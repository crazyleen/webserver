
DROP DATABASE IF EXISTS `hce`;
CREATE DATABASE `hce`;
USE `hce`;
DROP TABLE IF EXISTS `t_hce_user`;
CREATE TABLE `t_hce_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productno` varchar(16) COLLATE utf8_spanish_ci NOT NULL COMMENT '主帐号',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'HCE支付开关',
  `create_time` int unsigned NOT NULL,
  `update_time` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `productno` (`productno`)
) ENGINE=InnoDB AUTO_INCREMENT=100000001 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `t_hce_client`;
CREATE TABLE `t_hce_client` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户',
  `sessionkey` varchar(128) DEFAULT NULL,
  `imei` varchar(32) COLLATE utf8_spanish_ci NOT NULL COMMENT '设备唯一编号',
  `access_token` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `auth` tinyint(1) NOT NULL DEFAULT '0' COMMENT '授权',
  `desc` varchar(128) DEFAULT NULL COMMENT '描述',
  `create_time` int unsigned NOT NULL,
  `update_time` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `access_token` (`access_token`),
  KEY `imei` (`imei`, `user_id`),
  KEY `user_id` (`user_id`, `imei`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `t_hce_client_log`;
CREATE TABLE `t_hce_client_log` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `client_id` int(11) unsigned NOT NULL COMMENT 'client ID',
  `type` int(4) unsigned NOT NULL COMMENT 'log type, 0.open, 1.close, 2.nfc, 3.posp',
  `create_time` int unsigned NOT NULL,
  `update_time` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `access_token` (`access_token`),
  KEY `imei` (`imei`, `user_id`),
  KEY `user_id` (`user_id`, `imei`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;