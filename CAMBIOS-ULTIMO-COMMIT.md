# Cambios del commit `3d11f84` — "Agregado sección de fábricas para muebles en el panel de administrador"

Commit: `3d11f845531f885f6b4f5aa91fcf09cce1ff2f0e`
Fecha: 2026-07-18
82 archivos modificados (3435 inserciones, 7732 eliminaciones)

> Para actualizar Hostinger: subí los archivos listados abajo (respetando las rutas) y corré las migraciones pendientes. Ver **⚠️ Atención especial** al final antes de sobrescribir el `.htaccess` de `public/`.

## Migraciones de base de datos (ejecutar `php spark migrate` en el servidor)

- `app/Database/Migrations/2026-06-04-231235_AddUrlFabricanteToProductos.php` — agrega columna `url_fabricante` (VARCHAR 500, nullable) a `productos`.
- `app/Database/Migrations/2026-07-16-000001_CreateFabricasTable.php` — crea tabla `fabricas` (id, nombre, slug único, activo, timestamps).
- `app/Database/Migrations/2026-07-16-000002_AddFabricaIdToProductos.php` — agrega columna `fabrica_id` a `productos` con FK hacia `fabricas.id` (ON DELETE SET NULL).

Si en Hostinger no tenés acceso SSH a `php spark`, hay que aplicar el equivalente en SQL manualmente vía phpMyAdmin.

## Archivos nuevos

### Config / raíz
- `.htaccess` (nuevo, en la raíz del proyecto) — redirige todo a `public/`.

### Controladores
- `app/Controllers/Admin/Fabricas.php` — CRUD de fábricas.
- `app/Controllers/Pages.php` — páginas legales (política de privacidad, condiciones de servicio).
- `app/Controllers/Promociones.php` — página de promociones.

### Modelos
- `app/Models/FabricaModel.php`

### Vistas — administración
- `app/Views/admin/fabricas/form.php`
- `app/Views/admin/fabricas/index.php`

### Vistas — públicas
- `app/Views/catalogo_buscar.php`
- `app/Views/componentes/tailwind_config.php` — config compartida de Tailwind (incluida desde los `<head>`).
- `app/Views/contenido/ofertas.php`
- `app/Views/legal/condiciones_servicio.php`
- `app/Views/legal/politica_privacidad.php`
- `app/Views/promociones.php`

### Assets / imágenes
- `public/assets/img/marcas/Epson.png`
- `public/assets/img/marcas/Intel.png`
- `public/assets/img/marcas/LG.png`
- `public/assets/img/marcas/adata.png`
- `public/assets/img/marcas/amd.png`
- `public/assets/img/marcas/benq.png`
- `public/assets/img/marcas/hikvision.png`
- `public/assets/img/marcas/hp.png`
- `public/assets/img/marcas/logitech.png`
- `public/assets/img/marcas/samsung.png`
- `public/assets/img/marcas/tplink.png`
- `public/assets/img/perfiles/hernan.png`
- `public/assets/img/perfiles/pilito.jpeg` (reemplaza a `perfil_pilito.jpeg`, ver abajo)
- `public/assets/img/productos/producto_6_1781237525_191.jpg`
- `public/assets/img/productos/producto_6_1781237525_450.jpg`
- `public/assets/img/productos/producto_6_1781237525_696.jpg`

## Archivos eliminados

- `public/assets/img/perfiles/perfil_pilito.jpeg` (renombrado a `pilito.jpeg`)

## Archivos modificados

### Config
- `app/Config/Filters.php` — se quitó `toolbar` (debug toolbar) del filtro `after`. **Correcto para producción**, no requiere acción extra.
- `app/Config/Routes.php` — nuevas rutas: `admin/fabricas*`, `promociones`, `politica-privacidad`, `condiciones-servicio`.
- `public/.htaccess` — ⚠️ ver sección de atención especial abajo.

### Controladores
- `app/Controllers/Admin/Productos.php`
- `app/Controllers/Catalogo.php`
- `app/Controllers/Home.php`

### Modelos
- `app/Models/ProductoModel.php`

