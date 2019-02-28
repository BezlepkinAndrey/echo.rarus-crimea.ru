<?php

$last = function ($str) {
    return ($str) ? $str[strlen($str) - 1] : null;
};

echo $last(''); // => null
echo $last('pow'); // => w
echo $last('kids'); // => s