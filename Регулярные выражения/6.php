<?php

declare(strict_types=1);

function pregFunc(string $str)
{
    $pattern = '/^(?:(?:(?:(?:0[1-9]|1[0-9]|2[0-8])[\/](?:0[1-9]|1[012]))|(?:(?:29|30|31)[\/](?:0[13578]|1[02]))' .
        '|(?:(?:29|30)[\/](?:0[4,6,9]|11)))[\/](?:1[6-9]|[2-9][0-9])\d\d)|(?:29[\/]02[\/](?:1[6-9]|[2-9][0-9])' .
        '(?:00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96))$/u';

    return (bool)preg_match($pattern, $str);
}

function phpFunc(string $str)
{

    if (strlen($str) > 10) {
        return false;
    }

    $date = explode('/', $str);
    if (count($date) !== 3) {
        return false;
    }

    if (strlen($date[0]) != 2 || strlen($date[1]) != 2 || strlen($date[2]) != 4) {
        return false;
    }

    $options = array(
        'options' => array(
            'min_range' => 1600,
            'max_range' => 9999
        )
    );


    $date[2] = ($date[2][0] === '0') ? $date[2][1] : $date[2];
    $year = filter_var($date[2], FILTER_VALIDATE_INT, $options);

    $date[1] = ($date[1][0] === '0') ? $date[1][1] : $date[1];
    $month = filter_var($date[1], FILTER_VALIDATE_INT);

    $date[0] = ($date[0][0] === '0') ? $date[0][1] : $date[0];
    $day = filter_var($date[0], FILTER_VALIDATE_INT);

    if ($year === false || $month === false || $day === false) {
        return false;
    }

    if (checkdate($month, $day, $year)) {

        if ((int)$date[2] < 1600 || (int)$date[2] > 9999) {
            return false;
        } else {
            return true;
        }

    } else {
        return false;
    }
}

var_dump(pregFunc("29/02/2000"));
var_dump(pregFunc("30/04/2003"));
var_dump(pregFunc("01/01/2003"));
var_dump(pregFunc("29/02/2001"));
var_dump(pregFunc("30-04-2003"));
var_dump(pregFunc("1/1/1899"));

echo '    ';
var_dump(phpFunc("29/02/2000"));
var_dump(phpFunc("30/04/2003"));
var_dump(phpFunc("01/01/2003"));
var_dump(phpFunc("29/02/2001"));
var_dump(phpFunc("30-04-2003"));
var_dump(phpFunc("1/1/1899"));

