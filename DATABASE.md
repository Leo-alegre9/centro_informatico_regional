# Base de Datos — Centro Informático Regional

## Información general

| Parámetro | Valor |
|---|---|
| Motor | MySQL 8.x |
| Nombre de la base | `cir2` |
| Charset | `utf8mb4` |
| Collation | `utf8mb4_unicode_ci` |
| Framework ORM | CodeIgniter 4 Model |

---

## Diagrama de relaciones

```
admin_users
    (sin relaciones externas)

categorias ──────────────────────────┐
    id ◄── parent_id (self-ref.)     │ árbol jerárquico (nivel 1→2→3)
                                     │
marcas                               │
    id ◄────────────────────┐        │
                            │        │
productos ──────────────────┘        │
    id       marca_id (FK)           │
    │        categoria_id (FK) ──────┘
    │
    └──► producto_imagenes
              producto_id (FK)

contacto_mensajes
    (sin relaciones externas)
```

---

## Tablas

---

### 1. `admin_users`

Usuarios con acceso al panel de administración.

| Columna | Tipo | Nulo | Default | Descripción |
|---|---|---|---|---|
| `id` | INT UNSIGNED | NO | AUTO_INCREMENT | PK |
| `nombre` | VARCHAR(100) | NO | | Nombre completo del administrador |
| `email` | VARCHAR(150) | NO | | Email único de acceso |
| `password` | VARCHAR(255) | NO | | Hash bcrypt (password_hash) |
| `rol` | ENUM('superadmin','editor') | NO | `'editor'` | Nivel de permisos |
| `ultimo_acceso` | DATETIME | SÍ | NULL | Última sesión iniciada |
| `activo` | TINYINT(1) | NO | `1` | 0 = cuenta deshabilitada |
| `created_at` | DATETIME | SÍ | NULL | CI4 timestamps |
| `updated_at` | DATETIME | SÍ | NULL | CI4 timestamps |

**Claves:**
- PK: `id`
- UNIQUE: `email`

**Notas:** La contraseña se almacena siempre hasheada. Nunca guardar en texto plano.

---

### 2. `categorias`

Jerarquía de categorías con hasta 3 niveles (rubro → subrubro → sub-subrubro).  
Usa una estructura **self-referencial** (árbol adyacente) que cumple con 3FN.

| Columna | Tipo | Nulo | Default | Descripción |
|---|---|---|---|---|
| `id` | INT UNSIGNED | NO | AUTO_INCREMENT | PK |
| `parent_id` | INT UNSIGNED | SÍ | NULL | FK → `categorias.id`. NULL = nivel 1 (rubro) |
| `nivel` | TINYINT(1) UNSIGNED | NO | | `1` = Rubro, `2` = Subrubro, `3` = Sub-subrubro |
| `nombre` | VARCHAR(200) | NO | | Nombre legible (ej: "Accesorios") |
| `slug` | VARCHAR(100) | NO | | URL-friendly (ej: "accesorios") |
| `icono` | VARCHAR(80) | NO | `'fas fa-tag'` | Clase Font Awesome |
| `descripcion` | TEXT | SÍ | NULL | Descripción visible en catálogo |
| `activo` | TINYINT(1) | NO | `1` | 0 = ocultar del catálogo |
| `orden` | SMALLINT | NO | `0` | Orden de aparición |
| `created_at` | DATETIME | SÍ | NULL | CI4 timestamps |
| `updated_at` | DATETIME | SÍ | NULL | CI4 timestamps |

**Claves:**
- PK: `id`
- FK: `parent_id` → `categorias(id)` ON DELETE SET NULL
- UNIQUE: `(parent_id, slug)` — el slug debe ser único dentro del mismo padre
- INDEX: `nivel`, `activo`, `orden`

**Estructura de niveles:**

