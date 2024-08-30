<?php
    if($_SERVER["REQUEST_METHOD"] === "GET"){
        include "../includes/check_session.php";

        header("location: /pages/contacts.php");
        exit();
    }
    elseif($_SERVER["REQUEST_METHOD"] === "POST"){
        if(!isset($_POST["username"]) || !isset($_POST["pass"])) exit();
        //codigo para logar na conta e setar o session

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../includes/head.php" ?>
    <link rel="stylesheet" href="../public/css/login.css">
    <title>Login</title>
</head>
<body class="text-center">
    <main class="form-signin">
      <form>
        <img class="mb-4" src="/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
    
        <div class="form-floating">
          <input require type="email" name= "email" class="form-control" id="floatingInput" placeholder="name@example.com">
          <label for="floatingInput">Email address</label>
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
        <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
      </form>
    </main>
</body>
</html>