<?php

function make()
{
    return [];
}

function set(&$map, $key, $value)
{
    $key = crc32($key);
    $result = true;
    if (key_exists($key, $map)) {
        $result = false;
    }

    $map[$key] = $value;
    return $result;
}

function get($map, $key, $default = null)
{
    $key = crc32($key);
    return (key_exists($key, $map)) ? $map[$key] : $default;
}


$map = make();
$result = get($map, 'key');
print_r($result); // => null

$result = get($map, 'key', 'value');
print_r($result); // => value

set($map, 'key2', 'value2');
$result = get($map, 'key2');
print_r($result); // => value2