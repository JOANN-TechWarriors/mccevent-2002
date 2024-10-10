-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2024 at 03:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `captured_events`
--

CREATE TABLE `captured_events` (
  `id` int(11) NOT NULL,
  `stream_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `captured_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `AddOn` varchar(80) NOT NULL,
  `schoolid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contestants`
--

INSERT INTO `contestants` (`contestant_id`, `fullname`, `subevent_id`, `contestant_ctr`, `status`, `txt_code`, `rand_code`, `txtPollScore`, `Picture`, `AddOn`, `schoolid`) VALUES
(205, 'Dream Squad', 64, 1, 'finish', '', 691591, 0, '../img/Community-College-Madridejos.jpeg', 'Bsit-3 South', 0),
(206, 'BINI', 64, 2, 'finish', '', 947235, 1, '../img/mcc.jpg', 'Bsit-2 North', 0),
(214, 'Cristina', 77, 1, '', '', 858911, 1, '../img/66a4c61166f2f_mcc4.jpg', 'Bsit-3 South', 0),
(215, 'dianna', 77, 2, '', '', 577163, 1, '../img/mcc1.jpg', 'Bsit-2 North', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`judge_id`, `subevent_id`, `judge_ctr`, `fullname`, `code`, `jtype`) VALUES
(104, 64, 1, 'John Christian Fariola', '4c4py6', ''),
(105, 64, 2, 'James Vincent Pastorillo', 'rnisjp', ''),
(106, 64, 3, 'Jo Ann R. Bilbao', '6q4tut', ''),
(113, 77, 1, 'John Fariola', 'tzmuva', ''),
(114, 77, 2, 'James Pastorillo', 'wocupm', '');

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
  `place` text NOT NULL,
  `banner` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `main_event`
--

INSERT INTO `main_event` (`mainevent_id`, `event_name`, `status`, `organizer_id`, `sy`, `date_start`, `date_end`, `place`, `banner`) VALUES
(68, 'BSIT DAYS', 'activated', 31, '624', '2024-07-28', '2024-07-30', 'MCC COVERED COURT', '66a5986c29f86_mcc.jpg'),
(84, 'Binibining Marites', 'activated', 31, '312', '2024-08-01 08:52:00', '2024-08-01 12:58:00', 'MCC COVERED COURT', '66a8941cc6cfc_a social or political statement.jpg');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `reset_token` varchar(250) DEFAULT NULL,
  `reset_expires` varchar(250) DEFAULT NULL,
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
  `company_website` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `organizer`
--

INSERT INTO `organizer` (`organizer_id`, `fname`, `mname`, `lname`, `username`, `password`, `email`, `reset_token`, `reset_expires`, `pnum`, `txt_poll_num`, `access`, `org_id`, `status`, `company_name`, `company_address`, `company_logo`, `company_telephone`, `company_email`, `company_website`) VALUES
(19, 'AYRES', 'SANTILLAN', 'ILUSTRISIMO', 'blue', 'hello', 'joannbilbao5@gmail.com', 'ffd827badf8b56f8942b1b12ad9db9f93606b705ef03cc56d0c85ac2e739e690', '2024-09-30 21:55:41', '09385974999', '09385974999', 'Organizer', '', 'online', 'MCC EVENT JUDGING SYSTEM', 'BANTAYAN ISLAND, BUNAKAN, MADRIDEJOS, CEBU', '52985-ejs_logo.png', '9476865867', 'mcceventjudgingsystem@gmail.com', 'mcceventjudging.com'),
(20, 'JOANN', 'REBAMONTE', 'BILBAO', 'red', 'red', 'thomassalvado15@gmail.com', '13a47eee732480d3c33d459f0c5d46a7c2277c09e09c967c4bd05f22e35f5a56', '2023-05-11 22:56:30', '', '', 'Tabulator', '19', 'offline', '', '', '', '', '', ''),
(31, 'JOANN', 'REBAMONTE', 'BILBAO', 'ann', 'ann123', 'joannrebamonte80@gmail.com', '8239f6665044ef12f6a78539ee9b206b1910ffad14b5d77eef783ae2caaf0894', '2024-09-30 06:45:22', '09476875656', '09382451653', 'Organizer', '', 'offline', 'MCC EVENT JUDGING SYSTEM', 'BANTAYAN ISLAND, BUNAKAN, MADRIDEJOS, CEBU', 'logo.png', '9476865867', 'mcceventjudgingsystem@gmail.com', 'mcceventjudging.com'),
(34, 'Gwendelyn', 'Marabi', 'Escaran', 'gwen', 'gwen', '', NULL, NULL, '', '', 'Tabulator', '31', 'offline', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `rank_system`
--

CREATE TABLE `rank_system` (
  `rs_id` int(11) NOT NULL,
  `subevent_id` varchar(12) NOT NULL,
  `contestant_id` varchar(12) NOT NULL,
  `total_rank` decimal(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `faculty_id`, `title`, `schedule_type`, `description`, `location`, `is_repeating`, `repeating_data`, `schedule_date`, `time_from`, `time_to`, `date_created`) VALUES
(1, 2, 'Class 101 (M & Th)', 1, 'Sample Only', 'Online', 1, '{\"dow\":\"1,4\",\"start\":\"2020-10-01\",\"end\":\"2020-11-30\"}', '0000-00-00', '09:00:00', '12:00:00', '2023-04-19 08:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `streaming_status`
--

CREATE TABLE `streaming_status` (
  `id` int(11) NOT NULL,
  `action` enum('start','stop') NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `streaming_status`
--

INSERT INTO `streaming_status` (`id`, `action`, `timestamp`) VALUES
(1, 'start', '2024-07-30 18:39:00');

-- --------------------------------------------------------

--
-- Table structure for table `streams`
--

CREATE TABLE `streams` (
  `id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('scheduled','live','ended') NOT NULL DEFAULT 'scheduled',
  `stream_key` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `streams`
--

INSERT INTO `streams` (`id`, `organizer_id`, `title`, `description`, `status`, `stream_key`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(24, 19, '', NULL, 'ended', NULL, NULL, NULL, '2024-10-01 10:07:24', '2024-10-01 10:42:53'),
(25, 19, '', NULL, 'ended', NULL, NULL, NULL, '2024-10-01 10:13:25', '2024-10-01 10:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `schoolid` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`schoolid`, `student_id`, `fname`, `mname`, `lname`, `course`) VALUES
(1, '2021-1489', 'JOANN', 'R. ', 'BILBAO', 'BSIT 3 SOUTH'),
(2, '2021-1485', 'John Christian', 'L.', 'Fariola', 'BSIT 3 SOUTH');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sub_event`
--

INSERT INTO `sub_event` (`subevent_id`, `mainevent_id`, `organizer_id`, `event_name`, `status`, `eventdate`, `eventtime`, `place`, `txtpoll_status`, `view`, `txtpollview`, `banner`) VALUES
(64, 68, 31, 'HIPHOP  COMPITATION', 'activated', '2024-07-23', '10:30', 'MCC COVERED COURT', 'deactive', 'deactive', 'deactive', 'mcc3.jpg'),
(77, 68, 31, '123', 'activated', '2024-07-31', '', '123', 'deactive', 'deactive', 'deactive', 'mcc2.jpg');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `textpoll`
--

CREATE TABLE `textpoll` (
  `textpoll_id` int(11) NOT NULL,
  `contestant_id` varchar(12) NOT NULL,
  `text_vote` int(11) NOT NULL,
  `subevent_id` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upcoming_events`
--

CREATE TABLE `upcoming_events` (
  `id` int(30) NOT NULL,
  `title` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `banner` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `organizer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upcoming_events`
--

INSERT INTO `upcoming_events` (`id`, `title`, `start_date`, `end_date`, `banner`, `organizer_id`) VALUES
(68, 'Dance Contest', '2024-08-10 13:30:00', '2024-08-10 13:30:00', 'mcc.jpg', 35);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `subevent_id` int(11) NOT NULL,
  `contestant_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `student_id`, `subevent_id`, `contestant_id`, `timestamp`) VALUES
(4, '2021-1485', 64, 206, '2024-07-29 10:02:40'),
(5, '2021-1485', 79, 225, '2024-07-29 10:05:22'),
(6, '2021-1485', 77, 215, '2024-07-29 10:30:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `captured_events`
--
ALTER TABLE `captured_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stream_id` (`stream_id`);

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
-- Indexes for table `streaming_status`
--
ALTER TABLE `streaming_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `streams`
--
ALTER TABLE `streams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stream_key` (`stream_key`),
  ADD KEY `organizer_id` (`organizer_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`schoolid`);

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
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`student_id`,`subevent_id`,`contestant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `captured_events`
--
ALTER TABLE `captured_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contestants`
--
ALTER TABLE `contestants`
  MODIFY `contestant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `criteria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `judge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `main_event`
--
ALTER TABLE `main_event`
  MODIFY `mainevent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

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
  MODIFY `organizer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `rank_system`
--
ALTER TABLE `rank_system`
  MODIFY `rs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `streaming_status`
--
ALTER TABLE `streaming_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `streams`
--
ALTER TABLE `streams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `schoolid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_event`
--
ALTER TABLE `sub_event`
  MODIFY `subevent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `sub_results`
--
ALTER TABLE `sub_results`
  MODIFY `subresult_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=371;

--
-- AUTO_INCREMENT for table `textpoll`
--
ALTER TABLE `textpoll`
  MODIFY `textpoll_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upcoming_events`
--
ALTER TABLE `upcoming_events`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `captured_events`
--
ALTER TABLE `captured_events`
  ADD CONSTRAINT `captured_events_ibfk_1` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`id`);

--
-- Constraints for table `streams`
--
ALTER TABLE `streams`
  ADD CONSTRAINT `streams_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `organizer` (`organizer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
