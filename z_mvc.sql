-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 14 2021 г., 21:33
-- Версия сервера: 5.7.31
-- Версия PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `z_mvc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirm_code` varchar(100) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `name`, `last_name`, `phone`, `email`, `password`, `confirm_code`, `status`, `date`) VALUES
(71, 'dsdsds', 'dsdsds', '+37495647576', 'hov97hov@bk.ru', 'cbdf371742d38c2f06960e66059d8e76', NULL, '1', '2021-02-27 15:11:56');

-- --------------------------------------------------------

--
-- Структура таблицы `cats`
--

DROP TABLE IF EXISTS `cats`;
CREATE TABLE IF NOT EXISTS `cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cats`
--

INSERT INTO `cats` (`id`, `title`, `date`, `status`, `sort`) VALUES
(20, 'Notebook', '2021-03-13 22:08:50', '0', 0),
(23, 'Whatch', '2021-03-13 22:19:11', '0', 0),
(24, 'Tv', '2021-03-13 22:20:45', '0', 0),
(25, 'Smart Whatch', '2021-03-13 22:22:00', '0', 0),
(26, 'Keyboard', '2021-03-13 22:24:39', '0', 0),
(27, 'Mouse', '2021-03-13 22:27:49', '0', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(100) NOT NULL,
  `row_id` int(11) NOT NULL,
  `name_used` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `size` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=270 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`id`, `table_name`, `row_id`, `name_used`, `name`, `type`, `size`, `date`, `sort`) VALUES
