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

// 檢查是否傳遞了 id 參數
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 使用預處理語句查詢使用者資料，防止 SQL 注入
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die("找不到該使用者");
    }

    // 更新使用者資料
    if (isset($_POST['update'])) {
        $username = $_POST['username'];
        $email = $_POST['email'] ? $_POST['email'] : null;
        $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

        $update_stmt = $conn->prepare("UPDATE users SET username=?, email=?, password=? WHERE id=?");
        $update_stmt->bind_param("sssi", $username, $email, $password, $id);

        if ($update_stmt->execute()) {
            echo "使用者資料已更新";
        } else {
            echo "錯誤: " . $update_stmt->error;
        }

        echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    }

} else {
    die("未提供使用者 ID");
}

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>編輯使用者</title>
</head>
<body>
    <h1>編輯使用者</h1>
    <form action="edit_user.php?id=<?php echo $id; ?>" method="post">
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="電子郵件 (可選)">
        <input type="password" name="password" placeholder="留空保持原密碼">
        <button type="submit" name="update">更新</button>
    </form>
    <a href="index.php">返回使用者列表</a>
</body>
</html>

<?php
// 關閉連接
$conn->close();
?>
