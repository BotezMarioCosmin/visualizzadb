-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 29, 2024 at 11:37 PM
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
-- Database: `digitalgamestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `acquisti`
--

CREATE TABLE `acquisti` (
  `acquistoid` int(11) NOT NULL,
  `gamertag` varchar(30) NOT NULL,
  `prodottoid` int(11) NOT NULL,
  `importo` float NOT NULL,
  `dataacquisto` date NOT NULL,
  `statoordine` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `acquisti`
--

INSERT INTO `acquisti` (`acquistoid`, `gamertag`, `prodottoid`, `importo`, `dataacquisto`, `statoordine`) VALUES
(1, 'DiscoveryCtrl', 3, 59.99, '2024-01-14', 'completato'),
(2, 'Hero4Hire', 2, 59.99, '2023-12-30', 'in attesa'),
(3, 'Klondike', 1, 39.99, '2024-01-12', 'completato'),
(4, 'BananaRunner', 4, 19.99, '2024-02-26', 'completato');

-- --------------------------------------------------------

--
-- Table structure for table `prodotti`
--

CREATE TABLE `prodotti` (
  `prodottoid` int(11) NOT NULL,
  `nome` varchar(320) NOT NULL,
  `prezzo` float NOT NULL,
  `categoria` varchar(320) NOT NULL,
  `sviluppatore` varchar(320) NOT NULL,
  `pubblicatore` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodotti`
--

INSERT INTO `prodotti` (`prodottoid`, `nome`, `prezzo`, `categoria`, `sviluppatore`, `pubblicatore`) VALUES
(1, 'battlefield 1', 39.99, 'fps', 'dice', 'electronic arts'),
(2, 'call of duty : modern warfare', 59.99, 'fps', 'infinity ward', 'activision'),
(3, 'grand theft auto v', 59.99, 'open world', 'rockstar north', 'rockstar games'),
(4, 'Metro 2033', 19.99, 'survival horror', '4A Games', '4A Games'),
(6, 'Phasmophobia', 19.99, 'Horror', 'Kinetic games', 'Kinetic games');

-- --------------------------------------------------------

--
-- Table structure for table `prodotti_promozioni`
--

CREATE TABLE `prodotti_promozioni` (
  `idprodotto` int(11) NOT NULL,
  `idpromozione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodotti_promozioni`
--

INSERT INTO `prodotti_promozioni` (`idprodotto`, `idpromozione`) VALUES
(1, 2),
(2, 1),
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `promozioni`
--

CREATE TABLE `promozioni` (
  `id` int(11) NOT NULL,
  `sconto` int(3) NOT NULL,
  `datainizio` date NOT NULL,
  `datafine` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promozioni`
--

INSERT INTO `promozioni` (`id`, `sconto`, `datainizio`, `datafine`) VALUES
(1, 25, '2024-02-19', '2024-02-23'),
(2, 30, '2024-02-01', '2024-02-03'),
(3, 15, '2024-01-01', '2024-01-07'),
(4, 50, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `recensioni`
--

CREATE TABLE `recensioni` (
  `id` int(11) NOT NULL,
  `gamertag` varchar(30) NOT NULL,
  `prodottoid` int(11) NOT NULL,
  `valutazione` int(2) NOT NULL,
  `commento` varchar(320) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recensioni`
--

INSERT INTO `recensioni` (`id`, `gamertag`, `prodottoid`, `valutazione`, `commento`, `data`) VALUES
(1, 'DiscoveryCtrl', 3, 9, 'gioco stupendo', '2024-01-14'),
(2, 'Hero4Hire', 2, 10, 'bellissimo!', '2024-01-13'),
(3, 'Klondike', 1, 8, 'divertente', '2024-01-01'),
(4, 'BananaRunner', 4, 10, 'miglior gioco in commercio', '2024-02-27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('admin', 'admin'),
('cosmin', 'cosmin'),
('mario', 'mario'),
('programma', '12345'),
('prova', 'prova');

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `gamertag` varchar(30) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`gamertag`, `email`, `password`) VALUES
('BananaRunner', 'banana@gmail.com', 'banana'),
('CrazyGamer', 'crazy@gmail.com', 'crazy'),
('DiscoveryCtrl', 'nowayof@gmail.com', 'discoveryctrl'),
('Hero4Hire', 'lazylife@gmail.com', 'hero4hire'),
('Klondike', 'imnotreal@gmail.com', 'klondike'),
('TypicalLife', 'typic@gmail.com', 'typic');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acquisti`
--
ALTER TABLE `acquisti`
  ADD PRIMARY KEY (`acquistoid`),
  ADD KEY `rif_acquistigamertag` (`gamertag`),
  ADD KEY `rif_acquistiprodottoid` (`prodottoid`);

--
-- Indexes for table `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`prodottoid`);

--
-- Indexes for table `prodotti_promozioni`
--
ALTER TABLE `prodotti_promozioni`
  ADD KEY `rif_prodotti` (`idprodotto`),
  ADD KEY `rif_promozioni` (`idpromozione`);

--
-- Indexes for table `promozioni`
--
ALTER TABLE `promozioni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recensioni`
--
ALTER TABLE `recensioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rif_recensionigamertag` (`gamertag`),
  ADD KEY `rif_recensioniprodottoid` (`prodottoid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`gamertag`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acquisti`
--
ALTER TABLE `acquisti`
  MODIFY `acquistoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `prodottoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `promozioni`
--
ALTER TABLE `promozioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `recensioni`
--
ALTER TABLE `recensioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acquisti`
--
ALTER TABLE `acquisti`
  ADD CONSTRAINT `rif_acquistigamertag` FOREIGN KEY (`gamertag`) REFERENCES `utenti` (`gamertag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rif_acquistiprodottoid` FOREIGN KEY (`prodottoid`) REFERENCES `prodotti` (`prodottoid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prodotti_promozioni`
--
ALTER TABLE `prodotti_promozioni`
  ADD CONSTRAINT `rif_prodotti` FOREIGN KEY (`idprodotto`) REFERENCES `prodotti` (`prodottoid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rif_promozioni` FOREIGN KEY (`idpromozione`) REFERENCES `promozioni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recensioni`
--
ALTER TABLE `recensioni`
  ADD CONSTRAINT `rif_recensionigamertag` FOREIGN KEY (`gamertag`) REFERENCES `utenti` (`gamertag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rif_recensioniprodottoid` FOREIGN KEY (`prodottoid`) REFERENCES `prodotti` (`prodottoid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