(84, 'users', 85, 'home', '7502c65c59db653719403c1f36895ee2', 'jpg', '38013', '2021-03-07 01:40:46', 0),
(93, 'cats', 20, 'top', 'bd57364bc91ab37ee64ae0e9fa21a17e', 'jpg', '15597', '2021-03-13 22:13:15', 0),
(97, 'cats', 23, 'top', 'a20cc274d957f34d416904a3a6c5adcb', 'jpg', '101970', '2021-03-13 22:19:11', 0),
(98, 'cats', 24, 'top', 'f381fffcb9ec43ae5af457c1004109d8', 'jpg', '921177', '2021-03-13 22:20:46', 0),
(99, 'cats', 25, 'top', 'c24c5c70a4f617ac1b2f4b99cdfda89f', 'png', '286472', '2021-03-13 22:22:00', 0),
(101, 'cats', 26, 'top', '2112ba231bf6a51b3ff1e8eb85932174', 'png', '251762', '2021-03-13 22:26:07', 0),
(103, 'cats', 27, 'top', '8583ceef5e2ccbec204d4e28507e4f44', 'jpg', '39848', '2021-03-13 22:28:21', 0),
(107, 'sub_cats', 104, 'top', 'c35ada66fa3bc4a80d16af872060bd82', 'jpg', '81380', '2021-03-13 22:31:38', 0),
(111, 'sub_cats', 105, 'top', 'b08d3495b5059d173ed828133126b02b', 'png', '541933', '2021-03-13 22:34:51', 0),
(115, 'sub_cats', 106, 'top', 'f4a6ad710300c675ce6c3ea3ae43b23d', 'png', '103893', '2021-03-13 22:36:14', 0),
(118, 'sub_cats', 107, 'top', '59ecd26bcedf1a20016c9998e2ccba18', 'jpg', '142567', '2021-03-13 22:38:59', 0),
(119, 'sub_cats', 109, 'top', '9f6fad1f9e71b6f3e466753f5e9ba5af', 'jpg', '543631', '2021-03-13 22:40:04', 0),
(120, 'sub_cats', 110, 'top', '6739df5a71af4fd738489c8b19ce6f53', 'jpg', '762618', '2021-03-13 22:41:12', 0),
(122, 'sub_cats', 114, 'top', 'e44d1636d86eaa055a828a307ac0239a', 'jpg', '141817', '2021-03-13 22:45:51', 0),
(123, 'sub_cats', 115, 'top', '820ac3d414a62c82dcf0e80bdc4728f0', 'png', '258005', '2021-03-13 22:47:16', 0),
(124, 'sub_cats', 116, 'top', '5d9e86a996a772442dbe062bb1b1ac54', 'jpg', '198108', '2021-03-13 22:48:25', 0),
(128, 'sub_cats', 117, 'top', '1567079ccc6621ac35a77ebc2e4e2e4c', 'jpg', '51696', '2021-03-13 22:53:26', 0),
(129, 'sub_cats', 118, 'top', 'c06e3d3a53408881d4343c815e69a57b', 'jpg', '240659', '2021-03-13 22:54:40', 0),
(130, 'sub_cats', 119, 'top', 'bb7dfe8a2ffb53f77edb5774781027db', 'jfif', '3563', '2021-03-13 22:55:25', 0),
(132, 'products', 17, 'home', 'c9f109ae06185589d8680fc9bd9bc90f', 'jpg', '79714', '2021-03-14 00:39:17', 0),
(133, 'products', 17, 'gallery', '7f87ba9174f4eb08a6d9531c10e84bae', 'jpg', '28470', '2021-03-14 00:40:30', 0),
(134, 'products', 17, 'gallery', 'fc68bfb51cb921bcf7dd9bd7ce61cd0b', 'jpg', '29140', '2021-03-14 00:40:30', 0),
(135, 'products', 17, 'gallery', 'c62fa735b49c9e12bfb9be1b886d2cd2', 'jpg', '30789', '2021-03-14 00:40:31', 0),
(136, 'products', 17, 'gallery', '503492dfe244e7f4229fe6d96ed10cb0', 'jpg', '64874', '2021-03-14 00:40:31', 0),
(137, 'products', 17, 'gallery', 'b49987f2005d171da9dd5f468a5eefc1', 'jpg', '39713', '2021-03-14 00:40:31', 0),
(138, 'products', 17, 'gallery', 'e4701e2626e5b36f0caf1569ea230a5b', 'jpg', '65894', '2021-03-14 00:40:32', 0),
(139, 'products', 17, 'gallery', 'b3a39c3cca5a0e68c56c6feeebd15da8', 'jpg', '36643', '2021-03-14 00:40:32', 0),
(140, 'products', 17, 'gallery', '8290ca880029606bfc1faf190fbcda5f', 'jpg', '74535', '2021-03-14 00:40:32', 0),
(141, 'products', 18, 'home', 'af4dbf299672cfec24688a8bc81fe243', 'jpg', '68724', '2021-03-14 00:44:14', 0),
(142, 'products', 18, 'gallery', 'e4aa6b674d892b102cd5f582453e42ad', 'jpg', '27537', '2021-03-14 00:45:23', 0),
(143, 'products', 18, 'gallery', 'fb34ebd6371f0050101e525eed1c1209', 'jpg', '27600', '2021-03-14 00:45:23', 0),
(144, 'products', 18, 'gallery', '1ea4f4fe53c628b0e6f5a9f9c2a242b6', 'jpg', '25234', '2021-03-14 00:45:24', 0),
(145, 'products', 18, 'gallery', '251406812d77655856f9ead2596233b8', 'jpg', '27389', '2021-03-14 00:45:24', 0),
(146, 'products', 18, 'gallery', '5be4961c241106157b7af676a2666fc1', 'jpg', '43645', '2021-03-14 00:45:24', 0),
(147, 'products', 18, 'gallery', '7f9ecde152de2a184d677b2bbb7de7b7', 'jpg', '48302', '2021-03-14 00:45:24', 0),
(148, 'products', 18, 'gallery', 'a4c4662242b7e5892a3ff5d7868d08a1', 'jpg', '41651', '2021-03-14 00:45:25', 0),
(149, 'products', 18, 'gallery', '2e5f0c886930e009fd26c08bb2b8cd28', 'jpg', '62788', '2021-03-14 00:45:25', 0),
(150, 'products', 18, 'gallery', 'caa846a2697cd1f5c1ecef21cd4b5805', 'jpg', '59565', '2021-03-14 00:45:25', 0),
(151, 'products', 18, 'gallery', '51386d4b154ac9eaeb64be36c3bc4f13', 'jpg', '72285', '2021-03-14 00:45:26', 0),
(152, 'products', 18, 'gallery', 'b888f88200b710b037d5f9c024ed003a', 'jpg', '71712', '2021-03-14 00:45:26', 0),
(153, 'products', 18, 'gallery', 'bd3451152e94a131df7dd6f105d9d891', 'jpg', '68848', '2021-03-14 00:45:26', 0),
(154, 'products', 18, 'gallery', '04eb1a5b6d0693aae00dac4235930a02', 'jpg', '57994', '2021-03-14 00:45:26', 0),
(155, 'products', 18, 'gallery', '0243ebb86d526cc78bda1de9e5d4f009', 'jpg', '55249', '2021-03-14 00:45:27', 0),
(156, 'products', 18, 'gallery', '48f3fa308460e2121463fcfc04d0742f', 'jpg', '73477', '2021-03-14 00:45:27', 0),
(157, 'products', 18, 'gallery', '7cc33cfd8f0a28331839ed0b8a17ddb1', 'jpg', '61379', '2021-03-14 00:45:27', 0),
(165, 'products', 22, 'home', '98222b4e5ea1513095f4510062067612', 'jpg', '141869', '2021-03-14 01:00:32', 0),
(166, 'products', 22, 'gallery', 'c97df8c59b2498ae858ca14545b9e5c3', 'jpg', '75038', '2021-03-14 01:01:30', 0),
(167, 'products', 22, 'gallery', 'a43801f64b71a0771a0285cb84af7f61', 'jpg', '122241', '2021-03-14 01:01:30', 0),
(168, 'products', 22, 'gallery', 'a9ad7395545e456c592d7966867bfe62', 'jpg', '146975', '2021-03-14 01:01:30', 0),
(169, 'products', 22, 'gallery', 'b80c20868cddaba814b09ad57d3eb1a8', 'jpg', '68185', '2021-03-14 01:01:30', 0),
(170, 'products', 22, 'gallery', '254e54a7d106668087b2b7619d7035e7', 'jpg', '72243', '2021-03-14 01:01:31', 0),
(171, 'products', 22, 'gallery', 'c7313f181467ad499d2a2bc0f3e93b5b', 'jpg', '138669', '2021-03-14 01:01:31', 0),
(172, 'products', 22, 'gallery', '9b82543397c28cba744b179aa694d362', 'jpg', '36632', '2021-03-14 01:01:31', 0),
(173, 'products', 22, 'gallery', '763338c495c4af69c3a51ea6720ee885', 'jpg', '34911', '2021-03-14 01:01:31', 0),
(174, 'products', 22, 'gallery', '52300b845a53902a20f2dc08a374938e', 'jpg', '78558', '2021-03-14 01:01:32', 0),
(176, 'products', 23, 'home', '69d7d211198aa5857a7341fe14a5018f', 'jpg', '51963', '2021-03-14 01:06:43', 0),
(177, 'products', 23, 'gallery', '76543f02eb9aacf48dbf7c50c0448265', 'jpg', '39372', '2021-03-14 01:07:28', 0),
(178, 'products', 23, 'gallery', '2a7d91f4dbd993f33bb2e6c7f35f4041', 'jpg', '21552', '2021-03-14 01:07:28', 0),
(179, 'products', 23, 'gallery', '63bcd57987b4f93ce86cec11d9d700d7', 'jpg', '40027', '2021-03-14 01:07:28', 0),
(180, 'products', 23, 'gallery', '03befa78efff9ec68ec39c1c26315fae', 'jpg', '26795', '2021-03-14 01:07:28', 0),
(181, 'products', 23, 'gallery', '6da981713d679a1ad5e8c5638505e1ce', 'jpg', '35527', '2021-03-14 01:07:29', 0),
(182, 'products', 24, 'home', '44cdbd863ac6583ccf81216fd15f33f6', 'jpg', '25672', '2021-03-14 01:09:05', 0),
(183, 'products', 24, 'gallery', '0999f16461a1ded0c381d6cd2719e3f3', 'jpg', '26609', '2021-03-14 01:09:41', 0),
(184, 'products', 24, 'gallery', '92b2691451d0698ed2a6d0a06e15fe07', 'jpg', '27494', '2021-03-14 01:09:41', 0),
(185, 'products', 24, 'gallery', 'dd1b61f7cb89414af806fea2e3e4ee4f', 'jpg', '27405', '2021-03-14 01:09:41', 0),
(186, 'products', 24, 'gallery', 'a3570ca9001b678c55601af4af5fdf6f', 'jpg', '9212', '2021-03-14 01:09:42', 0),
(187, 'products', 24, 'gallery', 'b27d48b3b5c773faa4c31d488d08839d', 'jpg', '9185', '2021-03-14 01:09:42', 0),
(188, 'products', 25, 'home', '7894ab521ab4531cf1d95ec48d61d5c1', 'jpg', '42075', '2021-03-14 01:10:52', 0),
(189, 'products', 25, 'gallery', '122292a9d33d9435a496c3d43fb055ce', 'jpg', '10463', '2021-03-14 01:11:40', 0),
(190, 'products', 25, 'gallery', '95b035c7026dd86cf2fcee9fa1b2bbac', 'jpg', '30577', '2021-03-14 01:11:40', 0),
(191, 'products', 25, 'gallery', '2495f6227e98517147f164486f2f17e6', 'jpg', '30990', '2021-03-14 01:11:41', 0),
(192, 'products', 25, 'gallery', '1f1129b20658708b9579eaa904191239', 'jpg', '15242', '2021-03-14 01:11:41', 0),
(193, 'products', 25, 'gallery', '09b5afdabaf173a5f2ab28d89d8977d6', 'jpg', '37771', '2021-03-14 01:11:41', 0),
(194, 'products', 25, 'gallery', '04cc9983d2e70ee650dbdef570b040f5', 'jpg', '12893', '2021-03-14 01:11:41', 0),
(198, 'products', 26, 'home', '7dc65fb20b5161d26f4f070526fa2812', 'jpg', '37489', '2021-03-14 01:14:12', 0),
(199, 'products', 26, 'gallery', '1a55709f3787aaec831e9737fd30ca80', 'jpg', '42163', '2021-03-14 01:14:56', 0),
(200, 'products', 26, 'gallery', 'f4a7414966f07ecdce2e564f8ba5ad69', 'jpg', '45278', '2021-03-14 01:14:56', 0),
(201, 'products', 26, 'gallery', 'e7426139169219bfeb2249b53e065db5', 'jpg', '47580', '2021-03-14 01:14:56', 0),
(202, 'products', 26, 'gallery', '8c203b4a3efddd20bd0a3af1b88483f5', 'jpg', '45970', '2021-03-14 01:14:56', 0),
(203, 'products', 26, 'gallery', 'f4c34b7d479bc33214269aa34e709ed3', 'jpg', '17444', '2021-03-14 01:14:57', 0),
(204, 'products', 27, 'home', '0d2bf9aa9cec921810e13d70ae4a20b5', 'jpg', '32686', '2021-03-14 01:16:04', 0),
(205, 'products', 27, 'gallery', 'd05a62c0d67f7b555489a2d616df8ac5', 'jpg', '44342', '2021-03-14 01:16:47', 0),
(206, 'products', 27, 'gallery', '1461d2beccc3899273688a4aabfb0360', 'jpg', '42060', '2021-03-14 01:16:47', 0),
(207, 'products', 27, 'gallery', 'e698aad0110df348e0c4637c186a7fa0', 'jpg', '32686', '2021-03-14 01:16:47', 0),
(208, 'products', 27, 'gallery', '93d030deb74ac26dfb8b5359c7cee989', 'jpg', '43085', '2021-03-14 01:16:47', 0),
(209, 'products', 28, 'home', '7992d9ec0b2abc0cba9b8ad07175a04e', 'jpg', '69141', '2021-03-14 01:19:10', 0),
(210, 'products', 28, 'gallery', '80239368e5c3bbf5d313c14b86bae0db', 'jpg', '14247', '2021-03-14 01:19:20', 0),
(211, 'products', 28, 'gallery', '95324d5b6fd3669ffafe7e4c0a194497', 'jpg', '54665', '2021-03-14 01:19:20', 0),
(212, 'products', 28, 'gallery', 'a100e34b0dad3484a6d4cb97bdd2a88f', 'jpg', '9304', '2021-03-14 01:19:20', 0),
(213, 'products', 28, 'gallery', 'c2e986a48845414106f9730c78c29dc5', 'jpg', '8117', '2021-03-14 01:19:20', 0),
(214, 'sub_cats', 111, 'top', 'ae67449fbc33612ba973a8b5da9130a7', 'jpg', '69141', '2021-03-14 01:20:06', 0),
(215, 'products', 29, 'home', '0ce66fa8c4630a408edfd7a4d513cf2b', 'jpg', '43008', '2021-03-14 01:21:07', 0),
(216, 'products', 29, 'gallery', 'a0db99c3d81b709f5a9fb24ec2b92291', 'jpg', '15122', '2021-03-14 01:21:46', 0),
(217, 'products', 29, 'gallery', '3b1a8205cf9d08e1ac61af8aad1f8971', 'jpg', '21988', '2021-03-14 01:21:47', 0),
(218, 'products', 29, 'gallery', 'c6531cd58b97f23af7d4c43d20ddcb05', 'jpg', '19632', '2021-03-14 01:21:47', 0),
(219, 'products', 29, 'gallery', 'd691a6015056c198ec89a730c310857e', 'jpg', '11636', '2021-03-14 01:21:47', 0),
(220, 'products', 29, 'gallery', '8be5fcf0797570d7662615c2797c7e10', 'jpg', '25489', '2021-03-14 01:21:47', 0),
(221, 'products', 29, 'gallery', 'db44f086e0daa8a67c37900ceec50aae', 'jpg', '10985', '2021-03-14 01:21:47', 0),
(222, 'products', 30, 'home', 'b70c941401042fc1803dbfd29f5539e2', 'jpg', '23384', '2021-03-14 01:23:41', 0),
(223, 'products', 30, 'gallery', '07aea6ecc700c78d1d6a5357c421648f', 'jpg', '6615', '2021-03-14 01:23:49', 0),
(224, 'products', 30, 'gallery', '4f83d15f8faf701154e6aba322c75af6', 'jpg', '6151', '2021-03-14 01:23:49', 0),
(225, 'products', 30, 'gallery', '8764204625906ff9d595c45ab780aeb1', 'jpg', '8655', '2021-03-14 01:23:49', 0),
(226, 'products', 30, 'gallery', '8989f63d3b611d5943d9496bf112e883', 'jpg', '10109', '2021-03-14 01:23:49', 0),
(227, 'products', 30, 'gallery', 'b9db6831ba17e02e7262849961d66e26', 'jpg', '10394', '2021-03-14 01:23:50', 0),
(228, 'products', 31, 'home', 'cab21615e4e202bd2fa126ff4b791f4c', 'jpg', '38642', '2021-03-14 01:25:43', 0),
(229, 'products', 31, 'gallery', '5dac038c86fe657730d64297512500a1', 'jpg', '34595', '2021-03-14 01:26:05', 0),
(230, 'products', 31, 'gallery', '709038908fa10641159bb7df276490b4', 'jpg', '50879', '2021-03-14 01:26:05', 0),
(231, 'products', 31, 'gallery', 'a6703f6a30a21e835158346a5b3e17d6', 'jpg', '43216', '2021-03-14 01:26:05', 0),
(232, 'products', 31, 'gallery', '20a4e0b5c84e98f3697a5700adfe3103', 'jpg', '47128', '2021-03-14 01:26:06', 0),
(233, 'products', 31, 'gallery', '4563fc2b78f185763b60b101e293432d', 'jpg', '37046', '2021-03-14 01:26:06', 0),
(234, 'products', 31, 'gallery', '1930e09763cb602c4256d08122a6e09a', 'jpg', '47923', '2021-03-14 01:26:06', 0),
(235, 'products', 32, 'home', '2e9d967bc5168e694e85fb4c79a95786', 'jpg', '31409', '2021-03-14 01:28:18', 0),
(236, 'products', 32, 'gallery', '04ef172164b2521eecdbcd5f7c436b17', 'jpg', '31409', '2021-03-14 01:28:28', 0),
(237, 'products', 32, 'gallery', '576be60f81b62d17715b6fa1dd76c225', 'jpg', '32578', '2021-03-14 01:28:28', 0),
(238, 'products', 32, 'gallery', '51cf7e7d8ea36c81241de94cd09a325f', 'jpg', '22920', '2021-03-14 01:28:28', 0),
(239, 'products', 32, 'gallery', 'c0445c4dbd96d7313b738cbc292d2819', 'jpg', '11778', '2021-03-14 01:28:28', 0),
(240, 'products', 32, 'gallery', '1dfcc74ff5d18c58501072a9f032f312', 'jpg', '35207', '2021-03-14 01:28:29', 0),
(241, 'products', 33, 'home', '39808ff658ea0b7c24b60fe4b30d29aa', 'jpg', '13785', '2021-03-14 01:30:01', 0),
(242, 'products', 33, 'gallery', 'de16592abb145c1f4a1864373ab1edae', 'jpg', '12169', '2021-03-14 01:30:09', 0),
(243, 'products', 33, 'gallery', 'a5238335604b3166f3d72842a9b4bba8', 'jpg', '11973', '2021-03-14 01:30:09', 0),
(244, 'products', 33, 'gallery', '86bfe62431a0b95bea3d12dafcce2f52', 'jpg', '12996', '2021-03-14 01:30:09', 0),
(245, 'products', 34, 'home', '45052495c76475ad180b3b335dea5911', 'jpg', '21556', '2021-03-14 01:31:27', 0),
(246, 'products', 34, 'gallery', '6b4ce7eb690775dd5430ad72bda6154b', 'jpg', '11641', '2021-03-14 01:31:35', 0),
(247, 'products', 34, 'gallery', '5b8f1a5a11ff47137b9a5f9258650661', 'jpg', '21697', '2021-03-14 01:31:35', 0),
(248, 'products', 34, 'gallery', '8f0a0bc78e2979823699095e878196c9', 'jpg', '28821', '2021-03-14 01:31:36', 0),
(249, 'products', 34, 'gallery', '35da67720f3df71755ad6bcbc49910a2', 'jpg', '31618', '2021-03-14 01:31:36', 0),
(250, 'products', 34, 'gallery', '56b887f1b5065e5d3b2f8e5b8078959c', 'jpg', '15550', '2021-03-14 01:31:36', 0),
(252, 'products', 36, 'home', '0c4ec513164bc39c2bab71d5cb890b06', 'jpg', '144920', '2021-03-14 01:35:58', 0),
(253, 'products', 36, 'gallery', '37d60781788807049a9995444fd6d829', 'jpg', '151167', '2021-03-14 01:36:19', 0),
(254, 'products', 36, 'gallery', '48622ca3f07cbaabe548550873bc3d87', 'jpg', '98244', '2021-03-14 01:36:19', 0),
(255, 'products', 36, 'gallery', '55de4428a90c987831a220fa13fe5609', 'jpg', '329698', '2021-03-14 01:36:20', 0),
(256, 'products', 36, 'gallery', 'f1906ef44d4a7cf63290bd651469cb48', 'jpg', '81912', '2021-03-14 01:36:20', 0),
(257, 'products', 36, 'gallery', 'ad1388ad9d382d18fbbdf20aac0c7be6', 'jpg', '71881', '2021-03-14 01:36:20', 0),
(258, 'products', 37, 'home', '0dd71a397aeeb7784884b3b90d1b74ac', 'jpg', '333231', '2021-03-14 01:37:44', 0),
(259, 'products', 37, 'gallery', 'dac2274930eb71adfe4791047400bf73', 'jpg', '939185', '2021-03-14 01:37:52', 0),
(260, 'products', 37, 'gallery', 'ea233135671cbca99013b7329c5b4cb3', 'jpg', '1265745', '2021-03-14 01:37:53', 0),
(261, 'products', 38, 'home', 'c749122b1d51abe187b8d79dac1ea0f1', 'jpg', '108210', '2021-03-14 01:40:23', 0),
(262, 'products', 38, 'gallery', '93c5825385de14cab02174e329285389', 'jpg', '95213', '2021-03-14 01:41:02', 0),
(263, 'products', 38, 'gallery', '5693c9b9684a918b94770934c7fa7872', 'jpg', '93734', '2021-03-14 01:41:02', 0),
(264, 'products', 39, 'home', '1d406bc5c3e086d8d7226b5a1ca13139', 'jpg', '526876', '2021-03-14 01:43:58', 0),
(265, 'products', 39, 'gallery', 'd3b8831641f7a20b34f3fe6bfe480df8', 'jpg', '575895', '2021-03-14 01:44:09', 0),
(266, 'products', 39, 'gallery', '000d829e1f631475690bd844331a7a99', 'jpg', '464096', '2021-03-14 01:44:11', 0),
(267, 'products', 39, 'gallery', 'c8b25fc533a972ffc5b576264a45db05', 'jpg', '705672', '2021-03-14 01:44:12', 0),
(268, 'products', 39, 'gallery', '24e5809bd51750e62b3e6511e45dc668', 'jpg', '421954', '2021-03-14 01:44:13', 0),
(269, 'products', 39, 'gallery', 'c05b10ac147862bad75153be4c167a05', 'jpg', '787822', '2021-03-14 01:44:14', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_cat_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `discount` varchar(100) DEFAULT NULL,
  `discount_start_date` text,
  `discount_end_date` text,
  `descr` text NOT NULL,
  `quantity` varchar(500) NOT NULL,
  `top` enum('0','1') NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `sub_cat_id`, `title`, `price`, `discount`, `discount_start_date`, `discount_end_date`, `descr`, `quantity`, `top`, `date`, `status`, `sort`) VALUES
