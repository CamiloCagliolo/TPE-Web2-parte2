-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2022 a las 05:26:12
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_exoplanets`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exoplanets`
--

CREATE TABLE `exoplanets` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mass` float NOT NULL,
  `radius` float NOT NULL,
  `id_method` int(11) NOT NULL,
  `id_star` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `exoplanets`
--

INSERT INTO `exoplanets` (`id`, `name`, `mass`, `radius`, `id_method`, `id_star`) VALUES
(2, 'Beta Pictoris b', 12.7, 1.5, 5, 1),
(3, '51 Eridani b', 2.6, 1.5, 2, 3),
(4, 'HR 8799 e', 7, 1.3, 1, 4),
(5, 'HR 8799 d', 7, 1.3, 1, 4),
(6, 'HR 8799 c', 7, 1.3, 1, 4),
(7, 'HR 8799 b', 5, 1.2, 1, 4),
(8, 'HD 95086 b', 5, 2.3, 3, 5),
(9, 'Gliese 504 b', 4, 2.5, 3, 6),
(15, '2M1207b', 4.2, 1.5, 9, 15),
(16, '1RXS 1609 b', 10, 1.7, 9, 16),
(17, '2M J044144 b', 7, 2.1, 9, 17),
(18, 'Fomalhaut b', 1.7, 1.5, 5, 18),
(19, 'WD 0806-661 B', 7, 1.6, 9, 19),
(20, 'Ross 458(AB) c', 8.5, 1.8, 9, 20),
(21, 'HD 106906 b', 11, 2.1, 1, 21),
(22, 'GU Piscium b', 11, 2.4, 9, 22),
(23, 'PDS 70 b', 1.8, 1.2, 7, 23),
(24, 'PDS 70 c', 1.9, 1.5, 6, 23),
(25, 'HD 203030 B', 11, 3.1, 6, 24),
(38, 'coco', 2, 1, 3, 40),
(39, 'Prueba 2', 11, 11, 3, 37),
(40, 'Prueba 3', 11, 11, 3, 39),
(41, 'Prueba 4', 11, 11, 3, 39),
(42, 'Prueba 5', 11, 11, 3, 40),
(43, 'Prueba 6', 11, 11, 7, 40),
(44, 'AB Aurigae b', 9, 2.75, 5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `methods`
--

CREATE TABLE `methods` (
  `id` int(11) NOT NULL,
  `name_acronym` varchar(10) NOT NULL,
  `name_complete` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `methods`
--

INSERT INTO `methods` (`id`, `name_acronym`, `name_complete`) VALUES
(1, 'ADI', 'Angular Differential Imaging'),
(2, 'KLIP', 'Karhunen–Loève Image Processing'),
(3, 'LOCI', 'Locally Optimized Combination of Images'),
(4, 'NRM', 'Non-Redundant Aperture Masking Interferometry'),
(5, 'RSDI', 'Reference Star Differential Imaging'),
(6, 'SDI', 'Spectral Differential Imaging'),
(7, 'TLOCI', 'Template Locally Optimized Combination of Images'),
(9, '(Direct)', 'Direct Imaging');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stars`
--

CREATE TABLE `stars` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mass` float NOT NULL,
  `radius` float NOT NULL,
  `distance` float NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `stars`
--

INSERT INTO `stars` (`id`, `name`, `mass`, `radius`, `distance`, `type`) VALUES
(1, 'Beta Pictoris', 1.75, 1.8, 63.4, 'A6V'),
(2, 'AB Aurigae', 2.4, 2.5, 531, 'A0Ve'),
(3, '51 Eridani', 1.75, 1.45, 96, 'F0V'),
(4, 'HR 8799', 1.43, 1.34, 133.2, 'kA5'),
(5, 'HD 95086', 1.6, 1.9, 282, 'A8'),
(6, '59 Virginis', 1.16, 1.36, 57.4, 'G0V'),
(7, 'Kappa Andromedae', 2.768, 2.29, 168, 'B9IVn'),
(15, '2M1207', 0.025, 0.25, 211, 'M8p'),
(16, '1RXS J160929.1−210524', 0.85, 1.35, 456, 'K7V'),
(17, '2M J044144', 0.2, 0.8, 400, 'M8.5'),
(18, 'Fomalhaut', 1.92, 1.842, 25.13, 'A3V'),
(19, 'WD 0806−661', 0.58, 0.87, 62.8, 'DQ4.2'),
(20, 'DT Virginis', 0.553, 0.473, 37.53, 'M0.5'),
(21, 'HD 106906', 1.67, 2.03, 337, 'F5V'),
(22, 'GU Piscium', 0.66, 0.54, 155.3, 'M3'),
(23, 'PDS 70', 0.76, 1.26, 370, 'K7'),
(24, 'HD 203030', 0.965, 0.86, 128.2, 'K0V'),
(37, 'Prueba 1', 1, 1, 0, 'bbb'),
(38, 'Prueba 2', 1, 1, 2, 'aaa'),
(39, 'Prueba 3', 1, 1, 2, 'aaa'),
(40, 'Prueba 4', 1, 1, 2, 'aaa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user` varchar(40) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user`, `password`) VALUES
('camilo', '$argon2id$v=19$m=65536,t=4,p=1$NXQxVjA2NFdlLzJZMFlreg$ntwU1jYkWI8cctWTMlP5Oykw1Kf7XLt8WQuKle6nNRg'),
('invitado', '$argon2id$v=19$m=65536,t=4,p=1$YkpNSmd2R3ZjNmpXUmdscg$p4BzXGGfeEAMdc7eZth8Hkv1ZIngPXbY1O7wy2DDimE'),
('quomilito', '$2y$10$qd2yyK0RwlL5Ez5jpE5FD.CG42S5uFVjYf0MTYSfENJuQ3DLc7ZFm');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `exoplanets`
--
ALTER TABLE `exoplanets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_method` (`id_method`) USING BTREE,
  ADD KEY `id_star` (`id_star`);

--
-- Indices de la tabla `methods`
--
ALTER TABLE `methods`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stars`
--
ALTER TABLE `stars`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `exoplanets`
--
ALTER TABLE `exoplanets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `methods`
--
ALTER TABLE `methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `stars`
--
ALTER TABLE `stars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `exoplanets`
--
ALTER TABLE `exoplanets`
  ADD CONSTRAINT `exoplanets_ibfk_1` FOREIGN KEY (`id_method`) REFERENCES `methods` (`id`),
  ADD CONSTRAINT `exoplanets_ibfk_2` FOREIGN KEY (`id_star`) REFERENCES `stars` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
