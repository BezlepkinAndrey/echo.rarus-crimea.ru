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
    $allQuery[] = "create table users (id int primary key auto_increment, username varchar (255) unique not null, email varchar (255) not null , created_at timestamp not null )";
    $allQuery[] = "create table topics (id int primary key auto_increment, user_id int references users(id), body text not null , created_at timestamp not null )";

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


