<?php

namespace App\Arrays;

use function PHPSTORM_META\map;

function addPrefix($arr, $prefix)
{
    return array_map(function ($item) use ($prefix) {return $prefix.' '.$item;}, $arr);
}

