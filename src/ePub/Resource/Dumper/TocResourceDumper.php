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

class TocResourceDumper
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
<!DOCTYPE ncx PUBLIC "-//NISO//DTD ncx 2005-1//EN" 
   "http://www.daisy.org/z3986/2005/ncx-2005-1.dtd">

<ncx xmlns="http://www.daisy.org/z3986/2005/ncx/" version="2005-1" />
EOT
		);

		$toc = $dom->lastChild;
		
		$head   = $this->createHeadElement($dom);
		$docTitle = $this->createDocTitleElement($dom);
		$navMap = $this->createNavMapElement($dom, $this->package);

		$toc->appendChild($head);
		$toc->appendChild($docTitle);
		$toc->appendChild($navMap);

		return $dom->saveXML();
	}
	
	private function createHeadElement(\DOMDocument $dom)
	{
		$head = $dom->createElement('head');
		
		$tags = array(
			'dtb:uid' => $this->package->metadata->getValue('identifier'),
			'dtb:depth' => 1,
			'dtb:totalPageCount' => 0,
			'dtb:maxPageNumber' => 0
		);
		
		foreach ($tags as $name => $value) {
			$meta = $dom->createElement('meta');
			$meta->setAttribute('name', $name);
			$meta->setAttribute('content', $value);
			
			$head->appendChild($meta);
		}
		
		return $head;
	}
	
	private function createDocTitleElement(\DOMDocument $dom)
	{
		$docTitle = $dom->createElement('docTitle');
		$text = $dom->createElement('text', $this->package->metadata->getValue('title'));
		
		$docTitle->appendChild($text);
		
		return $docTitle;
	}

	private function createNavMapElement(\DOMDocument $document, Package $package)
	{
		$node = $document->createElement('navMap');
		
		$index = 1;

		foreach ($package->manifest->all() as $item) {
			if ($item->type !== 'application/xhtml+xml') {
				continue;
			}
			
			$child = $this->createNavPoint($document, $item, $index);
			
			$index++;

			$node->appendChild($child);
		}


		return $node;
	}
	
	private function createNavPoint(\DOMDocument $document, ManifestItem $item, &$index)
	{
		$child = $document->createElement('navPoint');
		$child->setAttribute('id', sprintf('navpoint-%d', $index));
		$child->setAttribute('playOrder', $index);
		
		
		$dom = new \DOMDocument('1.0');
		@$dom->loadHTML($item->getContent());
		
		$title = $dom->getElementsByTagName('title')->item(0);
		if (!$title) {
			$title = basename($item->href, '.html');
		} else {
			$title = $title->nodeValue;
		}
			
		$label = $document->createElement('navLabel');
		$text  = $document->createElement('text', $title);
		$label->appendChild($text);
		$child->appendChild($label);
			
		$content = $document->createElement('content');
		$content->setAttribute('src', $item->href);
		$child->appendChild($content);
		
		
		$xpath = new \DOMXPath($dom);
		
		$headers = $xpath->query('//h3/a[@id]');
			
		$createNavPoint = function ($id, $class, $title, $src, $playOrder) use ($document) {
			$child = $document->createElement('navPoint');
			$child->setAttribute('id', $id);
			$child->setAttribute('class', $class);
			$child->setAttribute('playOrder', $playOrder);
			
			$label = $document->createElement('navLabel');
			$text  = $document->createElement('text', $title);
			$label->appendChild($text);
			$child->appendChild($label);
			
			$content = $document->createElement('content');
			$content->setAttribute('src', $src);
			$child->appendChild($content);
			
			return $child;
		};
		
		if ($headers) {
			foreach ($headers as $node) {
				$ref = $node->getAttribute('id');
				$title = $node->nextSibling->nodeValue;
				
				$child->appendChild(
					$createNavPoint(
						str_replace('.', '_', $ref),
						'h2',
						$title,
						sprintf('%s#%s', $item->href, $ref),
						++$index
					)
				);
			}
		}
		
		return $child;
	}
}
