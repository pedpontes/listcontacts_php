<?php 
    define("DB_HOST", "localhost"); 
    define("DB_USER", "root"); 
    define("DB_PASS", ""); 
    define("DB_PORT", "3306"); 
    define("DB_DATABASE", "listcontacts"); 

    function getDbConnection(){
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_PORT);
        
        if($conn->connect_error){
            exit("Erro ao conectar ao banco: ". $conn->connect_error);
        }
        return $conn;
    }
?>