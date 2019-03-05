<?php

function cd($curentDir, $needDir)
{
    if (empty($curentDir)) {
        throw new Exception('ERROR: FIRST PATH IS INCORRECT');
    }

    if ($curentDir[0] != '/') {
        throw new Exception('ERROR: FIRST PATH IS INCORRECT');
    }

    if (empty($needDir)) {
        return $curentDir;
    }

    if ($needDir[0] == '/') {
        return $needDir;
    }

    $curentDir = preg_split('/\//', $curentDir, -1, PREG_SPLIT_NO_EMPTY);
    $needDir = preg_split('/\//', $needDir, -1, PREG_SPLIT_NO_EMPTY);

    foreach ($needDir as $dir) {
        if ($dir == '..') {
            array_pop($curentDir);
            if (empty($curentDir)) {
                throw new Exception('ERROR: SECOND PATH IS INCORRECT');
            }
            continue;
        }
        if ($dir == '.') {
            continue;
        }

        array_push($curentDir, $dir);
    }
    return '/' . implode($curentDir, '/');
}

echo cd('/current/path', '/etc'); // /etc
echo ' ';
echo cd('/current/path', '.././anotherpath'); // /current/anotherpath