-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 29, 2016 at 11:04 PM
-- Server version: 5.5.46-0+deb8u1
-- PHP Version: 7.0.1-1~dotdeb+8.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stuffz`
--
CREATE DATABASE IF NOT EXISTS `stuffz` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `stuffz`;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses` (
  `address_id` int(16) UNSIGNED NOT NULL,
  `street` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `number` int(8) NOT NULL,
  `addition` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `street`, `number`, `addition`, `postcode`, `city`) VALUES
(1, 'Zilverstraat', 5, '', '1601 KS', 'Enkhuizen'),
(2, 'Texel', 23, '', '1967EG', 'Heemskerk'),
(3, 'Science Park', 904, '', '1098XH', 'Amsterdam'),
(4, 'Hey', 10, '', '1702TB', 'Heerhugowaard'),
(5, 'Hey', 10, '', '1702TB', 'Heerhugowaard'),
(6, 'Heetakker', 65, '', '3762AZ', 'Soest'),
(7, 'Baanvak', 94, '', '1431 LM', 'Aalsmeer'),
(8, 'Heetakker', 65, '', '3762AZ', 'Soest'),
(9, 'Baanvak', 94, '', '1431 LM', 'Aalsmeer'),
(10, 'Prime', 1, '', '1234AB', 'Cybertron'),
(11, 'Baanvak', 94, '', '1431 LM', 'Aalsmeer'),
(12, 'Science Park', 904, '', '1098XH', 'Amsterdam'),
(13, 'Baanvak', 94, '', '1431 LM', 'Aalsmeer'),
(14, 'Baanvak', 94, '', '1431 LM', 'Aalsmeer'),
(15, 'Science Park', 904, '', '1098XH', 'Amsterdam'),
(16, 'Baanvak', 94, '', '1431 LM', 'Aalsmeer'),
(17, 'Science Park', 904, '', '1098XH', 'Amsterdam'),
(18, 'Baanvak', 94, '', '1431 LM', 'Aalsmeer'),
(19, 'Prime', 1, '', '1234AB', 'Cybertron'),
(20, 'Prime', 1, '', '1234AB', 'Cybertron'),
(21, 'Prime', 1, '', '1234AB', 'Cybertron'),
(22, 'Prime', 1, '', '1234AB', 'Cybertron'),
(23, 'Prime', 1, '', '1234AB', 'Cybertron'),
(24, 'Baanvak', 12, '', '1431LM', 'DIemen'),
(25, 'Admin', 94, '', '1324AB', 'Admin'),
(26, 'Science Park', 904, '', '1099XX', 'Amsterdam');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` int(16) UNSIGNED NOT NULL,
  `category_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Alkalimetalen'),
(2, 'Aardalkalimetalen'),
(3, 'Scandiumgroep'),
(4, 'Titaangroep'),
(5, 'Vanadiumgroep'),
(6, 'Chroomgroep'),
(7, 'Mangaangroep'),
(8, 'Platinagroep'),
(9, 'Kopergroep'),
(10, 'Zinkgroep'),
(11, 'Boorgroep'),
(12, 'Koolstofgroep'),
(13, 'Stikstofgroep'),
(14, 'Zuurstofgroep'),
(15, 'Halogenen'),
(16, 'Edelgassen'),
(17, 'Overig');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `media_id` int(16) UNSIGNED NOT NULL,
  `path` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`media_id`, `path`, `name`, `image`) VALUES
(1, 'resources/products/1.jpg', 'Waterstof', ''),
(2, 'resources/products/2.jpg', 'Helium', ''),
(3, 'resources/products/3.jpg', 'Lithium', ''),
(4, 'resources/products/4.jpg', 'Beryllium', ''),
(5, 'resources/products/5.jpg', 'Boor', ''),
(6, 'resources/products/6.jpg', 'Koolstof', ''),
(7, 'resources/products/7.jpg', 'Stikstof', ''),
(8, 'resources/products/8.jpg', 'Zuurstof', ''),
(9, 'resources/products/9.jpg', 'Fluor', ''),
(10, 'resources/products/10.jpg', 'Neon', ''),
(11, 'resources/products/11.jpg', 'Natrium', ''),
(12, 'resources/products/12.jpg', 'Magnesium', ''),
(13, 'resources/products/13.jpg', 'Aluminium', ''),
(14, 'resources/products/14.jpg', 'Silicium', ''),
(15, 'resources/products/15.jpg', 'Fosfor', ''),
(16, 'resources/products/16.jpg', 'Zwavel', ''),
(17, 'resources/products/17.jpg', 'Chloor', ''),
(18, 'resources/products/18.jpg', 'Argon', ''),
(19, 'resources/products/19.jpg', 'Kalium', ''),
(20, 'resources/products/20.jpg', 'Calcium', ''),
(21, 'resources/products/21.jpg', 'Scandium', ''),
(22, 'resources/products/22.jpg', 'Titanium', ''),
(23, 'resources/products/23.jpg', 'Vanadium', ''),
(24, 'resources/products/24.jpg', 'Chroom', ''),
(25, 'resources/products/25.jpg', 'Mangaan', ''),
(26, 'resources/products/26.jpg', 'IJzer', ''),
(27, 'resources/products/27.jpg', 'Kobalt', ''),
(28, 'resources/products/28.jpg', 'Nikkel', ''),
(29, 'resources/products/29.jpg', 'Koper', ''),
(30, 'resources/products/30.jpg', 'Zink', ''),
(31, 'resources/products/31.jpg', 'Gallium', ''),
(32, 'resources/products/32.jpg', 'Germanium', ''),
(33, 'resources/products/33.jpg', 'Arseen', ''),
(34, 'resources/products/34.jpg', 'Seleen', ''),
(35, 'resources/products/35.jpg', 'Broom', ''),
(36, 'resources/products/36.jpg', 'Krypton', ''),
(37, 'resources/products/37.jpg', 'Rubidium', ''),
(38, 'resources/products/38.jpg', 'Strontium', ''),
(39, 'resources/products/39.jpg', 'Yttrium', ''),
(40, 'resources/products/40.jpg', 'Zirkonium', ''),
(41, 'resources/products/41.jpg', 'Niobium', ''),
(42, 'resources/products/42.jpg', 'Molybdeen', ''),
(43, 'resources/products/43.jpg', 'Technetium', ''),
(44, 'resources/products/44.jpg', 'Ruthenium', ''),
(45, 'resources/products/45.jpg', 'Rodium', ''),
(46, 'resources/products/46.jpg', 'Palladium', ''),
(47, 'resources/products/47.jpg', 'Zilver', ''),
(48, 'resources/products/48.jpg', 'Cadmium', ''),
(49, 'resources/products/49.jpg', 'Indium', ''),
(50, 'resources/products/50.jpg', 'Tin', ''),
(51, 'resources/products/51.jpg', 'Antimoon', ''),
(52, 'resources/products/52.jpg', 'Tellurium', ''),
(53, 'resources/products/53.jpg', 'Jodium', ''),
(54, 'resources/products/54.jpg', 'Xenon', ''),
(55, 'resources/products/55.jpg', 'Cesium', ''),
(56, 'resources/products/56.jpg', 'Barium', ''),
(57, 'resources/products/57.jpg', 'Lanthaan', ''),
(58, 'resources/products/58.jpg', 'Cerium', ''),
(59, 'resources/products/59.jpg', 'Praseodymium', ''),
(60, 'resources/products/60.jpg', 'Neodymium', ''),
(61, 'resources/products/61.jpg', 'Promethium', ''),
(62, 'resources/products/62.jpg', 'Samarium', ''),
(63, 'resources/products/63.jpg', 'Europium', ''),
(64, 'resources/products/64.jpg', 'Gadolinium', ''),
(65, 'resources/products/65.jpg', 'Terbium', ''),
(66, 'resources/products/66.jpg', 'Dysprosium', ''),
(67, 'resources/products/67.jpg', 'Holmium', ''),
(68, 'resources/products/68.jpg', 'Erbium', ''),
(69, 'resources/products/69.jpg', 'Thulium', ''),
(70, 'resources/products/70.jpg', 'Ytterbium', ''),
(71, 'resources/products/71.jpg', 'Lutetium', ''),
(72, 'resources/products/72.jpg', 'Hafnium', ''),
(73, 'resources/products/73.jpg', 'Tantaal', ''),
(74, 'resources/products/74.jpg', 'Wolfraam', ''),
(75, 'resources/products/75.jpg', 'Renium', ''),
(76, 'resources/products/76.jpg', 'Osmium', ''),
(77, 'resources/products/77.jpg', 'Iridium', ''),
(78, 'resources/products/78.jpg', 'Platina', ''),
(79, 'resources/products/79.jpg', 'Goud', ''),
(80, 'resources/products/80.jpg', 'Kwik', ''),
(81, 'resources/products/81.jpg', 'Thallium', ''),
(82, 'resources/products/82.jpg', 'Lood', ''),
(83, 'resources/products/83.jpg', 'Bismut', ''),
(84, 'resources/products/84.jpg', 'Polonium', ''),
(85, 'resources/products/85.jpg', 'Astaat', ''),
(86, 'resources/products/86.jpg', 'Radon', ''),
(87, 'resources/products/87.jpg', 'Francium', ''),
(88, 'resources/products/88.jpg', 'Radium', ''),
(89, 'resources/products/89.jpg', 'Actinium', ''),
(90, 'resources/products/90.jpg', 'Thorium', ''),
(91, 'resources/products/91.jpg', 'Protactinium', ''),
(92, 'resources/products/92.jpg', 'Uranium', ''),
(93, 'resources/products/93.jpg', 'Neptunium', ''),
(94, 'resources/products/94.jpg', 'Plutonium', ''),
(95, 'resources/products/95.jpg', 'Americium', ''),
(96, 'resources/products/96.jpg', 'Curium', ''),
(97, 'resources/products/97.jpg', 'Berkelium', ''),
(98, 'resources/products/98.jpg', 'Californium', ''),
(99, 'resources/products/99.jpg', 'Einsteinium', ''),
(100, 'resources/products/100.jpg', 'Fermium', ''),
(101, 'resources/products/101.jpg', 'Mendelevium', ''),
(102, 'resources/products/102.jpg', 'Nobelium', ''),
(103, 'resources/products/103.jpg', 'Lawrencium', ''),
(104, 'resources/products/104.jpg', 'Rutherfordium', ''),
(105, 'resources/products/105.jpg', 'Dubnium', ''),
(106, 'resources/products/106.jpg', 'Seaborgium', ''),
(107, 'resources/products/107.jpg', 'Bohrium', ''),
(108, 'resources/products/108.jpg', 'Hassium', ''),
(109, 'resources/products/109.jpg', 'Meitnerium', ''),
(110, 'resources/products/110.jpg', 'Darmstadtium', ''),
(111, 'resources/products/111.jpg', 'Röntgenium', ''),
(112, 'resources/products/112.jpg', 'Copernium', ''),
(113, 'resources/products/113.jpg', 'Ununtrium', ''),
(114, 'resources/products/114.jpg', 'Flerovium', ''),
(115, 'resources/products/115.jpg', 'Ununpentium', ''),
(116, 'resources/products/116.jpg', 'Livermorium', ''),
(117, 'resources/products/117.jpg', 'Ununseptium', ''),
(118, 'resources/products/118.jpg', 'Ununoctium', ''),
(122, 'resources/products/uva-logo.png', 'Universiterium', ''),
(126, 'resources/products/Opdracht1.png', 'Test', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_id` int(16) UNSIGNED NOT NULL,
  `tax_rate` int(3) NOT NULL,
  `address_id` int(16) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` set('pay','prep','preps','sent','del','canc') COLLATE latin1_general_ci NOT NULL,
  `user_id` int(16) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `tax_rate`, `address_id`, `date`, `state`, `user_id`) VALUES
(1, 21, 3, '2016-01-28 22:38:20', 'preps', 2),
(2, 21, 5, '2016-01-28 23:37:28', 'prep', 3),
(3, 21, 8, '2016-01-29 11:34:39', 'prep', 4),
(4, 21, 9, '2016-01-29 11:44:01', 'sent', 5),
(5, 21, 11, '2016-01-29 13:14:25', 'prep', 5),
(6, 21, 12, '2016-01-29 13:16:31', 'canc', 5),
(7, 21, 13, '2016-01-29 13:19:11', 'sent', 5),
(8, 21, 14, '2016-01-29 13:35:47', 'canc', 5),
(9, 21, 15, '2016-01-29 13:46:44', 'prep', 5),
(10, 21, 16, '2016-01-29 13:51:14', 'del', 5),
(11, 21, 17, '2016-01-29 13:54:33', 'canc', 5),
(12, 21, 18, '2016-01-29 13:58:49', 'del', 5),
(13, 21, 19, '2016-01-29 14:21:42', 'prep', 6),
(14, 21, 20, '2016-01-29 14:24:41', 'canc', 6),
(15, 21, 21, '2016-01-29 14:35:01', 'prep', 6),
(16, 21, 22, '2016-01-29 14:48:38', 'del', 6),
(17, 21, 23, '2016-01-29 15:04:02', 'canc', 6),
(18, 21, 24, '2016-01-29 15:16:54', 'del', 5),
(19, 21, 26, '2016-01-29 16:29:54', 'del', 5);

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

