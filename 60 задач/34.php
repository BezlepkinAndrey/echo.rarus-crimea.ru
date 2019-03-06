<?php

function takeOldest($users, $count = 1)
{
    uasort($users, function ($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return (strtotime($a['birthday']) < strtotime($b['birthday'])) ? -1 : 1;
    });

    $result = [];
    $counter = $count;
    foreach ($users as $user) {
        if ($counter == 0) {
            break;
        }
        $result[] = $user;
        $counter--;
    }

    return $result;
}

$users = [
    ['name' => 'Tirion', 'birthday' => '1988-11-19'],
    ['name' => 'Sam', 'birthday' => '1999-11-22'],
    ['name' => 'Rob', 'birthday' => '1975-01-11'],
    ['name' => 'Sansa', 'birthday' => '2001-03-20'],
    ['name' => 'Tisha', 'birthday' => '1992-02-27']
];

print_r(takeOldest($users, 3));
# => Array (
#   ['name' => 'Rob', 'birthday' => '1975-01-11']
# )


