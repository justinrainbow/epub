<?php

/*
 * This file is part of the ePub Reader package
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ePub\Tests\Resource;

use ePub\Tests\BaseTest;
use ePub\Resource\OpfResource;
use ePub\Definition\Metadata;
use ePub\Definition\Manifest;

class OpfResourceTest extends BaseTest
{
	public function testLoadingValidOpenPackagingFormatFile()
	{
		$fixture = $this->getFixture('basic/OEPS/content.opf');

		$opf = new OpfResource($fixture);

        $package = $opf->bind();

        $metadata = $package->getMetadata();
        $this->assertTrue($metadata instanceof Metadata);
        $this->assertTrue($metadata->has('title'));
        $this->assertEquals('Epub Format Construction Guide', $metadata->get('title'));

        $manifest = $package->getManifest();
        $this->assertTrue($manifest instanceof Manifest);
        $this->assertEquals(
            array("ncx", "css", "logo", "title", "contents", "intro", "part1", "part2", "part3", "part4", "specs"),
            $manifest->keys()
        );
	}
}