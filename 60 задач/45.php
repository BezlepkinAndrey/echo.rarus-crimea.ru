<?php

/*function checkAvailability(mysqli $mysqli, $table, $key, $value)
{
    $stmt = $mysqli->prepare('select * from ? where ? = ?');
    $stmt->bind_param('ssss', $table, $key, $value);
    $res = $mysqli->query($stmt);
    return mysqli_num_rows($res);
}*/


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
    $allQuery[] = "insert into users (first_name, last_name) values ('Andrey', 'Kersanov')";
    $allQuery[] = "insert into users (first_name, last_name) values ('Vadim', 'Ermokin')";

    $allQuery[] = "insert into cars (user_first_name , brand, model) values ('Andrey', 'Nisan','Silvia')";
    $allQuery[] = "insert into cars (user_first_name , brand, model) values ('Andrey', 'Ford','Focus')";

    $allQuery[] = "insert into cars (user_first_name , brand , model) values ('Vadim', 'LADA','2110')";
    $allQuery[] = "insert into cars (user_first_name , brand, model) values ('Vadim', 'LADA','2109')";
    $allQuery[] = "insert into cars (user_first_name , brand, model) values ('Vadim', 'Reno','Duster')";

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

function createTableCars(mysqli $mysqli)
{
    @$mysqli->query("create table if not exists cars (user_first_name varchar(255), brand varchar(50), model varchar (50))") or die();
    return true;
}


$mysqli = getMySQLIObj();
createTableCars($mysqli);
$querys = getQuerys();
runQuerys($mysqli, $querys);


