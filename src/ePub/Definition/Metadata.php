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

class Metadata
{
    private $data = array();

    private $attrs = array();

    public function has($name)
    {
        return array_key_exists($name, $this->data);
    }

    public function get($name)
    {
        return $this->data[$name];
    }

    public function set($name, $value, $attrs = null)
    {
        $this->attrs[$name] = $attrs;
        $this->data[$name] = $value;
    }
}