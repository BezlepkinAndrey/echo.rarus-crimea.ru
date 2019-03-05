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

    $query = "select * from users where (created_at >= '2018-11-23' and created_at <= '2018-12-12') or house = 'stark';";

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
    birthday timestamp,
    created_at timestamp
);';
    $allQuery[] = "INSERT INTO users (first_name, email, house, birthday, created_at) VALUES
  ('Sansa', 'sansa@winter.com', 'stark', '1999-10-23', '2018-11-03'),
  ('Jon', 'jon@winter.com', 'stark', '1999-10-07', '2018-10-23'),
  ('Daenerys', 'daenerys@drakaris.com', 'targarien',  '1999-10-23', '2018-12-23'),
  ('Arya', 'arya@winter.com', 'stark', '2003-03-29', '2018-11-18'),
  ('Robb', 'robb@winter.com', 'stark', '1999-11-23', '2018-11-10'),
  ('Brienne', 'brienne@tarth.com', 'ne pomnu', '2001-04-04', '2018-11-28'),
  ('Tirion', 'tirion@got.com', 'lannister', '1975-1-11', '2018-11-23');";
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

