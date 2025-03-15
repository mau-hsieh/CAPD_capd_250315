<?php
session_start();
session_unset();  // 清除所有 session 變數
session_destroy(); // 銷毀 session

// 重定向回到登入頁面
header("Location: login.php");
exit();
