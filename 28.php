<?php

function wordsCount($str)
{
    $words = array_filter(preg_split('/[^а-яА-Яa-zA-Z0-9]/', $str), function ($item) {
        return !empty($item);
    });
    return array_count_values($words);
}

$options = getopt('f:');
if(!$options)
{
    print_r('set path (-f)');
    return;
}

if(!is_readable($options['f'])){
    print_r('file is not readable');
    return;
}

$str = file_get_contents($options['f']);

print_r(wordsCount($str));


//   ?в чем проблема регулярного выражения? Оно делит строки не по словам а кусками(((





