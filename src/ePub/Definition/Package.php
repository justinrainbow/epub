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