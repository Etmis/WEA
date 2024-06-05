<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'WEA');
if ($mysqli->connect_error) {
    die("Error connecting to database: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$ip = $_POST['ip'];
$port = $_POST['port'];
$password = $_POST['password'];

$stmt = $mysqli->prepare("INSERT INTO `server` (`name`, `ip`, `port`, `password`, `fk_user_id`) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('ssssi', $name, $ip, $port, $password, $user_id);
$stmt->execute();

$stmt->close();
$mysqli->close();

$_SESSION['successMessage'] = "Server Added Successfully!";

header("Location: index.php");
exit();