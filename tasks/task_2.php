<?php

function isPalindrome($str)
{
    return $str == strrev($str);
}


echo isPalindrome('radar'); // true
echo isPalindrome('maam');  // true
echo isPalindrome('a');     // true
echo isPalindrome('abs');   // false