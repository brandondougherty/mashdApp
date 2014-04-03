
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL auto_increment,
  `md5_id` varchar(200) collate latin1_general_ci NOT NULL default '',
  `user_email` varchar(220) collate latin1_general_ci NOT NULL default '',
  `pwd` varchar(220) collate latin1_general_ci NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `users_ip` varchar(200) collate latin1_general_ci NOT NULL default '',
  `banned` int(1) NOT NULL default '0',
  `ckey` varchar(220) collate latin1_general_ci NOT NULL default '',
  `ctime` varchar(220) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_email` (`user_email`),
  FULLTEXT KEY `idx_search` (`full_name`,`address`,`user_email`,`user_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=55 ;


INSERT INTO `users` VALUES (54, '', 'admin', 'admin', 'admin@localhost', 5, '4c09e75fa6fe36038ac240e9e4e0126cedef6d8c85cf0a1ae', 'admin', 'Switzerland', '4433093999', '', '', 0x323031302d30352d3034, '', 1, 0, 0, 'uqd1y4v', '1272992243');
        