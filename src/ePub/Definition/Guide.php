<?php

/*
 * This file is part of the ePub Reader package
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ePub\Definition;

use ePub\Definition\Metadata;
use ePub\Definition\ManifestItem;

class Guide extends Collection
{
	public function add(GuideItem $item)
	{
		if (isset($this->items[$item->type])) {
			throw new \RuntimeException(sprintf(
				'Attempting to add a duplicate GuideItem with type: %s',
				json_encode($item->type)
			));
		}

		$this->items[$item->type] = $item;
	}
}