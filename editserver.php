<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serverId = $_POST['serverId'];
    $name = !empty($_POST['name']) ? $_POST['name'] : null;
    $ip = !empty($_POST['ip']) ? $_POST['ip'] : null;
    $port = !empty($_POST['port']) ? $_POST['port'] : null;
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    $mysqli = new mysqli('localhost', 'root', '', 'WEA');
    if ($mysqli->connect_error) {
        die("Error connecting to database: " . $mysqli->connect_error);
    }

    $query = "UPDATE `server` SET ";
    $params = [];
    $types = "";

    if ($name) {
        $query .= "`name` = ?, ";
        $params[] = $name;
        $types .= "s";
    }
    if ($ip) {
        $query .= "`ip` = ?, ";
        $params[] = $ip;
        $types .= "s";
    }
    if ($port) {
        $query .= "`port` = ?, ";
        $params[] = $port;
        $types .= "s";
    }
    if ($password) {
        $query .= "`password` = ?, ";
        $params[] = $password;
        $types .= "s";
    }

    $query = rtrim($query, ", ") . " WHERE `id` = ?";
    $params[] = $serverId;
    $types .= "i";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();

    $_SESSION['successMessage'] = "Server updated successfully!";
    header("Location: index.php");
    exit();
}
