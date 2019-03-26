<?php

declare(strict_types=1);

function pregFunc(string $str)
{
    return (bool)preg_match('/^([0-9a-f]{2}[:-]){5}[0-9a-f]{2}$/i',
        $str);
}


var_dump(pregFunc("01:32:54:67:89:AB"));
var_dump(pregFunc("aE:dC:cA:56:76:54"));

var_dump(pregFunc("01:33:47:65:89:ab:cd"));
var_dump(pregFunc("01:23:45:67:89:Az"));





