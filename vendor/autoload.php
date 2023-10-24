<?php

function autoloader($className) {

    $baseDir = '../controllers/';
    $vendorDir = '../vendor/';

    $file = $baseDir . str_replace('\\', '/', $className) . '.php';
    $file_in_vendor = $vendorDir . str_replace('\\', '/', $className) . '.php';

    if (file_exists($file)) {
        include $file;
    }
    else if(file_exists($file_in_vendor)) {
        include $file_in_vendor;
    }
}

spl_autoload_register('autoloader');