<?php

function sayPrimeOrNot($arg)
{
    for ($i = 2; $i <= sqrt($arg); $i++) {
        if ($arg % $i == 0) {
            return false;
        }
    }
    return true;
}

$option = getopt('n:');
if (!$option) {
    print_r('set number (-n)');
}
$answer = (sayPrimeOrNot($option['n'])) ? 'yes' : 'no';

print_r($answer);