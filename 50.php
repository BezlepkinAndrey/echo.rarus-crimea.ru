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

    $allQuery = "select * from users where (created_at >= '2018-11-23' and created_at <= '2018-12-12') or house = 'stark'";

    return $allQuery;
}


function runQuery(mysqli $mysqli, $query)
{
    $result = null;
    try {


        $result = mysqli_fetch_all(SQLQuery($mysqli, $query));


    } catch (Exception $e) {

        throw $e;

    }

    return $result;
}


$mysqli = getMySQLIObj();

$query = getQuery();
$result = runQuery($mysqli, $query);

print_r($result);
