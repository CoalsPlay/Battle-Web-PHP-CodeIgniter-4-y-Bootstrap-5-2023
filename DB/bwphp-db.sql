-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-05-2023 a las 04:02:18
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bw-php2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arenas_db`
--

CREATE TABLE `arenas_db` (
  `idArena` int(11) UNSIGNED NOT NULL,
  `idUser1` int(11) UNSIGNED NOT NULL,
  `idUser2` int(11) UNSIGNED NOT NULL,
  `atkEnemyArena` int(11) UNSIGNED NOT NULL,
  `defEnemyArena` int(11) UNSIGNED NOT NULL,
  `healthEnemyArena` int(11) UNSIGNED NOT NULL,
  `maxHealthEnemyArena` int(11) UNSIGNED NOT NULL,
  `energyEnemyArena` int(11) UNSIGNED NOT NULL,
  `maxEnergyEnemyArena` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bugs_db`
--

CREATE TABLE `bugs_db` (
  `idBug` mediumint(8) NOT NULL,
  `textBug` varchar(20000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `authorBug` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dateBug` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments_db`
--

CREATE TABLE `comments_db` (
  `idComment` mediumint(8) UNSIGNED NOT NULL,
  `textComment` varchar(20000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `authorComment` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dateComment` date NOT NULL,
  `idNewsComment` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faq_db`
--

CREATE TABLE `faq_db` (
  `idFaq` mediumint(8) UNSIGNED NOT NULL,
  `titleFaq` varchar(500) NOT NULL,
  `descriptFaq` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fights_db`
--

CREATE TABLE `fights_db` (
  `idFight` int(11) UNSIGNED NOT NULL,
  `idUserFight` int(11) UNSIGNED NOT NULL,
  `idEnemyFight` int(11) UNSIGNED NOT NULL,
  `healthEnemyFight` int(11) UNSIGNED NOT NULL,
  `maxHealthEnemyFight` int(11) UNSIGNED NOT NULL,
  `atkEnemyFight` int(11) UNSIGNED NOT NULL,
  `defEnemyFight` int(11) UNSIGNED NOT NULL,
  `timeFight` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friends_db`
--

CREATE TABLE `friends_db` (
  `idFriends` int(11) UNSIGNED NOT NULL,
  `idFriend1` int(11) UNSIGNED NOT NULL,
  `idFriend2` int(11) UNSIGNED NOT NULL,
  `dateFriend` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventories_db`
--

CREATE TABLE `inventories_db` (
  `idInventory` int(11) UNSIGNED NOT NULL,
  `idUserInv` int(11) UNSIGNED NOT NULL,
  `idItemInv` int(11) UNSIGNED NOT NULL,
  `amountItemInv` int(11) UNSIGNED NOT NULL,
  `nameItemInv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maps_categories_db`
--

CREATE TABLE `maps_categories_db` (
  `idCategory` mediumint(8) NOT NULL,
  `nameCategory` varchar(100) NOT NULL,
  `descriptCategory` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maps_db`
--

CREATE TABLE `maps_db` (
  `idMap` mediumint(8) NOT NULL,
  `nameMap` varchar(100) NOT NULL,
  `descriptMap` varchar(10000) NOT NULL,
  `lvlMap` int(11) NOT NULL,
  `idCategoryMap` int(11) NOT NULL,
  `imageMap` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `max_friends`
--

CREATE TABLE `max_friends` (
  `id_user` int(11) NOT NULL,
  `friends` int(11) NOT NULL,
  `max_friends` int(11) NOT NULL DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages_db`
--

CREATE TABLE `messages_db` (
  `idMsg` int(11) UNSIGNED NOT NULL,
  `idAuthorMsg` int(10) UNSIGNED NOT NULL,
  `idReceiverMsg` int(10) UNSIGNED NOT NULL,
  `receiverNameMsg` varchar(255) NOT NULL,
  `titleMsg` varchar(255) NOT NULL,
  `textMsg` varchar(10000) NOT NULL,
  `dateMsg` datetime NOT NULL,
  `statusMsg` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mobs_db`
--

CREATE TABLE `mobs_db` (
  `idMob` int(11) UNSIGNED NOT NULL,
  `nameMob` varchar(50) NOT NULL,
  `descriptMob` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `atkMob` int(11) UNSIGNED NOT NULL,
  `healthMob` int(11) UNSIGNED NOT NULL,
  `maxHealthMob` int(11) UNSIGNED NOT NULL,
  `defMob` int(11) UNSIGNED NOT NULL,
  `expMob` int(11) UNSIGNED NOT NULL,
  `reputationMob` int(11) UNSIGNED NOT NULL,
  `goldMob` int(11) UNSIGNED NOT NULL,
  `frequencyMob` int(11) UNSIGNED NOT NULL,
  `imgMob` varchar(255) NOT NULL,
  `idMapMob` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `news_db`
--

CREATE TABLE `news_db` (
  `idNews` mediumint(8) UNSIGNED NOT NULL,
  `titleNews` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `textNews` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dateNews` datetime NOT NULL,
  `authorNews` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `commentsNews` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requests_db`
--

CREATE TABLE `requests_db` (
  `idRequest` int(11) UNSIGNED NOT NULL,
  `idAuthorRequest` int(11) UNSIGNED NOT NULL,
  `idReceiverRequest` int(11) UNSIGNED NOT NULL,
  `dateRequest` datetime NOT NULL,
  `statusRequest` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings_db`
--

CREATE TABLE `settings_db` (
  `siteName` varchar(255) NOT NULL,
  `siteDescript` varchar(5000) NOT NULL DEFAULT 'Description...',
  `maintenance` enum('0','1') NOT NULL DEFAULT '0',
  `titleMaintenance` varchar(1000) NOT NULL DEFAULT 'Maintenance mode',
  `descriptMaintenance` varchar(5000) NOT NULL DEFAULT 'Description maintenance mode....',
  `intervalExp` int(11) NOT NULL DEFAULT 200,
  `maxLvl` int(11) NOT NULL DEFAULT 100,
  `attributePointsPerLvl` int(11) NOT NULL DEFAULT 3,
  `maxTop` int(11) NOT NULL DEFAULT 10,
  `intervalLvl` int(11) NOT NULL DEFAULT 5,
  `helpFaq` varchar(10000) NOT NULL,
  `emailName` varchar(40) NOT NULL,
  `siteEmail` varchar(255) NOT NULL,
  `maxItemsInventory` int(11) NOT NULL,
  `maxFriends` int(11) NOT NULL,
  `moneyName` varchar(255) NOT NULL,
  `userTwitter` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `settings_db`
--

INSERT INTO `settings_db` (`siteName`, `siteDescript`, `maintenance`, `titleMaintenance`, `descriptMaintenance`, `intervalExp`, `maxLvl`, `attributePointsPerLvl`, `maxTop`, `intervalLvl`, `helpFaq`, `emailName`, `siteEmail`, `maxItemsInventory`, `maxFriends`, `moneyName`, `userTwitter`) VALUES
('BW-PHP', 'Sitio Web hecho con PHP', '0', 'MANTENIMIENTO', 'Estamos en mantenimiento, volveremos lo antes posible.', 500, 98, 10, 10, 10, 'Estas son las preguntas frecuentes que más se suelen hacer los usuarios a la hora de entender el juego. Si no está lo que busca, puedes enviar una pregunta al soporte y te la contestarán de inmediato.', 'BW-PHP ', 'admin@bwphp.com', 64, 30, 'Oro', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shop_db`
--

CREATE TABLE `shop_db` (
  `idItem` int(11) UNSIGNED NOT NULL,
  `nameItem` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `priceItem` int(11) UNSIGNED NOT NULL,
  `descriptionItem` varchar(10000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `imgItem` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `actionItem` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `amountActionItem` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suggestions_db`
--

CREATE TABLE `suggestions_db` (
  `idSuggestion` mediumint(8) UNSIGNED NOT NULL,
  `textSuggestion` varchar(20000) NOT NULL,
  `authorSuggestion` varchar(40) NOT NULL,
  `dateSuggestion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_db`
--

CREATE TABLE `users_db` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `passw` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `tokenPassword` varchar(255) NOT NULL DEFAULT '0',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `rank` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lastAccess` datetime NOT NULL,
  `onlineStatus` enum('0','1') NOT NULL,
  `autoplay` enum('0','1') NOT NULL DEFAULT '1',
  `theme` varchar(255) NOT NULL DEFAULT 'bootstrap.min.css',
  `gender` enum('0','1','2') NOT NULL,
  `aboutMe` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'avatar_default.png',
  `registrationDate` date NOT NULL,
  `registrationTime` time NOT NULL,
  `birthday` date NOT NULL DEFAULT '2001-01-01',
  `accountStatus` enum('0','1') NOT NULL DEFAULT '1',
  `twitter` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `facebook` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `youtube` varchar(255) NOT NULL DEFAULT '',
  `deaths` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `kills` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `reputation` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `ptsAttributes` int(11) UNSIGNED NOT NULL DEFAULT 3,
  `badge` int(11) NOT NULL DEFAULT 1,
  `gold` int(11) UNSIGNED NOT NULL DEFAULT 500,
  `level` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `exp` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `maxExp` int(11) UNSIGNED NOT NULL DEFAULT 300,
  `energy` int(11) UNSIGNED NOT NULL DEFAULT 100,
  `maxEnergy` int(11) UNSIGNED NOT NULL DEFAULT 100,
  `attack` int(11) UNSIGNED NOT NULL DEFAULT 8,
  `maxAttack` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `defense` int(11) UNSIGNED NOT NULL DEFAULT 100,
  `maxDefense` int(11) UNSIGNED NOT NULL DEFAULT 6,
  `health` int(11) UNSIGNED NOT NULL DEFAULT 100,
  `maxHealth` int(11) UNSIGNED NOT NULL DEFAULT 100,
  `time` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users_db`
--

INSERT INTO `users_db` (`id`, `user`, `passw`, `tokenPassword`, `email`, `rank`, `ip`, `lastAccess`, `onlineStatus`, `autoplay`, `theme`, `gender`, `aboutMe`, `avatar`, `registrationDate`, `registrationTime`, `birthday`, `accountStatus`, `twitter`, `facebook`, `youtube`, `deaths`, `kills`, `reputation`, `ptsAttributes`, `badge`, `gold`, `level`, `exp`, `maxExp`, `energy`, `maxEnergy`, `attack`, `maxAttack`, `defense`, `maxDefense`, `health`, `maxHealth`, `time`) VALUES
(36, 'admin', '$2y$10$YEygfuls3rbDN9LLyADANexRQ5.xWrDZOtOdwj/oD64ViGfUXmYTi', '0', 'admin@bwphp.com', 1, '::1', '0000-00-00 00:00:00', '0', '1', 'bootstrap.min.css', '0', '', 'avatar_default.png', '2023-05-09', '01:50:00', '2001-01-01', '1', '', '', '', 0, 0, 0, 3, 1, 500, 1, 0, 300, 100, 100, 8, 1, 100, 6, 100, 100, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `arenas_db`
--
ALTER TABLE `arenas_db`
  ADD PRIMARY KEY (`idArena`);

--
-- Indices de la tabla `bugs_db`
--
ALTER TABLE `bugs_db`
  ADD PRIMARY KEY (`idBug`);

--
-- Indices de la tabla `comments_db`
--
ALTER TABLE `comments_db`
  ADD PRIMARY KEY (`idComment`);

--
-- Indices de la tabla `faq_db`
--
ALTER TABLE `faq_db`
  ADD PRIMARY KEY (`idFaq`);

--
-- Indices de la tabla `fights_db`
--
ALTER TABLE `fights_db`
  ADD PRIMARY KEY (`idFight`);

--
-- Indices de la tabla `friends_db`
--
ALTER TABLE `friends_db`
  ADD PRIMARY KEY (`idFriends`);

--
-- Indices de la tabla `inventories_db`
--
ALTER TABLE `inventories_db`
  ADD PRIMARY KEY (`idInventory`);

--
-- Indices de la tabla `maps_categories_db`
--
ALTER TABLE `maps_categories_db`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indices de la tabla `maps_db`
--
ALTER TABLE `maps_db`
  ADD PRIMARY KEY (`idMap`);

--
-- Indices de la tabla `messages_db`
--
ALTER TABLE `messages_db`
  ADD PRIMARY KEY (`idMsg`);

--
-- Indices de la tabla `mobs_db`
--
ALTER TABLE `mobs_db`
  ADD PRIMARY KEY (`idMob`);

--
-- Indices de la tabla `news_db`
--
ALTER TABLE `news_db`
  ADD PRIMARY KEY (`idNews`);

--
-- Indices de la tabla `requests_db`
--
ALTER TABLE `requests_db`
  ADD PRIMARY KEY (`idRequest`);

--
-- Indices de la tabla `settings_db`
--
ALTER TABLE `settings_db`
  ADD UNIQUE KEY `siteName` (`siteName`);

--
-- Indices de la tabla `shop_db`
--
ALTER TABLE `shop_db`
  ADD PRIMARY KEY (`idItem`);

--
-- Indices de la tabla `suggestions_db`
--
ALTER TABLE `suggestions_db`
  ADD PRIMARY KEY (`idSuggestion`);

--
-- Indices de la tabla `users_db`
--
ALTER TABLE `users_db`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `arenas_db`
--
ALTER TABLE `arenas_db`
  MODIFY `idArena` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `bugs_db`
--
ALTER TABLE `bugs_db`
  MODIFY `idBug` mediumint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comments_db`
--
ALTER TABLE `comments_db`
  MODIFY `idComment` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `faq_db`
--
ALTER TABLE `faq_db`
  MODIFY `idFaq` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `fights_db`
--
ALTER TABLE `fights_db`
  MODIFY `idFight` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `friends_db`
--
ALTER TABLE `friends_db`
  MODIFY `idFriends` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `inventories_db`
--
ALTER TABLE `inventories_db`
  MODIFY `idInventory` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de la tabla `maps_categories_db`
--
ALTER TABLE `maps_categories_db`
  MODIFY `idCategory` mediumint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `maps_db`
--
ALTER TABLE `maps_db`
  MODIFY `idMap` mediumint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `messages_db`
--
ALTER TABLE `messages_db`
  MODIFY `idMsg` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `mobs_db`
--
ALTER TABLE `mobs_db`
  MODIFY `idMob` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `news_db`
--
ALTER TABLE `news_db`
  MODIFY `idNews` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `requests_db`
--
ALTER TABLE `requests_db`
  MODIFY `idRequest` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `shop_db`
--
ALTER TABLE `shop_db`
  MODIFY `idItem` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `suggestions_db`
--
ALTER TABLE `suggestions_db`
  MODIFY `idSuggestion` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users_db`
--
ALTER TABLE `users_db`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
