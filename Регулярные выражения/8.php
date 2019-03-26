<?php

declare(strict_types=1);

function pregFunc(string $str)
{

    return (bool)preg_match('/^(25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[0-9]{2}|[0-9])(\.(25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[0-9]{2}|[0-9])){3}$/i',
        $str);
}

function phpFunc(string $str)
{
    return (bool) filter_var($str,FILTER_VALIDATE_IP);
}


var_dump(pregFunc("127.0.0.1"));
var_dump(pregFunc("255.255.255.0"));
var_dump(pregFunc("192.168.0.1"));
var_dump(pregFunc("1300.6.7.8"));
var_dump(pregFunc("abc.def.gha.bcd"));
var_dump(pregFunc("254.hzf.bar.10"));

var_dump(phpFunc("127.0.0.1"));
var_dump(phpFunc("255.255.255.0"));
var_dump(phpFunc("192.168.0.1"));
var_dump(phpFunc("1300.6.7.8"));
var_dump(phpFunc("abc.def.gha.bcd"));
var_dump(phpFunc("254.hzf.bar.10"));
