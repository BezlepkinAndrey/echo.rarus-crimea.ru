<?php


function getSameCount($firstArr, $secondArr)
{
    return count(array_unique(array_intersect($firstArr, $secondArr)));
}


echo getSameCount([], []); // => 0
echo getSameCount([1, 10, 3], [10, 100, 35, 1]); // => 2
echo getSameCount([1, 3, 2, 2], [3, 1, 1, 2]); // => 3