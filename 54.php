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

    $query = "SELECT COUNT(*) as count, year(birthdayYaer) as year FROM (SELECT birthday as birthdayYaer FROM users WHERE `birthday` is NOT null) as years GROUP BY year(birthdayYaer) ORDER BY year";

    return $query;
}


function runQuery(mysqli $mysqli, $query)
{
    $result = null;
    try {


        $res = SQLQuery($mysqli, $query);
        for (; $row = $res->fetch_assoc(); $result[] = $row) {
            ;
        }

    } catch (Exception $e) {

        throw $e;

    }

    return $result;
}


function getInitQuerys()
{

    $allQuery = [];

    $allQuery[] = 'DROP TABLE IF EXISTS users;';
    $allQuery[] = 'CREATE TABLE users (
  id bigint PRIMARY KEY,
  birthday DATE,
  email VARCHAR(255) UNIQUE NOT NULL,
  first_name VARCHAR(50),
  created_at timestamp
);';

    $allQuery[] = "INSERT INTO users (id, first_name, email, birthday) VALUES
  (1, 'Sansa', 'sansa@winter.com', '1999-10-23'),
  (2, 'Jon', 'jon@winter.com', null),
  (3, 'Daenerys', 'daenerys@drakaris.com', '1999-10-23'),
  (4, 'Arya', 'arya@winter.com', '2003-03-29'),
  (5, 'Robb', 'robb@winter.com', '1999-11-23'),
  (6, 'Brienne', 'brienne@tarth.com', '2001-04-04'),
  (7, 'Tirion', 'tirion@got.com', '1975-1-11');";
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

$query = getQuery();
$result = runQuery($mysqli, $query);

print_r($result);

