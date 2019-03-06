<?php

function getMySQLIObj()
{
    $dblocation = 'localhost';
    $dbuser = 'root';
    $dbpassword = '';
    $db = 'test';

    $mysqli = @ new mysqli($dblocation, $dbuser, $dbpassword, $db);

    if ($mysqli->connect_error) {
        throw new Exception('ERROR: '.$mysqli->connect_errno);
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

function createTableCourses($mysqli)
{
    $sql = $sql = 'CREATE TABLE IF NOT EXISTS courses (name varchar(255), body text);';
    return SQLQuery($mysqli, $sql);
}

function createTableUsers($mysqli)
{
    $sql = 'CREATE TABLE users (first_name varchar(255), email varchar(255),manager boolean);';
    return SQLQuery($mysqli, $sql);
}

function createTableCourse_members($mysqli)
{
    $sql = 'CREATE TABLE course_members (user_id integer, created_at timestamp);';
    return SQLQuery($mysqli, $sql);
}

$mysqli = getMySQLIObj();
createTableCourses($mysqli);
createTableUsers($mysqli);
createTableCourse_members($mysqli);


