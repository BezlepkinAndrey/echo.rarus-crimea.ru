<?php

function swap(&$firstNum, &$secondNum)
{
    $temp = $firstNum;
    $firstNum = $secondNum;
    $secondNum = $temp;
}

$a = 5;
$b = 8;
swap($a, $b);

print_r($a); // 8
print_r($b); // 5