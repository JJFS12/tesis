-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-03-2021 a las 02:08:57
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_device`
--

USE `db_admin`;
CREATE TABLE `tbl_device` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `readings` varchar(200) NOT NULL,
  `APIkey` varchar(200) NOT NULL,
  `units` varchar(200) NOT NULL,
  `max` varchar(200) NOT NULL,
  `min` varchar(200) NOT NULL,
  `deviceid` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_device`
--

INSERT INTO `tbl_device` (`id`, `name`, `readings`, `units`, `max`, `min`,`deviceid`) VALUES
(1, 'temperatura', 'temperaura', 'celcius', '100', '0',`22`);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` int(11) NOT NULL COMMENT 'role_id',
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role`) VALUES
(1, 'superAdmin'),
(2, 'Admin'),
(3, 'User');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `roleid` tinyint(4) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `email`, `password`, `roleid`, `isActive`, `created_at`, `updated_at`) VALUES
(12, 'Rayhan', 'Rayhan', 'rayhankabir@gmail.com', '188000e1f0fb4075ae1c659697b96296f982cdc4', 2, 0, '2020-03-13 00:20:24', '2020-03-13 00:20:24'),
(22, 'juan jose flores sedano', 'yue', 'jottasedanof@gmail.com', 'a6068fbcefaa14f223f58eacf3f96b9f8f6eb0fd', 1, 0, '2021-03-03 06:25:07', '2021-03-03 06:25:07');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_device`
--
ALTER TABLE `tbl_device`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_device`
--
ALTER TABLE `tbl_device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'role_id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