```
Nivel 1 — Rubros principales (parent_id = NULL)
  ├─ Informática
  ├─ Muebles
  ├─ Electrodomésticos
  └─ Línea Comercial

Nivel 2 — Subrubros (parent_id = rubro.id)
  Informática → Accesorios, Componentes, Monitores, Seguridad, Conectividad, Impresión
  Muebles     → Oficina, Hogar
  Electro.    → Heladeras, Cocinas, Hornos, Freezers, TVs, Audio
  L. Comerc.  → Frío, Calor, Varios, Amoblamiento Comercial

Nivel 3 — Sub-subrubros (parent_id = subrubro.id) [solo algunos rubros]
  Oficina  → Escritorios, Mesas de PC, Sillas, Bibliotecas, Archiveros, Sillones
  Hogar    → Dormitorio, Livings, Cocina, Baño
  Frío     → Freezers Comerciales, Pozos de Frío, Exhibidoras, Bateas
  Calor    → Cocinas Industriales, Hornos Industriales, Freidoras
  Varios   → Balanzas, Cortadoras de Fiambre, Amasadoras, Freidoras de Aire
  Amoblam. → Góndolas, Estanterías, Paneles Ranurados, Mostradores, Racks, Accesorios
```

---

### 3. `marcas`

Marcas / fabricantes de los productos.

| Columna | Tipo | Nulo | Default | Descripción |
|---|---|---|---|---|
| `id` | INT UNSIGNED | NO | AUTO_INCREMENT | PK |
| `nombre` | VARCHAR(150) | NO | | Nombre de la marca (ej: "Samsung") |
| `slug` | VARCHAR(100) | NO | | URL-friendly (ej: "samsung") |
| `logo_url` | VARCHAR(500) | SÍ | NULL | Ruta relativa al logo en `/public/assets/img/marcas/` |
| `sitio_web` | VARCHAR(300) | SÍ | NULL | URL oficial de la marca |
| `activo` | TINYINT(1) | NO | `1` | 0 = ocultar |
| `created_at` | DATETIME | SÍ | NULL | CI4 timestamps |
| `updated_at` | DATETIME | SÍ | NULL | CI4 timestamps |

**Claves:**
- PK: `id`
- UNIQUE: `slug`

---

### 4. `productos`

Catálogo de productos. Cada producto pertenece a una categoría hoja (nivel 2 o nivel 3).

| Columna | Tipo | Nulo | Default | Descripción |
|---|---|---|---|---|
| `id` | INT UNSIGNED | NO | AUTO_INCREMENT | PK |
| `categoria_id` | INT UNSIGNED | NO | | FK → `categorias(id)` — siempre categoría hoja |
| `marca_id` | INT UNSIGNED | SÍ | NULL | FK → `marcas(id)` |
| `nombre` | VARCHAR(200) | NO | | Nombre del producto |
| `descripcion_corta` | VARCHAR(500) | SÍ | NULL | Resumen breve (para cards) |
| `descripcion` | TEXT | SÍ | NULL | Descripción completa |
| `precio_texto` | VARCHAR(100) | NO | `'Consultar precio'` | Precio visible (texto libre o valor) |
| `precio_numero` | DECIMAL(12,2) UNSIGNED | SÍ | NULL | Precio numérico para ordenar/filtrar (NULL = consultar) |
| `badge` | VARCHAR(50) | NO | `''` | Etiqueta destacada: "Nuevo", "Destacado", etc. |
| `icono` | VARCHAR(80) | NO | `'fas fa-box'` | Clase Font Awesome para placeholder |
| `activo` | TINYINT(1) | NO | `1` | 0 = no mostrar en catálogo |
| `orden` | SMALLINT | NO | `0` | Orden dentro de la categoría |
| `created_at` | DATETIME | SÍ | NULL | CI4 timestamps |
| `updated_at` | DATETIME | SÍ | NULL | CI4 timestamps |

**Claves:**
- PK: `id`
- FK: `categoria_id` → `categorias(id)` ON DELETE RESTRICT
- FK: `marca_id` → `marcas(id)` ON DELETE SET NULL
- INDEX: `categoria_id`, `activo`, `orden`, `precio_numero`

**Notas:**
- `precio_texto` se muestra al cliente (puede ser "$ 45.000" o "Consultar precio").
- `precio_numero` es opcional pero permite filtros y ordenamiento por precio en el futuro.
- `descripcion_corta` se usa en las cards del catálogo; `descripcion` en la vista detalle (a implementar).

---

### 5. `producto_imagenes`

Imágenes de cada producto. Un producto puede tener múltiples imágenes.

