<?php

function findIndex($arr, $finde_value)
{
    foreach ($arr as $key => $value) {
        if ($finde_value == $value) {
            return $key;
        }
    }
    return -1;
}


$temperatures = [37.5, 34, 39.3, 40, 38.7, 41.5, 40];

print_r(findIndex($temperatures, 34)); // => 1
print_r(findIndex($temperatures, 40)); // => 3
print_r(findIndex($temperatures, 3));  // => -1