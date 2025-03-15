<?php
// 載入 config.php 並取得資料庫連線資訊
$config = include('config.php');

$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];

$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 設定回傳為 JSON
header('Content-Type: application/json');

// 取得從 JavaScript 傳來的資料
$data = json_decode(file_get_contents('php://input'), true);
$input_username = $data['username'];
$input_password = $data['password'];

// 查詢資料庫中的用戶
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $input_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // 取得使用者資料
    $user = $result->fetch_assoc();

    // 驗證密碼
    if (password_verify($input_password, $user['password'])) {
        // 密碼正確
        echo json_encode(['success' => true]);
    } else {
        // 密碼錯誤
        echo json_encode(['success' => false]);
    }
} else {
    // 用戶不存在
    echo json_encode(['success' => false]);
}

// 關閉連接
$conn->close();
?>
