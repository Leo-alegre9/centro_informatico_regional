-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2026 a las 06:24:25
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
-- Base de datos: `cir2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('superadmin','editor') NOT NULL DEFAULT 'editor',
  `ultimo_acceso` datetime DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `admin_users`
--

INSERT INTO `admin_users` (`id`, `nombre`, `email`, `password`, `rol`, `ultimo_acceso`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'admin@cir.com', '$2y$10$d.Zbc3z.elgmDiMWRJqkRed4bmjxCdpAmXnlbg0F9A5rNKS..c6R2', 'superadmin', NULL, 1, '2026-05-10 17:21:04', '2026-05-10 17:21:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `nivel` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `icono` varchar(80) NOT NULL DEFAULT 'fas fa-tag',
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `orden` smallint(6) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `parent_id`, `nivel`, `nombre`, `slug`, `icono`, `descripcion`, `activo`, `orden`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Informática', 'informatica', 'fas fa-laptop', NULL, 1, 1, '2026-05-10 16:58:39', '2026-05-10 16:58:39'),
(2, NULL, 1, 'Muebles', 'muebles', 'fas fa-couch', NULL, 1, 2, '2026-05-10 16:58:39', '2026-05-10 16:58:39'),
(3, NULL, 1, 'Electrodomésticos', 'electrodomesticos', 'fas fa-blender', NULL, 1, 3, '2026-05-10 16:58:39', '2026-05-10 16:58:39'),
(4, NULL, 1, 'Línea Comercial', 'linea-comercial', 'fas fa-store', NULL, 1, 4, '2026-05-10 16:58:39', '2026-05-10 16:58:39'),
(5, 1, 2, 'Accesorios', 'accesorios', 'fas fa-keyboard', NULL, 1, 1, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(6, 1, 2, 'Componentes y Hardware', 'componentes', 'fas fa-microchip', NULL, 1, 2, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(7, 1, 2, 'Monitores', 'monitores', 'fas fa-tv', NULL, 1, 3, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(8, 1, 2, 'Seguridad Informática', 'seguridad', 'fas fa-shield-halved', NULL, 1, 4, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(9, 1, 2, 'Conectividad y Redes', 'conectividad', 'fas fa-wifi', NULL, 1, 5, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(10, 1, 2, 'Impresión', 'impresion', 'fas fa-print', NULL, 1, 6, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(11, 2, 2, 'Oficina', 'oficina', 'fas fa-briefcase', NULL, 1, 1, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(12, 2, 2, 'Hogar', 'hogar', 'fas fa-home', NULL, 1, 2, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(13, 3, 2, 'Heladeras', 'heladeras', 'fas fa-temperature-low', NULL, 1, 1, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(14, 3, 2, 'Cocinas', 'cocinas', 'fas fa-fire', NULL, 1, 2, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(15, 3, 2, 'Hornos', 'hornos', 'fas fa-bread-slice', NULL, 1, 3, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(16, 3, 2, 'Freezers', 'freezer', 'fas fa-snowflake', NULL, 1, 4, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(17, 3, 2, 'Televisores', 'tvs', 'fas fa-tv', NULL, 1, 5, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(18, 3, 2, 'Audio', 'audio', 'fas fa-volume-high', NULL, 1, 6, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(19, 4, 2, 'Frío Comercial', 'frio', 'fas fa-snowflake', NULL, 1, 1, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(20, 4, 2, 'Calor Industrial', 'calor', 'fas fa-fire', NULL, 1, 2, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(21, 4, 2, 'Varios', 'varios', 'fas fa-cubes', NULL, 1, 3, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(22, 4, 2, 'Amoblamiento Comercial', 'amoblamiento-comercial', 'fas fa-server', NULL, 1, 4, '2026-05-10 17:03:51', '2026-05-10 17:03:51'),
(23, 11, 3, 'Escritorios', 'escritorios', 'fas fa-briefcase', NULL, 1, 1, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(24, 11, 3, 'Mesas para PC', 'mesas-pc', 'fas fa-laptop', NULL, 1, 2, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(25, 11, 3, 'Sillas de Oficina', 'sillas', 'fas fa-chair', NULL, 1, 3, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(26, 11, 3, 'Bibliotecas', 'bibliotecas', 'fas fa-book', NULL, 1, 4, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(27, 11, 3, 'Archiveros', 'archiveros', 'fas fa-folder-open', NULL, 1, 5, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(28, 11, 3, 'Sillones de Espera', 'sillones', 'fas fa-couch', NULL, 1, 6, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(29, 12, 3, 'Dormitorio', 'dormitorio', 'fas fa-bed', NULL, 1, 1, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(30, 12, 3, 'Livings', 'livings', 'fas fa-couch', NULL, 1, 2, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(31, 12, 3, 'Cocina', 'cocina', 'fas fa-utensils', NULL, 1, 3, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(32, 12, 3, 'Baño', 'bano', 'fas fa-bath', NULL, 1, 4, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(33, 19, 3, 'Freezers Comerciales', 'freezer-comercial', 'fas fa-snowflake', NULL, 1, 1, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(34, 19, 3, 'Pozos de Frío', 'pozo-de-frio', 'fas fa-cubes', NULL, 1, 2, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(35, 19, 3, 'Exhibidoras', 'exhibidoras', 'fas fa-layer-group', NULL, 1, 3, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(36, 19, 3, 'Bateas', 'bateas', 'fas fa-grip-lines', NULL, 1, 4, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(37, 20, 3, 'Cocinas Industriales', 'cocinas-industrial', 'fas fa-fire', NULL, 1, 1, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(38, 20, 3, 'Hornos Industriales', 'hornos-industrial', 'fas fa-bread-slice', NULL, 1, 2, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(39, 20, 3, 'Freidoras', 'freidoras-calor', 'fas fa-fire', NULL, 1, 3, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(40, 21, 3, 'Balanzas', 'balanzas', 'fas fa-scale-balanced', NULL, 1, 1, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(41, 21, 3, 'Cortadoras de Fiambre', 'cortadoras-fiambre', 'fas fa-scissors', NULL, 1, 2, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(42, 21, 3, 'Amasadoras', 'amasadoras', 'fas fa-blender', NULL, 1, 3, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(43, 21, 3, 'Freidoras de Aire', 'freidoras-varios', 'fas fa-wind', NULL, 1, 4, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(44, 22, 3, 'Góndolas', 'gondolas', 'fas fa-layer-group', NULL, 1, 1, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(45, 22, 3, 'Estanterías Metálicas', 'estanterias-metalicas', 'fas fa-grip-lines', NULL, 1, 2, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(46, 22, 3, 'Paneles Ranurados', 'paneles-ranurados', 'fas fa-grip-lines', NULL, 1, 3, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(47, 22, 3, 'Mostradores', 'mostradores', 'fas fa-store', NULL, 1, 4, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(48, 22, 3, 'Racks', 'racks', 'fas fa-server', NULL, 1, 5, '2026-05-10 17:18:51', '2026-05-10 17:18:51'),
(49, 22, 3, 'Accesorios Comerciales', 'accesorios-comerciales', 'fas fa-cubes', NULL, 1, 6, '2026-05-10 17:18:51', '2026-05-10 17:18:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas_servicio`
--

