CREATE TABLE IF NOT EXISTS `views` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `view_date` datetime NOT NULL,
  `views_count` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_address_user_agent_page_url` (`ip_address`,`user_agent`,`page_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
