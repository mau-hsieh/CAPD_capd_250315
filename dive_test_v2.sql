-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2025 年 01 月 22 日 16:04
-- 伺服器版本： 10.11.6-MariaDB
-- PHP 版本： 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `dive_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `dive_test_v2`
--

CREATE TABLE `dive_test_v2` (
  `id` int(11) NOT NULL,
  `UserID` varchar(255) NOT NULL,
  `value` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `right01` int(11) DEFAULT NULL,
  `right02` int(11) DEFAULT NULL,
  `right03` int(11) DEFAULT NULL,
  `right04` int(11) DEFAULT NULL,
  `right05` int(11) DEFAULT NULL,
  `right06` int(11) DEFAULT NULL,
  `wrong01` int(11) DEFAULT NULL,
  `wrong02` int(11) DEFAULT NULL,
  `wrong03` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- 傾印資料表的資料 `dive_test_v2`
--

INSERT INTO `dive_test_v2` (`id`, `UserID`, `value`, `created_at`, `right01`, `right02`, `right03`, `right04`, `right05`, `right06`, `wrong01`, `wrong02`, `wrong03`) VALUES
(33, 'APD250122', 0, '2025-01-21 18:09:54', 1, 0, 0, 0, 0, 0, 0, 0, 0),
(34, 'mm', 0, '2025-01-22 06:22:37', 1, 1, 1, 1, 1, 1, 0, 0, 0);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `dive_test_v2`
--
ALTER TABLE `dive_test_v2`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `dive_test_v2`
--
ALTER TABLE `dive_test_v2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
