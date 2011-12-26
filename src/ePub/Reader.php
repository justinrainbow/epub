<?php

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