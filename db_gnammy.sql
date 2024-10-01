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
(1, 1, 'Looking for an idea for a tasty and creative breakfast? Try these Pistachio Crepes with sugar-free pistachio chocolate. A sweet yet light dish to start your day off right', 0),
(2, 1, 'LOW CARB ZUCCHINI LASAGNA 😋 IN 25 MINUTES! If you love lasagna too, you absolutely have to try this version with zucchini! ONLY 89kcal per serving, SUPER EASY and super tasty! So, will you try it?? 🤩 Leave a “LIKE” as your way of saying thank you 🙏🏻❤️\r\n', 5),
(3, 1, '🥔 3-INGREDIENT FLOURLESS FLATBREAD 😋 Gluten-free, no leavening! If you love flatbreads too, you absolutely have to try this version with potatoes! They are ready in 10 minutes, SUPER SOFT and super elastic! ONLY 73kcal per flatbread 😍 Did you know about them?', 9),
(4, 2, '🍓RED BERRY TIRAMISU 😋 Lactose-free, gluten-free, no added sugars! This will become one of your favorite desserts, shall we bet? 🥰 A super creamy yet light tiramisu, ready in 5 minutes, and it’s really SUITABLE FOR EVERYONE! 🤩\r\nI chose Céréal Almond Madeleines as the base, super soft, gluten-free, sugar-free, and dairy-free!', 21),
(5, 2, '🍫PROTEIN CLOUD CAKE 5 INGREDIENTS ❌ Flourless, lactose-free, no added sugars! 😋 Do you have egg whites in the fridge and dont know how to use them? This low-carb cake is just for you! SUPER EASY and suitable for everyone‼️ Shall we bet it will become your favorite breakfast/snack? 🥰', 3),
(6, 2, 'ZUCCHINI PANCAKES ONLY 3 INGREDIENTS 😋 Ready in 5 minutes! Leave a “LIKE” as your way of saying thank you 🙏🏻❤️', 1),
(7, 3, '🍫CHOCOLATE TRUFFLES 3 INGREDIENTS ❌ Egg-free, gluten-free, no added sugars 😋 If you always crave something sweet after lunch/dinner, these soft, low-calorie truffles are just for YOU! With ONLY 89 calories, they will steal your heart... They’re ready in minutes and eaten in seconds 🤪', 165),
(8, 4, '🥔 VEGETABLE ROLL 3 INGREDIENTS 🥕 LOW CARB! 😋 If you love rolls too, you absolutely have to try this vegetable version! SUPER EASY, light, and super tasty; you can fill it as I did, or make a thousand other variations... so, will you try it?? 🤩', 15),
(9, 4, '🌱CHICKPEA CUTLETS ONLY 2 INGREDIENTS ❌ Egg-free, flour-free! Hope you like them.', 0),
(10, 3, '🍯GRANOLA IN 5 MINUTES 😋 ONLY 4 INGREDIENTS! If you love crunchy cereals for breakfast too, you can’t miss this homemade granola! Perfect in both milk and yogurt, it’s ready in 5 minutes, and suitable for everyone... I chose Céréal Oat Bran as the base, rich in fiber, protein, vitamins, and minerals!\r\nSo, will you try it?? 🤩', 0);

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
(1, 'Pistachio'),
(2, 'Sweet'),
(3, 'Chocolate'),
(4, 'Easy'),
(5, 'Healthy'),
(6, 'Lunch'),
(7, 'Good'),
(8, 'Quick'),
(9, 'Flatbread'),
(10, 'Naan'),
(11, 'Food'),
(12, 'Healthy'),
(13, 'Potatoes'),
(14, 'Fresh'),
(15, 'Brownies'),
(16, 'LowCarb'),
(17, 'Pancakes'),
(18, 'Zucchini'),
(19, 'Fluffy'),
(20, 'Sandwich'),
(21, 'Pudding'),
(22, 'Pudding'),
(23, 'Flourless'),
(24, 'Roll'),
(25, 'Carrots'),
(26, 'Cutlet'),
(27, 'Chickpeas'),
(28, 'Veggie'),
(29, 'Granola'),
(30, 'Crunchy'),
(31, 'Breakfast');

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
(1, 'Zucchini'),
(2, 'Tomato sauce'),
(3, 'Mozzarella'),
(4, 'Potatoes'),
(5, 'Potato starch'),
(6, 'Water'),
(7, 'Salt'),
(8, 'Yogurt'),
(9, 'Cheese'),
(10, 'Sugar'),
(11, 'Sprinkles'),
(12, 'Egg white'),
(13, 'Cocoa'),
(14, 'Chocolate'),
(15, 'Egg'),
(16, 'Flour'),
(17, 'Milk'),
(18, 'Starch'),
(19, 'Chickpeas'),
(20, 'Starch'),
(21, 'Spices'),
(22, 'Bran'),
(23, 'Fruit'),
(24, 'Oil'),
(25, 'Honey');

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
(4, 'tbsp'),
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
(1, 'like', 'liked your gnam'),
(2, 'comment', 'commented on your gnam'),
(3, 'follow', 'started following you');

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
