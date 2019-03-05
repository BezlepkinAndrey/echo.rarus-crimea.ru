<?php

function grep($str, $pattern)
{

    $pathArr = glob($pattern);
    $result = [];
    foreach ($pathArr as $path) {
        if (is_file($path)) {

            $file = @fopen($path, 'r');
            if (!$file) {
                continue;
            }

            while (($buffer = fgets($file)) !== false) {
                $pos = strpos($buffer, $str);
                if ($pos !== false) {
                    $result[] = $buffer;
                }
            }
        }
    }
    return $result;
}


print_r(grep('test', './*')); // 3