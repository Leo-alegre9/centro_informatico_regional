<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Catalogo extends BaseController
{
    private function getRubros(): array
    {
        return [

            // ═══ INFORMÁTICA ═══
            'informatica' => [
                'nombre'      => 'Informática',
                'icono'       => 'fas fa-laptop',
                'descripcion' => 'Todo en tecnología informática: accesorios, hardware, monitores, seguridad, conectividad e impresión.',
                'subrubros'   => [
                    'accesorios' => [
                        'nombre'      => 'Accesorios',
                        'icono'       => 'fas fa-keyboard',
                        'descripcion' => 'Teclados, mouse, auriculares, webcams y todo lo que complementa tu equipo.',
                        'productos'   => [
                            ['nombre' => 'Teclado Mecánico RGB',       'descripcion' => 'Switches Blue, retroiluminación RGB, diseño español latino.',         'precio' => 'Consultar precio', 'badge' => 'Nuevo',      'icono' => 'fas fa-keyboard'],
                            ['nombre' => 'Mouse Gamer Logitech G203',  'descripcion' => '8000 DPI, retroiluminación RGB, 6 botones programables.',             'precio' => 'Consultar precio', 'badge' => '',           'icono' => 'fas fa-computer-mouse'],
                            ['nombre' => 'Auriculares HyperX Cloud',   'descripcion' => 'Sonido surround 7.1, micrófono desmontable, comodidad premium.',      'precio' => 'Consultar precio', 'badge' => '',           'icono' => 'fas fa-headphones'],
                            ['nombre' => 'Webcam Logitech C920',       'descripcion' => 'Full HD 1080p, autofocus, ideal para videollamadas y streaming.',      'precio' => 'Consultar precio', 'badge' => '',           'icono' => 'fas fa-video'],
                            ['nombre' => 'Mousepad XL Gaming',         'descripcion' => '900x400mm, superficie de alta precisión, base antideslizante.',       'precio' => 'Consultar precio', 'badge' => '',           'icono' => 'fas fa-tablet-screen-button'],
                        ],
                    ],
                    'componentes' => [
                        'nombre'      => 'Componentes y Hardware',
                        'icono'       => 'fas fa-microchip',
                        'descripcion' => 'RAM, SSD, procesadores y placas de video para actualizar o armar tu PC.',
                        'productos'   => [
                            ['nombre' => 'RAM DDR4 16GB Kingston',     'descripcion' => '3200MHz CL16, kit 2x8GB, compatible con Intel y AMD.',                'precio' => 'Consultar precio', 'badge' => 'Más vendido', 'icono' => 'fas fa-memory'],
                            ['nombre' => 'SSD NVMe 500GB Samsung',     'descripcion' => 'M.2 PCIe 3.0, hasta 3500MB/s lectura, 970 EVO Plus.',                 'precio' => 'Consultar precio', 'badge' => 'Destacado',   'icono' => 'fas fa-hard-drive'],
                            ['nombre' => 'Procesador Intel Core i5',   'descripcion' => '6 núcleos, 12 hilos, hasta 4.4GHz, socket LGA1700.',                  'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-microchip'],
                            ['nombre' => 'Placa de Video RX 6600',     'descripcion' => '8GB GDDR6, excelente rendimiento 1080p, bajo consumo.',               'precio' => 'Consultar precio', 'badge' => 'Nuevo',       'icono' => 'fas fa-microchip'],
                            ['nombre' => 'Fuente de Poder 650W',       'descripcion' => '80 Plus Bronze, semi-modular, protecciones completas Corsair.',       'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-bolt'],
                        ],
                    ],
                    'monitores' => [
                        'nombre'      => 'Monitores',
                        'icono'       => 'fas fa-tv',
                        'descripcion' => 'Monitores Full HD, 2K y 4K para trabajo, diseño y gaming.',
                        'productos'   => [
                            ['nombre' => 'Monitor LG 24" Full HD',     'descripcion' => '24" IPS, 75Hz, ideal para trabajo y entretenimiento.',                'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-tv'],
                            ['nombre' => 'Monitor Samsung 27" QHD',    'descripcion' => '27" VA, 165Hz, 1ms, QHD 2560x1440, FreeSync Premium.',               'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-tv'],
                            ['nombre' => 'Monitor Benq 24" Gamer',     'descripcion' => '24" TN, 144Hz, 1ms, FullHD, ideal para gaming competitivo.',         'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-tv'],
                            ['nombre' => 'Monitor Philips 4K 27"',     'descripcion' => '27" IPS 4K UHD, ideal para diseño gráfico y edición de video.',      'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-tv'],
                        ],
                    ],
                    'seguridad' => [
                        'nombre'      => 'Seguridad Informática',
                        'icono'       => 'fas fa-shield-halved',
                        'descripcion' => 'Antivirus, licencias de software, cámaras IP y soluciones de ciberseguridad.',
                        'productos'   => [
                            ['nombre' => 'Antivirus ESET NOD32',       'descripcion' => 'Licencia 1 año, 1 dispositivo, protección en tiempo real.',           'precio' => 'Consultar precio', 'badge' => 'Recomendado', 'icono' => 'fas fa-shield-halved'],
                            ['nombre' => 'Kaspersky Total Security',   'descripcion' => 'Protección PC/Mac/móvil, 1 año, 3 dispositivos.',                     'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-lock'],
                            ['nombre' => 'Cámara IP Hikvision',        'descripcion' => '2MP Full HD, visión nocturna, acceso remoto vía app móvil.',          'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-video'],
                            ['nombre' => 'UPS Forza 850VA',            'descripcion' => 'Respaldo de energía 850VA/510W, 6 tomas protegidas.',                 'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-battery-full'],
                            ['nombre' => 'Windows 11 Pro',             'descripcion' => 'Licencia original digital, BitLocker, RDP y funciones avanzadas.',    'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-display'],
                        ],
                    ],
                    'conectividad' => [
                        'nombre'      => 'Conectividad y Redes',
                        'icono'       => 'fas fa-wifi',
                        'descripcion' => 'Routers, switches, cables y soluciones de red para hogar y empresa.',
                        'productos'   => [
                            ['nombre' => 'Router TP-Link AC1200',      'descripcion' => 'Wi-Fi dual band 2.4+5GHz, 4 antenas, fácil configuración.',          'precio' => 'Consultar precio', 'badge' => 'Destacado',   'icono' => 'fas fa-wifi'],
                            ['nombre' => 'Switch 8 Puertos Gigabit',   'descripcion' => '10/100/1000Mbps, plug & play, ideal para oficinas.',                  'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-network-wired'],
                            ['nombre' => 'Cable UTP Cat6 (por metro)', 'descripcion' => 'Cable certificado Cat6, 250MHz, para instalaciones fijas.',           'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-plug'],
                            ['nombre' => 'Router MikroTik hAP ac2',    'descripcion' => 'Dual band 802.11ac, 5 puertos Gigabit, RouterOS.',                    'precio' => 'Consultar precio', 'badge' => 'Profesional', 'icono' => 'fas fa-server'],
                            ['nombre' => 'Repetidor Wi-Fi TP-Link',    'descripcion' => 'Extiende la señal Wi-Fi, hasta 300Mbps, configuración simple.',       'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-wifi'],
                        ],
                    ],
                    'impresion' => [
                        'nombre'      => 'Impresión',
                        'icono'       => 'fas fa-print',
                        'descripcion' => 'Impresoras, tintas y tóneres para mantener tu oficina siempre operativa.',
                        'productos'   => [
                            ['nombre' => 'Impresora Epson L3250',      'descripcion' => 'Multifunción, tinta continua, Wi-Fi, imprime/escanea/copia.',         'precio' => 'Consultar precio', 'badge' => 'Más vendida', 'icono' => 'fas fa-print'],
                            ['nombre' => 'Impresora HP LaserJet',      'descripcion' => 'Láser monocromática, 20ppm, USB, ideal para documentos.',             'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-print'],
                            ['nombre' => 'Kit Tinta Epson 544',        'descripcion' => 'Pack 4 colores (BK, C, M, Y) compatible L3150/L3250/L5290.',          'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-fill-drip'],
                            ['nombre' => 'Tóner HP CE285A',            'descripcion' => 'Compatible con HP LaserJet P1102/M1130, 1600 páginas.',               'precio' => 'Consultar precio', 'badge' => '',            'icono' => 'fas fa-fill-drip'],
                            ['nombre' => 'Impresora Canon PIXMA',      'descripcion' => 'Inyección de tinta, impresión fotográfica, Wi-Fi, color.',            'precio' => 'Consultar precio', 'badge' => 'Nuevo',       'icono' => 'fas fa-print'],
                        ],
                    ],
                ],
            ],

            // ═══ MUEBLES ═══
            'muebles' => [
                'nombre'      => 'Muebles',
                'icono'       => 'fas fa-couch',
                'descripcion' => 'Muebles de oficina y hogar: escritorios, sillas, camas, livings y mucho más.',
                'subrubros'   => [
                    'oficina' => [
                        'nombre'      => 'Oficina',
                        'icono'       => 'fas fa-briefcase',
                        'descripcion' => 'Muebles funcionales para equipar tu espacio de trabajo con comodidad y estilo.',
                        'subrubros'   => [
                            'escritorios' => [
                                'nombre'      => 'Escritorios',
                                'icono'       => 'fas fa-briefcase',
                                'descripcion' => 'Escritorios en L, rectos y regulables para todo tipo de espacio de trabajo.',
                                'productos'   => [
                                    ['nombre' => 'Escritorio en L 160cm',      'descripcion' => 'Melanina 18mm, dos cajones con cerradura, patas metálicas.',  'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-briefcase'],
                                    ['nombre' => 'Escritorio Recto 120cm',     'descripcion' => 'Aglomerado revestido, cajón central, ideal para pymes.',      'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-briefcase'],
                                    ['nombre' => 'Escritorio Standing Desk',   'descripcion' => 'Altura regulable motorizada, 120x60cm, trabajo de pie/sentado.', 'precio' => 'Consultar precio', 'badge' => 'Nuevo', 'icono' => 'fas fa-briefcase'],
                                    ['nombre' => 'Escritorio Gamer RGB',       'descripcion' => 'Superficie carbón, porta headset, soporte monitor, 140cm.',   'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-briefcase'],
                                ],
                            ],
                            'mesas-pc' => [
                                'nombre'      => 'Mesas para PC',
                                'icono'       => 'fas fa-laptop',
                                'descripcion' => 'Mesas compactas diseñadas para equipos de escritorio y estaciones de trabajo.',
                                'productos'   => [
                                    ['nombre' => 'Mesa PC Compacta 80cm',      'descripcion' => 'Con soporte para CPU y bandeja de teclado deslizable.',       'precio' => 'Consultar precio', 'badge' => '',      'icono' => 'fas fa-laptop'],
                                    ['nombre' => 'Mesa PC Esquinera',          'descripcion' => 'Aprovecha el rincón, soporte lateral para torre.',            'precio' => 'Consultar precio', 'badge' => 'Nuevo', 'icono' => 'fas fa-laptop'],
                                    ['nombre' => 'Mesa PC con Ruedas',         'descripcion' => 'Movilidad total, frenos de seguridad, fácil reubicación.',    'precio' => 'Consultar precio', 'badge' => '',      'icono' => 'fas fa-laptop'],
                                ],
                            ],
                            'sillas' => [
                                'nombre'      => 'Sillas de Oficina',
                                'icono'       => 'fas fa-chair',
                                'descripcion' => 'Sillas ergonómicas, ejecutivas y de escritorio para largas jornadas laborales.',
                                'productos'   => [
                                    ['nombre' => 'Silla Ergonómica Mesh',      'descripcion' => 'Respaldo de malla, apoyabrazos 4D, lumbar ajustable.',        'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-chair'],
                                    ['nombre' => 'Silla Ejecutiva Cuero',      'descripcion' => 'Eco-cuero negro, reclinable, base giratoria cromada.',        'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-chair'],
                                    ['nombre' => 'Silla Gamer RGB',            'descripcion' => 'Respaldo alto, reposapiés, cojines lumbar y cervical.',       'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-chair'],
                                    ['nombre' => 'Silla Secretaria',           'descripcion' => 'Sin apoyabrazos, asiento acolchado, regulable en altura.',    'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-chair'],
                                ],
                            ],
                            'bibliotecas' => [
                                'nombre'      => 'Bibliotecas',
                                'icono'       => 'fas fa-book',
                                'descripcion' => 'Bibliotecas y estantes para organizar libros, archivos y documentación.',
                                'productos'   => [
                                    ['nombre' => 'Biblioteca 5 Estantes',      'descripcion' => 'Melanina wengé, 180x80cm, para libros y carpetas A4.',        'precio' => 'Consultar precio', 'badge' => '',      'icono' => 'fas fa-book'],
                                    ['nombre' => 'Biblioteca Rinconera',       'descripcion' => 'Esquinera, 6 estantes, blanca o cerezo, 160cm alto.',         'precio' => 'Consultar precio', 'badge' => 'Nuevo', 'icono' => 'fas fa-book'],
                                    ['nombre' => 'Estante Flotante 90cm',      'descripcion' => 'Repisa de madera para pared, carga hasta 15kg.',              'precio' => 'Consultar precio', 'badge' => '',      'icono' => 'fas fa-book'],
                                ],
                            ],
                            'archiveros' => [
                                'nombre'      => 'Archiveros',
                                'icono'       => 'fas fa-folder-open',
                                'descripcion' => 'Archiveros y cajoneras para mantener tus documentos siempre ordenados.',
                                'productos'   => [
                                    ['nombre' => 'Archivero 4 Cajones Metal',  'descripcion' => 'Acero laminado, cerradura central, guías telescópicas.',      'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-folder-open'],
                                    ['nombre' => 'Cajonera 3 Cajones',         'descripcion' => 'Madera melanina, ruedas, cierre con llave, bajo escritorio.', 'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-folder-open'],
                                    ['nombre' => 'Archivero 2 Cajones',        'descripcion' => 'Tamaño carta/oficio, cerradura, acabado negro mate.',         'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-folder-open'],
                                ],
                            ],
                            'sillones' => [
                                'nombre'      => 'Sillones de Espera',
                                'icono'       => 'fas fa-couch',
                                'descripcion' => 'Sillones individuales y modulares para salas de espera y recepción.',
                                'productos'   => [
                                    ['nombre' => 'Sillón Individual Recepción', 'descripcion' => 'Tapizado en eco-cuero, estructura metálica, varios colores.', 'precio' => 'Consultar precio', 'badge' => '',      'icono' => 'fas fa-couch'],
                                    ['nombre' => 'Módulo Sala de Espera x3',   'descripcion' => 'Banco de 3 cuerpos, apoyabrazos, tapizado antimanchas.',      'precio' => 'Consultar precio', 'badge' => 'Nuevo', 'icono' => 'fas fa-couch'],
                                    ['nombre' => 'Sillón Ejecutivo de Visita', 'descripcion' => 'Cuero genuino, patas cromadas, diseño contemporáneo.',        'precio' => 'Consultar precio', 'badge' => '',      'icono' => 'fas fa-couch'],
                                ],
                            ],
                        ],
                    ],
                    'hogar' => [
                        'nombre'      => 'Hogar',
                        'icono'       => 'fas fa-home',
                        'descripcion' => 'Muebles para cada ambiente del hogar: dormitorio, living, cocina y baño.',
                        'subrubros'   => [
                            'dormitorio' => [
                                'nombre'      => 'Dormitorio',
                                'icono'       => 'fas fa-bed',
                                'descripcion' => 'Camas, placares y conjuntos completos para dormitorios.',
                                'productos'   => [
                                    ['nombre' => 'Cama 2 Plazas con Cajones',  'descripcion' => 'Cabecero tapizado, 2 cajones laterales, 160x200cm.',          'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-bed'],
                                    ['nombre' => 'Placard 3 Puertas Corredizas', 'descripcion' => 'Espejo en puertas, interior con estantes y barral.',        'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-door-open'],
                                    ['nombre' => 'Mesa de Luz x2',             'descripcion' => 'Juego de 2 mesas de luz, 1 cajón y estante, melanina.',       'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-bed'],
                                    ['nombre' => 'Cómoda 5 Cajones',           'descripcion' => 'Melanina blanca/roble, guías metálicas, tirador plateado.',   'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-box-open'],
                                ],
                            ],
                            'livings' => [
                                'nombre'      => 'Livings',
                                'icono'       => 'fas fa-couch',
                                'descripcion' => 'Sofás, sillones y muebles para sala de estar y living.',
                                'productos'   => [
                                    ['nombre' => 'Sofá 3 Cuerpos',             'descripcion' => 'Tela antimanchas, patas madera, varios colores disponibles.', 'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-couch'],
                                    ['nombre' => 'Sillón 1 Cuerpo',           'descripcion' => 'Combinable con sofás, estructura pino, relleno HR.',           'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-couch'],
                                    ['nombre' => 'Mesa Ratona Vidriada',       'descripcion' => 'Tapa de vidrio 6mm, base plegable, 90x50cm.',                 'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-table'],
                                    ['nombre' => 'Mueble para TV 1.60m',       'descripcion' => 'Dos puertas, cajón central, soporta hasta 65".',              'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-tv'],
                                ],
                            ],
                            'cocina' => [
                                'nombre'      => 'Cocina',
                                'icono'       => 'fas fa-utensils',
                                'descripcion' => 'Muebles bajos, altos y mesadas para equipar tu cocina.',
                                'productos'   => [
                                    ['nombre' => 'Juego Muebles Bajos 1.80m',  'descripcion' => 'Módulos de 60cm, con cajones y puertas, color blanco.',       'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-utensils'],
                                    ['nombre' => 'Mueble Alto 2 Puertas',      'descripcion' => 'Alacena 60x30cm, bisagras amortiguadas, varios colores.',     'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-utensils'],
                                    ['nombre' => 'Mesada Granito 1.80m',       'descripcion' => 'Granito negro Andino, bacha simple, canilla incluida.',       'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-utensils'],
                                ],
                            ],
                            'bano' => [
                                'nombre'      => 'Baño',
                                'icono'       => 'fas fa-bath',
                                'descripcion' => 'Vanitorios, espejeros y accesorios para equipar tu baño.',
                                'productos'   => [
                                    ['nombre' => 'Vanitory 80cm con Espejo',   'descripcion' => 'Bajo mesada con 2 puertas, espejo LED lateral incluido.',     'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-bath'],
                                    ['nombre' => 'Espejero 3 Puertas',         'descripcion' => 'Con estantes internos, luz LED integrada, 75cm de ancho.',    'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-bath'],
                                    ['nombre' => 'Mueble Bajo 60cm',           'descripcion' => 'Melanina blanca, 2 puertas abatibles, resistente a humedad.', 'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-bath'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // ═══ ELECTRODOMÉSTICOS ═══
            'electrodomesticos' => [
                'nombre'      => 'Electrodomésticos',
                'icono'       => 'fas fa-blender',
                'descripcion' => 'Todo en electrodomésticos para el hogar: heladeras, cocinas, hornos, freezers, TVs y audio.',
                'subrubros'   => [
                    'heladeras' => [
                        'nombre'      => 'Heladeras',
                        'icono'       => 'fas fa-temperature-low',
                        'descripcion' => 'Heladeras individuales, familiares y con freezer para el hogar.',
                        'productos'   => [
                            ['nombre' => 'Heladera Familiar 350L',         'descripcion' => 'Gota, 2 puertas, freezer superior, 55cm de ancho, A+.',          'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-temperature-low'],
                            ['nombre' => 'Heladera No Frost 420L',         'descripcion' => 'No Frost, 2 puertas, freezer inferior, pantalla digital.',       'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-temperature-low'],
                            ['nombre' => 'Heladera Side by Side 600L',     'descripcion' => 'Dispensador de agua y hielo, freezer izquierdo, acero.',         'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-temperature-low'],
                            ['nombre' => 'Heladera Bajo Mesada 100L',      'descripcion' => 'Compacta, 1 puerta, ideal para oficina o habitación.',           'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-temperature-low'],
                        ],
                    ],
                    'cocinas' => [
                        'nombre'      => 'Cocinas',
                        'icono'       => 'fas fa-fire',
                        'descripcion' => 'Cocinas a gas, eléctricas y mixtas para todos los hogares.',
                        'productos'   => [
                            ['nombre' => 'Cocina a Gas 56cm 4 Hornallas',  'descripcion' => 'Horno a gas, parrilla, cubierta esmaltada, encendido eléctrico.', 'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-fire'],
                            ['nombre' => 'Cocina a Gas 76cm 5 Hornallas',  'descripcion' => 'Mesada acero inox, horno amplio, ideal para familias grandes.',   'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-fire'],
                            ['nombre' => 'Anafe Eléctrico 2 Zonas',        'descripcion' => 'Vitrocerámica, 2 zonas de cocción, instalación simple.',          'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-fire'],
                        ],
                    ],
                    'hornos' => [
                        'nombre'      => 'Hornos',
                        'icono'       => 'fas fa-bread-slice',
                        'descripcion' => 'Hornos eléctricos, a gas, microondas y tostadores para tu cocina.',
                        'productos'   => [
                            ['nombre' => 'Horno Eléctrico de Mesa 45L',    'descripcion' => 'Convección, grill, 10 funciones, timer, bandeja y asadera.',     'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-bread-slice'],
                            ['nombre' => 'Microondas 30L',                  'descripcion' => '900W, digital, 6 niveles de potencia, función grill.',           'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-bread-slice'],
                            ['nombre' => 'Tostadora 4 Ranuras',            'descripcion' => 'Pinza incluida, 6 niveles de tostado, bandeja de migas.',        'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-bread-slice'],
                            ['nombre' => 'Horno Pizzero 35L',              'descripcion' => 'Temperatura hasta 300°C, resistencia circular, acero inox.',     'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-bread-slice'],
                        ],
                    ],
                    'freezer' => [
                        'nombre'      => 'Freezers',
                        'icono'       => 'fas fa-snowflake',
                        'descripcion' => 'Freezers verticales y cofre para conservar alimentos por más tiempo.',
                        'productos'   => [
                            ['nombre' => 'Freezer Vertical 220L',          'descripcion' => '3 cajones con tapa, No Frost, 55cm ancho, clase energética A.',  'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-snowflake'],
                            ['nombre' => 'Freezer Cofre 300L',             'descripcion' => 'Cierre con llave, gasto eficiente, tapa abatible con resorte.',   'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-snowflake'],
                            ['nombre' => 'Freezer Horizontal 150L',        'descripcion' => 'Compacto, para espacios reducidos, cestillos organizadores.',     'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-snowflake'],
                        ],
                    ],
                    'tvs' => [
                        'nombre'      => 'Televisores',
                        'icono'       => 'fas fa-tv',
                        'descripcion' => 'Smart TVs 4K, Full HD y OLED de las mejores marcas.',
                        'productos'   => [
                            ['nombre' => 'Smart TV 55" 4K Samsung',        'descripcion' => 'QLED 4K, HDR10+, Tizen OS, 4 HDMI, Wi-Fi, Bluetooth.',           'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-tv'],
                            ['nombre' => 'Smart TV 43" Full HD LG',        'descripcion' => 'WebOS, ThinQ AI, Magic Remote incluido, 3 HDMI, 2 USB.',          'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-tv'],
                            ['nombre' => 'Smart TV 65" OLED',              'descripcion' => 'OLED evo, 120Hz, Dolby Vision IQ, procesador α9 Gen5.',           'precio' => 'Consultar precio', 'badge' => 'Premium',   'icono' => 'fas fa-tv'],
                            ['nombre' => 'Smart TV 32" Full HD',           'descripcion' => 'Ideal segunda habitación, Android TV, 2 HDMI, Wi-Fi.',            'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-tv'],
                        ],
                    ],
                    'audio' => [
                        'nombre'      => 'Audio',
                        'icono'       => 'fas fa-volume-high',
                        'descripcion' => 'Parlantes bluetooth, barras de sonido, equipos de audio y home theater.',
                        'productos'   => [
                            ['nombre' => 'Barra de Sonido 2.1 Bluetooth',  'descripcion' => '200W RMS, subwoofer inalámbrico, HDMI ARC, óptico.',             'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-volume-high'],
                            ['nombre' => 'Parlante Bluetooth Portátil',    'descripcion' => 'IPX7 resistente al agua, 24hs batería, 360° sonido.',             'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-volume-high'],
                            ['nombre' => 'Home Theater 5.1',               'descripcion' => '1000W, 5 satélites + subwoofer, HDMI, USB, FM, Bluetooth.',      'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-volume-high'],
                            ['nombre' => 'Minicomponente 60W',             'descripcion' => 'CD, USB, Bluetooth, FM, ecualizador, display LCD.',               'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-volume-high'],
                        ],
                    ],
                ],
            ],

            // ═══ LÍNEA COMERCIAL ═══
            'linea-comercial' => [
                'nombre'      => 'Línea Comercial',
                'icono'       => 'fas fa-store',
                'descripcion' => 'Equipamiento para negocios: frío comercial, calor industrial, balanzas y amoblamiento.',
                'subrubros'   => [
                    'frio' => [
                        'nombre'      => 'Frío Comercial',
                        'icono'       => 'fas fa-snowflake',
                        'descripcion' => 'Equipos de frío para comercios: freezers, pozos, exhibidoras y bateas.',
                        'subrubros'   => [
                            'freezer-comercial' => [
                                'nombre'      => 'Freezers Comerciales',
                                'icono'       => 'fas fa-snowflake',
                                'descripcion' => 'Freezers verticales y cofre para supermercados, carnicerías y almacenes.',
                                'productos'   => [
                                    ['nombre' => 'Freezer Vertical 2 Puertas',  'descripcion' => 'Puerta de vidrio, iluminación LED, 600L, clase A.',         'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-snowflake'],
                                    ['nombre' => 'Freezer Cofre Comercial',     'descripcion' => '500L, tapa de vidrio, ideal para paletas y helados.',        'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-snowflake'],
                                    ['nombre' => 'Freezer Vertical 1 Puerta',   'descripcion' => 'Puerta de vidrio curvo, 300L, iluminación interior.',        'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-snowflake'],
                                ],
                            ],
                            'pozo-de-frio' => [
                                'nombre'      => 'Pozos de Frío',
                                'icono'       => 'fas fa-cubes',
                                'descripcion' => 'Pozos horizontales de frío para exhibición y venta de congelados.',
                                'productos'   => [
                                    ['nombre' => 'Pozo de Frío 1.0m',           'descripcion' => 'Caja horizontal abierta, temp. -18°C, iluminación LED.',    'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-cubes'],
                                    ['nombre' => 'Pozo de Frío 1.5m',           'descripcion' => 'Con tapa corrediza, eficiencia energética A+.',              'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-cubes'],
                                    ['nombre' => 'Pozo de Frío 2.0m Island',    'descripcion' => 'Isla central doble acceso, para grandes superficies.',       'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-cubes'],
                                ],
                            ],
                            'exhibidoras' => [
                                'nombre'      => 'Exhibidoras',
                                'icono'       => 'fas fa-layer-group',
                                'descripcion' => 'Exhibidoras de frío vertical para lácteos, bebidas y productos frescos.',
                                'productos'   => [
                                    ['nombre' => 'Exhibidora Vertical 2 Cuerpos', 'descripcion' => 'Puertas batientes vidrio, 6 estantes, 1400L total.',      'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-layer-group'],
                                    ['nombre' => 'Exhibidora Mural Abierta',    'descripcion' => 'Múltiples estantes, cortina de aire, 0-5°C.',               'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-layer-group'],
                                    ['nombre' => 'Exhibidora Bebidas 400L',     'descripcion' => 'Puerta de vidrio curvo, iluminación interior, retro style.', 'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-layer-group'],
                                ],
                            ],
                            'bateas' => [
                                'nombre'      => 'Bateas',
                                'icono'       => 'fas fa-grip-lines',
                                'descripcion' => 'Bateas de frío para frutas, verduras y productos de almacén.',
                                'productos'   => [
                                    ['nombre' => 'Batea Refrigerada 1.2m',      'descripcion' => 'Acero inox, temp. 0-5°C, iluminación LED lateral.',         'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-grip-lines'],
                                    ['nombre' => 'Batea Refrigerada 2.4m',      'descripcion' => 'Dos secciones independientes, termostato digital.',          'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-grip-lines'],
                                    ['nombre' => 'Batea Semi-Abierta 1.8m',     'descripcion' => 'Con tapa de vidrio abatible, uso en carnicerías y deli.',    'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-grip-lines'],
                                ],
                            ],
                        ],
                    ],
                    'calor' => [
                        'nombre'      => 'Calor Industrial',
                        'icono'       => 'fas fa-fire',
                        'descripcion' => 'Equipos de cocción industrial: cocinas, hornos y freidoras para gastronomía.',
                        'subrubros'   => [
                            'cocinas-industrial' => [
                                'nombre'      => 'Cocinas Industriales',
                                'icono'       => 'fas fa-fire',
                                'descripcion' => 'Cocinas a gas de 2 a 8 hornallas para uso gastronomico profesional.',
                                'productos'   => [
                                    ['nombre' => 'Cocina Industrial 4 Hornallas', 'descripcion' => 'Hornallas tipo volcán, válvula de seguridad, mesa acero.', 'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-fire'],
                                    ['nombre' => 'Cocina Industrial 6 Hornallas', 'descripcion' => 'Con horno, parrilla, alto rendimiento BTU.',              'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-fire'],
                                    ['nombre' => 'Cocina + Plancha 4 Hornallas',  'descripcion' => 'Plancha de 30cm a la derecha, acero inoxidable.',          'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-fire'],
                                ],
                            ],
                            'hornos-industrial' => [
                                'nombre'      => 'Hornos Industriales',
                                'icono'       => 'fas fa-bread-slice',
                                'descripcion' => 'Hornos convectores, pizzeros y pasteleros para panaderías y restaurantes.',
                                'productos'   => [
                                    ['nombre' => 'Horno Convector 10 Bandejas',  'descripcion' => 'Gas o eléctrico, temp. hasta 300°C, temporizador.',        'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-bread-slice'],
                                    ['nombre' => 'Horno Pizzero 2 Cámaras',      'descripcion' => 'Piso refractario, control independiente, 8 pizzas c/u.',   'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-bread-slice'],
                                    ['nombre' => 'Horno Pastelero 6 Moldes',     'descripcion' => 'Vapor integrado, piso de acero, para panadería.',          'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-bread-slice'],
                                ],
                            ],
                            'freidoras-calor' => [
                                'nombre'      => 'Freidoras',
                                'icono'       => 'fas fa-fire',
                                'descripcion' => 'Freidoras industriales a gas y eléctricas para locales gastronómicos.',
                                'productos'   => [
                                    ['nombre' => 'Freidora a Gas 10L',           'descripcion' => 'Canasto doble, control de temperatura, válvula de drenaje.', 'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-fire'],
                                    ['nombre' => 'Freidora Eléctrica 8L',        'descripcion' => 'Termostato ajustable 130-190°C, cuba extraíble inox.',      'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-fire'],
                                    ['nombre' => 'Freidora Doble Cuba 2x8L',     'descripcion' => 'Dos canastos independientes, ideal para locales de comidas.', 'precio' => 'Consultar precio', 'badge' => 'Nuevo',   'icono' => 'fas fa-fire'],
                                ],
                            ],
                        ],
                    ],
                    'varios' => [
                        'nombre'      => 'Varios',
                        'icono'       => 'fas fa-cubes',
                        'descripcion' => 'Equipamiento variado para negocios: balanzas, cortadoras y procesadores.',
                        'subrubros'   => [
                            'balanzas' => [
                                'nombre'      => 'Balanzas',
                                'icono'       => 'fas fa-scale-balanced',
                                'descripcion' => 'Balanzas digitales para comercio, carnicería y embalaje.',
                                'productos'   => [
                                    ['nombre' => 'Balanza Digital Comercial 15kg', 'descripcion' => 'Display doble, impresora de tickets, plataforma inox.',  'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-scale-balanced'],
                                    ['nombre' => 'Balanza de Mesa 5kg',          'descripcion' => 'Precisión 1g, batería recargable, homologada OIML.',       'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-scale-balanced'],
                                    ['nombre' => 'Balanza de Piso 300kg',        'descripcion' => 'Plataforma 40x40cm, display LED, certificada Senasa.',     'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-scale-balanced'],
                                ],
                            ],
                            'cortadoras-fiambre' => [
                                'nombre'      => 'Cortadoras de Fiambre',
                                'icono'       => 'fas fa-scissors',
                                'descripcion' => 'Cortadoras de fiambre manuales y automáticas para carnicerías y dietéticas.',
                                'productos'   => [
                                    ['nombre' => 'Cortadora Fiambre 250mm',      'descripcion' => 'Hoja 250mm, motor 150W, regulador de espesor 0-15mm.',      'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-scissors'],
                                    ['nombre' => 'Cortadora Fiambre 300mm',      'descripcion' => 'Motor 200W, mesa anodizada, carro ancho para jamones.',     'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-scissors'],
                                    ['nombre' => 'Cortadora Automática 220mm',   'descripcion' => 'Avance automático regulable, hoja inox, corte hasta 30mm.', 'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-scissors'],
                                ],
                            ],
                            'amasadoras' => [
                                'nombre'      => 'Amasadoras',
                                'icono'       => 'fas fa-blender',
                                'descripcion' => 'Amasadoras y batidoras industriales para panaderías y pastelerías.',
                                'productos'   => [
                                    ['nombre' => 'Amasadora Espiral 10kg',       'descripcion' => 'Motor 750W, bol inox, doble velocidad, temporizador.',      'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-blender'],
                                    ['nombre' => 'Batidora Planetaria 5L',       'descripcion' => '3 velocidades, 3 accesorios, tazón inox, 350W.',             'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-blender'],
                                    ['nombre' => 'Amasadora Sobadora 20kg',      'descripcion' => 'Rodillo sobador, mesa de acero, doble función.',            'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-blender'],
                                ],
                            ],
                            'freidoras-varios' => [
                                'nombre'      => 'Freidoras de Aire',
                                'icono'       => 'fas fa-wind',
                                'descripcion' => 'Freidoras de aire caliente sin aceite para uso comercial y doméstico.',
                                'productos'   => [
                                    ['nombre' => 'Freidora de Aire 5.5L',        'descripcion' => 'Sin aceite, 1700W, temperatura hasta 200°C, digital.',     'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-wind'],
                                    ['nombre' => 'Freidora de Aire 10L XXL',     'descripcion' => 'Para uso comercial, 2200W, 8 programas presets.',           'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-wind'],
                                    ['nombre' => 'Freidora de Aire Dual 8L',     'descripcion' => 'Doble cesta independiente, cocción simultánea.',            'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-wind'],
                                ],
                            ],
                        ],
                    ],
                    'amoblamiento-comercial' => [
                        'nombre'      => 'Amoblamiento Comercial',
                        'icono'       => 'fas fa-server',
                        'descripcion' => 'Equipamiento y mobiliario para locales comerciales: góndolas, estanterías y mostradores.',
                        'subrubros'   => [
                            'gondolas' => [
                                'nombre'      => 'Góndolas',
                                'icono'       => 'fas fa-layer-group',
                                'descripcion' => 'Góndolas centrales y murales para supermercados y negocios.',
                                'productos'   => [
                                    ['nombre' => 'Góndola Central 1.80m',        'descripcion' => 'Doble faz, 5 estantes, base con zócalo, varios colores.',   'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-layer-group'],
                                    ['nombre' => 'Góndola Mural 1.80m',          'descripcion' => 'Simple faz, 5 estantes, cabecera incluida.',                'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-layer-group'],
                                    ['nombre' => 'Módulo Adicional Góndola',     'descripcion' => 'Para ampliar líneas existentes, universal 1.22m.',          'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-layer-group'],
                                ],
                            ],
                            'estanterias-metalicas' => [
                                'nombre'      => 'Estanterías Metálicas',
                                'icono'       => 'fas fa-grip-lines',
                                'descripcion' => 'Estanterías de acero para depósitos, galpones y comercios.',
                                'productos'   => [
                                    ['nombre' => 'Estantería 5 Estantes 200kg',  'descripcion' => 'Acero galvanizado, 200x100x40cm, tornillos de ajuste.',    'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-grip-lines'],
                                    ['nombre' => 'Rack Liviano 4 Estantes',      'descripcion' => 'Tubular pintado, 180x90x40cm, carga máx. 80kg x estante.', 'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-grip-lines'],
                                    ['nombre' => 'Estantería Pesada 600kg',      'descripcion' => 'Perforada tipo palletero, 250x130x50cm, reforzada.',        'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-grip-lines'],
                                ],
                            ],
                            'paneles-ranurados' => [
                                'nombre'      => 'Paneles Ranurados',
                                'icono'       => 'fas fa-grip-lines',
                                'descripcion' => 'Paneles ranurados para exhibición vertical de productos en locales.',
                                'productos'   => [
                                    ['nombre' => 'Panel Ranurado 120x240cm',     'descripcion' => 'MDF lacado blanco, ranuras cada 5cm, instalación simple.',  'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-grip-lines'],
                                    ['nombre' => 'Panel Ranurado Metálico',      'descripcion' => 'Acero pintado, ranuras cada 5cm, mayor resistencia.',       'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-grip-lines'],
                                    ['nombre' => 'Kit Accesorios Panel x20',     'descripcion' => 'Ganchos, porta precios, brazos y estantes para paneles.',   'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-grip-lines'],
                                ],
                            ],
                            'mostradores' => [
                                'nombre'      => 'Mostradores',
                                'icono'       => 'fas fa-store',
                                'descripcion' => 'Mostradores de vidrio y madera para exhibición y atención al público.',
                                'productos'   => [
                                    ['nombre' => 'Mostrador Vidriado 1.20m',     'descripcion' => 'Vidrio 4mm, iluminación LED interior, base con puertas.',   'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-store'],
                                    ['nombre' => 'Mostrador Recto 1.80m',        'descripcion' => 'Melanina con bordes ABS, amplio espacio de trabajo.',       'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-store'],
                                    ['nombre' => 'Mostrador Esquinero',          'descripcion' => 'Ideal para recepciones y ángulos, vidriado frontal.',        'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-store'],
                                ],
                            ],
                            'racks' => [
                                'nombre'      => 'Racks',
                                'icono'       => 'fas fa-server',
                                'descripcion' => 'Racks metálicos para ropa, accesorios y exhibición en locales.',
                                'productos'   => [
                                    ['nombre' => 'Rack Circular Giratorio',      'descripcion' => 'Giratorio 360°, 80 perchas, base metálica, 180cm.',         'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-server'],
                                    ['nombre' => 'Rack Lineal 1.5m',            'descripcion' => 'Tubo cromado, 2 alturas regulables, base T anti-vuelco.',    'precio' => 'Consultar precio', 'badge' => 'Destacado', 'icono' => 'fas fa-server'],
                                    ['nombre' => 'Rack Doble Barra 1m',         'descripcion' => 'Dos barras de cuelgue, ruedas con freno, acero pintado.',    'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-server'],
                                ],
                            ],
                            'accesorios-comerciales' => [
                                'nombre'      => 'Accesorios Comerciales',
                                'icono'       => 'fas fa-cubes',
                                'descripcion' => 'Cestos, porta precios, señalética y accesorios para equipar tu local.',
                                'productos'   => [
                                    ['nombre' => 'Cesto Mostrador de Alambre',   'descripcion' => 'Cromado, varios tamaños, para exhibición de productos.',    'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-cubes'],
                                    ['nombre' => 'Porta Precio Clip x50',        'descripcion' => 'Plástico transparente, clip universal para estantes.',      'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-cubes'],
                                    ['nombre' => 'Cartelería LED para Local',    'descripcion' => 'Letrero luminoso personalizable, 60x20cm, incluye soporte.', 'precio' => 'Consultar precio', 'badge' => 'Nuevo',     'icono' => 'fas fa-cubes'],
                                    ['nombre' => 'Display de Flores PVC',        'descripcion' => 'Torre modular para accesorios, 60 ganchos, ruedas.',        'precio' => 'Consultar precio', 'badge' => '',          'icono' => 'fas fa-cubes'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

        ];
    }

    public function index(): string
    {
        $allRubros = $this->getRubros();

        return view('catalogo_rubro', [
            'titulo'      => 'Catálogo | Centro Informático Regional',
            'breadcrumb'  => [
                ['nombre' => 'Inicio',   'url' => base_url()],
                ['nombre' => 'Catálogo', 'url' => null],
            ],
            'current'     => [
                'nombre'      => 'Catálogo',
                'icono'       => 'fas fa-th-large',
                'descripcion' => 'Explorá todos nuestros rubros y encontrá lo que necesitás.',
                'subrubros'   => $allRubros,
            ],
            'currentPath' => 'catalogo',
            'siblings'    => [],
            'allRubros'   => $allRubros,
        ]);
    }

    public function browse(string $a, string $b = '', string $c = ''): string
    {
        $allRubros = $this->getRubros();

        $segments = array_filter([$a, $b, $c], fn($s) => $s !== '');
        $segments = array_values($segments);

        $breadcrumb = [
            ['nombre' => 'Inicio',   'url' => base_url()],
            ['nombre' => 'Catálogo', 'url' => base_url('catalogo')],
        ];

        $node      = ['subrubros' => $allRubros];
        $pathParts = ['catalogo'];
        $parentNode    = null;
        $parentPath    = 'catalogo';

        foreach ($segments as $i => $seg) {
            if (!isset($node['subrubros'][$seg])) {
                throw PageNotFoundException::forPageNotFound();
            }

            $parentNode = $node;
            $parentPath = implode('/', $pathParts);
            $node       = $node['subrubros'][$seg];
            $pathParts[] = $seg;

            if ($i < count($segments) - 1) {
                $breadcrumb[] = [
                    'nombre' => $node['nombre'],
                    'url'    => base_url(implode('/', $pathParts)),
                ];
            }
        }

        $breadcrumb[] = ['nombre' => $node['nombre'], 'url' => null];

        // Si el nodo es hoja (no tiene subrubros), intentar obtener productos de la DB
        if (!isset($node['subrubros'])) {
            $catModel    = new \App\Models\CategoriaModel();
            $categoria   = $catModel->findBySlugPath(
                $segments[0] ?? '',
                $segments[1] ?? null,
                isset($segments[2]) ? $segments[2] : null
            );
            if ($categoria) {
                $productoModel = new \App\Models\ProductoModel();
                $imgModel      = new \App\Models\ProductoImagenModel();
                $dbProductos   = $productoModel->getByCategoriaId($categoria['id']);
                if (!empty($dbProductos)) {
                    $prodIds     = array_column($dbProductos, 'id');
                    $imagenes    = $imgModel->whereIn('producto_id', $prodIds)
                                           ->where('es_principal', 1)
                                           ->findAll();
                    $imgByProdId = array_column($imagenes, null, 'producto_id');

                    $node['productos'] = array_map(fn($p) => [
                        'nombre'      => $p['nombre'],
                        'descripcion' => $p['descripcion_corta'] ?? $p['descripcion'] ?? '',
                        'precio'      => $p['precio_texto'],
                        'badge'       => $p['badge'],
                        'icono'       => $p['icono'],
                        'imagen_url'  => isset($imgByProdId[$p['id']]) ? $imgByProdId[$p['id']]['ruta'] : null,
                    ], $dbProductos);
                }
            }
        }

        $siblings = [];
        if ($parentNode !== null && isset($parentNode['subrubros'])) {
            $lastSeg = end($segments);
            foreach ($parentNode['subrubros'] as $key => $sibling) {
                $siblings[$key] = [
                    'nombre' => $sibling['nombre'],
                    'icono'  => $sibling['icono'],
                    'url'    => base_url($parentPath . '/' . $key),
                    'activo' => ($key === $lastSeg),
                ];
            }
        }

        $currentPath = implode('/', $pathParts);

        return view('catalogo_rubro', [
            'titulo'      => $node['nombre'] . ' | Centro Informático Regional',
            'breadcrumb'  => $breadcrumb,
            'current'     => $node,
            'currentPath' => $currentPath,
            'siblings'    => $siblings,
            'allRubros'   => $allRubros,
        ]);
    }
}
