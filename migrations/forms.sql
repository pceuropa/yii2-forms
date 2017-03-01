-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS `forms` (
`form_id` int(11) NOT NULL,
  `body` text,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `maximum` int(11) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `response` text
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

ALTER TABLE `forms` ADD PRIMARY KEY (`form_id`), ADD UNIQUE KEY `url-unique` (`url`);
ALTER TABLE `forms` MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
