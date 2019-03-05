<?php

function dump($file, $structure)
{
    $str = serialize($structure);
    return file_put_contents($file, $str);
}

function load($file)
{

    $str = file_get_contents($file);
    if (!$str) {
        return false;
    }

    return unserialize($str);
}

class test60
{

    public $a = 4;
    public $b = '  asdads ';

    function d($q)
    {
        return true;
    }

    private $j = 3;
    protected $l = "ew";
}

class test60_2 extends test60
{

    public $e;
    private $j = 4;
}

$file = '60.txt';
$structure = [[3, 4], [2, 3], new test60(), new test60_2()];

dump($file, $structure);
$data = load($file);

var_dump($data == $structure);