### Vistas — administración (Aca seguir)
- `app/Views/admin/categorias/form.php`
- `app/Views/admin/categorias/index.php`
- `app/Views/admin/configuracion/index.php`
- `app/Views/admin/consultas/index.php`
- `app/Views/admin/dashboard.php`
- `app/Views/admin/inventario/index.php`
- `app/Views/admin/layout.php`
- `app/Views/admin/login.php`
- `app/Views/admin/marcas/form.php`
- `app/Views/admin/marcas/index.php`
- `app/Views/admin/productos/buscar.php`
- `app/Views/admin/productos/form.php`
- `app/Views/admin/productos/index.php`
- `app/Views/admin/stock/index.php`

### Vistas — públicas / componentes
- `app/Views/componentes/base.php`
- `app/Views/componentes/carrusel_destacados.php`
- `app/Views/componentes/footer.php`
- `app/Views/componentes/header.php`
- `app/Views/componentes/mega_nav_panel.php`
- `app/Views/componentes/modal_producto.php`
- `app/Views/componentes/navbar.php`
- `app/Views/componentes/productos_seccion.php`
- `app/Views/contenido/catalogo_grid.php`
- `app/Views/contenido/catalogo_header.php`
- `app/Views/contenido/catalogo_subrubros.php`
- `app/Views/contenido/contacto_form.php`
- `app/Views/contenido/contacto_hero.php`
- `app/Views/contenido/contacto_rapido.php`
- `app/Views/contenido/destacados.php`
- `app/Views/contenido/hero.php`
- `app/Views/contenido/marcas.php`
- `app/Views/contenido/nosotros_hero.php`
- `app/Views/contenido/nosotros_propuesta.php`
- `app/Views/contenido/nosotros_quienes.php`
- `app/Views/contenido/rubros.php`
- `app/Views/contenido/servicio_tecnico.php`
- `app/Views/contenido/servicio_tecnico_detalle.php`
- `app/Views/contenido/stats.php`
- `app/Views/contenido/ubicacion.php`
- `app/Views/inicio.php`

## ⚠️ Atención especial antes de subir a Hostinger

**`public/.htaccess` — `RewriteBase` cambiado a una ruta local:**

```diff
- # RewriteBase /
+ RewriteBase /centro_informatico/public/
```

Ese valor (`/centro_informatico/public/`) corresponde al entorno local de XAMPP, no a Hostinger. Si subís este archivo tal cual, el sitio en producción probablemente rompa el ruteo. Antes de subirlo a Hostinger:

- Si el dominio apunta directo a la carpeta `public/` como raíz web, dejá `RewriteBase /` (comentado o descomentado según corresponda) en vez del valor local.
- Si en Hostinger el proyecto vive en una subcarpeta, ajustá `RewriteBase` a esa ruta real del hosting.

También revisá el `.env` de producción (no versionado) para confirmar `baseURL`, credenciales de base de datos y `CI_ENVIRONMENT = production`, ya que no forman parte de este commit pero son necesarios para que los cambios funcionen correctamente en Hostinger.

---

# 🆕 Cambios adicionales (todavía sin commitear)

## Archivos modificados

- `app/Config/Routes.php`
- `app/Models/ProductoModel.php`
- `app/Controllers/Catalogo.php`
- `app/Controllers/Admin/Productos.php`
- `app/Views/admin/productos/form.php`
- `app/Views/componentes/header.php`
- `app/Views/componentes/navbar.php`
- `app/Views/catalogo_rubro.php`
- `app/Views/contenido/catalogo_grid.php`
- `app/Views/componentes/productos_seccion.php`
- `app/Views/catalogo_buscar.php`
- `app/Views/contenido/catalogo_header.php`

## Archivos nuevos

- `app/Controllers/Producto.php`
- `app/Models/ColorModel.php`
- `app/Models/CaracteristicaModel.php`
- `app/Views/producto_detalle.php`
- `app/Commands/BackfillProductoSlugs.php`
- `app/Database/Migrations/2026-07-21-000001_AddSlugToProductos.php`
- `app/Database/Migrations/2026-07-21-000002_AddMedidasYMaterialToProductos.php`
- `app/Database/Migrations/2026-07-21-000003_CreateColoresTable.php`
- `app/Database/Migrations/2026-07-21-000004_CreateProductoColoresTable.php`

## Archivos eliminados

- `app/Views/componentes/modal_producto.php`

## SQL para phpMyAdmin

