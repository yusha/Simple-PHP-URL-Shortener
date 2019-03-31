# Simple-PHP-URL-Shortener
A Simple PHP Script for URL shortening 

Installation:

Create a database with a user and run this sql 

`CREATE TABLE IF NOT EXISTS `url_shorten` (
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `url` tinytext NOT NULL,
 `short_code` varchar(50) NOT NULL,
 `hits` int(11) NOT NULL,
 `added_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
`

Copy the index.php file to your domain or subdomain root directory and change the db name, username and password.

You can add additional protection to make the page private.
