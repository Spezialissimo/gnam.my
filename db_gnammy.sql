-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 15, 2024 alle 22:44
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

CREATE DATABASE IF NOT EXISTS `db_gnammy` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_gnammy`;

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

--
-- Dump dei dati per la tabella `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `gnam_id`, `parent_comment_id`, `text`, `timestamp`) VALUES
(7, 3, 6, NULL, 'Buoni, li proverò!', '1705354070'),
(8, 3, 7, NULL, 'Assurda.. bomba! Da provare :D', '1705354081'),
(9, 2, 7, 8, 'Buono!', '1705354315');

-- --------------------------------------------------------

--
-- Struttura della tabella `following`
--

CREATE TABLE `following` (
  `follower_user_id` int(11) NOT NULL,
  `followed_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `following`
--

INSERT INTO `following` (`follower_user_id`, `followed_user_id`) VALUES
(1, 2),
(1, 3),
(2, 1),
(2, 3);

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

--
-- Dump dei dati per la tabella `gnams`
--

INSERT INTO `gnams` (`id`, `user_id`, `description`, `share_count`) VALUES
(1, 1, 'Oggi vi mostro la mia ricetta per lo spumone al caffè! Super facile e goloso da preparare senza troppi sforzi.', 0),
(2, 1, 'Questa pasta è buonissima, facile da preparare, colorata e gustosa. Perfetta per tutti i giorni o le domeniche', 0),
(3, 1, 'Poco tempo? Molta fame? Queste fantastiche sfoglie di lasagna con pochissimi ingredienti fanno al caso tuo eh!', 0),
(4, 1, 'Oggi vi presento un dolce tipico della Spagna, la sua bontà è inversamente proporzionale alla sua popolarità... ci siamo capiti :D', 0),
(5, 1, 'Poco tempo e tanta fame? Ecco una ricetta che fa per te :D', 0),
(6, 2, ' Voglia matta di qualcosa di fresco? Non c\'è ricetta più fresh di questa', 0),
(7, 2, 'La stagione delle zuppe è arrivata, e con lei questa ricetta che ti farà impazzire!', 0),
(8, 3, 'Voglia di un fagottino fragoroso e buono? Questa ricetta è per te, buona, speciale e gustosa!', 0),
(9, 3, 'Questi biscotti ti piaceranno! Son buonissimi, croccanti, leggeri e fragorosi. Un perfetto abbraccio per cominciare la giornata :D', 0),
(10, 2, 'Voglia di qualcosa di fresco? Questa zuppa è il top :D', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `gnam_hashtags`
--

CREATE TABLE `gnam_hashtags` (
  `hashtag_id` int(11) NOT NULL,
  `gnam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `gnam_hashtags`
--

INSERT INTO `gnam_hashtags` (`hashtag_id`, `gnam_id`) VALUES
(1, 1),
(1, 3),
(1, 9),
(2, 1),
(2, 3),
(2, 4),
(2, 5),
(2, 9),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 7),
(4, 2),
(5, 2),
(5, 7),
(5, 8),
(5, 10),
(6, 2),
(6, 8),
(7, 3),
(7, 4),
(7, 5),
(7, 8),
(7, 10),
(8, 5),
(9, 5),
(9, 9),
(10, 6),
(11, 6),
(12, 7),
(13, 7),
(13, 8),
(13, 10),
(14, 7),
(15, 8),
(15, 9),
(16, 8),
(17, 9),
(18, 10);

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

--
-- Dump dei dati per la tabella `gnam_ingredients`
--