```sql
ALTER TABLE `productos`
  ADD COLUMN `slug` VARCHAR(220) NULL DEFAULT NULL AFTER `nombre`;

ALTER TABLE `productos` ADD UNIQUE KEY `productos_slug_unique` (`slug`);

ALTER TABLE `productos`
  ADD COLUMN `ancho` DECIMAL(8,2) UNSIGNED NULL DEFAULT NULL AFTER `stock`,
  ADD COLUMN `alto` DECIMAL(8,2) UNSIGNED NULL DEFAULT NULL AFTER `ancho`,
  ADD COLUMN `profundidad` DECIMAL(8,2) UNSIGNED NULL DEFAULT NULL AFTER `alto`,
  ADD COLUMN `unidad_medida` VARCHAR(10) NULL DEFAULT 'cm' AFTER `profundidad`,
  ADD COLUMN `material` VARCHAR(150) NULL DEFAULT NULL AFTER `unidad_medida`;

CREATE TABLE `colores` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(60) NOT NULL,
  `hex` VARCHAR(7) NULL DEFAULT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `colores_nombre_unique` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `producto_colores` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id` INT UNSIGNED NOT NULL,
  `color_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `producto_colores_producto_id_color_id_unique` (`producto_id`, `color_id`),
  KEY `producto_colores_producto_id_foreign` (`producto_id`),
  KEY `producto_colores_color_id_foreign` (`color_id`),
  CONSTRAINT `producto_colores_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `producto_colores_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

UPDATE productos
SET slug = LOWER(TRIM(BOTH '-' FROM REGEXP_REPLACE(REGEXP_REPLACE(nombre, '[^a-zA-Z0-9]+', '-'), '-+', '-')))
WHERE slug IS NULL OR slug = '';

UPDATE productos p
JOIN (
    SELECT slug FROM productos GROUP BY slug HAVING COUNT(*) > 1
) dup ON dup.slug = p.slug
SET p.slug = CONCAT(p.slug, '-', p.id);

SET @next_batch = (SELECT COALESCE(MAX(batch), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
('2026-07-21-000001', 'App\\Database\\Migrations\\AddSlugToProductos', 'default', 'App', UNIX_TIMESTAMP(), @next_batch),
('2026-07-21-000002', 'App\\Database\\Migrations\\AddMedidasYMaterialToProductos', 'default', 'App', UNIX_TIMESTAMP(), @next_batch),
('2026-07-21-000003', 'App\\Database\\Migrations\\CreateColoresTable', 'default', 'App', UNIX_TIMESTAMP(), @next_batch),
('2026-07-21-000004', 'App\\Database\\Migrations\\CreateProductoColoresTable', 'default', 'App', UNIX_TIMESTAMP(), @next_batch);
```




## 🗄️ Paso a paso: aplicar las migraciones manualmente en phpMyAdmin

Si en Hostinger no tenés acceso SSH para correr `php spark migrate`, seguí estos pasos para dejar la base de datos igual que en local. Hay **3 migraciones** pendientes de este commit, y hay que aplicarlas **en este orden** (la tabla `fabricas` tiene que existir antes de crear la FK en `productos`).

### 1. Entrar a phpMyAdmin y seleccionar la base

Entrá a phpMyAdmin desde el panel de Hostinger, seleccioná la base de datos de producción (equivalente a `cir2` en local) y andá a la pestaña **SQL**.

### 2. Ejecutar los cambios de estructura

Pegá y ejecutá los siguientes bloques, uno por uno (podés pegarlos todos juntos también, ya que están en el orden correcto):

```sql
-- Migración 2026-06-04-231235_AddUrlFabricanteToProductos
ALTER TABLE `productos`
  ADD COLUMN `url_fabricante` VARCHAR(500) NULL DEFAULT NULL AFTER `descripcion`;

-- Migración 2026-07-16-000001_CreateFabricasTable
CREATE TABLE `fabricas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fabricas_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Migración 2026-07-16-000002_AddFabricaIdToProductos (columna)
ALTER TABLE `productos`
  ADD COLUMN `fabrica_id` INT UNSIGNED NULL DEFAULT NULL AFTER `marca_id`;

-- Migración 2026-07-16-000002_AddFabricaIdToProductos (foreign key)
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_fabrica_id_foreign`
  FOREIGN KEY (`fabrica_id`) REFERENCES `fabricas` (`id`) ON DELETE SET NULL;
```

