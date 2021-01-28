
<?php

session_start();

unset($_SESSION["email_exist"]);
unset($_SESSION["username_exist"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>MyFace</title>
</head>

  <div class="container">

  <div class="row login-form">

  <div class="col-6">
    <form action="auth.php" method="POST">
     <h2 class="login">Login</h2>
      <div class="form-group">
        <input class="form-control" type="email" name="email" placeholder="E-mail Address">
       
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password">

      </div>      
      <button type="submit" name="submit-login" class="btn-primary">Login</button>      
      <a class="register" href="register.php">Create new account</a>
    </form>
    </div>
  </div>
  </div>
</body>
</html>
