<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>记录活动 - TimeTracker</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <h1>记录新活动</h1>
    
    <form action="../controllers/activity.php" method="POST">
        
        活动名称: <input type="text" name="activity_name" required><br>
        分类: <select name="category">
            <option value="学习">学习</option>
            <option value="工作">工作</option>
            <option value="休闲">休闲</option>
            <option value="运动">运动</option>
        </select><br>
        开始时间: <input type="datetime-local" name="start_time" required><br>
        结束时间: <input type="datetime-local" name="end_time"><br>
        备注: <textarea name="notes"></textarea><br>
        <input type="submit" value="提交">
    </form>
    

</body>
</html>
