
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录 - TimeTracker</title>
</head>
<body>
    <h1>登录 TimeTracker</h1>

    <form action="../controllers/login.php" method="POST">
    用户名: <input type="text" name="username"><br>
    密码: <input type="password" name="password"><br>
    <input type="submit" value="登录">

</form>
<p>还没有账号？<a href="register.php">点击注册</a></p>

</body>
</html>