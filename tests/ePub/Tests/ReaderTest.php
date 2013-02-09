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

use ePub\Tests\BaseTest;
use ePub\Reader;

class ReaderTest extends BaseTest
{
    public function testBasicInstantiation()
    {
        $this->assertTrue(new Reader instanceof Reader);
    }

    public function testLoadingEpubFile()
    {
        $epub = $this->getFixtureEpub('the_velveteen_rabbit.epub');
        
        $this->assertTrue($epub instanceof \ePub\Definition\Package);
    }

    public function testReadingManifestItemContent()
    {
        $epub = $this->getFixtureEpub('the_velveteen_rabbit.epub');

        $manifest   = $epub->getManifest();
        $dedication = $manifest->get('dedication');
        $expected   = $this->getFixture('the-velveteen-rabbit/' . $dedication->href);
        $this->assertEquals($expected, $dedication->getContent());
    }
    
    public function testReadingEpubVersion()
    {
        $epub = $this->getFixtureEpub('epub3_nested_nav.epub');
        $this->assertEquals('3.0', $epub->version);
        
        $epub = $this->getFixtureEpub('the_velveteen_rabbit.epub');
        $this->assertEquals('2.0', $epub->version);
    }
}