<?php

/**
 * Find the auto loader file
 */
$local = __DIR__.'/autoload.php';
if(is_file($local)) {
    require_once $local;
    return;
}

$pharPath = \Phar::running(true);
if ($pharPath && is_file("$pharPath/vendor/autoload.php")) {
    require_once "$pharPath/vendor/autoload.php";
} else {
    $depth = 5;
    for ($x = 0; $x <= $depth; $x++) {
        $prefix = str_repeat('../', $x);
        $autoload = __DIR__ . '/'.$prefix.'vendor/autoload.php';
        if (file_exists($autoload)) {
            require_once $autoload;
            return;
        }
    }

    throw new \RuntimeException('Could not resolve autoload file');
}




