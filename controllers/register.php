<?php
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // 加密密码

    try {
        $pdo = getDBConnection(); // 使用 PDO
        $sql = "INSERT INTO Users (Username, Email, PasswordHash) VALUES (:username, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "username" => $username,
            "email" => $email,
            "password" => $password
        ]);

        echo "注册成功！请登录。";
        header("Location: ../views/login.php"); // 注册完成跳转到登录页面
        exit();
    } catch (PDOException $e) {
        die("注册失败: " . $e->getMessage());
    }
}
?>
