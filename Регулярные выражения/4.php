<?php

declare(strict_types=1);


function pregFunc(string $str)
{
    return (bool)preg_match('/^((http:|https:)\/\/)?[A-Za-z0-9][-A-Za-z0-9]*[A-Za-z0-9](\.[A-Za-z0-9][-A-Za-z0-9]*[A-Za-z0-9])*(:[0-9]+)?(\/([A-Za-z0-9._]|%20)+)*(\?([A-Za-z0-9]|%20)+=([A-Za-z0-9]|%20)+(&([A-Za-z0-9]|%20)+=([A-Za-z0-9]|%20)+)*)?(#[A-Za-z0-9]+)?$/',
        $str);
}

function phpFunc(string $str)
{

    $urlArr = parse_url($str);

    if (isset($urlArr['scheme'])) {
        if (!($urlArr['scheme'] === 'http' || $urlArr['scheme'] === 'https')) {
            return false;
        }
    } else {
        $urlArr['host'] = explode('/', $urlArr['path'])[0];
    }

    if (isset($urlArr['host'])) {

        $hostSplitArr = explode('.', $urlArr['host']);
        $hostSplitArrLength = count($hostSplitArr);
        if ($hostSplitArrLength > 3) {
            return false;
        } elseif ($hostSplitArrLength === 3) {
            if (strlen($hostSplitArr[1]) < 2) {
                return false;
            }
        } elseif (strlen($hostSplitArr[0]) < 2) {
            return false;
        }


        if (strlen($urlArr['host']) < 2) {
            return false;
        }

        if (filter_var($urlArr['host'], FILTER_VALIDATE_IP)) {
            return false;
        }

        if (substr_count($urlArr['host'], '.') > 2) {
            return false;
        }

        if (strpos($urlArr['host'], '.-') !== false) {
            return false;
        }

        if (strpos($urlArr['host'], '-.') !== false) {
            return false;
        }

        if (strpos($urlArr['host'], '-.') !== false) {
            return false;
        }

        if (strpos($urlArr['host'], ' ') !== false) {
            return false;
        }

        if (strpos($urlArr['host'], '_') !== false) {
            return false;
        }


    } else {

        return false;
    }

    return true;
}

var_dump(pregFunc("http://www.zcontest.ru"));
var_dump(pregFunc("http://zcontest.ru"));
var_dump(pregFunc("http://zcontest.com"));
var_dump(pregFunc("https://zcontest.ru"));
var_dump(pregFunc("https://sub.zcontest-ru.com:8080"));
var_dump(pregFunc("http://zcontest.ru/dir%201/dir_2/program.ext?var1=x&var2=my%20value"));
var_dump(pregFunc("zcon.com/index.html#bookmark"));
var_dump(pregFunc("http://a.com"));
var_dump(pregFunc("http://www.domain-.com"));
var_dump(pregFunc("Just Text."));
echo '   ';
var_dump(phpFunc("http://www.zcontest.ru"));
var_dump(phpFunc("http://zcontest.ru"));
var_dump(phpFunc("http://zcontest.com"));
var_dump(phpFunc("https://zcontest.ru"));
var_dump(phpFunc("https://sub.zcontest-ru.com:8080"));
var_dump(phpFunc("http://zcontest.ru/dir%201/dir_2/program.ext?var1=x&var2=my%20value"));
var_dump(phpFunc("zcon.com/index.html#bookmark"));
var_dump(phpFunc("Just Text."));
var_dump(phpFunc("http://a.com"));
var_dump(phpFunc("http://www.domain-.com"));