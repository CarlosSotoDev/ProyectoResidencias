-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-11-2024 a las 02:01:39
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
) ENGINE=MyISAM AUTO_INCREMENT=310 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(308, 'MAXIMILIANO', 'MENDEZ', 'ROMERO', 2, 6, 105, NULL, 1, 308),
(309, 'FABIAN', 'ROMARIO', 'SAJNCEZ', 3, 7, 106, NULL, 1, 309);

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
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `asesor`
--

INSERT INTO `asesor` (`ID_Asesor`, `Nombres`, `Apellido_Paterno`, `Apellido_Materno`, `Proyecto_Asignado`, `Carrera`, `Rol`, `ID_Usuario`) VALUES
(100, 'FABIOLITA', 'FUENTES', 'HERRERA', 1, 1, 2, 100),
(101, 'JOSE LUIS', 'CAMACHO', 'CAMPERO', 2, 1, 2, 101),
(102, 'ASESOR', 'TAVAREZ', 'JUAREZ', 4, 1, 2, 102),
(103, 'LUIS ENRIQUE', 'VIVANCO', 'BENAVIDES', 3, 1, 2, 103),
(104, 'LUIS ALBERTO', 'OVANDO', 'BRITO', 5, 1, 2, 104),
(105, 'ARTURO', 'FALCON', 'CAMPOY', 6, 2, 2, 105),
(106, 'EMILIO', 'REYES', 'FERNANDEZ', 7, 3, 2, 106);

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
-- Estructura de tabla para la tabla `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE IF NOT EXISTS `notificaciones` (
  `ID_Notificacion` int NOT NULL AUTO_INCREMENT,
  `ID_Usuario` int NOT NULL,
  `Mensaje` text NOT NULL,
  `Fecha_Notificacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Leida` tinyint(1) NOT NULL DEFAULT '0',
  `ID_Proyecto` int DEFAULT NULL,
  PRIMARY KEY (`ID_Notificacion`),
  KEY `fk_notificacion_usuario` (`ID_Usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`ID_Notificacion`, `ID_Usuario`, `Mensaje`, `Fecha_Notificacion`, `Leida`, `ID_Proyecto`) VALUES
