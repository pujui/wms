-- MySQL dump 10.16  Distrib 10.1.19-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.19-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客戶ID',
  `customer_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '客戶名',
  `customer_tel1` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電話1',
  `customer_tel2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電話2',
  `customer_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手機',
  `customer_fax` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '傳真號碼',
  `customer_address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地址',
  `serial_numbers` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '統一編號',
  `is_del` tinyint(1) NOT NULL,
  `createtime` datetime NOT NULL COMMENT '建立日期',
  `updatetime` datetime NOT NULL COMMENT '更新日期',
  PRIMARY KEY (`customer_id`),
  KEY `customer_name` (`customer_name`),
  KEY `customer_address` (`customer_address`(191)),
  KEY `customer_tel1` (`customer_tel1`),
  KEY `customer_tel2` (`customer_tel2`),
  KEY `customer_phone` (`customer_phone`),
  KEY `customer_fax` (`customer_fax`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客戶資料表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `history_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `history_type` tinyint(3) unsigned NOT NULL COMMENT '0進貨, 1出貨, 2銷退',
  `history_serial` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '單號',
  `process_date` date NOT NULL COMMENT '出貨/進貨/銷貨日',
  `serial_numbers` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '發票號碼',
  `customer_id` int(11) NOT NULL COMMENT '客戶ID',
  `total_price` int(11) NOT NULL COMMENT '價格',
  `remark` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '備註',
  `createtime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_detail`
--

DROP TABLE IF EXISTS `history_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history_detail` (
  `hd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `history_id` int(10) unsigned NOT NULL COMMENT '對應單號序號',
  `price` int(11) NOT NULL COMMENT '商品價格',
  `item_id` int(11) NOT NULL COMMENT '商品ID',
  `item_count` int(11) NOT NULL COMMENT '商品數量',
  `total_price` int(11) NOT NULL,
  `item_sn` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品序號',
  `createtime` datetime NOT NULL COMMENT '建立時間',
  `updatetime` datetime NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`hd_id`),
  KEY `item_sn` (`item_sn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_detail`
--

LOCK TABLES `history_detail` WRITE;
/*!40000 ALTER TABLE `history_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `history_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名稱',
  `item_serial` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品序號',
  `item_type` tinyint(4) NOT NULL,
  `primary_price` int(11) NOT NULL COMMENT '成本價',
  `sell_price` int(11) NOT NULL COMMENT '販售價',
  PRIMARY KEY (`item_id`),
  KEY `item_serial` (`item_serial`),
  KEY `item_name` (`item_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) NOT NULL COMMENT '帳號',
  `name` varchar(100) NOT NULL COMMENT '姓名',
  `password` varchar(100) NOT NULL COMMENT '密碼',
  `privateKey` varchar(100) NOT NULL COMMENT '私用key',
  `createTime` datetime NOT NULL COMMENT '建立時間',
  `isActive` smallint(1) NOT NULL COMMENT '-1 刪除, 0 未啟用, 1 啟用, 2 管理者',
  `updateTime` datetime NOT NULL COMMENT '最後活動時間',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='使用者資料表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'root001','先鋒','662db5063d1123d576c5b5e0ce356eac65508e91','9868','2016-10-17 00:00:00',2,'2017-01-30 11:50:39'),(2,'root002','開票','1c6dd268ea6ad9cbfedd144878adea50256fc279','2063','2016-10-17 09:13:38',2,'2017-01-30 11:50:50'),(3,'root003','零件','a3a24b538eebc14eca11b7f0284e90e9efb0a3ce','7809','2016-10-17 14:28:31',2,'2017-01-30 11:51:00'),(4,'root004','test','57461b127f24bcbfa52bc84de25a5b257b9a39d1','1746','2016-10-17 14:31:16',0,'2017-01-30 11:51:15');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-31 11:45:35
