<?php
session_start(); // 啟用 session

// 檢查是否已登入，否則重定向至 login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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

// 接收篩選條件
$search_username = isset($_GET['username']) ? $_GET['username'] : '';

// 準備 SQL 語句
$sql = "SELECT * FROM users";
if (!empty($search_username)) {
    $sql .= " WHERE username LIKE ?";
}

$stmt = $conn->prepare($sql);

if (!empty($search_username)) {
    $search_param = "%$search_username%";
    $stmt->bind_param("s", $search_param);
}

$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <title>使用者列表</title>
    <link rel="stylesheet" href="style.css"> <!-- 引用外部 CSS 檔案 -->
</head>

<body>
    <h1>使用者列表</h1>
    <div class="btn-group">
        <a href="add_user.php">新增使用者</a>
        <a href="logout.php">登出</a>
    </div>

    <!-- 搜尋表單 -->
    <form method="get" action="">
        <label for="username">搜尋使用者名稱:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($search_username); ?>">
        <button type="submit">搜尋</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>使用者名稱</th>
            <th>電子郵件</th>
            <th>建立時間</th>
            <th>操作</th>
            <th colspan="4">查看成績</th> <!-- 合併為一個欄位，跨 4 個列 -->
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <?php if ($row['id'] != 1): // 跳過 ID 為 1 的帳號 ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email'] ? $row['email'] : '無'; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td class="actions">
                        <a href="edit_user.php?id=<?php echo $row['id']; ?>">編輯</a>
                        <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('確認要刪除嗎？')">刪除</a>
                    </td>
                    <td>
                        <a href="view_score01.php?username=<?php echo urlencode($row['username']); ?>">查看成績(CAPD)</a>
                    </td>

                    <td>
                        <a href="view_score02.php?username=<?php echo urlencode($row['username']); ?>">查看成績(APD)</a>
                    </td>
                    <td>
                        <a href="view_score03.php?username=<?php echo urlencode($row['username']); ?>">查看成績(知識測驗)</a>
                    </td>
                    <td>
                        <a href="view_score04.php?username=<?php echo urlencode($row['username']); ?>">查看成績(導管護理)</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endwhile; ?>
    </table>
</body>

</html>

<?php
// 關閉連接
$stmt->close();
$conn->close();
?>