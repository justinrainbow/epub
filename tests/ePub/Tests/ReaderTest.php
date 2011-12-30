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

	public function testLoadingEpubFile()
	{
		$fixture = $this->getFixturePath('the_velveteen_rabbit.epub');

		$reader = new Reader();
		$epub = $reader->load($fixture);

		$dedication = $epub->manifest->get('dedication');
		$expected = file_get_contents($this->getFixturePath('the-velveteen-rabbit/' . $dedication->href));
		$this->assertEquals($expected, $dedication->getContent());
	}
}