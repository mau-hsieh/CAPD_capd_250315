<?php
// 資料庫連線設定
$servername = "localhost";  // 資料庫伺服器
$username = "dive_db";      // 資料庫用戶名
$password = "Ie]c1P5pq7-]l6_9";  // 資料庫密碼
$dbname = "dive_db";        // 資料庫名稱

// 創建資料庫連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 獲取 AJAX 請求中的參數
$UserID = $_POST['UserID'];
$value = $_POST['value'];
$right01 = $_POST['right01'] ?? null;
$right02 = $_POST['right02'] ?? null;
$right03 = $_POST['right03'] ?? null;
$right04 = $_POST['right04'] ?? null;
$right05 = $_POST['right05'] ?? null;
$right06 = $_POST['right06'] ?? null;
$wrong01 = $_POST['wrong01'] ?? null;
$wrong02 = $_POST['wrong02'] ?? null;
$wrong03 = $_POST['wrong03'] ?? null;

// 插入數據到 dive_test_v3 資料表
$sql = "INSERT INTO dive_test_v3 (UserID, value, right01, right02, right03, right04, right05, right06, wrong01, wrong02, wrong03) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssssss",
    $UserID,
    $value,
    $right01,
    $right02,
    $right03,
    $right04,
    $right05,
    $right06,
    $wrong01,
    $wrong02,
    $wrong03
);

if ($stmt->execute()) {
    echo "Data saved successfully";
} else {
    echo "Error: " . $stmt->error;
}

// 關閉資料庫連接
$stmt->close();
$conn->close();
?>