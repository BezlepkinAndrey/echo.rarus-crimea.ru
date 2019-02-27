<?php

function getIn($data, $keys)
{
    if (empty($keys)) {
        return $data;
    }

    if (!is_array($data)) {
        return null;
    }

    $key = array_shift($keys);
    if (array_key_exists($key, $data)) {

        return getIn($data[$key], $keys);

    } else {

        return null;

    }


}

$data = [
    'user'  => 'ubuntu',
    'hosts' => [
        ['name' => 'web1'],
        ['name' => 'web2']
    ]
];

echo 'd';
print_r(getIn($data, ['undefined']));        // => null
print_r(getIn($data, ['user']));             // => 'ubuntu'
print_r(getIn($data, ['user', 'ubuntu']));   // => null
print_r(getIn($data, ['hosts', 1, 'name'])); // => 'web2'
print_r(getIn($data, ['hosts', 0]));         // => ['name' => 'web1']