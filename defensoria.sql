-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-07-2025 a las 19:08:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `defensoria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditorias`
--

CREATE TABLE `auditorias` (
  `auditoria_id` int(10) UNSIGNED NOT NULL,
  `usuario_id` tinyint(3) UNSIGNED NOT NULL,
  `accion` varchar(50) NOT NULL COMMENT 'Este campo es para registrar si el usuario realizo una accion (alta-baja-modificacion)',
  `observacion` text NOT NULL COMMENT 'Registra (en caso de modificacion) el contenido original modificado',
  `fecha` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora de la accion realizada',
  `tabla_afectada` text NOT NULL COMMENT 'Tabla en la que se realizo el cambio',
  `valor_anterior` text NOT NULL COMMENT 'Valor anterior modificado',
  `valor_nuevo` text NOT NULL COMMENT 'Nuevo valor ingresado/cambiado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoridades`
--

CREATE TABLE `autoridades` (
  `autoridad_id` int(10) UNSIGNED NOT NULL,
  `nombre_primero` varchar(50) NOT NULL COMMENT 'Primero nombre de autoridad',
  `apellido_primero` varchar(50) NOT NULL COMMENT 'Primer apellido de la autoridad',
  `foto_id` varchar(100) NOT NULL COMMENT 'Hace refencia al id de la foto que se va a utilizar en la autoridad',
  `estado` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Este campo esta para ver el estado de la Autoridad (1 es si esta activo// 0 si esta inactivo)',
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `nombre_segundo` text NOT NULL COMMENT 'Segundo nombre de la autoridad',
  `apellido_segundo` text NOT NULL COMMENT 'Segundo apellido de la autoridad'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faq`
--

CREATE TABLE `faq` (
  `faq_id` int(10) UNSIGNED NOT NULL,
  `pregunta` text NOT NULL COMMENT 'Cuerpo de la pregunta',
  `respuesta` text NOT NULL COMMENT 'Cuerpo de la respuesta a la pregunta',
  `usuario_id` tinyint(3) UNSIGNED NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Este campo valida el estado de FAQ ( 1 es para activo// 0 para inactivo)',
  `auditoria_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `foto_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Estado de visibilidad (activo 1 - inactivo 0)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memorias`
--

CREATE TABLE `memorias` (
  `memoria_id` int(10) UNSIGNED NOT NULL,
  `titulo` text NOT NULL,
  `descripcion` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL COMMENT 'Muestra la fecha y hora de cuando se creo la memoria en sistema',
  `usuario_id` tinyint(3) UNSIGNED NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `fecha_publicacion` date NOT NULL COMMENT 'Muestra la fecha de ultima publicacion de la memoria',
  `fecha_finalizacion` date NOT NULL COMMENT 'Fecha limite de visbilidad de la memoria (en caso de decidirse una)',
  `auditoria_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `noticia_id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_publicacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_finalizacion` datetime NOT NULL DEFAULT current_timestamp(),
  `autor` varchar(50) NOT NULL,
  `foto_id` int(10) UNSIGNED NOT NULL,
  `auditoria_id` int(10) UNSIGNED NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(40) NOT NULL,
  `dni` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditorias`
--
ALTER TABLE `auditorias`
  ADD PRIMARY KEY (`auditoria_id`);

--
-- Indices de la tabla `autoridades`
--
ALTER TABLE `autoridades`
  ADD PRIMARY KEY (`autoridad_id`);

--
-- Indices de la tabla `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`foto_id`);

--
-- Indices de la tabla `memorias`
--
ALTER TABLE `memorias`
  ADD PRIMARY KEY (`memoria_id`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`noticia_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditorias`
--
ALTER TABLE `auditorias`
  MODIFY `auditoria_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `autoridades`
--
ALTER TABLE `autoridades`
  MODIFY `autoridad_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `faq`
--
ALTER TABLE `faq`
  MODIFY `faq_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `foto_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `memorias`
--
ALTER TABLE `memorias`
  MODIFY `memoria_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `noticia_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
