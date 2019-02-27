<?php

function pick($arr, $keys)
{
    $result = [];
    foreach ($keys as $key) {

        if (array_key_exists($key, $arr)) {
            $result[$key] = $arr[$key];
        }

    }

    return $result;
}

$data = [
    'user'  => 'ubuntu',
    'cores' => 4,
    'os'    => 'linux'
];

print_r(pick($data, ['user']));       // → ['user' => 'ubuntu']
print_r(pick($data, ['user', 'os'])); // → ['user' => 'ubuntu', 'os' => 'linux']
print_r(pick($data, []));             // → []
print_r(pick($data, ['none']));       // → []