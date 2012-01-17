-- phpMyAdmin SQL Dump
-- version 3.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 17, 2012 at 03:56 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `monev_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(40) NOT NULL,
  `passwd` char(32) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `jabid` int(4) NOT NULL,
  `kdsatker` varchar(10) DEFAULT NULL,
  `kdunit` varchar(10) DEFAULT NULL,
  `kddept` varchar(10) DEFAULT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  `status` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jabid` (`jabid`),
  KEY `kdsatker` (`kdsatker`,`kdunit`,`kddept`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `userid`, `passwd`, `nama`, `jabid`, `kdsatker`, `kdunit`, `kddept`, `start_time`, `end_time`, `email`, `no_hp`, `status`) VALUES
(1, 'satker', '418b6672efe440cdce92f2f1233f9815', 'Satker 1', 1, '411880', '12', '015', '2012-04-25', '2012-06-24', '', '', 'Y'),
(4, 'eselon', 'add3f39f0540d2f0c2235ab688aa2d37', 'Eselon I', 2, NULL, '12', '015', '0000-00-00', '0000-00-00', '', '', 'Y'),
(5, 'kementrian', '2ba94503f9d48468b8610a916e6a2079', 'Kementrian I', 3, NULL, NULL, '015', '0000-00-00', '0000-00-00', '', '', 'Y'),
(6, 'dja', 'aa939d032327c8399cf2851d5b0201ed', 'DJA', 4, NULL, NULL, NULL, '0000-00-00', '0000-00-00', '', '', 'Y');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `fk_jabid` FOREIGN KEY (`jabid`) REFERENCES `tb_jabatan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
