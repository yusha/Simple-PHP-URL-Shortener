CREATE TABLE IF NOT EXISTS `url_shorten` (
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `url` tinytext NOT NULL,
 `short_code` varchar(50) NOT NULL,
 `hits` int(11) NOT NULL,
 `added_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
