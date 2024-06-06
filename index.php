<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RCON</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <header class="header">
    <label class="title">Minecraft Rcon</label>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="logout.php" class="button-58" role="button">Logout</a>
      <button href="addserver.php" class="button-58" role="button" data-toggle="modal" data-target="#addServerModal">Add
        Server</button>
    <?php else: ?>
      <a href="login.php" class="button-58" role="button">Login</a>
      <a href="register.php" class="button-58" role="button">Register</a>
    <?php endif; ?>
  </header>

  <div class="modal fade" id="addServerModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Fill the Form</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <form action="addserver.php" method="POST">
            <div class="form-group">
              <label for="name">Server Name:</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
              <label for="ip">IP Address:</label>
              <input type="text" class="form-control" id="ip" name="ip" required>
            </div>
            <div class="form-group">
              <label for="port">Port:</label>
              <input type="text" class="form-control" id="port" name="port" required>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </form>
        </div>

      </div>
    </div>
  </div>

  <?php
  class Server
  {
    private string $id;
    private string $name;
    private string $ip;
    private string $port;
    private string $password;

    function __construct($id, $name, $ip, $port, $password)
    {
      $this->id = $id;
      $this->name = $name;
      $this->ip = $ip;
      $this->port = $port;
      $this->password = $password;
    }

    function getId()
    {
      return $this->id;
    }

    function getName()
    {
      return $this->name;
    }

    function getIp()
    {
      return $this->ip;
    }

    function getPort()
    {
      return $this->port;
    }

    function getPassword()
    {
      return $this->password;
    }
  }

  $servers = [];
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $mysqli = new mysqli('localhost', 'root', '', 'WEA');
    if ($mysqli->connect_error) {
      die("error");
    }
    $stmt = $mysqli->prepare("SELECT * FROM `server` WHERE `fk_user_id` = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($server = $result->fetch_assoc()) {
      $servers[] = new Server($server["id"], $server["name"], $server["ip"], $server["port"], $server["password"]);
    }
    $stmt->close();
    $mysqli->close();

    if (count($servers) > 0) {
      echo "<div class='nigar'>Your saved Servers</div>
        <table>
          <tr>
            <th>Server Name</th>
            <th>IP Address</th>
            <th>Actions</th>
          </tr>";
      foreach ($servers as $server) {
        $serverId = $server->getId();
        echo "<tr>";
        echo "<td>" . $server->getName() . "</td>";
        echo "<td>" . $server->getIp() . ":" . $server->getPort() . "</td>";
        echo "<td><a href='server.php?serverId=$serverId' class='button'>CON</a> <a href='deleteserver.php?serverId=$serverId' class='button'>DEL</a></td>";
        echo "</tr>";
      }
      echo "</table></div>";
    }
  }
  
  ?>

  <?php
  if (isset($_SESSION['successMessage'])) {
    ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true"
      data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body text-center">
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
              <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
              <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
            </svg>
            <p><?php echo $_SESSION['successMessage']; ?></p>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function () {
        $('#successModal').modal('show');
        setTimeout(function () {
          $('#successModal').modal('hide');
        }, 2500);
      });
    </script>
    <?php
    unset($_SESSION['successMessage']);
  }
  ?>

  <?php
  if (isset($_SESSION['errorMessage'])) {
    ?>
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true"
      data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body text-center">
          <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark_circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark_check" fill="none" d="M14.1 14.1l23.8 23.8 m0,-23.8 l-23.8,23.8"/></svg>
          <p><?php echo $_SESSION['errorMessage']; ?></p>
          </div>
        </div>
      </div>
    </div>
    </div>
    <script>
      $(document).ready(function () {
        $('#errorModal').modal('show');
        setTimeout(function () {
          $('#errorModal').modal('hide');
        }, 2500);
      });
    </script>
    <?php
    unset($_SESSION['errorMessage']);
  }
  ?>

</body>

</html>