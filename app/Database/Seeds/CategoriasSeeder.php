<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    private function ins(array $data): int
    {
        $this->db->table('categorias')->insert(array_merge($data, [
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]));
        return (int) $this->db->insertID();
    }

    public function run(): void
    {
        if ($this->db->table('categorias')->countAllResults() > 0) {
            return;
        }

        // ══════════════════════════════════════════
        //  NIVEL 1 — RUBROS
        // ══════════════════════════════════════════
        $infoId = $this->ins(['parent_id' => null, 'nivel' => 1, 'nombre' => 'Informática',        'slug' => 'informatica',       'icono' => 'fas fa-laptop',        'descripcion' => 'Todo en tecnología informática: accesorios, hardware, monitores, seguridad, conectividad e impresión.', 'orden' => 1]);
        $mueId  = $this->ins(['parent_id' => null, 'nivel' => 1, 'nombre' => 'Muebles',            'slug' => 'muebles',           'icono' => 'fas fa-couch',         'descripcion' => 'Muebles de oficina y hogar: escritorios, sillas, camas, livings y mucho más.', 'orden' => 2]);
        $eleId  = $this->ins(['parent_id' => null, 'nivel' => 1, 'nombre' => 'Electrodomésticos',  'slug' => 'electrodomesticos', 'icono' => 'fas fa-blender',       'descripcion' => 'Todo en electrodomésticos para el hogar: heladeras, cocinas, hornos, freezers, TVs y audio.', 'orden' => 3]);
        $lcId   = $this->ins(['parent_id' => null, 'nivel' => 1, 'nombre' => 'Línea Comercial',    'slug' => 'linea-comercial',   'icono' => 'fas fa-store',         'descripcion' => 'Equipamiento para negocios: frío comercial, calor industrial, balanzas y amoblamiento.', 'orden' => 4]);

        // ══════════════════════════════════════════
        //  NIVEL 2 — INFORMÁTICA
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Accesorios',             'slug' => 'accesorios',   'icono' => 'fas fa-keyboard',      'descripcion' => 'Teclados, mouse, auriculares, webcams y todo lo que complementa tu equipo.', 'orden' => 1]);
        $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Componentes y Hardware', 'slug' => 'componentes',  'icono' => 'fas fa-microchip',     'descripcion' => 'RAM, SSD, procesadores y placas de video para actualizar o armar tu PC.', 'orden' => 2]);
        $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Monitores',              'slug' => 'monitores',    'icono' => 'fas fa-tv',            'descripcion' => 'Monitores Full HD, 2K y 4K para trabajo, diseño y gaming.', 'orden' => 3]);
        $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Seguridad Informática',  'slug' => 'seguridad',    'icono' => 'fas fa-shield-halved', 'descripcion' => 'Antivirus, licencias de software, cámaras IP y soluciones de ciberseguridad.', 'orden' => 4]);
        $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Conectividad y Redes',   'slug' => 'conectividad', 'icono' => 'fas fa-wifi',          'descripcion' => 'Routers, switches, cables y soluciones de red para hogar y empresa.', 'orden' => 5]);
        $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Impresión',              'slug' => 'impresion',    'icono' => 'fas fa-print',         'descripcion' => 'Impresoras, tintas y tóneres para mantener tu oficina siempre operativa.', 'orden' => 6]);

        // ══════════════════════════════════════════
        //  NIVEL 2 — MUEBLES
        // ══════════════════════════════════════════
        $ofId  = $this->ins(['parent_id' => $mueId, 'nivel' => 2, 'nombre' => 'Oficina', 'slug' => 'oficina', 'icono' => 'fas fa-briefcase', 'descripcion' => 'Muebles funcionales para equipar tu espacio de trabajo con comodidad y estilo.', 'orden' => 1]);
        $hogId = $this->ins(['parent_id' => $mueId, 'nivel' => 2, 'nombre' => 'Hogar',   'slug' => 'hogar',   'icono' => 'fas fa-home',      'descripcion' => 'Muebles para cada ambiente del hogar: dormitorio, living, cocina y baño.', 'orden' => 2]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — MUEBLES/OFICINA
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $ofId, 'nivel' => 3, 'nombre' => 'Escritorios',       'slug' => 'escritorios', 'icono' => 'fas fa-briefcase',   'descripcion' => 'Escritorios en L, rectos y regulables para todo tipo de espacio de trabajo.', 'orden' => 1]);
        $this->ins(['parent_id' => $ofId, 'nivel' => 3, 'nombre' => 'Mesas para PC',     'slug' => 'mesas-pc',    'icono' => 'fas fa-laptop',      'descripcion' => 'Mesas compactas diseñadas para equipos de escritorio y estaciones de trabajo.', 'orden' => 2]);
        $this->ins(['parent_id' => $ofId, 'nivel' => 3, 'nombre' => 'Sillas de Oficina', 'slug' => 'sillas',      'icono' => 'fas fa-chair',       'descripcion' => 'Sillas ergonómicas, ejecutivas y de escritorio para largas jornadas laborales.', 'orden' => 3]);
        $this->ins(['parent_id' => $ofId, 'nivel' => 3, 'nombre' => 'Bibliotecas',       'slug' => 'bibliotecas', 'icono' => 'fas fa-book',        'descripcion' => 'Bibliotecas y estantes para organizar libros, archivos y documentación.', 'orden' => 4]);
        $this->ins(['parent_id' => $ofId, 'nivel' => 3, 'nombre' => 'Archiveros',        'slug' => 'archiveros',  'icono' => 'fas fa-folder-open', 'descripcion' => 'Archiveros y cajoneras para mantener tus documentos siempre ordenados.', 'orden' => 5]);
        $this->ins(['parent_id' => $ofId, 'nivel' => 3, 'nombre' => 'Sillones de Espera','slug' => 'sillones',    'icono' => 'fas fa-couch',       'descripcion' => 'Sillones individuales y modulares para salas de espera y recepción.', 'orden' => 6]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — MUEBLES/HOGAR
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $hogId, 'nivel' => 3, 'nombre' => 'Dormitorio', 'slug' => 'dormitorio', 'icono' => 'fas fa-bed',      'descripcion' => 'Camas, placares y conjuntos completos para dormitorios.', 'orden' => 1]);
        $this->ins(['parent_id' => $hogId, 'nivel' => 3, 'nombre' => 'Livings',    'slug' => 'livings',    'icono' => 'fas fa-couch',    'descripcion' => 'Sofás, sillones y muebles para sala de estar y living.', 'orden' => 2]);
        $this->ins(['parent_id' => $hogId, 'nivel' => 3, 'nombre' => 'Cocina',     'slug' => 'cocina',     'icono' => 'fas fa-utensils', 'descripcion' => 'Muebles bajos, altos y mesadas para equipar tu cocina.', 'orden' => 3]);
        $this->ins(['parent_id' => $hogId, 'nivel' => 3, 'nombre' => 'Baño',       'slug' => 'bano',       'icono' => 'fas fa-bath',     'descripcion' => 'Vanitorios, espejeros y accesorios para equipar tu baño.', 'orden' => 4]);

        // ══════════════════════════════════════════
        //  NIVEL 2 — ELECTRODOMÉSTICOS
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $eleId, 'nivel' => 2, 'nombre' => 'Heladeras',    'slug' => 'heladeras', 'icono' => 'fas fa-temperature-low', 'descripcion' => 'Heladeras individuales, familiares y con freezer para el hogar.', 'orden' => 1]);
        $this->ins(['parent_id' => $eleId, 'nivel' => 2, 'nombre' => 'Cocinas',      'slug' => 'cocinas',   'icono' => 'fas fa-fire',            'descripcion' => 'Cocinas a gas, eléctricas y mixtas para todos los hogares.', 'orden' => 2]);
        $this->ins(['parent_id' => $eleId, 'nivel' => 2, 'nombre' => 'Hornos',       'slug' => 'hornos',    'icono' => 'fas fa-bread-slice',     'descripcion' => 'Hornos eléctricos, a gas, microondas y tostadores para tu cocina.', 'orden' => 3]);
        $this->ins(['parent_id' => $eleId, 'nivel' => 2, 'nombre' => 'Freezers',     'slug' => 'freezer',   'icono' => 'fas fa-snowflake',       'descripcion' => 'Freezers verticales y cofre para conservar alimentos por más tiempo.', 'orden' => 4]);
        $this->ins(['parent_id' => $eleId, 'nivel' => 2, 'nombre' => 'Televisores',  'slug' => 'tvs',       'icono' => 'fas fa-tv',              'descripcion' => 'Smart TVs 4K, Full HD y OLED de las mejores marcas.', 'orden' => 5]);
        $this->ins(['parent_id' => $eleId, 'nivel' => 2, 'nombre' => 'Audio',        'slug' => 'audio',     'icono' => 'fas fa-volume-high',     'descripcion' => 'Parlantes bluetooth, barras de sonido, equipos de audio y home theater.', 'orden' => 6]);

        // ══════════════════════════════════════════
        //  NIVEL 2 — LÍNEA COMERCIAL
        // ══════════════════════════════════════════
        $lcFrioId  = $this->ins(['parent_id' => $lcId, 'nivel' => 2, 'nombre' => 'Frío Comercial',       'slug' => 'frio',                  'icono' => 'fas fa-snowflake', 'descripcion' => 'Equipos de frío para comercios: freezers, pozos, exhibidoras y bateas.', 'orden' => 1]);
        $lcCalId   = $this->ins(['parent_id' => $lcId, 'nivel' => 2, 'nombre' => 'Calor Industrial',     'slug' => 'calor',                 'icono' => 'fas fa-fire',      'descripcion' => 'Equipos de cocción industrial: cocinas, hornos y freidoras para gastronomía.', 'orden' => 2]);
        $lcVarId   = $this->ins(['parent_id' => $lcId, 'nivel' => 2, 'nombre' => 'Varios',               'slug' => 'varios',                'icono' => 'fas fa-cubes',     'descripcion' => 'Equipamiento variado para negocios: balanzas, cortadoras y procesadores.', 'orden' => 3]);
        $lcAmobId  = $this->ins(['parent_id' => $lcId, 'nivel' => 2, 'nombre' => 'Amoblamiento Comercial','slug' => 'amoblamiento-comercial','icono' => 'fas fa-server',    'descripcion' => 'Equipamiento y mobiliario para locales comerciales: góndolas, estanterías y mostradores.', 'orden' => 4]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — LÍNEA COMERCIAL / FRÍO
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $lcFrioId, 'nivel' => 3, 'nombre' => 'Freezers Comerciales', 'slug' => 'freezer-comercial', 'icono' => 'fas fa-snowflake',    'descripcion' => 'Freezers verticales y cofre para supermercados, carnicerías y almacenes.', 'orden' => 1]);
        $this->ins(['parent_id' => $lcFrioId, 'nivel' => 3, 'nombre' => 'Pozos de Frío',        'slug' => 'pozo-de-frio',      'icono' => 'fas fa-cubes',        'descripcion' => 'Pozos horizontales de frío para exhibición y venta de congelados.', 'orden' => 2]);
        $this->ins(['parent_id' => $lcFrioId, 'nivel' => 3, 'nombre' => 'Exhibidoras',          'slug' => 'exhibidoras',       'icono' => 'fas fa-layer-group',  'descripcion' => 'Exhibidoras de frío vertical para lácteos, bebidas y productos frescos.', 'orden' => 3]);
        $this->ins(['parent_id' => $lcFrioId, 'nivel' => 3, 'nombre' => 'Bateas',               'slug' => 'bateas',            'icono' => 'fas fa-grip-lines',   'descripcion' => 'Bateas de frío para frutas, verduras y productos de almacén.', 'orden' => 4]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — LÍNEA COMERCIAL / CALOR
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $lcCalId, 'nivel' => 3, 'nombre' => 'Cocinas Industriales', 'slug' => 'cocinas-industrial',  'icono' => 'fas fa-fire',        'descripcion' => 'Cocinas a gas de 2 a 8 hornallas para uso gastronómico profesional.', 'orden' => 1]);
        $this->ins(['parent_id' => $lcCalId, 'nivel' => 3, 'nombre' => 'Hornos Industriales',  'slug' => 'hornos-industrial',   'icono' => 'fas fa-bread-slice', 'descripcion' => 'Hornos convectores, pizzeros y pasteleros para panaderías y restaurantes.', 'orden' => 2]);
        $this->ins(['parent_id' => $lcCalId, 'nivel' => 3, 'nombre' => 'Freidoras',            'slug' => 'freidoras-calor',     'icono' => 'fas fa-fire',        'descripcion' => 'Freidoras industriales a gas y eléctricas para locales gastronómicos.', 'orden' => 3]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — LÍNEA COMERCIAL / VARIOS
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $lcVarId, 'nivel' => 3, 'nombre' => 'Balanzas',             'slug' => 'balanzas',            'icono' => 'fas fa-scale-balanced', 'descripcion' => 'Balanzas digitales para comercio, carnicería y embalaje.', 'orden' => 1]);
        $this->ins(['parent_id' => $lcVarId, 'nivel' => 3, 'nombre' => 'Cortadoras de Fiambre','slug' => 'cortadoras-fiambre',  'icono' => 'fas fa-scissors',       'descripcion' => 'Cortadoras de fiambre manuales y automáticas para carnicerías y dietéticas.', 'orden' => 2]);
        $this->ins(['parent_id' => $lcVarId, 'nivel' => 3, 'nombre' => 'Amasadoras',           'slug' => 'amasadoras',          'icono' => 'fas fa-blender',        'descripcion' => 'Amasadoras y batidoras industriales para panaderías y pastelerías.', 'orden' => 3]);
        $this->ins(['parent_id' => $lcVarId, 'nivel' => 3, 'nombre' => 'Freidoras de Aire',    'slug' => 'freidoras-varios',    'icono' => 'fas fa-wind',           'descripcion' => 'Freidoras de aire caliente sin aceite para uso comercial y doméstico.', 'orden' => 4]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — LÍNEA COMERCIAL / AMOBLAMIENTO
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $lcAmobId, 'nivel' => 3, 'nombre' => 'Góndolas',                'slug' => 'gondolas',              'icono' => 'fas fa-layer-group', 'descripcion' => 'Góndolas centrales y murales para supermercados y negocios.', 'orden' => 1]);
        $this->ins(['parent_id' => $lcAmobId, 'nivel' => 3, 'nombre' => 'Estanterías Metálicas',   'slug' => 'estanterias-metalicas', 'icono' => 'fas fa-grip-lines',  'descripcion' => 'Estanterías de acero para depósitos, galpones y comercios.', 'orden' => 2]);
        $this->ins(['parent_id' => $lcAmobId, 'nivel' => 3, 'nombre' => 'Paneles Ranurados',       'slug' => 'paneles-ranurados',     'icono' => 'fas fa-grip-lines',  'descripcion' => 'Paneles ranurados para exhibición vertical de productos en locales.', 'orden' => 3]);
        $this->ins(['parent_id' => $lcAmobId, 'nivel' => 3, 'nombre' => 'Mostradores',             'slug' => 'mostradores',           'icono' => 'fas fa-store',       'descripcion' => 'Mostradores de vidrio y madera para exhibición y atención al público.', 'orden' => 4]);
        $this->ins(['parent_id' => $lcAmobId, 'nivel' => 3, 'nombre' => 'Racks',                   'slug' => 'racks',                 'icono' => 'fas fa-server',      'descripcion' => 'Racks metálicos para ropa, accesorios y exhibición en locales.', 'orden' => 5]);
        $this->ins(['parent_id' => $lcAmobId, 'nivel' => 3, 'nombre' => 'Accesorios Comerciales',  'slug' => 'accesorios-comerciales','icono' => 'fas fa-cubes',       'descripcion' => 'Cestos, porta precios, señalética y accesorios para equipar tu local.', 'orden' => 6]);
    }
}
