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

function getQuerys()
{

    $allQuery = [];
    $allQuery[] = "DELETE FROM users WHERE first_name = 'Sansa';";
    $allQuery[] = "INSERT INTO users (first_name, email) VALUES ('Arya', 'arya@winter.com');";
    $allQuery[] = "UPDATE users SET manager=TRUE WHERE email='tirion@got.com';";

    return $allQuery;
}


function runQuerys(mysqli $mysqli, $querys)
{
    try {
        $mysqli->begin_transaction();

        foreach ($querys as $query) {
            SQLQuery($mysqli, $query);
        }

        $mysqli->commit();

    } catch (Exception $e) {

        $mysqli->rollback();
        throw $e;

    }

    return true;
}

$mysqli = getMySQLIObj();
$querys = getQuerys();
runQuerys($mysqli, $querys);


