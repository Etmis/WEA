<?php session_start() ?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>Login</header>
      <form action="" method="post">
        <input type="text" name="username" placeholder="Enter your username" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <input type="submit" class="button" value="Login">
      </form>
      <div class="signup">
        <span class="signup">Don't have an account?
          <a href="register.php">Register</a>
        </span>
      </div>
    </div>
  </div>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysqli = new mysqli('localhost', 'root', '', 'WEA');
    if ($mysqli->connect_error) {
      die("Connection failed: " . $mysqli->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id, username, password FROM `user` WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $stmt->bind_result($user_id, $db_username, $db_password);
      $stmt->fetch();
      if (password_verify($password, $db_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['successMessage'] = "Login Successful!";
        header("Location: index.php");
        exit();
      } else {
        echo "<script type='text/javascript'>alert('Invalid password');</script>";
      }
    } else {
      echo "<script type='text/javascript'>alert('Account with this username doesn\'t exist');</script>";
    }

    $stmt->close();
    $mysqli->close();

  }
  ?>

</body>

</html>