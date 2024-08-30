<?php
    require "../services/db.php";

    session_start();

    if(!isset($_SESSION["username"]) || !isset($_SESSION["pass"])){
        header("location: /pages/login.php");
        exit();
    }

    $username = $_SESSION["username"];
    $pass = $_SESSION["pass"];

    $conn = getDbConnection();
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? and pass = ?");
    $stmt->bind_param("ss", $username, $pass);
    $exist = $stmt->execute();

    $conn->close();
    $stmt->close();

    if(!$exist){
        header("location: /pages/login.php");
        exit();
    }
?>