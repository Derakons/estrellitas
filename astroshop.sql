-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2024 a las 17:28:56
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
-- Base de datos: `astroshop`
--
CREATE DATABASE IF NOT EXISTS `astroshop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `astroshop`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `imagen`) VALUES
(1, 'Ropa', 'https://i.ebayimg.com/thumbs/images/g/ZnAAAOSwRT9iNK12/s-l640.jpg'),
(2, 'Adornos', 'https://pinturassanguino.com/blog/wp-content/uploads/2018/04/jgirado.jpg'),
(3, 'Libros', 'https://elclosetdemihermana.com/cdn/shop/files/home51_56f0d42a-fd8a-4c84-9b47-9d2e725a4c41.jpg'),
(4, 'Cristales', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTM7jed-PlIL_EaRvAYdX1h-WnTa5rwNGUahQ&s'),
(5, 'Inciensos', 'https://arteshop.es/wp-content/uploads/2020/05/IMG-20200701-WA0030.jpg'),
(6, 'Cartas del Tarot', 'https://www.cronista.com/files/image/528/528451/645290a237727_700_462!.jpg?s=3d963ce646ce85be8a505445a8fbd190&d=1683132582'),
(7, 'Runas', 'https://uploads.vibra.co/1/2022/11/cual-es-mi-runa-segun-mi-fecha-de-nacimiento-1.jpg'),
(8, 'Aceites Esenciales', 'https://apiumplanet.com/wp-content/uploads/2023/11/aries-aceites-esenciales.jpg'),
(9, 'Joyería', 'https://www.flavejoyas.com/cdn/shop/products/1624488248918_1000x1000.jpg?v=1624548928'),
(10, 'Decoración', 'https://i.etsystatic.com/26127518/r/il/ec5b15/4290747327/il_570xN.4290747327_c11c.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE `comentarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comentario` text NOT NULL,
  `fecha_comentario` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `nombre`, `email`, `comentario`, `fecha_comentario`) VALUES
(1, 'dante', 'dante@gmail.com', 'que bonito', '2024-06-25 23:30:13'),
(2, 'dante', 'dante@gmail.com', 'que bonito', '2024-06-25 23:30:22'),
(3, 'sadsa', 'asdsad@ss.com', 'assaddsa', '2024-06-27 13:24:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

DROP TABLE IF EXISTS `detalle_pedidos`;
CREATE TABLE `detalle_pedidos` (
  `id` int(10) UNSIGNED NOT NULL,
  `pedido_id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 1, 2, 19.99),
