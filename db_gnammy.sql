-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 06, 2023 alle 14:06
-- Versione del server: 10.4.18-MariaDB
-- Versione PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_gnammy`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gnam_id` int(11) NOT NULL,
  `parent_comment_id` int(11) DEFAULT NULL,
  `text` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `following`
--

CREATE TABLE `following` (
  `follower_user_id` int(11) NOT NULL,
  `followed_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `gnams`
--

CREATE TABLE `gnams` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `share_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `gnam_hashtags`
--

CREATE TABLE `gnam_hashtags` (
  `hashtag_id` int(11) NOT NULL,
  `gnam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `gnam_ingredients`
--

CREATE TABLE `gnam_ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `gnam_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_of_measure_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `hashtags`
--

CREATE TABLE `hashtags` (
  `id` int(11) NOT NULL,
  `text` varchar(15) NOT NULL,
  `icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `gnam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `notifications`
--

CREATE TABLE `notifications` (
  `source_user_id` int(11) NOT NULL,
  `target_user_id` int(11) NOT NULL,
  `gnam_id` int(11) DEFAULT NULL,
  `notification_type_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `notification_types`
--

CREATE TABLE `notification_types` (
  `id` int(11) NOT NULL,
  `template_text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `unit_of_measure`
--

CREATE TABLE `unit_of_measure` (
  `id` int(11) NOT NULL,
  `name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`follower_user_id`,`followed_user_id`);

--
-- Indici per le tabelle `gnams`
--
ALTER TABLE `gnams`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `gnam_hashtags`
--
ALTER TABLE `gnam_hashtags`
  ADD PRIMARY KEY (`hashtag_id`,`gnam_id`);

--
-- Indici per le tabelle `gnam_ingredients`
--
ALTER TABLE `gnam_ingredients`
  ADD PRIMARY KEY (`ingredient_id`,`gnam_id`);

--
-- Indici per le tabelle `hashtags`
--
ALTER TABLE `hashtags`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`user_id`,`gnam_id`);

--
-- Indici per le tabelle `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`source_user_id`,`target_user_id`,`timestamp`);

--
-- Indici per le tabelle `notification_types`
--
ALTER TABLE `notification_types`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `unit_of_measure`
--
ALTER TABLE `unit_of_measure`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `gnams`
--
ALTER TABLE `gnams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `hashtags`
--
ALTER TABLE `hashtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `unit_of_measure`
--
ALTER TABLE `unit_of_measure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
