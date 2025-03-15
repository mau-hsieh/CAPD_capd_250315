<?php
session_start(); // 啟用 session

// 檢查是否已登入，若已登入則重定向至使用者列表頁面
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

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

// 處理登入邏輯
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // 查詢資料庫中的 care_users 資料表
    $stmt = $conn->prepare("SELECT id, username, password FROM care_users WHERE username = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 取得使用者資料
        $user = $result->fetch_assoc();

        // 驗證密碼
        if (password_verify($input_password, $user['password'])) {
            // 密碼正確，登入成功
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // 跳轉到 index.php 顯示 users 資料表中的內容
            header("Location: index.php");
            exit();
        } else {
            $login_error = "密碼錯誤，請再試一次。";
        }
    } else {
        $login_error = "使用者名稱不存在。";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>使用者登入</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        label {
            font-size: 14px;
            color: #555;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        p {
            text-align: center;
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <form action="login.php" method="post">
        <h1>登入頁面</h1>
        <!-- 顯示錯誤訊息 -->
        <?php if ($login_error): ?>
            <p><?php echo $login_error; ?></p>
        <?php endif; ?>

        <!-- 登入表單 -->
        <label for="username">使用者名稱:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">密碼:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">登入</button>
    </form>
</body>
</html>

