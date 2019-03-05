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

    $query = "select DISTINCT house from users order by house";

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
    first_name varchar(255),
    email varchar(255),
    house varchar(255),
    birthday timestamp
);';
    $allQuery[] = "INSERT INTO users (first_name, email, birthday, house) VALUES
  ('Sansa', 'sansa@winter.com', '1999-10-23', 'stark'),
  ('Jon', 'jon@winter.com', '1999-10-07', 'stark'),
  ('Daenerys', 'daenerys@drakaris.com', '1999-10-23', 'targarien'),
  ('Arya', 'arya@winter.com', '2003-03-29', 'stark'),
  ('Robb', 'robb@winter.com', '1999-11-23', 'stark'),
  ('Brienne', 'brienne@tarth.com', '2001-04-04', 'tart'),
  ('Tirion', 'tirion@got.com', '1975-1-11', 'lannister');";
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

runQuerys($mysqli, getInitQuerys());

$query = getQuery();
$result = runQuery($mysqli, $query);

print_r($result);

