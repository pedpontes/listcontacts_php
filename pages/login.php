<?php
  include "../includes/check_session.php";

  if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    $conn = getDbConnection();

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
    $user = $result->fetch_assoc();

    //verifica se o usuario existe
    if(!isset($user)){
      header("Location: /pages/login.php");
      exit();
    }

    $match = password_verify($pass, $user["pass"]);

    $stmt->close();
    $conn->close();
    
    //caso o username e pass derem match, insere na session
    if($match){
      $_SESSION["username"] = $user["username"];
      $_SESSION["pass"] = $user["pass"];
      $_SESSION["id"] = $user["id"];
      
      header("Location: /pages/contacts.php");
      exit();
    }
    else{
      if(!isset($user)){
        header("Location: /pages/login.php");
        exit();
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <?php include "../includes/head.php" ?>
  <head>
    <link rel="stylesheet" href="../public/css/login.css">
    <title>Entrar</title>
  </head>
  <body class="text-center">
    <main class="form-signin">
      <form action="" method="post">
        <img class="mb-4" src="../public/assets/logo1.png" alt="" width="200" height="200">
        <h1 class="h3 mb-3 fw-normal">Entrar</h1>
        <div class="form-floating">
          <input required type="text" name="username" class="form-control" id="floatingInput" placeholder="Username">
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
          <input required type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
      <p class="mt-5 mb-3 text-muted">Não tem conta?<a href="/pages/register.php"> Registre-se</a></p>
    </form>
  </main>
</body>
</html>