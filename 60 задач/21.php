<?php

function getComposerFileData($filePath)
{
    $json = file_get_contents($filePath);

    return json_decode($json, true);
}


print_r(getComposerFileData(__DIR__ . '/composer.json'));