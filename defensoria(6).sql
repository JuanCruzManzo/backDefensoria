-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2025 a las 18:30:42
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

--
-- Volcado de datos para la tabla `auditorias`
--

INSERT INTO `auditorias` (`auditoria_id`, `usuario_id`, `accion`, `observacion`, `fecha`, `tabla_afectada`, `valor_anterior`, `valor_nuevo`) VALUES
(1, 1, 'Editar', 'Se edito el campo x ', '2025-08-18 11:05:10', 'fotos', 'x', 'x');

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

--
-- Volcado de datos para la tabla `faq`
--

INSERT INTO `faq` (`faq_id`, `pregunta`, `respuesta`, `usuario_id`, `estado`, `auditoria_id`) VALUES
(1, '¿Qué es la Defensoría del Pueblo de General Pueyrredon?', 'Es un organismo independiente que protege los derechos de los vecinos del Partido de General Pueyrredon frente a la administración pública y empresas de servicios.', 1, 0, 101),
(2, '¿Qué trámites puedo realizar en la Defensoría del Pueblo?', 'Podés presentar reclamos relacionados con servicios públicos, salud, medio ambiente, transporte, obras, seguridad social y otros temas que afecten tus derechos.', 1, 1, 102),
(3, '¿La atención en la Defensoría del Pueblo tiene algún costo?', 'No, todos los servicios que brinda la Defensoría del Pueblo son totalmente gratuitos para la ciudadanía.', 1, 1, 103),
(4, '¿Dónde está ubicada la Defensoría del Pueblo de Mar del Plata?', 'La sede principal se encuentra en Belgrano 2740, Mar del Plata. También hay delegaciones en distintos barrios.', 1, 1, 104),
(5, '¿Cómo puedo realizar un reclamo en la Defensoría del Pueblo?', 'Podés acercarte personalmente a la sede, llamar por teléfono, enviar un correo electrónico o ingresar al portal web oficial para iniciar tu trámite.', 1, 1, 105),
(6, '?ƒ?', '?Ý?~}üÍ', 0, 0, 0),
(7, '?ƒ?\r\n', '\r\n?Ý?~}üÍ', 0, 0, 0);

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

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`foto_id`, `nombre`, `fecha`, `estado`) VALUES
(1, 'foton', '2025-08-18 11:03:55', 1);

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
  `estado` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Estado de visibilidad (activo 1 - inactivo 0)',
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
  `titulo` varchar(100) NOT NULL COMMENT 'Este campo hace refencia al titulo que tiene la noticia',
  `contenido` text NOT NULL COMMENT 'En este campo se cargara todo el contenido de la noticia',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_publicacion` datetime NOT NULL COMMENT 'Fecha en la que aparecera la noticia visible',
  `fecha_finalizacion` datetime NOT NULL COMMENT 'Fecha en la que la noticia dejara de estar visible',
  `autor` varchar(50) NOT NULL,
  `foto` varchar(50) DEFAULT NULL COMMENT 'Guarda el nombre de la foto',
  `estado` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Estado de visibilidad (activo 1 - inactivo 0)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`noticia_id`, `titulo`, `contenido`, `fecha_creacion`, `fecha_publicacion`, `fecha_finalizacion`, `autor`, `foto`, `estado`) VALUES
(1, 'Noticion', 'Lorem Ipsum', '2025-08-18 11:05:36', '2025-08-18 11:05:36', '2025-08-18 11:05:36', 'Maquiavelo', 'plantilla/imgs68ac71', 0),
(2, 'Lorem', 'En este contenido vas a ver un noticion', '2025-08-25 10:57:59', '2025-08-08 12:00:00', '2025-11-17 14:00:00', 'Ipsum', '', 0),
(3, 'Prueba_noticia1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sodales libero libero, sit amet feugiat justo eleifend non. In hac habitasse platea dictumst. Vestibulum scelerisque faucibus velit vitae elementum. In at pulvinar lorem. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur vulputate placerat nisl, vitae auctor quam cursus a. Proin a ullamcorper libero. Proin venenatis leo at commodo porttitor. Nulla congue neque id nulla scelerisque, id vulputate risus semper. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis porttitor aliquam tempor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam condimentum nulla vel justo pellentesque, non sollicitudin enim porttitor. Donec imperdiet imperdiet euismod. Nulla malesuada ornare risus nec dictum. Interdum et malesuada fames ac ante ipsum primis in faucibus.\r\n\r\nNunc vulputate pulvinar massa vitae lobortis. Mauris id sagittis erat. Morbi eu tincidunt dolor, quis hendrerit tortor. Integer feugiat sapien non sem hendrerit rutrum. Donec tempus fringilla metus posuere fermentum. Etiam placerat justo eu libero dapibus posuere. Duis viverra id nisl vitae tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus bibendum mattis gravida. Donec ullamcorper vehicula mattis. Ut vitae justo a urna malesuada lobortis a id augue. Curabitur at sagittis justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras hendrerit ex a erat luctus, vel aliquam orci euismod.\r\n\r\nMorbi mollis, diam ut ornare lobortis, nunc lorem ultricies sapien, id mollis nunc felis sed est. Morbi id eros eu orci vulputate varius quis iaculis quam. Suspendisse ut convallis lorem. Morbi elit velit, fringilla et tellus non, consequat dignissim sapien. Aenean gravida semper urna, vel imperdiet est fringilla sed. Aenean lacinia dui vel odio euismod, vitae varius libero aliquam. Nam sed leo dolor. Donec pulvinar ligula a elit tempus consectetur. Nullam eget consequat odio. Aliquam eu ultrices felis. Vivamus imperdiet neque ut dui sagittis elementum.', '2025-08-25 11:17:13', '2025-08-14 00:00:00', '2025-08-31 16:00:00', 'Autor1', 'backDefensoria/plant', 0),
(4, 'Prueba_noticia2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam volutpat vulputate interdum. Proin elementum turpis non lectus vehicula, vitae efficitur elit pretium. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vestibulum sed pretium felis. Ut hendrerit nisi eu magna aliquet dignissim. Sed pretium turpis sed turpis mollis ullamcorper. Quisque bibendum sit amet ex eget vehicula. Suspendisse pulvinar suscipit purus, vitae sagittis mi venenatis eu. Aliquam vel interdum urna, eget mattis purus. Ut condimentum turpis vel libero pretium semper.\r\n\r\nNulla sagittis mi est, id egestas tortor gravida vel. Proin vulputate erat ut urna aliquet, eget lacinia magna iaculis. Nunc pulvinar posuere libero non ultrices. Maecenas molestie ac nibh eu mollis. Maecenas congue sem nec ipsum feugiat pretium. Sed vitae elit pretium, tincidunt justo quis, interdum ex. Morbi vel risus orci. Donec eu tempus nunc. Suspendisse eleifend leo ut massa dictum lobortis. Cras aliquet nisl sit amet lorem vehicula facilisis. Ut consequat tortor nisi, in congue est rutrum sed. Sed nec diam a velit volutpat viverra eget vulputate nisi.\r\n\r\nDuis eu mi nec enim dapibus dapibus a quis lectus. Nunc rutrum felis at malesuada laoreet. Sed vel arcu in magna commodo commodo ac at tellus. Fusce venenatis, mauris ac sollicitudin luctus, nibh risus porta metus, quis scelerisque lacus nisl quis velit. Nulla a est at libero aliquam lacinia. Fusce pellentesque maximus risus, sed varius velit pellentesque et. Pellentesque nulla orci, tristique in purus facilisis, laoreet tincidunt nisl. Ut eu arcu tellus. Etiam nec bibendum lorem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam blandit, dui non scelerisque imperdiet, ligula urna fringilla quam, finibus pellentesque sapien justo interdum neque. Suspendisse lacinia pharetra risus at feugiat. Vivamus sed nibh euismod, aliquam sem et, placerat urna. Praesent aliquet ornare vulputate. Aenean nec ligula et ante pharetra ultricies vitae sed arcu. Vestibulum maximus turpis enim, non elementum est mattis ac.\r\n\r\nNulla facilisi. Sed at leo nunc. Vestibulum et tristique mi. Praesent ante mauris, tempor id tincidunt quis, vulputate at ipsum. Quisque elit augue, tristique laoreet eleifend ut, cursus sed enim. Aliquam quam tortor, laoreet eu congue vitae, volutpat et lectus. Proin bibendum augue ac justo sollicitudin, eget tempor urna scelerisque. Nunc imperdiet orci et massa venenatis pharetra. Aenean urna est, tempor nec dictum eget, egestas id ipsum. Proin tempor, enim et varius lobortis, magna lacus lacinia massa, vel congue libero nibh ac arcu. Sed et euismod lacus. Pellentesque at elit non ligula porta egestas. Maecenas eget leo et eros laoreet consequat.\r\n\r\nAliquam interdum ligula eu dignissim pulvinar. Suspendisse varius sed massa quis gravida. Aliquam eros dui, elementum at fringilla a, volutpat a eros. Ut turpis mi, consequat id lacus at, mattis feugiat leo. Quisque sit amet ligula ac nulla malesuada fermentum non vel sapien. Phasellus ut tortor massa. Vestibulum feugiat libero vitae commodo consequat. Maecenas ultricies ligula vel lectus pulvinar pharetra. Vestibulum dolor quam, auctor non neque eu, faucibus auctor lectus. In pellentesque aliquam leo ut iaculis.', '2025-08-25 11:52:15', '2025-08-25 15:55:00', '2025-08-31 11:51:00', 'Mateo', '', 0),
(5, 'Prueba_noticia3', 'Lorem Ipsum', '2025-08-25 11:59:13', '2025-08-25 14:00:00', '2025-08-31 17:00:00', 'Mateo', 'backDefensoria/plantilla/imgs/5.png', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resoluciones`
--

