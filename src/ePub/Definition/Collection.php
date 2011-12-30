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

abstract class Collection
{
    protected $items;

    public function __construct()
    {
        $this->items = array();
    }

    public function add(ManifestItem $item)
    {
        if (isset($this->items[$item->id])) {
            throw new \RuntimeException(sprintf('Attempting to add a duplicate ManifestItem "%s"', $item->id));
        }

        $this->items[$item->id] = $item;
    }

    public function get($id)
    {
        return $this->items[$id];
    }

    public function keys()
    {
        return array_keys($this->items);
    }

    public function all()
    {
        return $this->items;
    }
}