-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 02 nov. 2023 à 08:24
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dwwm_20_10_23`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` tinytext DEFAULT NULL,
  `name` tinytext DEFAULT NULL,
  `mail` tinytext DEFAULT NULL,
  `dateCreate` datetime NOT NULL DEFAULT current_timestamp(),
  `dateUpdate` datetime NOT NULL DEFAULT current_timestamp(),
  `pass` tinytext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `name`, `mail`, `dateCreate`, `dateUpdate`, `pass`) VALUES
(3, 'Jacques', 'Chirac', '', '2023-10-20 15:46:29', '2023-10-30 16:37:57', 'password1'),
(4, 'Emmanuel', 'Macron', 'macrondu91@gmail.com', '2023-10-20 15:46:29', '2023-10-31 16:19:40', 'password1'),
(6, 'FranÃ§ois', 'Homelande', 'francoislefrancais@gmail.net', '2023-10-20 15:46:29', '2023-10-30 16:53:16', 'password1'),
(7, 'Phillipe', 'Poutou', 'pipoutou@live.net', '2023-10-20 15:46:29', '2023-11-02 09:21:10', 'password1'),
(50, 'ValÃ©rie ', 'PÃ©cresse', 'valochepec@lafrance.fr', '2023-10-31 12:36:51', '2023-10-31 12:36:51', 'valdu91'),
(53, 'Jean-Jacques', 'Goldman', 'jjgold@varietoche.fr', '2023-10-31 16:45:09', '2023-10-31 16:45:09', 'jiraiauboutdemesreves');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
