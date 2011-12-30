<?php

/*
 * This file is part of the ePub Reader package
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ePub\Loader;

use ePub\Resource\ZipFileResource;
use ePub\Resource\OpfResource;
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

        $data = $resource->get($opfFile);

        // all files referenced in the OPF are relative to it's directory
        if ('.' !== $dir = dirname($opfFile)) {
            $resource->setDirectory($dir);
        }

        $opfResource = new OpfResource($data, $resource);
        $package = $opfResource->bind();

        return $package;
    }
}