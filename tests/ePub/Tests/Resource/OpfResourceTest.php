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

class OpfResourceTest extends BaseTest
{
	public function testLoadingValidOpenPackagingFormatFile()
	{
		$fixture = $this->getFixturePath('basic/OEPS/content.opf');

		$opf = new OpfResource(file_get_contents($fixture));

        $package = $opf->bind();

        $this->assertTrue($package->metadata->has('title'));
        $this->assertEquals('Epub Format Construction Guide', $package->metadata->get('title'));
	}

    public function testLoadingInvalidOpenPackagingFormatFile()
    {

    }
}