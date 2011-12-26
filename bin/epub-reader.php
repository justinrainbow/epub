<?php

require_once __DIR__.'/../bootstrap.php';

use ePub\Reader;
use ePub\Loader\ZipFileLoader;

$epub = new Reader();
var_dump($epub->load($argv[1]));

