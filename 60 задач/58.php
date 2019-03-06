<?php

function rrmdir($dir)
{
    $arr = scandir($dir);
    if ($arr) {
        foreach ($arr as $obj) {
            if ($obj == '.' || $obj == '..') {
                continue;
            }
            $path = $dir . '/' . $obj;
            is_dir($path) ? rrmdir($path) : unlink($path);
        }
    }
    rmdir($dir);
}


print_r(rrmdir('testdir'));