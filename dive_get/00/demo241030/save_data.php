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
$right01 = isset($_POST['right01']) ? $_POST['right01'] : NULL;
$right02 = isset($_POST['right02']) ? $_POST['right02'] : NULL;
$right03 = isset($_POST['right03']) ? $_POST['right03'] : NULL;
$right04 = isset($_POST['right04']) ? $_POST['right04'] : NULL;
$right05 = isset($_POST['right05']) ? $_POST['right05'] : NULL;
$right06 = isset($_POST['right06']) ? $_POST['right06'] : NULL;
$wrong01 = isset($_POST['wrong01']) ? $_POST['wrong01'] : NULL;
$wrong02 = isset($_POST['wrong02']) ? $_POST['wrong02'] : NULL;
$wrong03 = isset($_POST['wrong03']) ? $_POST['wrong03'] : NULL;

if ($UserID !== '') {
    // 防止 SQL 注入
    $UserID = $conn->real_escape_string($UserID);
    $value = $value !== NULL ? $conn->real_escape_string($value) : "NULL";
    $right01 = $right01 !== NULL ? $conn->real_escape_string($right01) : "NULL";
    $right02 = $right02 !== NULL ? $conn->real_escape_string($right02) : "NULL";
    $right03 = $right03 !== NULL ? $conn->real_escape_string($right03) : "NULL";
    $right04 = $right04 !== NULL ? $conn->real_escape_string($right04) : "NULL";
    $right05 = $right05 !== NULL ? $conn->real_escape_string($right05) : "NULL";
    $right06 = $right06 !== NULL ? $conn->real_escape_string($right06) : "NULL";
    $wrong01 = $wrong01 !== NULL ? $conn->real_escape_string($wrong01) : "NULL";
    $wrong02 = $wrong02 !== NULL ? $conn->real_escape_string($wrong02) : "NULL";
    $wrong03 = $wrong03 !== NULL ? $conn->real_escape_string($wrong03) : "NULL";

    // 插入數據到新資料表
    $sql = "INSERT INTO dive_test_v2 (UserID, value, right01, right02, right03, right04, right05, right06, wrong01, wrong02, wrong03) 
            VALUES ('$UserID', $value, $right01, $right02, $right03, $right04, $right05, $right06, $wrong01, $wrong02, $wrong03)";
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
