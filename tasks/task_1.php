<?php

function isPalindrome($str)
{
    for ($i = 0, $len = strlen($str), $j = $len - 1; $i < ($len / 2); $i++, $j--) {
        if ($str[$i] !== $str[$j]) {
            return false;
        }
    }
    return true;
}


echo isPalindrome('radar'); // true
echo isPalindrome('maam');  // true
echo isPalindrome('a');     // true
echo isPalindrome('abs');   // false