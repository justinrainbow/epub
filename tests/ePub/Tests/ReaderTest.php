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
	public function testBasicIntstantiation()
	{
		$this->assertTrue(new Reader instanceof Reader);
	}
}