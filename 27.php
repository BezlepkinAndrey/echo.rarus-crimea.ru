<?php

function wordsCount($str)
{
    $words = array_filter(preg_split('/\s/', $str), function ($item) {
        return !empty($item);
    });
    $result = [];
    foreach ($words as $word) {
        if (key_exists($word, $result)) {
            $result[$word]++;

        } else {
            $result[$word] = 1;

        }
    }
    return $result;
}

print_r(wordsCount('')); // []
print_r(wordsCount('  one two one')); // ['one' => 2, 'two' => 1]
print_r(wordsCount('  one      two       one     ')); // ['one' => 2, 'two' => 1]