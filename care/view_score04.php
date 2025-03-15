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

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 接收 `username` 作為篩選條件
$username_filter = isset($_GET['username']) ? $_GET['username'] : '';

if (empty($username_filter)) {
    die("未提供有效的使用者名稱！");
}

// 查詢問題文字
$questions_sql = "SELECT id, question_text FROM question04 WHERE id BETWEEN 1 AND 6";
$questions_result = $conn->query($questions_sql);

$questions = [];
if ($questions_result->num_rows > 0) {
    while ($row = $questions_result->fetch_assoc()) {
        $questions[$row['id']] = $row['question_text'];
    }
} else {
    die("未找到相關問題資料！");
}

// 查詢篩選後的成績
$sql = "SELECT * FROM dive_test_v_PDCC WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username_filter);
$stmt->execute();
$result = $stmt->get_result();

// 準備變數儲存成績
$scores = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $scores[] = $row;
    }
} else {
    $no_scores = true;
}

$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>查看自動腹膜透析的成績 - <?php echo htmlspecialchars($username_filter); ?></title>
    <link rel="stylesheet" href="style.css"> <!-- 引用外部 CSS 檔案 -->
    <style>
        .correct {
            color: green;
        }
        .incorrect {
            color: red;
        }
    </style>
</head>
<body>
    <h1>查看成績 - <?php echo htmlspecialchars($username_filter); ?></h1>

    <?php if (!isset($no_scores)): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>使用者 ID</th>
                <th>建立時間</th>
                <?php foreach ($questions as $id => $question_text): ?>
                    <th><?php echo htmlspecialchars($question_text); ?></th>
                <?php endforeach; ?>

            </tr>
            <?php foreach ($scores as $score): ?>
                <tr>
                    <td><?php echo htmlspecialchars($score['id']); ?></td>
                    <td><?php echo htmlspecialchars($score['UserID']); ?></td>
                    <td><?php echo htmlspecialchars($score['created_at']); ?></td>
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <td class="<?php echo $score["right0$i"] == 1 ? 'correct' : 'incorrect'; ?>">
                            <?php echo $score["right0$i"] == 1 ? '操作正確' : '操作錯誤'; ?>
                        </td>
                    <?php endfor; ?>

                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>沒有找到成績記錄。</p>
    <?php endif; ?>

    <a href="index.php" class="back-link">返回使用者列表</a>
</body>
</html>