<?php

function wordsCount($str)
{
    $str = mb_strtolower($str);
    $words = preg_split('/[^0-9A-Za-zА-Яа-яЁё]+/u', $str, -1, PREG_SPLIT_NO_EMPTY);
    return array_count_values($words);
}

$options = getopt('f:');
if (!$options) {
    print_r('set path (-f)');
    return;
}

if (!is_readable($options['f'])) {
    print_r('file is not readable');
    return;
}

$str = file_get_contents($options['f']);

print_r(wordsCount($str));


//   ?в чем проблема регулярного выражения? Оно делит строки не по словам а кусками(((





