<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>注册账户 - TimeTracker</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<script src="../public/register.js"></script>

<body>
    <h1>注册新账户</h1>
    <form action="../controllers/register.php" method="POST">
        用户名: <input type="text" name="username" required><br>
        邮箱: <input type="email" name="email" required><br>
        密码: <input type="password" name="password" required><br>
        <input type="submit" value="注册">
    </form>
</body>
</html>
