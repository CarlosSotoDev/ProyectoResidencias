-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-09-2024 a las 02:53:37
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

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`ID_Administrador`, `Nombres`, `Apellido_Paterno`, `Apellido_Materno`, `Carrera`, `Rol`, `ID_Usuario`) VALUES
(1, 'admin', 'admin', 'admin', 1, 3, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`ID_Alumno`, `Nombres`, `Apellido_Paterno`, `Apellido_Materno`, `Carrera`, `Proyecto`, `Asesor`, `Calendario_Revisiones`, `Rol`, `ID_Usuario`) VALUES
(25, 'CRISTHIAN YAEL', 'ROMERO', 'ROBLEDO', 2, 19, 16, NULL, NULL, 25),
(26, 'AXEL', 'LIRA', 'JUAREZ', 10, 20, 17, NULL, NULL, 26),
(27, 'SAD', 'WADAW', 'DASDAS', 1, 19, 17, NULL, NULL, 27),
(29, 'AWE', 'AWWAD', 'ASDA', 1, 19, 17, NULL, NULL, 29);

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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `asesor`
--

INSERT INTO `asesor` (`ID_Asesor`, `Nombres`, `Apellido_Paterno`, `Apellido_Materno`, `Proyecto_Asignado`, `Carrera`, `Rol`, `ID_Usuario`) VALUES
(17, 'MARISOL', 'PRADO', 'FARFAN', 20, 1, NULL, NULL),
(18, 'WQEW', 'EQWEQW', 'QWEQW', 21, 1, NULL, NULL),
(19, 'SADSA', 'ASDAS', 'ASDAS', 22, 3, NULL, NULL),
(20, 'SDS', 'DASDA', 'DASDAS', 23, 1, NULL, NULL),
(16, 'LUIS', 'CAMACHO', 'CAMPERO', 19, 1, NULL, NULL);

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
(1, 'Ingeniería en Sistemas Computacionales'),
(2, 'Ingeniería Industrial'),
(3, 'Ingeniería Electromecánica'),
(4, 'Ingeniería Mecatrónica'),
(5, 'Ingeniería Ambiental'),
(6, 'Ingeniería en Materiales'),
(7, 'Ingeniería en Gestión Empresarial'),
(8, 'Ingeniería en Tecnologías de la Información y Comunicaciones'),
(9, 'Ingeniería Química'),
(10, 'Ingeniería Civil'),
(11, 'Licenciatura en Administración');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
CREATE TABLE IF NOT EXISTS `proyecto` (
  `ID_Proyecto` int NOT NULL AUTO_INCREMENT,
  `Nombre_Proyecto` varchar(200) NOT NULL,
  `Status` enum('Pendiente','En Revisión') NOT NULL,
  `Integrante_1` int DEFAULT NULL,
  `Integrante_2` int DEFAULT NULL,
  `Integrante_3` int DEFAULT NULL,
  `Asesor` int DEFAULT NULL,
  PRIMARY KEY (`ID_Proyecto`),
  KEY `fk_proyecto_integrante_1` (`Integrante_1`),
  KEY `fk_proyecto_integrante_2` (`Integrante_2`),
  KEY `fk_proyecto_integrante_3` (`Integrante_3`),
  KEY `fk_proyecto_asesor` (`Asesor`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`ID_Proyecto`, `Nombre_Proyecto`, `Status`, `Integrante_1`, `Integrante_2`, `Integrante_3`, `Asesor`) VALUES
(19, 'PROYECTO 1', 'Pendiente', 25, 27, 29, NULL),
(20, 'Proyecto ejemplo 2', 'Pendiente', 26, NULL, NULL, NULL),
(21, 'Proyecto ejemplo 35', 'Pendiente', NULL, NULL, NULL, NULL),
(22, 'Proyecto ejemplo 3', 'Pendiente', NULL, NULL, NULL, NULL),
(23, 'ASDASDAS', 'Pendiente', NULL, NULL, NULL, NULL);

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
(1, 'Alumno'),
(2, 'Asesor'),
(3, 'Administrador'),
(4, 'Inactivo');

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
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nombre_Usuario`, `Contraseña`, `Rol`) VALUES
(1, 'admin', 'cd27a308900e4f0e5c24083373ed96e3880a26be144d8eb712c49ca88dd1eac9', 3),
(19, 'ASESOR2', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2),
(18, 'ASESOR', '43a0594202b8c1e8a101a5c38b5d788b94ef19586b4ce9fd7cf347a0eb50cb99', 2),
(4, 'admin2', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 3),
(29, 'PRUEBA1', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1),
(28, 'EMILIO2', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1),
(27, 'EMILIO', '173af653133d964edfc16cafe0aba33c8f500a07f3ba3f81943916910c257705', 1),
(26, 'AXE', '173af653133d964edfc16cafe0aba33c8f500a07f3ba3f81943916910c257705', 1),
(24, 'AL', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1),
(16, 'CAMACHO', '6f2e05c67ecf25b547ef3d0d3e4b2b3ae40e6d7323bbac0cc254e0ca78d25ed1', 2),
(25, 'YAEL', '173af653133d964edfc16cafe0aba33c8f500a07f3ba3f81943916910c257705', 1),
(17, 'MARISOL', '1554727ead6bf1022401004e38d75c491c0af9bf19c1ac5bec6028a823ed7bf1', 2),
(20, 'ALUMNO1', '173af653133d964edfc16cafe0aba33c8f500a07f3ba3f81943916910c257705', 1),
(21, 'HOLA', '173af653133d964edfc16cafe0aba33c8f500a07f3ba3f81943916910c257705', 1),
(15, 'PRUEBA', '6b51d431df5d7f141cbececcf79edf3dd861c3b4069f0b11661a3eefacbba918', 2);

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
