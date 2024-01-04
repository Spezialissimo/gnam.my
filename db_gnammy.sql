-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 26, 2023 alle 12:04
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
  `timestamp` varchar(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `following`
--

CREATE TABLE `following` (
  `follower_user_id` int(11) NOT NULL,
  `followed_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `gnams`
--

CREATE TABLE `gnams` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `share_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `gnam_hashtags`
--

CREATE TABLE `gnam_hashtags` (
  `hashtag_id` int(11) NOT NULL,
  `gnam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `gnam_ingredients`
--

CREATE TABLE `gnam_ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `gnam_id` int(11) NOT NULL,
  `quantity` float DEFAULT NULL,
  `measurement_unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `hashtags`
--

CREATE TABLE `hashtags` (
  `id` int(11) NOT NULL,
  `text` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `gnam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `measurement_units`
--

CREATE TABLE `measurement_units` (
  `id` int(11) NOT NULL,
  `name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `source_user_id` int(11) NOT NULL,
  `target_user_id` int(11) NOT NULL,
  `gnam_id` int(11) DEFAULT NULL,
  `notification_type_id` int(11) NOT NULL,
  `timestamp` varchar(20) NOT NULL DEFAULT '0',
  `seen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `notification_types`
--

CREATE TABLE `notification_types` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `template_text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nome_chiave_gnam` (`gnam_id`),
  ADD KEY `fk_nome_chiave_userid` (`user_id`),
  ADD KEY `fk_nome_chiave_pcid` (`parent_comment_id`);

--
-- Indici per le tabelle `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`follower_user_id`,`followed_user_id`),
  ADD KEY `fk_nome_chiave_followed` (`followed_user_id`);

--
-- Indici per le tabelle `gnams`
--
ALTER TABLE `gnams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nome_chiave_user_id` (`user_id`);

--
-- Indici per le tabelle `gnam_hashtags`
--
ALTER TABLE `gnam_hashtags`
  ADD PRIMARY KEY (`hashtag_id`,`gnam_id`),
  ADD KEY `fk_nome_chiave_gnam_id` (`gnam_id`);

--
-- Indici per le tabelle `gnam_ingredients`
--
ALTER TABLE `gnam_ingredients`
  ADD PRIMARY KEY (`ingredient_id`,`gnam_id`),
  ADD KEY `fk_nome_chiave_measurement` (`measurement_unit_id`),
  ADD KEY `fk_nome_chiave_gnam_id_ingredients` (`gnam_id`);

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
  ADD PRIMARY KEY (`user_id`,`gnam_id`),
  ADD KEY `fk_nome_chiave_gnams` (`gnam_id`);

--
-- Indici per le tabelle `measurement_units`
--
ALTER TABLE `measurement_units`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nome_chiave_tui` (`target_user_id`),
  ADD KEY `fk_nome_chiave_gnam_id_notifications` (`gnam_id`),
  ADD KEY `fk_nome_chiave_notification` (`notification_type_id`);

--
-- Indici per le tabelle `notification_types`
--
ALTER TABLE `notification_types`
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
-- AUTO_INCREMENT per la tabella `measurement_units`
--
ALTER TABLE `measurement_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_nome_chiave_gnam` FOREIGN KEY (`gnam_id`) REFERENCES `gnams` (`id`),
  ADD CONSTRAINT `fk_nome_chiave_pcid` FOREIGN KEY (`parent_comment_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `fk_nome_chiave_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_nome_chiave_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limiti per la tabella `following`
--
ALTER TABLE `following`
  ADD CONSTRAINT `fk_nome_chiave_followed` FOREIGN KEY (`followed_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_nome_chiave_follower` FOREIGN KEY (`follower_user_id`) REFERENCES `users` (`id`);

--
-- Limiti per la tabella `gnams`
--
ALTER TABLE `gnams`
  ADD CONSTRAINT `fk_nome_chiave_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limiti per la tabella `gnam_hashtags`
--
ALTER TABLE `gnam_hashtags`
  ADD CONSTRAINT `fk_nome_chiave_gnam_id` FOREIGN KEY (`gnam_id`) REFERENCES `gnams` (`id`),
  ADD CONSTRAINT `fk_nome_chiave_hashtag` FOREIGN KEY (`hashtag_id`) REFERENCES `hashtags` (`id`);

--
-- Limiti per la tabella `gnam_ingredients`
--
ALTER TABLE `gnam_ingredients`
  ADD CONSTRAINT `fk_nome_chiave_gnam_id_ingredients` FOREIGN KEY (`gnam_id`) REFERENCES `gnams` (`id`),
  ADD CONSTRAINT `fk_nome_chiave_ingredient` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`),
  ADD CONSTRAINT `fk_nome_chiave_measurement` FOREIGN KEY (`measurement_unit_id`) REFERENCES `measurement_units` (`id`);

--
-- Limiti per la tabella `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_nome_chiave_gnams` FOREIGN KEY (`gnam_id`) REFERENCES `gnams` (`id`),
  ADD CONSTRAINT `fk_nome_chiave_user_likes` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limiti per la tabella `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_nome_chiave_gnam_id_notifications` FOREIGN KEY (`gnam_id`) REFERENCES `gnams` (`id`),
  ADD CONSTRAINT `fk_nome_chiave_notification` FOREIGN KEY (`notification_type_id`) REFERENCES `notification_types` (`id`),
  ADD CONSTRAINT `fk_nome_chiave_sui` FOREIGN KEY (`source_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_nome_chiave_tui` FOREIGN KEY (`target_user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
