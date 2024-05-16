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
      <form action="register.php">
        <input type="text" placeholder="Enter your email">
        <input type="password" placeholder="Create a password">
        <input type="password" placeholder="Confirm your password">
        <input type="button" class="button" value="Register">
      </form>
      <div class="signup">
        <span class="signup">Already have an account?
          <a href="login.php">Login</a>
        </span>
      </div>
    </div>
</body>
</html>