-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 03 2012 г., 01:55
-- Версия сервера: 5.1.63
-- Версия PHP: 5.3.5-1ubuntu7.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `stuzo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `parent_id`, `name`) VALUES
(1, 0, 'Electronics'),
(2, 0, 'Video'),
(3, 0, 'Photo'),
(4, 1, 'MP3 player'),
(5, 1, 'TV'),
(6, 4, 'iPod'),
(7, 6, 'Shuffle'),
(8, 3, 'SLR'),
(9, 8, 'DSLR'),
(10, 9, 'Nikon'),
(11, 9, 'Canon'),
(12, 11, '20D');

-- --------------------------------------------------------

--
-- Структура таблицы `parens`
--

CREATE TABLE IF NOT EXISTS `parens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_name` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `parens`
--

INSERT INTO `parens` (`id`, `parent_name`) VALUES
(1, 'Name_1'),
(3, 'Name_3'),
(4, 'Name_4'),
(6, 'Name_6'),
(8, 'Name_8'),
(9, 'Name_9'),
(11, 'Name_11');
