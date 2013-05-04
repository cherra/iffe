-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-05-2013 a las 19:34:14
-- Versión del servidor: 5.5.30
-- Versión de PHP: 5.4.4-14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `iffe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Adjuntos`
--

CREATE TABLE IF NOT EXISTS `Adjuntos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pasoproceso` int(11) NOT NULL,
  `path` varchar(100) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `observaciones` varchar(350) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Volcado de datos para la tabla `Adjuntos`
--

INSERT INTO `Adjuntos` (`id`, `id_pasoproceso`, `path`, `file_name`, `descripcion`, `observaciones`) VALUES
(15, 0, 'assets/adjuntos/contratos/', '15.jpg', 'Prueba con nuevo path', 'Pruebas'),
(16, 0, 'assets/adjuntos/contratos/', 'acuseDIC_.pdf', 'Documento', 'Prueba'),
(17, 0, 'assets/adjuntos/contratos/', '6.gif', 'Identificación del cliente', 'Credencial IFE'),
(18, 0, 'assets/adjuntos/contratos/', 'Aviso_de_Privacidad_-_GERMANIA.doc', 'Comprobante de domicilio', 'Recibo Telmex'),
(19, 0, 'assets/adjuntos/modelos/', 'FOTOS_MAURICIO_1571.jpg', 'Fachada', 'Fachada'),
(20, 0, 'assets/adjuntos/modelos/', 'FOTOS_MAURICIO_162.jpg', 'Cocina', 'Cocina integral, barra de material'),
(21, 0, 'assets/adjuntos/modelos/', 'FOTOS_MAURICIO_168.jpg', 'Baño 1', 'Lavabo de sobre poner'),
(22, 0, 'assets/adjuntos/modelos/', 'FOTOS_MAURICIO_173.jpg', 'Baño 2', 'Lavabo y regadera'),
(24, 0, 'assets/adjuntos/modelos/', 'FOTOS_MAURICIO_174.jpg', 'Patio', 'Patio lateral'),
(25, 0, 'assets/adjuntos/contratos/', 'image.jpg', 'Prueba de foto', 'Pigglet'),
(26, 0, 'assets/adjuntos/pasos/', 'Conejo-de-Pascua-para-pintar-7.gif', 'IFE', 'sss'),
(28, 0, 'assets/adjuntos/contratos/', 'acuseDIC_.pdf', 'Prueba', 'algo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Calles`
--

CREATE TABLE IF NOT EXISTS `Calles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(350) NOT NULL,
  `precio_base` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `Calles`
--

INSERT INTO `Calles` (`id`, `nombre`, `descripcion`, `precio_base`) VALUES
(6, 'La Estancia', 'Sur', 4422.32),
(7, 'La Estancia', 'Norte', 4422.32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categorias`
--

CREATE TABLE IF NOT EXISTS `Categorias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clientes`
--

CREATE TABLE IF NOT EXISTS `Clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `apellido_paterno` varchar(128) NOT NULL,
  `apellido_materno` varchar(128) NOT NULL,
  `calle` varchar(200) NOT NULL,
  `numero_interior` varchar(10) NOT NULL,
  `numero_exterior` varchar(10) NOT NULL,
  `colonia` varchar(128) NOT NULL,
  `ciudad` varchar(128) NOT NULL,
  `estado` varchar(128) NOT NULL,
  `rfc` varchar(11) NOT NULL,
  `curp` varchar(18) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `celular` varchar(10) NOT NULL,
  `email` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `Clientes`
--

INSERT INTO `Clientes` (`id`, `nombre`, `apellido_paterno`, `apellido_materno`, `calle`, `numero_interior`, `numero_exterior`, `colonia`, `ciudad`, `estado`, `rfc`, `curp`, `telefono`, `celular`, `email`) VALUES
(2, 'Carlos', 'Maldonado', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, 'Jorge', 'González', 'Becerra', 'Leon Felipe', '', '37', 'Lomas Verdes', 'Colima', 'Colima', '', '', '3121361900', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Concesiones`
--

CREATE TABLE IF NOT EXISTS `Concesiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Configuracion`
--

CREATE TABLE IF NOT EXISTS `Configuracion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(128) NOT NULL,
  `valor` varchar(128) NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `Configuracion`
--

INSERT INTO `Configuracion` (`id`, `key`, `valor`, `descripcion`) VALUES
(5, 'prefijo_contrato', 'CO', 'Prefijo para los números de contrato'),
(6, 'template_path', 'assets/templates/', 'Carpeta raíz donde se guardan los templates'),
(7, 'asset_path', 'assets/', 'Carpeta de Assets'),
(9, 'template_contratos', 'contrato.html', 'Archivo de plantilla para contratos.'),
(10, 'plano', 'plano.jpg', 'Nombre de archivo del plano de instalaciones de la feria'),
(11, 'imagenes', 'img/', 'Carpeta donde se guardan las imagenes para el sistema'),
(12, 'plano50', 'plano50.jpg', 'Nombre de archivo para el plano al 50% de su tamaño real'),
(13, 'plano75', 'plano75.jpg', 'Nombre de archivo para el plano al 75% de su tamaño real');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContratoAdjuntos`
--

CREATE TABLE IF NOT EXISTS `ContratoAdjuntos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrato` int(11) NOT NULL,
  `id_adjunto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `ContratoAdjuntos`
--

INSERT INTO `ContratoAdjuntos` (`id`, `id_contrato`, `id_adjunto`) VALUES
(15, 1, 15),
(16, 1, 16),
(17, 4, 17),
(18, 4, 18),
(19, 5, 25),
(20, 4, 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContratoModulos`
--

CREATE TABLE IF NOT EXISTS `ContratoModulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrato` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_contrato` (`id_contrato`,`id_modulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contratos`
--

CREATE TABLE IF NOT EXISTS `Contratos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(10) unsigned NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `numero` varchar(32) NOT NULL DEFAULT '0',
  `fecha` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `observaciones` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `Contratos`
--

INSERT INTO `Contratos` (`id`, `id_cliente`, `id_usuario`, `numero`, `fecha`, `fecha_vencimiento`, `observaciones`) VALUES
(1, 1, 1, '1', '2013-04-30', '2013-06-29', ''),
(2, 2, 1, '2', '2013-04-30', '2013-06-29', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Giros`
--

CREATE TABLE IF NOT EXISTS `Giros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Modulos`
--

CREATE TABLE IF NOT EXISTS `Modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_calle` int(11) NOT NULL,
  `id_categoria` int(10) unsigned NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `frente` decimal(5,2) NOT NULL,
  `fondo` decimal(5,2) NOT NULL,
  `numero` varchar(16) NOT NULL,
  `categoria` enum('local','modulo','metro') NOT NULL DEFAULT 'local',
  `coordenadas` varchar(128) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `tipo` enum('intermedio','esquina','otro') NOT NULL DEFAULT 'intermedio',
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `Modulos`
--

INSERT INTO `Modulos` (`id`, `id_calle`, `id_categoria`, `descripcion`, `frente`, `fondo`, `numero`, `categoria`, `coordenadas`, `precio`, `tipo`) VALUES
(9, 6, 0, '', 4.00, 4.00, '1', 'local', '', 4422.32, 'esquina'),
(10, 6, 0, '', 4.00, 4.00, '2', 'local', '', 4422.32, 'intermedio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Permisos`
--

CREATE TABLE IF NOT EXISTS `Permisos` (
  `id_permiso` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permKey` varchar(50) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `submenu` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `method` varchar(100) NOT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT '1',
  `icon` varchar(32) NOT NULL,
  PRIMARY KEY (`id_permiso`),
  UNIQUE KEY `permKey` (`permKey`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `Permisos`
--

INSERT INTO `Permisos` (`id_permiso`, `permKey`, `nombre`, `folder`, `submenu`, `class`, `method`, `menu`, `icon`) VALUES
(1, 'login/do_logout', 'login/do_logout', '', '', 'login', 'do_logout', 1, ''),
(2, 'preferencias', 'preferencias', 'preferencias', '', 'preferencias', 'index', 0, ''),
(3, 'preferencias/configuracion_lista', 'Parametros de configuración', 'preferencias', '', 'preferencias', 'configuracion_lista', 1, 'icon-list'),
(4, 'preferencias/configuracion_add', 'preferencias/configuracion_add', 'preferencias', '', 'preferencias', 'configuracion_add', 0, ''),
(5, 'preferencias/configuracion_update', 'preferencias/configuracion_update', 'preferencias', '', 'preferencias', 'configuracion_update', 0, ''),
(6, 'seguridad/permisos_lista', 'Permisos', 'preferencias', '', 'seguridad', 'permisos_lista', 1, 'icon-list'),
(7, 'seguridad/permiso_update', 'seguridad/permiso_update', 'preferencias', '', 'seguridad', 'permiso_update', 0, ''),
(8, 'seguridad/roles_lista', 'Roles', 'preferencias', '', 'seguridad', 'roles_lista', 1, 'icon-list'),
(9, 'seguridad/rol_add', 'seguridad/rol_add', 'preferencias', '', 'seguridad', 'rol_add', 0, ''),
(10, 'seguridad/rol_delete', 'seguridad/rol_delete', 'preferencias', '', 'seguridad', 'rol_delete', 0, ''),
(11, 'plantillas/contratos', 'Contratos', 'preferencias', '', 'plantillas', 'contratos', 1, 'icon-edit'),
(12, 'seguridad/usuarios_lista', 'Usuarios', 'preferencias', '', 'seguridad', 'usuarios_lista', 1, 'icon-list'),
(13, 'seguridad/rol_permisos', 'seguridad/rol_permisos', 'preferencias', '', 'seguridad', 'rol_permisos', 0, ''),
(14, 'seguridad/usuario_add', 'seguridad/usuario_add', 'preferencias', '', 'seguridad', 'usuario_add', 0, ''),
(15, 'seguridad/usuario_permisos', 'seguridad/usuario_permisos', 'preferencias', '', 'seguridad', 'usuario_permisos', 0, ''),
(16, 'seguridad/usuario_delete', 'seguridad/usuario_delete', 'preferencias', '', 'seguridad', 'usuario_delete', 0, ''),
(17, 'catalogos', 'catalogos', 'catalogos', '', 'catalogos', 'index', 0, ''),
(20, 'clientes/add', 'clientes/add', 'catalogos', '', 'clientes', 'add', 0, ''),
(21, 'clientes/lista', 'Clientes', 'catalogos', '', 'clientes', 'lista', 1, 'icon-list'),
(22, 'seguridad/permiso_delete', 'seguridad/permiso_delete', 'preferencias', '', 'seguridad', 'permiso_delete', 0, ''),
(23, 'clientes/update', 'clientes/update', 'catalogos', '', 'clientes', 'update', 0, ''),
(24, 'clientes/delete', 'clientes/delete', 'catalogos', '', 'clientes', 'delete', 0, ''),
(25, 'calles/lista', 'Calles', 'catalogos', '', 'calles', 'lista', 1, 'icon-list'),
(26, 'calles/add', 'calles/add', 'catalogos', '', 'calles', 'add', 0, ''),
(27, 'calles/update', 'calles/update', 'catalogos', '', 'calles', 'update', 0, ''),
(28, 'calles/delete', 'calles/delete', 'catalogos', '', 'calles', 'delete', 0, ''),
(29, 'calles/modulos', 'Módulos', 'catalogos', '', 'calles', 'modulos', 1, 'icon-list'),
(30, 'calles/modulos_add', 'calles/modulos_add', 'catalogos', '', 'calles', 'modulos_add', 0, ''),
(31, 'calles/modulos_update', 'calles/modulos_update', 'catalogos', '', 'calles', 'modulos_update', 0, ''),
(32, 'calles/modulos_delete', 'calles/modulos_delete', 'catalogos', '', 'calles', 'modulos_delete', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PermisosRol`
--

CREATE TABLE IF NOT EXISTS `PermisosRol` (
  `id_permisorol` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_rol` bigint(20) NOT NULL,
  `id_permiso` bigint(20) NOT NULL,
  `valor` tinyint(1) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_permisorol`),
  UNIQUE KEY `roleID_2` (`id_rol`,`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PermisosUsuario`
--

CREATE TABLE IF NOT EXISTS `PermisosUsuario` (
  `id_permisousuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) NOT NULL,
  `id_permiso` bigint(20) NOT NULL,
  `valor` tinyint(1) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_permisousuario`),
  UNIQUE KEY `userID` (`id_usuario`,`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Roles`
--

CREATE TABLE IF NOT EXISTS `Roles` (
  `id_rol` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `roleName` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `Roles`
--

INSERT INTO `Roles` (`id_rol`, `nombre`, `descripcion`) VALUES
(1, 'Superusuario', ''),
(3, 'Administrador', 'Personal administrativo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RolesUsuario`
--

CREATE TABLE IF NOT EXISTS `RolesUsuario` (
  `id_rolusuario` int(11) NOT NULL,
  `id_usuario` bigint(20) NOT NULL,
  `id_rol` bigint(20) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `userID` (`id_usuario`,`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `RolesUsuario`
--

INSERT INTO `RolesUsuario` (`id_rolusuario`, `id_usuario`, `id_rol`, `fecha`) VALUES
(1, 1, 1, '2013-03-21 02:23:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE IF NOT EXISTS `Usuarios` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `activo` enum('s','n') NOT NULL DEFAULT 's',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`id_usuario`, `nombre`, `username`, `password`, `activo`) VALUES
(1, 'Jorge', 'jorge', '33f927344e079e00d3fa45d8833b04e735223eec', 's');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
