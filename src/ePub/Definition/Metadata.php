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

use ePub\Definition\MetadataItem;
use ePub\Exception\InvalidArgumentException;
use ePub\Exception\OutOfBoundsException;

class Metadata extends Collection
{
    public function add(ItemInterface $item)
    {
        if (!($item instanceof MetadataItem)) {
            throw new InvalidArgumentException(sprintf(
                'Expected instance of ePub\Definition\MetadataItem, got %s',
                get_class($item)
            ));
        }

        $id = $item->getIdentifier();

        if (!isset($this->items[$id])) {
            $this->items[$id] = array();
        }

        $this->items[$id][] = $item;
    }

    public function getValue($id)
    {
        $item = $this->get($id);

        if (isset($item[0]) && $item[0] instanceof MetadataItem) {
            return $item[0]->value;
        }

        throw new OutOfBoundsException(
            "No value could be found for item: " . json_encode($id)
        );
    }
}