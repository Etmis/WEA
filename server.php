<?php
session_start();

require_once ('lib/Rcon.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'WEA');
if ($mysqli->connect_error) {
    die("Error connecting to database: " . $mysqli->connect_error);
}

$serverId = isset($_GET['serverId']) ? $_GET['serverId'] : null;
if (!$serverId) {
    echo "Server ID not provided.";
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT * FROM `server` WHERE `id` = ? AND `fk_user_id` = ?");
$stmt->bind_param('ii', $serverId, $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "Unauthorized access or server not found.";
    exit();
}

$server = $result->fetch_assoc();
$stmt->close();
$mysqli->close();

$host = $server['ip'];
$port = $server['port'];
$password = $server['password'];
$timeout = 3;

$rcon = new Thedudeguy\Rcon($host, $port, $password, $timeout);

if (!$rcon->connect()) {
    $_SESSION['errorMessage'] = "An error occurred while trying to connect to the server";
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $command = $_POST['command'];
        $rcon->sendCommand($command);
    } catch (Exception) {
        $_SESSION['errorMessage'] = "An error occurred while trying to connect to the server";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server RCON</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Server Management</h1>
        <p>Connected to server: <?php echo htmlspecialchars($server['name']); ?>
            (<?php echo htmlspecialchars($server['ip']); ?>:<?php echo htmlspecialchars($server['port']); ?>)</p>
        <form action="" method="post">
            <input type="text" name="command" placeholder="Enter command" required>
            <input type="submit" class="button" value="Send Command">
        </form>
    </div>
</body>

</html>