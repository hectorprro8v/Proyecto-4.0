-- MySQL dump 10.13  Distrib 8.0.45, for Win64 (x86_64)
--
-- Host: sicsacid.itslerdo.edu.mx    Database: bdsicsacid
-- ------------------------------------------------------
-- Server version	5.7.23-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articulo`
--

CREATE TABLE `articulo` (
  `idArticulo` int(11) NOT NULL AUTO_INCREMENT,
  `Clave_Articulo` varchar(20) NOT NULL,
  `Nombre_Articulo` varchar(250) NOT NULL,
  `Nombre_ingles` varchar(250) NOT NULL,
  `idLinea` int(11) DEFAULT NULL,
  `idContacto` int(11) DEFAULT NULL,
  `Institucion` varchar(150) NOT NULL,
  `Pais` varchar(50) NOT NULL,
  `Estado` varchar(50) NOT NULL,
  `Ciudad` varchar(50) NOT NULL,
  `Dictamen_Resumen` bit(1) DEFAULT NULL,
  `Dictamen_Extenso` bit(1) DEFAULT NULL,
  `Aceptado` bit(1) DEFAULT NULL,
  `Publicado` bit(1) DEFAULT b'0',
  `Anio` char(4) DEFAULT NULL,
  `Volumen` char(5) DEFAULT NULL,
  `Numero` char(5) DEFAULT NULL,
  `URL` text,
  `doi` varchar(120) DEFAULT NULL,
  `Url_landing` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`idArticulo`),
  KEY `idLinea` (`idLinea`),
  KEY `idContacto` (`idContacto`),
  CONSTRAINT `articulo_ibfk_1` FOREIGN KEY (`idLinea`) REFERENCES `linea_investigacion` (`idLinea`),
  CONSTRAINT `articulo_ibfk_2` FOREIGN KEY (`idContacto`) REFERENCES `usuario` (`idUsuario`)
) ;

--
-- Table structure for table `autores`
--

DROP TABLE IF EXISTS `autores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `autores` (
  `idautor` int(11) NOT NULL AUTO_INCREMENT,
  `idArticulo` int(11) NOT NULL,
  `Nombres` varchar(50) NOT NULL,
  `Apellido_Paterno` varchar(50) NOT NULL,
  `Apellido_Materno` varchar(50) NOT NULL,
  `Institucion` varchar(150) NOT NULL,
  `Correo_Electronico` varchar(100) DEFAULT NULL,
  `ORCID` text,
  `CVU` text,
  `Principal` bit(1) NOT NULL,
  `GradoEstudio` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idautor`),
  KEY `idArticulo` (`idArticulo`),
  CONSTRAINT `autores_ibfk_1` FOREIGN KEY (`idArticulo`) REFERENCES `articulo` (`idArticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=357 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `criterio_extenso_revisor`
--

DROP TABLE IF EXISTS `criterio_extenso_revisor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `criterio_extenso_revisor` (
  `id_criterio_extenso_revisor` int(11) NOT NULL AUTO_INCREMENT,
  `id_extenso_revisor` int(11) DEFAULT NULL,
  `idCriterio` int(11) DEFAULT NULL,
  `observaciones` text,
  `estatus` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_criterio_extenso_revisor`),
  KEY `id_extenso_revisor` (`id_extenso_revisor`),
  KEY `idCriterio` (`idCriterio`),
  CONSTRAINT `criterio_extenso_revisor_ibfk_1` FOREIGN KEY (`id_extenso_revisor`) REFERENCES `extenso_revisor` (`id_extenso_revisor`),
  CONSTRAINT `criterio_extenso_revisor_ibfk_2` FOREIGN KEY (`idCriterio`) REFERENCES `criterios` (`idCriterio`)
) ENGINE=InnoDB AUTO_INCREMENT=6777 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `criterios`
--

DROP TABLE IF EXISTS `criterios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `criterios` (
  `idCriterio` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) DEFAULT NULL,
  `puntuacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCriterio`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documento`
--

