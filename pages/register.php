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