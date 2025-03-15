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

// 處理新增使用者
if (isset($_POST['add'])) {
    $username = $_POST['username'];
    $email = $_POST['email'] ? $_POST['email'] : null;  // 如果沒有填寫電子郵件，設為 NULL
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 密碼加密

    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "使用者已新增";
    } else {
        echo "錯誤: " . $stmt->error;
    }

    echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>新增使用者</title>
</head>
<body>
    <h1>新增使用者</h1>
    <form action="add_user.php" method="post">
        <input type="text" name="username" placeholder="使用者名稱" required>
        <input type="email" name="email" placeholder="電子郵件 (可選)">
        <input type="password" name="password" placeholder="密碼" required>
        <button type="submit" name="add">新增</button>
    </form>
    <a href="index.php">返回使用者列表</a>
</body>
</html>

<?php
// 關閉連接
$conn->close();
?>
