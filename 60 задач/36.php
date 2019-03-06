<?php

function getGirlFriends($users)
{
    $result = [];
    foreach ($users as $user) {
        $result = array_merge($result, array_filter($user["friends"], function ($item) {
            return $item['gender'] == 'female';
        }));
    }
    return $result;

}


$users = [
    [
        'name'    => 'Tirion',
        'friends' => [
            ['name' => 'Mira', 'gender' => 'female'],
            ['name' => 'Ramsey', 'gender' => 'male']
        ]
    ],
    ['name' => 'Bronn', 'friends' => []],
    [
        'name'    => 'Sam',
        'friends' => [
            ['name' => 'Aria', 'gender' => 'female'],
            ['name' => 'Keit', 'gender' => 'female']
        ]
    ],
    [
        'name'    => 'Rob',
        'friends' => [
            ['name' => 'Taywin', 'gender' => 'male']
        ]
    ],
];

print_r(getGirlFriends($users));