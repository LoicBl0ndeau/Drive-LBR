-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 10, 2022 at 08:26 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lbr`
--

-- --------------------------------------------------------

--
-- Table structure for table `caractériser`
--

DROP TABLE IF EXISTS `caractériser`;
CREATE TABLE IF NOT EXISTS `caractériser` (
  `Id_fichier` int(11) NOT NULL,
  `Id_Tag` int(11) NOT NULL,
  PRIMARY KEY (`Id_fichier`,`Id_Tag`),
  KEY `Id_Tag` (`Id_Tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `catégorie`
--

DROP TABLE IF EXISTS `catégorie`;
CREATE TABLE IF NOT EXISTS `catégorie` (
  `Id_Catégorie` int(11) NOT NULL AUTO_INCREMENT,
  `Lieu` varchar(50) DEFAULT NULL,
  `Edition` varchar(50) DEFAULT NULL,
  `Autre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Catégorie`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fichier`
--

DROP TABLE IF EXISTS `fichier`;
CREATE TABLE IF NOT EXISTS `fichier` (
  `Id_fichier` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(50) DEFAULT NULL,
  `Titre` varchar(50) NOT NULL,
  `Auteur` varchar(50) DEFAULT NULL,
  `Taille` varchar(50) DEFAULT NULL,
  `Date_de_publication` date DEFAULT NULL,
  `Commentaire` varchar(50) DEFAULT NULL,
  `bin` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id_fichier`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fichier`
--

INSERT INTO `fichier` (`Id_fichier`, `Type`, `Titre`, `Auteur`, `Taille`, `Date_de_publication`, `Commentaire`, `bin`) VALUES
(1, NULL, 'Première_photo', NULL, NULL, NULL, NULL, NULL),
(2, 'image/jpeg', '20220603_231949.jpg', 'Louis Boubert', '2561729', NULL, NULL, 'upload/2/20220603_231949.jpg'),
(3, 'image/jpeg', '20220603_231949.jpg', 'Louis Boubert', '2561729', NULL, NULL, 'upload/3/20220603_231949.jpg'),
(4, 'image/jpeg', 'anthony-delanoix-hzgs56Ze49s-unsplash.jpg', 'Louis Boubert', '1744118', NULL, NULL, 'upload/4/anthony-delanoix-hzgs56Ze49s-unsplash.jpg'),
(5, 'image/jpeg', 'joey-thompson-4zN_-PKsbWw-unsplash.jpg', 'Louis Boubert', '1418428', NULL, NULL, 'upload/5/joey-thompson-4zN_-PKsbWw-unsplash.jpg'),
(6, 'video/mp4', 'BLONDEAU_DRIVE.mp4', 'Louis Boubert', '24627082', NULL, NULL, 'upload/6/BLONDEAU_DRIVE.mp4'),
(7, 'image/jpeg', '20220603_231949.jpg', 'Louis Boubert', '2561729', NULL, NULL, 'upload/7/20220603_231949.jpg'),
(8, 'image/jpeg', '20220603_231949.jpg', 'Louis Boubert', '2561729', NULL, NULL, 'upload/8/20220603_231949.jpg'),
(9, 'image/jpeg', '20220603_231949.jpg', 'Louis Boubert', '2561729', NULL, NULL, 'upload/9/20220603_231949.jpg'),
(10, 'image/jpeg', '20220603_231949.jpg', 'Louis Boubert', '2561729', NULL, NULL, 'upload/10/20220603_231949.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `gérer`
--

DROP TABLE IF EXISTS `gérer`;
CREATE TABLE IF NOT EXISTS `gérer` (
  `Id_Profil` int(11) NOT NULL,
  `Id_Tag` int(11) NOT NULL,
  PRIMARY KEY (`Id_Profil`,`Id_Tag`),
  KEY `Id_Tag` (`Id_Tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_`
--

DROP TABLE IF EXISTS `log_`;
CREATE TABLE IF NOT EXISTS `log_` (
  `Id_Log_` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) DEFAULT NULL,
  `Date_de_modification` varchar(50) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Log_`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `Id_Profil` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `MDP` varchar(100) DEFAULT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Profil`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`Id_Profil`, `email`, `MDP`, `Nom`, `Prenom`, `Description`, `Role`) VALUES
(1, 'louis.boubert.26@gmail.com', 'f2d81a260dea8a100dd517984e53c56a7523d96942a834b9cdc249bd4e8c7aa9', 'Boubert', 'Louis', 'premier profil', 'Admin'),
(3, 'capellemartin.27@gmail.com', '119511946f7c081e3050a2be01c9124b1b984efb455656c107b2ec056496c4ee', 'Capelle', 'Martin', 'Administrateur de création', 'Admin'),
(4, 'loic.blondeau@student.junia.com', '4bed74a357375b2892d4bcc91e6d511d20b5b021e4566c665eb686a3006ed585', 'Blondeau', 'Loïc', 'Administrateur de création', 'Admin'),
(5, 'iliesbenslama11@gmail.com', '11b44c52faf329051084b393388af64127479a221470e937dbfcba7417fa5f63', 'Benslama', 'Ilies', 'Administrateur de création', 'Admin'),
(7, 'test@test.test', NULL, 'test', 'test', 'test', 'Visiteur');

-- --------------------------------------------------------

--
-- Table structure for table `publier_modifier`
--

DROP TABLE IF EXISTS `publier_modifier`;
CREATE TABLE IF NOT EXISTS `publier_modifier` (
  `Id_Profil` int(11) NOT NULL,
  `Id_fichier` int(11) NOT NULL,
  PRIMARY KEY (`Id_Profil`,`Id_fichier`),
  KEY `Id_fichier` (`Id_fichier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `Id_Tag` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) DEFAULT NULL,
  `Créateur` varchar(50) DEFAULT NULL,
  `Id_Catégorie` int(11) NOT NULL,
  PRIMARY KEY (`Id_Tag`),
  KEY `Id_Catégorie` (`Id_Catégorie`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
