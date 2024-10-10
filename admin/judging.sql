-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2023 at 10:55 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `judging`
--

-- --------------------------------------------------------

--
-- Table structure for table `contestants`
--

CREATE TABLE `contestants` (
  `contestant_id` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `subevent_id` int(11) NOT NULL,
  `contestant_ctr` int(11) NOT NULL,
  `status` text NOT NULL,
  `txt_code` text NOT NULL,
  `rand_code` int(15) NOT NULL,
  `txtPollScore` int(11) NOT NULL,
  `Picture` text NOT NULL,
  `AddOn` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contestants`
--

INSERT INTO `contestants` (`contestant_id`, `fullname`, `subevent_id`, `contestant_ctr`, `status`, `txt_code`, `rand_code`, `txtPollScore`, `Picture`, `AddOn`) VALUES
(97, 'Queenielyn Batayola', 40, 1, 'finish', 'bsit 2 east', 521888, 1, '1680009246633.jpg', '2 - East'),
(98, 'Rinalyn B. Desamparado', 40, 2, 'finish', 'bsit 3 north', 522946, 0, '1680009231762.jpg', '2 - North'),
(99, 'Cj E. Jumantoc', 40, 3, 'finish', 'bsit 3 west', 2215233, 0, '1680009223377.jpg', '3 - West'),
(100, 'Mitche B. Pedroza', 40, 4, 'finish', '', 2215234, 0, '1680009215747.jpg', '2 - North'),
(101, 'Mylene T. Giltendez', 40, 5, 'finish', '', 2215235, 0, '1680009202934.jpg', '3 - North'),
(102, 'Roselyn A. Rosales ', 40, 6, 'finish', '', 2215236, 0, '1680009174138.jpg', '1 - North'),
(103, 'Judy Ann G. Escaran', 40, 7, 'finish', '', 2215237, 0, '1680009163409.jpg', '2 - West'),
(104, 'Jessica Ilustrisimo', 40, 8, 'finish', '', 2215238, 0, '1680009154906.jpg', '3 - South'),
(105, 'Emma P. Giltendez', 40, 9, 'finish', '', 2215239, 0, '1680009091504.jpg', '1 - East'),
(106, 'Zeny Cervantes', 40, 10, 'finish', '', 22152310, 0, '1680009063226.jpg', '1 - North'),
(107, 'Shella B. Bautro', 40, 11, 'finish', '', 22152311, 0, '1680009052971.jpg', '3 - East'),
(108, 'Jessamen I. Ilustrisimo', 40, 12, 'finish', '', 22152312, 0, '1680009038139.jpg', '1 - West'),
(109, 'Dianna Lyn Y. Cena', 40, 13, 'finish', '', 22152313, 0, '1680008991102.jpg', '2 South'),
(110, 'Queenielyn Batayola', 41, 1, 'finish', '', 978025, 1, '1680009246633.jpg', '2 - East'),
(111, 'Rinalyn B. Desamparado', 41, 2, 'finish', '', 879443, 0, '1680009231762.jpg', '2 - North'),
(112, 'Cj E. Jumantoc', 41, 3, 'finish', '', 5786813, 0, '1680009223377.jpg', '3 - West'),
(113, 'Mitche B. Pedroza', 41, 4, 'finish', '', 5786814, 0, '1680009215747.jpg', '2 - North'),
(114, 'Mylene T. Giltendez', 41, 5, 'finish', '', 5786815, 0, '1680009202934.jpg', '3 - North'),
(115, 'Roselyn A. Rosales ', 41, 6, 'finish', '', 5786816, 0, '1680009174138.jpg', '1 - North'),
(116, 'Judy Ann G. Escaran', 41, 7, 'finish', '', 5786817, 0, '1680009163409.jpg', '2 - West'),
(117, 'Jessica Ilustrisimo', 41, 8, 'finish', '', 5786818, 0, '1680009154906.jpg', '3 - South'),
(118, 'Emma P. Giltendez', 41, 9, 'finish', '', 5786819, 0, '1680009091504.jpg', '1 - East'),
(119, 'Zeny Cervantes', 41, 10, 'finish', '', 57868110, 0, '1680009063226.jpg', '1 - North'),
(120, 'Shella B. Bautro', 41, 11, 'finish', '', 57868111, 0, '1680009052971.jpg', '3 - East'),
(121, 'Jessamen I. Ilustrisimo', 41, 12, 'finish', '', 57868112, 0, '1680009038139.jpg', '1 - West'),
(122, 'Dianna Lyn Y. Cena', 41, 13, 'finish', '', 57868113, 0, '1680008991102.jpg', '2 South'),
(123, 'Queenielyn Batayola', 42, 1, 'finish', '', 564534, 0, '1680009246633.jpg', '2 - East'),
(124, 'Rinalyn B. Desamparado', 42, 2, 'finish', '', 967000, 0, '1680009231762.jpg', '2 - North'),
(125, 'Cj E. Jumantoc', 42, 3, 'finish', '', 2952703, 0, '1680009223377.jpg', '3 - West'),
(126, 'Mitche B. Pedroza', 42, 4, 'finish', '', 2952704, 0, '1680009215747.jpg', '2 - North'),
(127, 'Mylene T. Giltendez', 42, 5, 'finish', '', 2952705, 0, '1680009202934.jpg', '3 - North'),
(128, 'Roselyn A. Rosales ', 42, 6, 'finish', '', 2952706, 0, '1680009174138.jpg', '1 - North'),
(129, 'Judy Ann G. Escaran', 42, 7, 'finish', '', 2952707, 0, '1680009163409.jpg', '2 - West'),
(130, 'Jessica Ilustrisimo', 42, 8, 'finish', '', 2952708, 0, '1680009154906.jpg', '3 - South'),
(131, 'Emma P. Giltendez', 42, 9, 'finish', '', 2952709, 0, '1680009091504.jpg', '1 - East'),
(132, 'Zeny Cervantes', 42, 10, 'finish', '', 29527010, 0, '1680009063226.jpg', '1 - North'),
(133, 'Shella B. Bautro', 42, 11, 'finish', '', 29527011, 0, '1680009052971.jpg', '3 - East'),
(134, 'Jessamen I. Ilustrisimo', 42, 12, 'finish', '', 29527012, 0, '1680009038139.jpg', '1 - West'),
(135, 'Dianna Lyn Y. Cena', 42, 13, 'finish', '', 29527013, 0, '1680008991102.jpg', '2 South'),
(136, 'Queenielyn Batayola', 43, 1, 'finish', '', 362141, 1, '1680009246633.jpg', '2 - East'),
(137, 'Rinalyn B. Desamparado', 43, 2, 'finish', '', 720175, 0, '1680009231762.jpg', '2 - North'),
(138, 'Cj E. Jumantoc', 43, 3, 'finish', '', 7515873, 0, '1680009223377.jpg', '3 - West'),
(139, 'Mitche B. Pedroza', 43, 4, 'finish', '', 7515874, 0, '1680009215747.jpg', '2 - North'),
(140, 'Mylene T. Giltendez', 43, 5, 'finish', '', 7515875, 0, '1680009202934.jpg', '3 - North'),
(141, 'Roselyn A. Rosales ', 43, 6, 'finish', '', 7515876, 0, '1680009174138.jpg', '1 - North'),
(142, 'Judy Ann G. Escaran', 43, 7, 'finish', '', 7515877, 0, '1680009163409.jpg', '2 - West'),
(143, 'Jessica Ilustrisimo', 43, 8, 'finish', '', 7515878, 0, '1680009154906.jpg', '3 - South'),
(144, 'Emma P. Giltendez', 43, 9, 'finish', '', 7515879, 0, '1680009091504.jpg', '1 - East'),
(145, 'Zeny Cervantes', 43, 10, 'finish', '', 75158710, 0, '1680009063226.jpg', '1 - North'),
(146, 'Shella B. Bautro', 43, 11, 'finish', '', 75158711, 0, '1680009052971.jpg', '3 - East'),
(147, 'Jessamen I. Ilustrisimo', 43, 12, 'finish', '', 75158712, 0, '1680009038139.jpg', '1 - West'),
(148, 'Dianna Lyn Y. Cena', 43, 13, 'finish', '', 75158713, 0, '1680008991102.jpg', '2 South'),
(162, 'Queenielyn Batayola', 47, 1, 'finish', '', 905821, 0, '1680009246633.jpg', ''),
(163, 'Mitche B. Pedroza', 47, 2, 'finish', '', 140729, 0, '1680009215747.jpg', ''),
(164, 'Roselyn A. Rosales ', 47, 6, 'finish', '', 4557836, 0, '1680009174138.jpg', ''),
(165, 'Judy Ann G. Escaran', 47, 7, 'finish', '', 4557837, 1, '1680009163409.jpg', ''),
(166, 'Jessamen I. Ilustrisimo', 47, 12, 'finish', '', 45578312, 1, '1680009038139.jpg', ''),
(167, 'Queenielyn Batayola', 48, 1, 'finish', '', 717214, 0, '1680009246633.jpg', '2 - East'),
(168, 'Rinalyn B. Desamparado', 48, 2, '', '', 393695, 0, '1680009231762.jpg', '2 - North'),
(169, 'Cj E. Jumantoc', 48, 3, '', '', 3901653, 0, '1680009223377.jpg', '3 - West'),
(170, 'Mitche B. Pedroza', 48, 4, '', '', 3901654, 0, '1680009215747.jpg', '2 - North'),
(171, 'Mylene T. Giltendez', 48, 5, '', '', 3901655, 0, '1680009202934.jpg', '3 - North');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `criteria_id` int(11) NOT NULL,
  `subevent_id` int(11) NOT NULL,
  `criteria` text NOT NULL,
  `percentage` int(11) NOT NULL,
  `criteria_ctr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`criteria_id`, `subevent_id`, `criteria`, `percentage`, `criteria_ctr`) VALUES
