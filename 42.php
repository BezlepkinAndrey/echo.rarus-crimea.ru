<?php

function createTable()
{
    $sql = 'CREATE TABLE courses (name varchar(255), body text);';
    $sql .= 'CREATE TABLE users  (first_name varchar(255), email varchar(255),manager boolean);';
    $sql .= 'CREATE TABLE course_members (user_id integer, created_at timestamp);';
    return $sql;
}