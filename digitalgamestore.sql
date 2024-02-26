-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 26, 2024 alle 11:29
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
-- Database: `digitalgamestore`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `acquisti`
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
-- Dump dei dati per la tabella `acquisti`
--

INSERT INTO `acquisti` (`acquistoid`, `gamertag`, `prodottoid`, `importo`, `dataacquisto`, `statoordine`) VALUES
(1, 'DiscoveryCtrl', 3, 59.99, '2024-01-14', 'completato'),
(2, 'Hero4Hire', 2, 59.99, '2023-12-30', 'in attesa'),
(3, 'Klondike', 1, 39.99, '2024-01-12', 'completato'),
(4, 'BananaRunner', 4, 19.99, '2024-02-26', 'completato');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
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
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`prodottoid`, `nome`, `prezzo`, `categoria`, `sviluppatore`, `pubblicatore`) VALUES
(1, 'battlefield 1', 39.99, 'fps', 'dice', 'electronic arts'),
(2, 'call of duty : modern warfare', 59.99, 'fps', 'infinity ward', 'activision'),
(3, 'grand theft auto v', 59.99, 'open world', 'rockstar north', 'rockstar games'),
(4, 'Metro 2033', 19.99, 'survival horror', '4A Games', '4A Games');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti_promozioni`
--

CREATE TABLE `prodotti_promozioni` (
  `idprodotto` int(11) NOT NULL,
  `idpromozione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prodotti_promozioni`
--

INSERT INTO `prodotti_promozioni` (`idprodotto`, `idpromozione`) VALUES
(1, 2),
(2, 1),
(4, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `promozioni`
--

CREATE TABLE `promozioni` (
  `id` int(11) NOT NULL,
  `sconto` int(3) NOT NULL,
  `datainizio` date NOT NULL,
  `datafine` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `promozioni`
--

INSERT INTO `promozioni` (`id`, `sconto`, `datainizio`, `datafine`) VALUES
(1, 25, '2024-02-19', '2024-02-23'),
(2, 30, '2024-02-01', '2024-02-03'),
(3, 15, '2024-01-01', '2024-01-07');

-- --------------------------------------------------------

--
-- Struttura della tabella `recensioni`
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
-- Dump dei dati per la tabella `recensioni`
--

INSERT INTO `recensioni` (`id`, `gamertag`, `prodottoid`, `valutazione`, `commento`, `data`) VALUES
(1, 'DiscoveryCtrl', 3, 9, 'gioco stupendo', '2024-01-14'),
(2, 'Hero4Hire', 2, 10, 'bellissimo!', '2024-01-13'),
(3, 'Klondike', 1, 8, 'divertente', '2024-01-01'),
(4, 'BananaRunner', 4, 10, 'miglior gioco in commercio', '2024-02-27');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `gamertag` varchar(30) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`gamertag`, `email`, `password`) VALUES
('BananaRunner', 'banana@gmail.com', 'banana'),
('DiscoveryCtrl', 'nowayof@gmail.com', 'discoveryctrl'),
('Hero4Hire', 'lazylife@gmail.com', 'hero4hire'),
('Klondike', 'imnotreal@gmail.com', 'klondike');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `acquisti`
--
ALTER TABLE `acquisti`
  ADD PRIMARY KEY (`acquistoid`),
  ADD KEY `rif_acquistigamertag` (`gamertag`),
  ADD KEY `rif_acquistiprodottoid` (`prodottoid`);

--
-- Indici per le tabelle `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`prodottoid`);

--
-- Indici per le tabelle `prodotti_promozioni`
--
ALTER TABLE `prodotti_promozioni`
  ADD KEY `rif_prodotti` (`idprodotto`),
  ADD KEY `rif_promozioni` (`idpromozione`);

--
-- Indici per le tabelle `promozioni`
--
ALTER TABLE `promozioni`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `recensioni`
--
ALTER TABLE `recensioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rif_recensionigamertag` (`gamertag`),
  ADD KEY `rif_recensioniprodottoid` (`prodottoid`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`gamertag`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `acquisti`
--
ALTER TABLE `acquisti`
  MODIFY `acquistoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `prodottoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `promozioni`
--
ALTER TABLE `promozioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `recensioni`
--
ALTER TABLE `recensioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `acquisti`
--
ALTER TABLE `acquisti`
  ADD CONSTRAINT `rif_acquistigamertag` FOREIGN KEY (`gamertag`) REFERENCES `utenti` (`gamertag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rif_acquistiprodottoid` FOREIGN KEY (`prodottoid`) REFERENCES `prodotti` (`prodottoid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prodotti_promozioni`
--
ALTER TABLE `prodotti_promozioni`
  ADD CONSTRAINT `rif_prodotti` FOREIGN KEY (`idprodotto`) REFERENCES `prodotti` (`prodottoid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rif_promozioni` FOREIGN KEY (`idpromozione`) REFERENCES `promozioni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `recensioni`
--
ALTER TABLE `recensioni`
  ADD CONSTRAINT `rif_recensionigamertag` FOREIGN KEY (`gamertag`) REFERENCES `utenti` (`gamertag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rif_recensioniprodottoid` FOREIGN KEY (`prodottoid`) REFERENCES `prodotti` (`prodottoid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
