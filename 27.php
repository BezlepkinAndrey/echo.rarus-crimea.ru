<?php

function wordsCount($str)
{
    $words = preg_split('/\W/u', $str, -1, PREG_SPLIT_NO_EMPTY);
    return array_count_values($words);
}

print_r(wordsCount('')); // []
print_r(wordsCount('  one two one')); // ['one' => 2, 'two' => 1]
print_r(wordsCount('  one      two       one     ')); // ['one' => 2, 'two' => 1]