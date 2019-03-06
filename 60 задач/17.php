<?php

function countUniqChars($str)
{
    return count(($str) ? (array_unique(str_split($str))) : []);
}

$text1 = 'yyab';
print_r(countUniqChars($text1)); // => 3

$text2 = 'You know nothing Jon Snow';
print_r(countUniqChars($text2)); // => 13

$text3 = '';
print_r(countUniqChars($text3)); // => 0