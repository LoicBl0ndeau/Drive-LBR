-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 juin 2022 à 19:19
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lbr`
--

-- --------------------------------------------------------

--
-- Structure de la table `caractériser`
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
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `Id_Catégorie` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  `Créateur` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Catégorie`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`Id_Catégorie`, `Nom`, `Créateur`) VALUES
(0, 'Autre', '1'),
(1, 'Edition', '1'),
(2, 'Lieu', '1');

-- --------------------------------------------------------

--
-- Structure de la table `fichier`
--

DROP TABLE IF EXISTS `fichier`;
CREATE TABLE IF NOT EXISTS `fichier` (
  `Id_fichier` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(50) DEFAULT NULL,
  `Titre` varchar(50) NOT NULL,
  `Auteur_Id` int(11) DEFAULT NULL,
  `Taille` varchar(50) DEFAULT NULL,
  `Date_de_publication` date DEFAULT NULL,
  `Commentaire` varchar(50) DEFAULT NULL,
  `bin` varchar(100) DEFAULT NULL,
  `Corbeille` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`Id_fichier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `gérer`
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
-- Structure de la table `log_`
--

DROP TABLE IF EXISTS `log_`;
CREATE TABLE IF NOT EXISTS `log_` (
  `Id_Log_` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) DEFAULT NULL,
  `Date_de_modification` varchar(50) DEFAULT NULL,
  `Description` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`Id_Log_`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `profil`
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
  `pdp` varchar(100) NOT NULL DEFAULT 'images/pdp_user.jpg',
  PRIMARY KEY (`Id_Profil`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`Id_Profil`, `email`, `MDP`, `Nom`, `Prenom`, `Description`, `Role`, `pdp`) VALUES
(1, 'foucauld.bergerault@student.junia.com', '1da3ddb73ca4580da955f457c2d5b1e1031598915a5ddef49f235c02ae5dacbd', 'BERGERAULT', 'Foucauld', 'Administrateur des briques rouges', 'Admin', 'images/pdp_user.jpg'),
(2, 'mathieu.ranc@student.junia.com', '1da3ddb73ca4580da955f457c2d5b1e1031598915a5ddef49f235c02ae5dacbd', 'RANC', 'Mathieu', 'Administrateur des briques rouges', 'Admin', 'images/pdp_user.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `publier_modifier`
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
-- Structure de la table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `Id_Tag` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) DEFAULT NULL,
  `Créateur` varchar(50) DEFAULT NULL,
  `Id_Catégorie` int(11) DEFAULT '1',
  PRIMARY KEY (`Id_Tag`),
  KEY `Id_Catégorie` (`Id_Catégorie`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`Id_Tag`, `Nom`, `Créateur`, `Id_Catégorie`) VALUES
(0, 'sans tags', '1', 0),
(1, 'Jour', '1', 0),
(2, 'Nuit', '1', 0),
(3, '2TH', '1', 0),
(4, '2021', '1', 1),
(5, '2022', '1', 1),
(6, '2024', '1', 1),
(7, 'Scène 1', '1', 2),
(8, 'BackStage', '1', 2),
(9, 'Camping', '1', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