(54, 40, 'Poise and Beauty', 30, 1),
(55, 40, 'Mastery', 30, 2),
(56, 40, 'Self Confidence', 20, 3),
(57, 40, 'Audience Impact', 20, 4),
(58, 41, 'Figure & Fitness', 40, 1),
(59, 41, 'Stage Presence', 20, 2),
(60, 41, 'Confidence', 30, 3),
(61, 41, 'Overall Impact', 10, 4),
(62, 42, 'Creativity & Design', 40, 1),
(63, 42, 'Stage Presence', 20, 2),
(64, 42, 'Poise & Beauty', 30, 3),
(65, 42, 'Overall Impact', 10, 4),
(66, 43, 'Design & Fitting', 20, 1),
(67, 43, 'Stage Deportment', 30, 2),
(68, 43, 'Poise & Beauty', 40, 3),
(69, 43, 'Overall Impact', 10, 4),
(74, 47, 'Wit & Content', 40, 1),
(75, 47, 'Stage Presence', 20, 2),
(76, 47, 'Projection & Delivery', 30, 3),
(77, 47, 'Overall Impact', 10, 4),
(78, 48, 'PRODUCTION NUMBER', 30, 1),
(79, 48, 'SWIMWEAR ATTIRE', 30, 2),
(80, 48, 'EVENING GOWN', 20, 3),
(81, 48, 'Overall Impact', 20, 4);

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `judge_id` int(11) NOT NULL,
  `subevent_id` int(11) NOT NULL,
  `judge_ctr` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `code` varchar(6) NOT NULL,
  `jtype` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`judge_id`, `subevent_id`, `judge_ctr`, `fullname`, `code`, `jtype`) VALUES
(52, 40, 1, 'MR. ROWAN YHAPON', '7q47c4', ''),
(53, 40, 2, 'MR.DINO ILUSTRISIMO', 'rhk6sd', ''),
(54, 40, 3, 'ENGR. ROMEO VILLACERAN', 'xi7nbe', ''),
(55, 40, 4, 'MR.JANNAH CARATAO', 'adepm1', ''),
(56, 40, 5, 'MR. REYAN DIAZ', '', ''),
(57, 41, 1, 'MR. ROWAN YHAPON', 'r13qjc', ''),
(58, 41, 2, 'MR.DINO ILUSTRISIMO', 'a34npi', ''),
(59, 41, 3, 'ENGR. ROMEO VILLACERAN', 'gom4dh', ''),
(60, 41, 4, 'MR.JANNAH CARATAO', 'znu1nv', ''),
(61, 41, 5, 'MR. REYAN DIAZ', '', ''),
(62, 42, 1, 'MR. ROWAN YHAPON', 'jxo40k', ''),
(63, 42, 2, 'MR.DINO ILUSTRISIMO', 'ptchka', ''),
(64, 42, 3, 'ENGR. ROMEO VILLACERAN', 't65sft', ''),
(65, 42, 4, 'MR.JANNAH CARATAO', '6qswg7', ''),
(66, 42, 5, 'MR. REYAN DIAZ', '', ''),
(67, 43, 1, 'MR. ROWAN YHAPON', 'w1q2mx', ''),
(68, 43, 2, 'MR.DINO ILUSTRISIMO', 'edsvh6', ''),
(69, 43, 3, 'ENGR. ROMEO VILLACERAN', 'ha7tfw', ''),
(70, 43, 4, 'MR.JANNAH CARATAO', '7p2phg', ''),
(71, 43, 5, 'MR. REYAN DIAZ', '', ''),
(77, 47, 1, 'MR. ROWAN YHAPON', '72s6k1', ''),
(78, 47, 2, 'MR.DINO ILUSTRISIMO', '5225nc', ''),
(79, 47, 3, 'ENGR. ROMEO VILLACERAN', 'tcfqxf', ''),
(80, 47, 4, 'MR.JANNAH CARATAO', 'mbc7qb', ''),
(81, 48, 1, 'MR. ROWAN YHAPON', 'rudzd3', ''),
(82, 48, 2, 'MR.DINO ILUSTRISIMO', 'kxcojc', ''),
(83, 48, 3, 'ENGR. ROMEO VILLACERAN', 'swup5v', ''),
(84, 48, 4, 'MR.JANNAH CARATAO', 'mnbc6s', '');

-- --------------------------------------------------------

--
-- Table structure for table `main_event`
--

