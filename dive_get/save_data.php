<?php
// 資料庫連線設定
$servername = "localhost";  // 你的資料庫伺服器
$username = "dive_db";  // 你的資料庫用戶名
$password = "Ie]c1P5pq7-]l6_9";  // 你的資料庫密碼
$dbname = "dive_db";  // 你的資料庫名稱

// 創建資料庫連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 獲取 AJAX 請求中的 name 和 value 參數
$name = $_POST['name'];
$value = $_POST['value'];

// 插入數據到 dive_test 資料表
$sql = "INSERT INTO dive_test_v2 (name, value) VALUES ('$name', '$value')";

if ($conn->query($sql) === TRUE) {
    echo "Data saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// 關閉資料庫連接
$conn->close();
?>
