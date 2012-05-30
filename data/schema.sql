CREATE TABLE IF NOT EXISTS `mtdtt_session` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `mtdtt_session_split` (
  `session_id` int(11) NOT NULL,
  `split_time` int(11) NOT NULL,
  `type` enum('pause','resume','project') NOT NULL,
  PRIMARY KEY (`session_id`,`split_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