(2, 2, 2, 1, 29.99),
(3, 3, 3, 1, 15.99),
(4, 3, 4, 2, 12.99),
(5, 3, 5, 1, 5.99),
(6, 4, 3, 1, 15.99),
(7, 5, 4, 1, 12.99),
(8, 6, 1, 1, 19.99),
(9, 6, 6, 1, 24.99),
(10, 6, 7, 1, 21.99),
(11, 7, 7, 1, 39.99),
(12, 8, 1, 1, 19.99),
(13, 8, 8, 1, 9.99),
(14, 8, 9, 1, 15.00),
(15, 9, 6, 1, 24.99),
(16, 10, 10, 1, 34.99),
(17, 11, 2, 2, 0.00),
(18, 12, 2, 2, 0.00),
(19, 13, 1, 1, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_productos`
--

DROP TABLE IF EXISTS `imagenes_productos`;
CREATE TABLE `imagenes_productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `ruta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes_productos`
--

INSERT INTO `imagenes_productos` (`id`, `producto_id`, `ruta`) VALUES
(1, 1, 'camiseta-aries-2.jpg'),
(2, 1, 'camiseta-aries-3.jpg'),
(3, 2, 'collar-luna-2.jpg'),
(4, 3, 'libro-astrologia-2.jpg'),
(5, 4, 'amatista-2.jpg'),
(6, 5, 'incienso-lavanda-2.jpg'),
(7, 6, 'tarot-rider-2.jpg'),
(8, 7, 'runas-vikingas-2.jpg'),
(9, 8, 'aceite-te-2.jpg'),
(10, 9, 'anillo-zodiacal-2.jpg'),
(11, 10, 'lampara-sal-2.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `fecha_pedido_utc` datetime DEFAULT NULL,
  `estado` enum('pendiente','procesando','enviado','completado','cancelado') DEFAULT 'pendiente',
  `total` decimal(10,2) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `metodo_pago` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `fecha_pedido_utc`, `estado`, `total`, `nombre`, `apellidos`, `email`, `telefono`, `direccion`, `ciudad`, `codigo_postal`, `metodo_pago`) VALUES
(1, 1, '2024-06-25 15:29:53', 'completado', 49.98, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, '2024-06-25 15:29:53', 'pendiente', 29.99, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, '2024-06-25 15:29:53', 'enviado', 70.97, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, '2024-06-25 15:29:53', 'procesando', 15.99, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, '2024-06-25 15:29:53', 'cancelado', 12.99, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, '2024-06-25 15:29:53', 'completado', 65.97, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, '2024-06-25 15:29:53', 'pendiente', 39.99, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 8, '2024-06-25 15:29:53', 'enviado', 44.98, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 9, '2024-06-25 15:29:53', 'procesando', 24.99, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 10, '2024-06-25 15:29:53', 'completado', 34.99, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 11, NULL, 'pendiente', 59.98, 'dante', 'ssdd', 'der.@ss.com', 'ssdd', 'ssdd', 'ssdd', 'ssdd', 'Tarjeta'),
(12, 11, NULL, 'pendiente', 59.98, 'dante', 'ssdd', 'der.@ss.com', 'ssdd', 'ssdd', 'ssdd', 'ssdd', 'Tarjeta'),
(13, 14, NULL, 'pendiente', 19.99, 'bryan', 'ss', 'bryan@vilcanota.com', 'ss', 'ss', 'ss', 'ss', 'Tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `stock` int(10) UNSIGNED NOT NULL,
  `categoria_id` int(10) UNSIGNED DEFAULT NULL,
  `signos_compatibles` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `stock`, `categoria_id`, `signos_compatibles`, `fecha_creacion`) VALUES
(1, 'Camiseta con símbolo de Aries', 'Camiseta 100% algodón con el símbolo de Aries estampado.', 19.99, 'https://m.media-amazon.com/images/I/A13usaonutL._CLa%7C2140%2C2000%7C91iZdAlTFvL.png%7C0%2C0%2C2140%2C2000%2B0.0%2C0.0%2C2140.0%2C2000.0_AC_UY1000_.png', 20, 1, 'Aries, Leo, Sagitario', '2024-06-25 20:29:53'),
(2, 'Collar con piedra lunar', 'Collar de plata con una piedra lunar en forma de lágrima.', 29.99, 'collar-luna.jpg', 15, 2, 'Cáncer, Piscis', '2024-06-25 20:29:53'),
(3, 'Libro \"Astrología para principiantes\"', 'Un libro completo para adentrarse en el mundo de la astrología.', 15.99, 'libro-astrologia.jpg', 30, 3, 'Todos los signos', '2024-06-25 20:29:53'),
(4, 'Amatista en bruto', 'Una pieza única de amatista en bruto para la meditación.', 12.99, 'amatista.jpg', 10, 4, 'Piscis, Virgo, Capricornio', '2024-06-25 20:29:53'),
(5, 'Incienso de lavanda', 'Incienso natural de lavanda para relajar el ambiente.', 5.99, 'incienso-lavanda.jpg', 25, 5, 'Tauro, Libra, Piscis', '2024-06-25 20:29:53'),
(6, 'Baraja de Tarot Rider Waite', 'La baraja de Tarot más popular del mundo.', 24.99, 'tarot-rider.jpg', 12, 6, 'Todos los signos', '2024-06-25 20:29:53'),
(7, 'Set de Runas Vikingas', 'Un set de runas vikingas talladas en madera.', 39.99, 'runas-vikingas.jpg', 8, 7, 'Aries, Géminis, Leo', '2024-06-25 20:29:53'),
(8, 'Aceite esencial de árbol de té', 'Aceite esencial de árbol de té 100% puro.', 9.99, 'aceite-te.jpg', 18, 8, 'Virgo, Capricornio', '2024-06-25 20:29:53'),
(9, 'Anillo de plata con signo zodiacal', 'Anillo de plata personalizable con tu signo zodiacal.', 22.99, 'anillo-zodiacal.jpg', 14, 9, 'Todos los signos', '2024-06-25 20:29:53'),
(10, 'Lámpara de sal del Himalaya', 'Lámpara de sal del Himalaya para purificar el aire.', 34.99, 'lampara-sal.jpg', 5, 10, 'Todos los signos', '2024-06-25 20:29:53'),
(11, 'Camiseta Zodiaco', 'Camiseta con diseño del signo zodiaco Aries.', 15.99, 'img/productos/camiseta_zodiaco_aries.jpg', 0, 1, NULL, '2024-06-26 01:45:15'),
(12, 'Collar de Cuarzo', 'Collar con piedra de cuarzo rosa.', 24.99, 'img/productos/collar_cuarzo_rosa.jpg', 0, 2, NULL, '2024-06-26 01:45:15'),
(13, 'Tarot Clásico', 'Baraja de tarot clásica con ilustraciones antiguas.', 19.50, 'img/productos/tarot_clasico.jpg', 0, 3, NULL, '2024-06-26 01:45:15'),
(14, 'Vela Aromática de Lavanda', 'Vela aromática con esencia de lavanda para relajación.', 10.00, 'img/productos/vela_lavanda.jpg', 0, 2, NULL, '2024-06-26 01:45:15'),
(15, 'Póster Carta Astral', 'Póster personalizado con tu carta astral.', 22.00, 'img/productos/poster_carta_astral.jpg', 0, 2, NULL, '2024-06-26 01:45:15'),
(16, 'Agenda Astrológica 2024', 'Agenda con fases lunares y eventos astrológicos para 2024.', 18.75, 'img/productos/agenda_astrologica_2024.jpg', 0, 3, NULL, '2024-06-26 01:45:15'),
(17, 'Bolsa de Tela con Signos', 'Bolsa de tela ecológica con estampado de signos zodiacales.', 12.50, 'img/productos/bolsa_tela_zodiaco.jpg', 0, 1, NULL, '2024-06-26 01:45:15'),
(18, 'Anillo de Amatista', 'Anillo con piedra de amatista para equilibrio emocional.', 29.99, 'img/productos/anillo_amatista.jpg', 0, 2, NULL, '2024-06-26 01:45:15'),
(19, 'Guía de Interpretación de Sueños', 'Libro sobre cómo interpretar tus sueños.', 16.45, 'img/productos/guia_interpretacion_suenos.jpg', 0, 3, NULL, '2024-06-26 01:45:15'),
(20, 'Almohada Zodiacal', 'Almohada decorativa con constelaciones.', 27.00, 'img/productos/almohada_zodiacal.jpg', 0, 4, NULL, '2024-06-26 01:45:15'),
(21, 'Pulsera de Chakra', 'Pulsera ajustable con cuentas de colores representando los chakras.', 20.00, 'img/productos/pulsera_chakra.jpg', 0, 2, NULL, '2024-06-26 01:45:15'),
(22, 'Pendientes de Estrella', 'Pendientes de plata en forma de estrella.', 17.99, 'img/productos/pendientes_estrella.jpg', 0, 2, NULL, '2024-06-26 01:45:15'),
(23, 'Guía Astrológica para Principiantes', 'Libro introductorio a la astrología.', 14.00, 'img/productos/guia_astrologia_principiantes.jpg', 0, 3, NULL, '2024-06-26 01:45:15'),
(24, 'Esfera de Cristal', 'Esfera de cristal para adivinación.', 35.00, 'img/productos/esfera_cristal.jpg', 0, 4, NULL, '2024-06-26 01:45:15'),
(25, 'Llavero Signo Zodiacal', 'Llavero metálico con tu signo del zodiaco.', 8.50, 'img/productos/llavero_signo_zodiacal.jpg', 0, 2, NULL, '2024-06-26 01:45:15'),
(26, 'Sábana Estelar', 'Sábana de cama con diseño de estrellas y constelaciones.', 32.99, 'img/productos/sabana_estelar.jpg', 0, 1, NULL, '2024-06-26 01:45:15'),
(27, 'Collar Atrapasueños', 'Collar con un pequeño atrapasueños.', 21.00, 'img/productos/collar_atrapasuenos.jpg', 0, 2, NULL, '2024-06-26 01:45:15'),
(28, 'Libro de Compatibilidad Zodiacal', 'Libro sobre compatibilidad entre signos del zodiaco.', 18.00, 'img/productos/libro_compatibilidad_zodiacal.jpg', 0, 3, NULL, '2024-06-26 01:45:15'),
(29, 'Set de Incienso Espiritual', 'Set de incienso con diferentes fragancias para meditación.', 14.50, 'img/productos/set_incienso_espiritual.jpg', 0, 4, NULL, '2024-06-26 01:45:15'),
(30, 'Reloj de Pared Constelación', 'Reloj de pared con diseño de constelaciones.', 40.00, 'img/productos/reloj_pared_constelacion.jpg', 0, 2, NULL, '2024-06-26 01:45:15'),
(31, 'Cuaderno con Signos', 'Cuaderno de notas con diseño de signos zodiacales.', 9.75, 'img/productos/cuaderno_signos_zodiacales.jpg', 0, 4, NULL, '2024-06-26 01:45:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `signo_zodiacal` varchar(20) DEFAULT NULL,
  `direccion_envio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `contrasena`, `fecha_registro`, `signo_zodiacal`, `direccion_envio`) VALUES
(1, 'Ana Pérez', 'ana@example.com', 'contraseña1', '2024-06-25 20:29:52', 'Aries', 'sd'),
(2, 'Juan Gómez', 'juan@example.com', 'contraseña2', '2024-06-25 20:29:52', 'Tauro', 'sd'),
(3, 'Laura López', 'laura@example.com', 'contraseña3', '2024-06-25 20:29:52', 'Géminis', 'sd'),
(4, 'Pedro Martínez', 'pedro@example.com', 'contraseña4', '2024-06-25 20:29:52', 'Cáncer', 'sd'),
(5, 'Sofía Sánchez', 'sofia@example.com', 'contraseña5', '2024-06-25 20:29:52', 'Leo', 'sd'),
(6, 'Miguel Rodríguez', 'miguel@example.com', 'contraseña6', '2024-06-25 20:29:52', 'Virgo', 'sd'),
(7, 'Carmen García', 'carmen@example.com', 'contraseña7', '2024-06-25 20:29:52', 'Libra', 'sd'),
(8, 'Javier Fernández', 'javier@example.com', 'contraseña8', '2024-06-25 20:29:52', 'Escorpio', 'sd'),
(9, 'Isabel Díaz', 'isabel@example.com', 'contraseña9', '2024-06-25 20:29:52', 'Sagitario', 'sd'),
(10, 'David Moreno', 'david@example.com', 'contraseña10', '2024-06-25 20:29:52', 'Capricornio', 'sd'),
(11, 'dante', 'der.@ss.com', '$2y$10$7VSQBTKcBUJtwLheXN4xPOXZlBCF5GuNklqUUDwtlLaRhKk9Tny2q', '2024-06-26 03:15:02', NULL, 'sd'),
(12, 'yasmin', 'yasmin@123.com', '$2y$10$WsI9cJquw4qaxJVBEp0QUeaLgM.VCT1k8H9ZgSApb40Etz/GVxJT.', '2024-06-26 14:24:09', 'Leo', NULL),
(13, 'dante', 'dante@123.com', '$2y$10$ahcyC6NPdH2SpxyIaozPp.hvLB1n9RrVT2UmzvE6sATjJasWknvQO', '2024-06-26 14:27:20', 'Capricornio', NULL),
(14, 'bryan', 'bryan@vilcanota.com', '$2y$10$.WfZTQzTBBgeQif9WBrYEerYGww.WKmqLzGcxJGRi8gyECY8dd65q', '2024-06-27 13:21:36', 'Escorpio', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `imagenes_productos`
--
ALTER TABLE `imagenes_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `imagenes_productos`
--
ALTER TABLE `imagenes_productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedidos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `imagenes_productos`
--
ALTER TABLE `imagenes_productos`
  ADD CONSTRAINT `imagenes_productos_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
