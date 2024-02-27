-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 27, 2024 alle 10:59
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
(1, 1, 1, NULL, 'Ecco il mio primo gnam ragazzi, spero vi piaccia, se avete domande ditemi pure :D', '1709023765'),
(2, 2, 3, NULL, 'Sembrano ottime per i pranzi in uni!', '1709025270'),
(3, 3, 1, 1, 'Sembra ottima!', '1709026646'),
(4, 3, 6, NULL, 'Gnammm :)', '1709026662'),
(5, 3, 3, 2, 'Vero!', '1709026682'),
(6, 3, 4, NULL, 'Assurda sembra buonissima. In questi giorni proverò a farla', '1709026707'),
(7, 4, 6, NULL, 'Buone, sembrano anche molto salutari e gustose', '1709027149'),
(8, 4, 6, 4, 'Gnam siii, nuova ricetta preferita', '1709027163'),
(9, 4, 5, NULL, 'Questa me la salvo, squisito!', '1709027177'),
(10, 3, 2, NULL, 'Al posto delle zucchine posso usare le melanzane anche?', '1709027682'),
(11, 1, 2, 10, 'Certo. Cambia un po\' il sapore ma dovrebbe venire un\'ottimo piatto', '1709027712');

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
(1, 4),
(2, 1),
(2, 3),
(2, 4),
(3, 2),
(3, 4);

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
(1, 1, 'Cerchi un’idea per una colazione golosa e creativa? Prova queste Crepes al pistacchio con cioccolato al pistacchio senza zuccheri. Un piatto dolce ma leggero per iniziare la giornata al meglio', 0),
(2, 1, 'LASAGNA DI ZUCCHINE LOW CARB 😋 IN 25 MINUTI! Se anche tu ami la lasagna, questa versione con le zucchine non puoi assolutamente non provarla! SOLO 89kcal a porzione, FACILISSIMA e super sfiziosa! Insomma, la proverai?? 🤩 Lascia un “MI PIACE” è il tuo modo di dirmi grazie 🙏🏻❤️\r\n', 5),
(3, 1, '🥔 PIADINE SENZA FARINA 3 INGREDIENTI 😋 Senza glutine, senza lievitazione! Se anche tu ami le piadine, devi assolutamente provare questa versione con le patate! Si preparano in 10 minuti, sono MORBIDISSIME e super elastiche! SOLO 73kcal per piadina 😍 E tu, le conoscevi?', 9),
(4, 2, '🍓TIRAMISÙ AI FRUTTI ROSSI 😋 Senza lattosio, senza glutine, senza zuccheri aggiunti! Questo diventerà uno dei tuoi dolci preferiti, scommettiamo?🥰 Un tiramisù cremosissimo ed allo stesso tempo leggero, si prepara in 5 minuti ed è davvero ADATTO A TUTTI! 🤩\r\nIo come base ho scelto le Madeleine alle Mandorle di Céréal, super morbide, senza glutine, senza zuccheri aggiunti e senza latte!', 21),
(5, 2, '🍫 TORTA NUVOLA PROTEICA 5 INGREDIENTI ❌ Senza farina, senza lattosio, senza zuccheri aggiunti! 😋 Hai dell’albume in frigo e non sai come consumarlo? Questa torta low carb allora fa proprio al caso tuo! FACILISSIMA ed è adatta proprio a tutti‼️ Scommettiamo che diventerà la tua colazione/merenda preferita?🥰', 3),
(6, 2, 'PANCAKES DI ZUCCHINE SOLO 3 INGREDIENTI 😋 Pronti in 5 minuti! Lascia un “MI PIACE” è il tuo modo di dirmi grazie 🙏🏻❤️', 1),
(7, 3, '🍫TARTUFINI AL CIOCCOLATO 3 INGREDIENTI ❌ Senza uova, senza glutine, senza zuccheri aggiunti 😋 Se anche tu dopo pranzo/cena hai sempre voglia di dolce, questi tartufini morbidi con poche calorie, fanno proprio al CASO TUO! Con SOLO 89 calorie, ti ruberanno il cuore… Si preparano in pochissimi minuti e si divorano in pochissimi secondi 🤪', 165),
(8, 4, '🥔 ROTOLO DI VERDURE 3 INGREDIENTI 🥕 LOW CARB! 😋 Se anche tu ami i rotoli, questa versione di verdure non puoi assolutamente non provarla! FACILISSIMO, light, e super sfizioso; puoi farcirlo come ho fatto io, o prepararne di mille altre varianti… insomma, lo proverai?? 🤩', 15),
(9, 4, '🌱COTOLETTE DI CECI SOLO 2 INGREDIENTI ❌ Senza uova, senza farina! Spero vi piacciano.', 0),
(10, 3, '🍯 GRANOLA IN 5 MINUTI 😋 SOLO 4 INGREDIENTI! Se a colazione anche tu ami i cereali croccanti, non puoi non provare questa granola fatta in casa! Perfetta sia nel latte che nello yogurt, si prepara in 5 minuti, ed è adatta proprio a tutti... Io ho scelto come base la Crusca d\'avena Céréal, ricca di fibre, proteine, vitamine e minerali!\r\nInsomma, la proverai?? 🤩', 0);

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
(2, 1),
(2, 4),
(2, 5),
(2, 10),
(3, 1),
(3, 5),
(3, 7),
(4, 2),
(4, 10),
(5, 2),
(5, 5),
(5, 9),
(6, 2),
(6, 3),
(7, 2),
(8, 2),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(13, 8),
(14, 4),
(15, 5),
(16, 5),
(17, 6),
(18, 6),
(19, 6),
(20, 6),
(21, 7),
(22, 7),
(23, 7),
(24, 8),
(25, 8),
(26, 9),
(27, 9),
(28, 9),
(29, 10),
(30, 10),
(31, 10);

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
(1, 2, 500, 1),
(1, 6, 250, 1),
(2, 2, 300, 1),
(3, 2, 0, 3),
(4, 3, 41.6667, 1),
(5, 3, 12.5, 1),
(6, 3, 2.5, 2),
(7, 3, 0, 3),
(7, 6, 0, 3),
(7, 10, 0, 3),
(8, 4, 150, 1),
(9, 4, 250, 1),
(10, 4, 50, 1),
(10, 5, 50, 1),
(11, 4, 0, 3),
(12, 5, 250, 2),
(13, 5, 1, 4),
(13, 7, 50, 1),
(14, 5, 0, 3),
(15, 6, 1, 5),
(16, 6, 40, 1),
(17, 7, 1000, 2),
(18, 7, 90, 1),
(19, 9, 66.6667, 1),
(20, 9, 1.33333, 4),
(21, 9, 0, 3),
(22, 10, 200, 1),
(23, 10, 100, 1),
(24, 10, 50, 1),
(25, 10, 50, 1);

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
(1, 'Pistacchio'),
(2, 'Dolce'),
(3, 'Cioccolato'),
(4, 'Facile'),
(5, 'Sano'),
(6, 'Pranzo'),
(7, 'Buono'),
(8, 'Veloce'),
(9, 'Piadina'),
(10, 'Naan'),
(11, 'Cibo'),
(12, 'Healthy'),
(13, 'Patate'),
(14, 'Fresh'),
(15, 'Brownies'),
(16, 'LowCarb'),
(17, 'Pancakes'),
(18, 'Zucchine'),
(19, 'Fluffy'),
(20, 'Sandwich'),
(21, 'Budino'),
(22, 'Pudding'),
(23, 'SenzaFarina'),
(24, 'Rotolo'),
(25, 'Carote'),
(26, 'Cotoletta'),
(27, 'Ceci'),
(28, 'Veggie'),
(29, 'Granola'),
(30, 'Crunchy'),
(31, 'Colazione');

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
(1, 'Zucchine'),
(2, 'Salsa di pomodoro'),
(3, 'Mozzarella'),
(4, 'Patate'),
(5, 'Fecola di patate'),
(6, 'Acqua'),
(7, 'Sale'),
(8, 'Yogurt'),
(9, 'Formaggio'),
(10, 'Zucchero'),
(11, 'Granella'),
(12, 'Albume'),
(13, 'Cacao'),
(14, 'Cioccolato'),
(15, 'Uovo'),
(16, 'Farina'),
(17, 'Latte'),
(18, 'Amido'),
(19, 'Ceci'),
(20, 'Fecola'),
(21, 'Spezie'),
(22, 'Crusca'),
(23, 'Frutta'),
(24, 'Olio'),
(25, 'Miele');

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
(1, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 6),
(4, 5),
(4, 6),
(4, 8);

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
(4, 'c.ino'),
(5, 'u.tà');

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
(1, 2, 1, 3, 1, '1709025247', 0),
(2, 2, 1, 3, 2, '1709025270', 0),
(3, 3, 1, 1, 1, '1709026637', 0),
(4, 3, 1, 1, 2, '1709026646', 0),
(5, 3, 2, 6, 1, '1709026655', 0),
(6, 3, 2, 6, 2, '1709026662', 0),
(7, 3, 1, 3, 1, '1709026671', 0),
(8, 3, 1, 3, 2, '1709026682', 0),
(9, 3, 2, 4, 1, '1709026687', 0),
(10, 3, 2, 4, 2, '1709026707', 0),
(11, 4, 2, 6, 1, '1709027135', 0),
(12, 4, 2, 6, 2, '1709027149', 0),
(13, 4, 2, 6, 2, '1709027163', 0),
(14, 4, 2, 5, 1, '1709027168', 0),
(15, 4, 2, 5, 2, '1709027177', 0),
(16, 3, 1, 2, 1, '1709027665', 0),
(17, 3, 1, 2, 2, '1709027682', 1),
(18, 2, 1, NULL, 3, '1709027782', 0),
(19, 2, 3, NULL, 3, '1709027797', 0),
(20, 2, 4, NULL, 3, '1709027800', 0),
(21, 1, 2, NULL, 3, '1709027817', 0),
(22, 1, 3, NULL, 3, '1709027822', 0),
(23, 1, 4, NULL, 3, '1709027827', 0),
(24, 3, 4, NULL, 3, '1709027839', 0),
(25, 3, 2, NULL, 3, '1709027842', 0);

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
(1, '92152d55-aa29-4a8f-b497-7a21ce568951', 'user', '$2y$10$cKp3JI42UnuFKWY7u.bkW.vMutF7CgiPAsuoP5C/4Kq5COWPER.5u'),
(2, '7f6408d2-089e-4a0e-b080-9d1d57cd7442', 'Pier', '$2y$10$1MhkY67WHgUyhnELMGHamOibe6h1nBH1CL83bWt8pFdOw/YNpHi7m'),
(3, 'd72b23d7-27a5-4620-a35e-f104fad43d84', 'Pello', '$2y$10$0KEUzUxjgNGhaPJv8A7wo.tjx762bay5HHbFZSOS79P870iIaclgi'),
(4, 'f4d320ab-42d9-4adf-aec3-9f6d920ad9af', 'Davide', '$2y$10$mPRHj2gffAVZIgVyS/iIWu0ZXFIBch0diNA4SNbrQeEydouiRlXqe');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `gnams`
--
ALTER TABLE `gnams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `hashtags`
--
ALTER TABLE `hashtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT per la tabella `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT per la tabella `measurement_units`
--
ALTER TABLE `measurement_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT per la tabella `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
