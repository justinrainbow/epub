<?php

namespace ePub;

use ePub\Metadata;
use ePub\Manifest\ManifestItem;

class Manifest
{
	private $items;

	public function __construct()
	{
		$this->items = array();
	}

	public function add(ManifestItem $item)
	{
		if (isset($this->items[$item->id])) {
			throw new \RuntimeException(sprintf('Attempting to add a duplicate ManifestItem "%s"', $item->id));
		}

		$this->items[$item->id] = $item;
	}
}