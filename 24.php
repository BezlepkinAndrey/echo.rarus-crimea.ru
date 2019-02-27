<?php

function genDiff($firstArr, $secondArr)
{

    $keys = array_unique(array_merge(array_keys($firstArr), array_keys($secondArr)));

    $result = [];
    foreach ($keys as $key) {

        if (key_exists($key, $firstArr)) {
            if (key_exists($key, $secondArr)) {
                if ($firstArr[$key] == $secondArr[$key]) {
                    $result[$key] = 'unchanged';

                } else {
                    $result[$key] = 'changed';

                }

            } else {
                $result[$key] = 'deleted';

            }
        } else {
            $result[$key] = 'added';

        }

    }

    return $result;
}

$result = genDiff(
    ['one' => 'eon', 'two' => 'two', 'four' => true],
    ['two' => 'own', 'zero' => 4, 'four' => true]
);
// => [
//     'one' => 'deleted',
//     'two' => 'changed'
//     'zero' => 'added',
//     'four' => 'unchanged',
// ];

print_r($result);