| Columna | Tipo | Nulo | Default | Descripción |
|---|---|---|---|---|
| `id` | INT UNSIGNED | NO | AUTO_INCREMENT | PK |
| `producto_id` | INT UNSIGNED | NO | | FK → `productos(id)` |
| `ruta` | VARCHAR(500) | NO | | Ruta relativa: `assets/img/productos/nombre.jpg` |
| `alt_text` | VARCHAR(200) | SÍ | NULL | Texto alternativo para accesibilidad/SEO |
| `es_principal` | TINYINT(1) | NO | `0` | 1 = imagen destacada del producto |
| `orden` | SMALLINT | NO | `0` | Orden en la galería |
| `created_at` | DATETIME | SÍ | NULL | CI4 timestamps |
| `updated_at` | DATETIME | SÍ | NULL | CI4 timestamps |

**Claves:**
- PK: `id`
- FK: `producto_id` → `productos(id)` ON DELETE CASCADE
- INDEX: `producto_id`, `es_principal`

**Notas:**
- Las imágenes se guardan en `public/assets/img/productos/`.
- Solo puede haber una imagen principal por producto (validar en la aplicación).
- Al eliminar un producto, se eliminan todas sus imágenes en cascada.

---

### 6. `contacto_mensajes`

Mensajes recibidos desde el formulario de contacto.

| Columna | Tipo | Nulo | Default | Descripción |
|---|---|---|---|---|
| `id` | INT UNSIGNED | NO | AUTO_INCREMENT | PK |
| `nombre` | VARCHAR(100) | NO | | Nombre del remitente |
| `email` | VARCHAR(150) | NO | | Email del remitente |
| `asunto` | VARCHAR(100) | NO | | Asunto elegido en el formulario |
| `mensaje` | TEXT | NO | | Cuerpo del mensaje |
| `leido` | TINYINT(1) | NO | `0` | 0 = no leído, 1 = leído |
| `ip_remota` | VARCHAR(45) | SÍ | NULL | IP de origen (IPv4/IPv6) |
| `created_at` | DATETIME | SÍ | NULL | Fecha de recepción |

**Claves:**
- PK: `id`
- INDEX: `leido`, `created_at`

---

## Relaciones completas

```
admin_users
    Sin relaciones externas.

categorias
    categorias.parent_id  ──FK──►  categorias.id       (self-referencial, 0..1 a N)

marcas
    Sin relaciones externas.

productos
    productos.categoria_id ──FK──►  categorias.id      (N a 1, NOT NULL)
    productos.marca_id     ──FK──►  marcas.id           (N a 0..1, nullable)

producto_imagenes
    producto_imagenes.producto_id ──FK──►  productos.id (N a 1, CASCADE DELETE)

contacto_mensajes
    Sin relaciones externas.
```

---

## Normalización aplicada

### 1FN — Primera Forma Normal
- Todos los atributos son atómicos (sin grupos repetitivos ni arrays).
- Cada tabla tiene clave primaria simple definida.
- No hay columnas multi-valor.

### 2FN — Segunda Forma Normal
- Todas las tablas tienen claves primarias simples (no compuestas), por lo que 2FN se cumple automáticamente.
- No existen dependencias parciales.

### 3FN — Tercera Forma Normal
- No existen dependencias transitivas.
- El rubro/subrubro/sub-subrubro de un producto se infiere a través de `categoria_id` → `categorias` → `parent_id` (no se repiten datos de categoría en `productos`).
- El nombre y logo de una marca no se repiten en `productos`; se accede por `marca_id` → `marcas`.
- `precio_texto` y `precio_numero` representan el mismo precio en dos formatos diferentes; no es una dependencia transitiva porque ambos tienen propósito distinto (display vs. cálculo).

**Decisiones de diseño conscientes (desnormalización controlada):**
- `icono` en `productos`: podría estar en `categorias` y heredarse, pero se mantiene en productos para permitir iconos específicos por ítem.
- `precio_texto` + `precio_numero`: redundancia intencional; el texto es para display flexible, el número para queries de ordenamiento.

---

## Índices recomendados

```sql
-- categorias
CREATE INDEX idx_cat_parent  ON categorias (parent_id);
CREATE INDEX idx_cat_nivel   ON categorias (nivel);
CREATE INDEX idx_cat_slug    ON categorias (slug);

-- productos
CREATE INDEX idx_prod_cat    ON productos (categoria_id);
CREATE INDEX idx_prod_activo ON productos (activo, orden);
CREATE INDEX idx_prod_precio ON productos (precio_numero);

-- producto_imagenes
CREATE INDEX idx_img_prod    ON producto_imagenes (producto_id, es_principal);

-- contacto_mensajes
CREATE INDEX idx_msg_leido   ON contacto_mensajes (leido);
```

