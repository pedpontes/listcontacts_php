<?php
  include "../includes/check_session.php";

  if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    if(!isset($_POST["username"]) || !isset($_POST["pass"])) exit();
    
    $username = trim($_POST["username"]);
    $pass = trim($_POST["pass"]);
    
    $conn = getDbConnection();
        
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? and pass = ?");
    $stmt->bind_param("ss", $username, $pass);
    $stmt->execute();

    $result = $stmt->get_result();
    $exist = $result->num_rows > 0 ? true : false;
    
    $stmt->close();
    $conn->close();
    
    if($exist){
      $_SESSION["username"] = $username;
      $_SESSION["pass"] = $pass;
      
      header("location: /pages/contacts.php");
      exit();
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <?php include "../includes/head.php" ?>
  <head>
    <link rel="stylesheet" href="../public/css/login.css">
    <title>Login</title>
  </head>
  <body class="text-center">
    <main class="form-signin">
      <form action="" method="post">
        <img class="mb-4" src="/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <div class="form-floating">
          <input require type="text" name= "username" class="form-control" id="floatingInput">
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
          <input require type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">Não tem conta?<a href="/pages/register.php"> Registre-se</a></p>
    </form>
  </main>
</body>
</html>