-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220531.aadb8cc914
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 07 nov 2022 om 21:22
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sopranospizza`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `img`, `description`) VALUES
(1, 'Vlees', 'meat-category.jpg', NULL),
(3, 'Vegan', 'vegan-category.jpg', NULL),
(5, 'Vis', 'fish-category.jpg', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221023224522', '2022-10-23 22:45:35', 42),
('DoctrineMigrations\\Version20221023234619', '2022-10-23 23:46:28', 89),
('DoctrineMigrations\\Version20221024155011', '2022-10-24 15:50:20', 123),
('DoctrineMigrations\\Version20221024163848', '2022-10-24 16:38:53', 75),
('DoctrineMigrations\\Version20221024164614', '2022-10-24 16:46:20', 86),
('DoctrineMigrations\\Version20221025170506', '2022-10-25 17:05:18', 357),
('DoctrineMigrations\\Version20221025191302', '2022-10-25 19:13:06', 41);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'To Do',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymethod` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`id`, `description`, `price`, `user_id`, `status`, `name`, `adress`, `postal`, `email`, `paymethod`) VALUES
(6, 'Vegannetje.35cm (Large).Knoflook Saus!Ansjovis.25cm (Medium).Knoflook Saus ', 9, NULL, 'In Progress', 'Senna Oudshoorn', 'Gilzerijenhof 142', '2631LB', 'sennaoudshoorn@gmail.com', 'IDEAL'),
(7, 'Ansjovis.25cm (Medium).Knoflook Saus', 9, NULL, 'In Progress', 'Senna Oudshoorn', 'Gilzerijenhof 142', '2631LB', 'sennaoudshoorn@gmail.com', 'Contant'),
(8, 'Pepperoni.35cm (Large).Sambal', 12, 2, 'To Do', 'Senna Oudshoorn', 'Gilzerijenhof 142', '2631LB', 'guest@gmail.com2', 'Contant'),
(9, 'Pepperoni.35cm (Large).Sambal', 12, 2, 'To Do', 'Senna Oudshoorn', 'Gilzerijenhof 142', '2631LB', 'guest@gmail.com', 'Contant'),
(10, 'Vegannetje.35cm (Large).Knoflook Saus!Ansjovis.25cm (Medium).Knoflook Saus', 1012, NULL, 'To Do', 'Senna Oudshoorn', 'Gilzerijenhof 142', '2631LB', 'sennaoudshoorn@gmail.com', 'Contant'),
(11, 'Vegannetje.35cm (Large).Knoflook Saus!Ansjovis.25cm (Medium).Knoflook Saus ', 1012, NULL, 'In Progress', 'Senna Oudshoorn', 'Gilzerijenhof 142', '2631LB', 'sennaoudshoorn@gmail.com', 'Contant'),
(13, 'Vegannetje.35cm (Large).Knoflook Saus!Ansjovis.25cm (Medium).Knoflook Saus', 1012, 1, 'To Do', 'Senna Oudshoorn', 'Gilzerijenhof 142', '2631LB', 'admin@gmail.com', 'IDEAL'),
(15, 'Ansjovis.25cm (Medium).Knoflook Saus!Vegan Tomaat.25cm (Medium).Knoflook Saus', 30, 1, 'To Do', 'Senna Oudshoorn', 'Gilzerijenhof 142', '2631LB', 'admin@gmail.com', 'IDEAL');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pizza`
--

CREATE TABLE `pizza` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `pizza`
--

INSERT INTO `pizza` (`id`, `name`, `description`, `price`, `category_id`, `img`) VALUES
(1, 'Pepperoni', 'Pepperoni pizzatje vers uit de oven is echt toppie!', 12.5, 1, 'meat-category.jpg'),
(2, 'Ansjovis', 'Gatverdamme wat is dit ding vies, maarja sommige mensen kopen hem dus hij zit wel in ons schap.', 9.89, 5, 'fish-category.jpg'),
(4, 'Vegannetje', 'Ja als je van konijnen eten houdt', 1002.5, 3, '0edc38b5474c1c79086382b856280f5bedgar-castrejon-rzwe52hDK7w-unsplash.jpg'),
(5, 'Vegan Tomaat', 'Best wel een prima pizza met tomaten, vooral als je vegan bent is deze gewoon dikke prima!', 20.95, 3, 'e5c4a7c383cafd5c7ce7e030613dde74sheri-silver-A4EtgLN1_Fw-unsplash.jpg'),
(6, 'Vegan Spinazie', 'Spinazie pizza is niet echt lekker maarja die vegans hebben toch geen smaak pupillen meer.', 15.65, 3, '09fe7781a1370cace6339a49f76f2dd8engin-akyurt-BlvWaE31wxc-unsplash.jpg'),
(7, 'Gekleurde Advocado', 'Een echt feest taartje, maar dan ook nog eens vegan. Wat wil je nog meer?', 39.12, 3, '61220400c5dbb009cb289a66404c3f93roam-in-color-smN1dzUTj9Y-unsplash.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'admin@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$ZhVf2H2U1xOzKzxD7aqfYu0Sqyl.ycWqJ62L4v24wN0dqAQNTAbpa'),
(2, 'guest@gmail.com', '[]', '$2y$13$lKjjiVWj64NCDMDrAaJuleSEN2atqrQ21qTudfjoFUbaUe9A.1TQS');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexen voor tabel `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `pizza`
--
ALTER TABLE `pizza`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `category_id_2` (`category_id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `pizza`
--
ALTER TABLE `pizza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `pizza`
--
ALTER TABLE `pizza`
  ADD CONSTRAINT `pizza_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