CREATE TABLE `consultas_servicio` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre_cliente` varchar(200) NOT NULL,
  `tipo_equipo` varchar(100) NOT NULL,
  `marca_modelo` varchar(200) DEFAULT NULL,
  `descripcion_problema` text NOT NULL,
  `urgencia` varchar(100) NOT NULL DEFAULT 'Sin urgencia particular',
  `tecnico_contactado` varchar(100) NOT NULL,
  `numero_tecnico` varchar(30) NOT NULL,
  `ip_cliente` varchar(45) DEFAULT NULL,
  `estado` enum('nueva','vista','resuelta') NOT NULL DEFAULT 'nueva',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `consultas_servicio`
--

INSERT INTO `consultas_servicio` (`id`, `nombre_cliente`, `tipo_equipo`, `marca_modelo`, `descripcion_problema`, `urgencia`, `tecnico_contactado`, `numero_tecnico`, `ip_cliente`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Test Cliente', 'PC de escritorio', NULL, 'No enciende', 'Lo antes posible', 'Hernan', '543731448928', '::1', 'resuelta', '2026-05-11 22:31:19', '2026-05-12 05:18:58'),
(2, 'Leonel Alegre', 'Notebook / Laptop', 'Lenovo', 'No me carga el porno en mi navegador', 'Es urgente, lo necesito hoy', 'Hernán', '543731448928', '::1', 'resuelta', '2026-05-11 22:35:53', '2026-05-11 22:39:30'),
(3, 'Leonel Alegre', 'Notebook / Laptop', 'Samsung', 'No enciende mi notebook', 'Es urgente, lo necesito hoy', 'Hernán', '543731448928', '::1', 'resuelta', '2026-05-11 22:54:55', '2026-05-11 22:56:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto_mensajes`
--

