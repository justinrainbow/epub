<?php

namespace ePub\Loader;

use ePub\Resource\ZipFileResource;
use ePub\Definition\Manifest;
use ePub\Definition\ManifestItem;
use ePub\Definition\Metadata;

class ZipFileLoader
{
    private $metadata;

    public function load($file)
    {
        $this->metadata = new Metadata();

        $resource = new ZipFileResource($file);

        $package = $resource->getXML('META-INF/container.xml');

        $opfFile = (string) $package->rootfiles->rootfile['full-path'];

        $opf = $resource->getXML($opfFile);

        $this->loadMetadata($opf->metadata);
        $this->loadManifest($opf->manifest, $resource);

        return $this->metadata;
    }

    private function loadMetadata(\SimpleXmlElement $xml)
    {
        $namespaces = $xml->getDocNamespaces(true);
        foreach ($namespaces AS $prefix => $namespace) {
            foreach ($xml->children($namespace) as $tag) {
                $name = $tag->getName();

                if ($name === 'title') {
                    $this->metadata->title = (string) $tag;
                } else if ($name === 'identifier') {
                    $this->metadata->identifier = (string) $tag;
                } else if ($name === 'publisher') {
                    $this->metadata->publisher = (string) $tag;
                }
            }
        }
    }

    private function loadManifest(\SimpleXmlElement $xml, ZipFileResource $resource)
    {
        foreach ($xml->item as $child) {
            $item = new ManifestItem();

            $item->id       = (string) $child['id'];
            $item->href     = (string) $child['href'];
            $item->type     = (string) $child['media-type'];
            $item->fallback = (string) $child['fallback'];

            $this->metadata->manifest->add($item);
        }
    }
}