<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login & Registration Form</title>
    <!---Custom CSS File--->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <input type="checkbox" id="check">
    <div class="register form">
      <header>Register</header>
      <form action="" method="post">
        <input type="text" name="email" placeholder="Enter your email">
        <input type="text" name="username" placeholder="Enter your username">
        <input type="password" placeholder="Create a password">
        <input type="button" class="button" value="Register">
      </form>
      <div class="signup">
        <span class="signup">Already have an account?
          <a href="login.php">Login</a>
        </span>
      </div>
    </div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $mysqli = new mysqli('localhost', 'root', '', 'WEA');
  if ($mysqli->connect_error) {
      die("error");
  }

  $username = $_POST['username'];

  $stmt = $mysqli->prepare("SELECT username FROM `user` WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  echo "negr";
  echo "<script>console.log(negr);</script>";
  
  while ($row = $result->fetch_assoc()) {
    if ($username == $row) {
      echo "<script type='text/javascript'>alert('Username is already taken');</script>";
    }
  }
}

?>
</body>
</html>