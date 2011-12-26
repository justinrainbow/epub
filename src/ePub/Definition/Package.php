<?php

namespace ePub\Definition;

use ePub\Definition\ManifestItem;

class Package
{
    public $metadata;

    public $manifest;

    public $spine;

    public $guide;

    public function __construct()
    {
        $this->manifest = new Manifest();
        $this->metadata = new Metadata();
    }
}