CREATE TABLE `main_event` (
  `mainevent_id` int(11) NOT NULL,
  `event_name` text NOT NULL,
  `status` text NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `sy` varchar(9) NOT NULL,
  `date_start` text NOT NULL,
  `date_end` text NOT NULL,
  `place` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_event`
--

INSERT INTO `main_event` (`mainevent_id`, `event_name`, `status`, `organizer_id`, `sy`, `date_start`, `date_end`, `place`) VALUES
(41, 'Ms IT DAY', 'activated', 19, '1', '', '', 'MCC COVERED COURT'),
(42, 'Singing Contest', 'activated', 19, '2', '', '', 'MCC'),
(43, 'MS IT 2023', 'activated', 19, '2', '', '', 'MCC COVERED COURT'),
(44, 'BSIT DAY', 'activated', 29, '1', '', '', 'MCC COVERD');

-- --------------------------------------------------------

--
-- Table structure for table `messagein`
--

CREATE TABLE `messagein` (
  `Id` int(11) NOT NULL,
  `SendTime` varchar(10) DEFAULT NULL,
  `ReceiveTime` varchar(10) DEFAULT NULL,
  `MessageFrom` bigint(12) DEFAULT NULL,
  `MessageTo` varchar(10) DEFAULT NULL,
  `SMSC` varchar(10) DEFAULT NULL,
  `MessageText` varchar(4) DEFAULT NULL,
  `MessageType` varchar(10) DEFAULT NULL,
  `MessagePDU` varchar(10) DEFAULT NULL,
  `Gateway` varchar(10) DEFAULT NULL,
  `UserId` varchar(10) DEFAULT NULL,
  `sendStatus` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messagelog`
--

CREATE TABLE `messagelog` (
  `Id` int(11) NOT NULL,
  `SendTime` datetime DEFAULT NULL,
  `ReceiveTime` datetime DEFAULT NULL,
  `StatusCode` int(11) DEFAULT NULL,
  `StatusText` varchar(80) DEFAULT NULL,
  `MessageTo` varchar(80) DEFAULT NULL,
  `MessageFrom` varchar(80) DEFAULT NULL,
  `MessageText` text DEFAULT NULL,
  `MessageType` varchar(80) DEFAULT NULL,
  `MessageId` varchar(80) DEFAULT NULL,
  `ErrorCode` varchar(80) DEFAULT NULL,
  `ErrorText` varchar(80) DEFAULT NULL,
  `Gateway` varchar(80) DEFAULT NULL,
  `MessageParts` int(11) DEFAULT NULL,
  `MessagePDU` text DEFAULT NULL,
  `Connector` varchar(80) DEFAULT NULL,
  `UserId` varchar(80) DEFAULT NULL,
  `UserInfo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messagelog`
--

INSERT INTO `messagelog` (`Id`, `SendTime`, `ReceiveTime`, `StatusCode`, `StatusText`, `MessageTo`, `MessageFrom`, `MessageText`, `MessageType`, `MessageId`, `ErrorCode`, `ErrorText`, `Gateway`, `MessageParts`, `MessagePDU`, `Connector`, `UserId`, `UserInfo`) VALUES
(26, '2017-02-18 16:11:34', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '2017-02-18 16:12:00', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '2017-02-18 16:12:00', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, '2017-02-18 16:12:00', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, '2017-02-18 16:12:00', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '2017-02-18 16:12:00', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, '2017-02-18 16:12:00', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, '2017-02-18 16:12:00', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, '2017-02-18 16:12:00', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, '2017-02-18 16:12:31', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, '2017-02-18 16:12:31', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, '2017-02-18 16:12:31', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, '2017-02-18 16:12:31', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, '2017-02-18 16:12:31', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, '2017-02-18 16:12:31', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, '2017-02-18 16:12:31', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, '2017-02-18 16:12:31', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, '2017-02-18 16:21:40', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, '2017-02-18 16:22:10', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, '2017-02-18 16:23:10', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, '2017-02-18 16:23:41', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, '2017-02-18 16:24:13', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, '2017-02-18 16:24:45', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, '2017-02-18 16:25:16', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, '2017-02-18 16:27:19', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, '2017-02-18 16:27:21', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, '2017-02-18 16:30:21', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, '2017-02-18 16:30:49', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, '2017-02-18 16:31:21', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, '2017-02-18 16:32:21', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, '2017-02-18 16:38:03', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, '2017-02-18 16:38:33', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, '2017-02-18 16:40:09', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, '2017-02-18 16:40:11', NULL, 300, NULL, '+', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, '2017-02-18 16:40:41', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, '2017-02-18 16:42:16', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, '2017-02-18 16:42:16', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, '2017-02-18 16:42:59', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, '2017-02-18 16:43:30', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, '2017-02-18 16:44:02', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, '2017-02-18 16:44:34', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, '2017-02-18 16:45:05', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, '2017-02-18 16:50:22', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, '2017-02-18 16:50:55', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, '2017-02-18 16:54:03', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, '2017-02-18 16:55:35', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, '2017-02-18 16:56:07', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, '2017-02-18 16:56:39', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, '2017-02-18 16:57:12', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(133, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(134, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(135, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(136, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(137, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(138, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(139, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(143, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(144, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(145, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(146, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(147, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(148, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(149, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(150, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(151, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(152, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(153, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(154, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(155, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(156, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(157, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(158, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(159, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(160, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(161, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(162, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(163, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(164, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(165, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(166, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(167, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(168, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(169, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(170, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(171, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(172, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(173, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(174, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(175, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(176, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(177, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(178, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(179, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(180, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(181, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(182, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(183, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(184, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(185, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(186, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(187, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(188, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(189, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(190, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(191, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(192, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(193, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(194, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(195, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(196, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(197, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(198, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(199, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(200, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(201, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(202, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(203, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(204, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(205, '2017-02-18 17:02:44', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(206, '2017-02-18 17:02:44', NULL, 300, NULL, '+4438', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(207, '2017-02-18 17:02:44', NULL, 300, NULL, '+8080', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(208, '2017-02-18 17:15:15', NULL, 300, NULL, '+0', 'BCC EJS', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(209, '2017-02-18 17:30:24', NULL, 200, NULL, '+639074946964', 'test message', NULL, NULL, '1:+639074946964:197', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(210, '2017-02-18 17:35:38', NULL, 200, NULL, '+639074946964', 'Thank you. Your vote has been counted.', NULL, NULL, '1:+639074946964:198', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211, '2017-02-18 17:35:40', NULL, 200, NULL, '+4438', 'Wrong code. Pls. try again.', NULL, NULL, '1:+4438:199', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(212, '2017-02-18 17:37:47', NULL, 300, NULL, '', '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(213, '2017-02-18 17:38:23', NULL, 300, NULL, '', '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(214, '2017-02-18 17:38:47', NULL, 300, NULL, '', '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(215, '2017-02-18 17:39:09', NULL, 200, NULL, '+639074946964', 'Wrong code. Pls. try again.', NULL, NULL, '1:+639074946964:200', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(216, '2017-02-18 17:39:47', NULL, 200, NULL, '+639074946964', 'You have voted previously. Your vote is not counted.', NULL, NULL, '1:+639074946964:201', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(217, '2017-02-18 17:41:41', NULL, 200, NULL, '+639074946964', 'Thank you. Your vote has been counted.', NULL, NULL, '1:+639074946964:202', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(218, '2017-02-18 17:42:18', NULL, 200, NULL, '+639074946964', 'You have voted previously. Your vote is not counted.', NULL, NULL, '1:+639074946964:203', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(219, '2017-02-18 17:47:10', NULL, 200, NULL, '+639074946964', 'You have voted previously. Your vote is not counted.', NULL, NULL, '1:+639074946964:204', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(220, '2017-02-18 17:48:36', NULL, 200, NULL, '+639074946964', 'Thank you. Your vote has been counted.', NULL, NULL, '1:+639074946964:205', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(221, '2017-02-18 17:49:19', NULL, 200, NULL, '+639074946964', 'Wrong code. Pls. try again.', NULL, NULL, '1:+639074946964:206', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(222, '2017-02-18 17:52:58', NULL, 200, NULL, '+639983401847', 'Wrong code. Pls. try again.', NULL, NULL, '1:+639983401847:207', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(223, '2017-02-18 17:55:22', NULL, 200, NULL, '+639468601299', 'Thank you. Your vote has been counted.', NULL, NULL, '1:+639468601299:208', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(224, '2017-02-18 17:56:15', NULL, 200, NULL, '+639468601299', 'Thank you. Your vote has been counted.', NULL, NULL, '1:+639468601299:209', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(225, '2017-02-18 17:57:01', NULL, 200, NULL, '+639468601299', 'Thank you. Your vote has been counted.', NULL, NULL, '1:+639468601299:210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(226, '2017-02-18 18:02:11', NULL, 200, NULL, '+639156444975', 'Thank you. Your vote has been counted.', NULL, NULL, '1:+639156444975:211', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(227, '2017-02-18 18:02:49', NULL, 200, NULL, '+639156444975', 'Wrong code. Pls. try again.', NULL, NULL, '1:+639156444975:212', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messageout`
--

CREATE TABLE `messageout` (
  `Id` int(11) NOT NULL,
  `MessageTo` varchar(80) DEFAULT NULL,
  `MessageFrom` varchar(80) DEFAULT NULL,
  `MessageText` text DEFAULT NULL,
  `MessageType` varchar(80) DEFAULT NULL,
  `Gateway` varchar(80) DEFAULT NULL,
  `UserId` varchar(80) DEFAULT NULL,
  `UserInfo` text DEFAULT NULL,
  `Priority` int(11) DEFAULT NULL,
  `Scheduled` datetime DEFAULT NULL,
  `ValidityPeriod` int(11) DEFAULT NULL,
  `IsSent` tinyint(1) NOT NULL DEFAULT 0,
  `IsRead` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `organizer`
--

CREATE TABLE `organizer` (
  `organizer_id` int(11) NOT NULL,
  `fname` text NOT NULL,
  `mname` text NOT NULL,
  `lname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `pnum` varchar(15) NOT NULL,
  `txt_poll_num` varchar(15) NOT NULL,
  `access` varchar(25) NOT NULL,
  `org_id` varchar(12) NOT NULL,
  `status` varchar(12) NOT NULL,
  `company_name` varchar(55) NOT NULL,
  `company_address` varchar(55) NOT NULL,
  `company_logo` varchar(55) NOT NULL,
  `company_telephone` varchar(55) NOT NULL,
  `company_email` varchar(55) NOT NULL,
  `company_website` varchar(55) NOT NULL,
  `reset_token` varchar(64) NOT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organizer`
--

INSERT INTO `organizer` (`organizer_id`, `fname`, `mname`, `lname`, `username`, `password`, `email`, `pnum`, `txt_poll_num`, `access`, `org_id`, `status`, `company_name`, `company_address`, `company_logo`, `company_telephone`, `company_email`, `company_website`, `reset_token`, `reset_expires`) VALUES
(19, 'CHRISTIAN PAUL', 'LANORIAS', 'SALVADO', 'blue', 'blue', 'salvadochristianpaul5@gmail.com', '09385974999', '09385974999', 'Organizer', '', 'online', '', 'BANTAYAN ISLAND CEBU', '52985-ejs_logo.png', '000-0000', '', '', '12345abcde', '2023-05-07 14:21:21'),
(20, 'JOHN PAUL', '', 'UNGON', 'red', 'red', 'evas.jygona@gmail.com', '', '', 'Tabulator', '19', 'offline', '', '', '', '', '', '', '', NULL),
(27, 'user', 'user', 'user', 'user', 'user', '', '', '09078262015', 'Organizer', '', 'offline', '', '', '', '', '', '', '', NULL),
(28, 'black', 'black', 'black', '123', '123', '', '', '', 'Organizer', '', 'offline', '', '', '', '', '', '', '', NULL),
(29, 'Shiela', 'Ducay', 'Yhapon', 'shiela', '0415', '', '', '', 'Organizer', '', 'offline', '', '', '', '', '', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rank_system`
--

CREATE TABLE `rank_system` (
  `rs_id` int(11) NOT NULL,
  `subevent_id` varchar(12) NOT NULL,
  `contestant_id` varchar(12) NOT NULL,
  `total_rank` decimal(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rank_system`
--

INSERT INTO `rank_system` (`rs_id`, `subevent_id`, `contestant_id`, `total_rank`) VALUES
(16, '40', '97', '18.0'),
(17, '40', '98', '39.0'),
(18, '40', '99', '22.0'),
(19, '40', '100', '19.5'),
(20, '40', '101', '36.0'),
(21, '40', '102', '23.0'),
(22, '40', '103', '20.5'),
(23, '40', '104', '30.0'),
(24, '40', '105', '37.0'),
(25, '40', '106', '31.5'),
(26, '40', '107', '28.0'),
(27, '40', '108', '28.5'),
(28, '40', '109', '31.0'),
(29, '41', '110', '23.5'),
(30, '41', '111', '40.5'),
(31, '41', '112', '22.5'),
(32, '41', '113', '17.0'),
(33, '41', '114', '19.0'),
(34, '41', '115', '22.0'),
(35, '41', '116', '34.5'),
(36, '41', '117', '29.0'),
(37, '41', '118', '24.5'),
(38, '41', '119', '37.5'),
(39, '41', '120', '37.0'),
(40, '41', '121', '27.0'),
(41, '41', '122', '30.0'),
(42, '42', '123', '19.0'),
(43, '42', '124', '35.5'),
(44, '42', '125', '39.5'),
(45, '42', '126', '33.5'),
(46, '42', '127', '41.0'),
(47, '42', '128', '32.0'),
(48, '42', '129', '11.0'),
(49, '42', '130', '35.0'),
(50, '42', '131', '36.0'),
(51, '42', '132', '24.0'),
(52, '42', '133', '20.5'),
(53, '42', '134', '20.0'),
(54, '42', '135', '17.0'),
(55, '43', '136', '33.0'),
(56, '43', '137', '35.5'),
(57, '43', '138', '35.5'),
(58, '43', '139', '16.5'),
(59, '43', '140', '15.5'),
(60, '43', '141', '25.0'),
(61, '43', '142', '35.5'),
(62, '43', '143', '26.5'),
(63, '43', '144', '25.5'),
(64, '43', '145', '25.0'),
(65, '43', '146', '23.5'),
(66, '43', '147', '26.0'),
(67, '43', '148', '41.0'),
(68, '44', '149', '31.0'),
(69, '44', '150', '40.5'),
(70, '44', '151', '28.5'),
(71, '44', '152', '15.5'),
(72, '44', '153', '17.5'),
(73, '44', '158', '34.0'),
(74, '44', '157', '10.0'),
(75, '44', '156', '39.5'),
(76, '44', '155', '30.0'),
(77, '44', '154', '34.0'),
(78, '44', '159', '28.5'),
(79, '44', '160', '33.0'),
(80, '44', '161', '32.0'),
(81, '47', '162', '10.0'),
(82, '47', '163', '15.0'),
(83, '47', '164', '13.5'),
(84, '47', '165', '9.5'),
(85, '47', '166', '12.0');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(30) NOT NULL,
  `faculty_id` int(30) NOT NULL,
  `title` varchar(200) NOT NULL,
  `schedule_type` tinyint(1) NOT NULL COMMENT '1= class, 2= meeting,3=others',
  `description` text NOT NULL,
  `location` text NOT NULL,
  `is_repeating` tinyint(1) NOT NULL,
  `repeating_data` text NOT NULL,
  `schedule_date` date NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `faculty_id`, `title`, `schedule_type`, `description`, `location`, `is_repeating`, `repeating_data`, `schedule_date`, `time_from`, `time_to`, `date_created`) VALUES
(1, 2, 'Class 101 (M & Th)', 1, 'Sample Only', 'Online', 1, '{\"dow\":\"1,4\",\"start\":\"2020-10-01\",\"end\":\"2020-11-30\"}', '0000-00-00', '09:00:00', '12:00:00', '2023-04-19 08:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `sub_event`
--

CREATE TABLE `sub_event` (
  `subevent_id` int(11) NOT NULL,
  `mainevent_id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `event_name` text NOT NULL,
  `status` text NOT NULL,
  `eventdate` text NOT NULL,
  `eventtime` text NOT NULL,
  `place` text NOT NULL,
  `txtpoll_status` text NOT NULL,
  `view` varchar(15) NOT NULL,
  `txtpollview` varchar(15) NOT NULL,
  `banner` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_event`
--

INSERT INTO `sub_event` (`subevent_id`, `mainevent_id`, `organizer_id`, `event_name`, `status`, `eventdate`, `eventtime`, `place`, `txtpoll_status`, `view`, `txtpollview`, `banner`) VALUES
(40, 41, 19, 'BEST IN PRODUCTION NUMBER(MS IT DAY)', 'activated', '', '22:00', 'MCC', 'active', 'active', 'activated', 'IMG_1096 (2).png'),
(41, 41, 19, 'BEST IN SWIMWEAR (MS IT DAY)', 'activated', '', '22:00', 'MCC', 'active', 'active', 'deactivated', 'img20220825_08464925 (2).jpg'),
(42, 41, 19, 'BEST IN VOGUE (MS IT DAY)', 'activated', '', '22:00', 'MCC', '', 'deactivated', 'deactivated', 'img20220825_08464925.jpg'),
(43, 41, 19, 'BEST IN EVENING GOWN (MS IT DAY)', 'activated', '', '22:00', 'MCC', 'active', 'active', 'deactivated', 'img20220825_08482222.jpg'),
(46, 42, 19, 'ORIGINALITY(SINGING CONTEST)', 'activated', '', '', '', '', 'deactivated', 'deactivated', '1680009246633.jpg'),
(47, 41, 19, ' (MS IT 2023)', 'activated', '', '', '', 'active', 'deactivated', 'deactivated', '1679835719620.jpg'),
(48, 43, 19, 'MS IT 2023', 'activated', '', '', '', 'active', 'active', 'deactivated', 'logo.jpg'),
(49, 44, 29, 'Dancing', 'activated', '', '20:00', 'MCC', '', '', 'deactivated', '1680008991102.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sub_results`
--

CREATE TABLE `sub_results` (
  `subresult_id` int(11) NOT NULL,
  `subevent_id` int(11) NOT NULL,
  `mainevent_id` int(11) NOT NULL,
  `contestant_id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `total_score` decimal(11,1) NOT NULL,
  `deduction` int(11) NOT NULL,
  `criteria_ctr1` decimal(11,1) NOT NULL,
  `criteria_ctr2` decimal(11,1) NOT NULL,
  `criteria_ctr3` decimal(11,1) NOT NULL,
  `criteria_ctr4` decimal(11,1) NOT NULL,
  `criteria_ctr5` decimal(11,1) NOT NULL,
  `criteria_ctr6` decimal(11,1) NOT NULL,
  `criteria_ctr7` decimal(11,1) NOT NULL,
  `criteria_ctr8` decimal(11,1) NOT NULL,
  `criteria_ctr9` decimal(11,1) NOT NULL,
  `criteria_ctr10` decimal(11,1) NOT NULL,
  `comments` text NOT NULL,
  `rank` varchar(11) NOT NULL,
  `judge_rank_stat` varchar(15) NOT NULL,
  `place_title` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_results`
--

INSERT INTO `sub_results` (`subresult_id`, `subevent_id`, `mainevent_id`, `contestant_id`, `judge_id`, `total_score`, `deduction`, `criteria_ctr1`, `criteria_ctr2`, `criteria_ctr3`, `criteria_ctr4`, `criteria_ctr5`, `criteria_ctr6`, `criteria_ctr7`, `criteria_ctr8`, `criteria_ctr9`, `criteria_ctr10`, `comments`, `rank`, `judge_rank_stat`, `place_title`) VALUES
(61, 40, 41, 97, 52, '32.0', 0, '8.0', '7.0', '9.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', '1st'),
(62, 40, 41, 98, 52, '31.0', 0, '7.0', '8.0', '9.0', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', '4th'),
(63, 40, 41, 99, 52, '34.0', 0, '9.0', '8.0', '8.0', '9.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '4th'),
(64, 40, 41, 100, 52, '35.0', 0, '8.0', '9.0', '10.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '2nd'),
(65, 40, 41, 101, 52, '33.0', 0, '7.0', '9.0', '9.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', 'tie', '4th'),
(66, 40, 41, 102, 52, '33.0', 0, '9.0', '7.0', '9.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', 'tie', '4th'),
(67, 40, 41, 103, 52, '33.0', 0, '7.5', '8.0', '9.0', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', 'tie', '3rd'),
(68, 40, 41, 104, 52, '33.5', 0, '8.5', '7.5', '9.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', ''),
(69, 40, 41, 105, 52, '21.5', 0, '4.5', '4.5', '6.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', ''),
(70, 40, 41, 106, 52, '32.0', 0, '7.5', '9.0', '8.5', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', ''),
(71, 40, 41, 107, 52, '33.0', 0, '7.5', '8.0', '8.5', '9.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', 'tie', ''),
(72, 40, 41, 108, 52, '33.0', 0, '8.5', '9.0', '8.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', 'tie', ''),
(73, 40, 41, 109, 52, '32.5', 0, '7.5', '8.0', '8.5', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', '', ''),
(74, 40, 41, 97, 53, '33.5', 0, '6.0', '9.5', '8.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', '1st'),
(75, 40, 41, 98, 53, '22.5', 0, '3.5', '7.5', '5.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '4th'),
(76, 40, 41, 99, 53, '29.0', 0, '7.5', '7.0', '7.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', '', '4th'),
(77, 40, 41, 100, 53, '33.5', 0, '8.5', '7.5', '8.0', '9.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', '2nd'),
(78, 40, 41, 101, 53, '23.5', 0, '6.5', '6.0', '5.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', '4th'),
(79, 40, 41, 102, 53, '34.0', 0, '9.0', '8.0', '8.0', '9.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '4th'),
(80, 40, 41, 103, 53, '32.5', 0, '8.5', '7.5', '8.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4.5', 'tie', '3rd'),
(81, 40, 41, 104, 53, '31.0', 0, '7.0', '7.5', '8.0', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7.5', 'tie', ''),
(82, 40, 41, 105, 53, '24.5', 0, '2.5', '5.5', '7.5', '9.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', ''),
(83, 40, 41, 106, 53, '32.0', 0, '6.5', '8.0', '8.0', '9.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', '', ''),
(84, 40, 41, 107, 53, '32.5', 0, '9.0', '8.0', '7.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4.5', 'tie', ''),
(85, 40, 41, 108, 53, '31.0', 0, '8.0', '7.0', '7.5', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7.5', 'tie', ''),
(86, 40, 41, 109, 53, '28.0', 0, '6.0', '6.5', '7.0', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', '', ''),
(87, 40, 41, 97, 54, '35.0', 0, '8.5', '8.5', '8.5', '9.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '1st'),
(88, 40, 41, 98, 54, '30.0', 0, '8.5', '7.5', '7.0', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', '4th'),
(89, 40, 41, 99, 54, '30.5', 0, '8.0', '7.0', '8.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', 'tie', '4th'),
(90, 40, 41, 100, 54, '30.0', 0, '7.5', '6.5', '7.5', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '2nd'),
(91, 40, 41, 101, 54, '30.5', 0, '8.0', '8.0', '7.5', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', 'tie', '4th'),
(92, 40, 41, 102, 54, '34.0', 0, '8.5', '8.0', '8.5', '9.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '4th'),
(93, 40, 41, 103, 54, '33.5', 0, '8.5', '9.5', '8.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '3rd'),
(94, 40, 41, 104, 54, '31.0', 0, '8.0', '7.0', '7.0', '9.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7.5', 'tie', ''),
(95, 40, 41, 105, 54, '31.5', 0, '8.0', '8.0', '7.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', '', ''),
(96, 40, 41, 106, 54, '30.5', 0, '8.0', '7.0', '8.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', 'tie', ''),
(97, 40, 41, 107, 54, '31.0', 0, '7.0', '9.0', '7.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7.5', 'tie', ''),
(98, 40, 41, 108, 54, '32.5', 0, '8.0', '8.0', '9.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', ''),
(99, 40, 41, 109, 54, '34.5', 0, '9.0', '8.0', '9.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', ''),
(100, 40, 41, 97, 55, '30.5', 0, '6.5', '7.0', '9.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '1st'),
(101, 40, 41, 98, 55, '33.5', 0, '8.5', '8.0', '7.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '4th'),
(102, 40, 41, 99, 55, '38.5', 0, '7.5', '8.0', '7.5', '15.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '4th'),
(103, 40, 41, 100, 55, '32.0', 0, '9.0', '7.5', '7.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '2nd'),
(104, 40, 41, 101, 55, '28.0', 0, '7.5', '5.0', '7.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8', '', '4th'),
(105, 40, 41, 102, 55, '26.0', 0, '5.5', '6.5', '6.5', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '4th'),
(106, 40, 41, 103, 55, '29.5', 0, '6.0', '7.5', '7.5', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', '', '3rd'),
(107, 40, 41, 104, 55, '26.5', 0, '8.0', '5.5', '6.0', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', ''),
(108, 40, 41, 105, 55, '28.5', 0, '8.0', '6.0', '6.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7', '', ''),
(109, 40, 41, 106, 55, '30.0', 0, '7.5', '7.0', '7.0', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', ''),
(110, 40, 41, 107, 55, '27.5', 0, '7.0', '7.0', '6.5', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', 'tie', ''),
(111, 40, 41, 108, 55, '27.5', 0, '6.5', '8.0', '6.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', 'tie', ''),
(112, 40, 41, 109, 55, '27.5', 0, '7.0', '6.0', '6.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', 'tie', ''),
(113, 41, 41, 110, 57, '25.5', 0, '4.5', '7.0', '7.0', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', '4th'),
(114, 41, 41, 111, 57, '20.0', 0, '4.0', '4.5', '5.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '4th'),
(115, 41, 41, 112, 57, '23.5', 0, '4.5', '5.5', '6.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8.5', 'tie', '4th'),
(116, 41, 41, 113, 57, '24.0', 0, '3.0', '7.0', '7.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7', '', '1st'),
(117, 41, 41, 114, 57, '28.0', 0, '6.0', '6.0', '8.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', '2nd'),
(118, 41, 41, 115, 57, '31.0', 0, '7.0', '8.5', '7.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '3rd'),
(119, 41, 41, 116, 57, '22.0', 0, '5.0', '5.5', '6.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', ''),
(120, 41, 41, 117, 57, '22.0', 0, '3.5', '5.5', '6.0', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', ''),
(121, 41, 41, 118, 57, '27.5', 0, '4.0', '8.5', '8.0', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', ''),
(122, 41, 41, 119, 57, '21.5', 0, '2.0', '5.0', '8.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', ''),
(123, 41, 41, 120, 57, '23.5', 0, '4.5', '6.0', '5.5', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8.5', 'tie', ''),
(124, 41, 41, 121, 57, '25.0', 0, '3.5', '7.5', '5.5', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', '', ''),
(125, 41, 41, 122, 57, '28.0', 0, '6.5', '6.0', '8.5', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', ''),
(126, 41, 41, 110, 58, '27.5', 0, '8.0', '7.0', '6.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4.5', 'tie', '4th'),
(127, 41, 41, 111, 58, '21.5', 0, '3.5', '4.0', '6.5', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', '4th'),
(128, 41, 41, 112, 58, '25.5', 0, '4.0', '6.5', '7.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', '', '4th'),
(129, 41, 41, 113, 58, '29.5', 0, '5.0', '8.5', '7.5', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '1st'),
(130, 41, 41, 114, 58, '29.0', 0, '5.5', '7.5', '7.0', '9.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', '2nd'),
(131, 41, 41, 115, 58, '20.0', 0, '4.5', '7.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '3rd'),
(132, 41, 41, 116, 58, '25.0', 0, '4.5', '7.5', '6.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', '', ''),
(133, 41, 41, 117, 58, '23.0', 0, '3.5', '7.5', '6.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', ''),
(134, 41, 41, 118, 58, '26.5', 0, '6.0', '6.0', '7.5', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8', '', ''),
(135, 41, 41, 119, 58, '27.0', 0, '4.5', '7.5', '7.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6.5', 'tie', ''),
(136, 41, 41, 120, 58, '27.0', 0, '5.0', '7.0', '7.5', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6.5', 'tie', ''),
(137, 41, 41, 121, 58, '29.0', 0, '5.0', '8.5', '7.0', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', ''),
(138, 41, 41, 122, 58, '27.5', 0, '3.5', '7.5', '8.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4.5', 'tie', ''),
(139, 41, 41, 110, 59, '29.5', 0, '6.0', '7.5', '9.0', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '4th'),
(140, 41, 41, 111, 59, '27.5', 0, '8.0', '7.0', '6.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', '', '4th'),
(141, 41, 41, 112, 59, '30.0', 0, '5.5', '7.5', '8.5', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '4th'),
(142, 41, 41, 113, 59, '29.0', 0, '5.5', '9.0', '8.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '1st'),
(143, 41, 41, 114, 59, '25.5', 0, '6.0', '6.0', '5.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8', '', '2nd'),
(144, 41, 41, 115, 59, '27.0', 0, '7.0', '7.0', '6.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7', '', '3rd'),
(145, 41, 41, 116, 59, '22.5', 0, '4.0', '6.0', '6.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', ''),
(146, 41, 41, 117, 59, '28.0', 0, '6.5', '7.0', '7.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4.5', 'tie', ''),
(147, 41, 41, 118, 59, '28.0', 0, '5.5', '8.5', '8.0', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4.5', 'tie', ''),
(148, 41, 41, 119, 59, '20.5', 0, '4.0', '5.5', '5.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', ''),
(149, 41, 41, 120, 59, '23.0', 0, '4.5', '6.0', '6.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', ''),
(150, 41, 41, 121, 59, '25.0', 0, '6.0', '5.5', '7.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', '', ''),
(151, 41, 41, 122, 59, '24.5', 0, '6.0', '5.0', '6.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', '', ''),
(152, 41, 41, 110, 60, '20.5', 0, '6.0', '1.5', '5.5', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', '4th'),
(153, 41, 41, 111, 60, '23.5', 0, '5.5', '4.5', '6.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9.5', 'tie', '4th'),
(154, 41, 41, 112, 60, '25.5', 0, '5.0', '7.0', '6.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '4th'),
(155, 41, 41, 113, 60, '24.5', 0, '7.0', '6.5', '5.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', 'tie', '1st'),
(156, 41, 41, 114, 60, '24.5', 0, '5.0', '6.5', '6.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', 'tie', '2nd'),
(157, 41, 41, 115, 60, '27.5', 0, '5.5', '7.0', '7.5', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '3rd'),
(158, 41, 41, 116, 60, '26.5', 0, '5.5', '9.0', '6.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', ''),
(159, 41, 41, 117, 60, '26.0', 0, '7.5', '8.0', '4.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', ''),
(160, 41, 41, 118, 60, '24.0', 0, '5.5', '7.0', '5.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8', '', ''),
(161, 41, 41, 119, 60, '24.5', 0, '5.5', '6.5', '6.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', 'tie', ''),
(162, 41, 41, 120, 60, '21.5', 0, '6.0', '4.5', '6.0', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', ''),
(163, 41, 41, 121, 60, '23.5', 0, '6.0', '5.5', '6.0', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9.5', 'tie', ''),
(164, 41, 41, 122, 60, '18.0', 0, '4.0', '4.0', '5.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', ''),
(165, 42, 41, 123, 62, '31.5', 0, '7.5', '7.5', '9.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '3rd'),
(166, 42, 41, 124, 62, '16.5', 0, '4.0', '5.0', '2.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '4th'),
(167, 42, 41, 125, 62, '17.0', 0, '4.5', '4.0', '4.5', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', '4th'),
(168, 42, 41, 126, 62, '19.5', 0, '2.5', '4.5', '4.5', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', '4th'),
(169, 42, 41, 127, 62, '24.0', 0, '4.5', '6.0', '7.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7.5', 'tie', ''),
(170, 42, 41, 128, 62, '24.0', 0, '5.5', '5.5', '6.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7.5', 'tie', '4th'),
(171, 42, 41, 129, 62, '31.0', 0, '7.0', '7.0', '9.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '1st'),
(172, 42, 41, 130, 62, '21.0', 0, '4.0', '4.5', '6.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', '', ''),
(173, 42, 41, 131, 62, '23.0', 0, '9.0', '6.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', '', ''),
(174, 42, 41, 132, 62, '26.0', 0, '6.0', '5.5', '8.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', '4th'),
(175, 42, 41, 133, 62, '24.5', 0, '6.0', '5.5', '6.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', '', '4th'),
(176, 42, 41, 134, 62, '30.5', 0, '7.5', '7.5', '7.0', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '4th'),
(177, 42, 41, 135, 62, '27.5', 0, '6.5', '8.5', '5.5', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '2nd'),
(178, 42, 41, 123, 63, '21.0', 0, '3.5', '6.5', '4.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '3rd'),
(179, 42, 41, 124, 63, '20.0', 0, '3.5', '4.0', '5.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7', '', '4th'),
(180, 42, 41, 125, 63, '17.5', 0, '4.0', '3.0', '5.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', '4th'),
(181, 42, 41, 126, 63, '22.0', 0, '4.0', '8.0', '5.0', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '4th'),
(182, 42, 41, 127, 63, '16.5', 0, '2.5', '3.5', '6.5', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', ''),
(183, 42, 41, 128, 63, '16.0', 0, '5.5', '4.5', '5.5', '0.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '4th'),
(184, 42, 41, 129, 63, '23.5', 0, '5.5', '5.0', '6.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '1st'),
(185, 42, 41, 130, 63, '18.5', 0, '3.5', '4.0', '4.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', '', ''),
(186, 42, 41, 131, 63, '17.5', 0, '4.0', '4.5', '4.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', ''),
(187, 42, 41, 132, 63, '20.5', 0, '5.0', '5.0', '5.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5.5', 'tie', '4th'),
(188, 42, 41, 133, 63, '19.5', 0, '5.0', '4.0', '5.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8', '', '4th'),
(189, 42, 41, 134, 63, '20.5', 0, '3.5', '6.0', '5.0', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5.5', 'tie', '4th'),
(190, 42, 41, 135, 63, '24.5', 0, '6.5', '8.0', '4.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '2nd'),
(191, 42, 41, 123, 64, '14.0', 0, '2.0', '3.5', '4.0', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '3rd'),
(192, 42, 41, 124, 64, '15.0', 0, '3.0', '3.0', '4.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', '4th'),
(193, 42, 41, 125, 64, '17.5', 0, '2.5', '4.0', '4.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', '', '4th'),
(194, 42, 41, 126, 64, '18.5', 0, '4.0', '5.0', '5.0', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', '', '4th'),
(195, 42, 41, 127, 64, '16.5', 0, '4.0', '4.0', '3.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', ''),
(196, 42, 41, 128, 64, '21.0', 0, '4.5', '4.0', '6.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8', '', '4th'),
(197, 42, 41, 129, 64, '23.0', 0, '5.5', '4.0', '6.0', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', '1st'),
(198, 42, 41, 130, 64, '22.0', 0, '5.0', '4.5', '6.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7', '', ''),
(199, 42, 41, 131, 64, '23.5', 0, '5.5', '5.5', '6.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3.5', 'tie', ''),
(200, 42, 41, 132, 64, '25.5', 0, '6.5', '6.5', '6.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1.5', 'tie', '4th'),
(201, 42, 41, 133, 64, '25.5', 0, '6.0', '7.5', '5.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1.5', 'tie', '4th'),
(202, 42, 41, 134, 64, '23.5', 0, '5.5', '4.5', '6.5', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3.5', 'tie', '4th'),
(203, 42, 41, 135, 64, '22.5', 0, '5.0', '6.5', '4.0', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', '', '2nd'),
(204, 42, 41, 123, 65, '31.0', 0, '6.5', '8.5', '8.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '3rd'),
(205, 42, 41, 124, 65, '24.5', 0, '5.5', '6.0', '7.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3.5', 'tie', '4th'),
(206, 42, 41, 125, 65, '22.0', 0, '6.0', '5.0', '6.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7', '', '4th'),
(207, 42, 41, 126, 65, '20.0', 0, '5.0', '5.5', '4.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', '4th'),
(208, 42, 41, 127, 65, '20.0', 0, '5.5', '5.0', '4.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', ''),
(209, 42, 41, 128, 65, '24.5', 0, '4.5', '5.0', '7.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3.5', 'tie', '4th'),
(210, 42, 41, 129, 65, '27.0', 0, '5.5', '6.5', '6.5', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '1st'),
(211, 42, 41, 130, 65, '20.5', 0, '7.5', '3.0', '4.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', '', ''),
(212, 42, 41, 131, 65, '14.5', 0, '3.0', '4.5', '4.0', '3.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', ''),
(213, 42, 41, 132, 65, '15.5', 0, '3.0', '3.5', '4.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', '4th'),
(214, 42, 41, 133, 65, '23.0', 0, '3.5', '5.5', '6.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', '4th'),
(215, 42, 41, 134, 65, '21.5', 0, '5.0', '5.0', '5.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8', '', '4th'),
(216, 42, 41, 135, 65, '22.5', 0, '5.5', '6.0', '5.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', '', '2nd'),
(217, 43, 41, 136, 67, '21.0', 0, '4.0', '6.0', '5.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', 'tie', '4th'),
(218, 43, 41, 137, 67, '26.5', 0, '5.5', '7.0', '6.5', '7.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '4th'),
(219, 43, 41, 138, 67, '17.5', 0, '3.5', '4.5', '4.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', '4th'),
(220, 43, 41, 139, 67, '24.0', 0, '4.5', '7.5', '6.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '2nd'),
(221, 43, 41, 140, 67, '27.0', 0, '6.0', '5.0', '7.5', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '1st'),
(222, 43, 41, 141, 67, '34.5', 0, '13.5', '8.0', '6.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '4th'),
(223, 43, 41, 142, 67, '21.0', 0, '4.0', '6.5', '4.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', 'tie', ''),
(224, 43, 41, 143, 67, '21.0', 0, '5.0', '4.0', '6.0', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', 'tie', '4th'),
(225, 43, 41, 144, 67, '20.5', 0, '4.0', '5.5', '5.0', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', '4th'),
(226, 43, 41, 145, 67, '23.5', 0, '5.5', '4.5', '6.5', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', '4th'),
(227, 43, 41, 146, 67, '22.5', 0, '6.0', '6.0', '5.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7', '', '3rd'),
(228, 43, 41, 147, 67, '23.0', 0, '6.5', '4.5', '5.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', '', ''),
(229, 43, 41, 148, 67, '15.0', 0, '3.0', '3.5', '4.0', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', ''),
(230, 43, 41, 136, 68, '14.0', 0, '3.0', '3.0', '4.0', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '4th'),
(231, 43, 41, 137, 68, '19.5', 0, '4.0', '4.5', '5.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', 'tie', '4th'),
(232, 43, 41, 138, 68, '19.5', 0, '4.5', '6.0', '4.0', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', 'tie', '4th'),
(233, 43, 41, 139, 68, '22.5', 0, '5.5', '6.5', '5.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '2nd'),
(234, 43, 41, 140, 68, '21.0', 0, '5.5', '6.5', '4.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', '1st'),
(235, 43, 41, 141, 68, '19.5', 0, '6.5', '4.0', '4.0', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', 'tie', '4th'),
(236, 43, 41, 142, 68, '20.5', 0, '7.5', '4.5', '4.0', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', '', ''),
(237, 43, 41, 143, 68, '26.0', 0, '5.5', '5.5', '6.0', '9.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '4th'),
(238, 43, 41, 144, 68, '24.5', 0, '6.0', '6.0', '5.5', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', '4th'),
(239, 43, 41, 145, 68, '19.0', 0, '4.0', '5.5', '4.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', '4th'),
(240, 43, 41, 146, 68, '20.0', 0, '4.5', '4.0', '5.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7', '', '3rd'),
(241, 43, 41, 147, 68, '24.5', 0, '5.5', '5.0', '7.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', ''),
(242, 43, 41, 148, 68, '18.0', 0, '4.0', '5.0', '5.0', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', ''),
(243, 43, 41, 136, 69, '19.0', 0, '3.5', '5.0', '4.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', '', '4th'),
(244, 43, 41, 137, 69, '18.0', 0, '3.0', '4.5', '4.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', '4th'),
(245, 43, 41, 138, 69, '21.5', 0, '6.5', '4.5', '6.0', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4.5', 'tie', '4th'),
(246, 43, 41, 139, 69, '25.5', 0, '7.0', '5.5', '5.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '2nd'),
(247, 43, 41, 140, 69, '19.5', 0, '4.5', '4.0', '5.0', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7.5', 'tie', '1st'),
(248, 43, 41, 141, 69, '18.0', 0, '5.5', '4.0', '5.0', '3.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', '4th'),
(249, 43, 41, 142, 69, '17.5', 0, '3.5', '4.5', '4.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', ''),
(250, 43, 41, 143, 69, '21.5', 0, '5.5', '3.5', '7.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4.5', 'tie', '4th'),
(251, 43, 41, 144, 69, '30.5', 0, '6.5', '8.0', '8.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '4th'),
(252, 43, 41, 145, 69, '20.5', 0, '4.5', '4.5', '5.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', '', '4th'),
(253, 43, 41, 146, 69, '23.0', 0, '5.0', '5.5', '7.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '3rd'),
(254, 43, 41, 147, 69, '17.0', 0, '5.0', '4.0', '4.0', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', ''),
(255, 43, 41, 148, 69, '19.5', 0, '5.5', '4.5', '5.5', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7.5', 'tie', ''),
(256, 43, 41, 136, 70, '20.5', 0, '4.5', '5.0', '6.0', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '4th'),
(257, 43, 41, 137, 70, '13.5', 0, '3.0', '4.0', '3.0', '3.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '4th'),
(258, 43, 41, 138, 70, '16.5', 0, '4.5', '4.5', '3.5', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', '', '4th'),
(259, 43, 41, 139, 70, '18.0', 0, '4.5', '4.0', '4.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6.5', 'tie', '2nd'),
(260, 43, 41, 140, 70, '22.0', 0, '6.5', '4.5', '5.0', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '1st'),
(261, 43, 41, 141, 70, '19.0', 0, '3.5', '4.5', '5.0', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4.5', 'tie', '4th'),
(262, 43, 41, 142, 70, '17.0', 0, '3.0', '4.5', '4.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8.5', 'tie', ''),
(263, 43, 41, 143, 70, '14.0', 0, '4.0', '3.0', '3.0', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', '4th'),
(264, 43, 41, 144, 70, '16.0', 0, '4.5', '4.0', '3.5', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', '4th'),
(265, 43, 41, 145, 70, '20.0', 0, '6.0', '5.0', '5.5', '3.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '4th'),
(266, 43, 41, 146, 70, '18.0', 0, '4.0', '3.5', '5.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6.5', 'tie', '3rd'),
(267, 43, 41, 147, 70, '19.0', 0, '4.0', '7.0', '3.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4.5', 'tie', ''),
(268, 43, 41, 148, 70, '17.0', 0, '4.0', '4.5', '5.0', '3.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8.5', 'tie', ''),
(269, 44, 41, 149, 72, '29.0', 0, '7.5', '7.5', '7.5', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '4th'),
(270, 44, 41, 150, 72, '19.0', 0, '5.0', '3.5', '5.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '4th'),
(271, 44, 41, 151, 72, '18.0', 0, '4.0', '4.0', '5.0', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5.5', 'tie', '4th'),
(272, 44, 41, 152, 72, '18.0', 0, '4.0', '4.0', '5.0', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5.5', 'tie', '2nd'),
(273, 44, 41, 153, 72, '20.5', 0, '3.5', '4.5', '6.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '3rd'),
(274, 44, 41, 158, 72, '16.5', 0, '5.5', '4.5', '3.0', '3.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', 'tie', ''),
(275, 44, 41, 158, 72, '16.5', 0, '5.5', '4.5', '3.0', '3.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', 'tie', ''),
(276, 44, 41, 157, 72, '19.5', 0, '4.5', '4.5', '3.5', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '1st'),
(277, 44, 41, 156, 72, '11.0', 0, '2.5', '2.5', '3.0', '3.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', ''),
(278, 44, 41, 155, 72, '17.5', 0, '2.5', '5.0', '5.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7', '', ''),
(279, 44, 41, 154, 72, '16.0', 0, '3.0', '4.5', '5.0', '3.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', '', ''),
(280, 44, 41, 159, 72, '14.0', 0, '3.0', '3.5', '4.0', '3.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', '4th'),
(281, 44, 41, 160, 72, '13.5', 0, '4.0', '2.5', '3.0', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', ''),
(282, 44, 41, 161, 72, '16.5', 0, '3.5', '4.5', '3.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', 'tie', ''),
(283, 44, 41, 149, 73, '15.5', 0, '3.5', '3.5', '5.5', '3.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10', '', '4th'),
(284, 44, 41, 150, 73, '12.0', 0, '2.0', '4.0', '3.0', '3.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '4th'),
(285, 44, 41, 151, 73, '17.5', 0, '3.5', '3.5', '6.0', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9', '', '4th'),
(286, 44, 41, 152, 73, '20.0', 0, '4.0', '5.0', '3.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '2nd'),
(287, 44, 41, 153, 73, '21.5', 0, '7.0', '5.0', '4.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '3rd'),
(288, 44, 41, 158, 73, '18.5', 0, '4.5', '4.0', '5.0', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7.5', 'tie', ''),
(289, 44, 41, 157, 73, '28.5', 0, '12.0', '6.5', '4.0', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '1st'),
(290, 44, 41, 156, 73, '18.5', 0, '5.0', '4.0', '4.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '7.5', 'tie', ''),
(291, 44, 41, 155, 73, '19.5', 0, '4.5', '4.0', '5.0', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5.5', 'tie', ''),
(292, 44, 41, 154, 73, '14.0', 0, '3.5', '1.5', '3.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', ''),
(293, 44, 41, 160, 73, '20.5', 0, '5.0', '3.5', '6.0', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', ''),
(294, 44, 41, 161, 73, '19.5', 0, '3.5', '4.5', '5.0', '6.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5.5', 'tie', ''),
(295, 44, 41, 159, 73, '15.0', 0, '4.0', '2.5', '4.0', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', '4th'),
(296, 44, 41, 149, 74, '16.0', 0, '6.5', '4.5', '3.0', '2.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8', 'tie', '4th'),
(297, 44, 41, 161, 74, '16.0', 0, '4.0', '3.0', '4.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8', 'tie', ''),
(298, 44, 41, 160, 74, '15.0', 0, '4.0', '3.0', '4.0', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', ''),
(299, 44, 41, 159, 74, '17.0', 0, '4.5', '4.0', '4.5', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5.5', 'tie', '4th'),
(300, 44, 41, 158, 74, '23.5', 0, '6.0', '4.5', '5.0', '8.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', ''),
(301, 44, 41, 157, 74, '17.5', 0, '5.0', '4.0', '3.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '1st'),
(302, 44, 41, 156, 74, '12.0', 0, '3.5', '3.5', '3.5', '1.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', ''),
(303, 44, 41, 155, 74, '16.0', 0, '4.0', '3.5', '4.5', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8', 'tie', ''),
(304, 44, 41, 154, 74, '27.5', 0, '5.0', '4.0', '13.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', ''),
(305, 44, 41, 153, 74, '17.0', 0, '4.0', '4.0', '4.0', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5.5', 'tie', '3rd'),
(306, 44, 41, 152, 74, '23.5', 0, '6.5', '7.0', '4.5', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', '2nd'),
(307, 44, 41, 151, 74, '15.5', 0, '3.0', '3.0', '5.5', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', '4th'),
(308, 44, 41, 150, 74, '15.5', 0, '3.5', '4.0', '3.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '10.5', 'tie', '4th'),
(309, 44, 41, 149, 75, '14.5', 0, '3.5', '3.0', '4.0', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '12', '', '4th'),
(310, 44, 41, 150, 75, '13.0', 0, '3.5', '3.5', '3.5', '2.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '13', '', '4th'),
(311, 44, 41, 151, 75, '18.0', 0, '4.5', '4.0', '5.5', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3.5', 'tie', '4th'),
(312, 44, 41, 152, 75, '18.0', 0, '4.0', '4.5', '4.0', '5.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3.5', 'tie', '2nd'),
(313, 44, 41, 153, 75, '16.5', 0, '4.0', '3.5', '4.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '8', '', '3rd'),
(314, 44, 41, 154, 75, '15.0', 0, '4.5', '3.0', '3.5', '4.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '11', '', ''),
(315, 44, 41, 155, 75, '16.0', 0, '3.5', '3.5', '4.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9.5', 'tie', ''),
(316, 44, 41, 156, 75, '17.5', 0, '4.0', '4.0', '4.5', '5.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', 'tie', ''),
(317, 44, 41, 157, 75, '22.5', 0, '5.0', '5.0', '6.5', '6.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '1st'),
(318, 44, 41, 158, 75, '17.5', 0, '4.0', '4.5', '4.5', '4.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', 'tie', ''),
(319, 44, 41, 159, 75, '24.5', 0, '5.0', '5.5', '7.0', '7.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '4th'),
(320, 44, 41, 160, 75, '17.5', 0, '5.5', '4.5', '4.0', '3.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '6', 'tie', ''),
(321, 44, 41, 161, 75, '16.0', 0, '3.0', '4.0', '5.5', '3.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '9.5', 'tie', ''),
(322, 47, 41, 162, 77, '94.5', 0, '35.5', '19.0', '30.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '2nd'),
(323, 47, 41, 163, 77, '95.0', 0, '37.0', '19.0', '29.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '4th'),
(324, 47, 41, 164, 77, '72.5', 0, '17.0', '19.5', '26.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', '4th'),
(325, 47, 41, 165, 77, '100.0', 0, '40.0', '20.0', '30.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '1st'),
(326, 47, 41, 166, 77, '90.5', 0, '36.5', '19.5', '25.0', '9.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '3rd'),
(327, 47, 41, 162, 78, '97.5', 0, '38.5', '19.5', '29.5', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '2nd'),
(328, 47, 41, 163, 78, '86.0', 0, '29.0', '19.5', '28.0', '9.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', '4th'),
(329, 47, 41, 164, 78, '94.0', 0, '35.5', '19.0', '30.0', '9.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '4th'),
(330, 47, 41, 165, 78, '100.0', 0, '40.0', '20.0', '30.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '1st'),
(331, 47, 41, 166, 78, '96.0', 0, '37.0', '19.5', '29.5', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '3rd'),
(332, 47, 41, 162, 80, '100.0', 0, '40.0', '20.0', '30.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '2nd'),
(333, 47, 41, 163, 80, '96.0', 0, '40.0', '19.0', '27.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '3', '', '4th'),
(334, 47, 41, 164, 80, '97.0', 0, '39.5', '18.0', '30.0', '9.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2', '', '4th'),
(335, 47, 41, 165, 80, '57.0', 0, '28.0', '19.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', '1st'),
(336, 47, 41, 166, 80, '91.0', 0, '37.0', '19.5', '24.5', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '3rd'),
(337, 47, 41, 162, 79, '93.0', 0, '39.5', '19.5', '24.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '4', '', '2nd'),
(338, 47, 41, 163, 79, '90.0', 0, '34.5', '19.0', '26.5', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '5', '', '4th'),
(339, 47, 41, 164, 79, '96.0', 0, '39.5', '17.5', '29.0', '10.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', '4th'),
(340, 47, 41, 165, 79, '96.0', 0, '39.0', '19.0', '29.0', '9.0', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '2.5', 'tie', '1st'),
(341, 47, 41, 166, 79, '98.5', 0, '40.0', '19.5', '29.5', '9.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '1', '', '3rd'),
(342, 48, 43, 167, 81, '33.5', 0, '8.5', '8.0', '8.5', '8.5', '0.0', '0.0', '0.0', '0.0', '0.0', '0.0', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `textpoll`
--

CREATE TABLE `textpoll` (
  `textpoll_id` int(11) NOT NULL,
  `contestant_id` varchar(12) NOT NULL,
  `text_vote` int(11) NOT NULL,
  `subevent_id` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `upcoming_events`
--

CREATE TABLE `upcoming_events` (
  `id` int(30) NOT NULL,
  `title` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `upcoming_events`
--

INSERT INTO `upcoming_events` (`id`, `title`, `start_date`, `end_date`) VALUES
(20, 'Intramurals', '2023-04-26 08:00:00', '2023-04-26 17:00:00'),
(21, 'BSBA Days 2023', '2023-04-26 08:00:00', '2023-04-26 17:00:00'),
(26, 'BSIT DAY', '2023-04-28 08:00:00', '2023-04-28 17:00:00'),
(28, 'BSBA Day', '2023-05-08 08:00:00', '2023-05-08 17:00:00'),
(29, 'Trial', '2023-05-09 08:00:00', '2023-05-09 17:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contestants`
--
ALTER TABLE `contestants`
  ADD PRIMARY KEY (`contestant_id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`criteria_id`);

--
-- Indexes for table `judges`
--
ALTER TABLE `judges`
  ADD PRIMARY KEY (`judge_id`);

--
-- Indexes for table `main_event`
--
ALTER TABLE `main_event`
  ADD PRIMARY KEY (`mainevent_id`);

--
-- Indexes for table `messagein`
--
ALTER TABLE `messagein`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `messagelog`
--
ALTER TABLE `messagelog`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IDX_MessageId` (`MessageId`,`SendTime`);

--
-- Indexes for table `messageout`
--
ALTER TABLE `messageout`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IDX_IsRead` (`IsRead`);

--
-- Indexes for table `organizer`
--
ALTER TABLE `organizer`
  ADD PRIMARY KEY (`organizer_id`);

--
-- Indexes for table `rank_system`
--
ALTER TABLE `rank_system`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_event`
--
ALTER TABLE `sub_event`
  ADD PRIMARY KEY (`subevent_id`);

--
-- Indexes for table `sub_results`
--
ALTER TABLE `sub_results`
  ADD PRIMARY KEY (`subresult_id`);

--
-- Indexes for table `textpoll`
--
ALTER TABLE `textpoll`
  ADD PRIMARY KEY (`textpoll_id`);

--
-- Indexes for table `upcoming_events`
--
ALTER TABLE `upcoming_events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contestants`
--
ALTER TABLE `contestants`
  MODIFY `contestant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `criteria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `judge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `main_event`
--
ALTER TABLE `main_event`
  MODIFY `mainevent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `messagein`
--
ALTER TABLE `messagein`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messagelog`
--
ALTER TABLE `messagelog`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT for table `messageout`
--
ALTER TABLE `messageout`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organizer`
--
ALTER TABLE `organizer`
  MODIFY `organizer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `rank_system`
--
ALTER TABLE `rank_system`
  MODIFY `rs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_event`
--
ALTER TABLE `sub_event`
  MODIFY `subevent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `sub_results`
--
ALTER TABLE `sub_results`
  MODIFY `subresult_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `textpoll`
--
ALTER TABLE `textpoll`
  MODIFY `textpoll_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upcoming_events`
--
ALTER TABLE `upcoming_events`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
