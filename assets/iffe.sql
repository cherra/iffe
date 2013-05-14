-- MySQL dump 10.13  Distrib 5.5.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: iffe
-- ------------------------------------------------------
-- Server version	5.5.31-0ubuntu0.13.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `iffe`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `iffe` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `iffe`;

--
-- Table structure for table `Adjuntos`
--

DROP TABLE IF EXISTS `Adjuntos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Adjuntos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pasoproceso` int(11) NOT NULL,
  `path` varchar(100) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `observaciones` varchar(350) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Adjuntos`
--

LOCK TABLES `Adjuntos` WRITE;
/*!40000 ALTER TABLE `Adjuntos` DISABLE KEYS */;
INSERT INTO `Adjuntos` VALUES (15,0,'assets/adjuntos/contratos/','15.jpg','Prueba con nuevo path','Pruebas'),(16,0,'assets/adjuntos/contratos/','acuseDIC_.pdf','Documento','Prueba'),(17,0,'assets/adjuntos/contratos/','6.gif','Identificación del cliente','Credencial IFE'),(18,0,'assets/adjuntos/contratos/','Aviso_de_Privacidad_-_GERMANIA.doc','Comprobante de domicilio','Recibo Telmex'),(19,0,'assets/adjuntos/modelos/','FOTOS_MAURICIO_1571.jpg','Fachada','Fachada'),(20,0,'assets/adjuntos/modelos/','FOTOS_MAURICIO_162.jpg','Cocina','Cocina integral, barra de material'),(21,0,'assets/adjuntos/modelos/','FOTOS_MAURICIO_168.jpg','Baño 1','Lavabo de sobre poner'),(22,0,'assets/adjuntos/modelos/','FOTOS_MAURICIO_173.jpg','Baño 2','Lavabo y regadera'),(24,0,'assets/adjuntos/modelos/','FOTOS_MAURICIO_174.jpg','Patio','Patio lateral'),(25,0,'assets/adjuntos/contratos/','image.jpg','Prueba de foto','Pigglet'),(26,0,'assets/adjuntos/pasos/','Conejo-de-Pascua-para-pintar-7.gif','IFE','sss'),(28,0,'assets/adjuntos/contratos/','acuseDIC_.pdf','Prueba','algo');
/*!40000 ALTER TABLE `Adjuntos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Calles`
--

DROP TABLE IF EXISTS `Calles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Calles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(350) NOT NULL,
  `precio_base` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Calles`
--

LOCK TABLES `Calles` WRITE;
/*!40000 ALTER TABLE `Calles` DISABLE KEYS */;
INSERT INTO `Calles` VALUES (6,'La Estancia Sur','Sur',4422.32),(7,'La Estancia Norte','Norte',4422.32);
/*!40000 ALTER TABLE `Calles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Clientes`
--

DROP TABLE IF EXISTS `Clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Clientes` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Clientes`
--

