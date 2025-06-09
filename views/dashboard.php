<?php
// 文件路径: your_project_root/views/dashboard.php

include "../config/db.php";
$pdo = getDBConnection();
$sql = "SELECT Category, SUM(DATEDIFF(minute, StartTime, EndTime))/60.0 AS TotalHours FROM TimeLogs GROUP BY Category";
$stmt = $pdo->query($sql);
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <title>仪表盘 - TimeTracker</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const initialActivities = <?php echo json_encode($activities); ?>;
    </script>
    <script src="/TimeTracker/public/script.js"></script>
</head>

<body>
    <h1>我的活动数据</h1>

    <a href="activity.php"><button>记录新活动</button></a>
    <h2>选择时间范围</h2>
    <label>开始日期:</label> <input type="date" id="startDate">
    <label>结束日期:</label> <input type="date" id="endDate">
    <label for="groupType">时间分组：</label>
    <select id="groupType">
        <option value="">按活动类型（默认）</option>
        <option value="day">按天</option>
        <option value="month">按月</option>
        <option value="year">按年</option>
    </select>
    <button onclick="updateChart()">更新数据</button>
    <div style="width: 100%; height: 400px; position: relative;">
        <canvas id="activityChart"></canvas>
    </div>
</body>

</html>