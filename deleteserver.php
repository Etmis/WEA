<?php
session_start();

// Connect to database
$mysqli = new mysqli('localhost', 'root', '', 'WEA');
if ($mysqli->connect_error) {
    die("Error connecting to database: " . $mysqli->connect_error);
}

// Get server ID from URL parameter
$serverId = $_GET['serverId'];

// Prepare and execute delete query
$deleteQuery = $mysqli->prepare("DELETE FROM `server` WHERE `id` = ?");
$deleteQuery->bind_param('i', $serverId);
$deleteQuery->execute();
$mysqli->close();

$deleteQuery->close();
$mysqli->close();
header("location: index.php");
die();
