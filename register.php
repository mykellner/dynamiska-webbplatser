<?php 

require 'registerauth.php';

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
  <div class="row login-form">
    <div class="col-6">
    <form action="registerauth.php" method="POST">
      <h2>Create new account</h2>
      <div class="form-group">
      <?php if(isset($_SESSION['username_exist']) && $_SESSION['username_exist']) : ?>
        <label> Avändarnamnet är upptaget, vänligen välj ett annat. </label>
        <?php endif; ?> 
        <input type="text" class="form-control" name="username" placeholder="Username" require>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="fname" placeholder="Name" require>
      </div>  
      <div class="form-group">
        <input type="text" class="form-control" name="lname" placeholder="Surname" require>
      </div>      
      <div class="form-group">
      <?php if(isset($_SESSION['email_exist']) && $_SESSION['email_exist']) : ?>
        <label> Emailen är redan registrerad i vår databas. </label>
        <?php endif; ?> 
        <input type="email" class="form-control" name="email" placeholder="E-mail Address" require>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password" require>
      </div>      
      <button type="submit" name="submit" class="btn-primary">Create account</button>      
      <a href="index.php">Back to login</a>
    </form>
  </div>
  </div>
</body>
</html>
    
</body>
</html>