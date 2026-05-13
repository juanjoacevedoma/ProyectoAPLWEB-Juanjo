-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2026 a las 21:26:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `catalogo_hardware`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componentes`
--

CREATE TABLE `componentes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `marca_id` int(11) NOT NULL,
  `categoria` varchar(100) DEFAULT 'Sin categoría',
  `imagen_url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `componentes`
--

INSERT INTO `componentes` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `marca_id`, `categoria`, `imagen_url`) VALUES
(8, 'Intel Core i9', '', 500.00, 10, 1, 'CP', 'https://upload.wikimedia.org/wikipedia/commons/c/c5/Intel_Core_i9_2020_logo.svg'),
(9, 'Tarjeta Gráfica RTX 4070 SUPER', '', 127.00, 12, 5, 'GPU', 'https://www.coolmod.com/images/product/large/PROD-032473_1.jpg'),
(10, 'Ratón G Pro X Superlight', '', 126.99, 12, 4, 'Hardware', 'https://www.neobyte.es/72751-large_default/logitech-pro-x-superlight-raton-gaming-inalambrico.jpg'),
(11, 'Tarjeta Gráfica RTX 4060 Ti', '', 400.00, 10, 3, 'GPU', 'https://media.ldlc.com/r1600/ld/products/00/06/05/19/LD0006051943.jpg'),
(12, 'Placa Base ROG Strix B550-F', '', 300.00, 10, 1, 'Hardware', 'https://media.ldlc.com/r1600/ld/products/00/05/91/26/LD0005912642_1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimientos`
--

CREATE TABLE `mantenimientos` (
  `id` int(11) NOT NULL,
  `componente_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `descripcion` text NOT NULL,
  `tecnico` varchar(100) DEFAULT 'Admin Juanjo',
  `estado` enum('Pendiente','Completado','Fallo') DEFAULT 'Completado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimientos`
--

INSERT INTO `mantenimientos` (`id`, `componente_id`, `fecha`, `descripcion`, `tecnico`, `estado`) VALUES
(4, 8, '2026-05-13 20:59:56', 'Solucionado prueba', 'JUANJO', 'Completado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `pais` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `pais`) VALUES
(1, 'Asus', 'Taiwán'),
(2, 'Corsair', 'Estados Unidos'),
(3, 'MSI', 'Taiwán'),
(4, 'Logitech', 'Suiza'),
(5, 'Nvidia', 'Estados Unidos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `rol` enum('admin','editor') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `rol`) VALUES
(1, 'admin', '$2y$10$mPgd7c4gra715CXKkB2fGu32DNQwOGPC5M5BLrERIfCbO8OcoSpQ6', 'Administrador Juanjo', 'admin'),
(2, 'pepe', '$2y$10$yYadSLctWLcCtlqtpU.s7e3lmb8xQDsc7ctkx5KKuibGIfXyolYu2', 'Pepe Lluyot', 'admin'),
(3, 'prueba', '$2y$10$NK0ho.1qDMn82uLFnO80gO8ykbnhBEUuHaRGyNMwh9kXXe8mZX8U2', 'Editor', 'editor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marca_id` (`marca_id`);

--
-- Indices de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `componentes`
--
ALTER TABLE `componentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD CONSTRAINT `componentes_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD CONSTRAINT `mantenimientos_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
