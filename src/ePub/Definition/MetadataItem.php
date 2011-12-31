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

class MetadataItem implements ItemInterface
{
    public $name;

    public $value;

    public $attributes;

    public function getIdentifier()
    {
        return $this->name;
    }
}