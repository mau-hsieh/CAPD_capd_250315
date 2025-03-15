<?php
// 資料庫連線設定
$config = include('config.php');

$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];

// 建立連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}
// 新增帳號函數
function createUser($conn, $username, $password) {
    // 使用 bcrypt 加密密碼
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    // 準備 SQL 查詢
    $stmt = $conn->prepare("INSERT INTO care_users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);
    
    // 執行查詢並檢查結果
    if ($stmt->execute()) {
        echo "新增帳號成功！";
    } else {
        echo "錯誤: " . $stmt->error;
    }
    
    // 關閉 SQL statement
    $stmt->close();
}

// 測試用的帳號與密碼
$newUsername = "care"; // 改成你想新增的使用者名稱
$newPassword = "care"; // 改成你想新增的密碼

// 呼叫函數新增使用者
createUser($conn, $newUsername, $newPassword);

// 關閉連線
$conn->close();
?>
