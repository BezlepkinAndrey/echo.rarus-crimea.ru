<?php

function wordsCount($str)
{
    $words = array_filter(preg_split('/([a-zA-Zа-яА-Я]{1,}(-|—)[a-zA-Zа-яА-Я]{1,})|(\W|_)/', $str), function ($item) {
        return !empty($item);
    });
    return array_count_values($words);
}

print_r(wordsCount('')); // []
print_r(wordsCount('  one two one')); // ['one' => 2, 'two' => 1]
print_r(wordsCount('  one      two       one     ')); // ['one' => 2, 'two' => 1]