-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 17-05-2013 a las 14:43:02
-- Versión del servidor: 5.5.31
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

DROP TABLE IF EXISTS `Adjuntos`;
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

DROP TABLE IF EXISTS `Calles`;
CREATE TABLE IF NOT EXISTS `Calles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(350) NOT NULL,
  `precio_base` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `Calles`
--

INSERT INTO `Calles` (`id`, `nombre`, `descripcion`, `precio_base`) VALUES
(6, 'La Estancia Sur', 'Sur', 4422.32),
(7, 'La Estancia Norte', 'Norte', 4422.32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categorias`
--

DROP TABLE IF EXISTS `Categorias`;
CREATE TABLE IF NOT EXISTS `Categorias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clientes`
--

DROP TABLE IF EXISTS `Clientes`;
CREATE TABLE IF NOT EXISTS `Clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_concesion` int(11) NOT NULL,
  `id_giro` int(11) NOT NULL,
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
  PRIMARY KEY (`id`),
  KEY `id_giro` (`id_giro`),
  KEY `id_concesion` (`id_concesion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `Clientes`
--

INSERT INTO `Clientes` (`id`, `id_concesion`, `id_giro`, `nombre`, `apellido_paterno`, `apellido_materno`, `calle`, `numero_interior`, `numero_exterior`, `colonia`, `ciudad`, `estado`, `rfc`, `curp`, `telefono`, `celular`, `email`) VALUES
(2, 1, 1, 'Carlos', 'Maldonado', 'Orozco', 'Calzada del Campesion', '', '265', 'San Pablo', 'Colima', 'Colima', '', '', '3123131234', '', ''),
(3, 1, 1, 'Jorge', 'González', 'Becerra', 'Leon Felipe', '', '37', 'Lomas Verdes', 'Colima', 'Colima', '', '', '3121361900', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Concesiones`
--

DROP TABLE IF EXISTS `Concesiones`;
CREATE TABLE IF NOT EXISTS `Concesiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `descripcion` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Concesiones`
--

INSERT INTO `Concesiones` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Restaurante', 'Prueba de');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Configuracion`
--

DROP TABLE IF EXISTS `Configuracion`;
CREATE TABLE IF NOT EXISTS `Configuracion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(128) NOT NULL,
  `valor` varchar(128) NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

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
(13, 'plano75', 'plano75.jpg', 'Nombre de archivo para el plano al 75% de su tamaño real'),
(14, 'contrato_vencimiento', '15', 'Vencimiento de contratos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContratoAdjuntos`
--

DROP TABLE IF EXISTS `ContratoAdjuntos`;
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

DROP TABLE IF EXISTS `ContratoModulos`;
CREATE TABLE IF NOT EXISTS `ContratoModulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrato` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_contrato` (`id_contrato`,`id_modulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `ContratoModulos`
--

INSERT INTO `ContratoModulos` (`id`, `id_contrato`, `id_modulo`, `importe`) VALUES
(13, 4, 9, 5000.00),
(14, 4, 10, 6000.00),
(15, 4, 11, 4422.32),
(16, 3, 9, 4422.32),
(17, 3, 10, 4422.32),
(18, 2, 9, 4422.32),
(19, 2, 11, 4422.32),
(20, 1, 10, 4422.32),
(21, 1, 11, 4422.32),
(22, 1, 9, 4422.32),
(23, 5, 11, 4422.32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contratos`
--

DROP TABLE IF EXISTS `Contratos`;
CREATE TABLE IF NOT EXISTS `Contratos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(10) unsigned NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `numero` varchar(32) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_inicio` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `testigo1` varchar(128) NOT NULL,
  `testigo2` varchar(128) NOT NULL,
  `observaciones` varchar(256) NOT NULL,
  `estado` enum('pendiente','autorizado','cancelado') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `Contratos`
--

INSERT INTO `Contratos` (`id`, `id_cliente`, `id_usuario`, `numero`, `fecha`, `fecha_inicio`, `fecha_vencimiento`, `testigo1`, `testigo2`, `observaciones`, `estado`) VALUES
(1, 3, 0, '0', '2013-11-01 06:00:00', '0000-00-00', '2013-11-17', 'Ana Cristina', 'Georgina', 'Prueba de contrato', 'cancelado'),
(2, 3, 0, '1', '2013-11-01 06:00:00', '0000-00-00', '2013-11-17', 'Ana Cristina', 'Ana Sofía', 'Prueba 2', 'cancelado'),
(3, 2, 1, '2', '2013-11-01 06:00:00', '0000-00-00', '2013-11-17', 'Ana Sofía', 'Georgina', 'Prueba 3', 'cancelado'),
(4, 3, 1, '3', '2013-05-14 17:51:56', '2013-11-01', '2013-11-17', 'Ana Sofía', 'Georgina', 'Prueba', 'cancelado'),
(5, 2, 1, '4', '2013-05-17 18:02:47', '2013-11-01', '2013-11-17', 'Ana Cristina', 'Georgina', '', 'autorizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ferias`
--

DROP TABLE IF EXISTS `Ferias`;
CREATE TABLE IF NOT EXISTS `Ferias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `observaciones` varchar(256) NOT NULL,
  `activa` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Giros`
--

DROP TABLE IF EXISTS `Giros`;
CREATE TABLE IF NOT EXISTS `Giros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `descripcion` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Giros`
--

INSERT INTO `Giros` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Venta de comida', 'Prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Modulos`
--

DROP TABLE IF EXISTS `Modulos`;
CREATE TABLE IF NOT EXISTS `Modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_calle` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `frente` decimal(5,2) NOT NULL,
  `fondo` decimal(5,2) NOT NULL,
  `numero` varchar(16) NOT NULL,
  `categoria` enum('local','modulo','metro') NOT NULL DEFAULT 'local',
  `coordenadas` varchar(128) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `tipo` enum('intermedio','esquina','otro') NOT NULL DEFAULT 'intermedio',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `Modulos`
--

INSERT INTO `Modulos` (`id`, `id_calle`, `descripcion`, `frente`, `fondo`, `numero`, `categoria`, `coordenadas`, `precio`, `tipo`) VALUES
(9, 6, '', 4.00, 4.00, '1', 'local', '', 4422.32, 'esquina'),
(10, 6, '', 4.00, 4.00, '2', 'local', '', 4422.32, 'intermedio'),
(11, 7, '', 4.00, 4.00, '1', 'local', '', 4422.32, 'intermedio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Periodos`
--

DROP TABLE IF EXISTS `Periodos`;
CREATE TABLE IF NOT EXISTS `Periodos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `observaciones` varchar(256) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `Periodos`
--

INSERT INTO `Periodos` (`id`, `nombre`, `fecha_inicio`, `fecha_fin`, `observaciones`, `activo`) VALUES
(1, 'Feria 2012', '2012-11-02', '2012-11-18', '', 0),
(2, 'Feria 2011', '2011-11-04', '2011-11-20', '', 0),
(3, 'Feria 2013', '2013-11-01', '2013-11-17', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Permisos`
--

DROP TABLE IF EXISTS `Permisos`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

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
(33, 'clientes/giros_lista', 'Giros', 'catalogos', '', 'clientes', 'giros_lista', 1, 'icon-list'),
(34, 'clientes/giros_add', 'clientes/giros_add', 'catalogos', '', 'clientes', 'giros_add', 0, ''),
(35, 'clientes/giros_update', 'clientes/giros_update', 'catalogos', '', 'clientes', 'giros_update', 0, ''),
(36, 'clientes/giros_delete', 'clientes/giros_delete', 'catalogos', '', 'clientes', 'giros_delete', 0, ''),
(37, 'clientes/concesiones_lista', 'Concesiones', 'catalogos', '', 'clientes', 'concesiones_lista', 1, 'icon-list'),
(38, 'clientes/concesiones_add', 'clientes/concesiones_add', 'catalogos', '', 'clientes', 'concesiones_add', 0, ''),
(39, 'clientes/concesiones_update', 'clientes/concesiones_update', 'catalogos', '', 'clientes', 'concesiones_update', 0, ''),
(40, 'clientes/concesiones_delete', 'clientes/concesiones_delete', 'catalogos', '', 'clientes', 'concesiones_delete', 0, ''),
(45, 'operacion', 'operacion', 'operacion', '', 'operacion', 'index', 0, ''),
(49, 'informes', 'informes', 'informes', '', 'informes', 'index', 1, ''),
(54, 'ferias/calles', 'Calles', 'catalogos', '', 'ferias', 'calles', 1, 'icon-list'),
(55, 'ferias/calles_update', 'ferias/calles_update', 'catalogos', '', 'ferias', 'calles_update', 0, ''),
(56, 'ferias/modulos', 'Modulos', 'catalogos', '', 'ferias', 'modulos', 1, 'icon-list'),
(57, 'ferias/calles_add', 'ferias/calles_add', 'catalogos', '', 'ferias', 'calles_add', 0, ''),
(58, 'ferias/calles_delete', 'ferias/calles_delete', 'catalogos', '', 'ferias', 'calles_delete', 0, ''),
(59, 'ferias/modulos_update', 'ferias/modulos_update', 'catalogos', '', 'ferias', 'modulos_update', 0, ''),
(60, 'ferias/modulos_add', 'ferias/modulos_add', 'catalogos', '', 'ferias', 'modulos_add', 0, ''),
(61, 'ferias/modulos_delete', 'ferias/modulos_delete', 'catalogos', '', 'ferias', 'modulos_delete', 0, ''),
(62, 'ferias/periodos', 'Períodos', 'catalogos', '', 'ferias', 'periodos', 1, 'icon-list'),
(63, 'ferias/periodos_add', 'ferias/periodos_add', 'catalogos', '', 'ferias', 'periodos_add', 0, ''),
(64, 'ferias/periodos_update', 'ferias/periodos_update', 'catalogos', '', 'ferias', 'periodos_update', 0, ''),
(65, 'ferias/periodos_delete', 'ferias/periodos_delete', 'catalogos', '', 'ferias', 'periodos_delete', 0, ''),
(69, 'ventas/contratos', 'Contratos', 'operacion', '', 'ventas', 'contratos', 1, 'icon-list'),
(70, 'ventas/contratos_update', 'ventas/contratos_update', 'operacion', '', 'ventas', 'contratos_update', 0, ''),
(71, 'ventas/contratos_cancelar', 'ventas/contratos_cancelar', 'operacion', '', 'ventas', 'contratos_cancelar', 0, ''),
(72, 'ventas/contratos_modulos', 'ventas/contratos_modulos', 'operacion', '', 'ventas', 'contratos_modulos', 0, ''),
(73, 'ventas/contratos_add', 'ventas/contratos_add', 'operacion', '', 'ventas', 'contratos_add', 0, ''),
(74, 'ventas/contratos_delete_modulo', 'ventas/contratos_delete_modulo', 'operacion', '', 'ventas', 'contratos_delete_modulo', 0, ''),
(75, 'ventas/contratos_estado', 'ventas/contratos_estado', 'operacion', '', 'ventas', 'contratos_estado', 0, ''),
(76, 'ventas/contratos_autorizar', 'ventas/contratos_autorizar', 'operacion', '', 'ventas', 'contratos_autorizar', 0, ''),
(77, 'ventas/contratos_documento', 'ventas/contratos_documento', 'operacion', '', 'ventas', 'contratos_documento', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PermisosRol`
--

DROP TABLE IF EXISTS `PermisosRol`;
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

DROP TABLE IF EXISTS `PermisosUsuario`;
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

DROP TABLE IF EXISTS `Roles`;
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

DROP TABLE IF EXISTS `RolesUsuario`;
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

DROP TABLE IF EXISTS `Usuarios`;
CREATE TABLE IF NOT EXISTS `Usuarios` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `activo` enum('s','n') NOT NULL DEFAULT 's',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`id_usuario`, `nombre`, `username`, `password`, `activo`) VALUES
(1, 'Jorge', 'jorge', '33f927344e079e00d3fa45d8833b04e735223eec', 's');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
