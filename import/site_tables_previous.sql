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
-- Table structure for table `site_member_resources`
--

DROP TABLE IF EXISTS `site_member_resources`;
CREATE TABLE `site_member_resources` (
  `member_resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` varchar(10) DEFAULT NULL,
  `member_id` int(10) unsigned DEFAULT NULL,
  `fiscal_year` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`member_resource_id`),
  KEY `FK_member_resources_member_id` (`member_id`),
  KEY `FK_member_resources_resource_id` (`resource_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=191 ;

--
-- Dumping data for table `site_member_resources`
--

INSERT INTO `site_member_resources` VALUES(1, 'ovid', 1, '2012');
INSERT INTO `site_member_resources` VALUES(2, 'mgh', 1, '2012');
INSERT INTO `site_member_resources` VALUES(3, 'stat_ref', 1, '2012');
INSERT INTO `site_member_resources` VALUES(4, 'nejm', 1, '2012');
INSERT INTO `site_member_resources` VALUES(5, 'bmj', 1, '2012');
INSERT INTO `site_member_resources` VALUES(6, 'ebsco', 2, '2012');
INSERT INTO `site_member_resources` VALUES(7, 'ovid', 2, '2012');
INSERT INTO `site_member_resources` VALUES(8, 'nejm', 2, '2012');
INSERT INTO `site_member_resources` VALUES(9, 'bmj', 2, '2012');
INSERT INTO `site_member_resources` VALUES(10, 'ebsco', 3, '2012');
INSERT INTO `site_member_resources` VALUES(11, 'ovid', 3, '2012');
INSERT INTO `site_member_resources` VALUES(12, 'bmj', 3, '2012');
INSERT INTO `site_member_resources` VALUES(13, 'ovid', 4, '2012');
INSERT INTO `site_member_resources` VALUES(14, 'nejm', 4, '2012');
INSERT INTO `site_member_resources` VALUES(15, 'ebsco', 5, '2012');
INSERT INTO `site_member_resources` VALUES(16, 'ovid', 5, '2012');
INSERT INTO `site_member_resources` VALUES(17, 'stat_ref', 5, '2012');
INSERT INTO `site_member_resources` VALUES(18, 'nejm', 5, '2012');
INSERT INTO `site_member_resources` VALUES(19, 'bmj', 5, '2012');
INSERT INTO `site_member_resources` VALUES(20, 'ebsco', 6, '2012');
INSERT INTO `site_member_resources` VALUES(21, 'ovid', 6, '2012');
INSERT INTO `site_member_resources` VALUES(22, 'stat_ref', 6, '2012');
INSERT INTO `site_member_resources` VALUES(23, 'bmj', 6, '2012');
INSERT INTO `site_member_resources` VALUES(24, 'ebsco', 7, '2012');
INSERT INTO `site_member_resources` VALUES(25, 'ovid', 7, '2012');
INSERT INTO `site_member_resources` VALUES(26, 'mgh', 7, '2012');
INSERT INTO `site_member_resources` VALUES(27, 'mgh', 8, '2012');
INSERT INTO `site_member_resources` VALUES(28, 'mgh', 9, '2012');
INSERT INTO `site_member_resources` VALUES(29, 'nejm', 9, '2012');
INSERT INTO `site_member_resources` VALUES(30, 'bmj', 9, '2012');
INSERT INTO `site_member_resources` VALUES(31, 'ebsco', 10, '2012');
INSERT INTO `site_member_resources` VALUES(32, 'mgh', 11, '2012');
INSERT INTO `site_member_resources` VALUES(33, 'stat_ref', 11, '2012');
INSERT INTO `site_member_resources` VALUES(34, 'nejm', 11, '2012');
INSERT INTO `site_member_resources` VALUES(35, 'bmj', 11, '2012');
INSERT INTO `site_member_resources` VALUES(36, 'mgh', 12, '2012');
INSERT INTO `site_member_resources` VALUES(37, 'stat_ref', 12, '2012');
INSERT INTO `site_member_resources` VALUES(38, 'nejm', 12, '2012');
INSERT INTO `site_member_resources` VALUES(39, 'bmj', 12, '2012');
INSERT INTO `site_member_resources` VALUES(40, 'ebsco', 13, '2012');
INSERT INTO `site_member_resources` VALUES(41, 'mgh', 13, '2012');
INSERT INTO `site_member_resources` VALUES(42, 'ebsco', 14, '2012');
INSERT INTO `site_member_resources` VALUES(43, 'ebsco', 15, '2012');
INSERT INTO `site_member_resources` VALUES(44, 'ovid', 15, '2012');
INSERT INTO `site_member_resources` VALUES(45, 'ovid', 16, '2012');
INSERT INTO `site_member_resources` VALUES(46, 'mgh', 16, '2012');
INSERT INTO `site_member_resources` VALUES(47, 'bmj', 16, '2012');
INSERT INTO `site_member_resources` VALUES(48, 'mgh', 17, '2012');
INSERT INTO `site_member_resources` VALUES(49, 'ovid', 18, '2012');
INSERT INTO `site_member_resources` VALUES(50, 'mgh', 18, '2012');
INSERT INTO `site_member_resources` VALUES(51, 'bmj', 18, '2012');
INSERT INTO `site_member_resources` VALUES(52, 'ovid', 19, '2012');
INSERT INTO `site_member_resources` VALUES(53, 'mgh', 19, '2012');
INSERT INTO `site_member_resources` VALUES(54, 'bmj', 19, '2012');
INSERT INTO `site_member_resources` VALUES(55, 'mgh', 20, '2012');
INSERT INTO `site_member_resources` VALUES(56, 'bmj', 20, '2012');
INSERT INTO `site_member_resources` VALUES(57, 'bmj', 21, '2012');
INSERT INTO `site_member_resources` VALUES(58, 'ebsco', 22, '2012');
INSERT INTO `site_member_resources` VALUES(59, 'ebsco', 23, '2012');
INSERT INTO `site_member_resources` VALUES(60, 'ovid', 23, '2012');
INSERT INTO `site_member_resources` VALUES(61, 'mgh', 23, '2012');
INSERT INTO `site_member_resources` VALUES(62, 'stat_ref', 23, '2012');
INSERT INTO `site_member_resources` VALUES(63, 'nejm', 23, '2012');
INSERT INTO `site_member_resources` VALUES(64, 'bmj', 23, '2012');
INSERT INTO `site_member_resources` VALUES(65, 'ebsco', 24, '2012');
INSERT INTO `site_member_resources` VALUES(66, 'ovid', 24, '2012');
INSERT INTO `site_member_resources` VALUES(67, 'ovid', 25, '2012');
INSERT INTO `site_member_resources` VALUES(68, 'mgh', 25, '2012');
INSERT INTO `site_member_resources` VALUES(69, 'stat_ref', 25, '2012');
INSERT INTO `site_member_resources` VALUES(70, 'ebsco', 26, '2012');
INSERT INTO `site_member_resources` VALUES(71, 'ovid', 26, '2012');
INSERT INTO `site_member_resources` VALUES(72, 'mgh', 26, '2012');
INSERT INTO `site_member_resources` VALUES(73, 'stat_ref', 26, '2012');
INSERT INTO `site_member_resources` VALUES(74, 'bmj', 26, '2012');
INSERT INTO `site_member_resources` VALUES(75, 'ebsco', 27, '2012');
INSERT INTO `site_member_resources` VALUES(76, 'mgh', 27, '2012');
INSERT INTO `site_member_resources` VALUES(77, 'bmj', 27, '2012');
INSERT INTO `site_member_resources` VALUES(78, 'ebsco', 28, '2012');
INSERT INTO `site_member_resources` VALUES(79, 'nejm', 28, '2012');
INSERT INTO `site_member_resources` VALUES(80, 'ebsco', 29, '2012');
INSERT INTO `site_member_resources` VALUES(81, 'ovid', 29, '2012');
INSERT INTO `site_member_resources` VALUES(82, 'mgh', 29, '2012');
INSERT INTO `site_member_resources` VALUES(83, 'stat_ref', 29, '2012');
INSERT INTO `site_member_resources` VALUES(84, 'bmj', 29, '2012');
INSERT INTO `site_member_resources` VALUES(85, 'ebsco', 30, '2012');
INSERT INTO `site_member_resources` VALUES(86, 'ovid', 30, '2012');
INSERT INTO `site_member_resources` VALUES(87, 'bmj', 30, '2012');
INSERT INTO `site_member_resources` VALUES(88, 'ovid', 31, '2012');
INSERT INTO `site_member_resources` VALUES(89, 'mgh', 31, '2012');
INSERT INTO `site_member_resources` VALUES(90, 'stat_ref', 31, '2012');
INSERT INTO `site_member_resources` VALUES(91, 'bmj', 31, '2012');
INSERT INTO `site_member_resources` VALUES(92, 'ebsco', 32, '2012');
INSERT INTO `site_member_resources` VALUES(93, 'nejm', 32, '2012');
INSERT INTO `site_member_resources` VALUES(94, 'ovid', 33, '2012');
INSERT INTO `site_member_resources` VALUES(95, 'mgh', 33, '2012');
INSERT INTO `site_member_resources` VALUES(96, 'ebsco', 34, '2012');
INSERT INTO `site_member_resources` VALUES(97, 'ovid', 34, '2012');
INSERT INTO `site_member_resources` VALUES(98, 'mgh', 34, '2012');
INSERT INTO `site_member_resources` VALUES(99, 'ebsco', 35, '2012');
INSERT INTO `site_member_resources` VALUES(100, 'ovid', 35, '2012');
INSERT INTO `site_member_resources` VALUES(101, 'mgh', 35, '2012');
INSERT INTO `site_member_resources` VALUES(102, 'ebsco', 36, '2012');
INSERT INTO `site_member_resources` VALUES(103, 'ovid', 36, '2012');
INSERT INTO `site_member_resources` VALUES(104, 'mgh', 36, '2012');
INSERT INTO `site_member_resources` VALUES(105, 'ebsco', 37, '2012');
INSERT INTO `site_member_resources` VALUES(106, 'ovid', 37, '2012');
INSERT INTO `site_member_resources` VALUES(107, 'mgh', 37, '2012');
INSERT INTO `site_member_resources` VALUES(108, 'ebsco', 38, '2012');
INSERT INTO `site_member_resources` VALUES(109, 'ovid', 38, '2012');
INSERT INTO `site_member_resources` VALUES(110, 'mgh', 38, '2012');
INSERT INTO `site_member_resources` VALUES(111, 'ebsco', 39, '2012');
INSERT INTO `site_member_resources` VALUES(112, 'ovid', 39, '2012');
INSERT INTO `site_member_resources` VALUES(113, 'ebsco', 40, '2012');
INSERT INTO `site_member_resources` VALUES(114, 'ovid', 40, '2012');
INSERT INTO `site_member_resources` VALUES(115, 'mgh', 40, '2012');
INSERT INTO `site_member_resources` VALUES(116, 'stat_ref', 40, '2012');
INSERT INTO `site_member_resources` VALUES(117, 'nejm', 40, '2012');
INSERT INTO `site_member_resources` VALUES(118, 'bmj', 40, '2012');
INSERT INTO `site_member_resources` VALUES(119, 'ebsco', 41, '2012');
INSERT INTO `site_member_resources` VALUES(120, 'ovid', 41, '2012');
INSERT INTO `site_member_resources` VALUES(121, 'mgh', 41, '2012');
INSERT INTO `site_member_resources` VALUES(122, 'bmj', 41, '2012');
INSERT INTO `site_member_resources` VALUES(123, 'ebsco', 42, '2012');
INSERT INTO `site_member_resources` VALUES(124, 'ovid', 42, '2012');
INSERT INTO `site_member_resources` VALUES(125, 'mgh', 42, '2012');
INSERT INTO `site_member_resources` VALUES(126, 'ovid', 43, '2012');
INSERT INTO `site_member_resources` VALUES(127, 'stat_ref', 43, '2012');
INSERT INTO `site_member_resources` VALUES(128, 'bmj', 43, '2012');
INSERT INTO `site_member_resources` VALUES(129, 'ovid', 44, '2012');
INSERT INTO `site_member_resources` VALUES(130, 'mgh', 44, '2012');
INSERT INTO `site_member_resources` VALUES(131, 'bmj', 44, '2012');
INSERT INTO `site_member_resources` VALUES(132, 'ovid', 45, '2012');
INSERT INTO `site_member_resources` VALUES(133, 'mgh', 45, '2012');
INSERT INTO `site_member_resources` VALUES(134, 'ebsco', 46, '2012');
INSERT INTO `site_member_resources` VALUES(135, 'ovid', 46, '2012');
INSERT INTO `site_member_resources` VALUES(136, 'mgh', 46, '2012');
INSERT INTO `site_member_resources` VALUES(137, 'nejm', 46, '2012');
INSERT INTO `site_member_resources` VALUES(138, 'ebsco', 47, '2012');
INSERT INTO `site_member_resources` VALUES(139, 'ovid', 47, '2012');
INSERT INTO `site_member_resources` VALUES(140, 'mgh', 47, '2012');
INSERT INTO `site_member_resources` VALUES(141, 'mgh', 48, '2012');
INSERT INTO `site_member_resources` VALUES(142, 'ebsco', 49, '2012');
INSERT INTO `site_member_resources` VALUES(143, 'ebsco', 50, '2012');
INSERT INTO `site_member_resources` VALUES(144, 'ovid', 50, '2012');
INSERT INTO `site_member_resources` VALUES(145, 'mgh', 50, '2012');
INSERT INTO `site_member_resources` VALUES(146, 'stat_ref', 50, '2012');
INSERT INTO `site_member_resources` VALUES(147, 'bmj', 50, '2012');
INSERT INTO `site_member_resources` VALUES(148, 'nejm', 51, '2012');
INSERT INTO `site_member_resources` VALUES(149, 'stat_ref', 52, '2012');
INSERT INTO `site_member_resources` VALUES(150, 'bmj', 52, '2012');
INSERT INTO `site_member_resources` VALUES(151, 'ebsco', 53, '2012');
INSERT INTO `site_member_resources` VALUES(152, 'ovid', 53, '2012');
INSERT INTO `site_member_resources` VALUES(153, 'nejm', 53, '2012');
INSERT INTO `site_member_resources` VALUES(154, 'ebsco', 54, '2012');
INSERT INTO `site_member_resources` VALUES(155, 'ovid', 54, '2012');
INSERT INTO `site_member_resources` VALUES(156, 'mgh', 54, '2012');
INSERT INTO `site_member_resources` VALUES(157, 'nejm', 54, '2012');
INSERT INTO `site_member_resources` VALUES(158, 'ovid', 55, '2012');
INSERT INTO `site_member_resources` VALUES(159, 'mgh', 55, '2012');
INSERT INTO `site_member_resources` VALUES(160, 'nejm', 55, '2012');
INSERT INTO `site_member_resources` VALUES(161, 'ebsco', 56, '2012');
INSERT INTO `site_member_resources` VALUES(162, 'ebsco', 57, '2012');
INSERT INTO `site_member_resources` VALUES(163, 'ovid', 57, '2012');
INSERT INTO `site_member_resources` VALUES(164, 'nejm', 57, '2012');
INSERT INTO `site_member_resources` VALUES(165, 'ovid', 58, '2012');
INSERT INTO `site_member_resources` VALUES(166, 'mgh', 58, '2012');
INSERT INTO `site_member_resources` VALUES(167, 'stat_ref', 58, '2012');
INSERT INTO `site_member_resources` VALUES(168, 'ebsco', 59, '2012');
INSERT INTO `site_member_resources` VALUES(169, 'ovid', 59, '2012');
INSERT INTO `site_member_resources` VALUES(170, 'mgh', 59, '2012');
INSERT INTO `site_member_resources` VALUES(171, 'bmj', 59, '2012');
INSERT INTO `site_member_resources` VALUES(172, 'ovid', 60, '2012');
INSERT INTO `site_member_resources` VALUES(173, 'mgh', 60, '2012');
INSERT INTO `site_member_resources` VALUES(174, 'bmj', 60, '2012');
INSERT INTO `site_member_resources` VALUES(175, 'ovid', 61, '2012');
INSERT INTO `site_member_resources` VALUES(176, 'mgh', 61, '2012');
INSERT INTO `site_member_resources` VALUES(177, 'bmj', 61, '2012');
INSERT INTO `site_member_resources` VALUES(178, 'ovid', 62, '2012');
INSERT INTO `site_member_resources` VALUES(179, 'mgh', 62, '2012');
INSERT INTO `site_member_resources` VALUES(180, 'bmj', 62, '2012');
INSERT INTO `site_member_resources` VALUES(181, 'ebsco', 63, '2012');
INSERT INTO `site_member_resources` VALUES(182, 'mgh', 64, '2012');
INSERT INTO `site_member_resources` VALUES(183, 'nejm', 64, '2012');
INSERT INTO `site_member_resources` VALUES(184, 'bmj', 64, '2012');
INSERT INTO `site_member_resources` VALUES(185, 'ovid', 68, '2012');
INSERT INTO `site_member_resources` VALUES(186, 'mgh', 68, '2012');
INSERT INTO `site_member_resources` VALUES(187, 'stat_ref', 68, '2012');
INSERT INTO `site_member_resources` VALUES(188, 'bmj', 68, '2012');
INSERT INTO `site_member_resources` VALUES(189, 'ovid', 69, '2012');
INSERT INTO `site_member_resources` VALUES(190, 'bmj', 69, '2012');

-- --------------------------------------------------------

--
-- Table structure for table `site_product_rules`
--

DROP TABLE IF EXISTS `site_product_rules`;
CREATE TABLE `site_product_rules` (
  `product_rule_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `resource_product_id` int(11) DEFAULT NULL,
  `product_rule_description` varchar(50) DEFAULT NULL,
  `product_rule_min_beds` int(11) DEFAULT NULL,
  `product_rule_max_beds` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_rule_id`),
  UNIQUE KEY `product_rule_id` (`product_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `site_product_rules`
--


-- --------------------------------------------------------

--
-- Table structure for table `site_resources`
--

DROP TABLE IF EXISTS `site_resources`;
CREATE TABLE `site_resources` (
  `resource_id` varchar(10) NOT NULL DEFAULT '',
  `resource_name` varchar(30) DEFAULT NULL,
  `resource_description` varchar(60) DEFAULT NULL,
  `resource_notes` text,
  PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_resources`
--

INSERT INTO `site_resources` VALUES('bmj', 'BMJ', NULL, NULL);
INSERT INTO `site_resources` VALUES('ebsco', 'EBSCO', NULL, NULL);
INSERT INTO `site_resources` VALUES('mgh', 'MGH', NULL, NULL);
INSERT INTO `site_resources` VALUES('nejm', 'NEJM', NULL, NULL);
INSERT INTO `site_resources` VALUES('ovid', 'OVID', NULL, NULL);
INSERT INTO `site_resources` VALUES('stat_ref', 'STAT!Ref', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_resource_products`
--

DROP TABLE IF EXISTS `site_resource_products`;
CREATE TABLE `site_resource_products` (
  `resource_product_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `resource_id` varchar(10) DEFAULT NULL,
  `resource_product_name` varchar(30) DEFAULT NULL,
  `resource_product_description` varchar(60) DEFAULT NULL,
  `resource_product_admin_fee` float DEFAULT NULL,
  `resource_product_per_facility_fee` float DEFAULT NULL,
  `resource_product_notes` text,
  PRIMARY KEY (`resource_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `site_resource_products`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `site_member_resources`
--
ALTER TABLE `site_member_resources`
  ADD CONSTRAINT `site_member_resources_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `site_resources` (`resource_id`),
  ADD CONSTRAINT `FK_member_resources_site_member_id` FOREIGN KEY (`member_id`) REFERENCES `site_members` (`member_id`);