CREATE TABLE `resoluciones` (
  `resolucion_id` int(10) UNSIGNED NOT NULL,
  `estado` tinyint(4) NOT NULL COMMENT 'Estado de visibilidad (activo 1 - inactivo 0)',
  `auditoria_id` int(11) NOT NULL,
  `Anio` year(4) NOT NULL COMMENT 'Año al que pertenece la resolución cargada',
  `Titulo` varchar(50) NOT NULL COMMENT 'Titulo de la resolucion',
  `pdf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `resoluciones`
--

INSERT INTO `resoluciones` (`resolucion_id`, `estado`, `auditoria_id`, `Anio`, `Titulo`, `pdf`) VALUES
(1, 1, 0, '2014', 'resolucion Cami', 'http://www.defensoriadelpueblo.mdp.gob.ar/wp-content/uploads/2015/06/resolucion-01-2015.pdf'),
(2, 1, 1, '2014', 'resolucion cami', 'http://www.defensoriadelpueblo.mdp.gob.ar/wp-content/uploads/2015/06/resolucion-01-2015.pdf'),
(3, 1, 0, '2019', 'Mateo', ''),
(4, 1, 0, '2000', 'Carga buena', ''),
(5, 1, 0, '2019', 'Mateee', '');

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
  `estado` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Estado de usuario (activo 1 - inactivo 0). Si esta en 0 no funciona el usuario'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `nombre`, `apellido`, `dni`, `usuario`, `contrasena`, `estado`) VALUES
(1, 'mateo', 'prestia', 45220328, 'matepp', '1234', 1);

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
-- Indices de la tabla `resoluciones`
--
ALTER TABLE `resoluciones`
  ADD PRIMARY KEY (`resolucion_id`);

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
  MODIFY `auditoria_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `autoridades`
--
ALTER TABLE `autoridades`
  MODIFY `autoridad_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `faq`
--
ALTER TABLE `faq`
  MODIFY `faq_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `foto_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `memorias`
--
ALTER TABLE `memorias`
  MODIFY `memoria_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `noticia_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `resoluciones`
--
ALTER TABLE `resoluciones`
  MODIFY `resolucion_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
