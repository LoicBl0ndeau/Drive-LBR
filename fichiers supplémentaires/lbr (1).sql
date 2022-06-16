-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 16 juin 2022 à 12:36
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
-- Structure de la table `catégorie`
--

DROP TABLE IF EXISTS `catégorie`;
CREATE TABLE IF NOT EXISTS `catégorie` (
  `Id_Catégorie` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  `Créateur` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Catégorie`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `log_`
--

INSERT INTO `log_` (`Id_Log_`, `Nom`, `Date_de_modification`, `Description`) VALUES
(1, 'Boubert', '15-06-22 03:46:31', 'Connexion du compte 1 : louis.boubert.26@gmail.com / Boubert / Louis'),
(2, 'Boubert', '15-06-22 03:51:48', 'Connexion du compte 1 : louis.boubert.26@gmail.com / Boubert / Louis'),
(3, 'Boubert', '16-06-22 10:40:34', 'Modification du compte 4 : loic.blondeau@student.junia.co / Blondeau / Loïc / Administrateur de création / Visiteur'),
(4, 'Boubert', '16-06-22 10:40:42', 'Modification du compte 4 : loic.blondeau@student.junia.com / Blondeau / Loïc / Administrateur de création / Admin'),
(5, 'Boubert', '16-06-22 11:43:48', 'Création d\'un compte : oui@non.jsp / non / oui / azerty / Editeur');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`Id_Profil`, `email`, `MDP`, `Nom`, `Prenom`, `Description`, `Role`, `pdp`) VALUES
(1, 'louis.boubert.26@gmail.com', 'f2d81a260dea8a100dd517984e53c56a7523d96942a834b9cdc249bd4e8c7aa9', 'Boubert', 'Louis', 'premier profil', 'Admin', 'pdp/louis.boubert.26@gmail.com/téléchargement.jpg'),
(3, 'capellemartin.27@gmail.com', '119511946f7c081e3050a2be01c9124b1b984efb455656c107b2ec056496c4ee', 'Capelle', 'Martin', 'Administrateur de création', 'Admin', ''),
(4, 'loic.blondeau@student.junia.com', '4bed74a357375b2892d4bcc91e6d511d20b5b021e4566c665eb686a3006ed585', 'Blondeau', 'Loïc', 'Administrateur de création', 'Admin', ''),
(5, 'iliesbenslama11@gmail.com', '11b44c52faf329051084b393388af64127479a221470e937dbfcba7417fa5f63', 'Benslama', 'Ilies', 'Administrateur de création', 'Admin', ''),
(7, 'test@test.test', NULL, 'test', 'test', 'test', 'Visiteur', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`Id_Tag`, `Nom`, `Créateur`, `Id_Catégorie`) VALUES
(1, 'lo', '1', 1),
(2, 'lo', '1', 1),
(3, 'lo', '1', 1),
(4, 'lo', '1', 1),
(5, 'lo', '1', 1),
(6, 'lo', '1', 1),
(7, 'lo', '1', 1),
(8, 'lo', '1', 1),
(9, 'lo', '1', 1),
(10, 'lo', '1', 1),
(11, 'lo', '1', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
