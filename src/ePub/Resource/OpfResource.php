<?php

/*
 * This file is part of the ePub Reader package
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ePub\Resource;

use SimpleXMLElement;
use ePub\NamespaceRegistry;
use ePub\Definition\Package;
use ePub\Definition\Metadata;
use ePub\Definition\Manifest;
use ePub\Definition\ManifestItem;

class OpfResource
{
    protected $metadataTags = array(
        'require' => array(
            'dc' => array('title', 'identifier', 'language'),
        ),

        'optional' => array(
            'dc' => array(
                'creator', 'description', 'contributor', 'publisher',
                'subject', 'date', 'type', 'format', 'soure',
                'relation', 'coverage', 'rights'
            )
        )
    );

    private $xml;

    private $namespaces;

    public function __construct($data, ZipFileResource $resource = null)
    {
        if ($data instanceof SimpleXMLElement) {
            $this->xml = $data;
        } else if (is_string($data)) {
            $this->xml = simplexml_load_string($data);
        } else {
            throw new \RuntimeException(sprintf('Invalid data type for OpfResource'));
        }

        $this->resource = $resource;

        $this->namespaces = $this->xml->getNamespaces(true);
    }

    public function bind(Package $package = null)
    {
        $package = $package ?: new Package();

        $this->bindMetadata($this->xml->metadata, $package->metadata);
        $this->bindManifest($this->xml->manifest, $package->manifest);

        return $package;
    }

    private function bindMetadata(\SimpleXMLElement $xml, Metadata $metadata)
    {
        foreach ($xml->children(NamespaceRegistry::NAMESPACE_DC) as $child) {
            $name = $child->getName();

            $item  = trim((string) $child);
            $attrs = $this->getXmlAttributes($child);

            $metadata->set($name, $item, $attrs);
        }
    }

    private function bindManifest(\SimpleXmlElement $xml, Manifest $manifest)
    {
        foreach ($xml->item as $child) {
            $item = new ManifestItem();

            $item->id       = (string) $child['id'];
            $item->href     = (string) $child['href'];
            $item->type     = (string) $child['media-type'];
            $item->fallback = (string) $child['fallback'];

            if (null !== $this->resource) {
                $resource = $this->resource;

                $item->setContent(function () use ($item, $resource) {
                    return $resource->get($item->href);
                });
            }

            $manifest->add($item);
        }
    }

    private function getXmlAttributes($xml)
    {
        $attributes = array();
        foreach ($this->namespaces as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $attr => $value) {
                if ($prefix !== "") {
                    $attr = "{$prefix}:{$attr}";
                }

                $attributes[$attr] = $value;
            }
        }

        return array('value' => (string) $xml, 'attributes' => $attributes);
    }
}