-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 26, 2023 alle 12:02
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

--
-- Dump dei dati per la tabella `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `gnam_id`, `parent_comment_id`, `text`, `timestamp`) VALUES
(1, 13, 1, NULL, 'Fra bomba! Spacca sta ricetta', '1703587698'),
(2, 14, 1, NULL, 'Assurda bona dura :D', '1703587768'),
(3, 14, 1, 1, 'Concordo!', '1703587858');

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
(12, 13),
(12, 14),
(13, 12);

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
(1, 12, 'Questo è uno gnam di prova, nun ciò voja', 21),
(2, 12, 'Questo è un secondo gnam di prova, nun ciò voja', 21),
(3, 12, 'Questo è un terzo gnam di prova, nun ciò voja', 21),
(4, 13, 'Mi piacciono le ricette gustose', 23),
(5, 14, 'Gnam veloce su impepata di cozze', 34);

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
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 1),
(3, 1),
(4, 1),
(4, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `gnam_ingredients`
--

CREATE TABLE `gnam_ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `gnam_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `measurement_unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `gnam_ingredients`
--

INSERT INTO `gnam_ingredients` (`ingredient_id`, `gnam_id`, `quantity`, `measurement_unit_id`) VALUES
(1, 1, 3, 1),
(2, 1, 12, 1),
(3, 1, 4, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `hashtags`
--

CREATE TABLE `hashtags` (
  `id` int(11) NOT NULL,
  `text` varchar(15) NOT NULL,
  `icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `hashtags`
--

INSERT INTO `hashtags` (`id`, `text`, `icon`) VALUES
(1, 'Healthy', 'prova.jpg'),
(2, 'Pesante', 'prova.jpg'),
(3, 'Untazzo', 'prova.jpg'),
(4, 'Facile', 'prova.jpg');

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
(1, 'Farina'),
(2, 'Formaggio'),
(3, 'Acqua'),
(4, 'Zucchero'),
(5, 'Uova');

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
(13, 1),
(14, 1);

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
(1, 'gr'),
(2, 'ml'),
(3, 'qb'),
(4, 'cucc.');

-- --------------------------------------------------------

--
-- Struttura della tabella `notifications`
--

CREATE TABLE `notifications` (
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

INSERT INTO `notifications` (`source_user_id`, `target_user_id`, `gnam_id`, `notification_type_id`, `timestamp`, `seen`) VALUES
(13, 12, 1, 1, '1703587658', 0),
(14, 12, 1, 1, '1703587463', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `notification_types`
--

CREATE TABLE `notification_types` (
  `id` int(11) NOT NULL,
  `template_text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `notification_types`
--

INSERT INTO `notification_types` (`id`, `template_text`) VALUES
(1, 'ha messo mi piace al tuo gnam'),
(2, 'ha commentato un tuo gnam'),
(3, 'ha iniziato a seguirti');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_picture` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `api_key`, `name`, `password`) VALUES
(12, 'b181e2fa-5ddd-4a4b-aeb3-e73991b80de3', 'Pier', '5bf0ebcaf4201ae8e47d0ca95cb6b74cb6f8d925cab0312705e2a76aa3d6fe73', 'prova.png'),
(13, 'f71082fc-a900-402c-9939-7f6e443de809', 'Davide', '265b636f3d2724bd88e305cfdd9880faa8593cd8839db828a2a03c9920cc11b8', 'prova.png'),
(14, '123e11ec-24c4-45b6-8416-3eafeda8d1c3', 'Pello', '26b223dd8514f0815170156a0e797ab24d0fb6ff4ea361646435127d29880bcf', 'prova.png');

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
  ADD PRIMARY KEY (`source_user_id`,`target_user_id`,`timestamp`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `gnams`
--
ALTER TABLE `gnams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `hashtags`
--
ALTER TABLE `hashtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `measurement_units`
--
ALTER TABLE `measurement_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
