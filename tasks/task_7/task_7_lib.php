<?php

namespace App\Arrays;

use function PHPSTORM_META\map;

function addPrefix($arr, $prefix)
{
    return $arr.map(function ($item){return $prefix.$item;});
}