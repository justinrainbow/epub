<?php

namespace ePub\Tests;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
	public function getFixturePath($name)
	{
		return __DIR__.'/fixtures/' . $name;
	}
}