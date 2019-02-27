<?php

function getIntersectionOfSortedArrayFirst($firstArr, $secondArr)
{
    return array_unique(array_intersect($firstArr, $secondArr));
}

print_r(getIntersectionOfSortedArrayFirst([10, 11, 24], [10, 13, 14, 18, 24, 30]));
// => [10, 24]


function getIntersectionOfSortedArraySecond($firstArr, $secondArr)
{
    $result = [];

    if (!empty($firstArr) || !empty($secondArr)) {

        $minArr = (count($firstArr) <= count($secondArr)) ? $firstArr : $secondArr;
        $maxArr = (count($firstArr) > count($secondArr)) ? $firstArr : $secondArr;
        $tempArr = [];

        for ($i = 0; $i < count($minArr); $i++) {
            for ($j = 0; $j < count($maxArr); $j++) {
                if ($minArr[$i] == $maxArr[$j]) {
                    $tempArr[$minArr[$i]] = 0;
                }
            }
        }

        foreach ($tempArr as $key => $value) {
            $result[] = $key;
        }
    }
    return $result;
}

print_r(getIntersectionOfSortedArraySecond([10, 11, 24], [10, 13, 14, 18, 24, 30]));
// => [10, 24]