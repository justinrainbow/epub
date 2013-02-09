<?php

/*
 * This file is part of the ePub Reader package
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ePub\Definition;

use ePub\Definition\ManifestItem;

class Package
{
    public $version;
    
    public $metadata;

    public $manifest;

    public $spine;

    public $guide;
    
    public $navigation;

    public function __construct()
    {
        $this->manifest   = new Manifest();
        $this->metadata   = new Metadata();
        $this->spine      = new Spine();
        $this->guide      = new Guide();
        $this->navigation = new Navigation();
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function getManifest()
    {
        return $this->manifest;
    }

    public function getSpine()
    {
        return $this->spine;
    }

    public function getGuide()
    {
        return $this->guide;
    }
    
    public function getNavigation()
    {
        return $this->navigation;
    }
}