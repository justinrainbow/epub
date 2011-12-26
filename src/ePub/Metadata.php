<?php

namespace ePub;

use ePub\Manifest\ManifestItem;

class Metadata
{
    public $identifier;

    public $title;

    public $publisher;

    public $manifest;

    public function __construct()
    {
        $this->manifest = new Manifest();
    }
}