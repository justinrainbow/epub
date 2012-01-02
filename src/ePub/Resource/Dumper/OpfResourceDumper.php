<?php

/*
 * This file is part of the ePub Reader package
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ePub\Resource\Dumper;

use ePub\Definition\Guide;
use ePub\Definition\GuideItem;
use ePub\Definition\Metadata;
use ePub\Definition\Manifest;
use ePub\Definition\ManifestItem;
use ePub\Definition\Package;
use ePub\Definition\Spine;
use ePub\Exception\DuplicateItemException;
use ePub\Exception\InvalidArgumentException;
use ePub\Resource\OpfResource;
use ePub\NamespaceRegistry;

class OpfResourceDumper
{
	private $package;

	public function __construct(Package $package)
	{
		$this->package = $package;
	}

	public function dump(array $options = array())
	{
		$dom = new \DOMDocument('1.0');
		$dom->formatOutput = true;
		$dom->preserveWhiteSpace = false;
		$dom->loadXML(<<<EOT
<?xml version="1.0"?>
<package
 	unique-identifier="dcidid"
	xmlns="http://www.idpf.org/2007/opf"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:dcterms="http://purl.org/dc/terms/"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xmlns:opf="http://www.idpf.org/2007/opf"
	version="2.0" />
EOT
		);

		$package = $dom->firstChild;

		$metadata = $this->appendMetadataElement($dom, $this->package->metadata);
		$manifest = $this->appendManifestElement($dom, $this->package->manifest);
		$spine    = $this->appendSpineElement($dom, $this->package->spine);

		$package->appendChild($metadata);
		$package->appendChild($manifest);
		$package->appendChild($spine);

		return $dom->saveXML();
	}

	private function appendMetadataElement(\DOMDocument $document, Metadata $metadata)
	{
		$node = $document->createElement('metadata');

		foreach ($metadata->all() as $items) {
			foreach ($items as $item) {
				// $child = $document->createElementNS(NamespaceRegistry::NAMESPACE_DC, $item->name, $item->value);
				$child = $document->createElement(sprintf('%s:%s', NamespaceRegistry::PREFIX_DC, $item->name), $item->value);
				
				if ($item->name === 'identifier') {
					$child->setAttribute('id', 'dcidid');
				}

				foreach ($item->attributes as $attrName => $attrValue) {
					// if (false !== $pos = strpos($attrName, ':')) {
					// 	$nsPrefix = substr($attrName, 0, $pos);
					// 	$attrName = substr($attrName, $pos + 1);

					// 	$namespace = constant('ePub\NamespaceRegistry::NAMESPACE_' . strtoupper($nsPrefix));

					// 	$child->setAttributeNS($namespace, $attrName, $attrValue);
					// } else {
						$child->setAttribute($attrName, $attrValue);
					// }
				}

				$node->appendChild($child);
			}


		}

		return $node;
	}

	private function appendManifestElement(\DOMDocument $document, Manifest $manifest)
	{
		$node = $document->createElement('manifest');

		foreach ($manifest->all() as $item) {
			// $child = $document->createElementNS(NamespaceRegistry::NAMESPACE_DC, $item->name, $item->value);
			$child = $document->createElement('item');

			$child->setAttribute('id', $item->id);
			$child->setAttribute('href', $item->href);

			if ($item->type) {
				$child->setAttribute('media-type', $item->type);
			}

			if ($item->fallback) {
				$child->setAttribute('fallback', $item->fallback);
			}

			$node->appendChild($child);
		}

		return $node;
	}

	private function appendSpineElement(\DOMDocument $document, Spine $spine)
	{
		$node = $document->createElement('spine');
		$node->setAttribute('toc', 'ncx');

		foreach ($spine->all() as $item) {
			// $child = $document->createElementNS(NamespaceRegistry::NAMESPACE_DC, $item->name, $item->value);
			$child = $document->createElement('itemref');

			$child->setAttribute('idref', $item->id);

			$node->appendChild($child);
		}

		return $node;
	}

	private function appendGuideElement(\DOMDocument $document, Guide $guide)
	{
		$node = $document->createElement('guide');

		return $node;
	}
}