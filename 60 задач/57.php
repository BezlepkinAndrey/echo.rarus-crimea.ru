<?php

function cd($currentDir, $needDir)
{
    if (empty($currentDir)) {
        throw new Exception('ERROR: FIRST PATH IS INCORRECT');
    }

    if ($currentDir[0] != '/') {
        throw new Exception('ERROR: FIRST PATH IS INCORRECT');
    }

    if (empty($needDir)) {
        return $currentDir;
    }

    if ($needDir[0] == '/') {
        return $needDir;
    }

    $currentDir = preg_split('/\//', $currentDir, -1, PREG_SPLIT_NO_EMPTY);
    array_splice($currentDir, 0, 0, '/');

    $needDir = preg_split('/\//', $needDir, -1, PREG_SPLIT_NO_EMPTY);

    foreach ($needDir as $dir) {
        if ($dir == '..') {
            array_pop($currentDir);
            if (empty($currentDir)) {
                throw new Exception('ERROR: SECOND PATH IS INCORRECT');
            }
            continue;
        }
        if ($dir == '.') {
            continue;
        }

        array_push($currentDir, $dir);
    }
    array_shift($currentDir);
    return '/' . implode($currentDir, '/');
}

echo cd('/current/path', '/etc'); // /etc
echo ' ';
echo cd('/current/path', '.././anotherpath'); // /current/anotherpath
echo ' ';
echo cd('/current/path', '../../'); // /current
echo ' ';