DROP TABLE IF EXISTS `documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documento` (
  `idDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `idArticulo` int(11) DEFAULT NULL,
  `Nombre_Documento` varchar(100) NOT NULL,
  `Tipo_Documento` char(4) DEFAULT NULL,
  `URL` text,
  `Fecha_Envio` date DEFAULT NULL,
  `Fecha_Recepcion` date DEFAULT NULL,
  PRIMARY KEY (`idDocumento`),
  KEY `idArticulo` (`idArticulo`),
  CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`idArticulo`) REFERENCES `articulo` (`idArticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=406 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documentos_financiero`
--

DROP TABLE IF EXISTS `documentos_financiero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos_financiero` (
  `idDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `idRecibo` int(11) DEFAULT NULL,
  `Nombre_Documento` varchar(100) DEFAULT NULL,
  `Tipo_Documento` char(4) DEFAULT NULL,
  `URL` text,
  `Fecha_Envio` date DEFAULT NULL,
  `Fecha_Recepcion` date DEFAULT NULL,
  PRIMARY KEY (`idDocumento`),
  KEY `idRecibo` (`idRecibo`),
  CONSTRAINT `documentos_financiero_ibfk_1` FOREIGN KEY (`idRecibo`) REFERENCES `recibo_pago` (`idRecibo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `extenso`
--

DROP TABLE IF EXISTS `extenso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `extenso` (
  `idArticulo` int(11) DEFAULT NULL,
  `Status_Ext` varchar(20) NOT NULL,
  `Aceptado` bit(1) DEFAULT NULL,
  `Modificaciones` text,
  `Observaciones` text,
  `Fecha_Recepcion` date DEFAULT NULL,
  `Fecha_Dictamen` date DEFAULT NULL,
  `idDocumentoExtenso` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `Concluido` bit(1) DEFAULT b'0',
  `idDocumentoExtensoSA` int(11) DEFAULT NULL,
  `ObsCriterio` text,
  `statusPrimeraRev` char(1) DEFAULT NULL,
  `statusExtensoMod` bit(1) DEFAULT NULL,
  KEY `idArticulo` (`idArticulo`),
  KEY `idUsuario` (`idUsuario`),
  CONSTRAINT `extenso_ibfk_1` FOREIGN KEY (`idArticulo`) REFERENCES `articulo` (`idArticulo`),
  CONSTRAINT `extenso_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `extenso_revisor`
--

DROP TABLE IF EXISTS `extenso_revisor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `extenso_revisor` (
  `id_extenso_revisor` int(11) NOT NULL AUTO_INCREMENT,
  `idArticulo` int(11) DEFAULT NULL,
  `idRevisor` int(11) DEFAULT NULL,
  `Fecha_Revision` date DEFAULT NULL,
  `Aceptado` char(1) DEFAULT NULL,
  `Modificaciones` text,
  `Observaciones` text,
  `Fecha_Asignacion` date DEFAULT NULL,
  `Concluido` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id_extenso_revisor`),
  KEY `idArticulo` (`idArticulo`),
  KEY `idRevisor` (`idRevisor`),
  CONSTRAINT `extenso_revisor_ibfk_1` FOREIGN KEY (`idArticulo`) REFERENCES `articulo` (`idArticulo`),
  CONSTRAINT `extenso_revisor_ibfk_2` FOREIGN KEY (`idRevisor`) REFERENCES `revisor` (`idRevisor`)
) ENGINE=InnoDB AUTO_INCREMENT=220 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE TRIGGER `tgCriterios` AFTER INSERT ON `extenso_revisor` FOR EACH ROW BEGIN
	insert into criterio_extenso_revisor(id_extenso_revisor, idCriterio) 
		select new.id_extenso_revisor, criterios.idCriterio
		from criterios;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `linea_investigacion`
--

DROP TABLE IF EXISTS `linea_investigacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `linea_investigacion` (
  `idLinea` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`idLinea`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parametros`
--

DROP TABLE IF EXISTS `parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parametros` (
  `id_parametros` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Revista` text,
  `Consec_Art` int(11) DEFAULT NULL,
  `Color_Revista` varchar(16) DEFAULT NULL,
  `Anio` char(4) DEFAULT NULL,
  `Volumen` char(5) DEFAULT NULL,
  `Numero` char(5) DEFAULT NULL,
  `Recepcion_Resumen` date DEFAULT NULL,
  `Fecha_Limite_Resumen` date DEFAULT NULL,
  `Fecha_Limite_Revision_Resumen` date DEFAULT NULL,
  `Fecha_Limite_Extenso` date DEFAULT NULL,
  `Fecha_Limite_Revision_Extenso` date DEFAULT NULL,
  `Fecha_Limite_Extenso_Modificado` date DEFAULT NULL,
  `Fecha_Limite_Subir_Presentacion` date DEFAULT NULL,
  `Link_Publicacion` varchar(300) DEFAULT NULL,
  `ISSN` varchar(45) DEFAULT NULL,
  `Linea_Captura` text,
  `Doi` text,
  `Dia_publicacion` int(11) DEFAULT NULL,
  `Mes_publicacion` int(11) DEFAULT NULL,
  `Año_publicacion` int(11) DEFAULT NULL,
  `Base_URL_Landing` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_parametros`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recibo_pago`
--

DROP TABLE IF EXISTS `recibo_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recibo_pago` (
  `idRecibo` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `RFC` varchar(15) NOT NULL,
  `Razon_Social` text,
  `Domicilio` varchar(500) DEFAULT NULL,
  `Ciudad` varchar(50) NOT NULL,
  `Estado` varchar(50) NOT NULL,
  `Pais` varchar(50) NOT NULL,
  `CP` char(10) NOT NULL,
  `Forma_Pago` varchar(200) DEFAULT NULL,
  `Regimen_Fiscal` text,
  `Sub_Total` varchar(20) NOT NULL,
  `Iva` varchar(10) NOT NULL,
  `Total` varchar(10) NOT NULL,
  `Folio_Factura` varchar(50) DEFAULT NULL,
  `Otro` text,
  `Validado` bit(1) DEFAULT b'0',
  `Id_Precio_Pago` int(11) DEFAULT '1',
  `Comprobante` char(1) NOT NULL DEFAULT '0',
  `UsoCFDI` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idRecibo`),
  KEY `Id_Precio_Pago` (`Id_Precio_Pago`),
  CONSTRAINT `Id_Precio_Pago` FOREIGN KEY (`Id_Precio_Pago`) REFERENCES `tipopago` (`idTipoPago`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recibo_pago_detalle`
--

DROP TABLE IF EXISTS `recibo_pago_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recibo_pago_detalle` (
  `idRecibo` int(11) DEFAULT NULL,
  `idArticulo` int(11) DEFAULT NULL,
  KEY `idRecibo` (`idRecibo`),
  KEY `idArticulo` (`idArticulo`),
  CONSTRAINT `recibo_pago_detalle_ibfk_1` FOREIGN KEY (`idRecibo`) REFERENCES `recibo_pago` (`idRecibo`),
  CONSTRAINT `recibo_pago_detalle_ibfk_2` FOREIGN KEY (`idArticulo`) REFERENCES `articulo` (`idArticulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resumen`
--

DROP TABLE IF EXISTS `resumen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resumen` (
  `id_resumen` int(11) NOT NULL AUTO_INCREMENT,
  `idArticulo` int(11) NOT NULL,
  `Resumen_Art` text NOT NULL,
  `Abstract_Art` text NOT NULL,
  `Palabras_Clave` text NOT NULL,
  `Keywords` text NOT NULL,
  `Status_Art` varchar(20) DEFAULT NULL,
  `Aceptado` bit(1) DEFAULT NULL,
  `Justificacion` text,
  `Fecha_Recepcion` date DEFAULT NULL,
  `Fecha_Dictamen` date DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `Concluido` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id_resumen`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idArticulo` (`idArticulo`),
  CONSTRAINT `resumen_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `resumen_ibfk_2` FOREIGN KEY (`idArticulo`) REFERENCES `articulo` (`idArticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resumen_comite`
--

DROP TABLE IF EXISTS `resumen_comite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resumen_comite` (
  `id_resumen_comite` int(11) NOT NULL AUTO_INCREMENT,
  `idArticulo` int(11) DEFAULT NULL,
  `Aceptado` bit(1) DEFAULT NULL,
  `Justificacion` text,
  `Fecha_Revision` date DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `Fecha_Asignacion` date DEFAULT NULL,
  `Concluido` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id_resumen_comite`),
  KEY `idArticulo` (`idArticulo`),
  KEY `idUsuario` (`idUsuario`),
  CONSTRAINT `resumen_comite_ibfk_1` FOREIGN KEY (`idArticulo`) REFERENCES `articulo` (`idArticulo`),
  CONSTRAINT `resumen_comite_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `revisor`
--

DROP TABLE IF EXISTS `revisor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revisor` (
  `idRevisor` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) DEFAULT NULL,
  `Perfil` text,
  `URL_Ficha_Pres` text,
  `Tipo` varchar(10) NOT NULL DEFAULT 'INT',
  `Cartaterminacion` bit(1) DEFAULT b'0',
  `Grado_Estudios` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idRevisor`),
  KEY `idUsuario` (`idUsuario`),
  CONSTRAINT `revisor_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `revisor_linea`
--

DROP TABLE IF EXISTS `revisor_linea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revisor_linea` (
  `idLinea` int(11) DEFAULT NULL,
  `idRevisor` int(11) DEFAULT NULL,
  `Principal` bit(1) DEFAULT NULL,
  KEY `idLinea` (`idLinea`),
  KEY `idRevisor` (`idRevisor`),
  CONSTRAINT `revisor_linea_ibfk_1` FOREIGN KEY (`idLinea`) REFERENCES `linea_investigacion` (`idLinea`),
  CONSTRAINT `revisor_linea_ibfk_2` FOREIGN KEY (`idRevisor`) REFERENCES `revisor` (`idRevisor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_usuario` (
  `Id_Tipo_Usuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Tipo_Usuario` varchar(50) NOT NULL,
  `Caracter_tipo` char(1) NOT NULL,
  PRIMARY KEY (`Id_Tipo_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipopago`
--

DROP TABLE IF EXISTS `tipopago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipopago` (
  `idTipoPago` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Precio` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idTipoPago`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `token` (
  `TipoUsuario` char(1) DEFAULT NULL,
  `Token` char(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Correo_Electronico` varchar(100) NOT NULL,
  `Contrasenia` varchar(40) NOT NULL,
  `Nombres` varchar(50) DEFAULT NULL,
  `Apellido_Paterno` varchar(50) DEFAULT NULL,
  `Apellido_Materno` varchar(50) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Institucion` varchar(300) DEFAULT NULL,
  `Correo_Alternativo` varchar(100) DEFAULT NULL,
  `Nuevo` bit(1) NOT NULL,
  `FechaAlta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Activo` bit(1) DEFAULT b'1',
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE TRIGGER `bdsicsacid`.`usuario_BEFORE_INSERT` BEFORE INSERT ON `usuario` FOR EACH ROW
BEGIN
 IF LOWER(NEW.Correo_Electronico) = 'testing@example.com'
       OR LOWER(NEW.Correo_Electronico) LIKE '%@example.com'
       OR LOWER(NEW.Correo_Electronico) LIKE 'test%@%'
       OR LOWER(NEW.Correo_Electronico) LIKE 'testing%@%' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se permiten correos de prueba';
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`ubdsicsacid`@`%`*/ /*!50003 TRIGGER `bdsicsacid`.`usuario_BEFORE_UPDATE` BEFORE UPDATE ON `usuario` FOR EACH ROW
BEGIN
 IF LOWER(NEW.Correo_Electronico) = 'testing@example.com'
       OR LOWER(NEW.Correo_Electronico) LIKE '%@example.com'
       OR LOWER(NEW.Correo_Electronico) LIKE 'test%@%'
       OR LOWER(NEW.Correo_Electronico) LIKE 'testing%@%' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se permiten correos de prueba';
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `usuario_tipo`
--

DROP TABLE IF EXISTS `usuario_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_tipo` (
  `id_usuariotipopk` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` int(11) NOT NULL,
  `TipoUsuario` int(11) NOT NULL,
  PRIMARY KEY (`id_usuariotipopk`),
  KEY `Usuario` (`Usuario`),
  KEY `TipoUsuario` (`TipoUsuario`),
  CONSTRAINT `usuario_tipo_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `usuario_tipo_ibfk_2` FOREIGN KEY (`TipoUsuario`) REFERENCES `tipo_usuario` (`Id_Tipo_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'bdsicsacid'
--

--
-- Dumping routines for database 'bdsicsacid'
--
/*!50003 DROP FUNCTION IF EXISTS `fn_orcid_canonical` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `fn_orcid_canonical`(p_in VARCHAR(128)) RETURNS varchar(64) CHARSET latin1
    DETERMINISTIC
BEGIN
  DECLARE s VARCHAR(32);
  DECLARE i INT DEFAULT 1;
  DECLARE ch CHAR(1);
  DECLARE d INT;
  DECLARE total INT DEFAULT 0;
  DECLARE remainder INT;
  DECLARE result INT;
  DECLARE checkch CHAR(1);

  IF p_in IS NULL OR TRIM(p_in) = '' THEN RETURN NULL; END IF;

  SET s = LOWER(TRIM(p_in));
  IF s LIKE 'http://orcid.org/%' THEN
    SET s = SUBSTRING(s, 18);
  ELSEIF s LIKE 'https://orcid.org/%' THEN
    SET s = SUBSTRING(s, 19);
  END IF;

  SET s = REPLACE(REPLACE(REPLACE(REPLACE(s, '-', ''), ' ', ''), '/', ''), '.', '');
  IF s REGEXP '^[0-9]{15}[0-9x]$' = 0 THEN RETURN NULL; END IF;

  SET i = 1; SET total = 0;
  WHILE i <= 15 DO
    SET ch = SUBSTRING(s, i, 1);
    SET d = CAST(ch AS UNSIGNED);
    SET total = (total + d) * 2;
    SET i = i + 1;
  END WHILE;

  SET remainder = total % 11;
  SET result = (12 - remainder) % 11;
  SET checkch = CASE WHEN result = 10 THEN 'x' ELSE CHAR(48 + result) END;

  IF checkch <> SUBSTRING(s, 16, 1) THEN RETURN NULL; END IF;

  SET s = CONCAT(SUBSTRING(s,1,4),'-',SUBSTRING(s,5,4),'-',SUBSTRING(s,9,4),'-',
                 CONCAT(SUBSTRING(s,13,3), UCASE(SUBSTRING(s,16,1))));
  RETURN CONCAT('https://orcid.org/', s);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_xml_escape` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` FUNCTION `fn_xml_escape`(p_txt LONGTEXT) RETURNS longtext CHARSET latin1
    DETERMINISTIC
BEGIN
  IF p_txt IS NULL THEN RETURN NULL; END IF;
  SET p_txt = REPLACE(p_txt, '&',  '&amp;');
  SET p_txt = REPLACE(p_txt, '<',  '&lt;');
  SET p_txt = REPLACE(p_txt, '>',  '&gt;');
  SET p_txt = REPLACE(p_txt, '"',  '&quot;');
  SET p_txt = REPLACE(p_txt, '''', '&apos;');
  RETURN p_txt;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ActualizaContraseniaRevisor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `ActualizaContraseniaRevisor`()
BEGIN
    DECLARE v_idUsuario INT;
    DECLARE terminado INT DEFAULT 0;

    DECLARE cur_usuarios CURSOR FOR
        SELECT idUsuario FROM usuario where idUsuario in (Select Usuario from usuario_tipo where TipoUsuario=3);

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET terminado = 1;

    OPEN cur_usuarios;

    ciclo: LOOP
        FETCH cur_usuarios INTO v_idUsuario;

        IF terminado = 1 THEN
            LEAVE ciclo;
        END IF;

        CALL bdsicsacid.sp_ActualizaContraseniaUser('2eBHJ7467hWA', v_idUsuario);
    END LOOP;

    CLOSE cur_usuarios;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `publicar` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE ` PROCEDURE `publicar`(in idArt int)
BEGIN
	UPDATE articulo SET Publicado = 1 WHERE idArticulo = idArt;
    Select Clave_Articulo from articulo where idArticulo=idArt;
	insert into documento(idArticulo,Nombre_Documento,Tipo_Documento,URL,Fecha_Envio,Fecha_Recepcion)
	values(idArt,'Carta Publicación','CP',(select concat ('../Documentos/Carta_Publicacion/CP-',(Select  Clave_Articulo from articulo where idArticulo=idArt),'.pdf')),curdate(),NULL);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spAltaExtenso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `spAltaExtenso`(IN `_idArticulo` INT,
 IN `_Nombre` VARCHAR(100), 
 IN `_Tipo` CHAR(4), 
 IN `_URL` TEXT,
 IN `_NombreSA` VARCHAR(100), 
 IN `_TipoSA` CHAR(4), 
 IN `_URLSA` TEXT,
 IN  `_Concluido`boolean)
BEGIN
	if not exists(Select *  from Extenso where idArticulo=_idArticulo) then
		Begin
			insert into documento(idArticulo, Nombre_Documento, Tipo_Documento, URL, Fecha_Envio) 
			values(_idArticulo, _Nombre, _Tipo , _URL,
			(select date_format((SELECT NOW()), "%Y-%m-%d")));
			insert into documento(idArticulo, Nombre_Documento, Tipo_Documento, URL, Fecha_Envio) 
			values(_idArticulo, _NombreSA, _TipoSA, _URLSA,
			(select date_format((SELECT NOW()), "%Y-%m-%d")));
			insert into extenso(idArticulo, Status_Ext, Fecha_Recepcion, idDocumentoExtenso, idDocumentoExtensoSA, Concluido) 
			values(_idArticulo, 'En revision', 
			(select date_format((SELECT NOW()), "%Y-%m-%d")), 
			(select idDocumento from documento where idArticulo = _idArticulo and Tipo_Documento = 'E'), 
			(select idDocumento from documento where idArticulo = _idArticulo and Tipo_Documento = 'ESA'), _Concluido);
		end;
        else
			begin
				Update Extenso set concluido=_Concluido  where idArticulo=_idArticulo;
                update documento set Nombre_Documento=_Nombre, URL=_URL, Fecha_Envio=(select date_format((SELECT NOW()), "%Y-%m-%d"))
					where idDocumento = (Select idDocumentoExtenso from extenso where idArticulo=_idArticulo);
				update documento set Nombre_Documento=_NombreSA, URL=_URLSA, Fecha_Envio=(select date_format((SELECT NOW()), "%Y-%m-%d"))
					where idDocumento = (Select idDocumentoExtensoSA from extenso where idArticulo=_idArticulo);
            end;
    End if ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spAltaFactura` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `spAltaFactura`(IN `_idRecibo` INT, IN `_pago` VARCHAR(50), IN `_regimen` TEXT, IN `_folio` VARCHAR(100), IN `_otro` TEXT, IN `_archivo_xml` VARCHAR(100), IN `_url_xml` TEXT, IN `_archivo_pdf` VARCHAR(100), IN `_url_pdf` TEXT)
BEGIN
	update recibo_pago set Forma_Pago=_pago, Regimen_Fiscal=_regimen, Folio_Factura=_folio, Otro=_otro where idRecibo=_idRecibo;
    /*INSERTA EL ARCHIVO XML*/
    insert into documentos_financiero (idRecibo, Nombre_Documento, Tipo_Documento, URL, Fecha_Envio) values(_idRecibo, _archivo_xml, 'FXML', _url_xml, (select current_date()));
    /*INSERTA EL ARCHIVO PDF*/
    insert into documentos_financiero (idRecibo, Nombre_Documento, Tipo_Documento, URL, Fecha_Envio) values(_idRecibo, _archivo_pdf, 'FPDF', _url_pdf, (select current_date()));
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spAltaResumen` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `spAltaResumen`(IN `_Nombre` VARCHAR(400), IN `_titulo_ingles` VARCHAR(400)  ,IN `_Linea` VARCHAR(100), IN `_idContacto` INT, IN `_Institucion` VARCHAR(150), IN `_Pais` VARCHAR(50), IN `_Estado` VARCHAR(50), IN `_Ciudad` VARCHAR(50), IN `_Resumen` TEXT, IN `_Abstract` TEXT, IN `_Palabras_Clave` TEXT, IN `_Keywords` TEXT, IN `_Anio` CHAR(4), IN `_Volumen` CHAR(2), IN `_Numero` INT)
begin
declare _Clave varchar(10);
declare _consecutivo int; set _consecutivo = (select Consec_Art from parametros)+1;
set _Clave =(select CONCAT('CID', LPAD(_consecutivo, 3, '0')));
	insert into articulo(Clave_Articulo, Nombre_Articulo, Nombre_ingles, idLinea, idContacto, Institucion, Pais, Estado, Ciudad, Anio, Volumen, Numero)
    values(_Clave, _Nombre, _titulo_ingles  ,(select idLinea from linea_investigacion where Nombre = _Linea), _idContacto, _Institucion, _Pais, _Estado, _Ciudad, _Anio, _Volumen, _Numero);
    insert into resumen(idArticulo, Resumen_Art, Abstract_Art, Palabras_Clave, Keywords, Status_Art, Fecha_Recepcion)
    values(LAST_INSERT_ID(), _Resumen, _Abstract, _Palabras_Clave, _Keywords, 'En revision', (select date_format((SELECT NOW()), "%Y-%m-%d")));
    update parametros set Consec_Art = _consecutivo;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spAltaSegundoExtenso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `spAltaSegundoExtenso`(IN `_idArticulo` INT,
 IN `_Nombre` VARCHAR(100), 
 IN `_Tipo` CHAR(4), 
 IN `_URL` TEXT,
 IN `_NombreSA` VARCHAR(100), 
 IN `_TipoSA` CHAR(4), 
 IN `_URLSA` TEXT,
 IN  `_Concluido`boolean)
BEGIN
if exists(Select *  from Extenso where idArticulo=_idArticulo) then
		begin
				Update Extenso set concluido=_Concluido  where idArticulo=_idArticulo;
                update documento set Nombre_Documento=_Nombre, URL=_URL, Fecha_Envio=(select date_format((SELECT NOW()), "%Y-%m-%d"))
					where idDocumento = (Select idDocumentoExtenso from extenso where idArticulo=_idArticulo);
				update documento set Nombre_Documento=_NombreSA, URL=_URLSA, Fecha_Envio=(select date_format((SELECT NOW()), "%Y-%m-%d"))
					where idDocumento = (Select idDocumentoExtensoSA from extenso where idArticulo=_idArticulo);
				UPDATE extenso set statusExtensoMod = 1,  Status_Ext='En revision' where idArticulo = _idArticulo;
                update extenso_revisor set Aceptado=null, Fecha_Revision=null, Concluido=0 where idArticulo=_idArticulo;
			end;
        End if ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spDictamen` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `spDictamen`(IN `just` TEXT, IN `D_res` INT, IN `idArt` INT, IN `idUs` INT)
begin

IF D_res=1 then
	update resumen as r inner join articulo as a on a.idArticulo=r.idArticulo
		set r.Aceptado=1,a.Dictamen_Resumen=1,r.Justificacion=just,r.Status_Art='Dictamen',
		r.Fecha_Dictamen=CURDATE(),r.idUsuario=idUs
		where r.idArticulo=idArt;

ELSE
	update resumen as r inner join articulo as a on a.idArticulo=r.idArticulo
	set r.Aceptado=0,a.Dictamen_Resumen=0,r.Justificacion=just,r.Status_Art='Dictamen',
	r.Fecha_Dictamen=CURDATE(),r.idUsuario=idUs
	where r.idArticulo=idArt;
end IF;
	Update resumen set Concluido=1 where idArticulo=idArt;
    Update resumen_comite set Concluido=1 where idArticulo=idArt;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spDictamen_A` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `spDictamen_A`(
IN `D_res` INT, 
IN `m` TEXT, 
IN `o` TEXT, 
IN `idArt` INT, 
IN `idUs` INT,
in `crit` TEXT
)
begin
	IF D_res=1 then
	update extenso as e inner join articulo as a on a.idArticulo=e.idArticulo 
	set 
		e.Aceptado=1,
		e.Modificaciones=m,
		e.Observaciones=o,
		e.ObsCriterio=crit,
		a.Dictamen_Extenso=1,
		a.Aceptado=1,
		e.Status_Ext='Aceptado',
		e.Fecha_Dictamen=CURDATE(),
		e.idUsuario=idUs,
		e.statusPrimeraRev=0,
        e.concluido=1
	where 
		e.idArticulo=idArt;
END IF;
IF D_res=3 then
	update extenso as e inner join articulo as a on a.idArticulo=e.idArticulo 
	set 
		e.Aceptado=0,
		e.Modificaciones=m,
		e.Observaciones=o,
		e.ObsCriterio=crit,
		a.Dictamen_Extenso=0,
		a.Aceptado=0,
		e.Status_Ext='Segunda Revision',
		e.Fecha_Dictamen=CURDATE(),
		e.idUsuario=idUs,
		e.statusPrimeraRev=1,
        e.concluido = 0
	where 
		e.idArticulo=idArt;
	UPDATE extenso_revisor as ER SET ER.Concluido = 0, ER.Aceptado = 'S' WHERE idArticulo = idArt;
END IF;
IF D_res=2 then
	update extenso as e inner join articulo as a on a.idArticulo=e.idArticulo 
	set 
		e.Aceptado=0,
		e.Modificaciones=m,
		e.Observaciones=o,
		e.ObsCriterio=crit,
		a.Dictamen_Extenso=0,
		a.Aceptado=0,
		e.Status_Ext='No Aceptado',
		e.Fecha_Dictamen=CURDATE(),
		e.idUsuario=idUs,
		e.statusPrimeraRev=0,
        e.concluido=1
	where 
		e.idArticulo=idArt;
END IF;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spEperfil` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `spEperfil`(IN `_id` INT, IN `_nombre` VARCHAR(50), IN `_aPaterno` VARCHAR(50), IN `_aMaterno` VARCHAR(50), IN `_telefono` VARCHAR(15), IN `_instituto` VARCHAR(50), IN `_alternativo` VARCHAR(50), IN `_perfil` TEXT)
BEGIN
	update usuario set Nombres = _nombre, Apellido_Paterno = _aPaterno, Apellido_Materno = _aMaterno, Telefono = _telefono, Institucion = _instituto, Correo_Alternativo = _alternativo, Nuevo = 0 where idUsuario = _id;
	update revisor set Perfil = _perfil where idUsuario = _id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spEvalrevisor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `spEvalrevisor`(IN `clave` VARCHAR(15), IN `id` INT, IN `acept` CHAR(1), IN `modif` TEXT, IN `obser` TEXT, IN `Con` INT)
begin
    if Con=1
    then  
            update extenso_revisor as ex inner join articulo as a on a.idArticulo=ex.idArticulo
            set ex.Aceptado=acept, ex.Modificaciones = modif, ex.Observaciones = obser,
            ex.Fecha_Revision=curdate(), ex.Concluido=1 
            where
            a.Clave_Articulo=clave  and ex.idRevisor = id;
		
	 else 
           update extenso_revisor as ex inner join articulo as a on a.idArticulo=ex.idArticulo
            set ex.Aceptado=null, ex.Modificaciones = modif, ex.Observaciones = obser,
            ex.Fecha_Revision=null, ex.Concluido=0
            where
            a.Clave_Articulo=clave and ex.idRevisor = id;
            
	end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spEvaluars` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `spEvaluars`(IN `id` INT, IN `acept` INT, IN `just` TEXT, IN `clave` VARCHAR(15), IN `Con` INT)
begin

    if Con=1
    then  
            update resumen_comite as r inner join articulo as a on a.idArticulo=r.idArticulo
            set r.Aceptado=acept, Justificacion=just, 
            Fecha_Revision=curdate(), Concluido=1 
            where
            Clave_Articulo=clave and idUsuario = id;
            
	 else 
			update resumen_comite as r inner join articulo as a on a.idArticulo=r.idArticulo
            set r.Aceptado=null, Justificacion=just,
            Fecha_Revision=null,Concluido=0
            where
            Clave_Articulo=clave and idUsuario = id;
            
	end if;
	end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_ActualizaContraseniaUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `sp_ActualizaContraseniaUser`(
    in Contra varchar (40),
    in Id_Usuario int
)
begin
	declare token char(5);

        set token=(select distinct(case TipoUsuario when 5 then 'charC'
		else 'charT' end) 
from usuario_tipo  where Usuario= Id_Usuario);

update usuario set Contrasenia = TO_BASE64(AES_ENCRYPT(Contra, token))
-- aes_encrypt(Contra,token) 
where  idUsuario= Id_Usuario; 


	
    
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_actualiza_identificadores_aceptados` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `sp_actualiza_identificadores_aceptados`()
BEGIN
  DECLARE v_doi_pref   VARCHAR(300);
  DECLARE v_base       VARCHAR(300);
  DECLARE v_link       VARCHAR(300);

  -- Lee parámetros (una sola fila)
  SELECT Doi, Base_URL_Landing, Link_Publicacion
    INTO v_doi_pref, v_base, v_link
  FROM parametros
  LIMIT 1;

  
  IF v_doi_pref IS NULL THEN SET v_doi_pref := ''; END IF;
  IF v_base     IS NULL THEN SET v_base     := ''; END IF;
  IF v_link     IS NULL THEN SET v_link     := ''; END IF;

  
  -- Base_URL_Landing: debe terminar en "/"
  IF v_base <> '' AND RIGHT(v_base,1) <> '/' THEN
    SET v_base := CONCAT(v_base, '/');
  END IF;

  
  IF v_doi_pref <> '' AND RIGHT(v_doi_pref,1) <> '.' THEN
    SET v_doi_pref := CONCAT(v_doi_pref, '.');
  END IF;

  IF v_link <> '' AND RIGHT(v_link,1) <> '.' THEN
    SET v_link := CONCAT(v_link, '.');
  END IF;

 
  UPDATE articulo
     SET doi         = CONCAT(v_doi_pref, UPPER(TRIM(Clave_Articulo))),
         Url_Landing = CONCAT(v_base,     UPPER(TRIM(Clave_Articulo))),
         url         = CONCAT(v_link,     UPPER(TRIM(Clave_Articulo)))
   WHERE Aceptado = b'1'
     AND idArticulo > 0;  -- ayuda con Safe Update Mode
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_generar_crossref_xml_aceptados` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `sp_generar_crossref_xml_aceptados`(IN p_outfile VARCHAR(512))
BEGIN
  DECLARE v_nombre_revista   TEXT;
  DECLARE v_issn             VARCHAR(45);
  DECLARE v_prefijo_doi      TEXT;
  DECLARE v_base_landing     TEXT;
  DECLARE v_volumen          CHAR(5);
  DECLARE v_numero           CHAR(5);
  DECLARE v_day              CHAR(2);
  DECLARE v_month            CHAR(2);
  DECLARE v_year             CHAR(4);
  DECLARE v_safe_mode        INT;

  SET NAMES utf8 COLLATE utf8_unicode_ci;
  SET collation_connection = 'utf8_unicode_ci';
  SET SESSION group_concat_max_len = 1024*1024*64;

  /* Lee parámetros con COALESCE para evitar NULL */
  SELECT
    COALESCE(CONVERT(p.Nombre_Revista   USING utf8), ''),
    COALESCE(CONVERT(p.ISSN             USING utf8), ''),
    COALESCE(CONVERT(p.Doi              USING utf8), ''),
    COALESCE(CONVERT(p.Base_URL_Landing USING utf8), ''),
    COALESCE(CONVERT(p.Volumen          USING utf8), ''),
    COALESCE(CONVERT(p.Numero           USING utf8), ''),
    LPAD(COALESCE(p.Dia_publicacion, 1), 2, '0'),
    LPAD(COALESCE(p.Mes_publicacion, 1), 2, '0'),
    COALESCE(CONVERT(p.Año_publicacion  USING utf8), '')
  INTO
    v_nombre_revista, v_issn, v_prefijo_doi, v_base_landing,
    v_volumen, v_numero, v_day, v_month, v_year
  FROM parametros p
  LIMIT 1;

  /* Actualiza DOI/URLs en artículos publicados */
  SET v_safe_mode := @@SQL_SAFE_UPDATES;
  SET SQL_SAFE_UPDATES = 0;

  UPDATE articulo a
  SET
    a.doi         = CAST(CONCAT(CAST(v_prefijo_doi AS CHAR CHARACTER SET utf8), '.', a.Clave_Articulo) AS CHAR CHARACTER SET utf8),
    a.URL         = CAST(CONCAT('https://doi.org/', CAST(v_prefijo_doi AS CHAR CHARACTER SET utf8), '.', a.Clave_Articulo) AS CHAR CHARACTER SET utf8),
    a.Url_Landing = CAST(CONCAT(CAST(v_base_landing AS CHAR CHARACTER SET utf8), a.Clave_Articulo) AS CHAR CHARACTER SET utf8)
  WHERE a.Publicado = b'1';

  SET SQL_SAFE_UPDATES = v_safe_mode;

  /* Construye artículos con CONCAT_WS para que jamás regrese NULL */
  SET @ARTS := (
    SELECT GROUP_CONCAT(art_xml SEPARATOR '\n')
    FROM (
      SELECT CONCAT_WS('',
        '      <journal_article publication_type="full_text">', '\n',
        '        <titles><title>', fn_xml_escape(COALESCE(CAST(a.Nombre_Articulo AS CHAR CHARACTER SET utf8), '')), '</title></titles>', '\n',
        '        <contributors>', '\n',
        COALESCE((
          SELECT GROUP_CONCAT(
            CONCAT_WS('',
              '          <person_name sequence="',
              CASE WHEN au.Principal=1 THEN 'first' ELSE 'additional' END,
              '" contributor_role="author">', '\n',
              '            <given_name>', fn_xml_escape(COALESCE(CAST(TRIM(au.Nombres) AS CHAR CHARACTER SET utf8), '')), '</given_name>', '\n',
              '            <surname>', fn_xml_escape(COALESCE(CAST(TRIM(CONCAT_WS(" ", au.Apellido_Paterno, au.Apellido_Materno)) AS CHAR CHARACTER SET utf8), '')), '</surname>', '\n',
              '            <affiliation>', fn_xml_escape(COALESCE(CAST(TRIM(au.Institucion) AS CHAR CHARACTER SET utf8), '')), '</affiliation>', '\n',
              CASE
                WHEN fn_orcid_canonical(CAST(au.ORCID AS CHAR CHARACTER SET utf8)) IS NOT NULL THEN
                  CONCAT('            <ORCID>', fn_xml_escape(fn_orcid_canonical(CAST(au.ORCID AS CHAR CHARACTER SET utf8))), '</ORCID>', '\n')
                ELSE '' END,
              '          </person_name>', '\n'
            )
            ORDER BY au.Principal DESC, au.idautor ASC
            SEPARATOR ''
          )
          FROM autores au
          WHERE au.idArticulo = a.idArticulo
        ), ''),
        '        </contributors>', '\n',
        '        <jats:abstract xml:lang="es"><jats:p>',
            fn_xml_escape(COALESCE(CAST(r.Resumen_Art AS CHAR CHARACTER SET utf8), '')),
        '</jats:p></jats:abstract>', '\n',
        '        <publication_date media_type="online"><month>', COALESCE(v_month,''), '</month><day>', COALESCE(v_day,''), '</day><year>', COALESCE(v_year,''), '</year></publication_date>', '\n',
        '        <doi_data><doi>', COALESCE(CAST(v_prefijo_doi AS CHAR CHARACTER SET utf8), ''), '.', COALESCE(a.Clave_Articulo,''), '</doi>',
        '<resource>', COALESCE(CAST(v_base_landing AS CHAR CHARACTER SET utf8), ''), COALESCE(a.Clave_Articulo,''), '</resource></doi_data>', '\n',
        '      </journal_article>'
      ) AS art_xml
      FROM articulo a
      LEFT JOIN resumen r ON r.idArticulo = a.idArticulo
      WHERE a.Publicado = b'1'
      ORDER BY a.idArticulo
    ) t
  );

  /* Cabecera + cuerpo con CONCAT_WS para evitar NULL total */
  SET @XML := CONCAT_WS('',
'<?xml version="1.0" encoding="UTF-8"?>', '\n',
'<doi_batch xmlns="http://www.crossref.org/schema/4.4.2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ',
'xmlns:jats="http://www.ncbi.nlm.nih.gov/JATS1" version="4.4.2" ',
'xsi:schemaLocation="http://www.crossref.org/schema/4.4.2 http://www.crossref.org/schema/deposit/crossref4.4.2.xsd">', '\n',
'  <head>', '\n',
'    <doi_batch_id>', SUBSTRING(REPLACE(UUID(),"-",""), 1, 12), '</doi_batch_id>', '\n',
'    <timestamp>', DATE_FORMAT(UTC_TIMESTAMP(), "%Y%m%d%H%i%s"), '</timestamp>', '\n',
'    <depositor><depositor_name>lerdo:lerdo</depositor_name><email_address>revistacid@itslerdo.edu.mx</email_address></depositor>', '\n',
'    <registrant>WEB-FORM</registrant>', '\n',
'  </head>', '\n',
'  <body>', '\n',
'    <journal>', '\n',
'      <journal_metadata>', '\n',
'        <full_title>', fn_xml_escape(COALESCE(CAST(v_nombre_revista AS CHAR CHARACTER SET utf8), '')), '</full_title>', '\n',
'        <abbrev_title>CID TecLerdo</abbrev_title>', '\n',
'        <issn media_type="electronic">', fn_xml_escape(COALESCE(CAST(v_issn AS CHAR CHARACTER SET utf8), '')), '</issn>', '\n',
'      </journal_metadata>', '\n',
'      <journal_issue>', '\n',
'        <publication_date media_type="online"><month>', COALESCE(v_month,''), '</month><day>', COALESCE(v_day,''), '</day><year>', COALESCE(v_year,''), '</year></publication_date>', '\n',
'        <journal_volume><volume>', fn_xml_escape(COALESCE(CAST(v_volumen AS CHAR CHARACTER SET utf8), '')), '</volume></journal_volume>', '\n',
'        <issue>', fn_xml_escape(COALESCE(CAST(v_numero AS CHAR CHARACTER SET utf8), '')), '</issue>', '\n',
'      </journal_issue>', '\n',
COALESCE(@ARTS,''), '\n',
'    </journal>', '\n',
'  </body>', '\n',
'</doi_batch>'
  );

  /* Diagnóstico rápido: tamaño del XML (debe ser > 0) */
  SELECT OCTET_LENGTH(@XML) AS xml_bytes;

  /* Escribe el archivo (asegúrate de que NO exista previamente) */
  SET @sql := CONCAT('SELECT @XML INTO DUMPFILE ', QUOTE(p_outfile));
  PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_InsertaUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `sp_InsertaUsuario`(
in NombreUsuario varchar(50),
    in Email varchar(100),
    in TipoU char(1),
    in Contra varchar (40)
)
begin
   declare vidusuario int ;
	IF NOT EXISTS(Select idUSuario from usuario where Correo_electronico = Email) then
			Begin
				IF (TipoU ='C') then 
						insert into usuario(Nombres,Correo_Electronico,Contrasenia,Nuevo) VALUES
						(NombreUsuario,Email, 
                        TO_BASE64(AES_ENCRYPT(Contra, (SELECT token FROM token WHERE TipoUsuario='C'))), b'1');
                      --  aes_encrypt(Contra,(Select token from token where TipoUsuario='C')), b'1');
				else
					   insert into usuario(Nombres,Correo_Electronico,Contrasenia,Nuevo) values
						(NombreUsuario,Email, 
                        TO_BASE64(AES_ENCRYPT(Contra, (SELECT token FROM token WHERE TipoUsuario='T'))), b'1');
                        -- aes_encrypt(Contra,(Select token from token where TipoUsuario='T')),b'1');
						IF TipoU ='R' then 
								INSERT INTO revisor(idUsuario)
								VALUES((SELECT MAX(idUsuario)from usuario));
						END IF;
			   end if;
				INSERT INTO	usuario_tipo(Usuario,TipoUsuario)
				VALUES((SELECT MAX(idUsuario)from usuario),
				(Select id_Tipo_Usuario from tipo_usuario where caracter_tipo =TipoU));
			end;
	else	
			
			 set vidusuario= (select idUSuario from usuario where Correo_electronico = Email);
			  INSERT INTO	usuario_tipo(Usuario,TipoUsuario)
					VALUES(vidusuario,
					(Select id_Tipo_Usuario from tipo_usuario where caracter_tipo =TipoU));
			          IF TipoU ='R' then 
								INSERT INTO revisor(idUsuario)
								VALUES(vidusuario);
						END IF;
				
    end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_RegistrarRevisor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `sp_RegistrarRevisor`(
   IN p_nombre VARCHAR(50),
    IN p_apellido_paterno VARCHAR(50),
    IN p_apellido_materno VARCHAR(50),
    IN p_email VARCHAR(100),
    IN p_tipo_usuario VARCHAR(10),
    IN p_institucion VARCHAR(300),
    IN p_grado_estudios VARCHAR(50),
    IN p_lineas_investigacion TEXT
)
BEGIN
    DECLARE v_idUsuario INT DEFAULT 0;
    DECLARE v_idRevisor INT DEFAULT 0;
    DECLARE v_idTipoUsuario INT DEFAULT 0;
    DECLARE v_password VARCHAR(40);
    DECLARE v_existe_usuario INT DEFAULT 0;
    DECLARE v_existe_revisor INT DEFAULT 0;
    DECLARE v_contador INT DEFAULT 1;
    DECLARE v_idLinea INT;
    DECLARE v_lineas_count INT DEFAULT 0;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Verificar si el usuario ya existe como revisor o contacto
    SELECT COUNT(*) INTO v_existe_usuario
    FROM usuario_tipo UT
    INNER JOIN usuario U ON UT.Usuario = U.idUsuario
    INNER JOIN tipo_usuario TP ON UT.TipoUsuario = TP.Id_Tipo_Usuario
    WHERE U.Correo_Electronico = p_email
      AND (TP.Caracter_tipo = 'C' OR TP.Caracter_tipo = p_tipo_usuario);
    
    IF v_existe_usuario > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El usuario ya está registrado como revisor o contacto';
    END IF;
    
    -- Verificar si el correo ya existe en usuario
    SELECT COUNT(*) INTO v_existe_usuario
    FROM usuario
    WHERE Correo_Electronico = p_email;
    
    IF v_existe_usuario > 0 THEN
        
        SELECT COALESCE(idUsuario, 0) INTO v_idUsuario
        FROM usuario
        WHERE Correo_Electronico = p_email
        LIMIT 1;
        
        -- Actualizar usuario existente
        UPDATE usuario
        SET Nombres = p_nombre,
            Apellido_Paterno = p_apellido_paterno,
            Apellido_Materno = p_apellido_materno,
            Institucion = p_institucion
        WHERE idUsuario = v_idUsuario;
    ELSE
        -- Generar contraseña automática
        SET v_password = '2eBHJ7467hWA';
        
        -- Insertar nuevo usuario
        INSERT INTO usuario (
            Correo_Electronico,
            Contrasenia,
            Nombres,
            Apellido_Paterno,
            Apellido_Materno,
            Institucion,
            Activo,
            Nuevo,
            FechaAlta
        )
        VALUES (
            p_email,
            MD5(v_password),
            p_nombre,
            p_apellido_paterno,
            p_apellido_materno,
            p_institucion,
            1,
            1,
            NOW()
        );
        
        SET v_idUsuario = LAST_INSERT_ID();
        
        -- Obtener ID del tipo de usuario Revisor
        SELECT Id_Tipo_Usuario INTO v_idTipoUsuario
        FROM tipo_usuario
        WHERE Caracter_tipo = 'R'
        LIMIT 1;
        
        -- Asignar tipo de usuario
        INSERT INTO usuario_tipo (Usuario, TipoUsuario)
        VALUES (v_idUsuario, v_idTipoUsuario);
    END IF;
    
    -- Verificar si ya existe como revisor
    SELECT COUNT(*) INTO v_existe_revisor
    FROM revisor
    WHERE idUsuario = v_idUsuario;
    
    IF v_existe_revisor > 0 THEN
        
        SELECT COALESCE(idRevisor, 0) INTO v_idRevisor
        FROM revisor
        WHERE idUsuario = v_idUsuario
        LIMIT 1;
        
        -- Actualizar revisor existente
        UPDATE revisor
        SET Grado_Estudios = p_grado_estudios
        WHERE idUsuario = v_idUsuario;
    ELSE
        -- Insertar nuevo revisor
        INSERT INTO revisor (idUsuario, Perfil, Tipo, Cartaterminacion, Grado_Estudios)
        VALUES (v_idUsuario, '', p_tipo_usuario, 0, p_grado_estudios);
        
        SET v_idRevisor = LAST_INSERT_ID();
    END IF;
    
    -- Eliminar líneas de investigación anteriores
    DELETE FROM revisor_linea
    WHERE idRevisor = v_idRevisor;
    
    -- Procesar líneas de investigación
    IF p_lineas_investigacion IS NOT NULL AND p_lineas_investigacion != '' THEN
        
        SET v_lineas_count = (
            LENGTH(p_lineas_investigacion)
            - LENGTH(REPLACE(p_lineas_investigacion, ',', ''))
            + 1
        );
        
        WHILE v_contador <= v_lineas_count DO
            
            SET v_idLinea = SUBSTRING_INDEX(
                SUBSTRING_INDEX(p_lineas_investigacion, ',', v_contador),
                ',',
                -1
            );
            
            INSERT INTO revisor_linea (idLinea, idRevisor, Principal)
            VALUES (v_idLinea, v_idRevisor, 0);
            
            SET v_contador = v_contador + 1;
        END WHILE;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Debe seleccionar al menos una línea de investigación';
    END IF;
    
    COMMIT;
    
    SELECT v_idRevisor AS idRevisor;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `TablaCriterios` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`ubdsicsacid`@`%` PROCEDURE `TablaCriterios`(IN id_Articulo int)
BEGIN
	  DECLARE columnasRevisor VARCHAR(4000);
    SET columnasRevisor = NULL;
    SELECT
        GROUP_CONCAT(DISTINCT
            CONCAT(
               'MAX(CASE WHEN er.idRevisor = ', idRevisor,
                ' THEN cer.estatus ELSE NULL END) AS Rev', idRevisor
           )

        )

    INTO columnasRevisor FROM extenso_revisor  WHERE idArticulo = id_Articulo;

    -- Construir la consulta SQL completa y asignarla a una variable de sesión

    SET @consulta = CONCAT(' 

        SELECT

            c.idCriterio,

            c.descripcion AS Descripcion,

            ', columnasRevisor, '

        FROM

            criterios c

        LEFT JOIN criterio_extenso_revisor cer ON c.idCriterio = cer.idCriterio

        LEFT JOIN extenso_revisor er ON cer.id_extenso_revisor = er.id_extenso_revisor

        WHERE er.idArticulo = ', id_Articulo, '

        GROUP BY

            c.idCriterio, c.descripcion'

    );

   -- Ejecutar la consulta dinámica

    PREPARE proc FROM @consulta;

    EXECUTE proc;

    DEALLOCATE PREPARE proc;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-21 15:47:49
