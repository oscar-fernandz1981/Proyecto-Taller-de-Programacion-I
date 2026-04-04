-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-03-2026 a las 04:34:48
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
-- Base de datos: `fernandez_oscar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `activo` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `descripcion`, `activo`) VALUES
(1, 'termos', 1),
(2, 'auriculares', 1),
(3, 'juguetes', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `asunto` varchar(100) DEFAULT NULL,
  `mensaje` varchar(300) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id`, `nombre`, `email`, `asunto`, `mensaje`, `fecha`, `estado`) VALUES
(1, 'jose', 'joselo@correo.com', NULL, 'hola, q hay?!!!', '2026-03-16 22:20:46', 'Resuelta'),
(2, 'jose', 'joselo@correo.com', NULL, 'como está el partido?', '2026-03-16 22:20:46', 'Resuelta'),
(3, 'jose', 'joselo@correo.com', NULL, 'probando!!!', '2026-03-16 22:20:46', 'Resuelta'),
(4, 'jose', 'joselo@correo.com', NULL, 'dfdgfdg', '2026-03-16 22:20:46', 'Resuelta'),
(5, 'jose', 'joselo@correo.com', NULL, 'estoy de nuevo, probando esto', '2026-03-16 22:20:46', 'Resuelta'),
(6, 'jose', 'joselo@correo.com', NULL, 'probando de nuevo esto', '2026-03-16 22:20:46', 'Resuelta'),
(7, 'oscar', 'oscar_gimenez12@correo.com', NULL, 'buenas tardes queria saber los horarios de atencion y que necesito llevar, aparte del producto y su caja ... la factura?', '2026-03-16 22:20:46', 'Resuelta'),
(8, 'enzo', 'enzoayala@hotmail.com', NULL, 'Consulta... Para solicitud de pedidos?? \r\nGracias!!', '2026-03-16 22:20:46', 'Resuelta'),
(9, 'enzo', 'enzoayala@hotmail.com', NULL, 'buenas, habia solicitado un producto via whatsapp, y todavia no lo reciben. Eso fue la semana pasada', '2026-03-16 22:20:46', 'Pendiente'),
(10, 'enzo', 'enzoayala@hotmail.com', NULL, 'Todavia no tengo notificaciones del pedido solicitado!!\r\nGracias.-', '2026-03-16 22:20:46', 'Pendiente'),
(11, 'enzo', 'enzoayala@hotmail.com', NULL, 'nhmj,kj.k', '2026-03-16 22:20:46', 'Pendiente'),
(12, 'enzo', 'enzoayala@hotmail.com', NULL, 'probando...', '2026-03-16 22:20:46', 'Pendiente'),
(13, 'fef', 'grtgtrfd@fvf.com', NULL, 'vfbggnnhgmhjmjvcn', '2026-03-16 22:20:46', 'Pendiente'),
(14, 'rfgt', 'vgfbgfb@vvb.com', NULL, 'fvbgfbnghnhmj,k,', '2026-03-16 22:20:46', 'Pendiente'),
(15, 'jhjhjhjh', 'fjkgjkb@fgh.com', NULL, 'vfnghnmhjm,', '2026-03-16 22:20:46', 'Pendiente'),
(16, 'dfgfghgf', 'vbgh@cvb.com', NULL, 'sdfghjkkbbvcx', '2026-03-16 22:20:46', 'Pendiente'),
(17, 'gregrh', 'fgfhgf@fbgb.com', NULL, 'fdgfgj', '2026-03-16 22:20:46', 'Pendiente'),
(18, 'enzo', 'enzoayala@hotmail.com', NULL, 'fgfh', '2026-03-16 22:20:46', 'Pendiente'),
(19, 'ssfdf', 'fdf@vcv.com', NULL, 'cvbgbdd', '2026-03-16 22:20:46', 'Pendiente'),
(20, 'ssfdf', 'fdf@vcv.com', NULL, 'cvbgbdd', '2026-03-16 22:20:46', 'Pendiente'),
(21, 'VFBV', 'xx@m.com', NULL, 'DC  ', '2026-03-16 22:20:46', 'Pendiente'),
(22, 'pep', 'pep@pe.com', 'Facturación', 'me facturaron mal un producto, donde puedo reclamar???', '2026-03-16 22:20:46', 'Pendiente'),
(23, 'jacinto', 'jacintov@correo.com', 'Problema con pedido', 'hola, tuve un problema con un pedido, donde reclamo??', '2026-03-16 22:20:46', 'Pendiente'),
(24, 'luis ', 'luisja@email.com', 'Problema con pedido', 'tuve un problemita con un pedido, donde recurro????', NULL, 'Pendiente'),
(25, 'fdf', 'fdff@hh.com', 'Devolución o cambio', 'devolveme la plata ', '2026-03-17 01:30:02', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id_perfiles` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id_perfiles`, `descripcion`) VALUES
(1, 'admin'),
(2, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_prod` varchar(100) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `precio` float NOT NULL,
  `precio_vta` float NOT NULL,
  `stock` int(11) NOT NULL,
  `stock_min` int(11) NOT NULL,
  `eliminado` varchar(10) NOT NULL DEFAULT 'NO',
  `promo_activada` int(2) DEFAULT 2,
  `descuento_porcentaje` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_prod`, `imagen`, `categoria_id`, `precio`, `precio_vta`, `stock`, `stock_min`, `eliminado`, `promo_activada`, `descuento_porcentaje`) VALUES
