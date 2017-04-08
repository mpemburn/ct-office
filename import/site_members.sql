-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 06, 2012 at 11:06 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `hslanj_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `site_members`
--

DROP TABLE IF EXISTS `site_members`;
CREATE TABLE `site_members` (
  `member_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `counter` int(10) DEFAULT NULL,
  `member_name` varchar(70) DEFAULT NULL,
  `contact_name` varchar(30) DEFAULT NULL,
  `contact_title` varchar(50) DEFAULT NULL,
  `address_1` varchar(30) DEFAULT NULL,
  `address_2` varchar(30) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `county` varchar(20) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `consortia` varchar(10) DEFAULT NULL,
  `beds` int(10) DEFAULT NULL,
  `ip_addresses` text,
  `notes` text,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=70 ;

--
-- Dumping data for table `site_members`
--

INSERT INTO `site_members` VALUES(1, 1, 'Alfred I duPont Hospital for Children of the Nemours Foundation', 'Kristina M. Flathers', 'Medical Librarian', '1600 Rockland Rd', '0', 'Talleyville', 'DE', '19803-3607', 'New Castle', 'kflather@nemours.org', '(302) 723-1238', '(302) 651-5823', 'DelMIRA', 193, '192.234.253.0-254; 199.254.17.1-254; 207.103.18.0-254', '');
INSERT INTO `site_members` VALUES(2, 2, 'Atlantic Health System - Overlook Hospital', 'Patricia B. Regenberg', 'Library Manager', '99 Beauvoir Ave', '0', 'Summit', 'NJ', '07902-3533', 'Union', 'pat.regenberg@atlantichealth.org', '(908) 522-2886', '(908) 522-2274', 'HSLANJ', 360, '198.140.184.1; 198.140.183.1; 141.150.155.167; 204.58.30.2; 204.58.29.2', '');
INSERT INTO `site_members` VALUES(3, 3, 'Atlantic Health System - Morristown Memorial Hospital', 'Mary K Joyce', 'Library Manager', '100 Madison Ave', '0', 'Morristown', 'NJ', '07960-6136', 'Morris', 'maryk.joyce@atlantichealth.org', '(973) 971-5780', '(973) 290-7045', 'HSLANJ', 647, '198.140.184.1; 198.140.183.1; 141.150.155.167; 204.58.30.2; 204.58.29.2', 'Send bills for MMH to Pat Regenberg at OLH');
INSERT INTO `site_members` VALUES(4, 4, 'Beebe Medical Center', 'Jean D. Winstead', 'Health Sciences Librarian', '424 Savannah Rd', '0', 'Lewes', 'DE', '19958-1462', 'Sussex', 'jwinstead@bbmc.org', '(302) 645-3100 X5472', '(302) 644-2319', 'DelMIRA', 210, '216.158.0.100', '');
INSERT INTO `site_members` VALUES(5, 5, 'Capital Health at Mercer', 'Erica S. Moncreif', 'Director, Library Services', '446 Bellevue Ave', '0', 'Trenton', 'NJ', '08618-4502', 'Mercer', 'emoncrief@capitalhealth.org', '(609) 394-4125', '(609) 394-4131', 'HSLANJ', 215, '12.233.36.3', '');
INSERT INTO `site_members` VALUES(6, 6, 'Capital Health Regional Medical Center', 'Erica S. Moncreif', 'Director, Library Services', '750 Brunswick Ave', '0', 'Trenton', 'NJ', '08638-4143', 'Mercer', 'emoncrief@capitalhealth.org', '(609) 394-4125', '(609) 394-4131', 'HSLANJ', 213, '12.233.36.3', 'Send bills to Erica Moncrief at Capital Health at Mercer');
INSERT INTO `site_members` VALUES(7, 7, 'CentraState Healthcare System', 'Robin D. Siegel', 'Medical Librarian', '901 W Main St', '0', 'Freehold', 'NJ', '07728-2537', 'Monmouth', 'rsiegel@centrastate.com', '(732) 294-2668', '', 'HSLANJ', 260, '65.51.200.4', 'Bill DynaMed separately but add admin fee to the CINAHL, Ovid & MGH Invoice');
INSERT INTO `site_members` VALUES(8, 8, 'Chambersburg Hospital / Summit Health', 'Debra R. Miller', 'Education Resource Specialist', '112 N 7th St', '0', 'Chambersburg', 'PA', '17201-1720', 'Franklin', 'drmiller@summithealth.org', '(717) 267-4886', '', 'CPHSLA', 304, '67.237.145.164-169', '');
INSERT INTO `site_members` VALUES(9, 9, 'Children''s Specialized Hospital', 'Lyudmilla Lungin', 'Medical Librarian', '150 New Providence Rd', '0', 'Mountainside', 'NJ', '07092-2590', 'Union', 'llungin@childrens-specialized.org', '(908) 233-3720 X5227', '(908) 301-5569', 'HSLANJ', 30, '65.196.59.130', '');
INSERT INTO `site_members` VALUES(10, 10, 'Chilton Memorial Hospital', 'Eleanor Silverman', 'Medical Librarian', '97 West Parkway', '0', 'Pompton Plains', 'NJ', '07444-1647', 'Morris', 'esilverman18@hotmail.com', '(973) 831-5058', '(973) 831-5041', 'HSLANJ', 256, '', '');
INSERT INTO `site_members` VALUES(11, 11, 'Christiana Care Health System - Christiana Hospital', 'Christine Chastain-Warheit', 'Director, Medical Libraries', '4755 Ogletown Stanton Rd', '0', 'Newark', 'DE', '19718-0002', 'New Castle', 'ccw@christianacare.org', '(302) 733-1116', '(302) 733-1365', 'HSLANJ', 732, '167.112.0.0', '');
INSERT INTO `site_members` VALUES(12, 12, 'Christiana Care Health System - Wilmington Hospital', 'Christine Chastain-Warheit', 'Director, Medical Libraries', '501 W 14th St', '0', 'Wilmington', 'DE', '19801-1014', 'New Castle', 'ccw@christianacare.org', '(302) 733-1116', '(302) 733-1365', 'HSLANJ', 223, '167.112.0.0', 'Send all bills to CCW at CCHS');
INSERT INTO `site_members` VALUES(13, 13, 'Clara Maass Medical Center', 'Arlene Mangino', 'Medical Librarian / Manager', '1 Clara Maass Dr', '0', 'Belleville', 'NJ', '07109-3550', 'Essex', 'amangino@sbhcs.com', '(973) 450-2294', '(973) 844-4390', 'HSLANJ', 400, 'None - User ID/PW access only', '');
INSERT INTO `site_members` VALUES(14, 14, 'Community Medical Center', 'Donna Skulitz', 'RN Educator', '99 Hwy 37 West', '0', 'Toms River', 'NJ', '08753-6423', 'Ocean', 'dskulitz@sbhcs.com', '(732) 557-8205', '(732) 557-8693', 'NJHA', 592, '208.68.21.27-8; 208.68.20.27-8', '');
INSERT INTO `site_members` VALUES(15, 15, 'Deborah Heart and Lung Center', 'Carol A. Harris', 'Director, Library Services', '200 Trenton Rd', '0', 'Browns Mills', 'NJ', '08015-1705', 'Burlington', 'harrisc@deborah.org', '(609) 893-1200 X4398', '(609) 893-1566', 'HSLANJ', 139, '65.210.21.114-129', '');
INSERT INTO `site_members` VALUES(16, 16, 'Doylestown Hospital', 'Amy Scott', 'Manager, Library Services', '595 W State St', '0', 'Doylestown', 'PA', '18901-2554', 'Bucks', 'ascott@dh.org', '(215) 345-2310', '(215) 345-2541', 'HSLANJ', 209, '715.113.110.*', '');
INSERT INTO `site_members` VALUES(17, 17, 'Easton Hospital', 'Michael Schott', 'Director, Library Services', '250 S 21st St', '0', 'Easton', 'PA', '18042-3851', 'Northampton', 'michael_schott@chs.net', '(610) 250-4131', '', 'CHL', 255, '', '');
INSERT INTO `site_members` VALUES(18, 18, 'ECRI Institute', 'Amy Stone', 'Electronic Services Librarian', '5200 Butler Pike', '0', 'Plymouth Meeting', 'PA', '19462-1203', 'Montgomery', 'astone@ecri.org', '(610) 825-6000 X5198', '(610) 834-7366', 'Devic', 0, '8.14.164.3', '');
INSERT INTO `site_members` VALUES(19, 19, 'Fox Chase Cancer Center', 'Beth Lewis', 'Director of Library Services', '333 Cottman Ave', '0', 'Philadelphia', 'PA', '19111-2434', 'Philadelphia', 'beth.lewis@fccc.edu', '(215) 725-2710', '(215) 728-3655', 'HSLANJ', 75, '131.249.*.*', 'Bill McGraw Hill now; Bill everything else after July 1');
INSERT INTO `site_members` VALUES(20, 20, 'Geisinger System Services - Geisinger Medical Center', 'Susan Robishaw', 'Assistant Director', '100 N Academy Ave', '0', 'Danville', 'PA', '17822-4401', 'Montour', 'srobishaw@geisinger.edu', '(570) 271-8198', '(570) 271-5738', 'CPHSLA', 415, '159.240.*.*', '');
INSERT INTO `site_members` VALUES(21, 21, 'Geisinger System Services - Geisinger Wyoming Valley Medical Center', 'Susan Robishaw', 'Assistant Director', '1000 E Mountain Blvd', '0', 'Wilkes-Barre', 'PA', '18711-0027', 'Luzerne', 'srobishaw@geisinger.edu', '(570) 271-8198', '(570) 271-5738', 'CPHSLA', 182, '159.240.*.*', 'Send bills to Susan Robishaw at GMC');
INSERT INTO `site_members` VALUES(22, 22, 'Greystone Park Psychiatric Hospital', 'Mary O. Walker', 'Librarian', '59 Koch Ave', '0', 'Morris Plains', 'NJ', '07950-4400', 'Morris', 'mary.walker@dhs.state.nj.us', '(973) 538-1800 X5262', '(973) 889-8959', 'HSLANJ', 540, '', '');
INSERT INTO `site_members` VALUES(23, 23, 'Hackensack University Medical Center', 'Barbara S. Reich', 'Medical Library Director', '30 Prospect Ave', '0', 'Hackensack', 'NJ', '07601-1914', 'Bergen', 'breich@humed.com', '(201) 996-2326', '(201) 996-5547', 'HSLANJ', 696, '65.220.124.249; 69.74.36.200-2; 206.28.24.6; 65.209.106.162; 65.209.106.170', 'Send Proforma to BSR for PO Number; Invoice must be emailed to HAC A/P Office');
INSERT INTO `site_members` VALUES(24, 24, 'Hackettstown Regional Medical Center', 'Crista Minthorn', 'Educator/Magnet Coordinator', '651 Willow Grove St', '0', 'Hackettstown', 'NJ', '07840-1798', 'Warren', 'cminthor@hch.org', '(908) 979-8813', '(908) 441-1410', 'HSLANJ', 111, '10.12.32.1-255', '');
INSERT INTO `site_members` VALUES(25, 25, 'Hazleton General Hospital', 'Elaine M. Curry', 'Supervisor, Library Services', '700 E Broad St', '0', 'Hazleton', 'PA', '18201-6835', 'Luzerne', 'ecurry@ghha.org', '(570) 501-4800', '(570) 501-4840', 'HILNNEP', 150, '204.186.241.90', '');
INSERT INTO `site_members` VALUES(26, 26, 'Holy Name Medical Center', 'Keydi Boss O''Hagan', 'Medical Librarian', '718 Teaneck Rd', '0', 'Teaneck', 'NJ', '07666-4245', 'Bergen', 'k-ohagan@holyname.org', '(201) 833-3395', '(201) 530-7919', 'HSLANJ', 318, '69.74.142.131 + ID/PW access', '');
INSERT INTO `site_members` VALUES(27, 27, 'Hunterdon Medical Center', 'Jeanne Dutka', 'Medical Librarian', '2100 Wescott Dr', '0', 'Flemington', 'NJ', '08822-4603', 'Warren', 'dutka.jeanne@hunterdonhealthcare.org', '(908) 788-2579', '(908) 788-2537', 'HSLANJ', 178, '138.210.83.58', '');
INSERT INTO `site_members` VALUES(28, 28, 'Jersey City Medical Center', 'Brenda Shaw', 'Director, Medical Education', '355 Grand St', '0', 'Jersey City', 'NJ', '07203-4321', 'Hudson', 'bshaw@libertyhcs.org', '(201) 915-2403', '(201) 915-2701', 'HSLANJ', 330, '', '');
INSERT INTO `site_members` VALUES(29, 29, 'John F. Kennedy Medical Center', 'Lana Strazhnik', 'Director, Medical Library', '65 James St', '0', 'Edison', 'NJ', '08820-3947', 'Middlesex', 'lstrazhnik@solarishs.org', '(908) 668-2005', '(908) 226-4633', 'HSLANJ', 389, '65.51.38.194', '');
INSERT INTO `site_members` VALUES(30, 30, 'Kessler Foundation', 'Marita F. Delmonico', 'Medical Librarian', '1199 Pleasant Valley Way', '0', 'West Orange', 'NJ', '07052-1424', 'Essex', 'mdelmonico@kesslerfoundation.org', '(973) 324-3523', '(973) 243-6835', 'HSLANJ', 0, '173.161.156.53; 216.214.15.238', '');
INSERT INTO `site_members` VALUES(31, 31, 'Lancaster General Hospital', 'Cynthia McClellan', 'Library Director', '555 N Duke St', '0', 'Lancaster', 'PA', '17604-2250', 'Lancaster', 'cm057@lghealth.org', '(717) 544-5697', '(717) 544-4923', 'CPHSLA', 629, '170.122.*.*', '');
INSERT INTO `site_members` VALUES(32, 32, 'Lourdes Medical Center of Burlington County', 'Beth E. Murtaugh', 'Library Coordinator', '218 A Sunset Rd', '0', 'Willingboro', 'NJ', '08046-1110', 'Burlington', 'murtaughb@lourdesnet.org', '(609) 835-4140', '(609) 835-3092', 'HSLANJ', 249, '', '');
INSERT INTO `site_members` VALUES(33, 33, 'Memorial Medical Center / Conemaugh Health System', 'Kris Kalina', 'Medical Librarian', '1086 Franklin St', '0', 'Johnstown', 'PA', '15905-4305', 'Cambria', 'kkalina@conemaugh.org', '(814) 534-9413', '(814) 534-3244', 'CPHSLA', 486, '12.147.195.1-30; 12.168.247.96-126; 12.199.170.96-126', '');
INSERT INTO `site_members` VALUES(34, 34, 'Meridian Health - Jersey Shore University Medical Center', 'Catherine M. Boss', 'Coordinator, Library Services', '1945 Route 33', '0', 'Neptune', 'NJ', '07754-4859', 'Monmouth', 'cboss@meridianhealth.com', '(732) 776-4266', '(732) 776-4530', 'HSLANJ', 482, '205.172.192.254', 'Mothership for all Meridian Health Hospitals');
INSERT INTO `site_members` VALUES(35, 35, 'Meridian Health - Bayshore Community Hospital', 'Catherine M. Boss', 'Coordinator, Library Services', '727 N Beers St', '0', 'Holmdel', 'NJ', '07733-1514', 'Monmouth', 'cboss@meridianhealth.com', '(732) 776-4266', '(732) 776-4530', 'HSLANJ', 225, '205.172.192.254', 'Send all billing to Cboss at JSUMC - Onsite: Robin Maggio 732.888.7377 robin.maggio@bchs.com');
INSERT INTO `site_members` VALUES(36, 36, 'Meridian Health - Ocean Medical Center', 'Catherine M. Boss', 'Coordinator, Library Services', '425 Jack Martin Blvd', '0', 'Brick ', 'NJ', '08724-7732', 'Ocean', 'cboss@meridianhealth.com', '(732) 776-4266', '(732) 776-4530', 'HSLANJ', 281, '205.172.192.254', 'Send all billing to Cboss at JSUMC - Onsite: Suzan O''Hara 732.206.8312 sohara@meridianhealth.com');
INSERT INTO `site_members` VALUES(37, 37, 'Meridian Health - Riverview Medical Center', 'Catherine M. Boss', 'Coordinator, Library Services', '1 Riverview Plaza', '0', 'Red Bank', 'NJ', '07701-1864', 'Monmouth', 'cboss@meridianhealth.com', '(732) 776-4266', '(732) 776-4530', 'HSLANJ', 476, '205.172.192.254', 'Send all billing to Cboss at JSUMC - Onsite: Amy Edwards aedwards@meridianhealth.com');
INSERT INTO `site_members` VALUES(38, 38, 'Meridian Health - Southern Ocean Medical Center', 'Catherine M. Boss', 'Coordinator, Library Services', '1140 Route 72 West', '0', 'Manahawkin', 'NJ', '08050-2412', 'Ocean', 'cboss@meridianhealth.com', '(732) 776-4266', '(732) 776-4530', 'HSLANJ', 156, '205.172.192.254', 'Send all billing to Cboss at JSUMC - Onsite: no one');
INSERT INTO `site_members` VALUES(39, 39, 'Monmouth Medical Center', 'Colleen Mergogey', 'Director, Clinical Education', '300 Second Ave', '0', 'Long Branch', 'NJ', '07740-6303', 'Monmouth', 'cmergogey@sbhcs.com', '(732) 923-6833', '(732) 923-7973', 'HSLANJ', 325, '208.68.21.27-8; 208.68.20.27-8', 'Fred Pachman fpachman@shbcs.com');
INSERT INTO `site_members` VALUES(40, 40, 'Mountainside Hospital', 'Narmin Kurzum', 'Medical Librarian', '1 Bay Ave', '0', 'Montclair ', 'NJ', '07042-4837', 'Essex', 'narmin.kurzum@mountainsidehosp.com', '(973) 429-6240', '(973) 680-7850', 'HSLANJ', 343, '74.10.145.34-62; 209.156.154.241-6', '7% Sales Tax on Admin Fees Only');
INSERT INTO `site_members` VALUES(41, 41, 'Newark Beth Israel Medical Center', 'Tricia Reusing', 'Consulting Librarian to NBI', '201 Lyons Ave', '0', 'Newark', 'NJ', '07112-2027', 'Essex', 'preusing@sbhcs.com', '(973) 322-5052', '(973) 322-5279', 'HSLANJ', 415, '208.68.21.27-8; 208.68.20.27-8', '');
INSERT INTO `site_members` VALUES(42, 42, 'Our Lady of Lourdes Medical Center', 'Susan Cleveland', 'Library Director', '1600 Haddon Ave', '0', 'Camden', 'NJ', '08103-3101', 'Camden', 'clevelands@lourdesnet.org', '(856) 757-3548', '(856) 757-3215', 'HSLANJ', 410, '199.26.210.52', '');
INSERT INTO `site_members` VALUES(43, 43, 'Pinnacle Health System at Community General Hospital', 'Helen Houpt', 'Librarian', '4300 Londonderry Rd', '0', 'Harrisburg', 'PA', '17109-5317', 'Dauphin', 'hhoupt@pinnaclehealth.org', '(717) 657-7247', '(717) 657-7248', 'CPHSLA', 181, '198.185.241.*', 'Send bills to Helen Houpt at Pinnacle Harrisburg Hospital');
INSERT INTO `site_members` VALUES(44, 44, 'Pinnacle Health System at Harrisburg Hospital', 'Helen Houpt', 'Librarian', '111 South Front St', '0', 'Harrisburg', 'PA', '17101-2010', 'Dauphin', 'hhoupt@pinnaclehealth.org', '(717) 657-7247', '(717) 657-7248', 'CPHSLA', 389, '198.185.241.*', '');
INSERT INTO `site_members` VALUES(45, 45, 'Pocono Medical Center', 'Sharon Hrabina', 'Medical Librarian', '205 E Brown St', '0', 'East Stroudsburg', 'PA', '18301-3006', 'Monroe', 'shrabina@pmchealthsystem.org', '(570) 476-3515', '(570) 420-2580', 'CHL', 242, '209.173.13.162', '');
INSERT INTO `site_members` VALUES(46, 46, 'Princeton Health Care System', 'Louise M. Yorke', 'Manager, Library of the Health Sciences', '253 W Witherspoon St', '0', 'Princeton', 'NJ', '08540-3299', 'Mercer', 'lyorke@princetonhcs.org', '(609) 497-4487', '(609) 497-4998', 'HSLANJ', 301, '', '');
INSERT INTO `site_members` VALUES(47, 47, 'Raritan Bay Medical Center', 'Eleanor Silverman', 'Health Sciences Librarian', '530 New Brunswick Ave', '0', 'Perth Amboy', 'NJ', '08861-3654', 'Middlesex', 'esilverman18@hotmail.com', '(732) 324-5087', '(732) 324-4983', 'HSLANJ', 318, '10.10.0.*; 10.20.0.*', '');
INSERT INTO `site_members` VALUES(48, 48, 'Regional Hospital of Scranton (formerly Mercy Hospital)', 'Sr. Elizabeth Brandeth', 'Director, Library Services', '746 Jefferson Ave', '0', 'Scranton', 'PA', '18510-1697', 'Lackawanna', 'srelizabeth_brandreth@chs.net', '(570) 348-7800', '(570) 340-4871', 'HILNNEP', 224, '168.250.62.129', '');
INSERT INTO `site_members` VALUES(49, 49, 'Robert Wood Johnson University Hospital at Rahway', 'Janina Kaldan', 'Medical Librarian', '865 Stone St', '0', 'Rahway', 'NJ', '07065-2742', 'Union', 'jkaldan@rwjuhr.com', '(732) 499-6134', '(732) 499-6126', 'HSLANJ', 265, '208.251.161.193-254', '');
INSERT INTO `site_members` VALUES(50, 50, 'Saint Barnabas Medical Center', 'Tricia Reusing', 'Director, Library', '94 Old Short Hills Rd', '0', 'Livingston', 'NJ', '07039-5672', 'Essex', 'preusing@sbhcs.com', '(973) 322-5052', '(973) 322-5279', 'HSLANJ', 597, '208.68.21.27-8; 208.68.20.27-8', '');
INSERT INTO `site_members` VALUES(51, 51, 'Saint Barnabas Health Care System', 'Tricia Reusing', 'Director, Library', '95 Old Short Hills Rd', '0', 'West Orange', 'NJ', '07052-1008', 'Essex', 'preusing@sbhcs.com', '(973) 322-5052', '(973) 322-5279', 'NJHA', 0, '208.68.21.21-8; 208.68.20.27-8', 'Site License for all SBHCS Hospitals: Clara Maass, Community, Kimball, Monmouth, Newark Beth Israel, & SBMC');
INSERT INTO `site_members` VALUES(52, 0, 'Saint Clare''s Hospital', 'Joan DeRogatis', 'Librarian', '25 Pocono Rd', '0', 'Denville', 'NJ', '07834-2954', 'Morris', 'joanderogatis@saintclares.org', '(973) 625-6547', '(973) 625-6678', 'NJHA', 427, '', '');
INSERT INTO `site_members` VALUES(53, 52, 'Saint Peter''s University Hospital', 'Jeannine Creazzo', 'Manager, Library Services', '254 Easton Ave', '0', 'New Brunswick', 'NJ', '08901-1766', 'Middlesex', 'jcreazzo@saintpetersuh.com', '(732) 745-6647', '(732) 937-6091', 'HSLANJ', 478, '65.51.94.15-23', '');
INSERT INTO `site_members` VALUES(54, 53, 'Somerset Medical Center', 'Karen Wenk', 'Medical Librarian', '110 Rehill Ave', '0', 'Somerville', 'NJ', '08876-2519', 'Middlesex', 'kwenk@somerset-healthcare.com', '(908) 685-2423', '(908) 685-2869', 'HSLANJ', 355, '74.9.22.*; 65.200.139.130', '');
INSERT INTO `site_members` VALUES(55, 54, 'St. Francis Hospital - Wilmington', 'Rosemary Figorito', 'Medical Librarian', '701 N Clayton St', '0', 'Wilmington', 'DE', '19805-3165', 'New Castle', 'rfigorito@che-east.org', '(302) 421-4834', '', 'DelMIRA', 120, '', '');
INSERT INTO `site_members` VALUES(56, 55, 'St. Francis Medical Center - Trenton', 'Donna Barlow', 'Librarian', '601 Hamilton Ave', '0', 'Trenton', 'NJ', '08629-1915', 'Mercer', 'dbarlow@stfrancismedical.org', '(609) 599-5068', '(609) 599-5773', 'HSLANJ', 238, '', '');
INSERT INTO `site_members` VALUES(57, 56, 'St. Joseph''s Regional Medical Center', 'Patricia May', 'Director of Library Services', '701 Main St', '0', 'Paterson', 'NJ', '07503-2621', 'Passaic', 'mayp@sjhmc.org', '(973) 754-3592', '(973) 754-3593', 'HSLANJ', 517, '130.156.80-4.*; 207.79.184-5.*', '');
INSERT INTO `site_members` VALUES(58, 57, 'St. Mary Medical Center', 'Jacqueline Luizzi', 'Medical Librarian', '1201 Langhorne Newtown Rd', '0', 'Langhorne', 'PA', '19047-1201', 'Bucks', 'jluizzi@stmaryhealthcare.org', '(215) 710-2012', '(215) 710-4638', 'Devic', 374, '199.26.210.48', '');
INSERT INTO `site_members` VALUES(59, 58, 'St. Michael''s Medical Center', 'Peter Cole', 'Director, Medical Library', '111 Central Ave', '0', 'Newark', 'NJ', '07102-1909', 'Essex', 'pcole@smmcnj.org', '(973) 877-5471', '(973) 877-5378', 'HSLANJ', 266, '69.74.239.2; 69.74.217.130; 63.138.173.35; 67.151.56.66-7; 69.74.217.155; 69.74.230.178; 209.50.160.68; 209.50.160.87', '');
INSERT INTO `site_members` VALUES(60, 59, 'Susquehanna Health - Williamsport Hospital', 'Michael Heyd', 'Director, Medical Library', '777 Rural Ave', '0', 'Williamsport', 'PA', '17701-3109', 'Lycoming', 'mheyd@susquehannahealth.org', '(570) 321-2266', '(570) 321-2271', 'CPHSLA', 135, '72.55.42.68', '');
INSERT INTO `site_members` VALUES(61, 60, 'Susquehanna Health - Divine Providence Hospital', 'Michael Heyd', 'Director, Medical Library', '1100 Grampian Blvd', '0', 'Williamsport', 'PA', '17701-1909', 'Lycoming', 'mheyd@susquehannahealth.org', '(570) 321-2266', '(570) 321-2271', 'CPHSLA', 13, '72.55.42.68', 'Send bills to Mike Heyd at Wmsport Hospital');
INSERT INTO `site_members` VALUES(62, 61, 'Susquehanna Health - Muncy Valley Hospital', 'Michael Heyd', 'Director, Medical Library', '215 E Water St', '0', 'Muncy', 'PA', '17756-8828', 'Lycoming', 'mheyd@susquehannahealth.org', '(570) 321-2266', '(570) 321-2771', 'CPHSLA', 12, '72.55.42.68', 'Send bills to Mike Heyd at Wmsport Hospital');
INSERT INTO `site_members` VALUES(63, 62, 'Valley Hospital, The', 'Claudia Allocco', 'Director of Library Services', '223 N Van Dien Ave', '0', 'Ridgewood', 'NJ', '07450-2726', 'Bergen', 'callocc@valleyhealth.com', '(201) 447-8285', '(201) 447-8602', 'HSLANJ', 451, '', '');
INSERT INTO `site_members` VALUES(64, 63, 'Virtua Health System - Berlin', 'Maura Sostack', 'Medical Librarian', '100 Townsend Ave', '0', 'Berlin', 'NJ', '08009-9011', 'Camden', 'msostack@virtua.org', '(609) 914-6879', '(609) 267-8073', 'HSLANJ', 0, '', 'Send all bills to Maura Sostack at Memorial');
INSERT INTO `site_members` VALUES(65, 64, 'Virtua Health System - Marlton', 'Maura Sostack', 'Medical Librarian', '90 Brick Rd', '0', 'Marlton', 'NJ', '08053-2177', 'Burlington', 'msostack@virtua.org', '(609) 914-6879', '(609) 267-8073', 'HSLANJ', 0, '', 'Send all bills to Maura Sostack at Memorial');
INSERT INTO `site_members` VALUES(66, 65, 'Virtua Health Sytem - Memorial', 'Maura Sostack', 'Medical Librarian', '175 Madison Ave', '0', 'Mount Holly', 'NJ', '08060-2038', 'Burlington', 'msostack@virtua.org', '(609) 914-6879', '(609) 267-8073', 'HSLANJ', 1052, '170.184.81.34; 170.184.45.3; 170.184.0.0/16 - Virtua owns entire 170.184.0.0/16 subnet', '');
INSERT INTO `site_members` VALUES(67, 66, 'Virtua Health System - Voorhees', 'Maura Sostack', 'Medical Librarian', '101 Carnie Blvd', '0', 'Voorhees', 'NJ', '08043-1548', 'Camden', 'msostack@virtua.org', '(609) 914-6879', '(609) 267-8073', 'HSLANJ', 0, '', 'Send all bills to Maura Sostack at Memorial');
INSERT INTO `site_members` VALUES(68, 67, 'Wyoming Valley Health Care System', 'Rosemarie Taylor', 'Manager, Library Services', '575 N River St', '0', 'Wilkes-Barre', 'PA', '18764-0999', 'Luzerne', 'rtaylor@wvhcs.org', '(570) 552-1175', '(570) 552-1183', 'HILNNEP', 392, '64.9.76.229; 209.74.22.34', 'Ovid will bill an additional $1,795 for additional resources; bill with with NO admin fee');
INSERT INTO `site_members` VALUES(69, 68, 'York Hospital - Wellspan', 'Sue Shultz', 'Director, Library Services', '1001 S George St', '0', 'York', 'PA', '17405-3676', 'York', 'sshultz@wellspan.org', '(717) 851-2495', '(717) 851-2487', 'CPHSLA', 550, '207.181.180.2', '');
