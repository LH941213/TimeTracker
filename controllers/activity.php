<?php
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activity_name = $_POST["activity_name"];
    $category = $_POST["category"];
    $start_time = date('Y-m-d H:i:s', strtotime($_POST["start_time"]));

    $end_time = isset($_POST["end_time"]) && $_POST["end_time"] !== "" 
                ? date('Y-m-d H:i:s', strtotime($_POST["end_time"])) 
                : NULL;

    $notes = $_POST["notes"] ?? NULL;
    $user_id = 1; // 假设用户已登录（之后用 session 管理用户）

    
    $pdo = getDBConnection();
    $sql = "INSERT INTO TimeLogs (UserID, ActivityName, Category, StartTime, EndTime, Notes) 
                VALUES (:user_id, :activity_name, :category, :start_time, :end_time, :notes)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
            "user_id" => $user_id,
            "activity_name" => $activity_name,
            "category" => $category,
            "start_time" => $start_time,
            "end_time" => $end_time,
            "notes" => $notes
        ]);
    echo "活动记录成功！";
    header("Location: ../views/dashboard.php");
    exit();
    
}
?>
