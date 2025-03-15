<?php
// 資料庫連線設定
$servername = "localhost";
$username = "dive_db";
$password = "Ie]c1P5pq7-]l6_9";
$dbname = "dive_db";

// 創建資料庫連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 獲取 AJAX 請求中的資料
$UserID = isset($_POST['UserID']) ? $_POST['UserID'] : '';
$value = isset($_POST['value']) ? $_POST['value'] : NULL; // 若未提供，設為 NULL

// 初始化欄位陣列
$rightFields = [];

// 動態處理 `PDCC_right` 欄位
for ($i = 1; $i <= 6; $i++) {
    $rightField = sprintf("PDCC_right%02d", $i);
    $rightFields[$rightField] = isset($_POST[$rightField]) ? $_POST[$rightField] : NULL;
}

if ($UserID !== '') {
    // 防止 SQL 注入
    $UserID = $conn->real_escape_string($UserID);
    $value = $value !== NULL ? $conn->real_escape_string($value) : "NULL";

    // 處理 `PDCC_right` 欄位的值
    foreach ($rightFields as $key => $val) {
        $rightFields[$key] = $val !== NULL ? $conn->real_escape_string($val) : "NULL";
    }

    // 構建 SQL 插入語句
    $sql = "INSERT INTO dive_test_v_PDCC (UserID, value, " . implode(", ", array_keys($rightFields)) . ") 
            VALUES ('$UserID', $value, " . implode(", ", $rightFields) . ")";

    // 執行插入操作
    if ($conn->query($sql) === TRUE) {
        echo "Data saved successfully";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid data received";
}

// 關閉資料庫連接
$conn->close();
?>
