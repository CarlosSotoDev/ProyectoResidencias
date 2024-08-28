-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-08-2024 a las 03:10:56
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
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `ID_Usuario` int NOT NULL AUTO_INCREMENT,
  `Nombre_Usuario` varchar(50) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Rol` int DEFAULT NULL,
  PRIMARY KEY (`ID_Usuario`),
  KEY `Rol` (`Rol`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nombre_Usuario`, `Contraseña`, `Rol`) VALUES
(1, 'admin', '$2y$10$plGkmjbLUtTplB2oifvFD.9Ods3NXXfRd7RicGqzdHncM/IRC/giS', 3),
(2, 'SOTO', '$2y$10$xm6KM9NgjW2p01bfrPM9fuYfVqlsKYlw2I2UOFcgj7.14gNgTNR0e', 1),
(3, 'yael', '$2y$10$5n48aKx0sm36Bt/2Ku2fquVGeETjPrrWIoSEgGItUVXc4lVA/tnf6', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
