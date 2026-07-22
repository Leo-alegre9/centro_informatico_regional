# Página individual de producto + rediseño de tarjetas del catálogo

Resumen: se reemplazó el modal de producto por una página de detalle propia y permanente (`/producto/<slug>`), se rediseñaron las tarjetas del catálogo, y se amplió la base de datos para soportar medidas, material, colores y características técnicas por producto.

## Migraciones de base de datos (ejecutar `php spark migrate` en el servidor)

- `app/Database/Migrations/2026-07-21-000001_AddSlugToProductos.php` — agrega columna `slug` (VARCHAR 220, único, nullable) a `productos`.
- `app/Database/Migrations/2026-07-21-000002_AddMedidasYMaterialToProductos.php` — agrega `ancho`, `alto`, `profundidad` (DECIMAL 8,2 nullable), `unidad_medida` (VARCHAR 10, default `cm`) y `material` (VARCHAR 150 nullable) a `productos`.
- `app/Database/Migrations/2026-07-21-000003_CreateColoresTable.php` — crea tabla `colores` (id, nombre único, hex, timestamps).
- `app/Database/Migrations/2026-07-21-000004_CreateProductoColoresTable.php` — crea tabla pivote `producto_colores` (producto_id + color_id, FKs cascade, único por par).

Después de migrar, hay que completar el slug de los productos que ya existían (ver sección siguiente).

### Backfill de slugs

**Si tenés SSH:**
```bash
php spark productos:backfill-slugs
```
Genera el slug de cada producto sin slug a partir del nombre (con manejo de acentos y desambiguación automática `-2`, `-3`, ...). Es el método recomendado, hacelo apenas subas el código y antes de anunciar las URLs nuevas.

**Si NO tenés SSH (aplicar manualmente en phpMyAdmin):** ejecutar en este orden, después de correr las 4 migraciones de arriba.

```sql
-- 1) Generar un slug aproximado a partir del nombre para los productos que no tengan
UPDATE productos
SET slug = LOWER(TRIM(BOTH '-' FROM REGEXP_REPLACE(REGEXP_REPLACE(nombre, '[^a-zA-Z0-9]+', '-'), '-+', '-')))
WHERE slug IS NULL OR slug = '';

-- 2) Desambiguar los que hayan quedado duplicados agregando el id como sufijo
UPDATE productos p
JOIN (
    SELECT slug FROM productos GROUP BY slug HAVING COUNT(*) > 1
) dup ON dup.slug = p.slug
SET p.slug = CONCAT(p.slug, '-', p.id);
```

> Nota: esta versión SQL convierte cualquier carácter acentuado en guion (ej. "Mecánico" → "mec-nico") en vez de transliterarlo como hace el comando `spark`. Funciona para tener slugs únicos ya, pero si más adelante tenés acceso SSH conviene correr `php spark productos:backfill-slugs` una vez — no pisa los slugs ya asignados manualmente porque solo actualiza filas con `slug` vacío.

### Verificación

```sql
DESCRIBE productos;
DESCRIBE colores;
DESCRIBE producto_colores;
SELECT id, nombre, slug FROM productos ORDER BY id;
SELECT slug, COUNT(*) FROM productos GROUP BY slug HAVING COUNT(*) > 1; -- debe devolver 0 filas
```

Si usás phpMyAdmin y no corriste las migraciones vía `php spark migrate`, recordá además insertar el historial en la tabla `migrations` (mismo procedimiento documentado en `CAMBIOS-ULTIMO-COMMIT.md`) para que un futuro `php spark migrate` no intente reaplicarlas.

## Rutas nuevas

- `GET /producto/(:segment)` → `Producto::detalle` — resuelve por `slug`; si no matchea y el valor es numérico, hace fallback por `id` (compatibilidad con productos sin slug o enlaces viejos).

## Archivos nuevos

- `app/Controllers/Producto.php` — controlador de la página de detalle (resuelve slug/id, arma breadcrumb, imágenes, colores, características, link de WhatsApp).
- `app/Models/ColorModel.php` — tabla `colores` + pivote `producto_colores`, con `sincronizarProducto()` (get-or-create por nombre).
- `app/Models/CaracteristicaModel.php` — tabla `producto_caracteristicas` (ya existía sin usarse), con `sincronizarProducto()`.
- `app/Views/producto_detalle.php` — ficha pública del producto (galería + info a dos columnas, colores, medidas, material, características, disponibilidad, WhatsApp).
- `app/Commands/BackfillProductoSlugs.php` — comando `php spark productos:backfill-slugs`.
- Las 4 migraciones listadas arriba.

## Archivos modificados

- `app/Config/Routes.php` — nueva ruta `producto/(:segment)`.
- `app/Models/ProductoModel.php` — nuevos campos en `$allowedFields`; `generarSlugUnico()` y `getBySlugOrId()`.
- `app/Controllers/Catalogo.php` — `browse()` ahora incluye `slug` en los productos de categoría hoja; `buscar()` (AJAX) incluye `slug`; `buscar()` (resultados de página) genera `url_producto` en vez del anchor a `#producto-N`.
- `app/Controllers/Admin/Productos.php` — alta/edición maneja slug (autogenerado si se deja vacío), medidas, material, colores y características; helpers `parseColores()`/`parseCaracteristicas()`.
- `app/Views/admin/productos/form.php` — campos nuevos: slug (con auto-slug JS no bloqueante), ancho/alto/profundidad/unidad, material, colores (tags separados por coma), características (filas dinámicas clave/valor).
- `app/Views/componentes/header.php` — soporte opcional de `<meta name="description">` vía `$metaDescripcion`.
- `app/Views/catalogo_rubro.php` — se quitó el include del modal.
- `app/Views/contenido/catalogo_grid.php` — tarjetas rediseñadas: enlazan a `/producto/<slug>`, botón "Ver producto" + WhatsApp, descripción con `line-clamp-2`, ya no dependen del modal.
- `app/Views/componentes/productos_seccion.php` — mismo cambio de enlace/quita de modal en las tarjetas de secciones destacadas.
- `app/Views/catalogo_buscar.php` — el botón de resultado ahora linkea a `/producto/<slug>` en vez de `catalogo/.../#producto-N`.
- `app/Views/contenido/catalogo_header.php` — el panel de búsqueda en vivo del header navega a la página de producto en vez de abrir el modal.

## Archivos eliminados

- `app/Views/componentes/modal_producto.php` — reemplazado por la página de detalle.

## ⚠️ Antes de anunciar las URLs nuevas en producción

- **Stock por defecto es 0.** La ficha pública ahora muestra "Disponible" / "Sin stock por el momento" según `stock > 0`. Si nunca cargaron el stock de sus productos, todos van a mostrar "Sin stock" — conviene revisar y cargar valores reales en el panel antes de que los visitantes vean las fichas.
- Confirmar que el backfill de slugs corrió sin duplicados (última consulta de verificación de arriba).
- Si el hosting no tiene HTTPS/dominio final todavía, el link de WhatsApp arma la URL completa del producto con `current_url()` — verificar que `baseURL` en `.env` de producción sea el dominio real antes de compartir los links.
