<?php

/*
 * This file is part of the ePub Reader package
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ePub\Resource;

use ZipArchive;

class ZipFileResource
{
	private $zipFile;

    private $cwd;

	public function __construct($file)
	{
		$this->zipFile = new \ZipArchive();

        $this->zipFile->open($file);
	}

    public function setDirectory($dir)
    {
        $this->cwd = $dir;
    }

    public function get($name)
    {
        if (null !== $this->cwd) {
            $name = $this->cwd . '/' . $name;
        }

        return $this->zipFile->getFromName($name);
    }

    public function getXML($name)
    {
        return simplexml_load_string($this->get($name));
    }

    public function all()
    {
        $result = array();

        for ($i = 0; $i < $this->zipFile->numFiles; $i++){
            $item = $this->zipFile->statIndex($i);

            $result[] = $item['name'];
        }

        return $result;
    }
}