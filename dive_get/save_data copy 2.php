<?php
// 設置回應類型為 JSON
header("Content-Type: application/json");

// 資料庫連線設定
$servername = "localhost";
$username = "dive_db";
$password = "Ie]c1P5pq7-]l6_9";
$dbname = "dive_db";

// 創建資料庫連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接是否成功
if ($conn->connect_error) {
    die(json_encode([
        "status" => "error",
        "message" => "Connection failed: " . $conn->connect_error
    ]));
}

// 獲取 POST 資料
$UserID = isset($_POST['UserID']) ? $_POST['UserID'] : '';
$value = isset($_POST['value']) ? $_POST['value'] : null;

// 簡單驗證輸入
if ($UserID !== '' && $value !== null) {
    // 防止 SQL 注入
    $UserID = $conn->real_escape_string($UserID);
    $value = $conn->real_escape_string($value);

    // 插入數據到資料表
    $sql = "INSERT INTO dive_test_v2 (UserID, value) VALUES ('$UserID', '$value')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            "status" => "success",
            "message" => "Data saved successfully",
            "UserID" => $UserID,
            "value" => $value
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Error inserting data: " . $conn->error
        ]);
    }
} else {
    // 處理無效輸入
    echo json_encode([
        "status" => "error",
        "message" => "Invalid input: UserID or value is missing"
    ]);
}

// 關閉資料庫連線
$conn->close();
?>
