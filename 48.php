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

    $allQuery[] = 'ALTER TABLE users DROP COLUMN  age;';
    $allQuery[] = 'ALTER TABLE users ADD COLUMN  created_at timestamp;';
    $allQuery[] = 'ALTER TABLE users CHANGE COLUMN name first_name varchar(255) NOT NULL;';
    $allQuery[] = ' ALTER TABLE users ADD UNIQUE (email);';
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

function createTableUsers(mysqli $mysqli)
{
    @$mysqli->query("DROP TABLE IF EXISTS users CASCADE; CREATE TABLE users (id bigint PRIMARY KEY AUTO_INCREMENT, email varchar(255) NOT NULL,  age integer,name varchar(255));INSERT INTO users (email, age, name) VALUES ('noc@mail.com', 44, 'mike');") or die();
    return true;
}


$mysqli = getMySQLIObj();
createTableUsers($mysqli);
$querys = getQuerys();
runQuerys($mysqli, $querys);