(1, 'auricular manos libres', '1718633229_4ad0f6ee889501032472.jpg', 2, 4000, 6000, 1, 5, 'NO', 1, 45),
(2, 'auricular bluetooth', '1718633433_b93ab5eeff4f77c24cab.jpg', 2, 5600, 7000, 48, 1, 'NO', 1, 30),
(3, '', '1718633744_b6c14cdc9396c5802efd.jpg', 2, 5600, 6000, 10, 4, 'SI', 2, 0),
(4, 'termo acero inox', '1718633835_db20614281718c9add8c.jpg', 1, 7500, 8300, 48, 3, 'NO', 1, 20),
(5, 'termo lumilagro', '1719628769_556fc9307def7a7fc2a5.jpg', 1, 5500, 7800, 9, 5, 'NO', 0, 0),
(6, 'the batman', '1768078528_7266a8e28669a80d127c.jpg', 3, 15000, 17500, 33, 5, 'NO', 1, 20),
(7, 'batman gris', '1768078598_74223d919562178a01c9.jpg', 3, 8000, 11000, 15, 3, 'NO', 2, 0),
(8, 'auricular-micro', '1768080845_af1034ba29f4d9bd336e.jpg', 2, 6500, 9500, 15, 2, 'NO', 1, 15),
(9, 'funco pop pokemon', '1774482844_894348a8239362f9d775.jpg', 3, 10000, 18000, 25, 5, 'NO', 0, 0),
(10, 'autobot transformer', '1774495014_d34786c3f83006ac80d8.jpg', 3, 3500, 9000, 30, 5, 'NO', 1, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dni` int(8) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `perfil_img` varchar(255) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `baja` varchar(2) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `usuario`, `email`, `dni`, `pass`, `perfil_img`, `perfil_id`, `baja`) VALUES
(1, 'jose', 'lopez', 'joselo1', 'joselo@correo.com', 0, '$2y$10$NdHl4pSHkbd52AUpF8FoA.fIvsWayPxeCV95LYldeLuxCQ0pSoR2C', '', 2, 'NO'),
(4, 'admin', 'admin', 'admin', 'admin@admin.com', 0, '$2y$10$MdPdh02fuL2HHvi7R8/bcugwW9W6RuizRxhbKGqL2dJEiMZDataS6', '', 1, 'NO'),
(5, 'javier', 'caceres', 'javica1', 'javica@correo.com', 0, '$2y$10$ddDSEGNNSwxADxQPHkMMWedEkWawX40iZYq8nc1F3seTI78TJCJ2O', '', 2, 'NO'),
(6, 'carlos', 'romero', 'carlos1', 'charly@correo.com', 0, '$2y$10$U4U9yNYbeC2kcKJXxH/kpOevEmBIDGW7VluKeBIjiohVWgSgOoT3e', '', 2, 'NO'),
(7, 'oscar', 'fernandez', 'oscarf1', 'fernandez.r.oscar@gmail.com', 0, '$2y$10$CVg4kBRRRmxqoV3oj9uTMOHNzJhAVwOUIGlBHOJAudQP/9eun5VDm', '', 1, 'NO'),
(8, 'clarisa', 'riquelme', 'clarisa1', 'clarisa@correo.com', 0, '$2y$10$aGjdcLD.R2b4sH/eo.v34e/zY3L6lJ.rY/x9Pxfzuanc89UETsIYm', '', 2, 'NO'),
(9, 'oscar', 'gimenez', 'os_gi', 'oscar_gimenez12@correo.com', 0, '$2y$10$jIcCrAbafVlpMuvS7/zt2uamUxkYQ8wXj/37eg5oK5daWEabbuYue', '', 2, 'NO'),
(10, 'temp', 'teporario', 'tempadmin', 'tempadmin@correo.com', 0, '$2y$10$MdPdh02fuL2HHvi7R8/bcugwW9W6RuizRxhbKGqL2dJEiMZDataS6', '', 2, 'SI'),
(11, 'enzo', 'fernandez ayala', 'enzo_ayala', 'enzoayala@hotmail.com', 55996225, '$2y$10$hqf/EFTCbwSgLd/QLEp/r.rqwt0JA6C.ZNUVISyUXuKPpS.9MPwMO', '1773174012_72f4df4c7ac796bd0892.jpg', 2, 'NO'),
(12, 'jose', 'ramirez', 'joseram', 'joselo17@gmail.com', 0, '$2y$10$IgSbFUFNDDbjWD3fuAhqf.XnqwQJFJswUM05pZNi/ROXTI.enYIty', '', 2, 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_cabecera`
--

CREATE TABLE `ventas_cabecera` (
  `id` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `total_venta` float(10,2) NOT NULL,
  `tipo_pago` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas_cabecera`
--

INSERT INTO `ventas_cabecera` (`id`, `fecha`, `usuario_id`, `total_venta`, `tipo_pago`) VALUES
(1, '2024-06-30', 1, 7800.00, 'Efectivo'),
(2, '2024-06-30', 1, 7800.00, 'Efectivo'),
(3, '2024-06-30', 1, 13800.00, 'Efectivo'),
(4, '2024-06-30', 1, 29400.00, 'T_Debito'),
(5, '2026-01-22', 11, 28500.00, 'Efectivo'),
(6, '2026-01-22', 11, 24300.00, 'T_Credito'),
(7, '2026-02-09', 11, 35500.00, 'Efectivo'),
(8, '2026-02-16', 11, 26300.00, 'T_Debito'),
(9, '2026-02-17', 11, 21000.00, 'Transferencia'),
(10, '2026-02-21', 11, 35000.00, 'Transferencia'),
(11, '2026-02-21', 11, 33000.00, 'T_Debito'),
(12, '2026-02-21', 11, 22000.00, 'T_Credito'),
(13, '2026-02-21', 11, 33200.00, 'T_Credito'),
(14, '2026-02-21', 11, 35000.00, 'T_Debito'),
(15, '2026-02-21', 11, 19000.00, 'Efectivo'),
(16, '2026-02-21', 11, 18000.00, 'T_Debito'),
(17, '2026-02-21', 11, 21000.00, 'T_Credito'),
(18, '2026-02-26', 11, 600000.00, 'T_Debito'),
(19, '2026-02-26', 11, 14000.00, 'Efectivo'),
(20, '2026-03-14', 11, 35000.00, 'T_Debito'),
(21, '2026-03-15', 11, 35000.00, 'Transferencia'),
(22, '2026-03-18', 11, 621900.00, 'T_Credito'),
(23, '2026-03-23', 11, 11540.00, 'Efectivo'),
(24, '2026-03-23', 11, 10900.00, 'Transferencia'),
(25, '2026-03-26', 11, 7800.00, 'Efectivo'),
(26, '2026-03-26', 11, 702000.00, 'Efectivo'),
(27, '2026-03-26', 11, 82540.00, 'Transferencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_detalle`
--

CREATE TABLE `ventas_detalle` (
  `id` int(10) NOT NULL,
  `venta_id` int(10) NOT NULL,
  `producto_id` int(10) NOT NULL,
  `cantidad` int(10) NOT NULL,
  `precio` float(10,2) NOT NULL,
  `total` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas_detalle`
--

INSERT INTO `ventas_detalle` (`id`, `venta_id`, `producto_id`, `cantidad`, `precio`, `total`) VALUES
(6, 1, 5, 1, 7800.00, 7800.00),
(7, 2, 5, 1, 7800.00, 7800.00),
(8, 3, 5, 1, 7800.00, 7800.00),
(9, 3, 1, 1, 6000.00, 6000.00),
(10, 4, 5, 3, 7800.00, 23400.00),
(11, 4, 1, 1, 6000.00, 6000.00),
(12, 5, 6, 1, 17500.00, 17500.00),
(13, 5, 7, 1, 11000.00, 11000.00),
(14, 6, 2, 1, 7000.00, 7000.00),
(15, 6, 8, 1, 9500.00, 9500.00),
(16, 6, 5, 1, 7800.00, 7800.00),
(17, 7, 2, 1, 7000.00, 7000.00),
(18, 7, 7, 1, 11000.00, 11000.00),
(19, 7, 6, 1, 17500.00, 17500.00),
(20, 8, 2, 1, 7000.00, 7000.00),
(21, 8, 7, 1, 11000.00, 11000.00),
(22, 8, 4, 1, 8300.00, 8300.00),
(23, 9, 2, 3, 7000.00, 21000.00),
(33, 10, 6, 2, 17500.00, 35000.00),
(34, 11, 7, 3, 11000.00, 33000.00),
(35, 12, 7, 2, 11000.00, 22000.00),
(36, 13, 4, 4, 8300.00, 33200.00),
(37, 14, 6, 2, 17500.00, 35000.00),
(38, 15, 8, 2, 9500.00, 19000.00),
(39, 16, 1, 3, 6000.00, 18000.00),
(40, 17, 2, 3, 7000.00, 21000.00),
(41, 18, 1, 100, 6000.00, 600000.00),
(42, 19, 2, 2, 7000.00, 14000.00),
(43, 20, 2, 5, 7000.00, 35000.00),
(44, 21, 2, 5, 7000.00, 35000.00),
(45, 22, 4, 27, 8300.00, 224100.00),
(46, 22, 5, 51, 7800.00, 397800.00),
(47, 23, 2, 1, 4900.00, 4900.00),
(48, 23, 4, 1, 6640.00, 6640.00),
(49, 24, 1, 1, 6000.00, 6000.00),
(50, 24, 2, 1, 4900.00, 4900.00),
(51, 25, 5, 1, 7800.00, 7800.00),
(52, 26, 5, 90, 7800.00, 702000.00),
(53, 27, 1, 23, 3300.00, 75900.00),
(54, 27, 4, 1, 6640.00, 6640.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id_perfiles`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `perfil_id` (`perfil_id`);

--
-- Indices de la tabla `ventas_cabecera`
--
ALTER TABLE `ventas_cabecera`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfiles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `ventas_cabecera`
--
ALTER TABLE `ventas_cabecera`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`perfil_id`) REFERENCES `perfiles` (`id_perfiles`);

--
-- Filtros para la tabla `ventas_cabecera`
--
ALTER TABLE `ventas_cabecera`
  ADD CONSTRAINT `ventas_cabecera_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  ADD CONSTRAINT `ventas_detalle_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas_cabecera` (`id`),
  ADD CONSTRAINT `ventas_detalle_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
