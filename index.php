<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RCON</title>
</head>
<body>

<?php
$servers = [];
$mysqli = new mysqli('localhost', 'root', '', 'WEA');
if ($mysqli->connect_error) {
    die("error");
}
$queryServers = $mysqli->query("SELECT `name`, `ip`, `port`, `password` FROM `server`");
while ($server = $queryServers->fetch_assoc()) {
    $servers[] = new server($server["name"], $server["ip"], $server["port"], $server["password"]);
}
foreach ($servers as $server) {
    echo "<div>";
    echo $server->getName();
    echo $server->getIp();
    echo "</div>";
}

class server {
    private string $name;
    private string $ip;
    private string $port;
    private string $password;

    function __construct($name, $ip, $port, $password) {
        $this->name = $name;
        $this->ip = $ip;
        $this->port = $port;
        $this->password = $password;
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
?>
</body>
</html>