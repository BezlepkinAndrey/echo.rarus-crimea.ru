<?php

function average()
{
    return (func_num_args()) ? array_sum(func_get_args()) / count(func_get_args()) : null;
}

echo average(0); // => 0
echo average(0, 10); // => 5
echo average(-3, 4, 2, 10); // => 3.25
echo average(); // => null
