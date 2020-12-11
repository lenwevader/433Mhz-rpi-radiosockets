-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 20. Jul 2019 um 00:12
-- Server Version: 5.5.60
-- PHP-Version: 5.4.45-0+deb7u14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `Funksteckdosen`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Automatik`
--

CREATE TABLE IF NOT EXISTS `Automatik` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `FunkId` int(11) NOT NULL,
  `Zeit` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Hersteller`
--

CREATE TABLE IF NOT EXISTS `Hersteller` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Codename` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `Hersteller`
--

INSERT INTO `Hersteller` (`Id`, `Name`, `Codename`) VALUES
(1, 'Pollin', 'pollin'),
(2, 'Elro', 'elro_400_switch'),
(3, 'Brennenstuhl', 'brennenstuhl'),
(4, 'Mumbi', 'mumbi'),
(5, 'Intertechno', 'intertechno_switch'),
(6, 'Raw', 'raw');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Profil`
--

CREATE TABLE IF NOT EXISTS `Profil` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `Profil`
--

INSERT INTO `Profil` (`Id`, `Name`) VALUES
(1, 'Stube'),
(5, 'Panik'),
(6, 'AuÃŸen'),
(8, 'Weihnachten');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ProfilSteckdosen`
--

CREATE TABLE IF NOT EXISTS `ProfilSteckdosen` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ProfilId` int(11) NOT NULL,
  `SteckdosenId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Daten für Tabelle `ProfilSteckdosen`
--

INSERT INTO `ProfilSteckdosen` (`Id`, `ProfilId`, `SteckdosenId`) VALUES
(48, 5, 1),
(50, 5, 39),
(51, 5, 42),
(52, 5, 43),
(53, 5, 44),
(54, 6, 43),
(55, 6, 44),
(56, 1, 47),
(57, 5, 47),
(58, 5, 47),
(62, 1, 39),
(66, 1, 1),
(67, 1, 42),
(74, 8, 1),
(75, 8, 48),
(76, 8, 49),
(77, 8, 42);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Profilzeit`
--

CREATE TABLE IF NOT EXISTS `Profilzeit` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ProfilId` int(11) NOT NULL,
  `Von` text,
  `Bis` text,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `Profilzeit`
--

INSERT INTO `Profilzeit` (`Id`, `ProfilId`, `Von`, `Bis`) VALUES
(1, 1, 'U', '00:30');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Rawcode`
--

CREATE TABLE IF NOT EXISTS `Rawcode` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Raw_On` text NOT NULL,
  `Raw_Off` text NOT NULL,
  `Comment` varchar(20) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `Rawcode`
--

INSERT INTO `Rawcode` (`Id`, `Raw_On`, `Raw_Off`, `Comment`) VALUES
(1, '330 4940 330 1000 320 1010 970 360 320 1010 310 1010 970 370 320 1010 970 360 320 1010 970 370 960 370 960 360 320 1010 970 380 310 1020 300 1020 960 370 960 380 310 1020 960 370 310 1010 970 380 300 1030 950 380 300 1020 960 380 950 370 310 1020', '320 4950 330 1000 320 1010 970 360 320 1010 320 1000 980 370 310 1010 320 1020 310 1010 970 370 320 1010 970 360 970 360 310 1030 960 370 960 360 970 360 320 1020 320 1010 970 360 310 1020 310 1040 300 1020 310 1020 310 1010 970 370 960 370 310 1020', 'Stern'),
(2, '330 4950 320 1010 320 1000 980 350 330 1010 310 1010 980 360 320 1010 320 1010 320 1010 970 370 970 360 320 1010 970 360 970 370 970 360 310 1030 950 370 960 380 310 1020 960 370 310 1020 960 370 320 1020 310 1010 310 1020 960 380 310 1010 960 370', '320 4950 320 1010 320 1000 980 350 330 1000 320 1020 960 370 320 1020 310 1010 970 360 970 370 970 360 970 360 960 370 310 1030 310 1020 310 1020 960 360 970 370 310 1030 300 1020 310 1020 310 1030 310 1020 960 370 960 370 960 370 310 1010 970 370', 'Weihnachtsbaum');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Steckdosen`
--

CREATE TABLE IF NOT EXISTS `Steckdosen` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UId` int(11) NOT NULL,
  `SysCode` int(11) NOT NULL,
  `Hersteller` int(11) NOT NULL,
  `Name` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `Intervall` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Daten für Tabelle `Steckdosen`
--

INSERT INTO `Steckdosen` (`Id`, `UId`, `SysCode`, `Hersteller`, `Name`, `Intervall`) VALUES
(1, 1, 21, 1, 'Laterne', NULL),
(39, 2, 21, 1, 'Vitrine', NULL),
(41, 29, 11, 2, 'Pumpe', 10),
(42, 4, 21, 1, 'Lampe', NULL),
(43, 30, 11, 2, 'Laterne AuÃŸen', NULL),
(44, 1, 1, 5, 'AuÃŸentÃ¼r', 10),
(45, 23, 11, 2, 'Drucker', 10),
(47, 15, 11, 2, 'Vitrine II', NULL),
(48, 1, 1, 6, 'Stern', NULL),
(49, 1, 2, 6, 'Weihnachtsbaum', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Zeit`
--

CREATE TABLE IF NOT EXISTS `Zeit` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `FunkId` int(11) NOT NULL,
  `Von` text NOT NULL,
  `Bis` text NOT NULL,
  `Dusk` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Daten für Tabelle `Zeit`
--

INSERT INTO `Zeit` (`Id`, `FunkId`, `Von`, `Bis`, `Dusk`) VALUES
(40, 41, '06:00', '06:30', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
