-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 30-10-2024 a las 21:14:43
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
) ENGINE=MyISAM AUTO_INCREMENT=3002 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`ID_Administrador`, `Nombres`, `Apellido_Paterno`, `Apellido_Materno`, `Carrera`, `Rol`, `ID_Usuario`) VALUES
(1000, 'RIGOBERTO', 'SALINAS', 'PLIEGO', 1, 5, 1000),
(3000, 'ARATH2', 'TAVAREZ', 'MARTINEZ', 2, 5, 3000),
(3001, 'PEDRO', 'ROMARIO', 'SAJNCEZ', 3, 5, 3001);

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
) ENGINE=MyISAM AUTO_INCREMENT=309 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`ID_Alumno`, `Nombres`, `Apellido_Paterno`, `Apellido_Materno`, `Carrera`, `Proyecto`, `Asesor`, `Calendario_Revisiones`, `Rol`, `ID_Usuario`) VALUES
(300, 'CRISTHIAN YAEL', 'ROMERO', 'ROBLEDO', 1, 1, 100, NULL, 1, 300),
(301, 'CARLOS', 'SOTO', 'GARCIA', 1, 1, 100, NULL, 1, 301),
(302, 'ALUMNO', 'LIRA', 'ROBLEDO', 1, 4, 102, NULL, 1, 302),
(303, 'ALUMNO2', 'ROMERO', 'GARCIA', 1, 2, 101, NULL, 1, 303),
(304, 'CRISTHIAN YAEL', 'CAMACHO', 'CAMPOY', 1, 2, 101, NULL, 1, 304),
(305, 'ALEXIS', 'VASQUEZ', 'SANTIAGO', 1, 3, 103, NULL, 1, 305),
(306, 'JOSE MANUEL', 'LUVIANO', 'RAMIREZ', 1, 2, 101, NULL, 1, 306),
(307, 'DIEGO', 'FARFAN', 'MARTINEZ', 1, 5, 104, NULL, 1, 307),
(308, 'MAXIMILIANO', 'MENDEZ', 'ROMERO', 2, 6, 105, NULL, 1, 308);

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
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `asesor`
--

INSERT INTO `asesor` (`ID_Asesor`, `Nombres`, `Apellido_Paterno`, `Apellido_Materno`, `Proyecto_Asignado`, `Carrera`, `Rol`, `ID_Usuario`) VALUES
(100, 'FABIOLITA', 'FUENTES', 'HERRERA', 1, 1, 2, 100),
(101, 'JOSE LUIS', 'CAMACHO', 'CAMPERO', 2, 1, 2, 101),
(102, 'ASESOR', 'TAVAREZ', 'JUAREZ', 4, 1, 2, 102),
(103, 'LUIS ENRIQUE', 'VIVANCO', 'BENAVIDES', 3, 1, 2, 103),
(104, 'LUIS ALBERTO', 'OVANDO', 'BRITO', 5, 1, 2, 104),
(105, 'ARTURO', 'FALCON', 'CAMPOY', 6, 2, 2, 105);

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

--
-- Volcado de datos para la tabla `conproyectorevisiones`
--

INSERT INTO `conproyectorevisiones` (`ID_Proyecto`, `ID_Conexion`) VALUES
(1, 1),
(2, 2),
(5, 5);

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`ID_Proyecto`, `Nombre_Proyecto`, `Status`, `Integrante_1`, `Integrante_2`, `Integrante_3`, `Asesor`, `Archivo_Docx`) VALUES
(1, 'PROYECTO EJEMPLO PRUEBA 2', 'En Revisión', 300, 301, NULL, 100, 'GF_(1).docx'),
(2, 'PROYECTO EJEMPLO 2', 'En Revisión', 303, 304, 306, 101, 'TIBURON_(3).docx'),
(3, 'PROYECTO EJEMPLO 3', 'Pendiente', 305, NULL, NULL, 103, NULL),
(4, 'Proyecto ejemplo 3', 'Pendiente', 302, NULL, NULL, 102, NULL),
(5, 'PRPYECTO ENABLING', 'En Revisión', 307, NULL, NULL, 104, 'GF_(1)_1728533429.docx'),
(6, 'PRUEBA PARA JEFE', 'Pendiente', 308, NULL, NULL, 105, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `revisiones`
--

INSERT INTO `revisiones` (`ID_Conexion`, `ID_Revision`, `Comentario`, `Fecha_Revision`, `Fecha_Proxima_Revision`, `Revision_Numero`) VALUES
(1, 1, 'BUEN TRABAJO', '2024-10-03', '2024-10-18', 1),
(2, 2, 'GLEKGLEJLGJRLKGJLTR', '2024-10-04', '2024-10-25', 1),
(5, 3, 'BUEN TRABAJO PERO CORRIJE REDACCION', '2024-10-10', '2024-10-16', 1);

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
(4, 'INACTIVO'),
(5, 'JEFE_DE_CARRERA');

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
) ENGINE=MyISAM AUTO_INCREMENT=3002 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nombre_Usuario`, `Contraseña`, `Rol`) VALUES
(1, 'ADMIN', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 3),
(100, 'FABIOLA', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2),
(101, 'CAMACHO2', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2),
(300, 'YAEL', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1),
(301, 'CARLOS', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1),
(102, 'ASESOR', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2),
(302, 'ALUMNO', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1),
(303, 'ALUMNO2', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1),
(304, 'CCAMACHOC', 'a5ab3dff0ce6863eb3349b5af4ddaa4d0301ba35504f0d991f6b9d9f3d743fde', 1),
(103, 'LVIVANCOB', 'ec330fbdbec0635dd38fea4d037e995c8eab16e4def4f3c109ad0c3f8172d701', 2),
(305, 'AVASQUEZS', 'd752d2d3aef7729fe1b54483f9c8f81cb8fc1bc500b8e1706626ce3e228408bb', 1),
(306, 'JLUVIANOR', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1),
(104, 'LOVANDOB', '989e8a788da5ac8d716c9cafba276ae882a5801b40e2d1cbcba4c5221cd4b2c1', 2),
(307, 'DFARFANM', 'c913cdfc72f72a2533dcdfdf6b615e603dc11dccb527891f176d732d0e6d991c', 1),
(3000, 'ARATH', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 5),
(105, 'AFALCONC', 'ff774570d7fdab8b0c15ef79b015a579e6a82acf230f2f7d95659c0a46782f23', 2),
(308, 'MMENDEZR', 'd1a52aa40d5e38073b33176c3180b285ee2e6492483ffb72cff9898380f81a9a', 1),
(3001, 'PROMARIOS', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 5);

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
