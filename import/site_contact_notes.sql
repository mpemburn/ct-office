CREATE TABLE `site_contact_notes` ( 
	`note_id` int(11) NOT NULL AUTO_INCREMENT, 
	`entity_id` varchar(15) DEFAULT NULL, 
	`entity_type` varchar(50) DEFAULT NULL, 
	`contact_date` datetime DEFAULT NULL, 
	`return_call` int(11) DEFAULT NULL, 
	`return_call_date` date DEFAULT NULL, 
	`return_status` smallint(6) DEFAULT NULL, 
	`forward_call` int(11) DEFAULT NULL, 
	`note_text` longtext, 
	`attachment_path` varchar(255) DEFAULT NULL, 
	`user_id` varchar(10) DEFAULT NULL, 
	`deleted` tinyint(4) NOT NULL DEFAULT '0', 
	`deleted_by` varchar(20) DEFAULT NULL, 
	`deleted_date` datetime DEFAULT NULL, 
	`privileged` tinyint(4) DEFAULT '0', 
	KEY `note_id` (`note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; 