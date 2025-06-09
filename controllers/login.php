<?php
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $pdo = getDBConnection();
    $sql = "SELECT UserID, PasswordHash FROM Users WHERE Username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["username" => $username]);
    $row =$stmt->fetch(PDO::FETCH_ASSOC);
    if ($row&& password_verify($password,$row["PasswordHash"])) {
        session_start();
        $_SESSION["UserID"]=$row["UserID"];
        header("Location: ../views/dashboard.php");
        exit();
    }else {
        echo "用户名或密码错误";
    }


   
    
    
}
?>
