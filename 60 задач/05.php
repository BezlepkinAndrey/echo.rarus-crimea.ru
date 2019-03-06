<?php

function roots($a, $b, $c)
{
    $D = $b * $b - 4 * $a * $c;
    if ($D < 0) {
        return false;
    }
    return [(-$b + sqrt($D) / 2 * $a), (-$b - sqrt($D) / 2 * $a)];
}


print_r(roots(21, -4, 0));
print_r(roots(21, 56, 1));
print_r(roots(21, -4, 1));