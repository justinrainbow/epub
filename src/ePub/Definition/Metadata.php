<?php

namespace ePub\Definition;

use ePub\Definition\ManifestItem;

class Metadata
{
    public $identifier;

    public $title;

    public $publisher;

    public function has($name)
    {
        if (null === $this->{$name}) {
            return false;
        }

        return true;
    }
}