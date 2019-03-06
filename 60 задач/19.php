<?php

function checkIfBalanced($str)
{
    $balance = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] == '(') {
            $balance++;

        } elseif ($str[$i] == ')') {
            $balance--;
        }
        if ($balance < 0) {
            return false;
        }
    }

    return ($balance == 0) ? true : false;
}

print_r(checkIfBalanced('(5 + 6) * (7 + 8)/(4 + 3)')); // => true
print_r(checkIfBalanced('(4 + 3))')); // => false