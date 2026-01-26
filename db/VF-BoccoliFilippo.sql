-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Gen 13, 2026 alle 11:58
-- Versione del server: 8.2.0
-- Versione PHP: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lavagne`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `lavagne`
--

CREATE TABLE `lavagne` (
  `marca` varchar(50) DEFAULT NULL,
  `forma` varchar(50) DEFAULT NULL,
  `larghezza` int NOT NULL DEFAULT '0',
  `altezza` int NOT NULL DEFAULT '0',
  `tipo` varchar(50) NOT NULL,
  `ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `lavagne`
--

INSERT INTO `lavagne` (`marca`, `forma`, `larghezza`, `altezza`, `tipo`, `ID`) VALUES
('Ferrari', 'rettangolare', 104, 67, 'ardesia', 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `lavagne`
--
ALTER TABLE `lavagne`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `lavagne`
--
ALTER TABLE `lavagne`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
