-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 11 april 2012 kl 15:34
-- Serverversion: 5.1.37
-- PHP-version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `reminder_db`
--

-- --------------------------------------------------------

--
-- Struktur för tabell `reminder`
--

CREATE TABLE IF NOT EXISTS `reminder` (
  `reminder_id` int(11) NOT NULL AUTO_INCREMENT,
  `reminder_title` text NOT NULL,
  `reminder_remindme` datetime NOT NULL,
  PRIMARY KEY (`reminder_id`),
  KEY `reminder_id` (`reminder_id`),
  KEY `reminder_id_2` (`reminder_id`),
  KEY `reminder_id_3` (`reminder_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Data i tabell `reminder`
--

INSERT INTO `reminder` (`reminder_id`, `reminder_title`, `reminder_remindme`) VALUES
(3, 'Reminds you what to do...', '2012-04-11 15:42:09'),
(5, 'Reminds you what to do... Reminds you what to do...', '2012-04-11 15:42:09'),
(7, 'have a party in stockholm', '2012-04-11 12:04:07');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
