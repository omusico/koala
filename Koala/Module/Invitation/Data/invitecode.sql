CREATE TABLE IF NOT EXISTS `[TABLE_PREX]invitecode` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `code` varchar(32) NOT NULL COMMENT '邀请码',
  `isvalid` int(11) NOT NULL COMMENT 'isvalid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='邀请码' AUTO_INCREMENT=1 ;