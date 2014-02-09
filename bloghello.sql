-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Dim 09 Février 2014 à 18:29
-- Version du serveur: 5.6.11-log
-- Version de PHP: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `bloghello`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `texte` text NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `titre`, `texte`, `date`) VALUES
(105, 'Mon blog, ma fiertÃ©', 'Voici mon blog, fait par mes soins avec l''aide de Nilsine et L''ULCO. <br> <br>\r\n\r\nJe suis Godin Charles, un Ã©tudiant de 21ans actuellement en LP RSC. <br> <br>\r\n\r\nEt c''est parti pour remplir ce ptit blog ! <br>', 1391942220),
(106, 'Les pandas roux, c''est le bien !', 'Les panda roux, c''est cute, marrant, apaisant <br> <br>\r\n\r\nJe les adore ! ils m''apaisent rien qu''a les regarder jouÃ© ! <br> \r\nVoyez par vous mÃªme :  http://www.youtube.com/watch?v=7jWYUtQZhK0\r\n<br>', 1391943432),
(107, 'Je fais partie de Warlegend', 'Je fais partie de l''asso Warlegend, Je suis un newseur et traqueur de bon plan. <br> <br>\r\n\r\nJe dÃ©veloppe actuellement un plugin Wordpress afin de gÃ©rer des streams de jeux videos avec l''aide de: Laurent dubreuil et de Jordy Lefebvre.\r\n\r\n', 1391944020);

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  PRIMARY KEY (`id_tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Contenu de la table `tags`
--

INSERT INTO `tags` (`id_tag`, `nom`) VALUES
(43, 'proudness'),
(44, 'firefox'),
(45, 'Warlegend');

-- --------------------------------------------------------

--
-- Structure de la table `tags_articles`
--

CREATE TABLE IF NOT EXISTS `tags_articles` (
  `id_tags` int(11) NOT NULL,
  `id_articles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tags_articles`
--

INSERT INTO `tags_articles` (`id_tags`, `id_articles`) VALUES
(43, 105),
(44, 106),
(45, 107);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `mdp` varchar(30) NOT NULL,
  `sid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `email`, `mdp`, `sid`) VALUES
(1, 'o@o.fr', 'mdp', '39ba205263312dc11083852b1a2c20e6');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
