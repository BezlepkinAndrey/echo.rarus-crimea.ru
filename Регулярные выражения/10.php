<?php

declare(strict_types=1);

function pregFunc(string $str)
{
    return (bool)preg_match('/^[1-9][0-9]{5}$/',
        $str);
}

function phpFunc(string $str)
{
    $options = array(
        'options' => array(
            'min_range' => 100000,
            'max_range' => 999999
        )
    );
    return (bool)filter_var($str, FILTER_VALIDATE_INT, $options);

}

var_dump(pregFunc("123456"));
var_dump(pregFunc("234567"));
var_dump(pregFunc("1234567"));
var_dump(pregFunc("12345"));
var_dump(pregFunc("012345"));


var_dump(phpFunc("123456"));
var_dump(phpFunc("234567"));
var_dump(phpFunc("1234567"));
var_dump(phpFunc("12345"));
var_dump(phpFunc("012345"));
