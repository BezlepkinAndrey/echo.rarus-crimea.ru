<?php

declare(strict_types=1);

function pregFunc(string $str)
{
    return (bool)preg_match('/^#[0-9a-f]{6}$/i',
        $str);
}


var_dump(pregFunc("#FFFFFF"));
var_dump(pregFunc("#FF3421"));

var_dump(pregFunc("#00ff00"));
var_dump(pregFunc("232323"));

var_dump(pregFunc("f#fddee"));
var_dump(pregFunc("#fd2"));

var_dump(pregFunc("??????"));




