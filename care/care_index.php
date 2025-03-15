<?php
// 載入 config.php 並取得資料庫連線資訊
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

// 顯示所有使用者資料
$result = $conn->query("SELECT * FROM care_users");

?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>使用者列表</title>
</head>
<body>
    <h1>使用者列表</h1>
    <a href="add_care_user.php">新增使用者</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>使用者名稱</th>
            <th>電子郵件</th>
            <th>建立時間</th>
            <th>操作</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email'] ? $row['email'] : '無'; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $row['id']; ?>">編輯</a>
                    <a href="view_scores.php?id=<?php echo $row['id']; ?>">查看成績</a>
                    <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('確認要刪除嗎？')">刪除</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
// 關閉連接
$conn->close();
?>
