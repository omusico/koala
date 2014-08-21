CREATE TABLE IF NOT EXISTS `[TABLE_PREX]invitation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invitor` varchar(20) NOT NULL COMMENT '邀请人',
  `invited` varchar(20) DEFAULT NULL COMMENT '被邀请人',
  `isvalid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有效',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '邀请类型',
  `maketime` varchar(22) DEFAULT NULL COMMENT '生成时间',
  `url` varchar(500) DEFAULT NULL COMMENT '邀请链接',
  `code` varchar(100) DEFAULT NULL COMMENT '邀请码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='邀请关系记录表' AUTO_INCREMENT=1 ;