-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql
-- 生成日時: 2021 年 5 月 14 日 23:50
-- サーバのバージョン： 5.7.34
-- PHP のバージョン: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `sample`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `buy_detail`
--

CREATE TABLE `buy_detail` (
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `buy_histories`
--

CREATE TABLE `buy_histories` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ダンプしたテーブルのインデックス
--

<<<<<<< HEAD
--
-- テーブルのインデックス `buy_detail`
--
ALTER TABLE `buy_detail`
  ADD PRIMARY KEY (`order_id`,`item_id`)USING BTREE;
=======
--s
-- テーブルのインデックス `buy_detail`
--
ALTER TABLE `buy_detail`
  ADD PRIMARY KEY (`order_id`,`item_id`) USING BTREE; 
>>>>>>> 81a1a86b5ed6524840f9946654fe92d8652c6147

--
-- テーブルのインデックス `buy_histories`
--
ALTER TABLE `buy_histories`
  ADD PRIMARY KEY (`order_id`);
<<<<<<< HEAD

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

=======
>>>>>>> 81a1a86b5ed6524840f9946654fe92d8652c6147
--
-- テーブルの AUTO_INCREMENT `buy_histories`
--
ALTER TABLE `buy_histories`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
