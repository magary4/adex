CREATE TABLE `customer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
);

INSERT INTO `customer` VALUES (1,'Big News Media Corp',1),(2,'Online Mega Store',1),(3,'Nachoroo Delivery',0),(4,'Euro Telecom Group',1);

CREATE TABLE `ad_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `customer_idx` (`customer_id`),
  CONSTRAINT `ad_tag_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
);

INSERT INTO `ad_tag` VALUES (1,1,'Spring Campaign',1),(2,2,'Generic Tag',0),(3,3,'Summer Sale',1),(4,2,'Second Tag',1),(5,1,'New Campaign Tag',1);

CREATE TABLE `ip_blacklist` (
  `ip` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ip`)
);

INSERT INTO `ip_blacklist` VALUES (INET_ATON('0.0.0.0')),(INET_ATON('127.0.0.1')),(INET_ATON('255.255.255.255'));

CREATE TABLE `hourly_stats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) unsigned NOT NULL,
  `time` timestamp NOT NULL,
  `request_count` bigint(20) unsigned NOT NULL DEFAULT '0',
  `invalid_count` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_customer_time` (`customer_id`,`time`),
  KEY `customer_idx` (`customer_id`),
  CONSTRAINT `hourly_stats_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
);