<?php
    require "../services/db.php";

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(!isset($_POST["username"]) || !isset($_POST["pass"])) exit();

        $username = $_POST["username"];
        $pass = $_POST["pass"];

        $conn = getDbConnection();
        
        $stmt = $conn->prepare("INSERT INTO users (username, pass) VALUES (?,?)");
        $stmt->bind_param('ss', $username, $pass);

        $isSuccess = $stmt->execute();
        
        $conn->close();
        $stmt->close();

        if(!$isSuccess) exit();
        
        header("location: /pages/login.php");
        exit();
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
        <input type="submit" value="Registrar">
    </form>
</body>
</html>