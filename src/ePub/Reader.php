<?php

/*
 * This file is part of the ePub Reader package
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ePub;

use ePub\Loader\ZipFileLoader;

class Reader
{
	private $loader;

	public function __construct()
	{
		$this->loader = new ZipFileLoader();
	}

	public function load($file)
	{
		return $this->loader->load($file);
	}
}