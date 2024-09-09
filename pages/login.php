<?php
  include "../includes/check_session.php";

  if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    if(!isset($_POST["username"]) || !isset($_POST["pass"])){
      header("Location: /pages/login.php");
      exit();
    }
    if(empty($_POST["username"]) || empty($_POST["pass"])){
      header("Location: /pages/login.php");
      exit();
    }
    
    $username = trim($_POST["username"]);
    $pass = trim($_POST["pass"]);
    
    try {
      $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
      $stmt->bind_param("s", $username);

      $stmt->execute();
    } catch (mysqli_sql_exception $e) {
      exit("Erro: ". $e->getMessage());
    }

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $exist = password_verify($pass, $data["pass"]);

    $stmt->close();
    $conn->close();
    
    if($exist){
      $_SESSION["username"] = $data["username"];
      $_SESSION["pass"] = $data["pass"];
      $_SESSION["id"] = $data["id"];
      
      header("Location: /pages/contacts.php");
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
        <img class="mb-4" src="../public/assets/logo1.png" alt="" width="100" height="100">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <div class="form-floating">
          <input require type="text" name="username" class="form-control" id="floatingInput" placeholder="Username">
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