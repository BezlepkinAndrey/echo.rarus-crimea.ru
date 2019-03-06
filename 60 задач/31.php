<?php

function union()
{
    $result = [];
    foreach (func_get_args() as $arr) {
        $result = array_merge($arr, $result);
    }
    return array_values(array_unique($result));
}

print_r(union([3])); // => [3]
print_r(union([3, 2], [2, 2, 1])); // => [3, 2, 1]
print_r(union(['a', 3, false], [true, false, 3], [false, 5, 8])); // => ['a', 3, false, true, 5, 8]