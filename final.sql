-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024 年 06 月 16 日 14:23
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `final`
--

-- --------------------------------------------------------

--
-- 資料表結構 `attractions`
--

CREATE TABLE `attractions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `popularity` int(11) DEFAULT NULL,
  `seo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `opening_hours` varchar(255) DEFAULT NULL,
  `ticket_price` varchar(255) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_nopad_ci;

--
-- 傾印資料表的資料 `attractions`
--

INSERT INTO `attractions` (`id`, `name`, `description`, `location_id`, `category_id`, `popularity`, `seo`, `created_at`, `updated_at`, `address`, `contact_info`, `opening_hours`, `ticket_price`, `photo_url`) VALUES
(1, '台北展覽｜超人力霸王英雄展', '完整展出歷代超人角色 \n現場展示日本原裝超人、怪獸拍攝道具戲服 \n超巨型四米高超人雕像震撼呈現 \n電影、影集場景擬真還原，帶您沉浸在超人力霸王的宇宙中 \n稀有限定「超人力霸王拍照會」 \n多媒體互動體驗超人變身、挑戰消滅怪獸的刺激快感', 1, 3, 1, '超能力霸王 展覽', '2024-06-12 13:15:33', '2024-06-12 13:15:33', '華山1914文化創意產業園區 東2CD棟', '02-7713-4673', '10:00 - 18:00，17:30 停止售票及入場 ', '330', 'https://image.kkday.com/v2/image/get/h_650%2Cc_fit/s1.kkday.com/product_172202/20240517092850_BrDNe/jpg'),
(2, '台北｜凱達大飯店住宿｜加贈紀念禮', '台北住宿推薦：暑假 7-8 月，兒童不佔床免費！\n步行至捷運龍山寺站僅 5 分鐘，與萬華車站共構，交通便利\n鄰近剝皮寮歷史園區、華西街夜市、中正紀念堂、台北植物園等知名景點', 1, 2, 2, '台北 住宿 凱達', '2024-06-13 12:46:53', '2024-06-13 12:46:53', '台北市萬華區艋舺大道 167 號', '02-7713-4673', '整天', '2202', 'https://image.kkday.com/v2/image/get/h_650%2Cc_fit/s1.kkday.com/product_123128/20210923135104_vdtuu/png'),
(3, '台北兒童新樂園門票', 'KKday兒童新樂園門票比現場便宜，購買兒童新樂園一日Fun券即有多項刺激有趣的遊樂設施任你暢玩。\nKKday推出兒童新樂園聯票優惠，讓你一次爽玩兒童新樂園、天文館、科教館。\n在KKday訂購台北兒童新樂園門票，可以直接掃QRcode入館，即買即用！不必排隊購票，輕鬆入場！\n更多細節請見台北兒童新樂園攻略', 1, 3, 5, '樂園 兒童 新樂園', '2024-06-13 12:49:08', '2024-06-13 12:49:08', '11169台北市士林區承德路五段55號', NULL, NULL, '179', 'https://image.kkday.com/v2/image/get/h_650%2Cc_fit/s1.kkday.com/product_34133/20191206102721_ISqLO/jpg'),
(4, '台灣台北｜i-Ride TAIPEI 飛行劇院體驗門票｜源起．非洲＆飛越系列', '一座會飛的電影院！20米巨大球幕Ｘ超沉浸式體感飛行，超乎想像黑科技體驗\n突破全球紀實空拍規格！地球12部曲首部曲《源起．非洲》帶您重返人類故鄉\n體驗史詩級超鉅作！耗時1,095天，飛越17,000公里，非洲17國壯闊絕景映入眼簾\n造訪非洲世界之最！撒哈拉沙漠、尼羅河、東非大裂谷…直面宛如電影般浩瀚場景\n最另類Safari體驗！動物大遷徙X非洲五霸X生態小知識，親子共玩共學超推薦', 1, 3, 4, '台北 門票 飛行', '2024-06-13 13:22:04', '2024-06-13 13:22:04', NULL, NULL, NULL, '425', 'https://image.kkday.com/v2/image/get/h_650%2Cc_fit/s1.kkday.com/product_28750/20240520111829_EpTi0/jpg'),
(5, '【預售76折】台北展覽｜teamLab共創！未來園', '2022年台灣突破30萬人的超人氣teamLab互動藝術展即將登陸台北\n作品以「共創」為概念，從小孩到大人都能重拾熾熱童心，自由打開創意腦洞、盡情玩耍！\n預售票 76 折起販售中！於國立臺灣科學教育館盛大登場', 1, 3, 5, '台北 展覽 科教館', '2024-06-13 13:32:35', '2024-06-13 13:32:35', '臺北市士林區士商路189號', NULL, NULL, '390', 'https://image.kkday.com/v2/image/get/h_650%2Cc_fit/s1.kkday.com/product_168820/20240426081328_HOgTe/jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_nopad_ci;

--
-- 傾印資料表的資料 `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `seo`) VALUES
(1, '交通', NULL, 'Array'),
(2, '住宿', NULL, 'Array'),
(3, '景點門票', NULL, ''),
(4, '伴手禮', NULL, '');

-- --------------------------------------------------------

--
-- 資料表結構 `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `seo` varchar(255) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_nopad_ci;

--
-- 傾印資料表的資料 `locations`
--

INSERT INTO `locations` (`id`, `name`, `description`, `seo`, `photo_url`) VALUES
(1, '台北', NULL, '', 'https://image.kkday.com/v2/image/get/w_628%2Ch_472%2Cc_fill%2Cq_55%2Ct_webp/s1.kkday.com/campaign_1345/20210204034847_MwMNE/jpg'),
(2, '新北', NULL, NULL, NULL),
(3, '桃園', NULL, NULL, NULL),
(4, '新竹', NULL, NULL, NULL);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `category_id` (`category_id`);

--
-- 資料表索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `attractions`
--
ALTER TABLE `attractions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `attractions`
--
ALTER TABLE `attractions`
  ADD CONSTRAINT `attractions_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `attractions_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