CREATE TABLE `contacto_mensajes` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `asunto` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `ip_remota` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contacto_mensajes`
--

INSERT INTO `contacto_mensajes` (`id`, `nombre`, `email`, `asunto`, `mensaje`, `leido`, `ip_remota`, `created_at`) VALUES
(1, 'Leonel Francisco ', 'leonel@gmail.com', 'servicio-tecnico', 'Tengo una notebook que necesita limpieza y cambio de sistema operativo ', 0, '::1', NULL),
(2, 'Leonel Francisco ', 'leonelfalegre@gmail.com', 'presupuesto', 'Necesito presupuesto de pc gamer', 0, '::1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `logo_url` varchar(500) DEFAULT NULL,
  `sitio_web` varchar(300) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-05-10-000001', 'AppDatabaseMigrationsCreateAdminUsersTable', 'default', 'App', 1778536846, 1),
(2, '2025-05-10-000002', 'AppDatabaseMigrationsCreateCategoriasTable', 'default', 'App', 1778536846, 1),
(3, '2025-05-10-000003', 'AppDatabaseMigrationsCreateMarcasTable', 'default', 'App', 1778536846, 1),
(4, '2025-05-10-000004', 'AppDatabaseMigrationsCreateProductosTable', 'default', 'App', 1778536846, 1),
(5, '2025-05-10-000005', 'AppDatabaseMigrationsCreateProductoImagenesTable', 'default', 'App', 1778536846, 1),
(6, '2025-05-10-000006', 'AppDatabaseMigrationsCreateContactoMensajesTable', 'default', 'App', 1778536846, 1),
(14, '2025-05-12-000008', 'AppDatabaseMigrationsAddDestacadoToProductos', 'default', 'App', 1778559049, 2),
(15, '2025-05-11-000007', 'AppDatabaseMigrationsCreateConsultasServicioTable', 'default', 'App', 1778559049, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `categoria_id` int(10) UNSIGNED NOT NULL,
  `marca_id` int(10) UNSIGNED DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion_corta` varchar(500) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_texto` varchar(100) NOT NULL DEFAULT 'Consultar precio',
  `precio_numero` decimal(12,2) UNSIGNED DEFAULT NULL,
  `badge` varchar(50) NOT NULL DEFAULT '',
  `icono` varchar(80) NOT NULL DEFAULT 'fas fa-box',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `orden` smallint(6) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `marca_id`, `nombre`, `descripcion_corta`, `descripcion`, `precio_texto`, `precio_numero`, `badge`, `icono`, `activo`, `destacado`, `orden`, `created_at`, `updated_at`) VALUES
(2, 5, NULL, 'Mouse Logitech', 'Mouse logitech de color negro ', 'Más descripción', 'Consultar precio', NULL, 'Nuevo', 'fas fa-box', 1, 1, 0, '2026-05-12 04:19:09', '2026-05-12 05:05:50'),
(3, 5, NULL, 'Teclado Mecánico ', 'Teclado Mecánico ReDragon', 'Este teclado es de prueba', '65.000', NULL, 'Más vendido', 'fas fa-box', 1, 1, 0, '2026-05-12 05:11:54', '2026-05-12 05:12:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagenes`
--

CREATE TABLE `producto_imagenes` (
  `id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `ruta` varchar(500) NOT NULL,
  `alt_text` varchar(200) DEFAULT NULL,
  `es_principal` tinyint(1) NOT NULL DEFAULT 0,
  `orden` smallint(6) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_imagenes`
--

INSERT INTO `producto_imagenes` (`id`, `producto_id`, `ruta`, `alt_text`, `es_principal`, `orden`, `created_at`, `updated_at`) VALUES
(3, 2, 'assets/img/productos/producto_2_1778560429.jpg', 'Mouse Logitech', 1, 0, '2026-05-12 04:33:49', '2026-05-12 04:33:49'),
(4, 2, 'assets/img/productos/producto_2_1778562280_961.jpg', 'Mouse Logitech', 0, 0, '2026-05-12 05:04:40', '2026-05-12 05:04:40'),
(5, 3, 'assets/img/productos/producto_3_1778562714_865.jpg', 'Teclado Mecánico ', 1, 0, '2026-05-12 05:11:54', '2026-05-12 05:12:12'),
(6, 3, 'assets/img/productos/producto_3_1778562714_330.jpg', 'Teclado Mecánico ', 0, 0, '2026-05-12 05:11:54', '2026-05-12 05:12:12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email` (`email`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_parent_slug` (`parent_id`,`slug`),
  ADD KEY `idx_nivel` (`nivel`),
  ADD KEY `idx_activo` (`activo`);

--
-- Indices de la tabla `consultas_servicio`
--
ALTER TABLE `consultas_servicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_estado_fecha` (`estado`,`created_at`);

--
-- Indices de la tabla `contacto_mensajes`
--
ALTER TABLE `contacto_mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_leido_fecha` (`leido`,`created_at`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_slug` (`slug`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_prod_categoria` (`categoria_id`),
  ADD KEY `idx_prod_marca` (`marca_id`),
  ADD KEY `idx_activo_orden` (`activo`,`orden`),
  ADD KEY `idx_precio` (`precio_numero`);

--
-- Indices de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_prod_principal` (`producto_id`,`es_principal`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `consultas_servicio`
--
ALTER TABLE `consultas_servicio`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `contacto_mensajes`
--
ALTER TABLE `contacto_mensajes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `fk_cat_parent` FOREIGN KEY (`parent_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_prod_cat` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `fk_prod_marca` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD CONSTRAINT `fk_img_prod` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
