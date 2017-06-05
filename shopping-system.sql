-- MySQL dump 10.15  Distrib 10.0.17-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: shopping
-- ------------------------------------------------------
-- Server version	10.0.17-MariaDB

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
-- Table structure for table `ss_attribute`
--

DROP TABLE IF EXISTS `ss_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_attribute` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `attr_name` varchar(30) NOT NULL COMMENT '属性名称',
  `attr_type` enum('唯一','可选') NOT NULL COMMENT '属性类型',
  `attr_option_values` varchar(300) NOT NULL DEFAULT '' COMMENT '属性可选值',
  `type_id` mediumint(8) unsigned NOT NULL COMMENT '所属类型Id',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='属性表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_attribute`
--

LOCK TABLES `ss_attribute` WRITE;
/*!40000 ALTER TABLE `ss_attribute` DISABLE KEYS */;
INSERT INTO `ss_attribute` VALUES (1,'颜色','可选','白色,黑色,绿色,紫色,蓝色,金色,银色,粉色,富士白',1),(3,'出版社','唯一','人民大学出版社,清华大学出版社,工业大学出版社',3),(4,'出厂日期','唯一','',1),(5,'操作系统','可选','ios,android,windows',1),(6,'页数','唯一','',3),(7,'作者','唯一','',3),(8,'材质','唯一','',2),(9,'尺码','可选','M,XL,XXL,XXXL,XXXXL',2),(10,'屏幕尺寸','唯一','',1);
/*!40000 ALTER TABLE `ss_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_brand`
--

DROP TABLE IF EXISTS `ss_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_brand` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `brand_name` varchar(30) NOT NULL COMMENT '品牌名称',
  `site_url` varchar(150) NOT NULL DEFAULT '' COMMENT '官方网址',
  `brand_desc` longtext,
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '品牌Logo图片',
  `sm_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '品牌Logo图片sm',
  `is_show` enum('否','是') NOT NULL DEFAULT '是' COMMENT '是否显示',
  `sort_num` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `brand_name` (`brand_name`) USING BTREE,
  KEY `is_show` (`is_show`) USING BTREE,
  KEY `sort_num` (`sort_num`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='品牌';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_brand`
--

LOCK TABLES `ss_brand` WRITE;
/*!40000 ALTER TABLE `ss_brand` DISABLE KEYS */;
INSERT INTO `ss_brand` VALUES (2,'苹果','www.apple.com','&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;color:#ff0000&quot;&gt;苹果，不是吃的那种！&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;','Public/Uploads/brand/2017-05-29/592bf0cbcc985.jpg','Public/Uploads/brand/2017-05-29/thumb_sm_592bf0cbcc985.jpg','是',10),(3,'小米','www.mi.com','','Public/Uploads/brand/2017-05-29/592bf0e4db1a5.jpg','Public/Uploads/brand/2017-05-29/thumb_sm_592bf0e4db1a5.jpg','是',2),(4,'三星','www.samsung.com','','Public/Uploads/brand/2017-05-29/592bf0eeab83e.jpg','Public/Uploads/brand/2017-05-29/thumb_sm_592bf0eeab83e.jpg','是',5),(5,'华为','www.huawei.com','','Public/Uploads/brand/2017-05-29/592bf0f6073b1.jpg','Public/Uploads/brand/2017-05-29/thumb_sm_592bf0f6073b1.jpg','是',3),(6,'酷派','www.coolpad.com','','Public/Uploads/brand/2017-05-29/592bf0ff25bd1.jpg','Public/Uploads/brand/2017-05-29/thumb_sm_592bf0ff25bd1.jpg','是',4),(7,'联想','www.lenovo.com','&lt;p&gt;联想，专注于做电脑笔记本行业，行业巨头！&lt;/p&gt;','Public/Uploads/brand/2017-05-29/592bf10b4ee4a.jpg','Public/Uploads/brand/2017-05-29/thumb_sm_592bf10b4ee4a.jpg','是',0);
/*!40000 ALTER TABLE `ss_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_cart`
--

DROP TABLE IF EXISTS `ss_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_cart` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  `goods_attr_id` varchar(150) NOT NULL DEFAULT '' COMMENT '商品属性Id',
  `goods_number` mediumint(8) unsigned NOT NULL COMMENT '购买的数量',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员Id',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='购物车';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_cart`
--

LOCK TABLES `ss_cart` WRITE;
/*!40000 ALTER TABLE `ss_cart` DISABLE KEYS */;
INSERT INTO `ss_cart` VALUES (14,7,'2,6',1,1);
/*!40000 ALTER TABLE `ss_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_category`
--

DROP TABLE IF EXISTS `ss_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `cat_name` varchar(30) NOT NULL COMMENT '分类名称',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类的Id,0:顶级分类',
  `is_show` enum('是','否') NOT NULL DEFAULT '是' COMMENT '是否显示',
  `is_floor` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否推荐楼层',
  `sort_num` mediumint(3) NOT NULL COMMENT '排序',
  `keywords` varchar(30) NOT NULL DEFAULT '' COMMENT '关键词',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_category`
--

LOCK TABLES `ss_category` WRITE;
/*!40000 ALTER TABLE `ss_category` DISABLE KEYS */;
INSERT INTO `ss_category` VALUES (1,'家用电器',0,'是','是',0,'大电器'),(2,'手机、数码、京东通信',0,'是','是',0,''),(3,'电脑、办公',0,'是','是',0,''),(4,'家居、家具、家装、厨具',0,'是','是',0,''),(5,'男装、女装、内衣、珠宝',0,'否','是',0,''),(6,'个护化妆',0,'是','否',0,''),(8,'运动户外',0,'是','否',0,''),(9,'汽车、汽车用品',0,'是','否',0,''),(10,'母婴、玩具乐器',0,'是','否',0,''),(11,'食品、酒类、生鲜、特产',0,'是','否',0,''),(12,'营养保健',0,'是','是',0,''),(13,'图书、音像、电子书',0,'是','否',0,''),(14,'彩票、旅行、充值、票务',0,'是','否',0,''),(16,'大家电',1,'是','是',1,'大家电'),(17,'生活电器',1,'是','是',0,''),(18,'厨房电器',1,'是','是',0,''),(19,'个护健康',1,'是','是',0,''),(20,'五金家装',1,'是','是',0,''),(21,'iphone',2,'是','是',0,''),(22,'冰箱',16,'是','是',100,'冰箱'),(25,'手机配件',2,'是','是',0,''),(26,'摄影摄像',2,'是','是',0,''),(27,'节能汽车',9,'是','是',0,''),(28,'T恤',5,'是','是',12,''),(29,'烟酒',11,'是','是',12,'礼品，烟酒');
/*!40000 ALTER TABLE `ss_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_comment`
--

DROP TABLE IF EXISTS `ss_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_comment` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员Id',
  `content` varchar(200) NOT NULL COMMENT '内容',
  `addtime` datetime NOT NULL COMMENT '发表时间',
  `star` tinyint(3) unsigned NOT NULL COMMENT '分值',
  `click_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '有用的数字',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COMMENT='评论';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_comment`
--

LOCK TABLES `ss_comment` WRITE;
/*!40000 ALTER TABLE `ss_comment` DISABLE KEYS */;
INSERT INTO `ss_comment` VALUES (1,4,1,'测试','2015-10-28 09:40:55',5,0),(2,4,1,'测试','2015-10-28 09:41:25',4,0),(3,4,1,'测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试v','2015-10-28 09:41:53',4,0),(4,4,1,'formformformformformform','2015-10-28 09:43:26',4,0),(5,4,1,'fdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasfdasf','2015-10-28 09:43:40',3,0),(6,4,1,'1233212','2015-10-28 09:43:57',5,0),(7,4,1,'测试一下！！','2015-10-28 09:54:28',4,0),(8,4,1,'再测试一下！！','2015-10-28 09:55:22',1,0),(9,4,1,'再评论五！！','2015-10-28 09:56:25',2,0),(10,4,1,'123','2015-10-28 09:56:30',4,0),(11,4,1,'53645','2015-10-28 09:56:34',3,0),(12,4,1,'6576','2015-10-28 09:56:39',1,0),(13,4,1,'45645','2015-10-28 09:56:42',3,0),(14,4,1,'65576565','2015-10-28 09:56:45',2,0),(15,4,1,'最新的评论！！@3','2015-10-28 09:56:55',4,0),(16,4,1,'最新的评论！@#1','2015-10-28 09:57:07',4,0),(17,4,1,'滚动起来！@#','2015-10-28 09:59:18',4,0),(18,4,1,'234432','2015-10-28 09:59:24',4,0),(19,4,1,'435554','2015-10-28 09:59:27',5,0),(20,4,1,'454545','2015-10-28 09:59:31',1,0),(21,4,1,'7687','2015-10-28 09:59:35',5,0),(22,4,1,'454565','2015-10-28 09:59:41',3,0),(23,4,1,'76687687','2015-10-28 09:59:45',2,0),(24,4,1,'滚动吧！','2015-10-28 09:59:54',5,0),(25,4,1,'！@#QEWQEWfdsa','2015-10-28 10:00:08',1,0),(26,4,1,'厅','2015-10-28 10:00:46',5,0),(27,4,1,'1231213','2015-10-28 10:03:24',5,0),(28,4,1,'342432','2015-10-28 10:03:29',5,0),(29,4,1,'4345','2015-10-28 10:03:35',5,0),(30,4,1,'56545','2015-10-28 10:03:40',5,0),(31,4,1,'砌墙左','2015-10-28 10:03:49',5,0),(32,4,1,'43我用脾','2015-10-28 10:04:01',3,0),(33,4,1,'sfdsafdas','2015-10-28 10:04:10',3,0),(34,4,1,'fdfdadf','2015-10-28 10:04:32',4,0),(35,4,1,'fdafdas','2015-10-28 10:04:50',5,0),(36,4,1,'4434343','2015-10-28 10:04:54',2,0),(37,4,1,'454545','2015-10-28 10:05:00',1,0),(38,4,1,'434343','2015-10-28 10:05:40',5,0),(39,4,1,'454545','2015-10-28 10:05:44',3,0),(40,4,1,'&lt;script&gt;alert(123132);&lt;/script&gt;','2015-10-28 10:05:59',5,0),(41,4,1,'&lt;script&gt;alert(123132);&lt;/script&gt;','2015-10-28 10:06:30',5,0),(42,4,1,'&lt;script&gt;alert(123132);&lt;/script&gt;','2015-10-28 10:06:38',3,0),(43,4,1,'fdsfdsaafds','2015-10-28 10:53:14',5,0),(44,4,1,'fafdadfs','2015-10-28 10:53:38',5,0),(45,4,1,'fdsfdsa','2015-10-28 10:53:58',5,0),(46,4,1,'fdasfd','2015-10-28 11:04:41',5,0),(47,4,1,'2132321','2015-10-28 11:17:07',5,0),(48,4,1,'印象数据的测试！！！','2015-10-28 15:00:44',3,0),(49,4,1,'再测试！！1·','2015-10-28 15:02:17',5,0),(50,4,1,'测试一下！！','2015-10-28 15:10:55',2,0),(51,4,1,'测试','2015-10-28 15:11:19',5,0),(52,4,1,'大棒 324324','2015-10-28 15:12:49',5,0),(53,4,1,'dfsaafds','2015-10-28 15:38:19',5,0),(54,4,1,'fdsafdsadsa','2015-10-28 15:38:51',5,0),(55,4,1,'fdfdsa','2015-10-28 15:44:26',5,0);
/*!40000 ALTER TABLE `ss_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_comment_reply`
--

DROP TABLE IF EXISTS `ss_comment_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_comment_reply` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `comment_id` mediumint(8) unsigned NOT NULL COMMENT '评论Id',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员Id',
  `content` varchar(200) NOT NULL COMMENT '内容',
  `addtime` datetime NOT NULL COMMENT '发表时间',
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='评论回复';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_comment_reply`
--

LOCK TABLES `ss_comment_reply` WRITE;
/*!40000 ALTER TABLE `ss_comment_reply` DISABLE KEYS */;
INSERT INTO `ss_comment_reply` VALUES (1,54,1,'回复！！','2015-10-28 16:19:54'),(2,54,1,'回复！！！','2015-10-28 16:22:37'),(3,54,1,'回复一下1！！','2015-10-28 16:33:59'),(4,54,1,'再回复现代战争！！！','2015-10-28 16:34:09'),(5,54,1,'苷械  苷械  苷械  苷械  苷械  苷械','2015-10-28 16:34:16'),(6,54,1,'口口口口口口口口中','2015-10-28 16:34:44'),(7,52,1,'发表个回复试试','2015-10-28 16:43:23'),(8,53,1,'yuyuyuyuyu','2015-10-28 16:43:58'),(9,51,1,'ohjgfsdf','2015-10-28 16:44:16');
/*!40000 ALTER TABLE `ss_comment_reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_goods`
--

DROP TABLE IF EXISTS `ss_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `goods_name` varchar(150) NOT NULL COMMENT '商品名称',
  `market_price` decimal(10,2) NOT NULL COMMENT '市场价格',
  `shop_price` decimal(10,2) NOT NULL COMMENT '本店价格',
  `goods_desc` longtext COMMENT '商品描述',
  `is_on_sale` enum('是','否') NOT NULL DEFAULT '是' COMMENT '是否上架',
  `is_delete` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否放到回收站',
  `updtime` datetime NOT NULL,
  `addtime` datetime NOT NULL COMMENT '添加时间',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '原图',
  `sm_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '小图',
  `mid_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '中图',
  `big_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '大图',
  `mbig_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '更大图',
  `brand_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '品牌id',
  `cat_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '主分类Id',
  `type_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '类型Id',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `promote_start_date` datetime NOT NULL COMMENT '促销开始时间',
  `promote_end_date` datetime NOT NULL COMMENT '促销结束时间',
  `is_new` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否新品',
  `is_hot` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否热卖',
  `is_best` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否精品',
  `sort_num` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '排序的数字',
  `is_floor` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否推荐楼层',
  `goods_number` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品库存',
  `goods_sn` varchar(13) NOT NULL DEFAULT '0000000000000' COMMENT '货号',
  `is_updated` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否被修改',
  PRIMARY KEY (`id`),
  KEY `shop_price` (`shop_price`),
  KEY `addtime` (`addtime`),
  KEY `brand_id` (`brand_id`),
  KEY `is_on_sale` (`is_on_sale`),
  KEY `cat_id` (`cat_id`) USING BTREE,
  KEY `promote_price` (`promote_price`) USING BTREE,
  KEY `promote_start_date` (`promote_start_date`) USING BTREE,
  KEY `promote_end_date` (`promote_end_date`) USING BTREE,
  KEY `is_new` (`is_new`) USING BTREE,
  KEY `is_hot` (`is_hot`) USING BTREE,
  KEY `is_best` (`is_best`) USING BTREE,
  KEY `sort_num` (`sort_num`) USING BTREE,
  KEY `is_delete` (`is_delete`) USING BTREE,
  KEY `goods_sn` (`goods_sn`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COMMENT='商品';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_goods`
--

LOCK TABLES `ss_goods` WRITE;
/*!40000 ALTER TABLE `ss_goods` DISABLE KEYS */;
INSERT INTO `ss_goods` VALUES (2,'新的联想商品',123.00,5.00,'','是','否','2017-06-01 03:33:41','2015-10-15 14:48:03','Public/Uploads/Goods/2017-05-28/592a6c2eae566.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_592a6c2eae566.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_592a6c2eae566.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_592a6c2eae566.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_592a6c2eae566.jpg',7,3,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','否','否',100,'否',223,'1495952020',0),(3,'数码相机',111.00,112.00,'','是','否','2017-06-01 02:55:58','2015-10-15 16:05:05','Public/Uploads/Goods/2017-05-27/59297cc9524ae.jpg','Public/Uploads/Goods/2017-05-27/thumb_sm_59297cc9524ae.jpg','Public/Uploads/Goods/2017-05-27/thumb_mid_59297cc9524ae.jpg','Public/Uploads/Goods/2017-05-27/thumb_big_59297cc9524ae.jpg','Public/Uploads/Goods/2017-05-27/thumb_mbig_59297cc9524ae.jpg',2,3,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','否','否',100,'是',111,'1495951945sss',0),(4,'彩虹电视',0.00,50.00,'','是','否','2017-06-01 02:36:32','2015-10-16 14:56:41','Public/Uploads/Goods/2017-05-28/592a6c39a2d31.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_592a6c39a2d31.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_592a6c39a2d31.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_592a6c39a2d31.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_592a6c39a2d31.jpg',7,16,1,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','否','否',120,'否',0,'1495952025',0),(6,'耳机',444.00,333.00,'','是','否','2017-06-01 02:36:38','2015-10-16 11:02:08','Public/Uploads/Goods/2017-05-27/592988b123801.jpg','Public/Uploads/Goods/2017-05-27/thumb_sm_592988b123801.jpg','Public/Uploads/Goods/2017-05-27/thumb_mid_592988b123801.jpg','Public/Uploads/Goods/2017-05-27/thumb_big_592988b123801.jpg','Public/Uploads/Goods/2017-05-27/thumb_mbig_592988b123801.jpg',3,16,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','是','是',105,'是',333,'1495952032',0),(7,'商品属性测试',113.00,111.00,'','是','否','2017-06-01 02:36:42','2015-10-18 14:48:28','Public/Uploads/Goods/2017-05-28/592a6c43458be.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_592a6c43458be.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_592a6c43458be.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_592a6c43458be.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_592a6c43458be.jpg',3,16,1,101.00,'2015-10-21 00:01:00','2015-10-23 00:00:00','否','否','否',110,'是',0,'1495952038',0),(45,'滑盖手机',0.00,1111.00,'','是','否','2017-06-01 02:43:58','2017-05-26 00:19:33','Public/Uploads/Goods/2017-05-28/592a59cacc83c.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_592a59cacc83c.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_592a59cacc83c.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_592a59cacc83c.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_592a59cacc83c.jpg',4,26,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','否','否',100,'否',0,'1495952045',0),(46,'翻盖大手机',0.00,1111.00,'','是','否','2017-06-01 03:03:16','2017-05-26 00:20:32','Public/Uploads/Goods/2017-05-28/592a59d2e8b36.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_592a59d2e8b36.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_592a59d2e8b36.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_592a59d2e8b36.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_592a59d2e8b36.jpg',2,26,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','否','是',100,'否',0,'1495952070',0),(47,'平板手机',0.00,2312.00,'','是','否','2017-06-01 03:03:34','2017-05-26 00:31:27','Public/Uploads/Goods/2017-05-28/5929c3b5f0345.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_5929c3b5f0345.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_5929c3b5f0345.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_5929c3b5f0345.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_5929c3b5f0345.jpg',4,2,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','否','否',100,'否',0,'1495952079',0),(49,'翻盖手机',121.00,1213.00,'','是','否','2017-05-31 14:44:49','2017-05-26 02:21:05','Public/Uploads/Goods/2017-05-28/5929c392b84b1.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_5929c392b84b1.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_5929c392b84b1.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_5929c392b84b1.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_5929c392b84b1.jpg',3,2,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','是','是',100,'否',88,'0001495736465',0),(57,'诺基亚手机',0.00,2222.00,'','是','否','2017-05-31 14:45:01','2017-05-26 22:54:41','Public/Uploads/Goods/2017-05-28/592a59dc264dc.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_592a59dc264dc.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_592a59dc264dc.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_592a59dc264dc.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_592a59dc264dc.jpg',5,26,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','是','否',100,'否',0,'0001495810481',0),(58,'智能手机',0.00,22221.00,'','是','否','2017-05-31 14:38:26','2017-05-26 22:55:55','Public/Uploads/Goods/2017-05-28/592a59f2a006c.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_592a59f2a006c.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_592a59f2a006c.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_592a59f2a006c.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_592a59f2a006c.jpg',5,16,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','是','是',100,'否',0,'0001495810555',0),(59,'小灵通',0.00,121122.00,'','是','否','2017-06-01 03:05:27','2017-05-26 22:56:30','Public/Uploads/Goods/2017-05-28/5929a8eed7075.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_5929a8eed7075.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_5929a8eed7075.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_5929a8eed7075.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_5929a8eed7075.jpg',6,22,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','否','否',100,'否',0,'0000000000010',0),(60,'12212121',0.00,121.00,'','否','否','2017-05-28 13:02:53','2017-05-27 17:12:03','Public/Uploads/Goods/2017-05-28/592a59fdc620b.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_592a59fdc620b.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_592a59fdc620b.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_592a59fdc620b.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_592a59fdc620b.jpg',2,23,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','否','是',100,'否',0,'0001495876323',0),(61,'ffffff',22222.00,222.00,'<p>2222</p>','是','否','2017-05-31 12:55:56','2017-05-27 17:17:31','Public/Uploads/Goods/2017-05-31/592e4cdc59e6d.jpg','Public/Uploads/Goods/2017-05-31/thumb_sm_592e4cdc59e6d.jpg','Public/Uploads/Goods/2017-05-31/thumb_mid_592e4cdc59e6d.jpg','Public/Uploads/Goods/2017-05-31/thumb_big_592e4cdc59e6d.jpg','Public/Uploads/Goods/2017-05-31/thumb_mbig_592e4cdc59e6d.jpg',5,14,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','否','是',100,'否',444,'0001495876651',0),(62,'2222222222',1111.00,2222.00,'','是','否','2017-05-28 19:54:36','2017-05-27 17:17:56','Public/Uploads/Goods/2017-05-28/592aba7cc0db0.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_592aba7cc0db0.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_592aba7cc0db0.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_592aba7cc0db0.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_592aba7cc0db0.jpg',4,19,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','否','否',100,'否',77,'0001495876676',0),(63,'jjjjjjjjjjjjjj',2222.00,22222.00,'<p>2222</p>','是','否','2017-05-28 19:55:34','2017-05-27 17:19:26','Public/Uploads/Goods/2017-05-27/592952c63f263.jpg','Public/Uploads/Goods/2017-05-27/thumb_sm_592952c63f263.jpg','Public/Uploads/Goods/2017-05-27/thumb_mid_592952c63f263.jpg','Public/Uploads/Goods/2017-05-27/thumb_big_592952c63f263.jpg','Public/Uploads/Goods/2017-05-27/thumb_mbig_592952c63f263.jpg',6,9,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','否','否',100,'否',111,'0001495876766',0),(64,'手机',1199.00,999.00,'','是','否','2017-05-28 02:18:52','2017-05-27 21:58:11','Public/Uploads/Goods/2017-05-28/5929c30cbc3b9.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_5929c30cbc3b9.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_5929c30cbc3b9.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_5929c30cbc3b9.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_5929c30cbc3b9.jpg',3,2,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','否','否',100,'否',123,'0001495893491',0),(65,'少时诵诗书',0.00,2222.00,'','是','否','2017-05-28 01:03:42','2017-05-27 22:25:23','Public/Uploads/Goods/2017-05-27/59298c5325410.jpg','Public/Uploads/Goods/2017-05-27/thumb_sm_59298c5325410.jpg','Public/Uploads/Goods/2017-05-27/thumb_mid_59298c5325410.jpg','Public/Uploads/Goods/2017-05-27/thumb_big_59298c5325410.jpg','Public/Uploads/Goods/2017-05-27/thumb_mbig_59298c5325410.jpg',4,1,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','是','是',100,'否',33,'0001495895123',0),(68,'轮椅',2222.00,1111.00,'','是','否','2017-06-01 01:58:23','2017-05-28 13:55:50','Public/Uploads/Goods/2017-05-28/592a7f238e03d.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_592a7f238e03d.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_592a7f238e03d.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_592a7f238e03d.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_592a7f238e03d.jpg',3,4,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','否','是',100,'否',2,'0001495950950',0),(69,'宝马',543210.00,456789.00,'','是','否','0000-00-00 00:00:00','2017-05-28 14:03:26','','','','','',2,9,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','是','是',100,'否',12,'1495951406',0),(70,'奔驰',21312312.00,45134513.00,'','是','否','0000-00-00 00:00:00','2017-05-28 14:04:16','','','','','',0,9,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','否','是',100,'否',0,'asaf124513624',0),(71,'弧度电视机',0.00,222222.00,'','是','否','2017-05-28 15:55:40','2017-05-28 14:11:21','Public/Uploads/Goods/2017-05-28/592a827c7223f.jpg','Public/Uploads/Goods/2017-05-28/thumb_sm_592a827c7223f.jpg','Public/Uploads/Goods/2017-05-28/thumb_mid_592a827c7223f.jpg','Public/Uploads/Goods/2017-05-28/thumb_big_592a827c7223f.jpg','Public/Uploads/Goods/2017-05-28/thumb_mbig_592a827c7223f.jpg',0,16,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','否','否',100,'否',0,'ssssssss',0),(73,'眼霜',145.00,123.00,'','是','否','0000-00-00 00:00:00','2017-05-28 21:24:50','','','','','',0,6,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','是','是',100,'否',123,'1495977890',0),(74,'兰蔻',456.00,345.00,'','是','否','0000-00-00 00:00:00','2017-05-28 21:45:01','','','','','',0,6,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','是','是',100,'否',123,'1495979101',0),(75,'眉笔',789.00,231.00,'','是','否','0000-00-00 00:00:00','2017-05-28 21:48:02','','','','','',0,6,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','是','是',100,'否',0,'1495979282',0),(76,'酷睿冰雪精灵',0.00,5678.00,'','是','否','0000-00-00 00:00:00','2017-05-28 21:50:46','','','','','',0,3,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','否','是',100,'否',0,'1495979446',0),(77,'酷睿冰雪精灵1',0.00,5678.00,'','是','否','2017-06-01 03:20:02','2017-05-28 21:51:44','','','','','',0,3,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','否','是',100,'否',0,'1495979504',0),(78,'水水水水',0.00,12.00,'','是','否','2017-06-01 03:13:43','2017-05-28 22:01:00','','','','','',0,1,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','否','否',100,'否',0,'1495980060',0),(82,'点点滴滴',0.00,123.00,'','是','否','2017-06-01 03:30:53','2017-05-28 22:03:43','','','','','',0,26,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','否','是',100,'否',0,'1495980223',0),(88,'Safari',0.00,1212.00,'','是','否','0000-00-00 00:00:00','2017-05-28 22:24:26','','','','','',0,18,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','否','否',100,'否',0,'1495981466',0),(100,'凤凰军事',0.00,141.00,'','是','否','0000-00-00 00:00:00','2017-05-31 17:09:54','','','','','',0,17,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','否','否','否',100,'否',0,'1496221794',0),(105,'测试商品',4321.00,3456.00,'','是','否','2017-05-31 17:20:22','2017-05-31 17:18:47','Public/Uploads/Goods/2017-05-31/592e8ab5ac925.png','Public/Uploads/Goods/2017-05-31/thumb_sm_592e8ab5ac925.png','Public/Uploads/Goods/2017-05-31/thumb_mid_592e8ab5ac925.png','Public/Uploads/Goods/2017-05-31/thumb_big_592e8ab5ac925.png','Public/Uploads/Goods/2017-05-31/thumb_mbig_592e8ab5ac925.png',0,4,0,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','是','否','否',100,'否',0,'1496222401',0);
/*!40000 ALTER TABLE `ss_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_goods_attr`
--

DROP TABLE IF EXISTS `ss_goods_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_goods_attr` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `attr_value` varchar(150) NOT NULL DEFAULT '' COMMENT '属性值',
  `attr_id` mediumint(8) unsigned NOT NULL COMMENT '属性Id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='商品属性';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_goods_attr`
--

LOCK TABLES `ss_goods_attr` WRITE;
/*!40000 ALTER TABLE `ss_goods_attr` DISABLE KEYS */;
INSERT INTO `ss_goods_attr` VALUES (1,'白色',1,7),(2,'黑色',1,7),(3,'绿色',1,7),(4,'2015-10-01',4,7),(5,'ios',5,7),(6,'android',5,7),(7,'14寸',10,7),(8,'黑色',1,10),(9,'',4,10),(10,'android',5,10),(11,'',10,10),(12,'银色',1,6),(13,'粉色',1,6),(14,'2014-10-1',4,6),(15,'ios',5,6),(16,'android',5,6),(17,'6.6寸',10,6),(18,'白色',1,11),(19,'2014-10-1',4,11),(20,'ios',5,11),(21,'12寸',10,11);
/*!40000 ALTER TABLE `ss_goods_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_goods_cat`
--

DROP TABLE IF EXISTS `ss_goods_cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_goods_cat` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  `cat_id` mediumint(8) unsigned NOT NULL COMMENT '分类id',
  PRIMARY KEY (`goods_id`,`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品扩展分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_goods_cat`
--

LOCK TABLES `ss_goods_cat` WRITE;
/*!40000 ALTER TABLE `ss_goods_cat` DISABLE KEYS */;
INSERT INTO `ss_goods_cat` VALUES (2,17),(3,25),(4,16),(4,17),(4,20),(6,4),(6,6),(6,19),(100,4),(100,9),(105,17),(105,18);
/*!40000 ALTER TABLE `ss_goods_cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_goods_number`
--

DROP TABLE IF EXISTS `ss_goods_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_goods_number` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  `goods_number` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '库存量',
  `goods_attr_id` varchar(150) NOT NULL COMMENT '商品属性表的ID,如果有多个，就用程序拼成字符串存到这个字段中',
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存量';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_goods_number`
--

LOCK TABLES `ss_goods_number` WRITE;
/*!40000 ALTER TABLE `ss_goods_number` DISABLE KEYS */;
INSERT INTO `ss_goods_number` VALUES (7,0,'1,5'),(7,3109,'2,5'),(7,439,'3,5'),(7,665,'1,6'),(7,415,'2,6'),(7,119,'3,6'),(3,95,''),(4,0,'');
/*!40000 ALTER TABLE `ss_goods_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_goods_pic`
--

DROP TABLE IF EXISTS `ss_goods_pic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_goods_pic` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `pic` varchar(150) NOT NULL COMMENT '原图',
  `sm_pic` varchar(150) NOT NULL COMMENT '小图',
  `mid_pic` varchar(150) NOT NULL COMMENT '中图',
  `big_pic` varchar(150) NOT NULL COMMENT '大图',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='商品相册';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_goods_pic`
--

LOCK TABLES `ss_goods_pic` WRITE;
/*!40000 ALTER TABLE `ss_goods_pic` DISABLE KEYS */;
INSERT INTO `ss_goods_pic` VALUES (15,'Public/Uploads/Goods/2017-05-31/592e8a7809aee.jpg','Public/Uploads/Goods/2017-05-31/thumb_sm_592e8a7809aee.jpg','Public/Uploads/Goods/2017-05-31/thumb_mid_592e8a7809aee.jpg','Public/Uploads/Goods/2017-05-31/thumb_big_592e8a7809aee.jpg',105);
/*!40000 ALTER TABLE `ss_goods_pic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_manager`
--

DROP TABLE IF EXISTS `ss_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_manager` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_manager`
--

LOCK TABLES `ss_manager` WRITE;
/*!40000 ALTER TABLE `ss_manager` DISABLE KEYS */;
INSERT INTO `ss_manager` VALUES (1,'root','63a9f0ea7bb98050796b649e85481845'),(2,'admin','21232f297a57a5a743894a0e4a801fc3'),(3,'xiaoming','97304531204ef7431330c20427d95481');
/*!40000 ALTER TABLE `ss_manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_manager_role`
--

DROP TABLE IF EXISTS `ss_manager_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_manager_role` (
  `manager_id` mediumint(8) unsigned NOT NULL COMMENT '管理员id',
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色id',
  KEY `manager_id` (`manager_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员角色';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_manager_role`
--

LOCK TABLES `ss_manager_role` WRITE;
/*!40000 ALTER TABLE `ss_manager_role` DISABLE KEYS */;
INSERT INTO `ss_manager_role` VALUES (3,1),(4,2);
/*!40000 ALTER TABLE `ss_manager_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_member`
--

DROP TABLE IF EXISTS `ss_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_member` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `face` varchar(150) NOT NULL DEFAULT '' COMMENT '头像',
  `sm_face` varchar(150) NOT NULL DEFAULT '' COMMENT '头像缩略图',
  `jifen` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='会员';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_member`
--

LOCK TABLES `ss_member` WRITE;
/*!40000 ALTER TABLE `ss_member` DISABLE KEYS */;
INSERT INTO `ss_member` VALUES (1,'php39','e10adc3949ba59abbe56e057f20f883e','Public/Uploads/user/2017-05-29/592bc85702aa8.jpg','Public/Uploads/user/2017-05-29/thumb_sm_592bc85702aa8.jpg',15000),(3,'admin','21232f297a57a5a743894a0e4a801fc3','Public/Uploads/user/2017-05-29/592bc869134d4.jpg','Public/Uploads/user/2017-05-29/thumb_sm_592bc869134d4.jpg',1222),(4,'ceshi','cc17c30cd111c7215fc8f51f8790e0e1','Public/Uploads/user/2017-05-29/592bc87a64e90.jpg','Public/Uploads/user/2017-05-29/thumb_sm_592bc87a64e90.jpg',1111),(5,'xiaoming','e10adc3949ba59abbe56e057f20f883e','Public/Uploads/user/2017-05-29/592bc8868990b.jpg','Public/Uploads/user/2017-05-29/thumb_sm_592bc8868990b.jpg',0),(6,'you','639bae9ac6b3e1a84cebb7b403297b79','Public/Uploads/user/2017-05-29/592bc8986887d.jpg','Public/Uploads/user/2017-05-29/thumb_sm_592bc8986887d.jpg',99999),(9,'lj','a25ce144a2d07d0dc3319bf4d9033ccd','Public/Uploads/user/2017-05-29/592bcf1513ac6.jpg','Public/Uploads/user/2017-05-29/thumb_sm_592bcf1513ac6.jpg',8888),(10,'33','e10adc3949ba59abbe56e057f20f883e','Public/Uploads/user/2017-05-29/592bcee2e3e97.jpg','Public/Uploads/user/2017-05-29/thumb_sm_592bcee2e3e97.jpg',0),(11,'44','e10adc3949ba59abbe56e057f20f883e','Public/Uploads/user/2017-05-29/592bceefca779.jpeg','Public/Uploads/user/2017-05-29/thumb_sm_592bceefca779.jpeg',0);
/*!40000 ALTER TABLE `ss_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_member_level`
--

DROP TABLE IF EXISTS `ss_member_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_member_level` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `level_name` varchar(30) NOT NULL COMMENT '级别名称',
  `jifen_bottom` mediumint(8) unsigned NOT NULL COMMENT '积分下限',
  `jifen_top` mediumint(8) unsigned NOT NULL COMMENT '积分上限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='会员级别';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_member_level`
--

LOCK TABLES `ss_member_level` WRITE;
/*!40000 ALTER TABLE `ss_member_level` DISABLE KEYS */;
INSERT INTO `ss_member_level` VALUES (1,'注册会员',0,5000),(2,'初级会员',5001,10000),(3,'高级会员',10001,20000),(4,'VIP',20001,16777215);
/*!40000 ALTER TABLE `ss_member_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_member_price`
--

DROP TABLE IF EXISTS `ss_member_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_member_price` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  `level_id` mediumint(8) unsigned NOT NULL COMMENT '级别Id',
  `price` decimal(10,2) NOT NULL COMMENT '会员价格',
  PRIMARY KEY (`goods_id`,`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员价格';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_member_price`
--

LOCK TABLES `ss_member_price` WRITE;
/*!40000 ALTER TABLE `ss_member_price` DISABLE KEYS */;
INSERT INTO `ss_member_price` VALUES (2,0,444.00),(2,1,222.00),(2,2,333.00),(2,3,123.00),(2,4,123.00),(3,1,112.00),(3,2,112.00),(3,3,112.00),(3,4,112.00),(4,1,50.00),(4,2,50.00),(4,3,50.00),(4,4,50.00),(6,1,333.00),(6,2,333.00),(6,3,333.00),(6,4,333.00),(7,1,120.00),(7,2,105.00),(7,3,95.00),(7,4,90.00),(45,1,1111.00),(45,2,1111.00),(45,3,1111.00),(45,4,1111.00),(46,1,1111.00),(46,2,1111.00),(46,3,1111.00),(46,4,1111.00),(47,1,2312.00),(47,2,2312.00),(47,3,2312.00),(47,4,2312.00),(59,1,121122.00),(59,2,121122.00),(59,3,121122.00),(59,4,121122.00),(77,0,5678.00),(77,1,5678.00),(77,2,5678.00),(77,3,5678.00),(77,4,5678.00),(78,1,12.00),(78,2,12.00),(78,3,12.00),(78,4,12.00),(82,0,123.00),(82,1,123.00),(82,2,123.00),(82,3,123.00),(82,4,123.00),(85,1,13.00),(85,2,13.00),(85,3,13.00),(85,4,13.00),(86,1,13.00),(86,2,13.00),(86,3,13.00),(86,4,13.00),(87,1,13.00),(87,2,13.00),(87,3,13.00),(87,4,13.00),(88,1,1000.00),(88,2,800.00),(88,3,600.00),(88,4,500.00),(89,1,123.00),(89,2,123.00),(89,3,123.00),(89,4,123.00),(100,1,141.00),(100,2,141.00),(100,3,141.00),(100,4,141.00),(105,1,3456.00),(105,2,3456.00),(105,3,3456.00),(105,4,3456.00);
/*!40000 ALTER TABLE `ss_member_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_order`
--

DROP TABLE IF EXISTS `ss_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_order` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员Id',
  `addtime` int(10) unsigned NOT NULL COMMENT '下单时间',
  `pay_status` enum('是','否') NOT NULL DEFAULT '否' COMMENT '支付状态',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `total_price` decimal(10,2) NOT NULL COMMENT '定单总价',
  `shr_name` varchar(30) NOT NULL COMMENT '收货人姓名',
  `shr_tel` varchar(30) NOT NULL COMMENT '收货人电话',
  `shr_province` varchar(30) NOT NULL COMMENT '收货人省',
  `shr_city` varchar(30) NOT NULL COMMENT '收货人城市',
  `shr_area` varchar(30) NOT NULL COMMENT '收货人地区',
  `shr_address` varchar(30) NOT NULL COMMENT '收货人详细地址',
  `post_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态,0:未发货,1:已发货2:已收到货',
  `post_number` varchar(30) NOT NULL DEFAULT '' COMMENT '快递号',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `addtime` (`addtime`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='定单基本信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_order`
--

LOCK TABLES `ss_order` WRITE;
/*!40000 ALTER TABLE `ss_order` DISABLE KEYS */;
INSERT INTO `ss_order` VALUES (2,1,1445655657,'是',0,3359.00,'吴英雷','13344441111','上海','东城区','西三旗','西三旗',0,''),(3,1,1445655771,'是',0,333.00,'吴英雷','13344441111','北京','东城区','三环以内','西三旗',0,'');
/*!40000 ALTER TABLE `ss_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_order_goods`
--

DROP TABLE IF EXISTS `ss_order_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_order_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `order_id` mediumint(8) unsigned NOT NULL COMMENT '定单Id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  `goods_attr_id` varchar(150) NOT NULL DEFAULT '' COMMENT '商品属性id',
  `goods_number` mediumint(8) unsigned NOT NULL COMMENT '购买的数量',
  `price` decimal(10,2) NOT NULL COMMENT '购买的价格',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='定单商品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_order_goods`
--

LOCK TABLES `ss_order_goods` WRITE;
/*!40000 ALTER TABLE `ss_order_goods` DISABLE KEYS */;
INSERT INTO `ss_order_goods` VALUES (2,2,7,'2,6',7,95.00),(3,2,7,'3,5',4,95.00),(4,2,7,'1,5',4,95.00),(5,2,7,'3,6',4,95.00),(6,2,3,'',4,222.00),(7,2,4,'',2,333.00),(8,3,4,'',1,333.00);
/*!40000 ALTER TABLE `ss_order_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_privilege`
--

DROP TABLE IF EXISTS `ss_privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_privilege` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `pri_name` varchar(30) NOT NULL COMMENT '权限名称',
  `module_name` varchar(30) NOT NULL DEFAULT '' COMMENT '模块名称',
  `controller_name` varchar(30) NOT NULL DEFAULT '' COMMENT '控制器名称',
  `action_name` varchar(30) NOT NULL DEFAULT '' COMMENT '方法名称',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级权限Id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='权限';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_privilege`
--

LOCK TABLES `ss_privilege` WRITE;
/*!40000 ALTER TABLE `ss_privilege` DISABLE KEYS */;
INSERT INTO `ss_privilege` VALUES (1,'商品模块','','','',0),(2,'商品列表','Admin','Goods','lst',1),(3,'添加商品','Admin','Goods','add',2),(4,'修改商品','Admin','Goods','edit',2),(5,'删除商品','Admin','Goods','delete',2),(6,'分类列表','Admin','Category','lst',1),(7,'添加分类','Admin','Category','add',6),(8,'修改分类','Admin','Category','edit',6),(9,'删除分类','Admin','Category','delete',6),(10,'RBAC','','','',0),(11,'权限列表','Admin','Privilege','lst',10),(12,'添加权限','Privilege','Admin','add',11),(13,'修改权限','Admin','Privilege','edit',11),(14,'删除权限','Admin','Privilege','delete',11),(15,'角色列表','Admin','Role','lst',10),(16,'添加角色','Admin','Role','add',15),(17,'修改角色','Admin','Role','edit',15),(18,'删除角色','Admin','Role','delete',15),(19,'管理员列表','Admin','Admin','lst',10),(20,'添加管理员','Admin','Admin','add',19),(21,'修改管理员','Admin','Admin','edit',19),(22,'删除管理员','Admin','Admin','delete',19),(23,'类型列表','Admin','Type','lst',1),(24,'添加类型','Admin','Type','add',23),(25,'修改类型','Admin','Type','edit',23),(26,'删除类型','Admin','Type','delete',23),(27,'属性列表','Admin','Attribute','lst',23),(28,'添加属性','Admin','Attribute','add',27),(29,'修改属性','Admin','Attribute','edit',27),(30,'删除属性','Admin','Attribute','delete',27),(31,'ajax删除商品属性','Admin','Goods','ajaxDelGoodsAttr',4),(32,'ajax删除商品相册图片','Admin','Goods','ajaxDelImage',4),(33,'会员管理','','','',0),(34,'会员级别列表','Admin','MemberLevel','lst',33),(35,'添加会员级别','Admin','MemberLevel','add',34),(36,'修改会员级别','Admin','MemberLevel','edit',34),(37,'删除会员级别','Admin','MemberLevel','delete',34),(38,'品牌列表','Admin','Brand','lst',1);
/*!40000 ALTER TABLE `ss_privilege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_role`
--

DROP TABLE IF EXISTS `ss_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_role` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_role`
--

LOCK TABLES `ss_role` WRITE;
/*!40000 ALTER TABLE `ss_role` DISABLE KEYS */;
INSERT INTO `ss_role` VALUES (1,'商品模块管理员'),(2,'RBAC管理员');
/*!40000 ALTER TABLE `ss_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_role_pri`
--

DROP TABLE IF EXISTS `ss_role_pri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_role_pri` (
  `pri_id` mediumint(8) unsigned NOT NULL COMMENT '权限id',
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色id',
  KEY `pri_id` (`pri_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_role_pri`
--

LOCK TABLES `ss_role_pri` WRITE;
/*!40000 ALTER TABLE `ss_role_pri` DISABLE KEYS */;
INSERT INTO `ss_role_pri` VALUES (10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(19,2),(20,2),(21,2),(22,2),(1,1),(2,1),(3,1),(4,1),(31,1),(32,1),(5,1),(6,1),(7,1),(8,1),(9,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(38,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1);
/*!40000 ALTER TABLE `ss_role_pri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_type`
--

DROP TABLE IF EXISTS `ss_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_type` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `type_name` varchar(30) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='类型';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_type`
--

LOCK TABLES `ss_type` WRITE;
/*!40000 ALTER TABLE `ss_type` DISABLE KEYS */;
INSERT INTO `ss_type` VALUES (1,'手机'),(2,'服装'),(3,'书');
/*!40000 ALTER TABLE `ss_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_yinxiang`
--

DROP TABLE IF EXISTS `ss_yinxiang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ss_yinxiang` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  `yx_name` varchar(30) NOT NULL COMMENT '印象名称',
  `yx_count` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '印象的次数',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='印象';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_yinxiang`
--

LOCK TABLES `ss_yinxiang` WRITE;
/*!40000 ALTER TABLE `ss_yinxiang` DISABLE KEYS */;
INSERT INTO `ss_yinxiang` VALUES (1,4,'屏幕大',1),(2,4,'性能好',4),(3,4,'外观漂亮',1),(4,4,'便宜',3),(5,4,'颜色正宗',1),(6,4,'大棒1',1),(7,4,'大棒2',1),(8,4,'大棒3',1),(9,4,'大棒4',1),(10,4,'大棒5',1),(11,4,'大棒6',1),(12,4,'大棒76',1),(13,4,'8',1),(14,4,'9',1),(15,4,'43',4),(16,4,'4',1),(17,4,'3',2),(18,4,'32',1),(19,4,'5',1),(20,4,'6',1),(21,4,'7',1),(22,4,'76',1),(23,4,'一',1),(24,4,'于',1),(25,4,'城',1),(26,4,'re',5),(27,4,'er',1),(28,4,'re43',1),(29,4,'45',1);
/*!40000 ALTER TABLE `ss_yinxiang` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02  9:06:18
