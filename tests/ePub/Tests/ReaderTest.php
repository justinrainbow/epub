<?php

namespace ePub\Tests;

use ePub\Tests\BaseTest;
use ePub\Reader;

class ReaderTest extends BaseTest
{
	public function testBasicIntstantiation()
	{
		$this->assertTrue(new Reader instanceof Reader);
	}
}