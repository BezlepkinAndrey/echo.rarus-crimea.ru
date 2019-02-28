<?php


function getMySQLIObj()
{
    $dblocation = 'localhost';
    $dbuser = 'root';
    $dbpassword = '';
    $db = 'test';

    $mysqli = @ new mysqli($dblocation, $dbuser, $dbpassword, $db);

    if ($mysqli->connect_error) {
        throw new Exception('ERROR: ' . $mysqli->connect_errno);
    }

    return $mysqli;
}

function SQLQuery($mysqli, $sql)
{
    $res = $mysqli->query($sql);
    if (!$res) {
        throw new Exception('SQL ERROR: ' . $mysqli->error);
    }
    return $res;
}

function getQuery()
{
    return "SELECT * FROM users WHERE birthday > DATE('1999-10-23') ORDER BY first_name LIMIT 3";
}

function getUsers(mysqli $mysqli)
{
    $res = SQLQuery($mysqli, getQuery());
    return $res->fetch_all();
}

$mysqli = getMySQLIObj();
print_r(getUsers($mysqli));
