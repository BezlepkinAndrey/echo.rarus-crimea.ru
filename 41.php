<?php

function getDifference($firstArr, $secondArr)
{
    $result = [];
    foreach ($firstArr as $firstItem) {
        $is_found = false;
        foreach ($secondArr as $secondItem) {
            if ($firstItem == $secondItem) {
                $is_found = true;
                break;
            }
        }
        if (!$is_found) {
            $result[] = $firstItem;
        }
    }
    return $result;
}


print_r(getDifference([2, 1], [2, 3]));
// → [1]