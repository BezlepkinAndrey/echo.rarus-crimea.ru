<?php

function bubbleSort($arr)
{
    for ($i = count($arr) - 1; $i > 0; $i--) {
        for ($j = 0; $j < $i; $j++) {
            if ($arr[$i] < $arr[$j]) {
                $temp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    }
    return $arr;
}

print_r(bubbleSort([])); // => []
print_r(bubbleSort([3, 10, 4, 3])); // => [3, 3, 4, 10]