<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RCON</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<header>
    <label class="title">Minecraft Rcon</label>
    <a href="login.php" class="a">Login</a>
    <a href="register.php" class="a">Register</a>
    <a href="addserver.php" class="a">Add Server</a>
</header>
    

<?php



$servers = [];
$mysqli = new mysqli('localhost', 'root', '', 'WEA');
if ($mysqli->connect_error) {
    die("error");
}
$queryServers = $mysqli->query("SELECT * FROM `server`");
while ($server = $queryServers->fetch_assoc()) {
    $servers[] = new server($server["id"], $server["name"], $server["ip"], $server["port"], $server["password"]);
}
$mysqli->close();

if (count($servers) > 0 ) {
    echo "<div class='nigar'>Your saved Servers</div>
    <table>
        <tr>
          <th>Server Name</th>
          <th>IP address</address></th>
          <th>Actions</th>
        </tr>";
}

foreach ($servers as $server) {
    $serverId = $server->getId();
    echo "<tr>";
    echo "<td>" . $server->getName() . "</td>";
    echo "<td>" . $server->getIp() . ":" . $server->getPort() . "</td>";
    echo "<td><a href='server.php?serverId=$serverId' class='button'>CON</a> <a href='deleteserver.php?serverId=$serverId' class='button'>DEL</a></td>";
    echo "</tr>";
}
if (count($servers) > 0 ) {
    echo
    "</div>";
}

$mysqli->close();

class server {
    private string $id;
    private string $name;
    private string $ip;
    private string $port;
    private string $password;

    function __construct($id, $name, $ip, $port, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->ip = $ip;
        $this->port = $port;
        $this->password = $password;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getIp() {
        return $this->ip;
    }

    function getPort() {
        return $this->port;
    }

    function getPassword() {
        return $this->password;
    }
}

if (count($servers) > 0 ) {
    echo "</table>";
}
?>
</body>
</html>