<?php

namespace App\Arrays;

function get($arr, $index, $defaultValue = null)
{
    return (array_key_exists($index, $arr)) ? $arr[$index] : $defaultValue;
}