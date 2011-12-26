<?php

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
	}

    public function testLoadingInvalidOpenPackagingFormatFile()
    {

    }
}