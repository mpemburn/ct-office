CREATE TABLE `site_audit_log` ( 
	`audit_id` int(11) NOT NULL AUTO_INCREMENT, 
	`change_date` datetime DEFAULT NULL, 
	`table_name` varchar(50) DEFAULT NULL, 
	`key_field` varchar(50) DEFAULT NULL, 
	`key_value` varchar(50) DEFAULT NULL, 
	`sub_key_field` varchar(50) DEFAULT NULL, 
	`sub_key_value` varchar(50) DEFAULT NULL, 
	`field_name` varchar(50) DEFAULT NULL, 
	`field_label` varchar(50) DEFAULT NULL, 
	`change_from` longtext, 
	`change_to` longtext, 
	`user_id` varchar(10) DEFAULT NULL, 
	KEY `audit_id` (`audit_id`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; 