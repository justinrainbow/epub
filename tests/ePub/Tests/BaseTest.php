<?php

/*
 * This file is part of the ePub Reader package
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ePub\Tests;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Locate a test fixture file
     *
     * @param string $name Partial path to fixture
     *
     * @return string
     */
    public function getFixturePath($name)
    {
        return __DIR__.'/fixtures/' . $name;
    }

    /**
     * Locates a fixture and returns the file contents
     *
     * @param string $name Partial path to fixture
     *
     * @return string
     */
    public function getFixture($name)
    {
        return file_get_contents($this->getFixturePath($name));
    }
}