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

    $allQuery = "SELECT COUNT(*) as count FROM (SELECT birthday as birthdayYaer FROM users WHERE `birthday` is NOT null) as years GROUP BY year(birthdayYaer) ORDER BY COUNT";

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

