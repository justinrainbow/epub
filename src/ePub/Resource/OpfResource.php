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
use ePub\Definition\Spine;
use ePub\Definition\Guide;
use ePub\Definition\GuideItem;


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
        $this->bindSpine($this->xml->spine, $package->spine, $package->manifest);

        if ($this->xml->guide) {
            $this->bindGuide($this->xml->guide, $package->guide);
        }

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

            $this->addContentGetter($item);

            $manifest->add($item);
        }
    }

    private function bindSpine(\SimpleXMLElement $xml, Spine $spine, Manifest $manifest)
    {
        foreach ($xml->itemref as $child) {
            $id = (string) $child['idref'];

            $spine->add($manifest->get($id));
        }
    }

    private function bindGuide(\SimpleXMLElement $xml, Guide $guide)
    {
        foreach ($xml->reference as $child) {
            $item = new GuideItem();

            $item->title = (string) $child['title'];
            $item->type  = (string) $child['type'];
            $item->href  = (string) $child['href'];

            $this->addContentGetter($item);

            $guide->add($item);
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

    private function addContentGetter($item)
    {
        if (null !== $this->resource) {
            $resource = $this->resource;

            $item->setContent(function () use ($item, $resource) {
                return $resource->get($item->href);
            });
        }
    }
}