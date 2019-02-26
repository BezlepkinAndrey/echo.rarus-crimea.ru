<?php

function isContinuousSequence($arr)
{
    for ($i = 1; $i < count($arr); $i++) {
        if ($arr[$i] != ($arr[$i - 1] + 1)) {
            return false;
        }
    }
    return (bool) count($arr);
}

echo isContinuousSequence([10, 11, 12, 13]);     // => true
echo isContinuousSequence([10, 11, 12, 14, 15]); // => false
echo isContinuousSequence([1, 2, 2, 3]);         // => false
echo isContinuousSequence([]);                   // => false