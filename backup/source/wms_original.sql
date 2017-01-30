-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2017-01-30 07:23:15
-- 伺服器版本: 10.1.19-MariaDB
-- PHP 版本： 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `wms`
--

-- --------------------------------------------------------

--
-- 資料表結構 `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL COMMENT '客戶ID',
  `customer_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '客戶名',
  `customer_tel1` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電話1',
  `customer_tel2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電話2',
  `customer_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手機',
  `customer_fax` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '傳真號碼',
  `customer_address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地址',
  `serial_numbers` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '統一編號',
  `is_del` tinyint(1) NOT NULL,
  `createtime` datetime NOT NULL COMMENT '建立日期',
  `updatetime` datetime NOT NULL COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客戶資料表';

-- --------------------------------------------------------

--
-- 資料表結構 `history`
--

CREATE TABLE `history` (
  `history_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `history_type` tinyint(3) UNSIGNED NOT NULL COMMENT '0進貨, 1出貨, 2銷退',
  `history_serial` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '單號',
  `process_date` date NOT NULL COMMENT '出貨/進貨/銷貨日',
  `serial_numbers` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '發票號碼',
  `customer_id` int(11) NOT NULL COMMENT '客戶ID',
  `total_price` int(11) NOT NULL COMMENT '價格',
  `remark` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '備註',
  `createtime` datetime NOT NULL,
  `updatetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `history_detail`
--

CREATE TABLE `history_detail` (
  `hd_id` int(10) UNSIGNED NOT NULL,
  `history_id` int(10) UNSIGNED NOT NULL COMMENT '對應單號序號',
  `price` int(11) NOT NULL COMMENT '商品價格',
  `item_id` int(11) NOT NULL COMMENT '商品ID',
  `item_count` int(11) NOT NULL COMMENT '商品數量',
  `total_price` int(11) NOT NULL,
  `createtime` datetime NOT NULL COMMENT '建立時間',
  `updatetime` datetime NOT NULL COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名稱',
  `item_serial` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品序號',
  `item_type` tinyint(4) NOT NULL,
  `primary_price` int(11) NOT NULL COMMENT '成本價'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `userId` int(10) UNSIGNED NOT NULL,
  `account` varchar(50) NOT NULL COMMENT '帳號',
  `name` varchar(100) NOT NULL COMMENT '姓名',
  `password` varchar(100) NOT NULL COMMENT '密碼',
  `privateKey` varchar(100) NOT NULL COMMENT '私用key',
  `createTime` datetime NOT NULL COMMENT '建立時間',
  `isActive` smallint(1) NOT NULL COMMENT '-1 刪除, 0 未啟用, 1 啟用, 2 管理者',
  `updateTime` datetime NOT NULL COMMENT '最後活動時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='使用者資料表';

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`userId`, `account`, `name`, `password`, `privateKey`, `createTime`, `isActive`, `updateTime`) VALUES
(1, 'root001', '先鋒', '662db5063d1123d576c5b5e0ce356eac65508e91', '9868', '2016-10-17 00:00:00', 2, '2017-01-30 11:50:39'),
(2, 'root002', '開票', '1c6dd268ea6ad9cbfedd144878adea50256fc279', '2063', '2016-10-17 09:13:38', 2, '2017-01-30 11:50:50'),
(3, 'root003', '零件', 'a3a24b538eebc14eca11b7f0284e90e9efb0a3ce', '7809', '2016-10-17 14:28:31', 2, '2017-01-30 11:51:00'),
(4, 'root004', 'test', '57461b127f24bcbfa52bc84de25a5b257b9a39d1', '1746', '2016-10-17 14:31:16', 0, '2017-01-30 11:51:15');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `customer_name` (`customer_name`),
  ADD KEY `customer_address` (`customer_address`(191)),
  ADD KEY `customer_tel1` (`customer_tel1`,`customer_tel2`,`customer_phone`,`customer_fax`),
  ADD KEY `createtime` (`createtime`);

--
-- 資料表索引 `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `createtime` (`createtime`),
  ADD KEY `process_date` (`process_date`),
  ADD KEY `history_serial` (`history_serial`),
  ADD KEY `serial_numbers` (`serial_numbers`),
  ADD KEY `customer_id` (`customer_id`);

--
-- 資料表索引 `history_detail`
--
ALTER TABLE `history_detail`
  ADD PRIMARY KEY (`hd_id`),
  ADD KEY `history_id` (`history_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `createtime` (`createtime`);

--
-- 資料表索引 `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `item_serial` (`item_serial`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `account` (`account`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客戶ID';
--
-- 使用資料表 AUTO_INCREMENT `history`
--
ALTER TABLE `history`
  MODIFY `history_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `history_detail`
--
ALTER TABLE `history_detail`
  MODIFY `hd_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
