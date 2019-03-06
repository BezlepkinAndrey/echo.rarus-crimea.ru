<?php

function buildDefinitionList($arr)
{
    return '<dl>'.implode(array_map(function ($arr_str) {
        return '<dt>' . $arr_str[0] . '</dt><dd>' . $arr_str[1] . '</dd>';
    }, $arr)). '</dl>';
}

$definitions = [
    ['Блямба', 'Выпуклость, утолщения на поверхности чего-либо'],
    ['Бобр', 'Животное из отряда грызунов'],
];

print_r(buildDefinitionList($definitions));