-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 06, 2012 at 06:22 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `hslanj_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `site_member_vendors`
--

DROP TABLE IF EXISTS `site_member_vendors`;
CREATE TABLE `site_member_vendors` (
  `member_vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` varchar(10) DEFAULT NULL,
  `member_id` int(10) unsigned DEFAULT NULL,
  `fiscal_year` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`member_vendor_id`),
  KEY `FK_member_vendors_member_id` (`member_id`),
  KEY `FK_member_vendors_vendor_id` (`vendor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=191 ;

--
-- Dumping data for table `site_member_vendors`
--

INSERT INTO `site_member_vendors` VALUES(1, 'ovid', 1, '2012');
INSERT INTO `site_member_vendors` VALUES(2, 'mgh', 1, '2012');
INSERT INTO `site_member_vendors` VALUES(3, 'stat_ref', 1, '2012');
INSERT INTO `site_member_vendors` VALUES(4, 'nejm', 1, '2012');
INSERT INTO `site_member_vendors` VALUES(5, 'bmj', 1, '2012');
INSERT INTO `site_member_vendors` VALUES(6, 'ebsco', 2, '2012');
INSERT INTO `site_member_vendors` VALUES(7, 'ovid', 2, '2012');
INSERT INTO `site_member_vendors` VALUES(8, 'nejm', 2, '2012');
INSERT INTO `site_member_vendors` VALUES(9, 'bmj', 2, '2012');
INSERT INTO `site_member_vendors` VALUES(10, 'ebsco', 3, '2012');
INSERT INTO `site_member_vendors` VALUES(11, 'ovid', 3, '2012');
INSERT INTO `site_member_vendors` VALUES(12, 'bmj', 3, '2012');
INSERT INTO `site_member_vendors` VALUES(13, 'ovid', 4, '2012');
INSERT INTO `site_member_vendors` VALUES(14, 'nejm', 4, '2012');
INSERT INTO `site_member_vendors` VALUES(15, 'ebsco', 5, '2012');
INSERT INTO `site_member_vendors` VALUES(16, 'ovid', 5, '2012');
INSERT INTO `site_member_vendors` VALUES(17, 'stat_ref', 5, '2012');
INSERT INTO `site_member_vendors` VALUES(18, 'nejm', 5, '2012');
INSERT INTO `site_member_vendors` VALUES(19, 'bmj', 5, '2012');
INSERT INTO `site_member_vendors` VALUES(20, 'ebsco', 6, '2012');
INSERT INTO `site_member_vendors` VALUES(21, 'ovid', 6, '2012');
INSERT INTO `site_member_vendors` VALUES(22, 'stat_ref', 6, '2012');
INSERT INTO `site_member_vendors` VALUES(23, 'bmj', 6, '2012');
INSERT INTO `site_member_vendors` VALUES(24, 'ebsco', 7, '2012');
INSERT INTO `site_member_vendors` VALUES(25, 'ovid', 7, '2012');
INSERT INTO `site_member_vendors` VALUES(26, 'mgh', 7, '2012');
INSERT INTO `site_member_vendors` VALUES(27, 'mgh', 8, '2012');
INSERT INTO `site_member_vendors` VALUES(28, 'mgh', 9, '2012');
INSERT INTO `site_member_vendors` VALUES(29, 'nejm', 9, '2012');
INSERT INTO `site_member_vendors` VALUES(30, 'bmj', 9, '2012');
INSERT INTO `site_member_vendors` VALUES(31, 'ebsco', 10, '2012');
INSERT INTO `site_member_vendors` VALUES(32, 'mgh', 11, '2012');
INSERT INTO `site_member_vendors` VALUES(33, 'stat_ref', 11, '2012');
INSERT INTO `site_member_vendors` VALUES(34, 'nejm', 11, '2012');
INSERT INTO `site_member_vendors` VALUES(35, 'bmj', 11, '2012');
INSERT INTO `site_member_vendors` VALUES(36, 'mgh', 12, '2012');
INSERT INTO `site_member_vendors` VALUES(37, 'stat_ref', 12, '2012');
INSERT INTO `site_member_vendors` VALUES(38, 'nejm', 12, '2012');
INSERT INTO `site_member_vendors` VALUES(39, 'bmj', 12, '2012');
INSERT INTO `site_member_vendors` VALUES(40, 'ebsco', 13, '2012');
INSERT INTO `site_member_vendors` VALUES(41, 'mgh', 13, '2012');
INSERT INTO `site_member_vendors` VALUES(42, 'ebsco', 14, '2012');
INSERT INTO `site_member_vendors` VALUES(43, 'ebsco', 15, '2012');
INSERT INTO `site_member_vendors` VALUES(44, 'ovid', 15, '2012');
INSERT INTO `site_member_vendors` VALUES(45, 'ovid', 16, '2012');
INSERT INTO `site_member_vendors` VALUES(46, 'mgh', 16, '2012');
INSERT INTO `site_member_vendors` VALUES(47, 'bmj', 16, '2012');
INSERT INTO `site_member_vendors` VALUES(48, 'mgh', 17, '2012');
INSERT INTO `site_member_vendors` VALUES(49, 'ovid', 18, '2012');
INSERT INTO `site_member_vendors` VALUES(50, 'mgh', 18, '2012');
INSERT INTO `site_member_vendors` VALUES(51, 'bmj', 18, '2012');
INSERT INTO `site_member_vendors` VALUES(52, 'ovid', 19, '2012');
INSERT INTO `site_member_vendors` VALUES(53, 'mgh', 19, '2012');
INSERT INTO `site_member_vendors` VALUES(54, 'bmj', 19, '2012');
INSERT INTO `site_member_vendors` VALUES(55, 'mgh', 20, '2012');
INSERT INTO `site_member_vendors` VALUES(56, 'bmj', 20, '2012');
INSERT INTO `site_member_vendors` VALUES(57, 'bmj', 21, '2012');
INSERT INTO `site_member_vendors` VALUES(58, 'ebsco', 22, '2012');
INSERT INTO `site_member_vendors` VALUES(59, 'ebsco', 23, '2012');
INSERT INTO `site_member_vendors` VALUES(60, 'ovid', 23, '2012');
INSERT INTO `site_member_vendors` VALUES(61, 'mgh', 23, '2012');
INSERT INTO `site_member_vendors` VALUES(62, 'stat_ref', 23, '2012');
INSERT INTO `site_member_vendors` VALUES(63, 'nejm', 23, '2012');
INSERT INTO `site_member_vendors` VALUES(64, 'bmj', 23, '2012');
INSERT INTO `site_member_vendors` VALUES(65, 'ebsco', 24, '2012');
INSERT INTO `site_member_vendors` VALUES(66, 'ovid', 24, '2012');
INSERT INTO `site_member_vendors` VALUES(67, 'ovid', 25, '2012');
INSERT INTO `site_member_vendors` VALUES(68, 'mgh', 25, '2012');
INSERT INTO `site_member_vendors` VALUES(69, 'stat_ref', 25, '2012');
INSERT INTO `site_member_vendors` VALUES(70, 'ebsco', 26, '2012');
INSERT INTO `site_member_vendors` VALUES(71, 'ovid', 26, '2012');
INSERT INTO `site_member_vendors` VALUES(72, 'mgh', 26, '2012');
INSERT INTO `site_member_vendors` VALUES(73, 'stat_ref', 26, '2012');
INSERT INTO `site_member_vendors` VALUES(74, 'bmj', 26, '2012');
INSERT INTO `site_member_vendors` VALUES(75, 'ebsco', 27, '2012');
INSERT INTO `site_member_vendors` VALUES(76, 'mgh', 27, '2012');
INSERT INTO `site_member_vendors` VALUES(77, 'bmj', 27, '2012');
INSERT INTO `site_member_vendors` VALUES(78, 'ebsco', 28, '2012');
INSERT INTO `site_member_vendors` VALUES(79, 'nejm', 28, '2012');
INSERT INTO `site_member_vendors` VALUES(80, 'ebsco', 29, '2012');
INSERT INTO `site_member_vendors` VALUES(81, 'ovid', 29, '2012');
INSERT INTO `site_member_vendors` VALUES(82, 'mgh', 29, '2012');
INSERT INTO `site_member_vendors` VALUES(83, 'stat_ref', 29, '2012');
INSERT INTO `site_member_vendors` VALUES(84, 'bmj', 29, '2012');
INSERT INTO `site_member_vendors` VALUES(85, 'ebsco', 30, '2012');
INSERT INTO `site_member_vendors` VALUES(86, 'ovid', 30, '2012');
INSERT INTO `site_member_vendors` VALUES(87, 'bmj', 30, '2012');
INSERT INTO `site_member_vendors` VALUES(88, 'ovid', 31, '2012');
INSERT INTO `site_member_vendors` VALUES(89, 'mgh', 31, '2012');
INSERT INTO `site_member_vendors` VALUES(90, 'stat_ref', 31, '2012');
INSERT INTO `site_member_vendors` VALUES(91, 'bmj', 31, '2012');
INSERT INTO `site_member_vendors` VALUES(92, 'ebsco', 32, '2012');
INSERT INTO `site_member_vendors` VALUES(93, 'nejm', 32, '2012');
INSERT INTO `site_member_vendors` VALUES(94, 'ovid', 33, '2012');
INSERT INTO `site_member_vendors` VALUES(95, 'mgh', 33, '2012');
INSERT INTO `site_member_vendors` VALUES(96, 'ebsco', 34, '2012');
INSERT INTO `site_member_vendors` VALUES(97, 'ovid', 34, '2012');
INSERT INTO `site_member_vendors` VALUES(98, 'mgh', 34, '2012');
INSERT INTO `site_member_vendors` VALUES(99, 'ebsco', 35, '2012');
INSERT INTO `site_member_vendors` VALUES(100, 'ovid', 35, '2012');
INSERT INTO `site_member_vendors` VALUES(101, 'mgh', 35, '2012');
INSERT INTO `site_member_vendors` VALUES(102, 'ebsco', 36, '2012');
INSERT INTO `site_member_vendors` VALUES(103, 'ovid', 36, '2012');
INSERT INTO `site_member_vendors` VALUES(104, 'mgh', 36, '2012');
INSERT INTO `site_member_vendors` VALUES(105, 'ebsco', 37, '2012');
INSERT INTO `site_member_vendors` VALUES(106, 'ovid', 37, '2012');
INSERT INTO `site_member_vendors` VALUES(107, 'mgh', 37, '2012');
INSERT INTO `site_member_vendors` VALUES(108, 'ebsco', 38, '2012');
INSERT INTO `site_member_vendors` VALUES(109, 'ovid', 38, '2012');
INSERT INTO `site_member_vendors` VALUES(110, 'mgh', 38, '2012');
INSERT INTO `site_member_vendors` VALUES(111, 'ebsco', 39, '2012');
INSERT INTO `site_member_vendors` VALUES(112, 'ovid', 39, '2012');
INSERT INTO `site_member_vendors` VALUES(113, 'ebsco', 40, '2012');
INSERT INTO `site_member_vendors` VALUES(114, 'ovid', 40, '2012');
INSERT INTO `site_member_vendors` VALUES(115, 'mgh', 40, '2012');
INSERT INTO `site_member_vendors` VALUES(116, 'stat_ref', 40, '2012');
INSERT INTO `site_member_vendors` VALUES(117, 'nejm', 40, '2012');
INSERT INTO `site_member_vendors` VALUES(118, 'bmj', 40, '2012');
INSERT INTO `site_member_vendors` VALUES(119, 'ebsco', 41, '2012');
INSERT INTO `site_member_vendors` VALUES(120, 'ovid', 41, '2012');
INSERT INTO `site_member_vendors` VALUES(121, 'mgh', 41, '2012');
INSERT INTO `site_member_vendors` VALUES(122, 'bmj', 41, '2012');
INSERT INTO `site_member_vendors` VALUES(123, 'ebsco', 42, '2012');
INSERT INTO `site_member_vendors` VALUES(124, 'ovid', 42, '2012');
INSERT INTO `site_member_vendors` VALUES(125, 'mgh', 42, '2012');
INSERT INTO `site_member_vendors` VALUES(126, 'ovid', 43, '2012');
INSERT INTO `site_member_vendors` VALUES(127, 'stat_ref', 43, '2012');
INSERT INTO `site_member_vendors` VALUES(128, 'bmj', 43, '2012');
INSERT INTO `site_member_vendors` VALUES(129, 'ovid', 44, '2012');
INSERT INTO `site_member_vendors` VALUES(130, 'mgh', 44, '2012');
INSERT INTO `site_member_vendors` VALUES(131, 'bmj', 44, '2012');
INSERT INTO `site_member_vendors` VALUES(132, 'ovid', 45, '2012');
INSERT INTO `site_member_vendors` VALUES(133, 'mgh', 45, '2012');
INSERT INTO `site_member_vendors` VALUES(134, 'ebsco', 46, '2012');
INSERT INTO `site_member_vendors` VALUES(135, 'ovid', 46, '2012');
INSERT INTO `site_member_vendors` VALUES(136, 'mgh', 46, '2012');
INSERT INTO `site_member_vendors` VALUES(137, 'nejm', 46, '2012');
INSERT INTO `site_member_vendors` VALUES(138, 'ebsco', 47, '2012');
INSERT INTO `site_member_vendors` VALUES(139, 'ovid', 47, '2012');
INSERT INTO `site_member_vendors` VALUES(140, 'mgh', 47, '2012');
INSERT INTO `site_member_vendors` VALUES(141, 'mgh', 48, '2012');
INSERT INTO `site_member_vendors` VALUES(142, 'ebsco', 49, '2012');
INSERT INTO `site_member_vendors` VALUES(143, 'ebsco', 50, '2012');
INSERT INTO `site_member_vendors` VALUES(144, 'ovid', 50, '2012');
INSERT INTO `site_member_vendors` VALUES(145, 'mgh', 50, '2012');
INSERT INTO `site_member_vendors` VALUES(146, 'stat_ref', 50, '2012');
INSERT INTO `site_member_vendors` VALUES(147, 'bmj', 50, '2012');
INSERT INTO `site_member_vendors` VALUES(148, 'nejm', 51, '2012');
INSERT INTO `site_member_vendors` VALUES(149, 'stat_ref', 52, '2012');
INSERT INTO `site_member_vendors` VALUES(150, 'bmj', 52, '2012');
INSERT INTO `site_member_vendors` VALUES(151, 'ebsco', 53, '2012');
INSERT INTO `site_member_vendors` VALUES(152, 'ovid', 53, '2012');
INSERT INTO `site_member_vendors` VALUES(153, 'nejm', 53, '2012');
INSERT INTO `site_member_vendors` VALUES(154, 'ebsco', 54, '2012');
INSERT INTO `site_member_vendors` VALUES(155, 'ovid', 54, '2012');
INSERT INTO `site_member_vendors` VALUES(156, 'mgh', 54, '2012');
INSERT INTO `site_member_vendors` VALUES(157, 'nejm', 54, '2012');
INSERT INTO `site_member_vendors` VALUES(158, 'ovid', 55, '2012');
INSERT INTO `site_member_vendors` VALUES(159, 'mgh', 55, '2012');
INSERT INTO `site_member_vendors` VALUES(160, 'nejm', 55, '2012');
INSERT INTO `site_member_vendors` VALUES(161, 'ebsco', 56, '2012');
INSERT INTO `site_member_vendors` VALUES(162, 'ebsco', 57, '2012');
INSERT INTO `site_member_vendors` VALUES(163, 'ovid', 57, '2012');
INSERT INTO `site_member_vendors` VALUES(164, 'nejm', 57, '2012');
INSERT INTO `site_member_vendors` VALUES(165, 'ovid', 58, '2012');
INSERT INTO `site_member_vendors` VALUES(166, 'mgh', 58, '2012');
INSERT INTO `site_member_vendors` VALUES(167, 'stat_ref', 58, '2012');
INSERT INTO `site_member_vendors` VALUES(168, 'ebsco', 59, '2012');
INSERT INTO `site_member_vendors` VALUES(169, 'ovid', 59, '2012');
INSERT INTO `site_member_vendors` VALUES(170, 'mgh', 59, '2012');
INSERT INTO `site_member_vendors` VALUES(171, 'bmj', 59, '2012');
INSERT INTO `site_member_vendors` VALUES(172, 'ovid', 60, '2012');
INSERT INTO `site_member_vendors` VALUES(173, 'mgh', 60, '2012');
INSERT INTO `site_member_vendors` VALUES(174, 'bmj', 60, '2012');
INSERT INTO `site_member_vendors` VALUES(175, 'ovid', 61, '2012');
INSERT INTO `site_member_vendors` VALUES(176, 'mgh', 61, '2012');
INSERT INTO `site_member_vendors` VALUES(177, 'bmj', 61, '2012');
INSERT INTO `site_member_vendors` VALUES(178, 'ovid', 62, '2012');
INSERT INTO `site_member_vendors` VALUES(179, 'mgh', 62, '2012');
INSERT INTO `site_member_vendors` VALUES(180, 'bmj', 62, '2012');
INSERT INTO `site_member_vendors` VALUES(181, 'ebsco', 63, '2012');
INSERT INTO `site_member_vendors` VALUES(182, 'mgh', 64, '2012');
INSERT INTO `site_member_vendors` VALUES(183, 'nejm', 64, '2012');
INSERT INTO `site_member_vendors` VALUES(184, 'bmj', 64, '2012');
INSERT INTO `site_member_vendors` VALUES(185, 'ovid', 68, '2012');
INSERT INTO `site_member_vendors` VALUES(186, 'mgh', 68, '2012');
INSERT INTO `site_member_vendors` VALUES(187, 'stat_ref', 68, '2012');
INSERT INTO `site_member_vendors` VALUES(188, 'bmj', 68, '2012');
INSERT INTO `site_member_vendors` VALUES(189, 'ovid', 69, '2012');
INSERT INTO `site_member_vendors` VALUES(190, 'bmj', 69, '2012');

