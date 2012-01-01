<?php

/*
 * This file is part of the ePub Reader package
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ePub\Tests\Writer;

use ePub\Tests\BaseTest;
use ePub\Reader;
use ePub\Resource\Dumper\OpfResourceDumper;

class WriterTest extends BaseTest
{
    public function testLoadingEpubFile()
    {
        $fixture = $this->getFixturePath('the_velveteen_rabbit.epub');

        $reader = new Reader();
        $epub = $reader->load($fixture);

        $this->assertTrue($epub instanceof \ePub\Definition\Package);

        $dumper = new OpfResourceDumper($epub);
        echo $dumper->dump();
    }

    public function testReadingManifestItemContent()
    {
        $fixture = $this->getFixturePath('the_velveteen_rabbit.epub');

        $reader = new Reader();
        $epub   = $reader->load($fixture);

        $manifest   = $epub->getManifest();
        $dedication = $manifest->get('dedication');
        $expected   = $this->getFixture('the-velveteen-rabbit/' . $dedication->href);
        $this->assertEquals($expected, $dedication->getContent());
    }
}