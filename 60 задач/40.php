<?php

function without()
{
    $args = func_get_args();
    $arr = array_shift($args);
    return array_diff($arr, $args);

}


print_r(without([3, 4, 10, 4, 'true'], 4)); // => [3, 10, 'true']
print_r(without(['3', 2], 0, 5, 11)); // => ['3', 2]