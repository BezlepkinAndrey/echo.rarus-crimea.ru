<?php

function swap($arr, $index)
{
    if (key_exists($index, $arr) && key_exists($index - 1, $arr) && key_exists($index + 1, $arr)) {

        $temp = $arr[$index - 1];
        $arr[$index - 1] = $arr[$index + 1];
        $arr[$index + 1] = $temp;

    }
    return $arr;

}

$names = ['john', 'smith', 'karl'];

$result = swap($names, 1);
print_r($result); // => ['karl', 'smith', 'john']

$result = swap($names, 2);
print_r($result); // => ['john', 'smith', 'karl']