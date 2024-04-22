-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 22-08-2023 a las 21:09:32
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `despachosqr`
--
CREATE DATABASE IF NOT EXISTS `despachosqr` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `despachosqr`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `nombreEmpresa` text NOT NULL,
  `rutEmpresa` text NOT NULL,
  `direccionEmpresa` text NOT NULL,
  `nombreContactoEmpresa` text NOT NULL,
  `telefonoContactoEmpresa` int NOT NULL,
  `correoContactoEmpresa` int NOT NULL,
  `nivelEmpresa` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombreEmpresa`, `rutEmpresa`, `direccionEmpresa`, `nombreContactoEmpresa`, `telefonoContactoEmpresa`, `correoContactoEmpresa`, `nivelEmpresa`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '9', '9', '9', '9', 9, 9, 9, '2023-05-23 03:58:38', '2023-05-23 03:58:38', '0000-00-00 00:00:00'),
(2, '9', '9', '9', '9', 9, 9, 988, '2023-05-23 03:58:50', '2023-05-23 03:58:50', '0000-00-00 00:00:00'),
(3, '9', '9', '9', '9', 9, 9, 3333, '2023-05-23 04:02:29', '2023-05-23 04:05:57', '2023-05-23 04:05:57'),
(4, '9', '9', '9', '9', 9, 9, 333333, '2023-05-23 04:02:45', '2023-05-23 04:05:56', '2023-05-23 04:05:56'),
(5, '9', '9', '9', '9', 9, 9, 988333, '2023-05-23 04:06:03', '2023-05-23 04:06:19', '2023-05-23 04:06:19'),
(6, '9', '9', '9', '9', 9, 9, 988333111, '2023-05-23 04:06:14', '2023-05-23 04:06:16', '2023-05-23 04:06:16'),
(7, '9', '9', '9', '9', 9, 9, 933333, '2023-05-23 04:07:03', '2023-05-23 04:07:27', '0000-00-00 00:00:00'),
(8, '8', '8', '8', '8', 8, 8, 8, '2023-08-20 01:08:29', '2023-08-20 01:13:09', '2023-08-20 01:13:09'),
(9, 'SFD', '1', 'SADF', 'SADF', 2222, 1, 1, '2023-08-20 01:10:44', '2023-08-20 01:11:02', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conductores`
--

CREATE TABLE `conductores` (
  `id` int NOT NULL,
  `rut` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombres` text NOT NULL,
  `apellidoPaterno` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `apellidoMaterno` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` text NOT NULL,
  `licenciaConducir` text NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `deleted_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `conductores`
--

INSERT INTO `conductores` (`id`, `rut`, `nombres`, `apellidoPaterno`, `apellidoMaterno`, `fechaNacimiento`, `direccion`, `email`, `licenciaConducir`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', '1', '1', '1', '2023-05-01', '1', '1', '1', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despachos`
--

CREATE TABLE `despachos` (
  `id` int NOT NULL,
  `fecha` date NOT NULL,
  `cliente_id` int NOT NULL,
  `origenDespacho` text NOT NULL,
  `destinoDespacho` text NOT NULL,
  `conductor_id` int NOT NULL,
  `vehiculo_id` int NOT NULL,
  `recogido` datetime DEFAULT NULL,
  `entregado` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `despachos`
--

INSERT INTO `despachos` (`id`, `fecha`, `cliente_id`, `origenDespacho`, `destinoDespacho`, `conductor_id`, `vehiculo_id`, `recogido`, `entregado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, '2023-05-23', 7, 'fdsasdafasfd', 'asfdasdf', 1, 1, '2023-08-20 16:39:24', NULL, '2023-05-23 06:01:58', '2023-08-20 16:39:34', '2023-05-23 02:03:34'),
(4, '2023-05-06', 7, 'asfdsdfdsfa', 'vxczxvzcxvc', 1, 1, '2023-08-20 16:53:47', '2023-08-20 16:54:14', '2023-05-23 06:04:29', '2023-08-20 16:54:14', '2023-05-23 02:04:29'),
(5, '2023-08-10', 2, 'fdsasdafasfd', 'asfdasdf', 1, 1, NULL, NULL, '2023-08-20 20:49:51', '2023-08-20 20:49:51', '2023-08-20 16:49:51'),
(6, '2023-08-01', 2, 'fsdsdf', 'sdfdfsdf', 1, 1, NULL, NULL, '2023-08-20 20:50:21', '2023-08-20 20:50:21', '2023-08-20 16:50:21'),
(7, '2023-09-01', 0, 'fsdsdfsdf', 'sdfsdfsdfsdf', 0, 0, NULL, NULL, '2023-08-20 22:13:10', '2023-08-20 22:13:10', '2023-08-20 18:13:10'),
(8, '2023-09-01', 9, '21321323231213', '213213213213213', 0, 0, NULL, NULL, '2023-08-20 22:13:58', '2023-08-20 22:13:58', '2023-08-20 18:13:58'),
(9, '2023-08-08', 0, '234234243', '5654644646', 0, 0, NULL, NULL, '2023-08-20 22:17:21', '2023-08-20 22:17:21', '2023-08-20 18:17:21'),
(10, '2023-08-25', 9, 'sdfsdfsdfsdf', 'jhjkkjkk', 1, 1, NULL, NULL, '2023-08-20 22:18:21', '2023-08-20 22:18:21', '2023-08-20 18:18:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `roleName` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `roleName`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrador', '2023-03-15 23:16:22', '2023-03-15 23:16:22', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL,
  `userDNI` varchar(256) NOT NULL,
  `userFullName` text NOT NULL,
  `userEmail` varchar(256) NOT NULL,
  `userPassword` varchar(256) NOT NULL,
  `userPasswordRecoveryToken` varchar(256) NOT NULL,
  `userPasswordRecoveryTokenExpirationDatetime` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role_id`, `userDNI`, `userFullName`, `userEmail`, `userPassword`, `userPasswordRecoveryToken`, `userPasswordRecoveryTokenExpirationDatetime`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, '11.111.11-1', '', 'samu.silva@gmail.com', '123456', '', NULL, '2023-03-15 23:16:28', '2023-03-15 23:16:28', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int NOT NULL,
  `nombre` text NOT NULL,
  `patente` text NOT NULL,
  `año` int NOT NULL,
  `marca` text NOT NULL,
  `modelo` text NOT NULL,
  `tipo` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `nombre`, `patente`, `año`, `marca`, `modelo`, `tipo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', '1', 1, '1', '1', '1', '2023-05-23 06:23:19', '2023-05-23 06:23:19', '2023-05-23 06:23:19');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conductores`
--
ALTER TABLE `conductores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `despachos`
--
ALTER TABLE `despachos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `conductores`
--
ALTER TABLE `conductores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `despachos`
--
ALTER TABLE `despachos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
