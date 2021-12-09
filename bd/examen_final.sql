-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 07-12-2021 a las 13:18:14
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `examen_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesos`
--

DROP TABLE IF EXISTS `accesos`;
CREATE TABLE IF NOT EXISTS `accesos` (
  `acce_id` int(11) NOT NULL AUTO_INCREMENT,
  `acce_usuario` varchar(20) DEFAULT NULL,
  `acce_clave` varchar(255) DEFAULT NULL,
  `estu_id` int(11) NOT NULL,
  PRIMARY KEY (`acce_id`),
  UNIQUE KEY `uc_acce_usuario` (`acce_usuario`),
  KEY `fk_estu_id` (`estu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `accesos`
--

INSERT INTO `accesos` (`acce_id`, `acce_usuario`, `acce_clave`, `estu_id`) VALUES
(1, 'jesus', '1015', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

DROP TABLE IF EXISTS `asignaturas`;
CREATE TABLE IF NOT EXISTS `asignaturas` (
  `asig_id` int(11) NOT NULL AUTO_INCREMENT,
  `asig_nombre` varchar(45) NOT NULL,
  `asig_descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`asig_id`),
  UNIQUE KEY `uc_asig_nombre` (`asig_nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

DROP TABLE IF EXISTS `estudiantes`;
CREATE TABLE IF NOT EXISTS `estudiantes` (
  `estu_id` int(11) NOT NULL AUTO_INCREMENT,
  `estu_nombres` varchar(45) NOT NULL,
  `estu_apellidos` varchar(45) NOT NULL,
  `estu_documento` varchar(15) NOT NULL,
  PRIMARY KEY (`estu_id`),
  UNIQUE KEY `uc_estu_documento` (`estu_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`estu_id`, `estu_nombres`, `estu_apellidos`, `estu_documento`) VALUES
(1, 'JES&UACUTE;S DAVID', 'ROSO FL&OACUTE;REZ', '1015484086'),
(2, 'STEPHANIE SOFIA', 'ROSO FL&OACUTE;REZ', '1078828875');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes_asignaruras`
--

DROP TABLE IF EXISTS `estudiantes_asignaruras`;
CREATE TABLE IF NOT EXISTS `estudiantes_asignaruras` (
  `esasig_id` int(11) NOT NULL AUTO_INCREMENT,
  `estu_id` int(11) NOT NULL,
  `asig_id` int(11) NOT NULL,
  `tino_id` int(11) NOT NULL,
  `valor_nota` int(11) NOT NULL,
  PRIMARY KEY (`esasig_id`),
  KEY `fk_estu_id` (`estu_id`),
  KEY `fk_asig_id` (`asig_id`),
  KEY `fk_tino_id` (`tino_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_notas`
--

DROP TABLE IF EXISTS `tipo_notas`;
CREATE TABLE IF NOT EXISTS `tipo_notas` (
  `tino_id` int(11) NOT NULL AUTO_INCREMENT,
  `tino_nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tino_id`),
  UNIQUE KEY `uc_tino` (`tino_nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD CONSTRAINT `fk_accesos_estudiantes1` FOREIGN KEY (`estu_id`) REFERENCES `estudiantes` (`estu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `estudiantes_asignaruras`
--
ALTER TABLE `estudiantes_asignaruras`
  ADD CONSTRAINT `fk_estudiantes_asignarura_asignaturas1` FOREIGN KEY (`asig_id`) REFERENCES `asignaturas` (`asig_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estudiantes_asignarura_estudiantes` FOREIGN KEY (`estu_id`) REFERENCES `estudiantes` (`estu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estudiantes_asignarura_tipo_notas1` FOREIGN KEY (`tino_id`) REFERENCES `tipo_notas` (`tino_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
