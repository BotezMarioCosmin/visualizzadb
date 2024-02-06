-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2024 at 08:39 AM
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
(3, 'Klondike', 1, 39.99, '2024-01-12', 'completato');

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
(3, 'grand theft auto v', 59.99, 'open world', 'rockstar north', 'rockstar games');

-- --------------------------------------------------------

--
-- Table structure for table `promozioni`
--

CREATE TABLE `promozioni` (
  `promozioneid` int(11) NOT NULL,
  `prodottoid` int(11) NOT NULL,
  `sconto` int(11) NOT NULL,
  `datainizio` date NOT NULL,
  `datafine` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promozioni`
--

INSERT INTO `promozioni` (`promozioneid`, `prodottoid`, `sconto`, `datainizio`, `datafine`) VALUES
(1, 1, 20, '2024-01-14', '2024-01-21'),
(2, 2, 33, '2024-01-15', '2024-01-28'),
(3, 3, 60, '2024-01-01', '2024-01-31');

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
(3, 'Klondike', 1, 8, 'divertente', '2024-01-01');

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
('DiscoveryCtrl', 'nowayof@gmail.com', 'discoveryctrl'),
('Hero4Hire', 'lazylife@gmail.com', 'hero4hire'),
('Klondike', 'imnotreal@gmail.com', 'klondike');

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
-- Indexes for table `promozioni`
--
ALTER TABLE `promozioni`
  ADD PRIMARY KEY (`promozioneid`),
  ADD KEY `rif_promozioniprodottoid` (`prodottoid`);

--
-- Indexes for table `recensioni`
--
ALTER TABLE `recensioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rif_recensionigamertag` (`gamertag`),
  ADD KEY `rif_recensioniprodottoid` (`prodottoid`);

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
  MODIFY `acquistoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `prodottoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promozioni`
--
ALTER TABLE `promozioni`
  MODIFY `promozioneid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recensioni`
--
ALTER TABLE `recensioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acquisti`
--
ALTER TABLE `acquisti`
  ADD CONSTRAINT `rif_acquistigamertag` FOREIGN KEY (`gamertag`) REFERENCES `utenti` (`gamertag`),
  ADD CONSTRAINT `rif_acquistiprodottoid` FOREIGN KEY (`prodottoid`) REFERENCES `prodotti` (`prodottoid`);

--
-- Constraints for table `promozioni`
--
ALTER TABLE `promozioni`
  ADD CONSTRAINT `rif_promozioniprodottoid` FOREIGN KEY (`prodottoid`) REFERENCES `prodotti` (`prodottoid`);

--
-- Constraints for table `recensioni`
--
ALTER TABLE `recensioni`
  ADD CONSTRAINT `rif_recensionigamertag` FOREIGN KEY (`gamertag`) REFERENCES `utenti` (`gamertag`),
  ADD CONSTRAINT `rif_recensioniprodottoid` FOREIGN KEY (`prodottoid`) REFERENCES `prodotti` (`prodottoid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
