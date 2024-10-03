-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-10-2024 a las 06:07:17
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_residencias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

DROP TABLE IF EXISTS `administrador`;
CREATE TABLE IF NOT EXISTS `administrador` (
  `ID_Administrador` int NOT NULL AUTO_INCREMENT,
  `Nombres` varchar(100) NOT NULL,
  `Apellido_Paterno` varchar(100) NOT NULL,
  `Apellido_Materno` varchar(100) NOT NULL,
  `Carrera` int DEFAULT NULL,
  `Rol` int DEFAULT NULL,
  `ID_Usuario` int DEFAULT NULL,
  PRIMARY KEY (`ID_Administrador`),
  KEY `fk_administrador_carrera` (`Carrera`),
  KEY `fk_administrador_rol` (`Rol`),
  KEY `fk_administrador_usuario` (`ID_Usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

DROP TABLE IF EXISTS `alumno`;
CREATE TABLE IF NOT EXISTS `alumno` (
  `ID_Alumno` int NOT NULL AUTO_INCREMENT,
  `Nombres` varchar(100) NOT NULL,
  `Apellido_Paterno` varchar(100) NOT NULL,
  `Apellido_Materno` varchar(100) NOT NULL,
  `Carrera` int DEFAULT NULL,
  `Proyecto` int DEFAULT NULL,
  `Asesor` int DEFAULT NULL,
  `Calendario_Revisiones` text,
  `Rol` int DEFAULT NULL,
  `ID_Usuario` int DEFAULT NULL,
  PRIMARY KEY (`ID_Alumno`),
  KEY `fk_alumno_carrera` (`Carrera`),
  KEY `fk_alumno_proyecto` (`Proyecto`),
  KEY `fk_alumno_asesor` (`Asesor`),
  KEY `fk_alumno_rol` (`Rol`),
  KEY `fk_alumno_usuario` (`ID_Usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=302 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`ID_Alumno`, `Nombres`, `Apellido_Paterno`, `Apellido_Materno`, `Carrera`, `Proyecto`, `Asesor`, `Calendario_Revisiones`, `Rol`, `ID_Usuario`) VALUES
(300, 'CRISTHIAN YAEL', 'ROMERO', 'ROBLEDO', 1, 1, 100, NULL, 1, 300),
(301, 'CARLOS', 'SOTO', 'GARCIA', 1, 1, 100, NULL, 1, 301);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asesor`
--

DROP TABLE IF EXISTS `asesor`;
CREATE TABLE IF NOT EXISTS `asesor` (
  `ID_Asesor` int NOT NULL AUTO_INCREMENT,
  `Nombres` varchar(100) NOT NULL,
  `Apellido_Paterno` varchar(100) NOT NULL,
  `Apellido_Materno` varchar(100) NOT NULL,
  `Proyecto_Asignado` int DEFAULT NULL,
  `Carrera` int DEFAULT NULL,
  `Rol` int DEFAULT NULL,
  `ID_Usuario` int DEFAULT NULL,
  PRIMARY KEY (`ID_Asesor`),
  KEY `fk_asesor_proyecto_asignado` (`Proyecto_Asignado`),
  KEY `fk_asesor_carrera` (`Carrera`),
  KEY `fk_asesor_rol` (`Rol`),
  KEY `fk_asesor_usuario` (`ID_Usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `asesor`
--

INSERT INTO `asesor` (`ID_Asesor`, `Nombres`, `Apellido_Paterno`, `Apellido_Materno`, `Proyecto_Asignado`, `Carrera`, `Rol`, `ID_Usuario`) VALUES
(100, 'FABIOLA', 'FUENTES', 'HERRERA', 1, 2, 2, 100),
(101, 'JOSE LUIS', 'CAMACHO', 'CAMPERO', 2, 1, 2, 101);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

DROP TABLE IF EXISTS `carrera`;
CREATE TABLE IF NOT EXISTS `carrera` (
  `ID_Carrera` int NOT NULL AUTO_INCREMENT,
  `Nombre_Carrera` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_Carrera`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`ID_Carrera`, `Nombre_Carrera`) VALUES
(1, 'INGENIERÍA EN SISTEMAS COMPUTACIONALES'),
(2, 'INGENIERÍA INDUSTRIAL'),
(3, 'INGENIERÍA ELECTROMECÁNICA'),
(4, 'INGENIERÍA MECATRÓNICA'),
(5, 'INGENIERÍA AMBIENTAL'),
(6, 'INGENIERÍA EN MATERIALES'),
(7, 'INGENIERÍA EN GESTIÓN EMPRESARIAL'),
(8, 'INGENIERÍA EN TECNOLOGÍAS DE LA INFORMACIÓN Y COMUNICACIONES'),
(9, 'INGENIERÍA QUÍMICA'),
(10, 'INGENIERÍA CIVIL'),
(11, 'LICENCIATURA EN ADMINISTRACIÓN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conproyectorevisiones`
--

DROP TABLE IF EXISTS `conproyectorevisiones`;
CREATE TABLE IF NOT EXISTS `conproyectorevisiones` (
  `ID_Proyecto` int NOT NULL,
  `ID_Conexion` int NOT NULL,
  KEY `fk_conProyectoRevisiones_proyecto` (`ID_Proyecto`),
  KEY `fk_conProyectoRevisiones_revisiones` (`ID_Conexion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
CREATE TABLE IF NOT EXISTS `proyecto` (
  `ID_Proyecto` int NOT NULL AUTO_INCREMENT,
  `Nombre_Proyecto` varchar(200) NOT NULL,
  `Status` enum('Pendiente','En Revisión','Revisado','Completado') NOT NULL,
  `Integrante_1` int DEFAULT NULL,
  `Integrante_2` int DEFAULT NULL,
  `Integrante_3` int DEFAULT NULL,
  `Asesor` int DEFAULT NULL,
  `Archivo_Docx` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_Proyecto`),
  KEY `fk_proyecto_integrante_1` (`Integrante_1`),
  KEY `fk_proyecto_integrante_2` (`Integrante_2`),
  KEY `fk_proyecto_integrante_3` (`Integrante_3`),
  KEY `fk_proyecto_asesor` (`Asesor`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`ID_Proyecto`, `Nombre_Proyecto`, `Status`, `Integrante_1`, `Integrante_2`, `Integrante_3`, `Asesor`, `Archivo_Docx`) VALUES
(1, 'PROYECTO EJEMPLO PRUEBA', 'Pendiente', 300, 301, NULL, 100, NULL),
(2, 'PROYECTO EJEMPLO 2', 'Pendiente', NULL, NULL, NULL, NULL, NULL),
(3, 'PROYECTO EJEMPLO 3', 'Pendiente', NULL, NULL, NULL, 101, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revisiones`
--

DROP TABLE IF EXISTS `revisiones`;
CREATE TABLE IF NOT EXISTS `revisiones` (
  `ID_Conexion` int NOT NULL,
  `ID_Revision` int NOT NULL AUTO_INCREMENT,
  `Comentario` text,
  `Fecha_Revision` date NOT NULL,
  `Fecha_Proxima_Revision` date NOT NULL,
  `Revision_Numero` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID_Revision`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `ID_Rol` int NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_Rol`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`ID_Rol`, `Descripcion`) VALUES
(1, 'ALUMNO'),
(2, 'ASESOR'),
(3, 'ADMINISTRADOR'),
(4, 'INACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `ID_Usuario` int NOT NULL AUTO_INCREMENT,
  `Nombre_Usuario` varchar(50) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Rol` int DEFAULT NULL,
  PRIMARY KEY (`ID_Usuario`),
  KEY `fk_usuario_rol` (`Rol`)
) ENGINE=MyISAM AUTO_INCREMENT=302 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nombre_Usuario`, `Contraseña`, `Rol`) VALUES
(1, 'ADMIN', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 3),
(100, 'FABIOLA', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2),
(101, 'CAMACHO', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2),
(300, 'YAEL', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1),
(301, 'CARLOS', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1);

--
-- Disparadores `usuario`
--
DROP TRIGGER IF EXISTS `before_usuario_insert`;
DELIMITER $$
CREATE TRIGGER `before_usuario_insert` BEFORE INSERT ON `usuario` FOR EACH ROW BEGIN
    SET NEW.Contraseña = SHA2(NEW.Contraseña, 256);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_usuario_update`;
DELIMITER $$
CREATE TRIGGER `before_usuario_update` BEFORE UPDATE ON `usuario` FOR EACH ROW BEGIN
    -- Solo encripta si la contraseña ha sido cambiada
    IF NEW.Contraseña != OLD.Contraseña THEN
        SET NEW.Contraseña = SHA2(NEW.Contraseña, 256);
    END IF;
END
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
