-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 11:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `appartiene`
--

CREATE TABLE `appartiene` (
  `idEvento` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appartiene`
--

INSERT INTO `appartiene` (`idEvento`, `idCategoria`) VALUES
(101, 1),
(102, 2),
(103, 3),
(103, 1);

-- --------------------------------------------------------

--
-- Table structure for table `artista`
--

CREATE TABLE `artista` (
  `idArtista` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `dataNascita` date NOT NULL,
  `nomeD'arte` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `artista`
--

INSERT INTO `artista` (`idArtista`, `nome`, `cognome`, `dataNascita`, `nomeD'arte`) VALUES
(1, 'Luca', 'Gallo', '1990-05-15', 'DJ_LUK'),
(2, 'Anna', 'Neri', '1985-11-20', 'ANNA_SOUL'),
(3, 'Paolo', 'Bruni', '1995-03-10', 'P_ROCKS');

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nome`) VALUES
(1, 'Musica Live'),
(2, 'Teatro'),
(3, 'Cinema');

-- --------------------------------------------------------

--
-- Table structure for table `evento`
--

CREATE TABLE `evento` (
  `idEvento` int(11) NOT NULL,
  `luogo` varchar(30) NOT NULL,
  `data` date NOT NULL,
  `titolo` varchar(30) NOT NULL,
  `nickname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `evento`
--

INSERT INTO `evento` (`idEvento`, `luogo`, `data`, `titolo`, `nickname`) VALUES
(101, 'Palasport', '2026-01-20', 'The Big Show', 'User_A'),
(102, 'Auditorium', '2026-02-15', 'Drama Night', 'User_B'),
(103, 'Cinema XYZ', '2026-03-01', 'Short Film Fest', 'User_A');

-- --------------------------------------------------------

--
-- Table structure for table `interessa`
--

CREATE TABLE `interessa` (
  `nickname` varchar(30) NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `interessa`
--

INSERT INTO `interessa` (`nickname`, `idCategoria`) VALUES
('User_A', 1),
('User_A', 3),
('User_B', 2);

-- --------------------------------------------------------

--
-- Table structure for table `partecipa`
--

CREATE TABLE `partecipa` (
  `idArtista` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `partecipa`
--

INSERT INTO `partecipa` (`idArtista`, `idEvento`) VALUES
(1, 101),
(2, 101),
(2, 102),
(1, 103);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `idPost` int(11) NOT NULL,
  `commento` varchar(30) NOT NULL,
  `voto` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `nickname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`idPost`, `commento`, `voto`, `idEvento`, `nickname`) VALUES
(1, 'Ottimo concerto!', 5, 101, 'User_B'),
(2, 'Buona organizzazione.', 4, 101, 'User_C'),
(3, 'Trama coinvolgente.', 5, 102, 'User_A');

-- --------------------------------------------------------

--
-- Table structure for table `utente`
--

CREATE TABLE `utente` (
  `nickname` varchar(30) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `provincia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `utente`
--

INSERT INTO `utente` (`nickname`, `nome`, `cognome`, `email`, `provincia`) VALUES
('User_A', 'Mario', 'Rossi', 'mario.r@gmail.com', 'Milano'),
('User_B', 'Laura', 'Bianchi', 'laura.b@gmail.com', 'Roma'),
('User_C', 'Marco', 'Verdi', 'marco.v@gmail.com', 'Napoli');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appartiene`
--
ALTER TABLE `appartiene`
  ADD KEY `idCategoria` (`idCategoria`),
  ADD KEY `idEvento` (`idEvento`);

--
-- Indexes for table `artista`
--
ALTER TABLE `artista`
  ADD PRIMARY KEY (`idArtista`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indexes for table `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`idEvento`),
  ADD KEY `nickname` (`nickname`);

--
-- Indexes for table `interessa`
--
ALTER TABLE `interessa`
  ADD KEY `idCategoria` (`idCategoria`),
  ADD KEY `nickname` (`nickname`);

--
-- Indexes for table `partecipa`
--
ALTER TABLE `partecipa`
  ADD KEY `idArtista` (`idArtista`),
  ADD KEY `idEvento` (`idEvento`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`idPost`),
  ADD KEY `idEvento` (`idEvento`),
  ADD KEY `nickname` (`nickname`);

--
-- Indexes for table `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`nickname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `evento`
--
ALTER TABLE `evento`
  MODIFY `idEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `idPost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appartiene`
--
ALTER TABLE `appartiene`
  ADD CONSTRAINT `appartiene_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `appartiene_ibfk_2` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`);

--
-- Constraints for table `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`nickname`) REFERENCES `utente` (`nickname`);

--
-- Constraints for table `interessa`
--
ALTER TABLE `interessa`
  ADD CONSTRAINT `interessa_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `interessa_ibfk_2` FOREIGN KEY (`nickname`) REFERENCES `utente` (`nickname`);

--
-- Constraints for table `partecipa`
--
ALTER TABLE `partecipa`
  ADD CONSTRAINT `partecipa_ibfk_1` FOREIGN KEY (`idArtista`) REFERENCES `artista` (`idArtista`),
  ADD CONSTRAINT `partecipa_ibfk_2` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`nickname`) REFERENCES `utente` (`nickname`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
