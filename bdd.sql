-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 26, 2020 at 08:46 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `miam`
--
CREATE DATABASE 'miam';
-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `image`) VALUES
(1, 'Soupes', 'Une petite faim, Une entrée, une diet ? Pourquoi pas une soupe! Découvrez notre sélection de recettes pour réaliser vos plus belles soupes de manière simple et rapide. ', 'soupe.jpg'),
(2, 'Viandes', 'Un dîner entre amis et vous n\'avez pas le temps de préparer un repas au four? Pas de problème, nos recettes sont là pour vous aider!', 'viande.jpg'),
(3, 'Poissons', 'Et bien non ce n\'est pas un poisson d\'Avril!  Ce sont bien des recettes de poissons au micro-ondes! cuisson réussie à 100%!', 'poisson.jpg'),
(4, 'Accompagnements', 'Plusieurs accompagnements disponibles, pour n\'importe quel plat! Légumes, sauces? régalez-vous!', 'accompagnement.jpg'),
(5, 'Desserts', 'Un dessert! oui bien sûr chers internautes, c\'est possible! ', 'dessert.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `recipes_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `recipes_id`, `user_id`, `content`, `date`) VALUES
(1, 1, 7, 'test', '2020-07-09 14:44:14'),
(2, 1, 7, 'test', '2020-07-09 14:44:46'),
(3, 1, 7, 'test', '2020-07-09 14:45:01'),
(4, 11, 9, 'Vraiment pas mal, ce moelleux !', '2020-07-23 22:01:09'),
(5, 11, 9, 'c\'est bon les gateaux', '2020-07-24 12:04:13'),
(6, 18, 7, 'j\'aime le kiri', '2020-07-24 12:36:41');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200705110755', '2020-07-05 11:08:02', 367),
('DoctrineMigrations\\Version20200705154815', '2020-07-05 15:48:29', 185),
('DoctrineMigrations\\Version20200707085113', '2020-07-07 08:51:51', 118),
('DoctrineMigrations\\Version20200707085411', '2020-07-07 08:54:22', 149),
('DoctrineMigrations\\Version20200707085742', '2020-07-07 08:57:48', 142),
('DoctrineMigrations\\Version20200707093759', '2020-07-07 09:38:04', 123),
('DoctrineMigrations\\Version20200707192135', '2020-07-07 19:22:09', 247),
('DoctrineMigrations\\Version20200707194110', '2020-07-07 19:41:16', 253),
('DoctrineMigrations\\Version20200707200323', '2020-07-07 20:03:31', 236),
('DoctrineMigrations\\Version20200709141745', '2020-07-09 14:17:53', 273),
('DoctrineMigrations\\Version20200709144131', '2020-07-09 14:41:34', 181),
('DoctrineMigrations\\Version20200720162545', '2020-07-20 16:54:25', 290),
('DoctrineMigrations\\Version20200724125735', '2020-07-24 12:58:55', 271),
('DoctrineMigrations\\Version20200724141108', '2020-07-24 14:11:27', 292),
('DoctrineMigrations\\Version20200726130511', '2020-07-26 16:26:49', 493);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `information` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingredient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  `vote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`id`, `category_id`, `title`, `information`, `ingredient`, `content`, `image`, `date`, `comment`, `vote`) VALUES
(1, 1, 'Velouté aux asperges', '20 MIN (900W) pour 6 personnes', '800g d\'asperges blanches, 3 pommes de terre, 30g de beurre, 30cl de lait écrémé, sel et poivre', 'Retirez la base des asperges. Grattez et rincez-les, puis coupez-les en morceaux.\r\n\r\nEpluchez les pommes de terre, rincez-les et coupez-les en rondelles, déposez le tout dans une cocotte adaptée au micro-ondes avec le beurre en morceaux, couvrez et faites cuire 5 minutes en mélangeant à mi-cuisson.\r\n\r\nRecouvrez de lait et 70cl d\'eau, assaisonnez, poursuivez la cuisson 15 minutes. Mixez.', 'veloute_asperge.jpg', '2020-07-05 13:19:03', NULL, 47),
(8, 2, 'Rôti de porc à la bière', '41 MIN à 900W, pour 4 personnes', '1 rôti de 1kg, 50cl de bière blonde, 2 c.à.s de moutarde, 50g de crème fraîche liquide, sel et poivre', 'Mélangez la bière et la moutarde dans une cocotte adaptée au micro-ondes. Couvrez et faites cuire 6 minutes au micro-ondes.\r\nDéposez le rôti sur la sauce, faites quelques incisions avec la pointe d\'un couteau sur toute sa longueur, salez, poivrez et faites cuire pendant 35 minutes à couvert.\r\nDéposez le rôti sur un plat de service. Ajoutez la crème à la sauce chaude et mélangez. Nappez le rôti de sauce et servez.', 'porc_roti_biere.jpg', '2020-07-06 13:16:54', NULL, 1),
(9, 3, 'Moules marinières', '12 MIN à 900W, pour 4 personnes', '1L de moules de bouchot, 1 tomate, 2 échalotes, 1 gousse d\'ail, 1 oignon, 1 c.a.s d\'huile d\'olive, 20 cl de vin blanc sec, 2 c.a.s de persil plat ciselé et poivre', 'Rincez et grattez les moules. Rincez et coupez la tomate en rondelles.\r\nEpluchez les échalotes, l\'ail et l\'oignon, et émincez-les finement. Versez-les dans une cocotte adaptée au micro-ondes avec les rondelles de tomate et l\'huile d\'olive.\r\nRecouvrez de vin blanc, ajoutez une pincée de poivre et faites cuire à couvert pendant 6 minutes au micro-ondes.\r\nAjoutez les moules et poursuivez la cuisson 3 minutes. Mélangez et faites de nouveau cuire 3 minutes. Saupoudrez de persil et de poivre, mélangez et servez immédiatement. \r\nAstuce: La cuisson est optimal quand toutes les moules sont ouvertes!', 'moule.jpg', '2020-07-06 13:24:18', NULL, 0),
(10, 4, 'Gratin presque dauphinois', '13 MIN 30 à 900W, pour 4 personnes', '8 grosses pommes de terre, 1 gousse d\'ail, 10cl de lait entier, 10cl de crème fraîche liquide, 1 pincée de muscade, 20g de beurre demi-sel, 35g de gruyère râpé, sel et poivre', 'Epluchez et écrasez l\'ail. Frottes-le au fond d\'un plat à gratin adapté au micro-ondes. Epluchez et émincez finement les pommes de terre, puis répartissez-les dans le plat. Faites chauffer le lait 30 secondes au micro-ondes et versez-le dans le plat. Mélangez la crème avec la muscade et nappez-en les pommes de terre.\r\nParsemez de noisette de beurre, couvre et faites cuire 12 minutes au micro-ondes. Ajoutez le fromage, assaisonnez et prolongez la cuisson à découvert de 1 minute.', 'dauphinois.jpg', '2020-07-06 13:31:37', NULL, 0),
(11, 5, 'Moelleux au chocolat', '6 MIN à 800W, repos 10 MIN, pour 4 personnes', '130g de chocolat noir à pâtisser, 125g de beurre, 3 oeufs, 50g de sucre en poudre, 60g de farine, 1/2 sachet de levure chimique', 'Cassez le chocolat en morceaux et faites-le fondre au micro-ondes avec le beurre pendant 1 minute environ. Mélangez et réservez. Fouettez les oeufs avec le sucre. Ajoutez la farine et la levure, mélangez à nouveau. Répartissez la pâte dans un moule et faites cuire 5 minutes au micro-ondes. Laissez reposer pendant 10 minutes.\r\nAstuce: Glissez des carrés de chocolat noir au centre après 3 minutes de cuisson pour un coeur coulant.', 'moelleux_chocolat.jpg', '2020-07-06 13:38:52', NULL, 0),
(18, 1, 'Crème de courgette au kiri', '13 MIN à 900W, pour 6 personnes', '1,2kg de courgettes, 1 oignon, 3 kiri, 1,5L de bouillon de légumes, 2 c.à.s de ciboulette ciselé, sel et poivre', 'Rincez les courgettes, retirez l\'extrémité et coupez-les en rondelles. Epluchez l\'oignon et émincez-le.\r\nPlacez-les dans une cocotte adaptée au micro-ondes, recouvrez de bouillon et faites cuire 13 minutes à couvert.\r\nParsemez de ciboulette, incorporez les Kiri®, rectifiez l\'assaisonnement et mixez.', 'creme_courgette.webp', '2020-07-24 10:29:36', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reset_password_request`
--

INSERT INTO `reset_password_request` (`id`, `user_id`, `selector`, `hashed_token`, `requested_at`, `expires_at`) VALUES
(2, 6, 'jbCkm40GgviEtPZnTTjQ', 'FJHkZtm7ikwKd88uk4O1VYzQRvthal6PDYL0r0XcmEs=', '2020-07-22 15:35:30', '2020-07-22 16:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `username`) VALUES
(6, 'yoann.rodrigo@gmail.com', '[\"ROLE_USER\"]', '$2y$13$bEcTrxV56n1Slz1QtKeDy.HxCgC7ZmE9mpwjv66G/bsUDvG0PCL8W', 'Yoann'),
(7, 'tay.valade@gmail.com', '{\"1\": \"ROLE_USER\", \"2\": \"ROLE_ADMIN\"}', '$2y$13$a250xMzIhs6KONAjrC.rQOu.GC.Vx5zSOxaxOtuw9yecCUyoG6dMu', 'Tay'),
(9, 'jarvis@gmail.com', '[\"ROLE_USER\"]', '$2y$13$9rICUWetS2tP7Z104eSFbOwS7R2agOiIdv79KptBiGQWre5I30MUy', 'Jarvis');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526CFDF2B1FA` (`recipes_id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E46960F5A76ED395` (`user_id`),
  ADD KEY `IDX_E46960F559D8A214` (`recipe_id`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DA88B13712469DE2` (`category_id`);

--
-- Indexes for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9474526CFDF2B1FA` FOREIGN KEY (`recipes_id`) REFERENCES `recipe` (`id`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `FK_E46960F559D8A214` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`),
  ADD CONSTRAINT `FK_E46960F5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `FK_DA88B13712469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
