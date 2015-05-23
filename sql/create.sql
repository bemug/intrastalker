SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `mutex` (
  `version` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `pc` (
  `name` varchar(10) NOT NULL,
  `version` varchar(256) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  PRIMARY KEY (`name`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user` (
  `name` varchar(26) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `w` (
  `user` varchar(32) NOT NULL,
  `tty` varchar(32) NOT NULL,
  `connected_from` varchar(32) NOT NULL,
  `logina` varchar(32) NOT NULL,
  `idle` varchar(32) NOT NULL,
  `jcpu` varchar(32) NOT NULL,
  `pcpu` varchar(32) NOT NULL,
  `what` varchar(256) NOT NULL,
  `pc_name` varchar(10) NOT NULL,
  `version` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
