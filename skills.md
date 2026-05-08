# SKILLS.md — Página Web Centro Informático Regional

Nombre del proyecto: Centro Informático Regional Web

## 🎯 Propósito del proyecto

Desarrollar una página web institucional para Centro Informático Regional, enfocada en representar profesionalmente a la empresa y brindar información clara sobre:

- La empresa
- Los rubros comerciales
- Los productos disponibles
- Los servicios ofrecidos
- La ubicación y medios de contacto
- La identidad visual del negocio

La página debe funcionar como una carta de presentación digital para clientes actuales y potenciales.

## 📌 Stack del sistema

- Framework: CodeIgniter 4
- Lenguaje: PHP 8+
- Base de datos: MySQL / MariaDB en XAMPP local
- Frontend: HTML5, CSS3, Bootstrap 5
- JavaScript: Vanilla JS
- Arquitectura: MVC
- Servidor local: XAMPP
- Hosting futuro: servidor web compartido o VPS

## 🧠 Skills necesarias

### Backend

- Controllers, Models y Views en CodeIgniter 4
- Rutas limpias y organizadas
- Uso correcto de `base_url()`
- Carga dinámica de rubros, categorías, marcas y productos
- Validaciones básicas
- Separación clara entre lógica y presentación

### Base de Datos

- Modelado relacional
- Tablas para rubros, categorías, subcategorías, marcas, productos y servicios
- PK/FK
- Consultas con JOIN
- Filtros por rubro, categoría, marca o servicio
- Campos de estado activo/inactivo
- Imágenes asociadas a productos, marcas y categorías

### Frontend

- Bootstrap Grid
- Cards para rubros, productos y servicios
- Diseño responsive
- Navbar clara y accesible
- Hero principal institucional
- Secciones informativas
- Galerías o listados visuales
- Botones de contacto por WhatsApp
- Buen uso de imágenes comerciales

### UX/UI

- Diseño limpio, moderno y comercial
- Navegación simple
- Enfoque en que el cliente encuentre rápido lo que busca
- Uso de colores acordes a la identidad de Centro Informático Regional
- Textos breves, claros y orientados a venta
- Buen contraste visual
- Adaptación correcta a celulares

### Seguridad

- Validación de datos cargados desde base de datos
- Protección contra XSS en vistas
- Uso de `esc()` en CodeIgniter
- No mostrar información interna del sistema
- Control básico de errores
- Preparar el sistema para un panel administrador futuro

### SEO y presencia digital

- Títulos claros por página
- Meta descripciones
- URLs amigables
- Imágenes optimizadas
- Textos descriptivos para productos y servicios
- Buen uso de encabezados H1, H2 y H3
- Integración con redes sociales

### Módulos / Secciones principales

- Inicio
- Nosotros
- Rubros
- Informática
- Electrodomésticos
- Muebles
- Línea comercial
- Servicios
- Productos destacados
- Marcas
- Contacto
- Ubicación
- Preguntas frecuentes

## 🧩 Rubros principales

### Informática

Incluye productos como:

- Notebooks
- Computadoras
- Monitores
- Impresoras
- Periféricos
- Componentes
- Accesorios
- Redes y conectividad
- Seguridad informática

### Electrodomésticos

Incluye productos como:

- Heladeras
- Cocinas
- Hornos
- Anafes
- Freezers
- Exhibidoras
- Pequeños electrodomésticos

### Muebles

Incluye productos como:

- Escritorios
- Sillas
- Mesas para PC
- Bibliotecas
- Archiveros
- Muebles para oficina
- Muebles para el hogar

### Línea comercial

Incluye productos orientados a negocios, comercios y oficinas:

- Equipamiento comercial
- Exhibidoras
- Muebles comerciales
- Equipos de trabajo
- Soluciones para empresas

## 🛠️ Servicios

La página debe contemplar una sección de servicios, por ejemplo:

- Asesoramiento en compra de productos
- Venta de productos tecnológicos
- Venta de muebles y equipamiento
- Soluciones para oficinas
- Soluciones para comercios
- Servicio técnico o soporte, si corresponde
- Atención personalizada

## 🎨 Identidad visual

La página debe transmitir:

- Profesionalismo
- Confianza
- Cercanía con el cliente
- Variedad de productos
- Soluciones para hogar, oficina y comercio
- Imagen moderna y comercial

## 📁 Organización recomendada

### Controllers

- HomeController
- RubrosController
- ProductosController
- ServiciosController
- ContactoController

### Models

- RubroModel
- CategoriaModel
- SubcategoriaModel
- ProductoModel
- MarcaModel
- ServicioModel

### Views

- layout/header
- layout/navbar
- layout/footer
- home/index
- rubros/index
- rubros/detalle
- productos/index
- productos/detalle
- servicios/index
- contacto/index

## Regla principal

Priorizar claridad visual, navegación simple y representación profesional de Centro Informático Regional.

La página no debe sentirse como un sistema administrativo, sino como una web comercial e institucional pensada para clientes.

Cada sección debe comunicar rápido qué ofrece la empresa, qué productos trabaja y cómo el cliente puede contactarse.

Documentar con comentarios claros las partes importantes del código, especialmente rutas, controladores, consultas a base de datos y componentes visuales reutilizables.
