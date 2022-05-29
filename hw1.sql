-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 29, 2022 alle 16:05
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hw1`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `comments`
--

CREATE TABLE `comments` (
  `UserId` int(11) NOT NULL,
  `PostId` int(11) NOT NULL,
  `Content` varchar(1023) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `comments`
--

INSERT INTO `comments` (`UserId`, `PostId`, `Content`) VALUES
(2, 5, 'ciao'),
(3, 6, 'dai, a me piace');

--
-- Trigger `comments`
--
DELIMITER $$
CREATE TRIGGER `DeleteComments` AFTER DELETE ON `comments` FOR EACH ROW BEGIN
    UPDATE POSTS
    SET nComments = nComments - 1
    WHERE Id = OLD.PostId ; 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateComments` AFTER INSERT ON `comments` FOR EACH ROW BEGIN
    UPDATE POSTS
    SET nComments = nComments + 1
    WHERE Id = NEW.PostId ; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `likes`
--

CREATE TABLE `likes` (
  `UserId` int(11) NOT NULL,
  `PostId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `likes`
--

INSERT INTO `likes` (`UserId`, `PostId`) VALUES
(1, 5),
(2, 5),
(2, 6),
(3, 5),
(3, 6),
(3, 7);

--
-- Trigger `likes`
--
DELIMITER $$
CREATE TRIGGER `DeleteLikes` AFTER DELETE ON `likes` FOR EACH ROW BEGIN
    UPDATE POSTS
    SET nLikes = nLikes - 1
    WHERE Id = OLD.PostId ; 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateLikes` AFTER INSERT ON `likes` FOR EACH ROW BEGIN
    UPDATE POSTS
    SET nLikes = nLikes + 1
    WHERE Id = NEW.PostId ; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `posts`
--

CREATE TABLE `posts` (
  `Id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Game` varchar(255) DEFAULT NULL,
  `Content` varchar(1023) DEFAULT NULL,
  `Poster` int(11) DEFAULT NULL,
  `nLikes` int(11) DEFAULT 0,
  `nComments` int(11) DEFAULT 0,
  `Grade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `posts`
--

INSERT INTO `posts` (`Id`, `Title`, `Game`, `Content`, `Poster`, `nLikes`, `nComments`, `Grade`) VALUES
(5, 'Incredibile!!!', 'elden-ring', 'Il mio nuovo gioco preferito', 1, 3, 1, 5),
(6, 'Mah Mah', 'call-of-duty', 'Ho visto di meglio', 2, 2, 1, 3),
(7, 'bellissimo', 'dark-souls-ii', 'il mio preferito della serie', 3, 1, 0, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Cognome` varchar(255) DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`Id`, `Nome`, `Cognome`, `Username`, `Email`, `Pass`) VALUES
(1, 'Edoardo', 'Reina', 'ed16', 'edoardo.reina16@gmail.com', '$2y$10$GM8x9LTHa1/b0Nhnubft6OLFBOucTlqBGXDqG0ZDwWoUeROLEgM2i'),
(2, 'mauro', 'mauri', 'edo16', 'edo.edo@gmail.com', '$2y$10$nwem3RzEuwvcZRoFLTPAdu8cr1dGzUUozGfwlnc/4S5sh8a5FiIUq'),
(3, 'joelma', 'motadossantos', 'jo', 'joelmamotadossantos@hotmail.it', '$2y$10$tN70UDr/LAsGY9k3ToqUJuntQJL6UQM0WmDOKGhp5upG51.d0BaX2');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`UserId`,`PostId`),
  ADD KEY `PostId` (`PostId`);

--
-- Indici per le tabelle `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`UserId`,`PostId`),
  ADD KEY `PostId` (`PostId`);

--
-- Indici per le tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Poster` (`Poster`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`PostId`) REFERENCES `posts` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`PostId`) REFERENCES `posts` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`Poster`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
