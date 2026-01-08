-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 08, 2026 alle 10:21
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `community`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appartiene`
--

CREATE TABLE `appartiene` (
  `idEvento` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `appartiene`
--

INSERT INTO `appartiene` (`idEvento`, `idCategoria`) VALUES
(101, 1),
(102, 2),
(103, 3),
(103, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `artista`
--

CREATE TABLE `artista` (
  `idArtista` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `dataNascita` date NOT NULL,
  `nomeArte` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `artista`
--

INSERT INTO `artista` (`idArtista`, `nome`, `cognome`, `dataNascita`, `nomeArte`) VALUES
(1, 'Luca', 'Gallo', '1990-05-15', 'DJ_LUK'),
(2, 'Anna', 'Neri', '1985-11-20', 'ANNA_SOUL'),
(3, 'Paolo', 'Bruni', '1995-03-10', 'P_ROCKS');

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nome`) VALUES
(1, 'Musica Live'),
(2, 'Teatro'),
(3, 'Cinema');

-- --------------------------------------------------------

--
-- Struttura della tabella `evento`
--

CREATE TABLE `evento` (
  `idEvento` int(11) NOT NULL,
  `luogo` varchar(30) NOT NULL,
  `data` date NOT NULL,
  `titolo` varchar(30) NOT NULL,
  `nickname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`idEvento`, `luogo`, `data`, `titolo`, `nickname`) VALUES
(101, 'Palasport', '2026-01-20', 'The Big Show', 'User_A'),
(102, 'Auditorium', '2026-02-15', 'Drama Night', 'User_B'),
(103, 'Cinema XYZ', '2026-03-01', 'Short Film Fest', 'User_A');

-- --------------------------------------------------------

--
-- Struttura della tabella `interessa`
--

CREATE TABLE `interessa` (
  `nickname` varchar(30) NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `interessa`
--

INSERT INTO `interessa` (`nickname`, `idCategoria`) VALUES
('User_A', 1),
('User_A', 3),
('User_B', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipa`
--

CREATE TABLE `partecipa` (
  `idArtista` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `partecipa`
--

INSERT INTO `partecipa` (`idArtista`, `idEvento`) VALUES
(1, 101),
(2, 101),
(2, 102),
(1, 103);

-- --------------------------------------------------------

--
-- Struttura della tabella `post`
--

CREATE TABLE `post` (
  `idPost` int(11) NOT NULL,
  `commento` varchar(30) NOT NULL,
  `voto` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `nickname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `post`
--

INSERT INTO `post` (`idPost`, `commento`, `voto`, `idEvento`, `nickname`) VALUES
(1, 'Ottimo concerto!', 5, 101, 'User_B'),
(2, 'Buona organizzazione.', 4, 101, 'User_C'),
(3, 'Trama coinvolgente.', 5, 102, 'User_A');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `nickname` varchar(30) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`nickname`, `nome`, `cognome`, `email`, `provincia`, `password`) VALUES
('User_A', 'Mario', 'Rossi', 'mario.r@gmail.com', 'Milano', '123'),
('User_B', 'Laura', 'Bianchi', 'laura.b@gmail.com', 'Roma', '123'),
('User_C', 'Marco', 'Verdi', 'marco.v@gmail.com', 'Napoli', '123');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `appartiene`
--
ALTER TABLE `appartiene`
  ADD KEY `idCategoria` (`idCategoria`),
  ADD KEY `idEvento` (`idEvento`);

--
-- Indici per le tabelle `artista`
--
ALTER TABLE `artista`
  ADD PRIMARY KEY (`idArtista`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indici per le tabelle `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`idEvento`),
  ADD KEY `nickname` (`nickname`);

--
-- Indici per le tabelle `interessa`
--
ALTER TABLE `interessa`
  ADD KEY `idCategoria` (`idCategoria`),
  ADD KEY `nickname` (`nickname`);

--
-- Indici per le tabelle `partecipa`
--
ALTER TABLE `partecipa`
  ADD KEY `idArtista` (`idArtista`),
  ADD KEY `idEvento` (`idEvento`);

--
-- Indici per le tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`idPost`),
  ADD KEY `idEvento` (`idEvento`),
  ADD KEY `nickname` (`nickname`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`nickname`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `evento`
--
ALTER TABLE `evento`
  MODIFY `idEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT per la tabella `post`
--
ALTER TABLE `post`
  MODIFY `idPost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appartiene`
--
ALTER TABLE `appartiene`
  ADD CONSTRAINT `appartiene_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `appartiene_ibfk_2` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`);

--
-- Limiti per la tabella `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`nickname`) REFERENCES `utente` (`nickname`);

--
-- Limiti per la tabella `interessa`
--
ALTER TABLE `interessa`
  ADD CONSTRAINT `interessa_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `interessa_ibfk_2` FOREIGN KEY (`nickname`) REFERENCES `utente` (`nickname`);

--
-- Limiti per la tabella `partecipa`
--
ALTER TABLE `partecipa`
  ADD CONSTRAINT `partecipa_ibfk_1` FOREIGN KEY (`idArtista`) REFERENCES `artista` (`idArtista`),
  ADD CONSTRAINT `partecipa_ibfk_2` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`);

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`nickname`) REFERENCES `utente` (`nickname`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
