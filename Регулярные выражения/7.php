<?php
declare(strict_types=1);

function pregFunc(string $str)
{
    return (bool)preg_match("/^[a-z0-9!#$%&'*+\/\=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/\=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/",
        $str);
}

function phpFunc(string $str)
{
    $emailSplitArr = explode('@', $str);
    $domaineSplitArr = explode('.', $str);

    if (count($domaineSplitArr) !== 2) {
        return false;
    }

    return (bool)filter_var($str, FILTER_VALIDATE_EMAIL);
}

var_dump(pregFunc("mail@mail.ru"));
var_dump(pregFunc("valid@megapochta.com"));
var_dump(pregFunc("aa@aa.info"));
var_dump(pregFunc("bug@@@com.ru"));
var_dump(pregFunc("@val.ru"));
var_dump(pregFunc("Just Text2"));
var_dump(pregFunc("val@val"));
var_dump(pregFunc("val@val.a.a.a.a"));
var_dump(pregFunc("12323123@111[]][]"));

echo '   ';
var_dump(phpFunc("mail@mail.ru"));
var_dump(phpFunc("valid@megapochta.com"));
var_dump(phpFunc("aa@aa.info"));
var_dump(phpFunc("bug@@@com.ru"));
var_dump(phpFunc("@val.ru"));
var_dump(phpFunc("Just Text2"));
var_dump(phpFunc("val@val"));
var_dump(phpFunc("val@val.a.a.a.a"));
var_dump(phpFunc("12323123@111[]][]"));

