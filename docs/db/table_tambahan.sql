-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 11, 2012 at 06:33 AM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_monev`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_efisiensi`
--

CREATE TABLE IF NOT EXISTS `tb_efisiensi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thang` varchar(4) DEFAULT NULL,
  `bulan` varchar(12) DEFAULT NULL,
  `e` decimal(10,2) DEFAULT NULL,
  `kddept` varchar(10) DEFAULT NULL,
  `kdunit` varchar(10) DEFAULT NULL,
  `kdsatker` varchar(12) NOT NULL,
  `kdprogram` varchar(10) DEFAULT NULL,
  `kdgiat` varchar(10) DEFAULT NULL,
  `submitdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `e` (`e`),
  KEY `kdsatker` (`kdsatker`),
  KEY `kddept` (`kddept`,`kdunit`,`kdprogram`,`kdgiat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keluaran`
--

CREATE TABLE IF NOT EXISTS `tb_keluaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thang` varchar(4) DEFAULT NULL,
  `bulan` varchar(12) DEFAULT NULL,
  `pk` decimal(10,2) DEFAULT NULL,
  `kddept` varchar(10) DEFAULT NULL,
  `kdunit` varchar(10) DEFAULT NULL,
  `kdsatker` varchar(12) NOT NULL,
  `kdprogram` varchar(10) DEFAULT NULL,
  `kdgiat` varchar(10) DEFAULT NULL,
  `submitdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pk` (`pk`),
  KEY `kdsatker` (`kdsatker`),
  KEY `kddept` (`kddept`,`kdunit`,`kdprogram`,`kdgiat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_konsistensi`
--

CREATE TABLE IF NOT EXISTS `tb_konsistensi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thang` varchar(4) DEFAULT NULL,
  `bulan` varchar(12) DEFAULT NULL,
  `k` decimal(10,2) DEFAULT NULL,
  `kddept` varchar(10) DEFAULT NULL,
  `kdunit` varchar(10) DEFAULT NULL,
  `kdsatker` varchar(12) NOT NULL,
  `kdprogram` varchar(10) DEFAULT NULL,
  `submitdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `k` (`k`),
  KEY `kdsatker` (`kdsatker`),
  KEY `kddept` (`kddept`,`kdunit`,`kdprogram`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
