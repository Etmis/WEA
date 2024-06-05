<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'WEA');
if ($mysqli->connect_error) {
    die("Error connecting to database: " . $mysqli->connect_error);
}

$serverId = $_GET['serverId'];
$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("DELETE FROM `server` WHERE `id` = ? AND `fk_user_id` = ?");
$stmt->bind_param('ii', $serverId, $user_id);
$stmt->execute();

$stmt->close();
$mysqli->close();

header("location: index.php");
exit();
