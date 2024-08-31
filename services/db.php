<?php 
    define("DB_HOST", "192.168.1.3"); 
    define("DB_USER", "facul"); 
    define("DB_PASS", "123456"); 
    define("DB_PORT", "3306"); 
    define("DB_DATABASE", "pw2_contacts"); 

    function getDbConnection(){
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_PORT);
        
        if($conn->connect_error){
            exit("Erro ao conectar ao banco: ". $conn->connect_error);
        }
        return $conn;
    }
?>