(17, 105, 'Asus leptop', '360000', '7', '', '', 'Без ОС;\r\nДисплей: 15.6&amp;#039; FHD;\r\nПроцессор: Intel® Core™ i5-9300H ;\r\nОперативная память: 12 Гб ;\r\nГрафика: Nvidia GeForce GTX 1650;\r\nХранилище данных: 1 Тб HDD, 256 Гб SSD;', '50', '1', '2021-03-14 00:39:17', '1', 0),
(18, 105, 'ASUS ZenBook Flip', '650000', '', '', '', 'Windows 10\r\nДисплей: 13.3&amp;#039; 4K UHD\r\nПроцессор: Intel® Core™ i7-1165G7\r\nОперативная память: 16 Гб LPDDR4X\r\nГрафика: Intel Iris Xe Graphics\r\nХранилище данных: 1 Тб SSD', '15', '0', '2021-03-14 00:44:14', '1', 0),
(22, 106, 'Acer TravelMate', '540000', '', '', '', 'Диагональ/разрешение\r\n11.6&amp;quot;/1366x768 пикс.\r\nПроцессор\r\nIntel Celeron N4120 1.1 ГГц\r\nОперативная память (RAM) \r\n4 ГБ\r\nГрафический контроллер \r\nIntel UHD Graphics 600\r\nОперационная система \r\nWindows 10 Домашняя S-режим', '20', '0', '2021-03-14 01:00:32', '1', 0),
(23, 104, 'Dell Vostro 5301-8389', '400000', '13', '', '', 'Диагональ дисплея (дюйм): 13.3\r\nПроцессор: Intel® Core™ i5 1135G7\r\nОперативная память (Мб): 8192\r\nВидеокарта: Intel Iris Xe graphics\r\nОперационная система: Windows 10 Home', '60', '1', '2021-03-14 01:05:35', '1', 0),
(24, 104, 'DELL Inspiron 3593 Black', '450000', '', '', '', 'Гарантия\r\n\r\n12 мес.\r\nМодельный ряд\r\n\r\nDell Inspiron\r\nДиагональ дисплея\r\n\r\n15.6 &amp;quot;\r\nРазрешение дисплея\r\n\r\n1920 x 1080\r\nТип матрицы\r\n\r\nTN+film\r\nЧастота обновления экрана\r\n\r\n60 Гц\r\nПокрытие дисплея\r\n\r\nантибликовое\r\nСерия процессора\r\n\r\nIntel® Core™ i5 (10 поколение)', '30', '0', '2021-03-14 01:09:05', '1', 0),
(25, 106, 'ACER Aspire 3', '740500', '4', '', '', 'Модельный ряд\r\n\r\nAcer Aspire\r\nДиагональ дисплея\r\n\r\n15.6 &amp;quot;\r\nРазрешение дисплея\r\n\r\n1920 x 1080\r\nТип матрицы\r\n\r\nTN+film\r\nЧастота обновления экрана\r\n\r\n60 Гц\r\nПокрытие дисплея\r\n\r\nантибликовое\r\nСерия процессора\r\n\r\nAMD Ryzen 3', '30', '0', '2021-03-14 01:10:51', '1', 0),
(26, 116, 'APPLE Watch S6 GPS 40', '150000', '', '', '', 'Гарантия\r\n\r\n12 мес.\r\nФункциональность\r\n\r\nдля взрослых\r\nОперационная система\r\n\r\nWatch OS\r\nСовместимость\r\n\r\niOS (Apple)\r\nВид деятельности\r\n\r\nвелоспорт ; плавание ; бег\r\nДизайн\r\n\r\nсовременный (спортивный)\r\nФорма корпуса\r\n\r\nпрямоугольная\r\nРазмер корпуса\r\n\r\n40', '50', '1', '2021-03-14 01:14:12', '1', 0),
(27, 116, 'APPLE Watch S6 GPS 44', '650000', '15', '', '', 'Гарантия\r\n\r\n12 мес.\r\nФункциональность\r\n\r\nдля взрослых\r\nОперационная система\r\n\r\nWatch OS\r\nСовместимость\r\n\r\niOS (Apple)\r\nВид деятельности\r\n\r\nвелоспорт ; плавание ; бег\r\nДизайн\r\n\r\nсовременный (спортивный)\r\nФорма корпуса\r\n\r\nпрямоугольная\r\nРазмер корпуса\r\n\r\n44', '700', '0', '2021-03-14 01:16:04', '1', 0),
(28, 111, 'XIAOMI Mi TV UHD 4S 55', '856000', '3', '', '', 'Гарантия\r\n\r\n12 мес.\r\nБеспроводные коммуникации\r\n\r\nDLNA ; Bluetooth ; Wi-Fi\r\nДиагональ\r\n\r\n55&amp;quot; (140 см)\r\nРазрешение\r\n\r\n3840 x 2160 (4K UHD)\r\nSmart TV\r\n\r\nAndroid\r\nФормат экрана\r\n\r\nширокоэкранный (16:9)\r\nЧастота развертки\r\n\r\n60 Гц\r\nТехнологии, улучшающие изображение\r\n\r\nHDR 10', '4', '1', '2021-03-14 01:19:09', '1', 0),
(29, 114, 'LG 50UN74006LB', '650000', '', '', '', 'Гарантия\r\n\r\nГарантия от производителя\r\nБеспроводные коммуникации\r\n\r\nBluetooth ; Wi-Fi\r\nДиагональ\r\n\r\n50&amp;quot; (127 см)\r\nРазрешение\r\n\r\n3840 x 2160 (4K UHD)\r\nSmart TV\r\n\r\nWebOS\r\nФормат экрана\r\n\r\nширокоэкранный (16:9)\r\nЧастота развертки\r\n\r\n50 Гц\r\nТехнология интерполяции изображения\r\n\r\nTruMotion', '7', '0', '2021-03-14 01:21:07', '1', 0),
(30, 117, 'Apple Keyboard Bluetooth', '54000', '', '', '', 'Гарантия\r\n\r\nГарантия от производителя\r\nКомплектация\r\n\r\nклавиатура\r\nКласс\r\n\r\nмультимедийная\r\nКонструкция\r\n\r\nмембранная\r\nПодключение\r\n\r\nбеспроводное\r\nИнтерфейс\r\n\r\nBluetooth\r\nКоличество мультимедийных клавиш\r\n\r\n10\r\nТип элементов питания\r\n\r\nвстроенный аккумулятор', '6', '1', '2021-03-14 01:23:41', '1', 0),
(31, 117, 'AULA Terminus gaming', '360000', '5', '', '', 'Гарантия\r\n\r\n24 мес.\r\nКомплектация\r\n\r\nклавиатура\r\nКласс\r\n\r\nигровая\r\nКонструкция\r\n\r\nмембранная\r\nПодключение\r\n\r\nпроводное\r\nИнтерфейс\r\n\r\nUSB\r\nОсобенности\r\n\r\nподсветка\r\nРадиус действия/длина кабеля\r\n\r\n1.5 м', '9', '0', '2021-03-14 01:25:43', '1', 0),
(32, 118, 'GENIUS Smart KB-101', '7800', '', '', '', 'Гарантия\r\n\r\n12 мес.\r\nКомплектация\r\n\r\nклавиатура\r\nКласс\r\n\r\nстандартная\r\nКонструкция\r\n\r\nмембранная\r\nПодключение\r\n\r\nпроводное\r\nИнтерфейс\r\n\r\nUSB\r\nРадиус действия/длина кабеля\r\n\r\n1.5 м\r\nМатериал корпуса\r\n\r\nпластик', '57', '0', '2021-03-14 01:28:17', '1', 0),
(33, 119, 'MICROSOFT Arc Mouse', '25000', '', '', '', 'Гарантия\r\n\r\n12 мес.\r\nТип подключения\r\n\r\nбеспроводное\r\nБеспроводное подключение\r\n\r\nBluetooth\r\nТип сенсора\r\n\r\nоптический\r\nРазрешение сенсора\r\n\r\n1000 dpi\r\nКоличество кнопок\r\n\r\n2\r\nРадиус действия/длина кабеля\r\n\r\n10 м\r\nЧастота сигнала беспроводной связи\r\n\r\n2.4 ГГц', '30', '1', '2021-03-14 01:30:01', '1', 0),
(34, 119, 'Gaming Mouse G403', '29000', '', '', '', 'Гарантия\r\n\r\n24 мес.\r\nТип подключения\r\n\r\nпроводное\r\nПроводное подключение\r\n\r\nUSB\r\nТип сенсора\r\n\r\nоптический\r\nРазрешение сенсора\r\n\r\n12000 dpi\r\nКоличество кнопок\r\n\r\n6\r\nРадиус действия/длина кабеля\r\n\r\n2.1 м\r\nФункции и особенности\r\n\r\nподсветка ; настраиваемый вес', '60', '0', '2021-03-14 01:31:26', '1', 0),
(36, 107, 'Rolex GMT-Master', '1560000', '', '2021-03-15T02:34', '2021-04-11T02:34', 'The 126755SARU was a surprising addition to Rolex’s array of new timepieces introduced at Baselworld 2019. The 126755SARU comes with a rose gold case that is 40mm in diameter with a glare-proof sapphire crystal, a monobloc middle case, screw-down case back and a winding crown. It comes with a gem set bezel that features, 23 diamonds, 18 rubies and 18 sapphires set in the beloved Rolex Pepsi design and the lugs are covered with 76 brilliant diamonds. The dial is a diamond pave set with index hour markers, a date window at 3 o clock and rose gold Mercedes hands. The 126755SARU is powered by the self-winding 3186 caliber which has date functionality, an additional 24-hour hand and a power reserve of 50 hours. The case is paired with a rose gold oyster bracelet with a fold over clasp. It has a water resistance of 100 meters (330 feet)', '3', '1', '2021-03-14 01:35:58', '1', 0),
(37, 107, 'Rolex GMT-Master II', '1400000', '', '', '', 'Номер объявления	8W17O4\r\nМарка	Rolex\r\nМодель	GMT-Master II\r\nИдентификационный номер	126710BLRO\r\nТип механизма	Автоподзавод\r\nМатериал корпуса	Сталь\r\nМатериал браслета	Сталь\r\nГод выпуска	Неизвестно\r\nСостояние	Новые (Новые, без признаков ношения)\r\nОбъем доставки	\r\nС оригинальными документами и коробкой\r\nПол	Мужские часы/часы унисекс\r\nМестоположение	Гонконг', '6', '0', '2021-03-14 01:37:44', '1', 0),
(38, 109, 'Orient QC15004D', '150000', '3', '', '', 'Stainless steel case with a stainless steel bracelet. Uni-directional rotating stainless steel bezel with a black top ring. Black dial with silver-tone hands and index hour markers. Arabic numerals mark the 6, 9 and 12 o&amp;#039;clock positions. Minute markers around the outer rim. Dial Type: Analog. Luminescent hands and markers. Day of the week and date display at the 3 o&amp;#039;clock position. Orient calibre F6922 automatic movement with a 40-hour power reserve. Scratch resistant mineral crystal. Screw down crown. Solid case back. Round case shape. Case size: 41 mm. Case thickness: 13 mm. Band width: 22 mm. Fold over clasp with a safety release. Water resistant at 200 meters / 660 feet. Functions: date, day, hour, minute, second. Dive watch style. Watch label: Japan Movt. Orient Mako II Automatic Black Dial Men&amp;#039;s Watch FAA02001B9.', '41', '0', '2021-03-14 01:40:22', '1', 0),
(39, 110, 'Hublot Classic Fusion', '620000', '7', '', '', 'Listing number	B3JFC1\r\nBrand	Hublot\r\nModel	Classic Fusion Chronograph\r\nReference number	541.NX.1171.RX\r\nDealer product code	CCXX\r\nMovement	Automatic\r\nCase material	Titanium\r\nBracelet material	Rubber\r\nYear of production	2019\r\nCondition	Unworn (Mint condition, without signs of wear)\r\nScope of delivery	\r\nOriginal box, original papers\r\nGender	Men&amp;#039;s watch/Unisex\r\nLocation	United States of America, Massachusetts, Boston', '21', '0', '2021-03-14 01:43:57', '1', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `review` text NOT NULL,
  `rate` int(1) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `review`
--

INSERT INTO `review` (`id`, `p_id`, `user_name`, `review`, `rate`, `date`) VALUES
(75, 17, 'Hovhannes', 'supeer', 1, '2021-03-14 18:38:06'),
(76, 17, 'Hovhannes', 'supeer', 4, '2021-03-14 18:38:08'),
(73, 17, 'Hovhannes', 'Shat Lavn e)', 4, '2021-03-14 17:46:57'),
(74, 17, 'Hovhannes', 'supeer', 2, '2021-03-14 18:38:02');

-- --------------------------------------------------------

--
-- Структура таблицы `sub_cats`
--

DROP TABLE IF EXISTS `sub_cats`;
CREATE TABLE IF NOT EXISTS `sub_cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sub_cats`
--

INSERT INTO `sub_cats` (`id`, `cat_id`, `title`, `date`) VALUES
(117, 26, 'Apple', '2021-03-13 22:50:39'),
(114, 24, 'LG', '2021-03-13 22:45:51'),
(115, 25, 'Samsung', '2021-03-13 22:47:16'),
(116, 25, 'Apple Whatch', '2021-03-13 22:48:25'),
(111, 24, 'Xiamoi', '2021-03-13 22:44:38'),
(109, 23, 'Orient', '2021-03-13 22:40:04'),
(110, 23, 'Publot', '2021-03-13 22:41:12'),
(107, 23, 'Rolex', '2021-03-13 22:37:11'),
(106, 20, 'Acer', '2021-03-13 22:35:31'),
(105, 20, 'Asus', '2021-03-13 22:32:33'),
(104, 20, 'Dell', '2021-03-13 22:29:29'),
(118, 26, 'Genius', '2021-03-13 22:54:21'),
(119, 27, 'Genius', '2021-03-13 22:55:25');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirm_code` varchar(100) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `phone`, `email`, `password`, `confirm_code`, `status`, `date`) VALUES
(85, 'Hovhannes', '85sasas', '0956476760sasasas', 'hov97hov@bk.ru', 'b34e35b0fe4025f8f3df09f44e3d1c9b', '', '1', '2021-02-28 01:17:11'),
(86, 'Hovo', 'Mkrtchyan', '025545', 'hov97mkrtchyan@gmail.com', 'c4819d06b0ca810d38506453cfaae9d8', '', '1', '2021-03-02 14:22:31');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
