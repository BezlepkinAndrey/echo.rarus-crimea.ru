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

function getUserId(mysqli $mysqli, $userName)
{
    $res = runQuery($mysqli, "select id from users where first_name = '" . $userName . "'");
    if (empty($res)) {
        return false;
    }

    return $res[0]['id'];
}

function createFriandship(mysqli $mysqli, $firstUserId, $secondUserId)
{
    if (!$firstUserId || !$secondUserId) {

        return false;
    }
    try {
        $mysqli->begin_transaction();


        $sql = "insert into friendship (user1_id, user2_id) value (?,?)";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('dd', $firstUserId, $secondUserId);
        $stmt->execute();

        if ($stmt->error) {
            throw new Exception("FAILURE!!! " . $stmt->error);
        }

        $stmt->close();
        $mysqli->commit();
    } catch (Exception $e) {
        $mysqli->rollback();

        throw $e;
    }

}


function getInitQuerys()
{

    $allQuery = [];

    $allQuery[] = 'DROP TABLE IF EXISTS friendship;';
    $allQuery[] = 'DROP TABLE IF EXISTS users;';

    $allQuery[] = 'CREATE TABLE users (
  id bigint PRIMARY KEY,
  first_name varchar(255),
  email varchar(255),
  birthday timestamp
);';

    $allQuery[] = "CREATE TABLE friendship (
  id bigint PRIMARY KEY AUTO_INCREMENT,
  user1_id bigint REFERENCES users(id),
  user2_id bigint REFERENCES users(id)
);";

    $allQuery[] = "INSERT INTO users (id, first_name, email, birthday) VALUES
  (1, 'Sansa', 'sansa@winter.com', '1999-10-23'),
  (2, 'Jon', 'jon@winter.com', '1999-10-07'),
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

runQuerys($mysqli, getInitQuerys());


$firstId = getUserId($mysqli, 'Tirion');
$secondId = getUserId($mysqli, 'Jon');

createFriandship($mysqli, $firstId, $secondId);


