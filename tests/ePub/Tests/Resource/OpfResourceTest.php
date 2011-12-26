<?php

namespace ePub\Tests\Resource;

use ePub\Tests\BaseTest;
use ePub\Resource\OpfResource;

class OpfResourceTest extends BaseTest
{
	public function testBasicIntstantiation()
	{
		$fixture = $this->getFixturePath('basic/OEPS/content.opf');

		$opf = new OpfResource(file_get_contents($fixture));
	}
}