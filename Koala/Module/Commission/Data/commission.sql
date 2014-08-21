CREATE TABLE IF NOT EXISTS `[TABLE_PREX]commission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(22) NOT NULL COMMENT '佣金所有人',
  `amount` varchar(20) NOT NULL DEFAULT '0.00' COMMENT '可用佣金总额',
  `unsettle` varchar(20) NOT NULL DEFAULT '0.00' COMMENT '未结算佣金',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='佣金表' AUTO_INCREMENT=1 ;