<?php

declare(strict_types=1);


/*

Задача 4 Написать регулярное выражение определяющее является ли данная строчка валидным URL адресом.
В данной задаче правильным URL считаются адреса http и https, явное указание протокола также может отсутствовать.
Учитываются только адреса, состоящие из символов, т.е. IP адреса в качестве URL не присутствуют при проверке.
Допускаются поддомены, указание порта доступа через двоеточие, GET запросы с передачей параметров, доступ к
 подпапкам на домене, допускается наличие якоря через решетку. Однобуквенные домены считаются запрещенными.
Запрещены спецсимволы, например «-» в начале и конце имени домена. Запрещен символ «_» и пробел в имени домена.
При составлении регулярного выражения ориентируйтесь на список правильных и неправильных выражений заданных ниже.

Пример правильных выражений:
http://www.zcontest.ru
http://zcontest.ru
http://zcontest.com
https://zcontest.ru
https://sub.zcontest-ru.com:8080
http://zcontest.ru/dir%201/dir_2/program.ext?var1=x&var2=my%20value
zcon.com/index.html#bookmark

Пример неправильных выражений:
Just Text.
http://a.com
http://www.domain-.com


 */

function pregFunc(string $str)
{
    return (bool)preg_match('/^{[0-9a-f]{8}-([0-9a-f]{4}-){3}[0-9a-f]{12}}|([0-9a-f]{8}-([0-9a-f]{4}-){3}[0-9a-f]{12})$/i',
        $str);
}

function phpFunc(string $str)
{
    $strLength = strlen($str);
    if (!($strLength === 36 || $strLength === 38)) {
        return false;
    }

    $startPos = 0;
    $endPos = $strLength - 1;
    if ($strLength === 38) {
        if (!($str[0] === '{' && $str[$strLength - 1] === '}')) {
            return false;
        } else {
            $startPos = 1;
            $endPos = $endPos - 1;
        }
    }

    $str = mb_strtolower($str);

    $counterArray = [8, 4, 4, 4, 12];
    $counterArrayLastIndex = count($counterArray) - 1;
    $counterIndex = 0;

    $alph = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];

    for ($i = $startPos; $i <= $endPos; $i++) {
        $symbol = $str[$i];

        if ($counterArray[$counterIndex] === 0) {
            if ($counterIndex !== $counterArrayLastIndex) {
                if ($symbol !== '-') {
                    return false;
                } else {
                    $counterIndex++;
                }
            }
        } else {
            if (in_array($symbol, $alph)) {
                $counterArray[$counterIndex]--;
            } else {
                return false;
            }
        }
    }

    return true;
}

var_dump(pregFunc("{e02fa0e4-01ad-090A-c130-0d05a0008ba0}"));
var_dump(pregFunc("e02fd0e4-00fd-090A-ca30-0d00a0038ba0"));

var_dump(phpFunc("{e02fa0e4-01ad-090A-c130-0d05a0008ba0}"));
var_dump(phpFunc("e02fa0e4-01ad-090A-c130-0d05a0008ba0"));


var_dump(pregFunc("02fa0e4-01ad-090A-c130-0d05a0008ba0}"));
var_dump(pregFunc("e02fd0e400fd090Aca300d00a0038ba0"));

var_dump(phpFunc("02fa0e4-01ad-090A-c130-0d05a0008ba0}"));
var_dump(phpFunc("e02fd0e400fd090Aca300d00a0038ba0"));

