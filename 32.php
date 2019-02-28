<?php

function slugify($str)
{
    $str = strtolower($str);
    $words = array_filter(preg_split('/\s{1,}/', $str), function ($item) {
        return !empty($item);
    });
    return implode('-', $words);
}

echo slugify(''); // ''
echo ' ';
echo slugify('test'); // 'test'
echo ' ';
echo slugify('test me'); // 'test-me'
echo ' ';
echo slugify('La La la LA'); // 'la-la-la-la'
echo ' ';
echo slugify('O la      lu'); // 'o-la-lu'
echo ' ';
echo slugify(' yOu   '); // 'you'

