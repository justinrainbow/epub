<?php

require_once __DIR__.'/vendor/autoload.php';

if (class_exists('PHPUnit_Util_Configuration', false)) {
    spl_autoload_register(function ($class) {
        if (0 === strpos($class, 'ePub\\Tests')) {
            require_once __DIR__.'/tests/'.str_replace('\\', '/', $class).'.php';
        }
    });
}
