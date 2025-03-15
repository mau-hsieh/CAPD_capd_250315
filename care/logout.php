<?php
session_start(); // 啟用 session
session_destroy(); // 清除 session 資料
header("Location: login.php"); // 重定向到登入頁面
exit();
?>
