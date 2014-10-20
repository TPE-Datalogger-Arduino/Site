-- Généré le :  Sam 18 Octobre 2014 à 18:11
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


--
-- Base de données :  `tpe`
--
-- --------------------------------------------------------
--
-- Structure de la table `datalog_meteo`
--
-- Création :  Sam 18 Octobre 2014 à 16:09
--

DROP TABLE IF EXISTS `datalog_meteo`;
CREATE TABLE IF NOT EXISTS `datalog_meteo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `temps` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `temperature` float NOT NULL,
  `humidite` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `datalog_meteo`
--

INSERT INTO `datalog_meteo` (`temps`, `temperature`, `humidite`) VALUES
('2014-10-18 16:09:17', 105, 100);
