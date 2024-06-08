-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- 主機： localhost:3306
-- 產生時間： 2024 年 06 月 07 日 16:09
-- 伺服器版本： 10.11.7-MariaDB-2ubuntu2
-- PHP 版本： 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `cbb111232`
--

-- --------------------------------------------------------

--
-- 資料表結構 `carts`
--

CREATE TABLE `carts` (
  `cartID` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `buyer_id` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `carts`
--

INSERT INTO `carts` (`cartID`, `p_id`, `buyer_id`, `amount`) VALUES
(50, 5, '3', 1),
(51, 6, '3', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `orderDetail`
--

CREATE TABLE `orderDetail` (
  `detailID` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `sellerID` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `products`
--

CREATE TABLE `products` (
  `p_id` int(11) NOT NULL,
  `p_name` text NOT NULL,
  `p_price` int(11) NOT NULL,
  `p_amount` int(11) NOT NULL,
  `p_intro` text NOT NULL,
  `p_picture` text NOT NULL,
  `sellerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `products`
--

INSERT INTO `products` (`p_id`, `p_name`, `p_price`, `p_amount`, `p_intro`, `p_picture`, `sellerID`) VALUES
(5, '【KITACO × GEARS】EV 後避震器 MONKEY125 (18-)', 19793, 111, '我們與迷你自行車部件制造商kitaco和著名的懸掛部件制造商gears合作開發了這一產品。 新的懸掛系統是與kitaco和齒輪合作開發的。 通過騎行高度調節、回彈阻尼力調節和預緊力調節機制，可以根據情況進行廣泛設置。', 'https://webike-cdn-net.azureedge.net/catalogue/images/94257/520-1300100_3.jpg', 2),
(6, 'STYLEMA 煞車卡鉗套件 (30 / 100mm) / APRILIA RSV4等車型可用', 26202, 116, '【活塞直徑】30mm（同直徑4pot） 【安裝間距】100mm 【重量】約865g（包括剎車片）', 'https://webike-cdn-net.azureedge.net/catalogue/images/93034/220-d020-10.jpg', 2),
(7, '排氣管', 38724, 414, '品牌： K-FACTORY', 'https://webike-cdn-net.azureedge.net/catalogue/images/86191/kfac3.jpg', 3);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `userRealName` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` int(11) NOT NULL COMMENT '身分(1:管理員 2:一般用戶)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`u_id`, `userRealName`, `username`, `password`, `role`) VALUES
(1, '01', 'admin', '$2y$10$UnOPTT3MnTqNO.7wlIKLUOmtscxSF.g50fCHAnYm/KIwxjW988kQS', 1),
(2, '11', 'test01', '$2y$10$8yZdQsBIqxI85DE28QRep.dfS5mGIgxv3axZr2einQN5spKCu9S12', 2),
(3, '阿菜3123', 'test02', '$2y$10$RQTc8gwlLO/CAZT3xN0rx.MXNjjB6A/RJukDsIJOHJcS9DsZUGKE6', 2);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cartID`);

--
-- 資料表索引 `orderDetail`
--
ALTER TABLE `orderDetail`
  ADD PRIMARY KEY (`detailID`);

--
-- 資料表索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- 資料表索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `carts`
--
ALTER TABLE `carts`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `orderDetail`
--
ALTER TABLE `orderDetail`
  MODIFY `detailID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
