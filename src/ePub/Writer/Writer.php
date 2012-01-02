<?php

/*
 * This file is part of the ePub Reader package
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ePub\Writer;

use ePub\Definition\Package;
use ePub\Exception\DuplicateItemException;
use ePub\Exception\InvalidArgumentException;

class Writer
{
	private $package;
	
	public function __construct(Package $package)
	{
		$this->package = $package;
	}
	
	
}