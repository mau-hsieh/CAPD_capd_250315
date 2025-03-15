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

$user_id = $_GET['id'];

// 查詢該使用者的答題記錄，依 session_id 和 question_number 排序
$result = $conn->query("SELECT session_id, question_number, is_correct FROM responses WHERE user_id = $user_id ORDER BY session_id, question_number");

// 準備變數儲存
$sessions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // 將相同 session_id 的資料存入同一個 array
        $sessions[$row['session_id']][] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>查看成績</title>
    <link rel="stylesheet" href="style.css"> <!-- 引用外部 CSS 檔案 -->
</head>
<body>
    <h1>查看成績</h1>

    <?php if (!empty($sessions)): ?>
        <?php 
        $test_number = 1; // 測驗次數計數器
        foreach ($sessions as $session_id => $questions): ?>
            <h2>第<?php echo $test_number; ?>次測驗 (Session ID: <?php echo $session_id; ?>)</h2>
            <table>
                <tr>
                    <th>問題編號</th>
                    <th>作答結果</th>
                </tr>
                <?php foreach ($questions as $question): ?>
                    <tr>
                        <td><?php echo $question['question_number']; ?></td>
                        <td><?php echo $question['is_correct'] ? '正確' : '錯誤'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php $test_number++; // 每處理一個 session_id 後，測驗次數遞增 ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>無答題記錄</p>
    <?php endif; ?>

    <a href="index.php" class="back-link">返回使用者列表</a>
</body>
</html>

<?php
// 關閉連接
$conn->close();
?>
