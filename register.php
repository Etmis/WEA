<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="register form">
      <header>Register</header>
      <form action="" method="post">
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="text" name="username" placeholder="Enter your username" required>
        <input type="password" name="password" placeholder="Create a password" required>
        <input type="submit" class="button" value="Register">
      </form>
      <div class="signup">
        <span class="signup">Already have an account?
          <a href="login.php">Login</a>
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

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("SELECT username FROM `user` WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
      echo "<script type='text/javascript'>alert('Username is already taken');</script>";
    } else {
      $stmt = $mysqli->prepare("INSERT INTO `user` (`email`, `username`, `password`) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $email, $username, $password);
      $stmt->execute();

      $user_id = $stmt->insert_id;
      $stmt->close();
      
      $_SESSION['user_id'] = $user_id;

      $mysqli->close();

      $_SESSION['successMessage'] = "Registration Successful!";
      header("Location: index.php");
      exit();
    }
  }
  ?>
</body>

</html>