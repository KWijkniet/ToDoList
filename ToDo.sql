-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Gegenereerd op: 12 feb 2019 om 17:14
-- Serverversie: 5.6.37
-- PHP-versie: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ToDo`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Items`
--

CREATE TABLE IF NOT EXISTS `Items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `table_id` int(11) NOT NULL,
  `completed` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `Items`
--

INSERT INTO `Items` (`id`, `name`, `table_id`, `completed`) VALUES
(1, 'Item 02', 1, 0),
(2, 'Item 02', 1, 0),
(3, 'just a  test', 2, 0);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `Items`
--
ALTER TABLE `Items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `Items`
--
ALTER TABLE `Items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
