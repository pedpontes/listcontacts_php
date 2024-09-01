<?php
    include "../services/db.php";

    session_start();

    if(!isset($_SESSION["username"]) || !isset($_SESSION["pass"])){
        if(basename($_SERVER['PHP_SELF']) !== "login.php"){
            header("location: /pages/login.php");
            exit();
        }
    }
    else{
        $username = trim($_SESSION["username"]);
        $pass = trim($_SESSION["pass"]);

        $conn = getDbConnection();
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? and pass = ?");
        $stmt->bind_param("ss", $username, $pass);
        $stmt->execute();

        $result = $stmt->get_result();
        $exist = $result->num_rows > 0 ? true : false;

        if(!$exist){
            if(basename($_SERVER['PHP_SELF']) !== "login.php"){
                header("location: /pages/login.php");
                exit();
            }
        }
        else{
            if(basename($_SERVER['PHP_SELF']) === "login.php"){
                header("location: /pages/contacts.php");
                exit();
            }
        }
    }
?>