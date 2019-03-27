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

    $date['year'] = $date[2];
    $date['month'] = $date[1];
    $date['day'] = $date[0];

    if (strlen($date['day']) != 2 || strlen($date['month']) != 2 || strlen($date['year']) != 4) {
        return false;
    }

    $options = array(
        'options' => array(
            'min_range' => 1600,
            'max_range' => 9999
        )
    );


    $date['year'] = ($date['year'][0] === '0') ? $date['year'][1] : $date['year'];
    $year = filter_var($date['year'], FILTER_VALIDATE_INT, $options);

    $date['month'] = ($date['month'][0] === '0') ? $date['month'][1] : $date['month'];
    $month = filter_var($date['month'], FILTER_VALIDATE_INT);

    $date['day'] = ($date['day'][0] === '0') ? $date['day'][1] : $date['day'];
    $day = filter_var($date['day'], FILTER_VALIDATE_INT);

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