-- --------------------------------------------------------

--
-- Table structure for table `site_resource_rules`
--

DROP TABLE IF EXISTS `site_resource_rules`;
CREATE TABLE `site_resource_rules` (
  `resource_rule_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_resource_id` int(11) DEFAULT NULL,
  `resource_rule_description` varchar(50) DEFAULT NULL,
  `resource_rule_min_beds` int(11) DEFAULT NULL,
  `resource_rule_max_beds` int(11) DEFAULT NULL,
  PRIMARY KEY (`resource_rule_id`),
  UNIQUE KEY `resource_rule_id` (`resource_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `site_resource_rules`
--


-- --------------------------------------------------------

--
-- Table structure for table `site_vendors`
--

DROP TABLE IF EXISTS `site_vendors`;
CREATE TABLE `site_vendors` (
  `vendor_id` varchar(10) NOT NULL DEFAULT '',
  `vendor_name` varchar(30) DEFAULT NULL,
  `vendor_description` varchar(60) DEFAULT NULL,
  `vendor_notes` text,
  PRIMARY KEY (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_vendors`
--

INSERT INTO `site_vendors` VALUES('bmj', 'BMJ', NULL, NULL);
INSERT INTO `site_vendors` VALUES('ebsco', 'EBSCO', NULL, NULL);
INSERT INTO `site_vendors` VALUES('mgh', 'MGH', NULL, NULL);
INSERT INTO `site_vendors` VALUES('nejm', 'NEJM', NULL, NULL);
INSERT INTO `site_vendors` VALUES('ovid', 'OVID', NULL, NULL);
INSERT INTO `site_vendors` VALUES('stat_ref', 'STAT!Ref', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_vendor_resources`
--

DROP TABLE IF EXISTS `site_vendor_resources`;
CREATE TABLE `site_vendor_resources` (
  `vendor_resource_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` varchar(10) DEFAULT NULL,
  `vendor_resource_name` varchar(30) DEFAULT NULL,
  `vendor_resource_description` varchar(60) DEFAULT NULL,
  `vendor_resource_admin_fee` float DEFAULT NULL,
  `vendor_resource_per_facility_fee` float DEFAULT NULL,
  `vendor_resource_notes` text,
  PRIMARY KEY (`vendor_resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `site_vendor_resources`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `site_member_vendors`
--
ALTER TABLE `site_member_vendors`
  ADD CONSTRAINT `site_member_vendors_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `site_vendors` (`vendor_id`),
  ADD CONSTRAINT `FK_member_vendors_site_member_id` FOREIGN KEY (`member_id`) REFERENCES `site_members` (`member_id`);
