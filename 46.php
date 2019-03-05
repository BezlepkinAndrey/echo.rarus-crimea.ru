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
    $allQuery[] = "insert into article_categories (name) values ('Andrey')";
    $allQuery[] = "insert into article_categories (name) values ('Vlad')";

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

function createTableArticle_categories(mysqli $mysqli)
{
    @$mysqli->query("create table if not exists article_categories  (id INT PRIMARY KEY AUTO_INCREMENT, name text)") or die();
    return true;
}


$mysqli = getMySQLIObj();
createTableArticle_categories($mysqli);
$querys = getQuerys();
runQuerys($mysqli, $querys);


