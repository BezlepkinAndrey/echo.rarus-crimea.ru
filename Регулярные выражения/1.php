<?php

declare(strict_types=1);

function pregFunc(string $str)
{
    return (bool) preg_match('/^abcdefdhsf\^dsdsвВВo\*18340$/', $str);
}

function phpFunc(string $str)
{
    return $str === 'abcdefdhsf^dsdsвВВo*18340';
}

var_dump(pregFunc("abcdefdhsf^dsdsвВВo*18340"));
var_dump(phpFunc("abcdefdhsf^dsdsвВВo*18340"));