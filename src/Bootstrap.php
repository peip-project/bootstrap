<?php

/*
 * This file is part of the PEIP project.
 * This file is part of the bootstrap package.
 *  (c) 2017 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PEIP;

/**
 * Class PEIP\Bootstrap.
 *
 */
class Bootstrap
{
    /**
     *
     */
    public static function run()
    {   $projectDir = dirname(__DIR__);
        $local = $projectDir.'/autoload.php';
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
                $autoload = $projectDir . '/'.$prefix.'vendor/autoload.php';
                if (file_exists($autoload)) {
                    require_once $autoload;
                    return;
                }
            }

            throw new \RuntimeException('Could not resolve autoload file');
        }
    }
}
