<?php

function getIndexOfWarmestDay($arr)
{
    $arr_max = (array_map(function ($arr_str) {
        return max($arr_str);
    }, $arr));
    return array_search(max($arr_max), $arr_max);
}

$data = [
    [-5, 7, 1],
    [3, 2, 3],
    [-1, -1, 10],
];

echo getIndexOfWarmestDay($data); // 2