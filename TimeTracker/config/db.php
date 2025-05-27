<?php
    function getDBConnection(){
        $dsn = "sqlsrv:Server=localhost;Database=TimeTrackerDB";
        $username = "sa";  
        $password = "Liuhe1213";  
        $pdo = new PDO($dsn, $username, $password);
        return $pdo;

    }
?>