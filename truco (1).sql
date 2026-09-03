-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-09-2026 a las 04:25:37
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `truco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id` int(11) NOT NULL,
  `puntuacion` tinyint(4) DEFAULT NULL,
  `idPartida` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id` int(11) NOT NULL,
  `buenas` tinyint(1) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `equipo_nosotros` varchar(50) NOT NULL DEFAULT 'Nosotros',
  `puntos_nosotros` int(11) NOT NULL DEFAULT 0,
  `equipo_ellos` varchar(50) NOT NULL DEFAULT 'Ellos',
  `puntos_ellos` int(11) NOT NULL DEFAULT 0,
  `limite_puntos` int(11) NOT NULL DEFAULT 30,
  `ganador` varchar(50) NOT NULL DEFAULT '',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`id`, `buenas`, `idUsuario`, `equipo_nosotros`, `puntos_nosotros`, `equipo_ellos`, `puntos_ellos`, `limite_puntos`, `ganador`, `fecha`) VALUES
(1, NULL, NULL, 'Nosotros', 0, 'Ellos', 30, 30, 'Ellos', '2026-08-30 20:43:04'),
(2, NULL, NULL, 'Nosotros', 30, 'Ellos', 8, 30, 'Nosotros', '2026-09-03 01:45:03'),
(3, NULL, NULL, 'Nosotros', 30, 'Ellos', 11, 30, 'Nosotros', '2026-09-03 01:59:24'),
(4, NULL, NULL, 'Nosotros', 15, 'Ellos', 8, 15, 'Nosotros', '2026-09-03 02:06:03'),
(5, NULL, NULL, 'Nosotros', 15, 'Ellos', 2, 15, 'Nosotros', '2026-09-03 02:08:52'),
(6, NULL, NULL, 'Nosotros', 15, 'Ellos', 0, 15, 'Nosotros', '2026-09-03 02:10:46'),
(7, NULL, NULL, 'Nosotros', 15, 'Ellos', 1, 15, 'Nosotros', '2026-09-03 02:18:29'),
(8, NULL, NULL, 'Nosotros', 15, 'Ellos', 1, 15, 'Nosotros', '2026-09-03 02:19:16'),
(9, NULL, 1, 'Nosotros', 15, 'Ellos', 4, 15, 'Nosotros', '2026-09-03 02:23:39'),
(10, NULL, 1, 'Nosotros', 30, 'Ellos', 11, 30, 'Nosotros', '2026-09-03 02:23:58'),
(11, NULL, 1, 'Nosotros', 15, 'Ellos', 0, 15, 'Nosotros', '2026-09-03 02:25:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `contrasenia` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `contrasenia`) VALUES
(1, 'lauro', '123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partidaFK` (`idPartida`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioFK` (`idUsuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `partidaFK` FOREIGN KEY (`idPartida`) REFERENCES `partida` (`id`);

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `usuarioFK` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