INSERT INTO `gnam_ingredients` (`ingredient_id`, `gnam_id`, `quantity`, `measurement_unit_id`) VALUES
(1, 1, 200, 1),
(2, 1, 0, 3),
(2, 9, 70, 1),
(3, 2, 250, 1),
(4, 2, 0, 3),
(5, 2, 3, 4),
(5, 7, 1, 4),
(5, 9, 0, 3),
(6, 3, 200, 1),
(7, 3, 0, 3),
(8, 3, 60, 1),
(9, 4, 20, 1),
(10, 4, 150, 2),
(10, 9, 3, 4),
(11, 4, 5, 4),
(12, 7, 30, 1),
(13, 7, 0, 3),
(14, 9, 0, 2),
(15, 10, 0, 3),
(16, 10, 1, 4),
(17, 10, 3, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `hashtags`
--

CREATE TABLE `hashtags` (
  `id` int(11) NOT NULL,
  `text` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `hashtags`
--

INSERT INTO `hashtags` (`id`, `text`) VALUES
(1, 'Facile'),
(2, 'Veloce'),
(3, 'Sano'),
(4, 'Pasta'),
(5, 'Life'),
(6, 'Food'),
(7, 'Buono'),
(8, 'Croccante'),
(9, 'Gustoso'),
(10, 'Arancia'),
(11, 'Frutta'),
(12, 'Calda'),
(13, 'Good'),
(14, 'Fresh'),
(15, 'Dolce'),
(16, 'Speciale'),
(17, 'Fragrante'),
(18, 'Fresco');

-- --------------------------------------------------------

--
-- Struttura della tabella `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`) VALUES
(1, 'Caffe'),
(2, 'Zucchero'),
(3, 'Pasta'),
(4, 'Pomodorini'),
(5, 'Pazienza'),
(6, 'Lattuga'),
(7, 'Forma'),
(8, 'Pasta sfoglia'),
(9, 'Zucchero a velo'),
(10, 'Farina'),
(11, 'Latte'),
(12, 'Zuppa'),
(13, 'Sale'),
(14, 'Acqua'),
(15, 'Sedano'),
(16, 'Salame'),
(17, 'Carota');

-- --------------------------------------------------------

--
-- Struttura della tabella `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `gnam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `likes`
--

INSERT INTO `likes` (`user_id`, `gnam_id`) VALUES
(2, 4),
(3, 6),
(3, 7),
(3, 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `measurement_units`
--

CREATE TABLE `measurement_units` (
  `id` int(11) NOT NULL,
  `name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `measurement_units`
--

INSERT INTO `measurement_units` (`id`, `name`) VALUES
(1, 'gr.'),
(2, 'ml'),
(3, 'qb'),
(4, 'c.ino');

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

--
-- Dump dei dati per la tabella `notifications`
--

INSERT INTO `notifications` (`id`, `source_user_id`, `target_user_id`, `gnam_id`, `notification_type_id`, `timestamp`, `seen`) VALUES
(8, 3, 2, 6, 1, '1705354064', 0),
(9, 3, 2, 6, 2, '1705354070', 0),
(10, 3, 2, 7, 1, '1705354073', 1),
(11, 3, 2, 7, 2, '1705354081', 0),
(14, 2, 1, NULL, 3, '1705354131', 0),
(30, 2, 3, NULL, 3, '1705354282', 0),
(31, 2, 1, 4, 1, '1705354694', 1),
(32, 1, 2, NULL, 3, '1705354854', 0),
(33, 1, 3, NULL, 3, '1705354856', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `notification_types`
--

CREATE TABLE `notification_types` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `template_text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `notification_types`
--

INSERT INTO `notification_types` (`id`, `name`, `template_text`) VALUES
(1, 'like', 'ha messo mi piace ad un tuo gnam'),
(2, 'comment', 'ha commentato un tuo gnam'),
(3, 'follow', 'ha iniziato a seguirti');

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
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `api_key`, `name`, `password`) VALUES
(1, '0002f8cf-b93d-43a0-90ed-dafb98f02bd2', 'Pier', '$2y$10$K9JuFZ2kFIBi3cTfhHiV3eQJgUbJBFK/EH8V7p3SPMUYXQJPLQK5C'),
(2, 'd9f20a1c-a73e-478a-b343-8f0132eb5195', 'Pello', '$2y$10$rMf6QpdVvYf56B7.Gdvjb./PMIcs9.TDwpSz8uJVTRwIHsGgwBk9y'),
(3, '784913f9-3abd-44be-95ee-18b5bba97d30', 'Davide', '$2y$10$5lGgD7aHbW7UH9nCJ0t0huEBz2y/DS9LFnBySSfZuLp3c/oTYocK.');

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
  ADD KEY `fk_nome_chiave_notification` (`notification_type_id`),
  ADD KEY `fk_nome_chiave_sui` (`source_user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `gnams`
--
ALTER TABLE `gnams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `hashtags`
--
ALTER TABLE `hashtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT per la tabella `measurement_units`
--
ALTER TABLE `measurement_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT per la tabella `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