(1, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-10-31', '2024-10-30 15:42:23', 1, NULL),
(2, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-10-31', '2024-10-30 15:42:23', 1, NULL),
(3, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-10-31', '2024-10-30 15:49:37', 1, NULL),
(4, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-10-31', '2024-10-30 15:49:37', 1, NULL),
(5, 303, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-10-31', '2024-10-30 15:50:59', 1, NULL),
(6, 304, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-10-31', '2024-10-30 15:50:59', 0, NULL),
(7, 306, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-10-31', '2024-10-30 15:50:59', 0, NULL),
(8, 303, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-01', '2024-10-30 17:30:11', 1, NULL),
(9, 304, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-01', '2024-10-30 17:30:11', 0, NULL),
(10, 306, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-01', '2024-10-30 17:30:11', 0, NULL),
(11, 303, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-02', '2024-10-30 17:55:43', 1, NULL),
(12, 304, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-02', '2024-10-30 17:55:43', 0, NULL),
(13, 306, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-02', '2024-10-30 17:55:43', 0, NULL),
(14, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-01', '2024-10-31 19:52:48', 1, NULL),
(15, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-01', '2024-10-31 19:52:48', 1, NULL),
(16, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-02', '2024-10-31 19:53:48', 1, NULL),
(17, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-02', '2024-10-31 19:53:48', 1, NULL),
(18, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-28', '2024-11-03 12:05:06', 1, NULL),
(19, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-28', '2024-11-03 12:05:06', 0, NULL),
(20, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-22', '2024-11-03 12:12:22', 1, NULL),
(21, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-22', '2024-11-03 12:12:22', 0, NULL),
(22, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-21', '2024-11-03 12:15:07', 1, NULL),
(23, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-21', '2024-11-03 12:15:07', 0, NULL),
(24, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-12-07', '2024-11-03 12:19:29', 1, NULL),
(25, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-12-07', '2024-11-03 12:19:29', 0, NULL),
(26, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-23', '2024-11-03 12:22:31', 1, NULL),
(27, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-23', '2024-11-03 12:22:31', 0, NULL),
(28, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-23', '2024-11-03 12:24:46', 1, NULL),
(29, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-23', '2024-11-03 12:24:46', 0, NULL),
(30, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-12-06', '2024-11-03 12:25:06', 1, NULL),
(31, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-12-06', '2024-11-03 12:25:06', 0, NULL),
(32, 100, 'Un nuevo documento ha sido subido para el proyecto.', '2024-11-03 15:42:21', 1, 1),
(33, 100, 'Un nuevo documento ha sido subido para el proyecto.', '2024-11-03 15:48:16', 1, 1),
(34, 100, 'Un nuevo documento ha sido subido para el proyecto.', '2024-11-03 15:49:40', 1, 1),
(35, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-23', '2024-11-03 15:49:52', 1, NULL),
(36, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-23', '2024-11-03 15:49:52', 0, NULL),
(37, 100, 'Un nuevo documento ha sido subido para el proyecto.', '2024-11-07 19:28:05', 1, 1),
(38, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-15', '2024-11-07 19:28:28', 1, NULL),
(39, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-15', '2024-11-07 19:28:28', 0, NULL),
(40, 100, 'Un nuevo documento ha sido subido para el proyecto.', '2024-11-07 19:31:40', 0, 1),
(41, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-23', '2024-11-07 19:32:40', 1, NULL),
(42, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-23', '2024-11-07 19:32:40', 0, NULL),
(43, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-14', '2024-11-07 19:45:29', 1, NULL),
(44, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-14', '2024-11-07 19:45:29', 0, NULL),
(45, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-22', '2024-11-07 19:45:47', 1, NULL),
(46, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-22', '2024-11-07 19:45:47', 0, NULL),
(47, 300, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-22', '2024-11-07 19:45:52', 0, NULL),
(48, 301, 'Se ha agregado un nuevo comentario a tu proyecto. Fecha de próxima revisión: 2024-11-22', '2024-11-07 19:45:52', 0, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`ID_Proyecto`, `Nombre_Proyecto`, `Status`, `Integrante_1`, `Integrante_2`, `Integrante_3`, `Asesor`, `Archivo_Docx`) VALUES
(1, 'PROYECTO EJEMPLO PRUEBA 2', 'En Revisión', 300, 301, NULL, 100, 'TABLAS_SOTE_(1).docx'),
(2, 'PROYECTO EJEMPLO 2', 'En Revisión', 303, 304, 306, 101, 'TIBURON_(3).docx'),
(3, 'PROYECTO EJEMPLO 3', 'Pendiente', 305, NULL, NULL, 103, NULL),
(4, 'Proyecto ejemplo 3', 'Pendiente', 302, NULL, NULL, 102, NULL),
(5, 'PRPYECTO ENABLING', 'En Revisión', 307, NULL, NULL, 104, 'GF_(1)_1728533429.docx'),
(6, 'PRUEBA PARA JEFE', 'Pendiente', 308, NULL, NULL, 105, NULL),
(7, 'PROYECTO ELECTROMECANICA', 'Pendiente', 309, NULL, NULL, 106, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `revisiones`
--

INSERT INTO `revisiones` (`ID_Conexion`, `ID_Revision`, `Comentario`, `Fecha_Revision`, `Fecha_Proxima_Revision`, `Revision_Numero`) VALUES
(1, 1, 'BUEN TRABAJO', '2024-10-03', '2024-10-18', 1),
(2, 2, 'GLEKGLEJLGJRLKGJLTR', '2024-10-04', '2024-10-25', 1),
(5, 3, 'BUEN TRABAJO PERO CORRIJE REDACCION', '2024-10-10', '2024-10-16', 1),
(1, 4, 'NUEVA REVISION', '2024-10-30', '2024-10-31', 1),
(1, 5, 'ASA', '2024-10-30', '2024-10-31', 1),
(2, 6, 'SADSADAS', '2024-10-30', '2024-10-31', 1),
(2, 7, 'dwqq', '2024-10-30', '2024-11-01', 1),
(2, 8, 'qaqsA', '2024-10-30', '2024-11-02', 1),
(1, 9, 'ASASDA', '2024-11-01', '2024-11-01', 1),
(1, 10, 'ASDASD', '2024-11-01', '2024-11-02', 1),
(1, 11, 'WQEQW', '2024-11-03', '2024-11-28', 1),
(1, 12, 'WAQ', '2024-11-03', '2024-11-22', 1),
(1, 13, 'AWEWAEWA', '2024-11-03', '2024-11-21', 1),
(1, 14, 'WQEQ', '2024-11-03', '2024-12-07', 1),
(1, 15, 'WAA', '2024-11-03', '2024-11-23', 1),
(1, 16, 'WQEQ', '2024-11-03', '2024-11-23', 1),
(1, 17, 'WQE', '2024-11-03', '2024-12-06', 1),
(1, 18, 'werw', '2024-11-03', '2024-11-23', 1),
(1, 19, 'BUEN TRABAJO', '2024-11-08', '2024-11-15', 1),
(1, 20, 'SADAS', '2024-11-08', '2024-11-23', 1),
(1, 21, 'WEQEQ', '2024-11-08', '2024-11-14', 1),
(1, 22, 'EWEWERW', '2024-11-08', '2024-11-22', 1),
(1, 23, 'WQEWQ', '2024-11-08', '2024-11-22', 1);

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
(3001, 'PROMARIOS', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 5),
(106, 'EREYESF', 'd4405ec23fb5a6963b47ef8b07a93a0e9343d1901862f33bda5824ebd913e2e8', 2),
(309, 'FROMARIOS', 'ecbaf58490a3246e2353e802789df76cde9c21d7d08631de4c04b56cc74fcc36', 1);

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
