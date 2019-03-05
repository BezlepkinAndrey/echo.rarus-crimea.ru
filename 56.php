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

    $allQuery = "SELECT COUNT(*) as count FROM (SELECT birthday as birthdayYaer FROM users WHERE `birthday` is NOT null) as years GROUP BY year(birthdayYaer) ORDER BY COUNT";

    return $allQuery;
}


function runQuery(mysqli $mysqli, $query)
{
    $result = null;
    try {


        $result = mysqli_fetch_all(SQLQuery($mysqli, $query));


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

    return $res[0][0];
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

$mysqli = getMySQLIObj();
$firstId = getUserId($mysqli, 'Tirion');
$secondId = getUserId($mysqli, 'Jon');

createFriandship($mysqli, $firstId, $secondId);


