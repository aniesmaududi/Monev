-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 20, 2012 at 11:21 AM
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
-- Table structure for table `tb_catatan_eselon`
--

DROP TABLE IF EXISTS `tb_catatan_eselon`;
CREATE TABLE IF NOT EXISTS `tb_catatan_eselon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kdunit` varchar(10) NOT NULL,
  `kddept` varchar(10) NOT NULL,
  `catatan` text NOT NULL,
  `tglupdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kdsatker` (`kdunit`,`kddept`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_catatan_eselon`
--

INSERT INTO `tb_catatan_eselon` (`id`, `kdunit`, `kddept`, `catatan`, `tglupdate`) VALUES
(1, '11', '015', 'teyteytrnjhg kjhgkjh kjhkjh kjh kjh kj', '2012-01-20 07:49:02');

-- --------------------------------------------------------

--
-- Table structure for table `tb_catatan_kl`
--

DROP TABLE IF EXISTS `tb_catatan_kl`;
CREATE TABLE IF NOT EXISTS `tb_catatan_kl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kddept` varchar(10) NOT NULL,
  `catatan` text NOT NULL,
  `tglupdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kddept` (`kddept`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_catatan_kl`
--

INSERT INTO `tb_catatan_kl` (`id`, `kddept`, `catatan`, `tglupdate`) VALUES
(1, '015', 'adsdwerwer werw erwerwe', '2012-01-20 08:36:08');

-- --------------------------------------------------------

--
-- Table structure for table `tb_catatan_satker`
--

DROP TABLE IF EXISTS `tb_catatan_satker`;
CREATE TABLE IF NOT EXISTS `tb_catatan_satker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kdsatker` varchar(10) NOT NULL,
  `kdunit` varchar(10) NOT NULL,
  `kddept` varchar(10) NOT NULL,
  `catatan` text NOT NULL,
  `tglupdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kdsatker` (`kdsatker`,`kdunit`,`kddept`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tb_catatan_satker`
--

INSERT INTO `tb_catatan_satker` (`id`, `kdsatker`, `kdunit`, `kddept`, `catatan`, `tglupdate`) VALUES
(1, '675713', '11', '015', '- membutuhkan latihan\n- membutuhkan pasokan logistik', '2012-01-20 05:58:22'),
(2, '675713', '11', '015', 'asdasd asdasd ', '2012-01-20 06:14:54'),
(3, '675713', '11', '015', 'asdasda asdasd a asd asd ', '2012-01-20 11:18:16');
