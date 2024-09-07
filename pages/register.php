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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="" method="post">
        <label for="username">
            Username:
            <input type="text" name="username" id="username" require>
        </label>
        <label for="pass">
            Username:
            <input type="password" name="pass" id="pass" require>
        </label>
        <label for="email">
            Email:
            <input type="email" name="email" id="email">
        </label>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>