LOCK TABLES `Clientes` WRITE;
/*!40000 ALTER TABLE `Clientes` DISABLE KEYS */;
INSERT INTO `Clientes` VALUES (2,1,1,'Carlos','Maldonado','Orozco','Calzada del Campesion','','265','San Pablo','Colima','Colima','','','3123131234','',''),(3,0,0,'Jorge','González','Becerra','Leon Felipe','','37','Lomas Verdes','Colima','Colima','','','3121361900','','');
/*!40000 ALTER TABLE `Clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Concesiones`
--

DROP TABLE IF EXISTS `Concesiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Concesiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `descripcion` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Concesiones`
--

LOCK TABLES `Concesiones` WRITE;
/*!40000 ALTER TABLE `Concesiones` DISABLE KEYS */;
INSERT INTO `Concesiones` VALUES (1,'Restaurante','Prueba de');
/*!40000 ALTER TABLE `Concesiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Configuracion`
--

DROP TABLE IF EXISTS `Configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Configuracion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(128) NOT NULL,
  `valor` varchar(128) NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Configuracion`
--

LOCK TABLES `Configuracion` WRITE;
/*!40000 ALTER TABLE `Configuracion` DISABLE KEYS */;
INSERT INTO `Configuracion` VALUES (5,'prefijo_contrato','CO','Prefijo para los números de contrato'),(6,'template_path','assets/templates/','Carpeta raíz donde se guardan los templates'),(7,'asset_path','assets/','Carpeta de Assets'),(9,'template_contratos','contrato.html','Archivo de plantilla para contratos.'),(10,'plano','plano.jpg','Nombre de archivo del plano de instalaciones de la feria'),(11,'imagenes','img/','Carpeta donde se guardan las imagenes para el sistema'),(12,'plano50','plano50.jpg','Nombre de archivo para el plano al 50% de su tamaño real'),(13,'plano75','plano75.jpg','Nombre de archivo para el plano al 75% de su tamaño real'),(14,'contrato_vencimiento','15','Vencimiento de contratos');
/*!40000 ALTER TABLE `Configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ContratoAdjuntos`
--

DROP TABLE IF EXISTS `ContratoAdjuntos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContratoAdjuntos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrato` int(11) NOT NULL,
  `id_adjunto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ContratoAdjuntos`
--

LOCK TABLES `ContratoAdjuntos` WRITE;
/*!40000 ALTER TABLE `ContratoAdjuntos` DISABLE KEYS */;
INSERT INTO `ContratoAdjuntos` VALUES (15,1,15),(16,1,16),(17,4,17),(18,4,18),(19,5,25),(20,4,28);
/*!40000 ALTER TABLE `ContratoAdjuntos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ContratoModulos`
--

DROP TABLE IF EXISTS `ContratoModulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContratoModulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrato` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_contrato` (`id_contrato`,`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ContratoModulos`
--

LOCK TABLES `ContratoModulos` WRITE;
/*!40000 ALTER TABLE `ContratoModulos` DISABLE KEYS */;
INSERT INTO `ContratoModulos` VALUES (13,4,9,5000.00),(14,4,10,6000.00),(15,4,11,4422.32);
/*!40000 ALTER TABLE `ContratoModulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Contratos`
--

DROP TABLE IF EXISTS `Contratos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Contratos` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Contratos`
--

LOCK TABLES `Contratos` WRITE;
/*!40000 ALTER TABLE `Contratos` DISABLE KEYS */;
INSERT INTO `Contratos` VALUES (1,3,0,'0','2013-11-01 06:00:00','0000-00-00','2013-11-17','Ana Cristina','Georgina','Prueba de contrato','cancelado'),(2,3,0,'1','2013-11-01 06:00:00','0000-00-00','2013-11-17','Ana Cristina','Ana Sofía','Prueba 2','cancelado'),(3,2,1,'2','2013-11-01 06:00:00','0000-00-00','2013-11-17','Ana Sofía','Georgina','Prueba 3','cancelado'),(4,3,1,'3','2013-05-14 17:51:56','2013-11-01','2013-11-17','Ana Sofía','Georgina','Prueba','cancelado');
/*!40000 ALTER TABLE `Contratos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ferias`
--

DROP TABLE IF EXISTS `Ferias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ferias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `observaciones` varchar(256) NOT NULL,
  `activa` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ferias`
--

LOCK TABLES `Ferias` WRITE;
/*!40000 ALTER TABLE `Ferias` DISABLE KEYS */;
/*!40000 ALTER TABLE `Ferias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Giros`
--

DROP TABLE IF EXISTS `Giros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Giros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `descripcion` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Giros`
--

LOCK TABLES `Giros` WRITE;
/*!40000 ALTER TABLE `Giros` DISABLE KEYS */;
INSERT INTO `Giros` VALUES (1,'Comida','Prueba');
/*!40000 ALTER TABLE `Giros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Modulos`
--

DROP TABLE IF EXISTS `Modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Modulos` (
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Modulos`
--

LOCK TABLES `Modulos` WRITE;
/*!40000 ALTER TABLE `Modulos` DISABLE KEYS */;
INSERT INTO `Modulos` VALUES (9,6,'',4.00,4.00,'1','local','',4422.32,'esquina'),(10,6,'',4.00,4.00,'2','local','',4422.32,'intermedio'),(11,7,'',4.00,4.00,'1','local','',4422.32,'intermedio');
/*!40000 ALTER TABLE `Modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Periodos`
--

DROP TABLE IF EXISTS `Periodos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Periodos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `observaciones` varchar(256) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Periodos`
--

LOCK TABLES `Periodos` WRITE;
/*!40000 ALTER TABLE `Periodos` DISABLE KEYS */;
INSERT INTO `Periodos` VALUES (1,'Feria 2012','2012-11-02','2012-11-18','',0),(2,'Feria 2011','2011-11-04','2011-11-20','',0),(3,'Feria 2013','2013-11-01','2013-11-17','',1);
/*!40000 ALTER TABLE `Periodos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Permisos`
--

DROP TABLE IF EXISTS `Permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Permisos` (
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
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Permisos`
--

LOCK TABLES `Permisos` WRITE;
/*!40000 ALTER TABLE `Permisos` DISABLE KEYS */;
INSERT INTO `Permisos` VALUES (1,'login/do_logout','login/do_logout','','','login','do_logout',1,''),(2,'preferencias','preferencias','preferencias','','preferencias','index',0,''),(3,'preferencias/configuracion_lista','Parametros de configuración','preferencias','','preferencias','configuracion_lista',1,'icon-list'),(4,'preferencias/configuracion_add','preferencias/configuracion_add','preferencias','','preferencias','configuracion_add',0,''),(5,'preferencias/configuracion_update','preferencias/configuracion_update','preferencias','','preferencias','configuracion_update',0,''),(6,'seguridad/permisos_lista','Permisos','preferencias','','seguridad','permisos_lista',1,'icon-list'),(7,'seguridad/permiso_update','seguridad/permiso_update','preferencias','','seguridad','permiso_update',0,''),(8,'seguridad/roles_lista','Roles','preferencias','','seguridad','roles_lista',1,'icon-list'),(9,'seguridad/rol_add','seguridad/rol_add','preferencias','','seguridad','rol_add',0,''),(10,'seguridad/rol_delete','seguridad/rol_delete','preferencias','','seguridad','rol_delete',0,''),(11,'plantillas/contratos','Contratos','preferencias','','plantillas','contratos',1,'icon-edit'),(12,'seguridad/usuarios_lista','Usuarios','preferencias','','seguridad','usuarios_lista',1,'icon-list'),(13,'seguridad/rol_permisos','seguridad/rol_permisos','preferencias','','seguridad','rol_permisos',0,''),(14,'seguridad/usuario_add','seguridad/usuario_add','preferencias','','seguridad','usuario_add',0,''),(15,'seguridad/usuario_permisos','seguridad/usuario_permisos','preferencias','','seguridad','usuario_permisos',0,''),(16,'seguridad/usuario_delete','seguridad/usuario_delete','preferencias','','seguridad','usuario_delete',0,''),(17,'catalogos','catalogos','catalogos','','catalogos','index',0,''),(20,'clientes/add','clientes/add','catalogos','','clientes','add',0,''),(21,'clientes/lista','Clientes','catalogos','','clientes','lista',1,'icon-list'),(22,'seguridad/permiso_delete','seguridad/permiso_delete','preferencias','','seguridad','permiso_delete',0,''),(23,'clientes/update','clientes/update','catalogos','','clientes','update',0,''),(24,'clientes/delete','clientes/delete','catalogos','','clientes','delete',0,''),(33,'clientes/giros_lista','Giros','catalogos','','clientes','giros_lista',1,'icon-list'),(34,'clientes/giros_add','clientes/giros_add','catalogos','','clientes','giros_add',0,''),(35,'clientes/giros_update','clientes/giros_update','catalogos','','clientes','giros_update',0,''),(36,'clientes/giros_delete','clientes/giros_delete','catalogos','','clientes','giros_delete',0,''),(37,'clientes/concesiones_lista','Concesiones','catalogos','','clientes','concesiones_lista',1,'icon-list'),(38,'clientes/concesiones_add','clientes/concesiones_add','catalogos','','clientes','concesiones_add',0,''),(39,'clientes/concesiones_update','clientes/concesiones_update','catalogos','','clientes','concesiones_update',0,''),(40,'clientes/concesiones_delete','clientes/concesiones_delete','catalogos','','clientes','concesiones_delete',0,''),(45,'operacion','operacion','operacion','','operacion','index',0,''),(49,'informes','informes','informes','','informes','index',1,''),(54,'ferias/calles','Calles','catalogos','','ferias','calles',1,'icon-list'),(55,'ferias/calles_update','ferias/calles_update','catalogos','','ferias','calles_update',0,''),(56,'ferias/modulos','Modulos','catalogos','','ferias','modulos',1,'icon-list'),(57,'ferias/calles_add','ferias/calles_add','catalogos','','ferias','calles_add',0,''),(58,'ferias/calles_delete','ferias/calles_delete','catalogos','','ferias','calles_delete',0,''),(59,'ferias/modulos_update','ferias/modulos_update','catalogos','','ferias','modulos_update',0,''),(60,'ferias/modulos_add','ferias/modulos_add','catalogos','','ferias','modulos_add',0,''),(61,'ferias/modulos_delete','ferias/modulos_delete','catalogos','','ferias','modulos_delete',0,''),(62,'ferias/periodos','Períodos','catalogos','','ferias','periodos',1,'icon-list'),(63,'ferias/periodos_add','ferias/periodos_add','catalogos','','ferias','periodos_add',0,''),(64,'ferias/periodos_update','ferias/periodos_update','catalogos','','ferias','periodos_update',0,''),(65,'ferias/periodos_delete','ferias/periodos_delete','catalogos','','ferias','periodos_delete',0,''),(69,'ventas/contratos','Contratos','operacion','','ventas','contratos',1,'icon-list'),(70,'ventas/contratos_update','ventas/contratos_update','operacion','','ventas','contratos_update',0,''),(71,'ventas/contratos_cancelar','ventas/contratos_cancelar','operacion','','ventas','contratos_cancelar',0,''),(72,'ventas/contratos_modulos','ventas/contratos_modulos','operacion','','ventas','contratos_modulos',0,''),(73,'ventas/contratos_add','ventas/contratos_add','operacion','','ventas','contratos_add',0,''),(74,'ventas/contratos_delete_modulo','ventas/contratos_delete_modulo','operacion','','ventas','contratos_delete_modulo',0,''),(75,'ventas/contratos_estado','ventas/contratos_estado','operacion','','ventas','contratos_estado',0,'');
/*!40000 ALTER TABLE `Permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PermisosRol`
--

DROP TABLE IF EXISTS `PermisosRol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PermisosRol` (
  `id_permisorol` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_rol` bigint(20) NOT NULL,
  `id_permiso` bigint(20) NOT NULL,
  `valor` tinyint(1) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_permisorol`),
  UNIQUE KEY `roleID_2` (`id_rol`,`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PermisosRol`
--

LOCK TABLES `PermisosRol` WRITE;
/*!40000 ALTER TABLE `PermisosRol` DISABLE KEYS */;
/*!40000 ALTER TABLE `PermisosRol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PermisosUsuario`
--

DROP TABLE IF EXISTS `PermisosUsuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PermisosUsuario` (
  `id_permisousuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) NOT NULL,
  `id_permiso` bigint(20) NOT NULL,
  `valor` tinyint(1) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_permisousuario`),
  UNIQUE KEY `userID` (`id_usuario`,`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PermisosUsuario`
--

LOCK TABLES `PermisosUsuario` WRITE;
/*!40000 ALTER TABLE `PermisosUsuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `PermisosUsuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Roles`
--

DROP TABLE IF EXISTS `Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Roles` (
  `id_rol` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `roleName` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Roles`
--

LOCK TABLES `Roles` WRITE;
/*!40000 ALTER TABLE `Roles` DISABLE KEYS */;
INSERT INTO `Roles` VALUES (1,'Superusuario',''),(3,'Administrador','Personal administrativo');
/*!40000 ALTER TABLE `Roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RolesUsuario`
--

DROP TABLE IF EXISTS `RolesUsuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RolesUsuario` (
  `id_rolusuario` int(11) NOT NULL,
  `id_usuario` bigint(20) NOT NULL,
  `id_rol` bigint(20) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `userID` (`id_usuario`,`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RolesUsuario`
--

LOCK TABLES `RolesUsuario` WRITE;
/*!40000 ALTER TABLE `RolesUsuario` DISABLE KEYS */;
INSERT INTO `RolesUsuario` VALUES (1,1,1,'2013-03-21 02:23:11');
/*!40000 ALTER TABLE `RolesUsuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuarios`
--

DROP TABLE IF EXISTS `Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Usuarios` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `activo` enum('s','n') NOT NULL DEFAULT 's',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuarios`
--

LOCK TABLES `Usuarios` WRITE;
/*!40000 ALTER TABLE `Usuarios` DISABLE KEYS */;
INSERT INTO `Usuarios` VALUES (1,'Jorge','jorge','33f927344e079e00d3fa45d8833b04e735223eec','s');
/*!40000 ALTER TABLE `Usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-14 14:10:33
