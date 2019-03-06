<?php

function getChildren($users)
{
    $result = [];
    foreach ($users as $user) {
        $result = array_merge($result, $user["children"]);
    }
    return $result;

}

$users = [
    [
        'name'     => 'Tirion',
        'children' => [
            ['name' => 'Mira', 'birdhday' => '1983-03-23']
        ]
    ],
    ['name' => 'Bronn', 'children' => []],
    [
        'name'     => 'Sam',
        'children' => [
            ['name' => 'Aria', 'birdhday' => '2012-11-03'],
            ['name' => 'Keit', 'birdhday' => '1933-05-14']
        ]
    ],
    [
        'name'     => 'Rob',
        'children' => [
            ['name' => 'Tisha', 'birdhday' => '2012-11-03']
        ]
    ],
];

print_r(getChildren($users));
// [
//     ['name' => 'Mira', 'birdhday' => '1983-03-23'],
//     ['name' => 'Aria', 'birdhday' => '2012-11-03'],
//     ['name' => 'Keit', 'birdhday' => '1933-05-14'],
//     ['name' => 'Tisha', 'birdhday' => '2012-11-03']
// ]