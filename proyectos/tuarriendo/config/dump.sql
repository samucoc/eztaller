-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-01-2019 a las 01:30:30
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eztaller_pruebase`
--
CREATE DATABASE IF NOT EXISTS `eztaller_pruebase` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `eztaller_pruebase`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodegas`
--

DROP TABLE IF EXISTS `bodegas`;
CREATE TABLE `bodegas` (
  `b_ncorr` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bodegas`
--

INSERT INTO `bodegas` (`b_ncorr`, `nombre`) VALUES
(1, 'Bodega Principal'),
(2, 'Bodega Anexa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `m_ncorr` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `descripcion` text NOT NULL,
  `icono` text NOT NULL,
  `link` text NOT NULL,
  `estado` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `usuario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`m_ncorr`, `nombre`, `descripcion`, `icono`, `link`, `estado`, `orden`, `created`, `updated`, `usuario`) VALUES
(1, 'Mantenedores', 'Mantenedores', '', 'mantenedores_main.php', 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(3, 'Ingresos', 'Ingresos', '', 'ingresos_main.php', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(4, 'Egresos', 'Egresos', '', 'egresos_main.php', 1, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(5, 'Informes', 'Informes', '', 'informes_main.php', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(6, 'Configuración Sistema', 'Configuración Sistema', '', 'configuration_main.php', 1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus_hijos`
--

DROP TABLE IF EXISTS `menus_hijos`;
CREATE TABLE `menus_hijos` (
  `mh_ncorr` int(11) NOT NULL,
  `m_ncorr` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `descripcion` text NOT NULL,
  `link` text NOT NULL,
  `icono` text NOT NULL,
  `estado` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  `usuario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menus_hijos`
--

INSERT INTO `menus_hijos` (`mh_ncorr`, `m_ncorr`, `nombre`, `descripcion`, `link`, `icono`, `estado`, `orden`, `updated`, `created`, `usuario`) VALUES
(1, 6, 'Usuarios', 'Usuarios', 'users.php', '', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(2, 6, 'Perfiles', 'Perfiles', 'perfiles.php', '', 1, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(3, 6, 'Menús', 'Menús', 'menus.php', '', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(4, 6, 'Menús Hijos', 'Menús Hijos', 'menus_hijos.php', '', 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(5, 6, 'Perfiles tienen Menu', 'Perfiles tienen Menu', 'perfiles_tienen_menus.php', '', 1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(6, 6, 'Perfiles tienen Menus Hijos', 'Perfiles tienen Menus Hijos', 'perfiles_tienen_menus_hijos.php', '', 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movim`
--

DROP TABLE IF EXISTS `movim`;
CREATE TABLE `movim` (
  `m_ncorr` int(11) NOT NULL,
  `movim_tipo` int(11) NOT NULL,
  `movim_bodega` int(11) NOT NULL,
  `movim_bodega_trans` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `usuario` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movim_detalle`
--

DROP TABLE IF EXISTS `movim_detalle`;
CREATE TABLE `movim_detalle` (
  `md_ncorr` int(11) NOT NULL,
  `m_ncorr` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `descr` text NOT NULL,
  `cantidad` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movim_tipos`
--

DROP TABLE IF EXISTS `movim_tipos`;
CREATE TABLE `movim_tipos` (
  `mt_ncorr` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `movim_tipos`
--

INSERT INTO `movim_tipos` (`mt_ncorr`, `nombre`, `descripcion`) VALUES
(1, 'Ingreso a Bodega', 'Ingreso a Bodega'),
(2, 'Ingreso a Vendedor', 'Ingreso a Vendedor'),
(3, 'Devolución de Vendedor', 'Devolución de Vendedor'),
(4, 'Ajustes (+)', 'Ajustes (+)'),
(5, 'Traspaso entre bodegas', 'Traspaso entre bodegas'),
(6, 'Ajustes (-)', 'Ajustes (-)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
CREATE TABLE `perfiles` (
  `p_ncorr` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`p_ncorr`, `nombre`, `descripcion`) VALUES
(1, 'Usuario', 'Usuario'),
(2, 'Cliente', 'Cliente'),
(3, 'Técnico', 'Técnico'),
(4, 'Administrador', 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles_tienen_menus`
--

DROP TABLE IF EXISTS `perfiles_tienen_menus`;
CREATE TABLE `perfiles_tienen_menus` (
  `ptm_ncorr` int(11) NOT NULL,
  `perfil` int(11) NOT NULL,
  `menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfiles_tienen_menus`
--

INSERT INTO `perfiles_tienen_menus` (`ptm_ncorr`, `perfil`, `menu`) VALUES
(1, 4, 1),
(3, 4, 3),
(4, 4, 4),
(5, 4, 5),
(6, 4, 6),
(10, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles_tienen_menus_hijos`
--

DROP TABLE IF EXISTS `perfiles_tienen_menus_hijos`;
CREATE TABLE `perfiles_tienen_menus_hijos` (
  `ptm_ncorr` int(11) NOT NULL,
  `perfil` int(11) NOT NULL,
  `menu_hijo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfiles_tienen_menus_hijos`
--

INSERT INTO `perfiles_tienen_menus_hijos` (`ptm_ncorr`, `perfil`, `menu_hijo`) VALUES
(1, 4, 1),
(2, 4, 2),
(3, 4, 3),
(4, 4, 4),
(7, 4, 5),
(8, 4, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `perfil` int(11) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `profile_pic` varchar(250) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `kind` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `email`, `perfil`, `password`, `profile_pic`, `is_active`, `kind`, `created_at`) VALUES
(1, 'admin', 'Samuel Silva', 'samu.silva@gmail.com', 4, '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 'default.png', 1, 1, '2017-07-15 12:05:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bodegas`
--
ALTER TABLE `bodegas`
  ADD PRIMARY KEY (`b_ncorr`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`m_ncorr`);

--
-- Indices de la tabla `menus_hijos`
--
ALTER TABLE `menus_hijos`
  ADD PRIMARY KEY (`mh_ncorr`);

--
-- Indices de la tabla `movim`
--
ALTER TABLE `movim`
  ADD PRIMARY KEY (`m_ncorr`);

--
-- Indices de la tabla `movim_detalle`
--
ALTER TABLE `movim_detalle`
  ADD PRIMARY KEY (`md_ncorr`);

--
-- Indices de la tabla `movim_tipos`
--
ALTER TABLE `movim_tipos`
  ADD PRIMARY KEY (`mt_ncorr`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`p_ncorr`);

--
-- Indices de la tabla `perfiles_tienen_menus`
--
ALTER TABLE `perfiles_tienen_menus`
  ADD PRIMARY KEY (`ptm_ncorr`);

--
-- Indices de la tabla `perfiles_tienen_menus_hijos`
--
ALTER TABLE `perfiles_tienen_menus_hijos`
  ADD PRIMARY KEY (`ptm_ncorr`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bodegas`
--
ALTER TABLE `bodegas`
  MODIFY `b_ncorr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `m_ncorr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `menus_hijos`
--
ALTER TABLE `menus_hijos`
  MODIFY `mh_ncorr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `movim`
--
ALTER TABLE `movim`
  MODIFY `m_ncorr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movim_detalle`
--
ALTER TABLE `movim_detalle`
  MODIFY `md_ncorr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movim_tipos`
--
ALTER TABLE `movim_tipos`
  MODIFY `mt_ncorr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `p_ncorr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `perfiles_tienen_menus`
--
ALTER TABLE `perfiles_tienen_menus`
  MODIFY `ptm_ncorr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `perfiles_tienen_menus_hijos`
--
ALTER TABLE `perfiles_tienen_menus_hijos`
  MODIFY `ptm_ncorr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;