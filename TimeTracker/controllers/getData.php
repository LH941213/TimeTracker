<?php
include "../config/db.php";
$pdo = getDBConnection();

$start = $_GET["start"] ?? null; 
$end = $_GET["end"] ?? null;
$group=$_GET['group'] ?? '';   

if (!$start || !$end) {
    alert("请选择开始日期和结束日期！");
    exit;
}
switch ($group) {
    case 'day':
        $groupExpr = "CONVERT(varchar(10), StartTime, 120)"; // yyyy-MM-dd
        $selectLabel = "$groupExpr AS Label";
        break;
    case 'month':
        $groupExpr = "FORMAT(StartTime, 'yyyy-MM')";
        $selectLabel = "$groupExpr AS Label";
        break;
    case 'year':
        $groupExpr = "YEAR(StartTime)";
        $selectLabel = "$groupExpr AS Label";
        break;
    default:
        $groupExpr = "Category";
        $selectLabel = "Category AS Label";
        break;
}
// 修改SQL查询，在按时间分组时也包含类别信息
if ($group && $group !== '') {
    $sql = "SELECT $selectLabel, Category, SUM(DATEDIFF(minute, StartTime, EndTime))/60.0 AS TotalHours
            FROM TimeLogs
            WHERE StartTime BETWEEN :start AND :end
            GROUP BY $groupExpr, Category
            ORDER BY $groupExpr, Category";
} else {
    $sql = "SELECT $selectLabel, SUM(DATEDIFF(minute, StartTime, EndTime))/60.0 AS TotalHours
            FROM TimeLogs
            WHERE StartTime BETWEEN :start AND :end
            GROUP BY $groupExpr
            ORDER BY $groupExpr";
}
$stmt = $pdo->prepare($sql);
$stmt->execute(["start" => $start, "end" => $end]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
?>
