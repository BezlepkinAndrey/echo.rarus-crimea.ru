<?php

declare(strict_types=1);

function pregFunc(string $str)
{

    return (bool)preg_match('/^((?=[0-9A-Za-z_]*\d)(?=[0-9A-Za-z_]*[a-z])(?=[0-9A-Za-z_]*[A-Z])[0-9A-Za-z_]{8,})$/',
        $str);
}


var_dump(pregFunc("C00l_Pass"));
var_dump(pregFunc("SupperPas1"));
var_dump(pregFunc("Cool_pass"));
var_dump(pregFunc("C00l"));