---

## Consultas frecuentes

### Obtener todos los productos de una categoría (por ruta de slugs)

```sql
-- Paso 1: obtener el ID de la categoría hoja por slug chain
SELECT c3.id AS categoria_id
FROM categorias c1
JOIN categorias c2 ON c2.parent_id = c1.id
JOIN categorias c3 ON c3.parent_id = c2.id
WHERE c1.slug = 'muebles'
  AND c2.slug = 'oficina'
  AND c3.slug = 'escritorios'
  AND c1.nivel = 1 AND c2.nivel = 2 AND c3.nivel = 3;

-- Para ruta de 2 niveles (informatica/accesorios):
SELECT c2.id AS categoria_id
FROM categorias c1
JOIN categorias c2 ON c2.parent_id = c1.id
WHERE c1.slug = 'informatica'
  AND c2.slug = 'accesorios'
  AND c1.nivel = 1 AND c2.nivel = 2;

-- Paso 2: obtener productos
SELECT p.*, m.nombre AS marca_nombre, m.logo_url AS marca_logo
FROM productos p
LEFT JOIN marcas m ON m.id = p.marca_id
WHERE p.categoria_id = :categoria_id
  AND p.activo = 1
ORDER BY p.orden ASC, p.nombre ASC;
```

### Obtener imagen principal de un producto

```sql
SELECT ruta, alt_text
FROM producto_imagenes
WHERE producto_id = :id AND es_principal = 1
LIMIT 1;
```

### Árbol completo de categorías activas

```sql
SELECT
    c1.nombre AS rubro,
    c2.nombre AS subrubro,
    c3.nombre AS sub_subrubro,
    COALESCE(c3.id, c2.id) AS hoja_id
FROM categorias c1
LEFT JOIN categorias c2 ON c2.parent_id = c1.id  AND c2.activo = 1
LEFT JOIN categorias c3 ON c3.parent_id = c2.id  AND c3.activo = 1
WHERE c1.nivel = 1 AND c1.activo = 1
ORDER BY c1.orden, c2.orden, c3.orden;
```

### Mensajes no leídos (panel admin)

```sql
SELECT COUNT(*) AS total_no_leidos
FROM contacto_mensajes
WHERE leido = 0;
```

---

## Comandos de gestión

```bash
# Crear todas las tablas
php spark migrate

# Poblar categorías + primer admin
php spark db:seed CategoriasSeeder
php spark db:seed AdminSeeder

# O ambos en uno
php spark db:seed

# Ver estado de migraciones
php spark migrate:status

# Revertir última migración
php spark migrate:rollback

# Revertir todo
php spark migrate:rollback --all
```

---

## Estructura de archivos relacionados

```
app/
  Controllers/
    Admin/
      Auth.php          ← login / logout
      Dashboard.php     ← panel principal
      Productos.php     ← CRUD productos
  Filters/
    AdminFilter.php     ← protege rutas /admin/*
  Models/
    AdminUserModel.php
    CategoriaModel.php
    MarcaModel.php
    ProductoModel.php
    ProductoImagenModel.php
    ContactoMensajeModel.php
  Database/
    Migrations/
      2025-05-10-000001_CreateAdminUsersTable.php
      2025-05-10-000002_CreateCategoriasTable.php
      2025-05-10-000003_CreateMarcasTable.php
      2025-05-10-000004_CreateProductosTable.php
      2025-05-10-000005_CreateProductoImagenesTable.php
      2025-05-10-000006_CreateContactoMensajesTable.php
    Seeds/
      AdminSeeder.php
      CategoriasSeeder.php

public/
  assets/
    img/
      productos/        ← imágenes de productos (subidas desde admin)
      marcas/           ← logos de marcas
```

---

## Historial de versiones del esquema

| Versión | Fecha | Descripción |
|---|---|---|
| v1.0 | 2025-05-10 | Esquema inicial: admin_users + productos (slugs texto) |
| v2.0 | 2025-05-10 | Normalización completa: categorias, marcas, producto_imagenes, contacto_mensajes |
