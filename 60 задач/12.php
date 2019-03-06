<?php

function getSameParity($arr)
{
    if (empty($arr)) {
        return [];
    } else {
        return array_filter($arr, function ($item) use ($arr) {
            return ($arr[0] % 2) == ($item % 2);
        });
    }
}

print_r(getSameParity([]));        // => []
print_r(getSameParity([1, 2, 3])); // => [1, 3]
print_r(getSameParity([1, 2, 8])); // => [1]
print_r(getSameParity([2, 2, 8])); // => [2, 2, 8]