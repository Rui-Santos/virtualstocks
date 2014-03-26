DROP TABLE IF EXISTS `vs_depot`;
CREATE TABLE `vs_depot` (
  `depot_number` int(11) NOT NULL,
  `depot_password` varchar(255) NOT NULL,
  `depot_mail` varchar(95) NOT NULL,
  `depot_balance` float(11,2) NOT NULL,
  `depot_statement` float(11,2) NOT NULL,
  PRIMARY KEY (`depot_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `vs_depot_order`;
CREATE TABLE `vs_depot_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_depot_number` int(11) NOT NULL,
  `order_type` varchar(12) NOT NULL,
  `order_exchange` varchar(2) NOT NULL,
  `order_symbol` varchar(4) NOT NULL,
  `order_amount` int(11) NOT NULL,
  `order_limit` float(7,2) NOT NULL,
  `order_date` int(11) NOT NULL,
  `order_valid_date` int(11) NOT NULL,
  `order_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`order_id`),
  KEY `order_depot_number` (`order_depot_number`),
  CONSTRAINT `vs_depot_order_ibfk_1` FOREIGN KEY (`order_depot_number`) REFERENCES `vs_depot` (`depot_number`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `vs_forex`;
CREATE TABLE `vs_forex` (
  `forex_from` varchar(3) NOT NULL,
  `forex_to` varchar(3) NOT NULL,
  `forex_rate` float(5,2) NOT NULL,
  `forex_date` int(11) NOT NULL,
  PRIMARY KEY (`forex_from`,`forex_to`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `vs_interest`;
CREATE TABLE `vs_interest` (
  `depot_number` int(11) NOT NULL,
  `depot_valuta` float(11,2) NOT NULL,
  `depot_date` int(11) NOT NULL,
  KEY `depot_number` (`depot_number`),
  CONSTRAINT `vs_interest_ibfk_1` FOREIGN KEY (`depot_number`) REFERENCES `vs_depot` (`depot_number`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `vs_stock`;
CREATE TABLE `vs_stock` (
  `stock_symbol` varchar(4) NOT NULL,
  `stock_isin` varchar(12) NOT NULL,
  `stock_qualified_name` varchar(85) NOT NULL,
  `stock_short_name` varchar(55) NOT NULL,
  `stock_category` tinyint(2) NOT NULL,
  `stock_country_iso` varchar(2) NOT NULL,
  PRIMARY KEY (`stock_symbol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `vs_depot_stock`;
CREATE TABLE `vs_depot_stock` (
  `depot_number` int(11) NOT NULL,
  `stock_symbol` varchar(4) NOT NULL,
  `stock_amount` int(11) NOT NULL,
  PRIMARY KEY (`depot_number`,`stock_symbol`),
  KEY `stock_symbol` (`stock_symbol`),
  CONSTRAINT `vs_depot_stock_ibfk_1` FOREIGN KEY (`depot_number`) REFERENCES `vs_depot` (`depot_number`) ON DELETE CASCADE,
  CONSTRAINT `vs_depot_stock_ibfk_2` FOREIGN KEY (`stock_symbol`) REFERENCES `vs_stock` (`stock_symbol`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `vs_stock_category`;
CREATE TABLE `vs_stock_category` (
  `category_id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(65) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `vs_stock_exchange`;
CREATE TABLE `vs_stock_exchange` (
  `stock_symbol` varchar(4) NOT NULL,
  `stock_exchange` varchar(2) NOT NULL,
  PRIMARY KEY (`stock_symbol`,`stock_exchange`),
  CONSTRAINT `vs_stock_exchange_ibfk_2` FOREIGN KEY (`stock_symbol`) REFERENCES `vs_stock` (`stock_symbol`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `vs_stock_rate`;
CREATE TABLE `vs_stock_rate` (
  `stock_symbol` varchar(4) NOT NULL,
  `stock_exchange` varchar(2) NOT NULL,
  `stock_rate` float(6,2) NOT NULL,
  `stock_rate_timestamp` int(11) NOT NULL,
  PRIMARY KEY (`stock_symbol`,`stock_exchange`,`stock_rate_timestamp`),
  CONSTRAINT `vs_stock_rate_ibfk_2` FOREIGN KEY (`stock_symbol`) REFERENCES `vs_stock` (`stock_symbol`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;