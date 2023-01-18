-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 18-01-2023 a las 21:23:08
-- Versión del servidor: 8.0.29
-- Versión de PHP: 8.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `appsalon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citasservicios`
--

CREATE TABLE `citasservicios` (
  `id` int NOT NULL,
  `citaId` int DEFAULT NULL,
  `servicioId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ta_citas`
--

CREATE TABLE `ta_citas` (
  `id` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `fk_usuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ta_citas`
--

INSERT INTO `ta_citas` (`id`, `fecha`, `hora`, `fk_usuario`) VALUES
(15, '2023-01-18', '13:50:00', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ta_productos`
--

CREATE TABLE `ta_productos` (
  `id` int DEFAULT NULL,
  `producto` varchar(60) NOT NULL,
  `precio` decimal(5,3) NOT NULL,
  `cantidad` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ta_servicios`
--

CREATE TABLE `ta_servicios` (
  `id` int NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `precio` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ta_servicios`
--

INSERT INTO `ta_servicios` (`id`, `nombre`, `precio`) VALUES
(24, 'Corte Hombre', '12.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ta_usuarios`
--

CREATE TABLE `ta_usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `apellido` varchar(60) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` char(60) NOT NULL,
  `telefono` char(10) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `token` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ta_usuarios`
--

INSERT INTO `ta_usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `telefono`, `admin`, `confirmado`, `token`) VALUES
(2, 'Administrador', 'Administrador', 'administrador@gmail.com', '$2y$10$pTf20J0lkwceVAzyZ/A7NuA7ra8KIZf5CohZoZAOcIbTAKAnW3OkS', '3017779132', 1, 1, ''),
(5, 'Mariana', 'Perea', 'mariana@gmail.com', '$2y$10$D6yxId632YDt0q5Lzun9l.jQDWIuR5SP9NbLvGtKl211rvyKF19ga', '3180987', 0, 1, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citasservicios`
--
ALTER TABLE `citasservicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicioId` (`servicioId`),
  ADD KEY `citaId` (`citaId`);

--
-- Indices de la tabla `ta_citas`
--
ALTER TABLE `ta_citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario` (`fk_usuario`);

--
-- Indices de la tabla `ta_servicios`
--
ALTER TABLE `ta_servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ta_usuarios`
--
ALTER TABLE `ta_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citasservicios`
--
ALTER TABLE `citasservicios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ta_citas`
--
ALTER TABLE `ta_citas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `ta_servicios`
--
ALTER TABLE `ta_servicios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `ta_usuarios`
--
ALTER TABLE `ta_usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citasservicios`
--
ALTER TABLE `citasservicios`
  ADD CONSTRAINT `citasservicios_ibfk_1` FOREIGN KEY (`servicioId`) REFERENCES `ta_servicios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citasservicios_ibfk_2` FOREIGN KEY (`citaId`) REFERENCES `ta_citas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ta_citas`
--
ALTER TABLE `ta_citas`
  ADD CONSTRAINT `ta_citas_ibfk_1` FOREIGN KEY (`fk_usuario`) REFERENCES `ta_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
