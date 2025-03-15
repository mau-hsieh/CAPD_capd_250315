<?php
// 載入 config.php 並取得資料庫連線資訊
$config = include('config.php');

$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 刪除使用者
$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id=$id");

echo "使用者已刪除";
echo "<meta http-equiv='refresh' content='0;url=index.php'>";

$conn->close();
?>
