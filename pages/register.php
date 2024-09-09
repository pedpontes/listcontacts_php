<?php
    require "../services/db.php";

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(!isset($_POST["username"]) || !isset($_POST["pass"]) || !isset($_POST["email"])) exit();

        $username = trim($_POST["username"]);
        $pass = trim($_POST["pass"]);
        $email = trim($_POST["email"]);

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            
            $conn = getDbConnection();
            
            $pass = password_hash($pass, PASSWORD_BCRYPT);

            echo $pass;

            try {
                $stmt = $conn->prepare("INSERT INTO users (username, pass, email) VALUES (?,'$pass',?)");
                $stmt->bind_param('ss', $username, $email);
                
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                echo 'Erro:'. $e->getMessage();
            }

            if(!($stmt->affected_rows > 0)){
                $conn->close();
                $stmt->close();
                header("location: /pages/register.php");
                exit();
            }

            $conn->close();
            $stmt->close();

            header("location: /pages/login.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <?php include "../includes/head.php" ?>
  <head>
    <link rel="stylesheet" href="../public/css/login.css">
    <title>Registrar</title>
  </head>
  <body class="text-center">
    <main class="form-signin">
      <form action="" method="post">
        <img class="mb-4" src="../public/assets/logo1.png" alt="" width="100" height="100">
        <h1 class="h3 mb-3 fw-normal">Registre-se</h1>
        <div class="form-floating">
          <input require type="text" name="username" class="form-control" id="floatingInput" placeholder="Username">
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
          <input require type="text" name="email" class="form-control" id="floatingPassword" placeholder="Email">
          <label for="floatingPassword">Email</label>
        </div>
        <div class="form-floating">
          <input require type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
      <p class="mt-5 mb-3 text-muted">Já é cadastrado?<a href="/pages/login.php"> Entrar</a></p>
    </form>
  </main>
</body>
</html>