<?php
    include "../services/db.php";

    $conn = getDbConnection();

    session_start();

    if(!isset($_SESSION["username"]) || !isset($_SESSION["pass"]) || !isset($_SESSION["id"])){
        exit("aq");
        if(basename($_SERVER['PHP_SELF']) !== "login.php"){
            header("location: /pages/login.php");
            exit();
        }
    }
    else{
        $username = $_SESSION["username"];
        $pass = $_SESSION["pass"];
        $id = $_SESSION["id"];

        $result = $conn->query("SELECT * FROM users WHERE id = '$id'");
        $data = $result->fetch_assoc();

        $exist = password_verify($pass, $data["pass"]);

        echo $exist;

        exit();
        if(!$exist){
            if(basename($_SERVER['PHP_SELF']) !== "login.php"){
                header("location: /pages/login.php");
                exit();
            }
        }else{
            if(basename($_SERVER['PHP_SELF']) === "login.php"){
                header("location: /pages/contacts.php");
                exit();
            }
        }
    }