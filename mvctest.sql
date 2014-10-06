SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `mvctest` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mvctest`;

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parents` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parentAndAlias` (`parents`(255),`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

TRUNCATE TABLE `category`;
INSERT INTO `category` (`id`, `parents`, `name`, `alias`, `description`) VALUES
(1, '/', 'Категория 1', 'category1', 'Категория 1'),
(2, '/', 'Категория 2', 'category2', 'Категория 2'),
(3, '/', 'Категория 3', 'category3', 'Категория 3'),
(4, '/', 'Категория 4', 'category4', 'Категория 4'),
(5, '/category2/', 'Подкатегория 1', 'subcategory1', 'Подкатегория 1'),
(6, '/category2/', 'Подкатегория 2', 'subcategory2', 'Подкатегория 2'),
(7, '/category2/subcategory1/', 'Подкатегория 3', 'subcategory3', 'Подкатегория 3'),
(8, '/category2/subcategory1/', 'Подкатегория 4', 'subcategory4', 'Подкатегория 4'),
(9, '/category2/subcategory1/', 'Подкатегория 5', 'subcategory5', 'Подкатегория 5');

CREATE TABLE IF NOT EXISTS `prodcat` (
  `productId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  UNIQUE KEY `productId` (`productId`,`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `prodcat`;
INSERT INTO `prodcat` (`productId`, `categoryId`) VALUES
(1, 7),
(2, 7),
(3, 7);

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

TRUNCATE TABLE `product`;
INSERT INTO `product` (`id`, `name`, `alias`, `description`, `price`) VALUES
(1, 'Товар 1', 'tovar1', 'Товар 1', 10),
(2, 'Товар 2', 'tovar2', 'Товар 2', 20),
(3, 'Товар 3', 'tovar3', 'Товар 3', 30);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