DROP TABLE IF EXISTS `prices`;
CREATE TABLE `prices` (
  `price_id` int(16) UNSIGNED NOT NULL,
  `price` int(16) NOT NULL,
  `time_set` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_id` int(16) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`price_id`, `price`, `time_set`, `product_id`) VALUES
(1, 101, '2016-01-28 21:41:13', 1),
(2, 401, '2016-01-28 21:41:13', 2),
(3, 694, '2016-01-28 21:41:13', 3),
(4, 901, '2016-01-28 21:41:13', 4),
(5, 1081, '2016-01-28 21:41:13', 5),
(6, 1201, '2016-01-28 21:41:13', 6),
(7, 1401, '2016-01-28 21:41:13', 7),
(8, 1600, '2016-01-28 21:41:13', 8),
(9, 1900, '2016-01-28 21:41:13', 9),
(10, 2018, '2016-01-28 21:41:13', 10),
(11, 2299, '2016-01-28 21:41:13', 11),
(12, 2431, '2016-01-28 21:41:13', 12),
(13, 2698, '2016-01-28 21:41:13', 13),
(14, 2809, '2016-01-28 21:41:13', 14),
(15, 3097, '2016-01-28 21:41:13', 15),
(16, 3207, '2016-01-28 21:41:13', 16),
(17, 3545, '2016-01-28 21:41:13', 17),
(18, 3995, '2016-01-28 21:41:13', 18),
(19, 3910, '2016-01-28 21:41:13', 19),
(20, 4008, '2016-01-28 21:41:13', 20),
(21, 4495, '2016-01-28 21:41:13', 21),
(22, 4787, '2016-01-28 21:41:13', 22),
(23, 5094, '2016-01-28 21:41:13', 23),
(24, 5200, '2016-01-28 21:41:14', 24),
(25, 5494, '2016-01-28 21:41:14', 25),
(26, 5585, '2016-01-28 21:41:14', 26),
(27, 5893, '2016-01-28 21:41:14', 27),
(28, 5869, '2016-01-28 21:41:14', 28),
(29, 6354, '2016-01-28 21:41:14', 29),
(30, 6538, '2016-01-28 21:41:14', 30),
(31, 6972, '2016-01-28 21:41:14', 31),
(32, 7264, '2016-01-28 21:41:14', 32),
(33, 7492, '2016-01-28 21:41:14', 33),
(34, 8797, '2016-01-28 21:41:14', 34),
(35, 7990, '2016-01-28 21:41:14', 35),
(36, 8380, '2016-01-28 21:41:14', 36),
(37, 8547, '2016-01-28 21:41:14', 37),
(38, 8762, '2016-01-28 21:41:14', 38),
(39, 8891, '2016-01-28 21:41:14', 39),
(40, 9122, '2016-01-28 21:41:14', 40),
(41, 9291, '2016-01-28 21:41:14', 41),
(42, 9595, '2016-01-28 21:41:14', 42),
(43, 9891, '2016-01-28 21:41:14', 43),
(44, 10107, '2016-01-28 21:41:14', 44),
(45, 10291, '2016-01-28 21:41:14', 45),
(46, 10642, '2016-01-28 21:41:14', 46),
(47, 10787, '2016-01-28 21:41:14', 47),
(48, 11241, '2016-01-28 21:41:14', 48),
(49, 11482, '2016-01-28 21:41:14', 49),
(50, 11871, '2016-01-28 21:41:14', 50),
(51, 12176, '2016-01-28 21:41:14', 51),
(52, 12760, '2016-01-28 21:41:14', 52),
(53, 12690, '2016-01-28 21:41:14', 53),
(54, 13130, '2016-01-28 21:41:14', 54),
(55, 13291, '2016-01-28 21:41:14', 55),
(56, 13733, '2016-01-28 21:41:14', 56),
(57, 13891, '2016-01-28 21:41:14', 57),
(58, 14012, '2016-01-28 21:41:14', 58),
(59, 14091, '2016-01-28 21:41:14', 59),
(60, 14424, '2016-01-28 21:41:14', 60),
(61, 14692, '2016-01-28 21:41:14', 61),
(62, 15036, '2016-01-28 21:41:14', 62),
(63, 15197, '2016-01-28 21:41:14', 63),
(64, 15725, '2016-01-28 21:41:14', 64),
(65, 15893, '2016-01-28 21:41:14', 65),
(66, 16250, '2016-01-28 21:41:14', 66),
(67, 16493, '2016-01-28 21:41:14', 67),
(68, 16726, '2016-01-28 21:41:14', 68),
(69, 16893, '2016-01-28 21:41:14', 69),
(70, 17304, '2016-01-28 21:41:14', 70),
(71, 17497, '2016-01-28 21:41:14', 71),
(72, 17849, '2016-01-28 21:41:14', 72),
(73, 18095, '2016-01-28 21:41:14', 73),
(74, 18384, '2016-01-28 21:41:14', 74),
(75, 18621, '2016-01-28 21:41:14', 75),
(76, 19023, '2016-01-28 21:41:14', 76),
(77, 19222, '2016-01-28 21:41:14', 77),
(78, 19508, '2016-01-28 21:41:14', 78),
(79, 19697, '2016-01-28 21:41:14', 79),
(80, 20059, '2016-01-28 21:41:14', 80),
(81, 20438, '2016-01-28 21:41:14', 81),
(82, 20720, '2016-01-28 21:41:14', 82),
(83, 20898, '2016-01-28 21:41:14', 83),
(84, 20898, '2016-01-28 21:41:14', 84),
(85, 20998, '2016-01-28 21:41:14', 85),
(86, 22200, '2016-01-28 21:41:14', 86),
(87, 22300, '2016-01-28 21:41:14', 87),
(88, 22603, '2016-01-28 21:41:14', 88),
(89, 22707, '2016-01-28 21:41:14', 89),
(90, 23204, '2016-01-28 21:41:14', 90),
(91, 23104, '2016-01-28 21:41:14', 91),
(92, 23803, '2016-01-28 21:41:14', 92),
(93, 23705, '2016-01-28 21:41:14', 93),
(94, 23905, '2016-01-28 21:41:14', 94),
(95, 24106, '2016-01-28 21:41:14', 95),
(96, 24406, '2016-01-28 21:41:14', 96),
(97, 24908, '2016-01-28 21:41:14', 97),
(98, 25100, '2016-01-28 21:41:14', 98),
(99, 25200, '2016-01-28 21:41:14', 99),
(100, 25700, '2016-01-28 21:41:14', 100),
(101, 25800, '2016-01-28 21:41:14', 101),
(102, 25901, '2016-01-29 14:23:34', 102),
(103, 26200, '2016-01-28 21:41:14', 103),
(104, 26100, '2016-01-28 21:41:14', 104),
(105, 26200, '2016-01-28 21:41:14', 105),
(106, 27100, '2016-01-28 21:41:15', 106),
(107, 26400, '2016-01-28 21:41:15', 107),
(108, 26900, '2016-01-28 21:41:15', 108),
(109, 26800, '2016-01-28 21:41:15', 109),
(110, 28100, '2016-01-28 21:41:15', 110),
(111, 28200, '2016-01-28 21:41:15', 111),
(112, 28317, '2016-01-28 21:41:15', 112),
(113, 28618, '2016-01-28 21:41:15', 113),
(114, 28900, '2016-01-28 21:41:15', 114),
(115, 28919, '2016-01-28 21:41:15', 115),
(116, 29200, '2016-01-28 21:41:15', 116),
(117, 29100, '2016-01-28 21:41:15', 117),
(118, 29300, '2016-01-28 21:41:15', 118),
(122, 2500, '2016-01-29 12:39:38', 122);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `product_id` int(16) UNSIGNED NOT NULL,
  `serial_number` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `category_id` int(16) UNSIGNED DEFAULT NULL,
  `supplier_id` int(16) UNSIGNED DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  `supply` int(16) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `serial_number`, `name`, `description`, `category_id`, `supplier_id`, `visible`, `supply`) VALUES
(1, '1', 'Waterstof', 'Waterstof is een chemisch element met symbool H (La: Hydrogenium) en atoomnummer 1. Het element komt als dusdanig niet in geïsoleerde vorm voor in normale omstandigheden, maar vormt door de hoge reactiviteit verbindingen. Onder atmosferische omstandigheden vormt waterstof een twee-atomig molecule: diwaterstof, dat meestal gewoon als waterstof of waterstofgas aangeduid wordt. Waterstof is het meest voorkomende element in het universum. Het normale isotoop van waterstof protium bestaat maar uit één proton en één elektron en bevat dus geen neutronen. Waterstof is het enige element dat zonder neutronen bestaat.', 17, NULL, 1, 84),
(2, '2', 'Helium', 'Helium is een scheikundig element met symbool He en atoomnummer 2. Het is een kleurloos edelgas.Helium is veel lichter dan lucht. Het wordt daarom vaak gebruikt als vulmiddel voor ballonnen en luchtschepen. Helium verdient de voorkeur boven waterstof, dat weliswaar lichter is, maar zeer brandbaar. Het stijgvermogen van helium is 93% van dat van waterstof. Helium is wel veel kostbaarder dan waterstof, omdat het moeilijker te winnen is. Bovendien kan het niet met de cascademethode vloeibaar gemaakt worden, waardoor het duur in het gebruik is, bijvoorbeeld bij transport.', 16, NULL, 1, 91),
(3, '3', 'Lithium', 'Lithium is een scheikundig element met symbool Li en atoomnummer 3. Het is een zilverwit alkalimetaal.Lithium werd in 1817 ontdekt door Johan Arfwedson. De naam is afgeleid van het Griekse λιθος (lithos) dat ''steen'' betekent. Arfwedson ontdekte het element tijdens het onderzoeken van mineralen die afkomstig waren uit de Utö-mijnen op het Zweedse eiland Utö. Christian Gmelin observeerde in 1818 dat lithiumzouten in een vlam een heldere rode kleur gaven.', 1, NULL, 1, 100),
(4, '4', 'Beryllium', 'Beryllium is een scheikundig element met symbool Be en atoomnummer 4. Het is een donkergrijs aardalkalimetaal.Als eerste herkende Nicolas-Louis Vauquelin het in 1798 in oxidische vorm. In 1828 slaagden zowel Friedrich Wöhler als Antoine Bussy er in het metaal door reductie van berylliumchloride met kalium te bereiden. De naam beryllium is afkomstig van het Grieks βήρυλλος, bērullos, beryl, in het Prakrit veruliya (वॆरुलिय‌), in het Pali veḷuriya (वेलुरिय); ] veḷiru (भेलिरु) of, viḷar (भिलर्), bleek worden, hetgeen verwijst naar de bleke kleur van de halfedelsteen beril. Naar verluidt heeft een oplossing van beryllium een zoetige smaak, vandaar dat dit element een tijd de naam glucinium heeft gedragen (van het Griekse glykys, wat zoet betekent).', 2, NULL, 1, 99),
(5, '5', 'Boor', 'Boor of borium (niet te verwarren met bohrium) is een scheikundig element met symbool B en atoomnummer 5. Het is een zwart metalloïde.Boorverbindingen waren al in de oudheid bekend. De naam komt van het Arabische buraq voor borax, een mineraal dat het voornaamste erts voor boorwinning is. Borax is een boraat (meer bepaald natriumtetraboraat), een zout van boorzuur. Het element is daaruit niet zo makkelijk vrij te maken, omdat dat sterke reductoren vereist, zoals magnesium of aluminium. Het element werd daarom pas in 1808 door Sir Humphry Davy, Louis Gay-Lussac en Louis Jacques Thénard bereid. Op deze manier bereid wordt boor echter verontreinigd door het metaal. Door ontleding van vluchtige halogeniden valt het element echter met weinig onzuiverheden te bereiden.', 11, NULL, 1, 100),
(6, '6', 'Koolstof', 'Koolstof is een scheikundig element met symbool C en atoomnummer 6. Het is een niet-metaal dat in verschillende vormen, allotropen, voorkomt. In de natuur komen de allotropen diamant, grafiet, amorfe koolstof en het zeldzame lonsdaleïet voor. Koolstof werd al in de prehistorische oudheid ontdekt en gebruikt in de vorm van houtskool, dat bereid werd door organisch materiaal (meestal hout) te verhitten in een zuurstofarme omgeving. Het Engelse carbon is dan ook afgeleid van het Latijnse woord voor houtskool. Ook diamant, een andere allotroop van koolstof, is al lang bekend. Pas sinds enkele decennia is het mogelijk diamant synthetisch te vervaardigen.', 12, NULL, 1, 90),
(7, '7', 'Stikstof', 'Stikstof is een scheikundig element met symbool N en atoomnummer 7. Stikstof is een niet-metaal uit de stikstofgroep (groep 15). Losse atomen van dit element zijn zeer reactief en verbinden zich direct met andere stikstofatomen. Hierbij wordt meestal distikstof gevormd (N2 of moleculaire stikstof), wat de gangbare verschijningsvorm van stikstof is. Op kamertemperatuur verkeert N2 in gasvorm.', 13, NULL, 1, 98),
(8, '8', 'Zuurstof', 'Zuurstof is een chemisch element met symbool O (Uit het Latijn: oxygenium) en atoomnummer 8. Het is een niet-metaal dat tot de zuurstofgroep (groep VIa of groep 16) in het periodiek systeem behoort. Zuurstof komt als enkelvoudige stof vooral als dizuurstof (O2) in de atmosfeer voor. In samengestelde vorm is het eveneens een wijdverspreid element omdat alle water van de oceanen en alle silicaten waar de aardkorst uit bestaat zuurstof bevatten. Gemeten naar gewicht is zuurstof veruit het meest voorkomende element in het menselijk lichaam: dat bestaat voor ongeveer 65 % uit zuurstof (voornamelijk in de vorm van water) Als gas is zuurstof kleurloos, reukloos en smaakloos. Als vloeistof is het lichtblauw van kleur.', 14, NULL, 1, 95),
(9, '9', 'Fluor', 'Fluor is een chemisch element met symbool F en atoomnummer 9. Het behoort tot de groep van de halogenen (groep VIIa). Het element komt in monoatomische vorm niet voor in de natuur. Het vormt diatomische moleculen difluor (F2), die wegens de hoge reactiviteit zelf ook nauwelijks in de natuur te vinden zijn. Het element komt dus in de natuur vrijwel alleen in samengestelde stoffen voor.', 15, NULL, 1, 100),
(10, '10', 'Neon', 'Neon is een chemisch element met symbool Ne en atoomnummer 10. Het is een kleurloos edelgas.Neon is in 1898 ontdekt door William Ramsay en Morris Travers, vrijwel gelijktijdig met de ontdekking van xenon en krypton. Het Griekse woord neon betekent nieuw.', 16, NULL, 1, 99),
(11, '11', 'Natrium', 'Natrium is een chemisch element met symbool Na en atoomnummer 11. Het is een zilverkleurig alkalimetaal. In het Engels en in de Romaanse talen heet het element sodium/sodio enzovoorts, dat men ook in slechte vertalingen tegenkomt. Natrium is bij kamertemperatuur een vast metaal dat zeer snel met de zuurstof uit de lucht reageert tot natriumoxide en met water tot natriumhydroxide en waterstof.', 1, NULL, 1, 100),
(12, '12', 'Magnesium', 'Magnesium is een scheikundig element met symbool Mg en atoomnummer 12. Het is een zilverwit aardalkalimetaal. Magnesium is genoemd naar het district Magnesia in Thessalië in Griekenland. Magnesium was in de vorm van magnesiumoxide al heel lang bekend, maar pas in 1755 werd door de Schotse wetenschapper Joseph Black onderkend dat men bij magnesiumoxide (het werd toen nog niet zo genoemd) met een nieuwe stof te maken had. Tot die tijd werden magnesiumoxide en calciumoxide met elkaar verward en beide ongebluste kalk genoemd. Toen in 1803 in Moravië een aanzienlijke afzetting van natuurlijk magnesiumcarbonaat werd ontdekt, werd dit door C.F. Ludwig aanvankelijk talcum carbonatum genoemd.', 2, NULL, 1, 94),
(13, '13', 'Aluminium', 'Aluminium is een scheikundig element met symbool Al en atoomnummer 13. Het is een zilverwit hoofdgroepmetaal. De naam is afgeleid van het Latijnse woord alumen dat aluin betekent. Verbindingen van aluminium waren al in de oudheid bekend. Zo werd aluin onder meer gebruikt om bloedingen te stelpen. Het is echter niet eenvoudig het metaal uit aluin vrij te maken. Aluminium werd in 1807 ontdekt door Humphry Davy, die het trachtte te bereiden uit aluminiumoxide. In 1825 bereidde Hans Christian Ørsted een onzuivere vorm van aluminium uit aluminiumchloride en kaliumamalgaam. Jarenlang was het metaal zo kostbaar dat het in ornamenten toegepast werd, getuige de massief aluminium kap op de toren van het Washington Monument.', 11, NULL, 1, 97),
(14, '14', 'Silicium', 'Silicium of kiezel is een scheikundig element met symbool Si en atoomnummer 14. Het is een donkergrijs metalloïde. Silicium is voor het eerst geïdentificeerd door Antoine Lavoisier in 1787. Later werd het door Humphry Davy aangezien voor een verbinding. Pas in 1811 werd duidelijk dat het tóch om een element ging, toen Louis Gay-Lussac onzuiver amorf silicium verkreeg door siliciumtetrafluoride te verhitten in aanwezigheid van kalium. In 1824 maakte Jöns Jacob Berzelius zuiver silicium door dezelfde methode als Lussac te gebruiken, maar door daarna het product meerdere malen uit te wassen. Zijn naam heeft silicium te danken aan het Latijnse Silex, vuursteen. In 1854 bereidde Henri Saint-Claire Deville voor het eerst kristallijn silicium, de tweede allotrope vorm waarin silicium voorkomt.', 12, NULL, 1, 100),
(15, '15', 'Fosfor', 'Fosfor is een scheikundig element met symbool P en atoomnummer 15. Het is een niet-metaal dat in verschillende kleuren kan voorkomen waarvan rode fosfor en witte fosfor - (vroeger) ook gele fosfor genoemd - het bekendst zijn. Fosfor is in 1669 ontdekt door de Duitse alchemist Hennig Brand toen hij urine onderzocht. In een poging de zouten in te dampen, viel het Brand op dat er een wittige stof achterbleef die oplichtte in het donker en zeer brandbaar was. De naam heeft fosfor te danken aan het Griekse woord phosphoros, dat (net als het Latijnse woord lucifer) te vertalen is met lichtdrager. Phosphoros was in de Griekse mythologie een van de personificaties van de planeet Venus.', 13, NULL, 1, 100),
(16, '16', 'Zwavel', 'Zwavel is een scheikundig element met symbool S en atoomnummer 16. Het is een geel niet-metaal. Al in de 9e eeuw was bekend dat een mengsel van zwavel, kool en teer uiterst brandbaar is en daarom werd het regelmatig toegepast bij oorlogshandelingen. In de 12de eeuw werd in China buskruit uitgevonden dat een mengsel was van kaliumnitraat, houtskool en zwavel. In de mythologie werd zwavel vaak in verband gebracht met de hel. De naam zwavel is vermoedelijk afgeleid van het indo-europees *suel- „doen opzwellen“, koken.', 14, NULL, 1, 100),
(17, '17', 'Chloor', 'Chloor is een scheikundig element met symbool Cl en atoomnummer 17. Het behoort tot de groep van de halogenen. Chloor komt bij kamertemperatuur voor als een geel/groen en zeer giftig gas dichloor (Cl2). Chloor is in 1774 door Carl Scheele ontdekt, maar hij besefte niet dat het een element was. Hij vermoedde dat het een verbinding van zuurstof was. Pas in 1810 kwam Humphry Davy tot die gevolgtrekking. In 1823 ontdekte Michael Faraday hoe chloor vloeibaar gemaakt kon worden.', 15, NULL, 1, 97),
(18, '18', 'Argon', 'Argon is een scheikundig element met symbool Ar en atoomnummer 18. Het is een kleurloos edelgas. In 1785 veronderstelde de Britse wetenschapper Henry Cavendish dat argon in de lucht voor zou moeten komen maar kon dat niet aantonen. Pas in 1894 konden Lord Rayleigh en William Ramsay aantonen dat argon daadwerkelijk in de lucht voorkwam. Door middel van een experiment (zuivere lucht werd ontdaan van andere stoffen, zoals zuurstof, koolstofdioxide, water en stikstofgas) konden zij het bestaan van deze stof aantonen. De naam komt van het Griekse ἀργος dat te vertalen is als lui of niet actief. Hierbij werd verwezen naar de inerte eigenschappen van dit element.', 16, NULL, 1, 99),
(19, '19', 'Kalium', 'Kalium is een scheikundig element met symbool K en atoomnummer 19. Het is een zilverwit alkalimetaal. In de Angelsakische en Romaanse landen staat het element bekend als potassium. Deze naam is afgeleid van het Nederlandse woord potas. Het is opmerkelijk dat in het Nederlands en veel Germaanse en Slavische talen de uit het Arabisch afkomstige naam wordt gehanteerd, terwijl in veel andere talen een uit het Nederlands afgeleide naam wordt gebruikt. In 1702 vermoedde G.E. Stahl een verschil tussen soda (Na2CO3) en potas (K2CO3). De naam kalium komt van het Arabische al-qali (potas), de naam die werd gebruikt voor zowel kalium als voor natrium.', 1, NULL, 1, 100),
(20, '20', 'Calcium', 'Calcium is een scheikundig element met symbool Ca en atoomnummer 20. Het is een zilverwit aardalkalimetaal. Calciumoxide (CaO) werd al door de Romeinen gebruikt, maar pas in 1808 werd het als element ontdekt en door middel van elektrolyse geïsoleerd door Humphry Davy. De naam is afkomstig van het Latijnse Calx, dat kalksteen betekent.', 2, NULL, 1, 100),
(21, '21', 'Scandium', 'Scandium is een scheikundig element met symbool Sc en atoomnummer 21. Het is een zilverwit overgangsmetaal. In 1869 voorspelde Dmitri Mendelejev op basis van zijn tabel het bestaan van scandium en hij noemde het ekaboron omdat het element in zijn tabel onder boor stond. Tien jaar later waren de Zweedse chemicus Lars Fredrick Nilson en zijn team met behulp van spectrumanalyse op zoek naar lanthaniden toen zij stuitten op scandium. Rondom die tijd kwam ook Per Teodor Cleve tot dezelfde ontdekking. Scandium heeft de naam te danken aan de eerst genoemde ontdekker (scandia is de Latijnse naam voor Scandinavië). Pas in 1960 bleek men in staat om op grote schaal zuivere scandium te winnen. ', 3, NULL, 1, 100),
(22, '22', 'Titanium', 'Titanium of titaan is een scheikundig element met symbool Ti en atoomnummer 22. Het is een grijs metallisch overgangsmetaal, het behoort met zirkonium (Zr), hafnium (Hf) en rutherfordium (Rf) tot de titaangroep. In 1791 ontdekte William Gregor een nog onbekend element in het mineraal ilmeniet. In 1795 herontdekte Martin Heinrich Klaproth het element, ditmaal in rutielerts en hij noemde het titanium naar de titanen uit de Griekse mythologie. Doordat het metaal bij hoge temperaturen makkelijk reageert met zuurstof en koolstof, is het moeilijk zuiver titanium te produceren. In 1922 lukte het Anton Eduard van Arkel zuiver metallisch titaan te bereiden (jodideproces of van Arkel-de Boerproces).', 4, NULL, 1, 100),
(23, '23', 'Vanadium', 'Vanadium is een scheikundig element met symbool V en atoomnummer 23. Het is een zilvergrijs overgangsmetaal. Vanadium is in 1801 ontdekt door de Spaans-Mexicaanse mineraloog Andrés Manuel del Río in de buurt van Mexico-Stad. Del Río noemde het mineraal bruin lood (later werd dit mineraal bekend als vanadiet) en metaal panchromium, omdat de zouten ervan allerlei verschillende kleuren hadden. Omdat de meeste zouten die met panchromium gevormd konden worden een rode kleur kregen bij verhitting, hernoemde hij het later naar erythronium. Later wist een Franse chemicus Del Río ervan te overtuigen dat hij geen nieuw element had ontdekt, maar slechts een onzuivere vorm van chroom.', 5, NULL, 1, 100),
(24, '24', 'Chroom', 'Chroom of chromium is een chemisch element met symbool Cr en atoomnummer 24. Het is een zilverkleurig overgangsmetaal. In 1761 vond Johann Gottlob Lehmann in de bergen van de Oeral een oranje-rood mineraal dat hij Siberisch rood lood noemde, omdat hij dacht dat het een loodverbinding was met seleen en ijzer. Later bleek dat hij het mineraal crocoiet had gevonden, dat uit lood(II)chromaat (PbCrO4) bestaat.', 6, NULL, 1, 100),
(25, '25', 'Mangaan', 'Mangaan is een scheikundig element met symbool Mn en atoomnummer 25. Het is een zilverkleurig overgangsmetaal. Al sinds de prehistorie wordt mangaan gebruikt. 15.000 jaar voor het begin van onze jaartelling werd het mineraal pyrolusiet (mangaan(IV)oxide, mangaandioxide) al gebruikt als pigment in verf. De Egyptenaren en Romeinen pasten mangaan toe tijdens de productie van glas, om de groenkleuring veroorzaakt door ijzerverontreinigingen tegen te gaan, maar ook om het glas een typische amethistkleur te geven. De Spartanen maakten legeringen van mangaan en ijzer waardoor de smeedbaarheid en hardheid van het ijzer verbeterd werd.', 7, NULL, 1, 100),
(26, '26', 'IJzer', 'IJzer is een scheikundig element met symbool Fe (uit het Latijn: ferrum) en atoomnummer 26. Het is een grijs, ruw overgangsmetaal. In de volksmond wordt de term ijzer vaak gebruikt voor materiaal dat eigenlijk staal heet, een legering van ijzer en koolstof.Uit opgravingen blijkt dat rond 4000 v.Chr. ijzer al werd gebruikt in Sumer en het Oude Egypte voor speerpunten en ornamenten. Veelal was het ijzer hiervoor afkomstig van ingeslagen meteorieten (het zogenaamde meteoorijzer). In de daarop volgende eeuwen werd het gebruik van ijzer verspreid naar Mesopotamië, Anatolië, Midden-Oosten en andere gebieden. IJzer was in die dagen een uiterst duur metaal.', 8, NULL, 1, 100),
(27, '27', 'Kobalt', 'Kobalt is een scheikundig element met symbool Co en atoomnummer 27. Het is een zilverkleurig overgangsmetaal. Door de Egyptenaren, Grieken en Romeinen werden kobaltverbindingen gebruikt voor het kleuren van glas. In Perzië werd een ketting gevonden met door kobaltverbindingen gekleurde blauwe glaskralen uit ongeveer 2250 v.Chr. De Chinezen gebruikten in de tijd van de Tang- en Ming-dynastie kobaltverbindingen voor het kleuren van porselein. Het element zelf werd omstreeks 1730 ontdekt door Georg Brandt tijdens het onderzoeken van mineralen. Deze Zweedse wetenschapper was toen in staat om aan te tonen dat kobalt zorgde voor de blauwe kleur en niet – zoals eerder aangenomen – bismut.', 8, NULL, 1, 100),
(28, '28', 'Nikkel', 'Nikkel is een scheikundig element met symbool Ni en atoomnummer 28. Het is een zilverwit/grijs overgangsmetaal. In het gebied dat tegenwoordig bekend is als Syrië zijn bronzen voorwerpen gevonden die nikkel bevatten. De oudste sporen van het gebruik van nikkel leiden terug tot 3500 v.Chr. Uit oude Chinese geschriften blijkt dat nikkelhoudende mineralen zoals nikkoliet werden gebruikt om glas een groene kleur te geven.', 8, NULL, 1, 100),
(29, '29', 'Koper', 'Koper is een scheikundig element met symbool Cu en atoomnummer 29. Het is een rood/geel overgangsmetaal dat in ongelegeerde vorm ook als roodkoper bekendstaat. Opgravingen in het noorden van wat tegenwoordig bekend is als Irak, hebben aangetoond dat koper al werd gebruikt rond 8700 v.Chr. Andere opgravingen wijzen uit dat men in 5000 v.Chr. koper al smolt en isoleerde uit koperhoudende mineralen zoals malachiet en azuriet.', 9, NULL, 1, 99),
(30, '30', 'Zink', 'Zink is een scheikundig element met symbool Zn en atoomnummer 30. Het is een blauw/wit overgangsmetaal. Zinklegeringen worden al eeuwenlang gebruikt. In Palestina en het vroegere Transsylvanië zijn objecten gevonden die tot 87% zink bevatten en dateren uit 1400 v.Chr. Rond het jaar 1000 was men in India al in staat zink te smelten en gedeeltelijk te zuiveren. Aan het einde van de 14e eeuw konden Hindoestanen zink onderscheiden van de toen al bekende andere metalen. In de Westerse Wereld wordt de ontdekking van zink veelal toegeschreven aan de Duitser Andreas Sigismund Marggraf, die het in het jaar 1746 isoleerde door het mineraal calamien te reduceren met houtskool. De herkomst van de naam ''zink'' is onduidelijk.', 10, NULL, 1, 100),
(31, '31', 'Gallium', 'Gallium is een scheikundig element met symbool Ga en atoomnummer 31. Het is een zilverwit hoofdgroepmetaal. Toen het periodiek systeem voor het eerst werd voorgesteld was het element nog niet bekend en een van de belangrijkste voorspellingen die Dmitri Mendelejev op grond van zijn systeem deed, was dat er nog een element in de boorgroep gevonden moest worden, één periode na aluminium. Hij noemde het eka-aluminium, waarbij eka een Sanskrietvoorvoegsel is dat één betekent. Hij voorspelde dat het iets zwaarder dan zink zou zijn en vooral driewaardige verbindingen zou vormen. In 1875 vond Paul-Émile Lecoq de Boisbaudran het element door middel van spectroscopie, en in hetzelfde jaar isoleerde hij het metaal door elektrolyse van een oplossing van galliumhydroxide in kaliumhydroxide.', 11, NULL, 1, 100),
(32, '32', 'Germanium', 'Germanium is een scheikundig element met als symbool Ge en atoomnummer 32. Het is een vrij hard grijswit metalloïde, dat behoort tot de koolstofgroep. Zuiver germanium is een halfgeleider. Net zoals het vergelijkbare element silicium komt het in de natuur niet in zuivere vorm voor, maar gebonden aan andere elementen, zoals zuurstof. Het komt voor in verschillende mineralen, zoals argyrodiet, germaniet en renieriet. De abundantie van het element op Aarde is vrij laag: de hoeveelheid in de aardkorst bedraagt 1,4 tot 1,5 ppm. In de oceaan komt het voor in concentraties van 50 nanogram per liter. Dat is de reden waarom germanium pas op het einde van de 19e eeuw werd ontdekt.', 12, NULL, 1, 100),
(33, '33', 'Arseen', 'Arseen of arsenicum is een scheikundig element met symbool As en atoomnummer 33. Het is een metalloïde dat een aantal verschillende allotropen kent. Ook arseen(III)oxide, As2O3 wordt soms (foutief) aangeduid als arseen. Vermoedelijk heeft Albertus Magnus in 1250 het element voor het eerst geïsoleerd. In 1649 beschreef Johann Schröder twee manieren om arseen te isoleren.', 13, NULL, 1, 100),
(34, '34', 'Seleen', 'Seleen of selenium is een scheikundig element met symbool Se en atoomnummer 34. Het is een grijs niet-metaal. Seleen is in 1817 door Jöns Jacob Berzelius ontdekt tijdens het onderzoeken van telluur. Pas vanaf ongeveer 1970 werden er steeds meer toepassingen gevonden voor seleen.', 14, NULL, 1, 100),
(35, '35', 'Broom', 'Broom is een scheikundig element met symbool Br en atoomnummer 35. Het element behoort tot de groep van de halogenen. Als enkelvoudige stof vormt het diatomische moleculen dibroom (Br2), een stof die op aarde niet in de natuur voorkomt. Het element komt vooral voor onder de vorm van zouten, vooral bromiden en bromaten. Broom (het Griekse woord bromos betekent stinkend) werd in 1826 ontdekt door Antoine-Jérôme Balard, maar werd voor het eerst industrieel geproduceerd rond 1860.', 15, NULL, 1, 100),
(36, '36', 'Krypton', 'Krypton is een scheikundig element met symbool Kr en atoomnummer 36. Het is een kleurloos edelgas. In 1898 is krypton ontdekt door William Ramsay en Morris Travers. Het bleef over bij de ontleding van vloeibare lucht na het verwijderen van water, zuurstof, stikstof, helium en argon. Een week later ontdekte het duo op dezelfde manier ook neon.', 16, NULL, 1, 99),
(37, '37', 'Rubidium', 'Rubidium is een scheikundig element met symbool Rb en atoomnummer 37. Het is een zilverwit alkalimetaal. Rubidium is in 1861 ontdekt door de Duitse wetenschappers Robert Bunsen en Gustav Kirchhoff tijdens het bestuderen van het mineraal lepidoliet met behulp van een spectroscoop. Vóór ongeveer 1920 werd het element voornamelijk gebruikt voor onderzoek, later kwamen er ook industriële toepassingen. De naam rubidium is afkomstig van het Latijnse rubidus, dat diepste rood betekent, vanwege de twee karakteristieke heldere rode spectraallijnen.', 1, NULL, 1, 100),
(38, '38', 'Strontium', 'Strontium is een scheikundig element met symbool Sr en atoomnummer 38. Het is een zilverwit aardalkalimetaal. In 1790 was Adair Crawford in staat om het mineraal strontianiet te onderscheiden van verschillende bariummineralen. Acht jaar later ontdekte Martin Heinrich Klaproth het element zelf en in 1808 werd het voor het eerst met behulp van elektrolyse geïsoleerd door Humphry Davy. Het element is vernoemd naar de Schotse plaats Strontian waar strontiumhoudende mineralen voor het eerst werden ontdekt.', 2, NULL, 1, 100),
(39, '39', 'Yttrium', 'Yttrium is een scheikundig element met symbool Y en atoomnummer 39. Het is een zilverwit overgangsmetaal. In 1794 is yttriumoxide (Y2O3) ontdekt in het mineraal gadoliniet door de Finse chemicus en geoloog Johan Gadolin. Later is het in 1828 voor het eerst geïsoleerd door Friedrich Wöhler door yttriumchloride (YCl3) te reduceren met kalium. Het element is vernoemd naar de Zweedse groeve Ytterby. In de omgeving werden en worden lanthanidehoudende mineralen gevonden waarin ook vaak yttrium wordt aangetroffen. Andere elementen die naar deze stad zijn vernoemd zijn erbium, terbium en ytterbium.', 3, NULL, 1, 100),
(40, '40', 'Zirkonium', 'Zirkonium of zirkoon is een scheikundig element met symbool Zr en atoomnummer 40. Het is een goudkleurig overgangsmetaal. Zirkonium is in 1789 ontdekt door de Duitse chemicus Martin Heinrich Klaproth tijdens het onderzoeken van een jargon, een lichte zirkoon, uit Sri Lanka. Hij noemde het nieuwe element Zirkonerde (zirconia). In 1824 is het in onzuivere vorm voor het eerst geïsoleerd door de Zweedse chemicus Jöns Jacob Berzelius door een mengsel van kalium en zirkoniumfluoride te verhitten. Pas in 1914 is zirkonium in zuivere vorm geïsoleerd. De naam zirkonium is afgeleid van het mineraal zirkoon, waarin het aangetroffen werd. De naam zirkoon is te herleiden tot het Perzische zargūn, dat goudkleurig betekent.', 4, NULL, 1, 100),
(41, '41', 'Niobium', 'Niobium is een scheikundig element met symbool Nb en atoomnummer 41. Het is een glanzend wit overgangsmetaal. Het krijgt een typerende blauwe glans als het langere tijd aan de lucht wordt blootgesteld bij kamertemperatuur. Niobium is in 1801 ontdekt door de Engelse chemicus Charles Hatchett toen hij het mineraal columbiet onderzocht dat hem door John Winthrop, de eerste gouverneur van Connecticut, was toegestuurd. Hij noemde het nieuwe element columbium, naar Columbia, een allegorische benaming voor de Verenigde Staten. Niobium is in 1801 ontdekt door de Engelse chemicus Charles Hatchett toen hij het mineraal columbiet onderzocht dat hem door John Winthrop, de eerste gouverneur van Connecticut, was toegestuurd.', 5, NULL, 1, 100),
(42, '42', 'Molybdeen', 'Molybdeen is een chemisch element met symbool Mo en atoomnummer 42. Het is een grijs overgangsmetaal. In 1778 was de Zweedse chemicus Carl Wilhelm Scheele in staat om molybdeenoxide te isoleren uit mineralen. Vier jaar later isoleerde de Zweedse geoloog Peter Jacob Hjelm voor het eerst elementair molybdeen door het oxide te reduceren met koolstof. De naam molybdeen komt van het Griekse Μόλυβδος, molybdos en is te vertalen als op lood lijkend.', 6, NULL, 1, 100),
(43, '43', 'Technetium', 'Technetium is een scheikundig element met symbool Tc en atoomnummer 43. Het is een zilvergrijs overgangsmetaal, dat in 1937 werd ontdekt. Het werd ontdekt door de Italiaanse wetenschappers Carlo Perrier en Emilio Segrè toen ze een molybdeenmonster onderzochten dat hen was toegestuurd door Ernest Lawrence. Het monster was op de Universiteit van Californië - Berkeley in een cyclotron gebombardeerd met deuteriumkernen waardoor de isotoop 97Tc ontstond. Technetium was het eerste kunstmatig geproduceerde element. Het woord ''technetium'' verwijst naar het Griekse woord ''technetos'' (τεχνητός), wat ''kunstmatig'' betekent.', 7, NULL, 1, 100),
(44, '44', 'Ruthenium', 'Ruthenium is een scheikundig element met symbool Ru en atoomnummer 44. Het is een zilverwit overgangsmetaal. Berzelius en Osann bestudeerden, onafhankelijk van elkaar, in 1827 het residu dat achterbleef wanneer ruw platina, afkomstig uit het Oeralgebergte, werd opgelost in koningswater. Berzelius vond geen ongebruikelijke metalen, maar Osann dacht drie nieuwe ontdekt te hebben. Één daarvan noemde hij ruthenium, naar het Latijnse woord voor Rusland, Ruthenia. Osann trok zijn bewering later weer in, omdat noch hij, noch Berzelius zijn experiment succesvol kon herhalen.', 8, NULL, 1, 100),
(45, '45', 'Rodium', 'Rodium is een scheikundig element met symbool Rh en atoomnummer 45. Het is een zilverwit overgangsmetaal. Rodium is in 1803 ontdekt door Engelse chemicus William Hyde Wollaston tijdens het onderzoeken van ruw platina-erts afkomstig uit Zuid-Afrika. Eerst loste hij het erts op in koningswater en neutraliseerde het zuur met natriumhydroxide. Door ammoniumchloride toe te voegen sloeg het platina neer en na het verwijderen van nog wat andere elementen bleven er rode rodiumchloride kristallen over. Hieruit werd door reductie met waterstofgas zuiver rodium geïsoleerd. De naam rodium (vroeger rhodium) komt van het Griekse ῥόδον, rhodon, dat roos betekent.', 8, NULL, 1, 100),
(46, '46', 'Palladium', 'Palladium is een scheikundig element met symbool Pd en atoomnummer 46. Het is een zilverwit overgangsmetaal. Palladium is in 1803 ontdekt door William Hyde Wollaston tijdens het onderzoeken van ruw platinaerts uit Zuid-Amerika. Palladium is vernoemd naar de in 1802 ontdekte planetoïde Pallas.', 8, NULL, 1, 100),
(47, '47', 'Zilver', 'Zilver is een scheikundig element met symbool Ag en atoomnummer 47. Het is een wit overgangsmetaal. Zilver werd al voor het begin van onze jaartelling gebruikt voor versiersels en als betaalmiddel. Uit opgravingen blijkt dat al 4000-3500 v.Chr. zilver werd gescheiden van lood op eilanden in de Egeïsche Zee en Anatolië. Vaak werd zilver geassocieerd met de maan, de zee en verschillende goden. In de alchemie werd voor zilver het symbool van een halve maan gebruikt en alchemisten noemden het Luna. Van het metaal kwik werd gedacht dat het een soort zilver was. In sommige talen blijkt dat nog uit de naam die kwik heeft zoals quicksilver in het Engels of kwikzilver (met de betekenis levend zilver) in wat ouder Nederlands. Veel later bleek het om twee volstrekt verschillende elementen te gaan.', 9, NULL, 1, 100),
(48, '48', 'Cadmium', 'Cadmium is een scheikundig element met symbool Cd en atoomnummer 48. Het is een zilvergrijs overgangsmetaal. Cadmium werd in 1817 ontdekt door de Duitse chemicus Friedrich Strohmeyer als een onzuiverheid in het mineraal calamiet (zinkcarbonaat). Gedurende zo''n 100 jaar was Duitsland het enige land ter wereld dat op grote schaal cadmium produceerde. Alhoewel vandaag de dag bekend is dat cadmium en cadmiumverbindingen uiterst giftig zijn, stelde de Britse Pharmaceutical Codex in 1907 dat cadmiumjodide in de geneeskunde toegepast kon worden ter bestrijding van enkele ziekten.', 10, NULL, 1, 100),
(49, '49', 'Indium', 'Indium is een scheikundig element met symbool In en atoomnummer 49. Het is een zilvergrijs hoofdgroepmetaal. Indium is in 1863 ontdekt door Ferdinand Reich en Theodore Richter terwijl zij met een spectrograaf in zinkertsen op zoek waren naar thallium. Vier jaar later was Richter in staat om het metaal te isoleren. De naam Indium is afkomstig van de indigolijn in het atoomspectrum van indium.', 11, NULL, 1, 100),
(50, '50', 'Tin', 'Tin is een scheikundig element met symbool Sn (Latijn: stannum) en atoomnummer 50. Het is een zilvergrijs hoofdgroepmetaal. Tin, een van de vroegst ontdekte metalen, werd gebruikt voor het vervaardigen van brons, een koper-tin legering. In 3500 v.Chr. was al bekend dat tin (evenals arseen en nikkel) een verhardend effect had op koper. Daarom werd het gebruikt in gereedschappen en wapens. In de bronstijd was het een onontbeerlijk metaal omdat de heersende technologie op brons gebaseerd was.', 12, NULL, 1, 97),
(51, '51', 'Antimoon', 'Antimoon, ook antimonium of stibium geheten, is een scheikundig element met symbool Sb en atoomnummer 51. Het is een zilvergrijs metalloïde. De eerste wetenschappelijke melding van antimoon werd gemaakt in 1450 door Tholden. Maar het was niet het element wat men met deze naam aanduidde, maar het mineraal stibniet: antimoon-sulfide. Als element werd het niet herkend. Reeds lange tijd daarvoor werden antimoonverbindingen voor uiteenlopende doeleinden gebruikt. Onder andere als medicijn (braakmiddel) en voor cosmetica om de huid zwart te kleuren.', 13, NULL, 1, 100),
(52, '52', 'Tellurium', 'Tellurium is een scheikundig element met symbool Te en atoomnummer 52. Het is een zilvergrijs metalloïde. Tellurium is in 1782 ontdekt door de Oostenrijks-Hongaarse wetenschapper Franz Joseph Müller von Reichenstein. Zestien jaar later, in 1798, werd het door Martin Heinrich Klaproth voor het eerst geïsoleerd en kreeg het zijn naam. De naam tellurium is afgeleid van het Latijnse tellus dat aarde betekent.', 14, NULL, 1, 100),
(53, '53', 'Jodium', 'Jodium of jood is een scheikundig element met symbool I en atoomnummer 53. Het element behoort tot de groep van de halogenen. Het element werd in 1811 ontdekt door de Franse wetenschapper Bernard Courtois. Hij was de zoon van een salpeterproducent (kaliumnitraat, essentieel bestanddeel van buskruit). Rond die tijd was Frankrijk verzeild geraakt in meerdere oorlogen en de vraag naar buskruit was groot. Salpeter werd gewonnen uit zeewier dat werd gedroogd, verbrand en de as werd vervolgens gewassen met water. Om de salpeter verder te zuiveren werd zoutzuur toegevoegd. Op een dag schoot Courtois uit met het zuur waarbij een wolk van paarse damp opsteeg.De naam is afkomstig van het Griekse Iodes, wat violet betekent.', 15, NULL, 1, 100),
(54, '54', 'Xenon', 'Xenon is een scheikundig element met symbool Xe en atoomnummer 54. Het is een kleurloos edelgas. Xenon is in 1898 ontdekt door William Ramsay en Morris Travers toen het als residu achterbleef tijdens het verdampen van vloeibare lucht. De naam xenon komt van het Griekse ξενоς (xenos) dat vreemdeling betekent.', 16, NULL, 1, 98),
(55, '55', 'Cesium', 'Cesium of caesium is een scheikundig element met symbool Cs en atoomnummer 55. Het is een zilver/goudkleurig alkalimetaal. Cesium is als eerste spectroscopisch ontdekt door Robert Bunsen en Gustav Kirchhoff in 1860. Het kwam in kleine hoeveelheden voor in mineraalwater uit Bad Dürkheim, dat zij onderzochten. De naam is afkomstig van de Latijnse term caesius, dat als hemelblauw (naar de twee intense blauwe lijnen in het atomaire emissiespectrum van dit element) vertaald kan worden.', 1, NULL, 1, 100),
(56, '56', 'Barium', 'Barium is een scheikundig element met symbool Ba en atoomnummer 56. Het is een zilverwit aardalkalimetaal. Omstreeks 1500 werden bariumsulfaat bevattende stenen magische krachten toegekend, omdat ze een lichte gloed afgaven na te zijn verhit in aanwezigheid van houtskool. Zelfs na enkele jaren bleven de stenen in het donker nog nagloeien. Tegenwoordig staat dit verschijnsel bekend als fosforescentie. Barium is voor het eerst geïdentificeerd in 1774 door Carl Wilhelm Scheele en in 1808 voor het eerst geïsoleerd door Humphry Davy door gesmolten bariumoxide te elektrolyseren. De naam barium is afgeleid van het Griekse βαρυς (barys) dat zwaar betekent.', 2, NULL, 1, 100),
(57, '57', 'Lanthaan', 'Lanthaan of lanthanium is een scheikundig element met symbool La en atoomnummer 57. Het is een zilverwit lanthanide. Lanthaan is in 1839 ontdekt door de Zweedse wetenschapper Carl Gustaf Mosander nadat hij een oplossing van ceriumnitraat indampte en het ontstane zout oploste in verdund salpeterzuur. Wat er achterbleef was onzuiver lanthaanoxide. In 1923 is lanthaan voor het eerst in elementaire vorm geïsoleerd. De naam lanthaan is afgeleid van het Griekse λανθάνειν, lanthanein, dat verborgen zijn betekent.', 3, NULL, 1, 100),
(58, '58', 'Cerium', 'Cerium is een scheikundig element met symbool Ce en atoomnummer 58. Het is een zilverwit lanthanide. Cerium is in 1803 ontdekt door de Zweedse wetenschappers Jöns Jacob Berzelius en Wilhelm von Hisinger. Tegelijkertijd en onafhankelijk daarvan werd het element ook ontdekt door de Duitser Martin Heinrich Klaproth. Cerium is door Berzelius vernoemd naar de dwergplaneet Ceres, die twee jaar daarvoor ontdekt was.', 3, NULL, 1, 100),
(59, '59', 'Praseodymium', 'Praseodymium is een scheikundig element met symbool Pr en atoomnummer 59. Het is een zilverwit lanthanide. In 1841 veronderstelde de Zweedse chemicus Carl Gustav Mosander dat hij het element didymium had ontdekt. Paul Émile Lecoq de Boisbaudran toonde in 1879 aan dat Mosanders didymium een combinatie van samarium en een ander onbekend element was, door het samarium er uit te isoleren. Dat het residu opzichzelf ook weer een mengsel van twee andere elementen was, bewees Carl Auer von Welsbach in 1885 door het te scheiden in neodymium en praseodymium.', 3, NULL, 1, 100),
(60, '60', 'Neodymium', 'Neodymium is een scheikundig element met symbool Nd en atoomnummer 60. Het is een geel/zilverwitte lanthanide. Neodymium is in 1885 ontdekt door de Oostenrijkse chemicus Carl Auer von Welsbach. Hij scheidde neodymium en praseodymium van het materiaal dat tot die tijd bekendstond als didymium, waarvan men meende dat het een element was. Het duurde tot 1925 voordat neodymium in zuivere vorm werd geïsoleerd.', 3, NULL, 1, 100),
(61, '61', 'Promethium', 'Promethium is een scheikundig element met symbool Pm en atoomnummer 61. Het is een zilverwit/grijs lanthanide. De naam promethium is afgeleid van de Griekse mythologische figuur Prometheus, die de mens het vuur zou hebben gegeven. Het element kreeg de naam omdat Prometheus zoiets als ''de vooruit denkende'' betekent, en promethium werd voorspeld lang voor zijn ontdekking.', 3, NULL, 1, 100),
(62, '62', 'Samarium', 'Samarium is een scheikundig element met symbool Sm en atoomnummer 62. Het is een zilverwit lanthanide. Samarium is in 1853 ontdekt door de Zwitserse chemicus Jean Charles Galissard toen hij scherpe absorptiebanden aantrof bij het bekijken van het element dat toen bekend was als didymium met een spectrofotometer. In Parijs werd samarium voor het eerst uit het mineraal samarskiet geïsoleerd door Paul Émile Lecoq de Boisbaudran in 1879. De naam samarium is afkomstig van het mineraal samarskiet waarin samarium meestal wordt aangetroffen.', 3, NULL, 1, 100),
(63, '63', 'Europium', 'Europium is een scheikundig element met symbool Eu en atoomnummer 63. Het is een zilverwit lanthanide. In 1890 ontdekte Paul Émile Lecoq de Boisbaudran spectraallijnen in een mengsel van samarium en gadolinium, die niet bij die elementen hoorden. Hierdoor ontstond het vermoeden over het bestaan van europium. De ontdekking van europium wordt echter meestal toegeschreven aan Eugène-Antole Demarçay, een Franse chemicus die in 1896 samarium onderzocht en daarbij stuitte op een verontreiniging door europium. In 1901 was hij in staat om europium voor het eerst te isoleren. De naam europium is afgeleid van het werelddeel Europa.', 3, NULL, 1, 100),
(64, '64', 'Gadolinium', 'Gadolinium is een scheikundig element met symbool Gd en atoomnummer 64. Het is een zilverwit lanthanide. In 1880 merkte de Zwitserse chemicus Jean Charles Galissard de Marignac op dat het materiaal dat in die tijd bekendstond als didymium en het mineraal gadoliniet een overeenkomende spectrumlijn vertoonde, die later werd toegeschreven aan gadolinium. In 1886 isoleerde Paul Émile Lecoq de Boisbaudran voor het eerst gadoliniumoxide uit het mineraal. Het duurde echter tot het begin van de 20e eeuw voordat Georges Urbain metallisch gadolinium kon isoleren. Deze Franse chemicus heeft tussen 1895 en 1912 een aantal elementen voor het eerst kunnen isoleren door middel van fractionele destillatie. Gadolinium is vernoemd naar de Finse chemicus en geoloog Johan Gadolin.', 3, NULL, 1, 100),
(65, '65', 'Terbium', 'Terbium is een scheikundig element met symbool Tb en atoomnummer 65. Het is een grijskleurig lanthanide. Terbium is in 1843 ontdekt door Carl Gustaf Mosander. Deze Zweedse chemicus trof het element aan als verontreiniging in yttriumoxide. Het duurde tot ongeveer 1900 voordat Georges Urbain in staat was het element voor het eerst te isoleren met behulp van ionenuitwisseling. De naam ''terbium'' is afgeleid van de plaatsnaam Ytterby in Zweden.', 3, NULL, 1, 100),
(66, '66', 'Dysprosium', 'Dysprosium is een scheikundig element met symbool Dy en atoomnummer 66. Het is een zilvergrijs lanthanide. Dysprosium is in 1886 ontdekt door de Franse scheikundige Paul Émile Lecoq de Boisbaudran toen hij erin slaagde om dysprosiumoxide te isoleren uit verontreinigd erbiumoxide waarvan men tot dat moment dacht dat het holmiumoxide was. Het duurde tot de vroege jaren ''50 in de 20e eeuw voordat de ionenwisselaars ver genoeg ontwikkeld waren om zuiver dysprosium te isoleren.', 3, NULL, 1, 100),
(67, '67', 'Holmium', 'Holmium is een scheikundig element met symbool Ho en atoomnummer 67. Het is een zilverwit lanthanide. Holmium is in 1878 ontdekt door Marc Delafontaine en Jacques Louis Soret toen zij bij spectrometisch onderzoek onbekende absorptiebanden aantroffen. Het toen nog onbekende element noemden zij Element X. In datzelfde jaar ontdekte Per Teodor Cleve onafhankelijk van Delafontaine en Soret het element tijdens het onderzoeken van erbiumoxide. Holmium is vernoemd naar de Latijnse naam voor Stockholm: Holmia, de woonplaats van Cleve.', 3, NULL, 1, 100),
(68, '68', 'Erbium', 'Erbium is een scheikundig element met symbool Er en atoomnummer 68. Het is een zilverwit lanthanide. Erbium is in 1843 ontdekt door de Zweedse chemicus Carl Gustaf Mosander tijdens het onderzoeken van mineralen. Hij noemde het naar Ytterby, waar het voor het eerst werd gevonden. In 1934 werd zuiver metallische erbium geïsoleerd door erbiumchloride te reduceren met kaliumdamp.', 3, NULL, 1, 100),
(69, '69', 'Thulium', 'Thulium is een scheikundig element met symbool Tm en atoomnummer 69. Het is een zilverwit lanthanide. In 1879 is thulium ontdekt door de Zweedse chemicus Per Teodor Cleve tijdens het bestuderen van onzuiverheden in lanthanideoxiden. Eén voor één verwijderde hij alle bekende bestanddelen uit erbiumoxide, waarbij uiteindelijk twee onbekende substanties overbleven. De ene was een bruinkleurig oxide van het gelijktijdig door Marc Delafontaine ontdekte holmium, de andere was een groen oxide van een toen nog niet eerder ontdekt element dat hij thulium noemde. De naam thulium is afkomstig van Thule, de oude Romeinse naam voor een mythisch land in het verre noorden, vermoedelijk Scandinavië of mogelijk IJsland.', 3, NULL, 1, 100),
(70, '70', 'Ytterbium', 'Ytterbium is een scheikundig element met symbool Yb en atoomnummer 70. Het is een zilverwit lanthanide. Ytterbium is door de ontdekker Jean Charles Galissard de Marignac in 1878 vernoemd naar het plaatsje Ytterby bij Stockholm in Zweden waar het erts vandaan kwam waarin een aantal van de lanthaniden ontdekt zijn. In 1908 slaagde Georges Urbain erin om wat Marignac in 1878 als ytterbia had betiteld te scheiden in wat nu bekendstaat als lutetium en ytterbium. Von Welsbach werkte omstreeks dezelfde tijd aan het probleem en noemde de elementen aldebaranium en cassiopeium, maar later werden deze namen verworpen.', 3, NULL, 1, 100),
(71, '71', 'Lutetium', 'Lutetium is een scheikundig element met symbool Lu en atoomnummer 71. Het is een zilverwit lanthanide. Onafhankelijk van elkaar is lutetium in 1907 ontdekt door Georges Urbain en Carl Auer von Welsbach. Beide troffen het element als verontreiniging aan in het mineraal ytterbia, waarvan eerder vermoed werd dat het volledig uit ytterbiumverbindingen bestond. Aangezien Urbain het isolatieproces als eerste beschreef, wordt deze Franse chemicus gezien als de ontdekker van lutetium. Zelf noemde hij het element neoytterbium, maar dat werd in 1949 veranderd in lutetium. Welsbach stelde de namen cassiopium en aldebaranium voor, maar deze namen werden afgewezen. De naam lutetium is afgeleid van de Latijnse naam voor Parijs, Lutetia.', 3, NULL, 1, 100),
(72, '72', 'Hafnium', 'Hafnium is een scheikundig element met symbool Hf en atoomnummer 72. Het is een staalgrijs overgangsmetaal. Op basis van zijn atoomtheorie voorspelde Niels Bohr dat het 72ste element niet tot de zeldzame aarden behoorde, waar men het tot dan toe tevergeefs gezocht had. Op Bohr''s aanwijzing werd het element in 1922 ontdekt door de Nederlandse fysicus en ingenieur Dirk Coster en de Hongaarse scheikundige George de Hevesy toen zij met röntgenspectrometrie de buitenste elektronen van zirkoniumhoudende erts bestudeerden. De naam Hafnium is afgeleid van het Latijnse woord voor Kopenhagen Hafnia; de plaats waar het element is ontdekt.', 4, NULL, 1, 100),
(73, '73', 'Tantaal', 'Tantaal of tantalium is een scheikundig element met symbool Ta en atoomnummer 73. Het is een grijsblauw overgangsmetaal. Tantaal is in 1802 in Zweden ontdekt door Anders Gustaf Ekeberg en in 1820 voor het eerst geïsoleerd door Jöns Jacob Berzelius. Veel scheikundigen in die tijd dachten dat tantaal een isotoop van niobium was, maar in 1866 werd aangetoond dat de zuren van tantaal- en niobium verschillende verbindingen waren. De naam tantalium is afkomstig van het Griekse Tantalos, een mythisch personage.', 5, NULL, 1, 100),
(74, '74', 'Wolfraam', 'Wolfraam is een scheikundig element met symbool W en atoomnummer 74. Het is een grijswit overgangsmetaal. In het Engels en in veel romaanse talen heet het metaal tungsten. Men komt dit woord wel eens in slechte vertalingen tegen. Tung sten is Zweeds voor zware steen, de oorspronkelijke benaming die rond 1758 werd gegeven aan het mineraal dat nu bekend staat als scheeliet, een verbinding van calcium en wolfraam. De naam wolfraam komt van Wolf en Rahm (room, oude benaming voor schuim), een Duitse vertaling van het Latijnse lupi spuma, omdat het een vretend schuim vormt bij de tinbereiding.', 6, NULL, 1, 100),
(75, '75', 'Renium', 'Renium (vóór 1954 geschreven als rhenium) is een scheikundig element met symbool Re en atoomnummer 75. Het is een grijswit overgangsmetaal. In 1925 is het element renium ontdekt door de Duitse scheikundigen Walter Noddack, Ida Noddack en Otto Berg toen zij de mineralen columbiet, gadoliniet en molybdeniet onderzochten met een spectrofotometer. De aangetroffen hoeveelheden renium waren echter gering. De naam renium is afgeleid van de Latijnse naam voor de rivier de Rijn: Rhenus.', 7, NULL, 1, 100),
(76, '76', 'Osmium', 'Osmium is een scheikundig element met symbool Os en atoomnummer 76. Het is een blauwgrijs overgangsmetaal. Osmium is in 1803 ontdekt door Smithson Tennant in Londen. Het metaal bleef samen met iridium achter als zwart residu na het oplossen van platinaerts in koningswater. De naam osmium is afgeleid van het Griekse osmè (οσμη), dat kan worden vertaald als stank. Hierbij wordt duidelijk verwezen naar osmium(VIII)oxide, dat zelfs bij lage temperaturen een enorme stank verspreidt. Osmiumpoeder oxideert reeds bij kamertemperatuur.', 8, NULL, 1, 100),
(77, '77', 'Iridium', 'Iridium is een scheikundig element met symbool Ir en atoomnummer 77. Het is een zilverwit overgangsmetaal. Iridium is in 1803 (gelijktijdig met osmium) ontdekt door de Engelse chemicus Smithson Tennant, toen het als residu achterbleef na het oplossen van platina erts in koningswater. Tennant gaf het deze naam omdat er vele kleuren zichtbaar waren: Iris is de godin van de regenboog, Iridis betekent in het Latijn van Iris.', 8, NULL, 1, 100),
(78, '78', 'Platina', 'Platina is een scheikundig element met symbool Pt en atoomnummer 78. Het is een grijswit overgangsmetaal. Door de oorspronkelijke bewoners van Amerika werd platina al lange tijd gebruikt, voordat er omstreeks 1500 voor het eerst melding van wordt gemaakt in geschriften van de Italiaan Julius Caesar Scaliger. Deze humanist beschreef platina als een wonderlijk metaal dat werd aangetroffen in (het huidige) Panama en Mexico en ''onmogelijk kon worden gesmolten''. De Spanjaarden gaven het metaal de naam ''platino''. Dat betekent ''klein zilver''. Ze troffen het in Colombia aan tussen het gedolven zilver en beschouwden het als een ongewenste verontreiniging.', 8, NULL, 1, 100),
(79, '79', 'Goud', 'Goud is een scheikundig element met symbool Au en atoomnummer 79. Het is een geel metalliek overgangsmetaal. Het is al sinds de stroomculturen (Nabije Oosten van 3500 v.Chr. tot 800 v.Chr.) zeer gewaardeerd en is roestvrij, daarom wordt goud soms ''de koning der metalen'' genoemd.', 9, NULL, 1, 100),
(80, '80', 'Kwik', 'Kwik (soms ook wel kwikzilver genoemd) is een scheikundig element met symbool Hg (uit het Grieks hydrargyros via het Latijnse hydrargyrus) en atoomnummer 80. Het is een zilverwit overgangsmetaal dat als enige metaal ook bij kamertemperatuur vloeibaar is. De naam kwik is afgeleid van het Oudsaksische woord quik, dat ''levend'' of ''levendig'' betekende; het Engelse quicksilver betekent dan ook van oorsprong ''levend(ig) zilver''. Een vergelijkbare Latijnse naam is argentum vivum, maar de officiële Latijnse aanduiding is hydrargyrum (uit Grieks hudor-, ''water'', en arguros, ''zilver''). Het symbool Hg dankt kwik dan ook aan deze Griekse naam.', 10, NULL, 1, 100),
(81, '81', 'Thallium', 'Thallium is een scheikundig element met symbool Tl en atoomnummer 81. Het is een zilverwit hoofdgroepmetaal. Thallium is in 1861 ontdekt door de Engelse wetenschapper Sir William Crookes tijdens het spectrofotometrisch onderzoeken van residuen, die overbleven bij de productie van zwavelzuur. Een jaar later werd thallium door Crookes en Claude-Auguste Lamy onafhankelijk van elkaar geïsoleerd. Thallium betekent in het Grieks groene tak of scheut. Deze naam past het scheikundig element omdat het een zeer heldere groene spectrum emissielijn vertoont.', 11, NULL, 1, 100),
(82, '82', 'Lood', 'Lood is een scheikundig element met symbool Pb en atoomnummer 82. Het is een donkergrijs hoofdgroepmetaal. Lood wordt sinds 5000-4500 v.Chr. gebruikt omdat het wijdverspreid op aarde voorkomt en eenvoudig kan worden bewerkt. Alchemisten dachten dat lood het oudste metaal was en associeerden het met de planeet Saturnus. In het Romeinse Rijk werden loden pijpen gebruikt om water te transporteren die in sommige gevallen 2000 jaar later nog steeds in gebruik zijn. In de jaren 1980-90 ontstond het besef dat lood schadelijk is voor het milieu met als gevolg dat het gebruik ervan aan banden werd gelegd. In autobrandstoffen werd lood vervangen door andere stoffen en loden pijpleidingen werden vervangen door pijpleidingen in kunststof, (verzinkt) staal of koper.', 12, NULL, 1, 100),
(83, '83', 'Bismut', 'Bismut is een scheikundig element met symbool Bi en atoomnummer 83. Het is een roodwit hoofdgroepmetaal. In het verleden werd bismut vaak verward met tin of lood omdat het daar veel eigenschappen mee deelt. In 1753 lukte het de Franse wetenschapper Claude François Geoffroy om bismut te scheiden van lood. De naam is afkomstig van het Duitse Wismut, wat vermoedelijk een verbastering is van witte massa.', 13, NULL, 1, 100);
INSERT INTO `products` (`product_id`, `serial_number`, `name`, `description`, `category_id`, `supplier_id`, `visible`, `supply`) VALUES
(84, '84', 'Polonium', 'Polonium is een scheikundig element met symbool Po en atoomnummer 84. Het is een zilvergrijs metalloïde. Het element werd in 1898 ontdekt door Marie Curie. Zij onderzocht de radioactiviteit van pekblende. Nadat Curie het radioactieve uranium en thorium van het monster had afgescheiden, kwam ze tot de vaststelling dat het overblijvende materiaal nog steeds radioactief was. Dit was een indicatie voor Curie dat er zich nog andere radioactieve elementen in bevonden (ontstaan door radioactief verval van uranium en thorium). Daarop scheidde ze eerst polonium af en later ook radium. Marie Curie noemde het element naar haar geliefde, onderdrukte vaderland Polen.', 14, NULL, 1, 94),
(85, '85', 'Astaat', 'Astaat of astatium is een scheikundig element met symbool At en atoomnummer 85. Het is zo zeldzaam dat niet bekend is hoe het er uit ziet; daarnaast zouden hoeveelheden die groot genoeg zijn om met het blote oog waar te nemen meteen verdampen door de intense radioactiviteit. Theoretisch zou het een metalliek zilverkleurig metalloïde kunnen zijn.', 15, NULL, 1, 100),
(86, '86', 'Radon', 'Radon is een scheikundig element met symbool Rn en atoomnummer 86. Het is een kleurloos edelgas. In 1900 ontdekte de Duitse fysicus Friedrich Ernst Dorn radon. Hij noemde het radiumemanatie of emanatie (symbool Em). In 1908 werd radon voor het eerst geïsoleerd door William Ramsay en Robert Whytlaw-Gray, waarbij ze het niton noemden, afgeleid van het Latijnse nitens dat als schijning vertaald kan worden. Deze twee chemici bepaalden ook de dichtheid van het gas en concludeerden dat niton het zwaarste bekende edelgas was. Sinds ongeveer 1923 wordt het radon genoemd.', 16, NULL, 1, 100),
(87, '87', 'Francium', 'Francium, aangeduid met het symbool Fr, is het scheikundige element met atoomnummer 87. Het is een sterk radioactief alkalimetaal met een metalliek donkergrijze kleur. Francium is in 1939 ontdekt door de Franse fysicus Marguerite Perey van het Curie-instituut in Parijs. Zij ontdekte het element tijdens het bestuderen van de radioactieve vervalproducten van actinium. Het element is genoemd naar het land waarin het ontdekt is.', 1, NULL, 1, 100),
(88, '88', 'Radium', 'Radium is een scheikundig element met symbool Ra en atoomnummer 88. Het is een wit/zilverkleurig aardalkalimetaal. Radium is in 1898 ontdekt door Pierre en Marie Curie tijdens het onderzoeken van het mineraal uraniniet toen, na het verwijderen van uranium uit het mineraal, het residu nog steeds radioactief bleek te zijn. In 1902 is radium met behulp van elektrolyse van radiumchloride voor het eerst geïsoleerd door Curie en André-Louis Debierne. De naam radium is afgeleid van het Latijnse radius dat als straal of straling kan worden opgevat.', 2, NULL, 1, 100),
(89, '89', 'Actinium', 'Actinium is een scheikundig element met symbool Ac en atoomnummer 89. Het is een zilverkleurig actinide. Actinium is in 1899 ontdekt door de Franse chemicus André-Louis Debierne toen hij het element scheidde van het mineraal uraniniet. Onafhankelijk van Debierne ontdekte Friedrich Otto Giesel in 1902 actinium op vergelijkbare wijze. De naam actinium is afgeleid van het Griekse ακτίνος, aktinos dat vertaald kan worden als straal of straling.', 3, NULL, 1, 100),
(90, '90', 'Thorium', 'Thorium is een scheikundig element met symbool Th en atoomnummer 90. Het is een zilverwit actinide. Thorium is in 1828 ontdekt door de Zweedse chemicus Jöns Jacob Berzelius. Het element is vernoemd naar de Noorse god van de donder, Thor.', 3, NULL, 1, 100),
(91, '91', 'Protactinium', 'Protactinium is een scheikundig element met symbool Pa en atoomnummer 91. Het is een metalliek zilverkleurig actinide. Door de schaarste, hoge radioactiviteit en giftigheid zijn er geen industriële toepassingen voor protactinium. Op kleine schaal wordt het toegepast bij fundamenteel onderzoek. Protactinium is een actinide met een metallieke glans en is redelijk stabiel aan de lucht. Bij temperaturen onder 1,4 kelvin vertoont het supergeleidende eigenschappen.', 3, NULL, 1, 100),
(92, '92', 'Uranium', 'Uranium of uraan is een scheikundig element met symbool U en atoomnummer 92. Het is een metallisch grijs actinide. Natuurlijk uranium bestaat grotendeels uit 238U en voor 0,7% uit 235U. Bij verrijkt uranium is dit laatste percentage hoger, bij verarmd uranium lager. Uranium werd in 1789 ontdekt door de Duitse scheikundige Martin Heinrich Klaproth in het mineraal pekblende. Het element werd genoemd naar de planeet Uranus, die acht jaar eerder was ontdekt.', 3, NULL, 1, 95),
(93, '93', 'Neptunium', 'Neptunium is een scheikundig element met symbool Np en atoomnummer 93. Het is een zilverkleurig metalliek actinide. Neptunium is in 1940 ontdekt door Edwin McMillan en Philip Abelson in het isotopenlaboratorium van de Universiteit van Californië - Berkeley. Door uraniumkernen te bombarderen met neutronen ontstond uiteindelijk 239Np. Het was het eerste transurane element dat gesynthetiseerd werd.', 3, NULL, 1, 100),
(94, '94', 'Plutonium', 'Plutonium is een scheikundig element met symbool Pu en atoomnummer 94. Het is een zilverwit actinide. In zuivere vorm is plutonium een zilverwit metaal, maar door oxidatie aan de lucht verandert dat snel in geel. Door spontaan verval met uitstraling van α-deeltjes voelt plutonium altijd warmer aan dan de omgeving. In grote hoeveelheden kan dat zelfs water doen koken.', 3, NULL, 1, 94),
(95, '95', 'Americium', 'Americium is een scheikundig element met als symbool Am en atoomnummer 95. Het is een zilverwit actinide. Americium is voor het eerst gesynthetiseerd in 1944 door Glenn Seaborg, Leon O. Morgan, Ralph James en Albert Ghiorso in het Argonne National Laboratory. Zij waren in staat om 241Am te produceren door plutonium in een kernreactor te bombarderen met neutronen. De naam ''americium'' is afgeleid van het continent Amerika, waar het element ontdekt is, naar analogie met europium.', 3, NULL, 1, 100),
(96, '96', 'Curium', 'Curium is een scheikundig element met symbool Cm en atoomnummer 96. Het is een zilverkleurig actinide. In uiterst kleine hoeveelheden wordt curium aangetroffen in uraniumerts als gevolg van natuurlijk verval. Deze hoeveelheden zijn commercieel gezien niet interessant. Voor wetenschappelijke en industriële toepassingen wordt curium geproduceerd door plutonium te bombarderen met neutronen.', 3, NULL, 1, 100),
(97, '97', 'Berkelium', 'Berkelium is een scheikundig element met symbool Bk en atoomnummer 97. Het is een grijs of zilverwit actinide. Het radioactieve berkelium wordt slechts in zeer kleine hoeveelheden geproduceerd voor wetenschappelijk onderzoek. Industriële toepassingen komen niet voor.', 3, NULL, 1, 100),
(98, '98', 'Californium', 'Californium is een scheikundig element met symbool Cf en atoomnummer 98. Het is een vermoedelijk grijs of zilverkleurig actinide. Omdat californium slechts in minuscule hoeveelheden beschikbaar is, wordt het alleen gebruikt voor zeer specialistische toepassingen. Folies van 252-Cf worden bij radiologisch onderzoek gebruikt als bron van neutronen en bij het detecteren van goud en zilver. Het is het zwaarste element dat praktische toepassingen heeft.', 3, NULL, 1, 99),
(99, '99', 'Einsteinium', 'Einsteinium is een scheikundig element met symbool Es en atoomnummer 99. Het is een glanzend, zilverwit actinide. In zuivere vorm is het een sterk radioactief, zwaar metaal. Van einsteinium zijn geen toepassingen bekend, behalve, zoals gezegd, als tussenstadium bij de productie van mendelevium.', 3, NULL, 1, 99),
(100, '100', 'Fermium', 'Fermium is een scheikundig element met symbool Fm en atoomnummer 100. Het is een vermoedelijk grijs of zilverkleurig actinide. Fermium is in 1952 ontdekt door een team onder leiding van Albert Ghiorso. Zij ontdekten het metaal in het puin dat overgebleven was na de eerste test met een waterstofbom (Operation Ivy). Door de intense hitte en druk van de explosie was fermium ontstaan na het fuseren van een uraniumkern en 17 neutronen. Deze ontdekking werd in verband met de Koude Oorlog geheimgehouden tot 1955. Echter eind 1953 werd door fysici uit Stockholm al melding gemaakt van een onbekend element met 100 protonen en een massa van ongeveer 250 dat zij hadden geproduceerd door 238-U te laten fuseren met 16O ionen.', 3, NULL, 1, 100),
(101, '101', 'Mendelevium', 'Mendelevium is een scheikundig element met symbool Md en atoomnummer 101. Het is een vermoedelijk grijs of zilverkleurig actinide. In 1955 is mendelevium voor het eerst gesynthetiseerd door Albert Ghiorso, Glenn Seaborg, Bernard Harvey en Greg Choppin. Zij produceerden 256Md door 253Es in een cyclotron te bombarderen met alfadeeltjes. Het element is vernoemd naar de Russische scheikundige Dmitri Mendelejev.', 3, NULL, 1, 100),
(102, '102', 'Nobelium', 'Nobelium is een scheikundig element met symbool No en atoomnummer 102. Het is een vermoedelijk grijs of zilverwit actinide. Omdat nobelium alleen in zeer kleine hoeveelheden geproduceerd kan worden, is er weinig over de eigenschappen bekend.', 3, NULL, 1, 0),
(103, '103', 'Lawrencium', 'Lawrencium is een scheikundig element met symbool Lr en atoomnummer 103. Het is een vermoedelijk zilverwit of grijs actinide. De naam lawrencium is afgeleid van Ernest Lawrence, de uitvinder van het cyclotron.', 3, NULL, 1, 100),
(104, '104', 'Rutherfordium', 'Rutherfordium is een scheikundig element met symbool Rf en atoomnummer 104. Het is een vermoedelijk grijs of zilverkleurig. Rutherfordium is een uiterst radioactief element waarvan het instabielste isotoop een halveringstijd heeft van 65 seconden. De praktische toepassing ervan is daardoor minimaal. Rutherfordium is het eerst transactinide element en vermoedelijk vertoont het in chemisch opzicht veel overeenkomsten met hafnium.', 4, NULL, 1, 99),
(105, '105', 'Dubnium', 'Dubnium is een scheikundig element met symbool Db en atoomnummer 105. Het is een vermoedelijk grijs of zilverkleurig. Over de chemische en fysische eigenschappen van dubnium is nauwelijks iets bekend. Vermoedelijk vertoont het overeenkomsten met tantalium.', 5, NULL, 1, 100),
(106, '106', 'Seaborgium', 'Seaborgium is een scheikundig element met symbool Sg en atoomnummer 106. Het is vermoedelijk een grijs of zilverwit. Omdat seaborgium zich in het periodiek systeem direct onder wolfraam (W) bevindt is het aannemelijk dat de chemische eigenschappen overeenkomsten vertonen met die van wolfraam.', 6, NULL, 1, 100),
(107, '107', 'Bohrium', 'Bohrium (niet te verwarren met borium) is een scheikundig element met symbool Bh en atoomnummer 107. Het is een vermoedelijk grijs of zilverkleurig. Vanwege de uiterst korte halveringstijden van de bohriumisotopen is het nauwelijks mogelijk om onderzoek te doen naar de chemische en fysische eigenschappen.', 7, NULL, 1, 100),
(108, '108', 'Hassium', 'Hassium is een scheikundig element met symbool Hs en atoomnummer 108. Het is een vermoedelijk grijs of zilverkleurig. Omdat hassium onder osmium staat in het periodiek systeem, ligt het in de verwachting dat het tetraoxide HsO4 minstens zo vluchtig zal zijn als dat van de lichtere leden van groep 8 van het periodiek systeem. Men moet daar wel een beetje een slag om de arm houden, omdat het niet helemaal duidelijk is hoe zeer de gevolgen van de relativiteit de systematiek van het systeem verstoren. Met hogere atoomnummers wordt deze factor steeds belangrijker.', 8, NULL, 1, 100),
(109, '109', 'Meitnerium', 'Meitnerium is een scheikundig element met symbool Mt en atoomnummer 109. Het is een vermoedelijk grijs of zilverkleurig. Er is slechts een klein aantal meitneriumatomen geproduceerd en hun levensduur is zeer kort. Daarom is het vrijwel onmogelijk om onderzoek te doen naar de chemische en fysische eigenschappen. Vermoedelijk vertoont meitnerium grote overeenkomsten met het element iridium, omdat het zich in dezelfde groep bevindt.', 8, NULL, 1, 100),
(110, '110', 'Darmstadtium', 'Darmstadtium is een scheikundig element met symbool Ds en atoomnummer 110. Het is een overgangsmetaal. De levensduur van het element en het minuscule aantal atomen dat ooit is geproduceerd maakt het onmogelijk om serieus onderzoek te verrichten naar de eigenschappen van darmstadtium. Uit theoretische afleidingen kan met redelijke zekerheid bijvoorbeeld de elektronenconfiguratie worden voorspeld. Een andere eigenschap waarvan sterke vermoedens bestaan, maar welke niet kan worden aangetoond is dat de aggregatietoestand vermoedelijk vast is bij standaardtemperatuur en druk.', 8, NULL, 1, 100),
(111, '111', 'Röntgenium', 'Röntgenium, ook wel roentgenium is een scheikundig element met symbool Rg en atoomnummer 111. Het element is vernoemd naar Wilhelm Röntgen. Tot 1 november 2004 was dit element bekend als unununium met als symbool Uuu.Vanwege het hoge atoomgewicht van 272 rekent men röntgenium tot de superzware atomen. Het element komt, net als koper, zilver en goud, voor in groep 11, vandaar dat dit element tot de overgangsmetalen wordt gerekend. Andere overgangsmetalen zijn vaste metalen, röntgenium zal dit waarschijnlijk ook zijn.', 9, NULL, 1, 100),
(112, '112', 'Copernium', 'Copernicium (Cn), voorheen: ununbium (Uub), is het 112e element uit het periodiek systeem der elementen en werd in 1996 voor het eerst gevormd in Darmstadt door het Duitse Gesellschaft für Schwerionenforschung (GSI), geleid door professor Sigurd Hofmann. Het element is vernoemd naar de astronoom Nicolaas Copernicus, de grondlegger van het moderne heliocentrische wereldbeeld, waarbij de aarde rond de zon draait. Het element heeft een halveringstijd van 240 µs en wordt derhalve niet in de vrije natuur aangetroffen. Tot nu toe zijn er ongeveer 75 coperniciumatomen via verschillende kernreacties ontstaan.', 10, NULL, 1, 100),
(113, '113', 'Ununtrium', 'Ununtrium (Uut) is het 113de scheikundig element uit het periodiek systeem der elementen. Het is ontdekt in 2003 en voor het eerst gesynthetiseerd in 2004. De naam is gebaseerd op de Latijnse naam van de cijfers van het getal dat het aantal protonen in de kern beschrijft: 113. De bereiding vond door een team bestaande uit Russen en Amerikanen in het Gezamenlijk Instituut voor Kernonderzoek te Doebna. Zij beschoten americium-243 (element 95) met calcium-48 (element 20), waarna ununpentium ontstond, dat binnen een fractie van een seconde in ununtrium vervalt. Vervolgens vervalt dit element binnen 1,2 s.', 11, NULL, 1, 100),
(114, '114', 'Flerovium', 'Het element flerovium (symbool: Fl) met atoomnummer 114 werd voor het eerst geproduceerd door wetenschappers die werkzaam waren bij het Flerov Laboratorium van het Gezamenlijk Instituut voor Kernonderzoek in Doebna, Rusland in 1998. Ze schoten calciumatomen tegen plutoniumatomen aan. Het resultaat was een enkel atoom flerovium-289, een isotoop met een halveringstijd van ongeveer 21 seconden. Dit bleek het meest stabiele fleroviumisotoop te zijn. Onder invloed van α-straling vervalt het tot copernicium-285.', 12, NULL, 1, 100),
(115, '115', 'Ununpentium', 'Ununpentium (Uup) is een superzwaar scheikundig element met atoomnummer 115. Totdat de ontdekking officieel bekend is gemaakt heeft het nog geen eigen naam. Dus wordt het kortweg aangeduid als Uup. Die afkorting staat voor ununpentium, ofwel ''één-één-vijf'' volgens een classificatie die bedacht is door de International Union for Pure and Applied Chemistry. In februari 2004 heeft een gecombineerde Russische/Amerikaanse onderzoeksgroep ununpentium gemaakt door americium-243 (element 95) te beschieten met calcium-48 (element 20). Als ununpentium vervalt komt er naast een α-deeltje ook het element ununtrium (element 113) vrij. Het maken van dit element is door Japanse wetenschappers bevestigd en, in mei 2006, door het Gezamenlijk Instituut voor Kernonderzoek.', 13, NULL, 1, 99),
(116, '116', 'Livermorium', 'Livermorium (symbool: Lv) (eerder bekend onder de tijdelijke naam Ununhexium, met het symbool Uuh) is de naam van het scheikundig element 116. In 1999 meldden onderzoekers van het Lawrence Berkeley National Laboratory de ontdekking van het element. Bij controle bleek de data echter niet het gemelde resultaat te geven. De ontdekker, Victor Ninov, had de data gemanipuleerd. Het element werd een jaar later alsnog geproduceerd door Russische onderzoekers van het Gezamenlijk Instituut voor Kernonderzoek.', 14, NULL, 1, 100),
(117, '117', 'Ununseptium', 'Ununseptium (Eka-Astaat) is de tijdelijke naam van het in 2010 ontdekte chemisch element uit het periodiek systeem met het atoomnummer 117. De afkorting van dit element is Uus. In januari 2010 meldden wetenschappers van het Flerov Laboratory of Nuclear Reactions dat men erin geslaagd was, succesvol verval van het nieuwe element 117 vast te leggen.', 15, NULL, 1, 100),
(118, '118', 'Ununoctium', 'Ununoctium is de tijdelijke naam van een scheikundig element met tijdelijk symbool Uuo en periodiek nummer 118. Het kan vallen onder de edelgassen. De naam komt van het Latijnse unus (een) en octo (acht): 2 keer unus en een keer octo maakt 118. In 1999 beschoot een onderzoeksteam aan het Nationale Laboratorium van Lawrence Berkeley in Californië lood-208-atomen met hoge energie krypton-86-ionen om ununoctium te creëren. Na een analyse leken er drie atomen van element 118 met atoommassa 294 en een halveringstijd van minder dan een milliseconde te zijn. In 2001 trok het team echter zijn claims in nadat andere laboratoria er niet in waren geslaagd om hun resultaten te reproduceren door dezelfde techniek toe te passen.', 16, NULL, 1, 100),
(122, '122', 'Universiterium', 'Het materiaal van de UvA', 17, NULL, 0, 99);

-- --------------------------------------------------------

--
-- Table structure for table `products_media`
--

DROP TABLE IF EXISTS `products_media`;
CREATE TABLE `products_media` (
  `product_id` int(16) UNSIGNED NOT NULL,
  `media_id` int(16) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `products_media`
--

INSERT INTO `products_media` (`product_id`, `media_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(21, 21),
(22, 22),
(23, 23),
(24, 24),
(25, 25),
(26, 26),
(27, 27),
(28, 28),
(29, 29),
(30, 30),
(31, 31),
(32, 32),
(33, 33),
(34, 34),
(35, 35),
(36, 36),
(37, 37),
(38, 38),
(39, 39),
(40, 40),
(41, 41),
(42, 42),
(43, 43),
(44, 44),
(45, 45),
(46, 46),
(47, 47),
(48, 48),
(49, 49),
(50, 50),
(51, 51),
(52, 52),
(53, 53),
(54, 54),
(55, 55),
(56, 56),
(57, 57),
(58, 58),
(59, 59),
(60, 60),
(61, 61),
(62, 62),
(63, 63),
(64, 64),
(65, 65),
(66, 66),
(67, 67),
(68, 68),
(69, 69),
(70, 70),
(71, 71),
(72, 72),
(73, 73),
(74, 74),
(75, 75),
(76, 76),
(77, 77),
(78, 78),
(79, 79),
(80, 80),
(81, 81),
(82, 82),
(83, 83),
(84, 84),
(85, 85),
(86, 86),
(87, 87),
(88, 88),
(89, 89),
(90, 90),
(91, 91),
(92, 92),
(93, 93),
(94, 94),
(95, 95),
(96, 96),
(97, 97),
(98, 98),
(99, 99),
(100, 100),
(101, 101),
(102, 102),
(103, 103),
(104, 104),
(105, 105),
(106, 106),
(107, 107),
(108, 108),
(109, 109),
(110, 110),
(111, 111),
(112, 112),
(113, 113),
(114, 114),
(115, 115),
(116, 116),
(117, 117),
(118, 118),
(122, 122);

-- --------------------------------------------------------

--
-- Table structure for table `products_orders`
--

DROP TABLE IF EXISTS `products_orders`;
CREATE TABLE `products_orders` (
  `product_id` int(16) UNSIGNED NOT NULL,
  `order_id` int(16) UNSIGNED NOT NULL,
  `price_id` int(16) UNSIGNED NOT NULL,
  `amount` int(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `products_orders`
--

INSERT INTO `products_orders` (`product_id`, `order_id`, `price_id`, `amount`) VALUES
(2, 1, 2, 3),
(4, 2, 4, 1),
(2, 3, 2, 4),
(84, 3, 84, 1),
(92, 3, 92, 1),
(2, 4, 2, 2),
(10, 4, 10, 1),
(18, 4, 18, 1),
(36, 4, 36, 1),
(54, 4, 54, 1),
(98, 5, 98, 1),
(54, 5, 54, 1),
(99, 6, 99, 1),
(122, 7, 122, 1),
(104, 7, 104, 1),
(7, 8, 7, 2),
(8, 8, 8, 1),
(12, 9, 12, 6),
(13, 9, 13, 3),
(17, 10, 17, 3),
(92, 10, 92, 4),
(84, 10, 84, 5),
(1, 11, 1, 2),
(8, 11, 8, 1),
(1, 12, 1, 2),
(8, 12, 8, 1),
(6, 13, 6, 2),
(1, 13, 1, 6),
(8, 13, 8, 1),
(102, 14, 102, 1),
(94, 15, 94, 6),
(6, 16, 6, 8),
(1, 16, 1, 6),
(8, 16, 8, 1),
(50, 17, 50, 3),
(29, 18, 29, 1),
(115, 19, 115, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_specs`
--

DROP TABLE IF EXISTS `products_specs`;
CREATE TABLE `products_specs` (
  `product_id` int(16) UNSIGNED NOT NULL,
  `spec_id` int(16) UNSIGNED NOT NULL,
  `value_id` int(16) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products_specs`
--

INSERT INTO `products_specs` (`product_id`, `spec_id`, `value_id`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(2, 1, 4),
(2, 3, 5),
(3, 1, 6),
(3, 2, 7),
(3, 3, 8),
(4, 1, 9),
(4, 2, 10),
(4, 3, 11),
(5, 1, 12),
(5, 2, 13),
(5, 3, 14),
(6, 1, 15),
(7, 1, 16),
(7, 2, 17),
(7, 3, 18),
(8, 1, 19),
(8, 2, 20),
(8, 3, 21),
(9, 1, 22),
(9, 2, 23),
(9, 3, 24),
(10, 1, 25),
(10, 2, 26),
(10, 3, 27),
(11, 1, 28),
(11, 2, 29),
(11, 3, 30),
(12, 1, 31),
(12, 2, 32),
(12, 3, 33),
(13, 1, 34),
(13, 2, 35),
(13, 3, 36),
(14, 1, 37),
(14, 2, 38),
(14, 3, 39),
(15, 1, 40),
(15, 2, 41),
(15, 3, 42),
(16, 1, 43),
(16, 2, 44),
(16, 3, 45),
(17, 1, 46),
(17, 2, 47),
(17, 3, 48),
(18, 1, 49),
(18, 2, 50),
(18, 3, 51),
(19, 1, 52),
(19, 2, 53),
(19, 3, 54),
(20, 1, 55),
(20, 2, 56),
(20, 3, 57),
(21, 1, 58),
(21, 2, 59),
(21, 3, 60),
(22, 1, 61),
(22, 2, 62),
(22, 3, 63),
(23, 1, 64),
(23, 2, 65),
(23, 3, 66),
(24, 1, 67),
(24, 2, 68),
(24, 3, 69),
(25, 1, 70),
(25, 2, 71),
(25, 3, 72),
(26, 1, 73),
(26, 2, 74),
(26, 3, 75),
(27, 1, 76),
(27, 2, 77),
(27, 3, 78),
(28, 1, 79),
(28, 2, 80),
(28, 3, 81),
(29, 1, 82),
(29, 2, 83),
(29, 3, 84),
(30, 1, 85),
(30, 2, 86),
(30, 3, 87),
(31, 1, 88),
(31, 2, 89),
(31, 3, 90),
(32, 1, 91),
(32, 2, 92),
(32, 3, 93),
(33, 1, 94),
(33, 4, 95),
(33, 5, 96),
(34, 1, 97),
(34, 2, 98),
(34, 3, 99),
(35, 1, 100),
(35, 2, 101),
(35, 3, 102),
(36, 1, 103),
(36, 2, 104),
(36, 3, 105),
(37, 2, 106),
(37, 3, 107),
(37, 1, 108),
(38, 2, 109),
(38, 3, 110),
(38, 1, 111),
(39, 2, 112),
(39, 3, 113),
(39, 1, 114),
(40, 2, 115),
(40, 3, 116),
(40, 1, 117),
(41, 2, 118),
(41, 3, 119),
(41, 1, 120),
(42, 2, 121),
(42, 3, 122),
(42, 1, 123),
(43, 2, 124),
(43, 3, 125),
(43, 1, 126),
(44, 2, 127),
(44, 3, 128),
(44, 1, 129),
(45, 2, 130),
(45, 3, 131),
(45, 1, 132),
(46, 2, 133),
(46, 3, 134),
(46, 1, 135),
(47, 2, 136),
(47, 3, 137),
(47, 1, 138),
(48, 2, 139),
(48, 3, 140),
(48, 1, 141),
(49, 2, 142),
(49, 3, 143),
(49, 1, 144),
(50, 2, 145),
(50, 3, 146),
(50, 1, 147),
(51, 2, 148),
(51, 3, 149),
(51, 1, 150),
(52, 2, 151),
(52, 1, 152),
(53, 2, 153),
(53, 3, 154),
(53, 1, 155),
(54, 2, 156),
(54, 3, 157),
(54, 1, 158),
(55, 2, 159),
(55, 3, 160),
(55, 1, 161),
(56, 2, 162),
(56, 3, 163),
(56, 1, 164),
(57, 2, 165),
(57, 3, 166),
(57, 1, 167),
(58, 2, 168),
(58, 3, 169),
(58, 1, 170),
(59, 2, 171),
(59, 3, 172),
(59, 1, 173),
(60, 2, 174),
(60, 3, 175),
(60, 1, 176),
(61, 2, 177),
(61, 3, 178),
(61, 1, 179),
(62, 2, 180),
(62, 3, 181),
(62, 1, 182),
(63, 2, 183),
(63, 3, 184),
(63, 1, 185),
(64, 2, 186),
(64, 3, 187),
(64, 1, 188),
(65, 2, 189),
(65, 3, 190),
(65, 1, 191),
(66, 2, 192),
(66, 3, 193),
(66, 1, 194),
(67, 2, 195),
(67, 3, 196),
(67, 1, 197),
(68, 2, 198),
(68, 3, 199),
(68, 1, 200),
(69, 2, 201),
(69, 3, 202),
(69, 1, 203),
(70, 2, 204),
(70, 3, 205),
(70, 1, 206),
(71, 2, 207),
(71, 3, 208),
(71, 1, 209),
(72, 2, 210),
(72, 3, 211),
(72, 1, 212),
(73, 2, 213),
(73, 3, 214),
(73, 1, 215),
(74, 2, 216),
(74, 3, 217),
(74, 1, 218),
(75, 2, 219),
(75, 3, 220),
(75, 1, 221),
(76, 2, 222),
(76, 3, 223),
(76, 1, 224),
(77, 1, 225),
(77, 2, 226),
(77, 3, 227),
(78, 1, 228),
(78, 2, 229),
(78, 3, 230),
(79, 1, 231),
(79, 2, 232),
(79, 3, 233),
(80, 1, 234),
(80, 2, 235),
(80, 3, 236),
(81, 1, 237),
(81, 2, 238),
(81, 3, 239),
(82, 1, 240),
(82, 2, 241),
(82, 3, 242),
(83, 1, 243),
(83, 2, 244),
(83, 3, 245),
(84, 1, 246),
(84, 2, 247),
(84, 3, 248),
(85, 2, 249),
(85, 3, 250),
(86, 1, 251),
(86, 2, 252),
(86, 3, 253),
(87, 1, 254),
(87, 2, 255),
(88, 1, 256),
(88, 2, 257),
(88, 3, 258),
(89, 1, 259),
(89, 2, 260),
(89, 3, 261),
(90, 1, 262),
(90, 2, 263),
(90, 3, 264),
(91, 1, 265),
(91, 2, 266),
(91, 3, 267),
(92, 1, 268),
(92, 2, 269),
(92, 3, 270),
(93, 1, 271),
(93, 2, 272),
(93, 3, 273),
(94, 1, 274),
(94, 2, 275),
(94, 3, 276),
(95, 1, 277),
(95, 2, 278),
(95, 3, 279),
(96, 1, 280),
(96, 2, 281),
(97, 1, 282),
(97, 2, 283),
(98, 2, 284),
(99, 1, 285),
(99, 2, 286),
(99, 3, 287),
(100, 2, 288),
(101, 2, 289),
(103, 2, 291),
(104, 1, 292),
(104, 2, 293),
(104, 3, 294),
(105, 1, 295),
(106, 6, 296),
(107, 6, 297),
(108, 1, 298),
(109, 1, 299),
(110, 6, 300),
(111, 6, 301),
(112, 6, 302),
(113, 6, 303),
(114, 1, 304),
(114, 2, 305),
(114, 3, 306),
(115, 6, 307),
(116, 1, 308),
(116, 2, 309),
(117, 7, 310),
(118, 7, 311),
(122, 10, 315),
(122, 11, 316),
(122, 12, 317),
(102, 2, 318);

-- --------------------------------------------------------

--
-- Table structure for table `specs`
--

DROP TABLE IF EXISTS `specs`;
CREATE TABLE `specs` (
  `spec_id` int(16) UNSIGNED NOT NULL,
  `spec_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `spec_desc` mediumtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `specs`
--

INSERT INTO `specs` (`spec_id`, `spec_name`, `spec_desc`) VALUES
(1, 'Dichtheid kg*m^-3', NULL),
(2, 'Smeltpunt (K)', NULL),
(3, 'Kookpunt (K)', NULL),
(4, 'Sublimatiepunt (K)', NULL),
(5, 'Tripelpunt (K)', NULL),
(6, 'Halveringstijd (sec)', NULL),
(7, 'Kleur', NULL),
(10, 'Hoeveelheid studenten', NULL),
(11, 'Stad', NULL),
(12, 'Mooiste campus', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `spec_values`
--

DROP TABLE IF EXISTS `spec_values`;
CREATE TABLE `spec_values` (
  `value_id` int(16) UNSIGNED NOT NULL,
  `value_int` int(64) DEFAULT NULL,
  `value_char` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `spec_values`
--

INSERT INTO `spec_values` (`value_id`, `value_int`, `value_char`) VALUES
(1, NULL, '0,08988'),
(2, NULL, '14,01'),
(3, NULL, '20,28'),
(4, NULL, '0,1787'),
(5, NULL, '4,2'),
(6, NULL, '534'),
(7, NULL, '453,74'),
(8, NULL, '1620'),
(9, NULL, '1847,7'),
(10, NULL, '1551,2'),
(11, NULL, '2773'),
(12, NULL, '2340'),
(13, NULL, '2352'),
(14, NULL, '3923'),
(15, NULL, '2620'),
(16, NULL, '1,2506'),
(17, NULL, '63,3'),
(18, NULL, '77,4'),
(19, NULL, '1,429'),
(20, NULL, '54,8'),
(21, NULL, '90,2'),
(22, NULL, '1,696'),
(23, NULL, '53'),
(24, NULL, '85'),
(25, NULL, '0,89994'),
(26, NULL, '24,51'),
(27, NULL, '27,1'),
(28, NULL, '971'),
(29, NULL, '371,01'),
(30, NULL, '1154,6'),
(31, NULL, '1738'),
(32, NULL, '922'),
(33, NULL, '1378'),
(34, NULL, '2702'),
(35, NULL, '933'),
(36, NULL, '2740'),
(37, NULL, '2329'),
(38, NULL, '1687'),
(39, NULL, '3538'),
(40, NULL, '1820'),
(41, NULL, '317'),
(42, NULL, '553'),
(43, NULL, '2070'),
(44, NULL, '386'),
(45, NULL, '718'),
(46, NULL, '3,214'),
(47, NULL, '172'),
(48, NULL, '239'),
(49, NULL, '1,782'),
(50, NULL, '83,75'),
(51, NULL, '87,30'),
(52, NULL, '862'),
(53, NULL, '336,5'),
(54, NULL, '1038,7'),
(55, NULL, '1550'),
(56, NULL, '1112'),
(57, NULL, '1767'),
(58, NULL, '2989'),
(59, NULL, '1812,2'),
(60, NULL, '3021'),
(61, NULL, '4540'),
(62, NULL, '1940'),
(63, NULL, '3560'),
(64, NULL, '5800'),
(65, NULL, '2163'),
(66, NULL, '3623'),
(67, NULL, '7190'),
(68, NULL, '2130'),
(69, NULL, '2963'),
(70, NULL, '7430'),
(71, NULL, '1517'),
(72, NULL, '2333'),
(73, NULL, '8760'),
(74, NULL, '1811'),
(75, NULL, '3023'),
(76, NULL, '8900'),
(77, NULL, '1768'),
(78, NULL, '3373'),
(79, NULL, '8902'),
(80, NULL, '1728'),
(81, NULL, '3193'),
(82, NULL, '8960'),
(83, NULL, '1357'),
(84, NULL, '2843'),
(85, NULL, '7140'),
(86, NULL, '692'),
(87, NULL, '1182'),
(88, NULL, '5907'),
(89, NULL, '302'),
(90, NULL, '2478'),
(91, NULL, '5323'),
(92, NULL, '1210'),
(93, NULL, '3123'),
(94, NULL, '5720'),
(95, NULL, '886'),
(96, NULL, '1090'),
(97, NULL, '4790'),
(98, NULL, '490'),
(99, NULL, '958'),
(100, NULL, '3119'),
(101, NULL, '226'),
(102, NULL, '332'),
(103, NULL, '3,708'),
(104, NULL, '116,6'),
(105, NULL, '119,7'),
(106, NULL, '312,09'),
(107, NULL, '961'),
(108, NULL, '1532'),
(109, NULL, '312,09'),
(110, NULL, '961'),
(111, NULL, '2640'),
(112, NULL, '1042'),
(113, NULL, '1655'),
(114, NULL, '4469'),
(115, NULL, '2125'),
(116, NULL, '4473'),
(117, NULL, '6506'),
(118, NULL, ''),
(119, NULL, ''),
(120, NULL, ''),
(121, NULL, '2890'),
(122, NULL, '4900'),
(123, NULL, '10280'),
(124, NULL, '2445'),
(125, NULL, '4840'),
(126, NULL, '11500'),
(127, NULL, '2583'),
(128, NULL, '4323'),
(129, NULL, '12370'),
(130, NULL, '2238'),
(131, NULL, '4033'),
(132, NULL, '12400'),
(133, NULL, '1827'),
(134, NULL, '3213'),
(135, NULL, '12020'),
(136, NULL, '1235'),
(137, NULL, '2428'),
(138, NULL, '10500'),
(139, NULL, '594'),
(140, NULL, '1038'),
(141, NULL, '8650'),
(142, NULL, '429'),
(143, NULL, '2353'),
(144, NULL, '7310'),
(145, NULL, '505'),
(146, NULL, '2896'),
(147, NULL, '7300'),
(148, NULL, '904'),
(149, NULL, '1860'),
(150, NULL, '6684'),
(151, NULL, '723'),
(152, NULL, '6240'),
(153, NULL, '386,7'),
(154, NULL, '458,4'),
(155, NULL, '4930'),
(156, NULL, '161,3'),
(157, NULL, '165'),
(158, NULL, '5,88'),
(159, NULL, '301,6'),
(160, NULL, '944,2'),
(161, NULL, '1873'),
(162, NULL, '998'),
(163, NULL, '2123'),
(164, NULL, '3510'),
(165, NULL, '1193'),
(166, NULL, '3693'),
(167, NULL, '6700'),
(168, NULL, '1070'),
(169, NULL, '3700'),
(170, NULL, '7254'),
(171, NULL, '1204'),
(172, NULL, '3790'),
(173, NULL, '6773'),
(174, NULL, '1294'),
(175, NULL, '3350'),
(176, NULL, '7007'),
(177, NULL, '1315'),
(178, NULL, '3000'),
(179, NULL, '7220'),
(180, NULL, '1347'),
(181, NULL, '2067'),
(182, NULL, '7520'),
(183, NULL, '1095'),
(184, NULL, '1870'),
(185, NULL, '5243'),
(186, NULL, '1586'),
(187, NULL, '3540'),
(188, NULL, '7900'),
(189, NULL, '1630'),
(190, NULL, '3500'),
(191, NULL, '8229'),
(192, NULL, '1685'),
(193, NULL, '2540'),
(194, NULL, '8550'),
(195, NULL, '1745'),
(196, NULL, '2970'),
(197, NULL, '8795'),
(198, NULL, '1802'),
(199, NULL, '3140'),
(200, NULL, '9066'),
(201, NULL, '1838'),
(202, NULL, '2223'),
(203, NULL, '9321'),
(204, NULL, '1095'),
(205, NULL, '1469'),
(206, NULL, '6965'),
(207, NULL, '1936'),
(208, NULL, '3670'),
(209, NULL, '9840'),
(210, NULL, '2495'),
(211, NULL, '4723'),
(212, NULL, '13600'),
(213, NULL, '3269'),
(214, NULL, '5807'),
(215, NULL, '16654'),
(216, NULL, '3695'),
(217, NULL, '5828'),
(218, NULL, '19300'),
(219, NULL, '3453'),
(220, NULL, '5900'),
(221, NULL, '21000'),
(222, NULL, '3318'),
(223, NULL, '5300'),
(224, NULL, '22610'),
(225, NULL, '22560'),
(226, NULL, '2683'),
(227, NULL, '4823'),
(228, NULL, '21450'),
(229, NULL, '2045'),
(230, NULL, '4443'),
(231, NULL, '19320'),
(232, NULL, '1337'),
(233, NULL, '3081'),
(234, NULL, '13546'),
(235, NULL, '234'),
(236, NULL, '630'),
(237, NULL, '11850'),
(238, NULL, '576,7'),
(239, NULL, '1730'),
(240, NULL, '11340'),
(241, NULL, '600'),
(242, NULL, '2024'),
(243, NULL, '9747'),
(244, NULL, '544'),
(245, NULL, '1837'),
(246, NULL, '9320'),
(247, NULL, '527'),
(248, NULL, '1235'),
(249, NULL, '575'),
(250, NULL, '610'),
(251, NULL, '9,73'),
(252, NULL, '202'),
(253, NULL, '211'),
(254, NULL, '1870'),
(255, NULL, '300'),
(256, NULL, '5000'),
(257, NULL, '973'),
(258, NULL, '1973'),
(259, NULL, '10070'),
(260, NULL, '1324'),
(261, NULL, '2743'),
(262, NULL, '11720'),
(263, NULL, '2023'),
(264, NULL, '5000'),
(265, NULL, '15370'),
(266, NULL, '1845'),
(267, NULL, '4300'),
(268, NULL, '18950'),
(269, NULL, '1408'),
(270, NULL, '4404'),
(271, NULL, '20250'),
(272, NULL, '915'),
(273, NULL, '4175'),
(274, NULL, '19840'),
(275, NULL, '913'),
(276, NULL, '3503'),
(277, NULL, '13670'),
(278, NULL, '1449'),
(279, NULL, '2284'),
(280, NULL, '13300'),
(281, NULL, '1618'),
(282, NULL, '14790'),
(283, NULL, '1323'),
(284, NULL, '24,51'),
(285, NULL, '8840'),
(286, NULL, '1133'),
(287, NULL, '1269'),
(288, NULL, '1125'),
(289, NULL, '1100'),
(291, NULL, '1900'),
(292, NULL, '23200'),
(293, NULL, '2400'),
(294, NULL, '5800'),
(295, NULL, '29000'),
(296, NULL, '144'),
(297, NULL, '0.44'),
(298, NULL, '30000'),
(299, NULL, '37000'),
(300, NULL, '9.6'),
(301, NULL, '126'),
(302, NULL, '252'),
(303, NULL, '19.6'),
(304, NULL, '14000'),
(305, NULL, '340'),
(306, NULL, '420'),
(307, NULL, '0.22'),
(308, NULL, '12900'),
(309, NULL, '715'),
(310, NULL, 'Waarschijnlijk donker en metaalachtig'),
(311, NULL, 'Kleurloos'),
(315, NULL, '45000'),
(316, NULL, 'Amsterdam'),
(317, NULL, 'Science Park'),
(318, NULL, '1100');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `supplier_id` int(16) UNSIGNED NOT NULL,
  `supplier_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` int(16) UNSIGNED DEFAULT NULL,
  `address_id` int(16) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(16) UNSIGNED NOT NULL,
  `first_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `prefix` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_birth` date NOT NULL,
  `sex` set('male','female','none') COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(256) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `phone` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `address_id` int(16) UNSIGNED DEFAULT NULL,
  `passwd_hash` varchar(256) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `privilege_level` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `surname`, `prefix`, `date_birth`, `sex`, `email`, `phone`, `address_id`, `passwd_hash`, `privilege_level`) VALUES
(1, 'Frederick', 'Kreuk', '', '1998-07-31', 'male', 'rick.kreuk@me.com', '0681206639', 1, '$2y$10$RMuMHxUbpu2kPt.0P/Qir.g/QSPxE0a06jHAj5MNq.yZdCaqJXwle', 9),
(2, 'Jens', 'Kalshoven', '', '1997-03-31', 'male', 'jens.kalshoven@gmail.com', '0644598876', 2, '$2y$10$AG6kquam/mlcsgybOJDDiuK2Qbcvucz4yjpJJHxtOXYLNtM8NwUZu', 9),
(3, 'Niels', 'Zwemmer', '', '1995-12-29', 'male', 'nielzwe@live.nl', '0612345678', 4, '$2y$10$W8xXypuML9ltWK9LJztmzOyVv7gWQAKWR4teAZvx8DIoXSxfYIsJW', 0),
(4, 'Rico', 'Hoegee', '', '1996-07-21', 'male', 'ricotlfm@gmail.com', '0612345678', 6, '$2y$10$sS7XyFmYdfIf3.2zs6VuSeHS4nDJKlmvjv6ChckDR43t5H6twSBta', 9),
(5, 'Sander', 'Hansen', '', '1996-10-01', 'male', 'sanderisbestok@gmail.com', '0618453742', 7, '$2y$10$Dl738XJusd3ZI2aeUUelbeE.LM8tDrHl0eSEMMTukmnJzJ9dV3t1O', 9),
(6, 'Optimus', 'Prime', '', '2000-01-01', 'male', 'optimus_prime@cybertron.com', '0612345678', 10, '$2y$10$Fw6PCs2HWx/9AtVVBuRcZuK6f0dcss.sJVI8ywFaZquGutQX66MYi', 9),
(7, 'Admin', 'Admin', '', '1996-10-01', 'male', 'admin@swatman.nl', '0618453742', 25, '$2y$10$fk4mYisJ.cBtVnU0rRIvm.HAQkFcLb9PCXucXTh9lAZl5.fLmbuy.', 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`price_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `products_media`
--
ALTER TABLE `products_media`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `products_orders`
--
ALTER TABLE `products_orders`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `price_id` (`price_id`);

--
-- Indexes for table `products_specs`
--
ALTER TABLE `products_specs`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `spec_id` (`spec_id`),
  ADD KEY `value_id` (`value_id`);

--
-- Indexes for table `specs`
--
ALTER TABLE `specs`
  ADD PRIMARY KEY (`spec_id`),
  ADD UNIQUE KEY `spec_name` (`spec_name`);

--
-- Indexes for table `spec_values`
--
ALTER TABLE `spec_values`
  ADD PRIMARY KEY (`value_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `address_id` (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `media_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `price_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT for table `specs`
--
ALTER TABLE `specs`
  MODIFY `spec_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `spec_values`
--
ALTER TABLE `spec_values`
  MODIFY `value_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_media`
--
ALTER TABLE `products_media`
  ADD CONSTRAINT `products_media_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`media_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_media_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_orders`
--
ALTER TABLE `products_orders`
  ADD CONSTRAINT `products_orders_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `products_orders_ibfk_3` FOREIGN KEY (`price_id`) REFERENCES `prices` (`price_id`) ON UPDATE CASCADE;

--
-- Constraints for table `products_specs`
--
ALTER TABLE `products_specs`
  ADD CONSTRAINT `products_specs_ibfk_3` FOREIGN KEY (`value_id`) REFERENCES `spec_values` (`value_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_specs_ibfk_1` FOREIGN KEY (`spec_id`) REFERENCES `specs` (`spec_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_specs_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
