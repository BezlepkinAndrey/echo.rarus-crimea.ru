<?php

function getManWithLessFriends($users)
{
    if (empty($users)) {
        return null;
    } else {

        $resultUser = array_pop($users);
        foreach ($users as $user) {
            if (count($user['friends']) <= count($resultUser['friends'])) {
                $resultUser = $user;
            }
        }
        return $resultUser;
    }
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
    ['name' => 'Keit', 'friends' => []],
    [
        'name'    => 'Rob',
        'friends' => [
            ['name' => 'Taywin', 'gender' => 'male']
        ]
    ],
];

print_r(getManWithLessFriends($users));
// => ['name' => 'Keit', 'friends' => []];