> Si `productos` no tiene una columna `marca_id` (por ejemplo, en un entorno distinto), quitá el `AFTER \`marca_id\`` del segundo `ALTER TABLE` — el orden de la columna no afecta el funcionamiento.

### 3. Marcar las migraciones como ejecutadas

CodeIgniter registra cada migración corrida en la tabla `migrations`. Si no la insertás, la próxima vez que alguien corra `php spark migrate` (por SSH o localmente contra esa base) va a intentar aplicar estas 3 migraciones de nuevo y va a fallar porque las columnas/tabla ya existen.

Si la tabla `migrations` **no existe todavía** en esa base (primer deploy con migraciones), creala primero:

```sql
CREATE TABLE `migrations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` VARCHAR(255) NOT NULL,
  `class` VARCHAR(255) NOT NULL,
  `group` VARCHAR(255) NOT NULL,
  `namespace` VARCHAR(255) NOT NULL,
  `time` INT(11) NOT NULL,
  `batch` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

Luego insertá el historial de las 3 migraciones (esto no modifica ninguna tabla de datos, solo le dice a CodeIgniter "esto ya se aplicó"):

```sql
SET @next_batch = (SELECT COALESCE(MAX(batch), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
('2026-06-04-231235', 'App\\Database\\Migrations\\AddUrlFabricanteToProductos', 'default', 'App', UNIX_TIMESTAMP(), @next_batch),
('2026-07-16-000001', 'App\\Database\\Migrations\\CreateFabricasTable',        'default', 'App', UNIX_TIMESTAMP(), @next_batch),
('2026-07-16-000002', 'App\\Database\\Migrations\\AddFabricaIdToProductos',    'default', 'App', UNIX_TIMESTAMP(), @next_batch);
```

### 4. Verificar

```sql
SELECT * FROM `migrations` ORDER BY `id` DESC LIMIT 5;
DESCRIBE `productos`;
DESCRIBE `fabricas`;
```

Confirmá que `productos` tenga las columnas `url_fabricante` y `fabrica_id`, y que `fabricas` exista con sus columnas y el índice único en `slug`.

### 5. (Alternativa) Si sí tenés acceso SSH

Si en algún momento tenés SSH en Hostinger, es más simple correr directamente:

```bash
php spark migrate
```

Esto aplica las 3 migraciones y registra el historial automáticamente, sin necesidad de nada de lo anterior.

---

# Archivos modificados 26-07-26

## Migraciones de base de datos (ejecutar `php spark migrate` en el servidor)

- `app/Database/Migrations/2026-07-24-000001_CreateLineasTable.php` — crea tabla `lineas` (id, fabrica_id, nombre, slug, activo, timestamps; único `fabrica_id+slug`; FK `fabrica_id` → `fabricas.id` ON DELETE CASCADE).
- `app/Database/Migrations/2026-07-24-000002_AddLineaIdToProductos.php` — agrega columna `linea_id` (INT unsigned, nullable, después de `fabrica_id`) a `productos` con FK hacia `lineas.id` (ON DELETE SET NULL).
- `app/Database/Migrations/2026-07-24-000003_CreateProductoColorVariantesTable.php` — crea tabla `producto_color_variantes` (id, producto_id, nombre, tipo ENUM('simple','combinado','textura'), color_primario, color_secundario, imagen_muestra, orden, activo, timestamps; índice `producto_id+activo+orden`; FK `producto_id` → `productos.id` ON DELETE CASCADE).
- `app/Database/Migrations/2026-07-24-000004_CreateProductoColorImagenesTable.php` — crea tabla `producto_color_imagenes` (id, producto_color_id, imagen, texto_alternativo, es_principal, orden, activo, timestamps; índice `producto_color_id+activo+orden`; FK `producto_color_id` → `producto_color_variantes.id` ON DELETE CASCADE).

## Archivos nuevos

### Controladores
- `app/Controllers/Admin/Lineas.php`

### Modelos
- `app/Models/ColorImagenModel.php`
- `app/Models/ColorVarianteModel.php`
- `app/Models/LineaModel.php`

### Vistas — administración
- `app/Views/admin/lineas/form.php`
- `app/Views/admin/lineas/index.php`

### Assets / imágenes
- `public/assets/img/productos/color_galeria_1_1784912822_622.webp`
- `public/assets/img/productos/color_galeria_2_1784912822_686.png`
- `public/assets/img/productos/producto_6_1784876280_191.jpg`
- `public/assets/img/productos/producto_6_1784876280_244.jpg`
- `public/assets/img/productos/producto_6_1784876280_467.jpg`
- `public/assets/img/productos/producto_6_1784876280_539.jpg`
- `public/assets/img/productos/producto_6_1784876280_666.jpg`
- `public/assets/img/productos/producto_6_1784876280_847.jpg`
- `public/assets/img/productos/producto_6_1784876280_894.jpg`
- `public/assets/img/productos/color_galeria_3_1785080542_766.jpg`
- `public/assets/img/productos/color_galeria_4_1785080542_882.jpg`
- `public/assets/img/productos/producto_7_1785080612_918.png`

## Archivos modificados

- `app/Config/Routes.php`
- `app/Controllers/Admin/Productos.php`
- `app/Controllers/Catalogo.php`
- `app/Controllers/Producto.php`
- `app/Models/ColorModel.php`
- `app/Models/ProductoModel.php`
- `app/Views/admin/fabricas/index.php`
- `app/Views/admin/productos/form.php`
- `app/Views/contenido/catalogo_grid.php`
- `app/Views/producto_detalle.php`

## Archivos eliminados

- `public/assets/img/productos/producto_2_1778560429.jpg`
- `public/assets/img/productos/producto_3_1778562714_865.jpg`
- `public/assets/img/productos/producto_4_1778712497_274.jpg`

## SQL para phpMyAdmin

```sql
CREATE TABLE `lineas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fabrica_id` INT UNSIGNED NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lineas_fabrica_id_slug` (`fabrica_id`, `slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `lineas`
  ADD CONSTRAINT `lineas_fabrica_id_foreign`
  FOREIGN KEY (`fabrica_id`) REFERENCES `fabricas` (`id`) ON DELETE CASCADE;

ALTER TABLE `productos`
  ADD COLUMN `linea_id` INT UNSIGNED NULL DEFAULT NULL AFTER `fabrica_id`;

ALTER TABLE `productos`
  ADD CONSTRAINT `productos_linea_id_foreign`
  FOREIGN KEY (`linea_id`) REFERENCES `lineas` (`id`) ON DELETE SET NULL;

CREATE TABLE `producto_color_variantes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id` INT UNSIGNED NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `tipo` ENUM('simple','combinado','textura') NOT NULL DEFAULT 'simple',
  `color_primario` VARCHAR(7) NULL DEFAULT NULL,
  `color_secundario` VARCHAR(7) NULL DEFAULT NULL,
  `imagen_muestra` VARCHAR(500) NULL DEFAULT NULL,
  `orden` SMALLINT NOT NULL DEFAULT 0,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `producto_color_variantes_producto_id_activo_orden` (`producto_id`, `activo`, `orden`),
  CONSTRAINT `producto_color_variantes_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `producto_color_imagenes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_color_id` INT UNSIGNED NOT NULL,
  `imagen` VARCHAR(500) NOT NULL,
  `texto_alternativo` VARCHAR(200) NULL DEFAULT NULL,
  `es_principal` TINYINT(1) NOT NULL DEFAULT 0,
  `orden` SMALLINT NOT NULL DEFAULT 0,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `producto_color_imagenes_producto_color_id_activo_orden` (`producto_color_id`, `activo`, `orden`),
  CONSTRAINT `producto_color_imagenes_producto_color_id_foreign` FOREIGN KEY (`producto_color_id`) REFERENCES `producto_color_variantes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET @next_batch = (SELECT COALESCE(MAX(batch), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
('2026-07-24-000001', 'App\\Database\\Migrations\\CreateLineasTable', 'default', 'App', UNIX_TIMESTAMP(), @next_batch),
('2026-07-24-000002', 'App\\Database\\Migrations\\AddLineaIdToProductos', 'default', 'App', UNIX_TIMESTAMP(), @next_batch),
('2026-07-24-000003', 'App\\Database\\Migrations\\CreateProductoColorVariantesTable', 'default', 'App', UNIX_TIMESTAMP(), @next_batch),
('2026-07-24-000004', 'App\\Database\\Migrations\\CreateProductoColorImagenesTable', 'default', 'App', UNIX_TIMESTAMP(), @next_batch);
```

---

# Cambios recientes

- `app/Controllers/Home.php`
- `app/Controllers/Producto.php`
- `app/Controllers/Promociones.php`
- `app/Views/componentes/carrusel_destacados.php`
- `app/Views/contenido/destacados.php`
- `app/Views/contenido/ofertas.php`
- `app/Views/producto_detalle.php`
- `app/Views/promociones.php`

---

# Ultimos cambimos del día

## Migraciones de base de datos (ejecutar `php spark migrate` en el servidor)

- `app/Database/Migrations/2026-07-26-000001_AddPrecioInternoToProductos.php`
- `app/Database/Migrations/2026-07-26-000002_CreateNotasTable.php`

## Archivos nuevos

- `app/Controllers/Admin/Notas.php`
- `app/Models/NotaModel.php`
- `app/Views/admin/notas/index.php`
- `app/Views/admin/productos/ver.php`
- `public/assets/img/productos/producto_7_1785103483_439.jpg`
- `public/assets/img/productos/producto_7_1785103483_699.jpg`
- `public/assets/img/productos/producto_7_1785103484_113.jpg`
- `public/assets/img/productos/producto_7_1785103484_345.png`

## Archivos modificados

- `app/Config/Routes.php`
- `app/Controllers/Admin/Consultas.php`
- `app/Controllers/Admin/Productos.php`
- `app/Models/ProductoModel.php`
- `app/Views/admin/consultas/index.php`
- `app/Views/admin/layout.php`
- `app/Views/admin/productos/form.php`
- `app/Views/admin/productos/index.php`
- `app/Views/componentes/carrusel_destacados.php`
- `app/Views/contenido/destacados.php`

## SQL para phpMyAdmin

```sql
ALTER TABLE `productos`
  ADD COLUMN `precio_interno` DECIMAL(12,2) UNSIGNED NULL DEFAULT NULL AFTER `precio_dolar`;

CREATE TABLE `notas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `autor` VARCHAR(100) NOT NULL,
  `contenido` TEXT NOT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notas_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET @next_batch = (SELECT COALESCE(MAX(batch), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
('2026-07-26-000001', 'App\\Database\\Migrations\\AddPrecioInternoToProductos', 'default', 'App', UNIX_TIMESTAMP(), @next_batch),
('2026-07-26-000002', 'App\\Database\\Migrations\\CreateNotasTable', 'default', 'App', UNIX_TIMESTAMP(), @next_batch);
```

---

# Archivos modificados - 28-07-26

- `app/Views/admin/layout.php`
- `app/Views/admin/login.php`
- `app/Views/componentes/header.php`
- `public/favicon.ico`

## Archivos nuevos

- `public/assets/img/CIR_favicon.png`

---

# Actualizaciones 29-07-2026

## Migraciones de base de datos (ejecutar `php spark migrate` en el servidor)

- `app/Database/Migrations/2026-07-29-000001_AddNombreIndexToProductos.php`

## Archivos nuevos

- `app/Views/componentes/paginador.php`

## Archivos modificados

- `app/Models/ProductoModel.php`
- `app/Models/CategoriaModel.php`
- `app/Controllers/Catalogo.php`
- `app/Controllers/Admin/Productos.php`
- `app/Views/catalogo_buscar.php`
- `app/Views/catalogo_rubro.php`
- `app/Views/contenido/catalogo_grid.php`
- `app/Views/admin/productos/buscar.php`
- `app/Views/admin/productos/ver.php`

---

# Cambios - 13-08-2026

Módulo de presupuestos/listados (público + admin), PDF de presupuesto y actualización de logos en el sitio.

## Migraciones de base de datos (ejecutar `php spark migrate` en el servidor)

- `app/Database/Migrations/2026-08-13-000001_CreatePresupuestosTable.php` — crea las tablas `presupuestos` y `presupuesto_detalles`.
- `app/Database/Migrations/2026-08-13-000002_AddTipoToPresupuestos.php` — agrega columna `tipo` ENUM('presupuesto','listado') a `presupuestos`, después de `token`.

## Archivos nuevos

### Controladores
- `app/Controllers/Admin/Presupuestos.php`
- `app/Controllers/PresupuestoPublico.php`

### Modelos
- `app/Models/PresupuestoModel.php`
- `app/Models/PresupuestoDetalleModel.php`

### Librerías / helpers
- `app/Libraries/PresupuestoPdf.php` — arma el PDF del presupuesto (Dompdf) compartido entre el panel admin y la vista pública.
- `app/Helpers/whatsapp_helper.php`

### Vistas — administración
- `app/Views/admin/presupuestos/index.php`
- `app/Views/admin/presupuestos/form.php`
- `app/Views/admin/presupuestos/ver.php`
- `app/Views/admin/presupuestos/pdf.php`

### Vistas — públicas / componentes
- `app/Views/presupuesto_publico.php`
- `app/Views/presupuesto_producto.php`
- `app/Views/componentes/base_presupuesto.php`
- `app/Views/componentes/presupuesto_footer.php`

### Assets / imágenes
- `public/assets/img/logo_cir_nuevo.png` — logo nuevo sin fondo blanco, usado en el header/footer del presupuesto público, el detalle de producto del presupuesto y el PDF.
- `public/assets/img/isologo_cir.png` — isologo (solo ícono, sin fondo) usado en el sidebar del panel admin.

## Archivos modificados

- `app/Config/Routes.php` — rutas del módulo de presupuestos (admin + público).
- `app/Views/admin/layout.php` — logo del sidebar reemplazado por `isologo_cir.png`, tamaño responsivo (`max-w-[140px] sm:max-w-[160px]`).
- `app/Views/admin/categorias/form.php`
- `app/Views/admin/categorias/index.php`
- `app/Views/admin/configuracion/index.php`
- `app/Views/admin/consultas/index.php`
- `app/Views/admin/dashboard.php`
- `app/Views/admin/fabricas/form.php`
- `app/Views/admin/fabricas/index.php`
- `app/Views/admin/inventario/index.php`
- `app/Views/admin/lineas/form.php`
- `app/Views/admin/lineas/index.php`
- `app/Views/admin/login.php`
- `app/Views/admin/marcas/form.php`
- `app/Views/admin/marcas/index.php`
- `app/Views/admin/notas/index.php`
- `app/Views/admin/productos/buscar.php`
- `app/Views/admin/productos/form.php`
- `app/Views/admin/productos/index.php`
- `app/Views/admin/productos/ver.php`
- `app/Views/admin/stock/index.php`
- `composer.json` — dependencia agregada (`dompdf/dompdf`, usada por `PresupuestoPdf.php`).
- `composer.lock`

No hubo archivos eliminados en esta tanda.

## SQL para phpMyAdmin

Pegá y ejecutá los siguientes bloques en la pestaña **SQL** de phpMyAdmin, en este orden (la tabla `presupuestos` tiene que existir antes de poder agregarle la columna `tipo`, y antes de crear la FK de `presupuesto_detalles`).

```sql
-- Migración 2026-08-13-000001_CreatePresupuestosTable
CREATE TABLE `presupuestos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero` VARCHAR(20) NULL DEFAULT NULL,
  `token` VARCHAR(40) NULL DEFAULT NULL,
  `admin_user_id` INT UNSIGNED NULL DEFAULT NULL,
  `cliente_nombre` VARCHAR(150) NOT NULL,
  `cliente_telefono` VARCHAR(30) NOT NULL,
  `cliente_email` VARCHAR(150) NULL DEFAULT NULL,
  `cliente_documento` VARCHAR(30) NULL DEFAULT NULL,
  `fecha` DATE NOT NULL,
  `valido_hasta` DATE NULL DEFAULT NULL,
  `subtotal` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `descuento_tipo` ENUM('monto','porcentaje') NOT NULL DEFAULT 'monto',
  `descuento_valor` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `descuento_monto` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `total` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `observaciones` TEXT NULL DEFAULT NULL,
  `condiciones` TEXT NULL DEFAULT NULL,
  `estado` ENUM('borrador','generado','enviado','aceptado','rechazado') NOT NULL DEFAULT 'borrador',
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `presupuestos_numero` (`numero`),
  UNIQUE KEY `presupuestos_token` (`token`),
  KEY `presupuestos_admin_user_id` (`admin_user_id`),
  KEY `presupuestos_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuestos_admin_user_id_foreign`
  FOREIGN KEY (`admin_user_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

CREATE TABLE `presupuesto_detalles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `presupuesto_id` INT UNSIGNED NOT NULL,
  `producto_id` INT UNSIGNED NULL DEFAULT NULL,
  `producto_nombre` VARCHAR(200) NOT NULL,
  `producto_codigo` VARCHAR(50) NULL DEFAULT NULL,
  `precio_unitario` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `cantidad` INT UNSIGNED NOT NULL DEFAULT 1,
  `subtotal` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `orden` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `presupuesto_detalles_presupuesto_id` (`presupuesto_id`),
  KEY `presupuesto_detalles_producto_id` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `presupuesto_detalles`
  ADD CONSTRAINT `presupuesto_detalles_presupuesto_id_foreign`
  FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `presupuesto_detalles`
  ADD CONSTRAINT `presupuesto_detalles_producto_id_foreign`
  FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Migración 2026-08-13-000002_AddTipoToPresupuestos
ALTER TABLE `presupuestos`
  ADD COLUMN `tipo` ENUM('presupuesto','listado') NOT NULL DEFAULT 'presupuesto' AFTER `token`;
```

Después, insertá el historial de las 2 migraciones (esto solo le dice a CodeIgniter "esto ya se aplicó"; no toca ninguna tabla de datos):

```sql
SET @next_batch = (SELECT COALESCE(MAX(batch), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
('2026-08-13-000001', 'App\\Database\\Migrations\\CreatePresupuestosTable', 'default', 'App', UNIX_TIMESTAMP(), @next_batch),
('2026-08-13-000002', 'App\\Database\\Migrations\\AddTipoToPresupuestos', 'default', 'App', UNIX_TIMESTAMP(), @next_batch);
```

Verificación:

```sql
SELECT * FROM `migrations` ORDER BY `id` DESC LIMIT 5;
DESCRIBE `presupuestos`;
DESCRIBE `presupuesto_detalles`;
```

Confirmá que `presupuestos` tenga la columna `tipo` y que ambas tablas existan con sus FKs (`presupuestos.admin_user_id` → `admin_users.id`, `presupuesto_detalles.presupuesto_id` → `presupuestos.id`, `presupuesto_detalles.producto_id` → `productos.id`).

---

# Cambios - 14-08-2026

Fix del PDF de presupuesto (`Class "Dompdf\Options" not found`) y precarga del precio interno del producto al agregarlo a un presupuesto/listado.

## ⚠️ Atención especial — esto es lo que corrige el error del PDF

El error `Class "Dompdf\Options" not found` **no es un bug de código**: `dompdf/dompdf` se agregó a `composer.json`/`composer.lock` el 13-08-2026 (ver sección anterior), pero la carpeta `vendor/` está en `.gitignore` (no se versiona) y en Hostinger no se corrió `composer install` después de ese cambio, así que el paquete nunca llegó al servidor.

**Para solucionarlo en producción**, sin necesidad de tocar código:

- **Si tenés acceso SSH en Hostinger:** corré `composer install --no-dev` (o `composer update dompdf/dompdf`) parado en la raíz del proyecto en el servidor.
- **Si no tenés SSH:** subí por FTP/administrador de archivos las carpetas nuevas `vendor/dompdf/`, `vendor/php-font-lib/` y `vendor/php-svg-lib/` (están en tu entorno local, recién instaladas), y sobrescribí `vendor/autoload.php` junto con todo `vendor/composer/` por las versiones locales actuales — son los archivos que Composer regeneró al instalar la dependencia.

Ninguno de estos archivos forma parte de este listado de "archivos nuevos/modificados" porque `vendor/` no se versiona en git.

## Archivos modificados

- `app/Controllers/Admin/Presupuestos.php` — el buscador de productos del presupuesto (`buscarProductosJson`) ahora devuelve también `precio_interno`, y `precioInicial()` lo prioriza por sobre el precio público (`precio_numero`/`precio_texto`) al precargar el precio de un producto agregado a un presupuesto o listado. Si el producto no tiene precio interno cargado, sigue cayendo al precio público como antes.
- `app/Views/admin/presupuestos/form.php` — muestra una etiqueta "interno" (con candado) junto al precio en el buscador y en la fila del ítem cuando el precio precargado viene del precio interno del producto, para que quede claro antes de guardar/enviar el presupuesto que ese precio no es el público. El precio sigue siendo editable a mano en todos los casos.

No hubo archivos nuevos ni eliminados en esta tanda.
