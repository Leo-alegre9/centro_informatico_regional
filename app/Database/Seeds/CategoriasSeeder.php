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
        $infoId = $this->ins(['parent_id' => null, 'nivel' => 1, 'nombre' => 'Informática',        'slug' => 'informatica',       'icono' => 'fas fa-microchip',     'descripcion' => 'Todo en tecnología para tu hogar y empresa: computación, componentes, gaming, notebooks, redes, seguridad y más.', 'orden' => 1]);
        $mueId  = $this->ins(['parent_id' => null, 'nivel' => 1, 'nombre' => 'Muebles',            'slug' => 'muebles',           'icono' => 'fas fa-couch',         'descripcion' => 'Muebles de oficina y hogar: escritorios, sillas, camas, livings y mucho más.', 'orden' => 2]);
        $eleId  = $this->ins(['parent_id' => null, 'nivel' => 1, 'nombre' => 'Electrodomésticos',  'slug' => 'electrodomesticos', 'icono' => 'fas fa-blender',       'descripcion' => 'Todo en electrodomésticos para el hogar: heladeras, cocinas, hornos, freezers, TVs y audio.', 'orden' => 3]);
        $lcId   = $this->ins(['parent_id' => null, 'nivel' => 1, 'nombre' => 'Línea Comercial',    'slug' => 'linea-comercial',   'icono' => 'fas fa-store',         'descripcion' => 'Equipamiento para negocios: frío comercial, calor industrial, balanzas y amoblamiento.', 'orden' => 4]);

        // ══════════════════════════════════════════
        //  NIVEL 2 — INFORMÁTICA (12 categorías)
        // ══════════════════════════════════════════
        $compId   = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Computación',           'slug' => 'computacion',          'icono' => 'fas fa-desktop',          'descripcion' => 'Equipos de escritorio completos: PCs, workstations y servidores para hogar y empresa.', 'orden' => 1]);
        $compnId  = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Componentes',           'slug' => 'componentes',          'icono' => 'fas fa-microchip',        'descripcion' => 'Hardware para armar o actualizar tu PC: procesadores, memorias, placas, almacenamiento y más.', 'orden' => 2]);
        $gamId    = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Gaming',                'slug' => 'gaming',               'icono' => 'fas fa-gamepad',          'descripcion' => 'Equipá tu setup gamer con lo mejor en periféricos, monitores y accesorios.', 'orden' => 3]);
        $notId    = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Notebooks y Movilidad', 'slug' => 'notebooks-movilidad',  'icono' => 'fas fa-laptop',           'descripcion' => 'Laptops, tablets y accesorios para trabajar y estudiar donde quieras.', 'orden' => 4]);
        $impId    = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Impresión',             'slug' => 'impresion',            'icono' => 'fas fa-print',            'descripcion' => 'Impresoras, multifunción, tintas, tóneres y consumibles para hogar y oficina.', 'orden' => 5]);
        $redId    = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Redes y Conectividad',  'slug' => 'redes-conectividad',   'icono' => 'fas fa-wifi',             'descripcion' => 'Routers, switches, cableado y soluciones de red para hogar y empresa.', 'orden' => 6]);
        $segId    = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Seguridad Electrónica', 'slug' => 'seguridad-electronica','icono' => 'fas fa-shield-halved',    'descripcion' => 'Videovigilancia, alarmas y control de acceso para proteger tu hogar y negocio.', 'orden' => 7]);
        $perId    = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Periféricos',           'slug' => 'perifericos',          'icono' => 'fas fa-keyboard',         'descripcion' => 'Teclados, mouse, parlantes, webcams y accesorios de uso diario para tu PC.', 'orden' => 8]);
        $monId    = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Monitores y Pantallas', 'slug' => 'monitores-pantallas',  'icono' => 'fas fa-display',          'descripcion' => 'Pantallas Full HD, 2K y 4K para trabajo, diseño y gaming, más soportes.', 'orden' => 9]);
        $almId    = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Almacenamiento',        'slug' => 'almacenamiento',       'icono' => 'fas fa-hard-drive',       'descripcion' => 'Pendrives, SSD externos, HDD, tarjetas SD y NAS para todo tipo de necesidad.', 'orden' => 10]);
        $eneId    = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Energía y Protección',  'slug' => 'energia-proteccion',   'icono' => 'fas fa-bolt',             'descripcion' => 'UPS, estabilizadores y protectores de tensión para cuidar tus equipos.', 'orden' => 11]);
        $ofTecId  = $this->ins(['parent_id' => $infoId, 'nivel' => 2, 'nombre' => 'Oficina Tecnológica',   'slug' => 'oficina-tecnologica',  'icono' => 'fas fa-briefcase',        'descripcion' => 'Proyectores, teléfonos IP, calculadoras y tecnología para el entorno de trabajo.', 'orden' => 12]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / COMPUTACIÓN
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $compId,  'nivel' => 3, 'nombre' => 'PCs de Escritorio',     'slug' => 'pcs-escritorio',       'icono' => 'fas fa-computer',             'descripcion' => 'Computadoras de escritorio listas para usar en hogar y oficina.', 'orden' => 1]);
        $this->ins(['parent_id' => $compId,  'nivel' => 3, 'nombre' => 'PCs Armadas',           'slug' => 'pcs-armadas',          'icono' => 'fas fa-screwdriver-wrench',   'descripcion' => 'PCs ensambladas a medida según tus necesidades y presupuesto.', 'orden' => 2]);
        $this->ins(['parent_id' => $compId,  'nivel' => 3, 'nombre' => 'Mini PC',               'slug' => 'mini-pc',             'icono' => 'fas fa-box',                  'descripcion' => 'Computadoras compactas de bajo consumo, ideales para escritorios pequeños.', 'orden' => 3]);
        $this->ins(['parent_id' => $compId,  'nivel' => 3, 'nombre' => 'Workstations',          'slug' => 'workstations',        'icono' => 'fas fa-display',              'descripcion' => 'Estaciones de trabajo de alto rendimiento para diseño y edición profesional.', 'orden' => 4]);
        $this->ins(['parent_id' => $compId,  'nivel' => 3, 'nombre' => 'Servidores',            'slug' => 'servidores',          'icono' => 'fas fa-server',               'descripcion' => 'Servidores torre y rack para pymes con almacenamiento centralizado.', 'orden' => 5]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / COMPONENTES
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $compnId, 'nivel' => 3, 'nombre' => 'Procesadores',         'slug' => 'procesadores',        'icono' => 'fas fa-microchip',            'descripcion' => 'CPUs Intel y AMD para todos los presupuestos y necesidades.', 'orden' => 1]);
        $this->ins(['parent_id' => $compnId, 'nivel' => 3, 'nombre' => 'Motherboards',         'slug' => 'motherboards',        'icono' => 'fas fa-circuit-board',        'descripcion' => 'Placas madre Intel y AMD para armado y actualización de equipos.', 'orden' => 2]);
        $this->ins(['parent_id' => $compnId, 'nivel' => 3, 'nombre' => 'Memorias RAM',         'slug' => 'memorias-ram',        'icono' => 'fas fa-memory',               'descripcion' => 'Memorias DDR4 y DDR5 para laptops y escritorios de todas las marcas.', 'orden' => 3]);
        $this->ins(['parent_id' => $compnId, 'nivel' => 3, 'nombre' => 'Placas de Video',      'slug' => 'placas-video',        'icono' => 'fas fa-film',                 'descripcion' => 'GPUs NVIDIA y AMD para gaming, diseño y renderizado.', 'orden' => 4]);
        $this->ins(['parent_id' => $compnId, 'nivel' => 3, 'nombre' => 'Fuentes de Poder',     'slug' => 'fuentes',             'icono' => 'fas fa-bolt',                 'descripcion' => 'Fuentes ATX certificadas 80 Plus para todo tipo de configuración.', 'orden' => 5]);
        $this->ins(['parent_id' => $compnId, 'nivel' => 3, 'nombre' => 'Gabinetes',            'slug' => 'gabinetes',           'icono' => 'fas fa-box-open',             'descripcion' => 'Gabinetes ATX, mATX e ITX con o sin RGB para todo tipo de armado.', 'orden' => 6]);
        $this->ins(['parent_id' => $compnId, 'nivel' => 3, 'nombre' => 'Discos SSD',           'slug' => 'discos-ssd',          'icono' => 'fas fa-hard-drive',           'descripcion' => 'SSDs SATA y NVMe M.2 para máxima velocidad de arranque y carga.', 'orden' => 7]);
        $this->ins(['parent_id' => $compnId, 'nivel' => 3, 'nombre' => 'Discos HDD',           'slug' => 'discos-hdd',          'icono' => 'fas fa-server',               'descripcion' => 'Discos duros de gran capacidad para almacenamiento masivo y backup.', 'orden' => 8]);
        $this->ins(['parent_id' => $compnId, 'nivel' => 3, 'nombre' => 'Refrigeración Líquida','slug' => 'refrigeracion',       'icono' => 'fas fa-fan',                  'descripcion' => 'Kits AIO de refrigeración líquida para mantener tu CPU al óptimo.', 'orden' => 9]);
        $this->ins(['parent_id' => $compnId, 'nivel' => 3, 'nombre' => 'Coolers',              'slug' => 'coolers',             'icono' => 'fas fa-wind',                 'descripcion' => 'Disipadores de aire para CPU y fans de torre para tu gabinete.', 'orden' => 10]);
        $this->ins(['parent_id' => $compnId, 'nivel' => 3, 'nombre' => 'Pasta Térmica',        'slug' => 'pasta-termica',       'icono' => 'fas fa-droplet',              'descripcion' => 'Pastas conductoras para optimizar la transferencia de calor del CPU.', 'orden' => 11]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / GAMING
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $gamId,   'nivel' => 3, 'nombre' => 'Sillas Gamer',         'slug' => 'sillas-gamer',        'icono' => 'fas fa-chair',                'descripcion' => 'Sillas ergonómicas gamer reclinables para largas sesiones de juego.', 'orden' => 1]);
        $this->ins(['parent_id' => $gamId,   'nivel' => 3, 'nombre' => 'Teclados Gamer',       'slug' => 'teclados-gamer',      'icono' => 'fas fa-keyboard',             'descripcion' => 'Teclados mecánicos y membrana RGB para gaming competitivo.', 'orden' => 2]);
        $this->ins(['parent_id' => $gamId,   'nivel' => 3, 'nombre' => 'Mouse Gamer',          'slug' => 'mouse-gamer',         'icono' => 'fas fa-computer-mouse',       'descripcion' => 'Ratones gaming de alta precisión con sensores ópticos premium.', 'orden' => 3]);
        $this->ins(['parent_id' => $gamId,   'nivel' => 3, 'nombre' => 'Mousepads',            'slug' => 'mousepads',           'icono' => 'fas fa-tablet-screen-button', 'descripcion' => 'Tapetes de escritorio XL y gamer para máxima precisión.', 'orden' => 4]);
        $this->ins(['parent_id' => $gamId,   'nivel' => 3, 'nombre' => 'Auriculares Gamer',    'slug' => 'auriculares-gamer',   'icono' => 'fas fa-headphones',           'descripcion' => 'Headsets con sonido envolvente y micrófono para horas de juego.', 'orden' => 5]);
        $this->ins(['parent_id' => $gamId,   'nivel' => 3, 'nombre' => 'Monitores Gamer',      'slug' => 'monitores-gamer',     'icono' => 'fas fa-display',              'descripcion' => 'Monitores de alta frecuencia de actualización para gaming fluido.', 'orden' => 6]);
        $this->ins(['parent_id' => $gamId,   'nivel' => 3, 'nombre' => 'Joysticks',            'slug' => 'joysticks',           'icono' => 'fas fa-gamepad',              'descripcion' => 'Controles y joysticks para PC compatibles con los títulos más populares.', 'orden' => 7]);
        $this->ins(['parent_id' => $gamId,   'nivel' => 3, 'nombre' => 'Streaming',            'slug' => 'streaming',           'icono' => 'fas fa-tower-broadcast',      'descripcion' => 'Capturadoras, micrófonos y luces para streamers profesionales.', 'orden' => 8]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / NOTEBOOKS
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $notId,   'nivel' => 3, 'nombre' => 'Notebooks',            'slug' => 'notebooks',           'icono' => 'fas fa-laptop',               'descripcion' => 'Laptops para trabajo, estudio y uso general de las principales marcas.', 'orden' => 1]);
        $this->ins(['parent_id' => $notId,   'nivel' => 3, 'nombre' => 'Ultrabooks',           'slug' => 'ultrabooks',          'icono' => 'fas fa-laptop-code',          'descripcion' => 'Laptops ultradelgadas y livianas de alto rendimiento para profesionales.', 'orden' => 2]);
        $this->ins(['parent_id' => $notId,   'nivel' => 3, 'nombre' => 'Chromebooks',          'slug' => 'chromebooks',         'icono' => 'fas fa-globe',                'descripcion' => 'Laptops con Chrome OS, rápidas y de larga batería para uso diario.', 'orden' => 3]);
        $this->ins(['parent_id' => $notId,   'nivel' => 3, 'nombre' => 'Tablets',              'slug' => 'tablets',             'icono' => 'fas fa-tablet-screen-button', 'descripcion' => 'Tablets Android, iPad y Windows para productividad y entretenimiento.', 'orden' => 4]);
        $this->ins(['parent_id' => $notId,   'nivel' => 3, 'nombre' => 'Accesorios Notebook',  'slug' => 'accesorios-notebook', 'icono' => 'fas fa-plug',                 'descripcion' => 'Hubs, adaptadores y teclados bluetooth para tu laptop.', 'orden' => 5]);
        $this->ins(['parent_id' => $notId,   'nivel' => 3, 'nombre' => 'Bases Refrigerantes',  'slug' => 'bases-refrigerantes', 'icono' => 'fas fa-fan',                  'descripcion' => 'Bases con ventiladores para mantener tu notebook fresca.', 'orden' => 6]);
        $this->ins(['parent_id' => $notId,   'nivel' => 3, 'nombre' => 'Mochilas',             'slug' => 'mochilas',            'icono' => 'fas fa-briefcase',            'descripcion' => 'Mochilas y bolsos para transportar tu laptop con seguridad.', 'orden' => 7]);
        $this->ins(['parent_id' => $notId,   'nivel' => 3, 'nombre' => 'Cargadores',           'slug' => 'cargadores',          'icono' => 'fas fa-charging-station',     'descripcion' => 'Cargadores universales, USB-C y originales para notebooks y tablets.', 'orden' => 8]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / IMPRESIÓN
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $impId,   'nivel' => 3, 'nombre' => 'Impresoras',           'slug' => 'impresoras',          'icono' => 'fas fa-print',                'descripcion' => 'Impresoras de inyección de tinta y láser para todo tipo de uso.', 'orden' => 1]);
        $this->ins(['parent_id' => $impId,   'nivel' => 3, 'nombre' => 'Multifunción',         'slug' => 'multifuncion',        'icono' => 'fas fa-copy',                 'descripcion' => 'Equipos todo-en-uno: imprime, escanea y copia.', 'orden' => 2]);
        $this->ins(['parent_id' => $impId,   'nivel' => 3, 'nombre' => 'Tintas',               'slug' => 'tintas',              'icono' => 'fas fa-fill-drip',            'descripcion' => 'Tintas originales y compatibles para todas las marcas.', 'orden' => 3]);
        $this->ins(['parent_id' => $impId,   'nivel' => 3, 'nombre' => 'Tóner',                'slug' => 'toner',               'icono' => 'fas fa-fill-drip',            'descripcion' => 'Tóneres originales y compatibles para impresoras láser.', 'orden' => 4]);
        $this->ins(['parent_id' => $impId,   'nivel' => 3, 'nombre' => 'Etiquetadoras',        'slug' => 'etiquetadoras',       'icono' => 'fas fa-tag',                  'descripcion' => 'Impresoras de etiquetas para comercio y logística.', 'orden' => 5]);
        $this->ins(['parent_id' => $impId,   'nivel' => 3, 'nombre' => 'Papel',                'slug' => 'papel',               'icono' => 'fas fa-file',                 'descripcion' => 'Resmas A4, papel fotográfico y especial para todo tipo de impresora.', 'orden' => 6]);
        $this->ins(['parent_id' => $impId,   'nivel' => 3, 'nombre' => 'Insumos',              'slug' => 'insumos',             'icono' => 'fas fa-box-open',             'descripcion' => 'Consumibles y repuestos: drums, fusores y kits de mantenimiento.', 'orden' => 7]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / REDES
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $redId,   'nivel' => 3, 'nombre' => 'Routers',              'slug' => 'routers',             'icono' => 'fas fa-wifi',                 'descripcion' => 'Routers Wi-Fi 5 y 6 para cobertura total en hogares y empresas.', 'orden' => 1]);
        $this->ins(['parent_id' => $redId,   'nivel' => 3, 'nombre' => 'Access Points',        'slug' => 'access-point',        'icono' => 'fas fa-tower-broadcast',      'descripcion' => 'Puntos de acceso Wi-Fi para ampliar la cobertura en grandes espacios.', 'orden' => 2]);
        $this->ins(['parent_id' => $redId,   'nivel' => 3, 'nombre' => 'Switches',             'slug' => 'switches',            'icono' => 'fas fa-network-wired',        'descripcion' => 'Switches no administrables y administrables para redes de empresa.', 'orden' => 3]);
        $this->ins(['parent_id' => $redId,   'nivel' => 3, 'nombre' => 'Cableado',             'slug' => 'cableado',            'icono' => 'fas fa-plug',                 'descripcion' => 'Cables UTP Cat5e, Cat6 y Cat6A para instalaciones estructuradas.', 'orden' => 4]);
        $this->ins(['parent_id' => $redId,   'nivel' => 3, 'nombre' => 'Placas de Red',        'slug' => 'placas-red',          'icono' => 'fas fa-ethernet',             'descripcion' => 'Tarjetas de red Gigabit y 2.5G para PCs de escritorio.', 'orden' => 5]);
        $this->ins(['parent_id' => $redId,   'nivel' => 3, 'nombre' => 'Adaptadores WiFi',     'slug' => 'adaptadores-wifi',    'icono' => 'fas fa-signal',               'descripcion' => 'Adaptadores USB y PCIe para agregar Wi-Fi a cualquier computadora.', 'orden' => 6]);
        $this->ins(['parent_id' => $redId,   'nivel' => 3, 'nombre' => 'Repetidores',          'slug' => 'repetidores',         'icono' => 'fas fa-arrows-rotate',        'descripcion' => 'Repetidores y amplificadores Wi-Fi para eliminar zonas sin señal.', 'orden' => 7]);
        $this->ins(['parent_id' => $redId,   'nivel' => 3, 'nombre' => 'Fibra Óptica',         'slug' => 'fibra-optica',        'icono' => 'fas fa-bolt',                 'descripcion' => 'Materiales y equipos para instalaciones de fibra óptica.', 'orden' => 8]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / SEGURIDAD
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $segId,   'nivel' => 3, 'nombre' => 'Cámaras IP',           'slug' => 'camaras-ip',          'icono' => 'fas fa-video',                'descripcion' => 'Cámaras IP para interiores y exteriores con visión nocturna.', 'orden' => 1]);
        $this->ins(['parent_id' => $segId,   'nivel' => 3, 'nombre' => 'Kits DVR',             'slug' => 'kits-dvr',            'icono' => 'fas fa-hard-drive',           'descripcion' => 'Kits completos de videovigilancia con grabador DVR y cámaras.', 'orden' => 2]);
        $this->ins(['parent_id' => $segId,   'nivel' => 3, 'nombre' => 'Cámaras WiFi',         'slug' => 'camaras-wifi',        'icono' => 'fas fa-camera',               'descripcion' => 'Cámaras inalámbricas para monitoreo fácil vía app.', 'orden' => 3]);
        $this->ins(['parent_id' => $segId,   'nivel' => 3, 'nombre' => 'Alarmas',              'slug' => 'alarmas',             'icono' => 'fas fa-bell',                 'descripcion' => 'Sistemas de alarma para hogar y empresa con comunicación GSM/WiFi.', 'orden' => 4]);
        $this->ins(['parent_id' => $segId,   'nivel' => 3, 'nombre' => 'Sensores',             'slug' => 'sensores',            'icono' => 'fas fa-circle-dot',           'descripcion' => 'Detectores de movimiento, apertura y humo para sistemas de alarma.', 'orden' => 5]);
        $this->ins(['parent_id' => $segId,   'nivel' => 3, 'nombre' => 'Videoporteros',        'slug' => 'videoporteros',       'icono' => 'fas fa-door-open',            'descripcion' => 'Intercomunicadores con cámara y apertura remota.', 'orden' => 6]);
        $this->ins(['parent_id' => $segId,   'nivel' => 3, 'nombre' => 'Control de Acceso',    'slug' => 'control-acceso',      'icono' => 'fas fa-id-card',              'descripcion' => 'Sistemas de acceso por tarjeta, huella y PIN para empresas.', 'orden' => 7]);
        $this->ins(['parent_id' => $segId,   'nivel' => 3, 'nombre' => 'UPS',                  'slug' => 'ups-seguridad',       'icono' => 'fas fa-battery-full',         'descripcion' => 'Alimentación ininterrumpida para cámaras y DVRs.', 'orden' => 8]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / PERIFÉRICOS
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $perId,   'nivel' => 3, 'nombre' => 'Teclados',             'slug' => 'teclados',            'icono' => 'fas fa-keyboard',             'descripcion' => 'Teclados de membrana, mecánicos e inalámbricos para uso diario.', 'orden' => 1]);
        $this->ins(['parent_id' => $perId,   'nivel' => 3, 'nombre' => 'Mouse',                'slug' => 'mouse',               'icono' => 'fas fa-computer-mouse',       'descripcion' => 'Ratones ópticos y láser con y sin cable para trabajo diario.', 'orden' => 2]);
        $this->ins(['parent_id' => $perId,   'nivel' => 3, 'nombre' => 'Parlantes',            'slug' => 'parlantes',           'icono' => 'fas fa-volume-high',          'descripcion' => 'Parlantes de escritorio y sistemas 2.1 para PC.', 'orden' => 3]);
        $this->ins(['parent_id' => $perId,   'nivel' => 3, 'nombre' => 'Auriculares',          'slug' => 'auriculares',         'icono' => 'fas fa-headphones',           'descripcion' => 'Auriculares con y sin cable para todo tipo de uso.', 'orden' => 4]);
        $this->ins(['parent_id' => $perId,   'nivel' => 3, 'nombre' => 'Webcams',              'slug' => 'webcams',             'icono' => 'fas fa-video',                'descripcion' => 'Cámaras web para videollamadas, streaming y home office.', 'orden' => 5]);
        $this->ins(['parent_id' => $perId,   'nivel' => 3, 'nombre' => 'Micrófonos',           'slug' => 'microfonos',          'icono' => 'fas fa-microphone',           'descripcion' => 'Micrófonos USB y XLR para streaming, podcast y videollamadas.', 'orden' => 6]);
        $this->ins(['parent_id' => $perId,   'nivel' => 3, 'nombre' => 'Lectores',             'slug' => 'lectores',            'icono' => 'fas fa-barcode',              'descripcion' => 'Lectores de código de barras, tarjetas y memorias.', 'orden' => 7]);
        $this->ins(['parent_id' => $perId,   'nivel' => 3, 'nombre' => 'Hubs USB',             'slug' => 'hubs-usb',            'icono' => 'fas fa-plug',                 'descripcion' => 'Concentradores USB 3.0 y USB-C para múltiples dispositivos.', 'orden' => 8]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / MONITORES
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $monId,   'nivel' => 3, 'nombre' => 'Monitores de Oficina', 'slug' => 'monitores-oficina',   'icono' => 'fas fa-display',              'descripcion' => 'Monitores IPS y VA para trabajo y productividad diaria.', 'orden' => 1]);
        $this->ins(['parent_id' => $monId,   'nivel' => 3, 'nombre' => 'Monitores Gamer',      'slug' => 'monitores-gamer-pantallas','icono' => 'fas fa-tv',             'descripcion' => 'Monitores de alta frecuencia para gaming fluido y competitivo.', 'orden' => 2]);
        $this->ins(['parent_id' => $monId,   'nivel' => 3, 'nombre' => 'Smart Displays',       'slug' => 'smart-displays',      'icono' => 'fas fa-tv',                   'descripcion' => 'Pantallas inteligentes con conectividad Android o Chrome.', 'orden' => 3]);
        $this->ins(['parent_id' => $monId,   'nivel' => 3, 'nombre' => 'Soportes',             'slug' => 'soportes',            'icono' => 'fas fa-border-all',           'descripcion' => 'Soportes de mesa y pared para monitores de todos los tamaños.', 'orden' => 4]);
        $this->ins(['parent_id' => $monId,   'nivel' => 3, 'nombre' => 'Brazos Articulados',   'slug' => 'brazos-articulados',  'icono' => 'fas fa-arrows-up-down-left-right','descripcion' => 'Brazos de escritorio con altura ajustable para ergonomía óptima.', 'orden' => 5]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / ALMACENAMIENTO
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $almId,   'nivel' => 3, 'nombre' => 'Pendrives',            'slug' => 'pendrives',           'icono' => 'fas fa-plug',                 'descripcion' => 'USB 3.0 y 3.2 de 32GB a 256GB para transferencia rápida.', 'orden' => 1]);
        $this->ins(['parent_id' => $almId,   'nivel' => 3, 'nombre' => 'SSD Externos',         'slug' => 'ssd-externos',        'icono' => 'fas fa-hard-drive',           'descripcion' => 'SSDs portátiles ultra rápidos para backup y archivos grandes.', 'orden' => 2]);
        $this->ins(['parent_id' => $almId,   'nivel' => 3, 'nombre' => 'HDD Externos',         'slug' => 'hdd-externos',        'icono' => 'fas fa-hdd',                  'descripcion' => 'Discos duros portátiles de gran capacidad para backup.', 'orden' => 3]);
        $this->ins(['parent_id' => $almId,   'nivel' => 3, 'nombre' => 'Tarjetas SD',          'slug' => 'tarjetas-sd',         'icono' => 'fas fa-sd-card',              'descripcion' => 'MicroSD y SD para cámaras, drones y tablets de alta velocidad.', 'orden' => 4]);
        $this->ins(['parent_id' => $almId,   'nivel' => 3, 'nombre' => 'NAS',                  'slug' => 'nas',                 'icono' => 'fas fa-server',               'descripcion' => 'Servidores de almacenamiento en red para backup centralizado.', 'orden' => 5]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / ENERGÍA
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $eneId,   'nivel' => 3, 'nombre' => 'UPS',                  'slug' => 'ups',                 'icono' => 'fas fa-battery-full',         'descripcion' => 'Alimentación ininterrumpida para PC, routers y equipos críticos.', 'orden' => 1]);
        $this->ins(['parent_id' => $eneId,   'nivel' => 3, 'nombre' => 'Estabilizadores',      'slug' => 'estabilizadores',     'icono' => 'fas fa-gauge',                'descripcion' => 'Reguladores de tensión para proteger equipos de fluctuaciones.', 'orden' => 2]);
        $this->ins(['parent_id' => $eneId,   'nivel' => 3, 'nombre' => 'Protectores',          'slug' => 'protectores',         'icono' => 'fas fa-shield',               'descripcion' => 'Zapatillas y protectores de tensión contra picos eléctricos.', 'orden' => 3]);
        $this->ins(['parent_id' => $eneId,   'nivel' => 3, 'nombre' => 'Fuentes Universales',  'slug' => 'fuentes-universales', 'icono' => 'fas fa-plug',                 'descripcion' => 'Fuentes de alimentación universal para laptops y dispositivos.', 'orden' => 4]);
        $this->ins(['parent_id' => $eneId,   'nivel' => 3, 'nombre' => 'Pilas y Baterías',     'slug' => 'pilas-baterias',      'icono' => 'fas fa-battery-half',         'descripcion' => 'Pilas alcalinas, recargables y baterías de litio para periféricos.', 'orden' => 5]);

        // ══════════════════════════════════════════
        //  NIVEL 3 — INFORMÁTICA / OFICINA TEC.
        // ══════════════════════════════════════════
        $this->ins(['parent_id' => $ofTecId, 'nivel' => 3, 'nombre' => 'Calculadoras',         'slug' => 'calculadoras',        'icono' => 'fas fa-calculator',           'descripcion' => 'Calculadoras científicas, financieras y de escritorio.', 'orden' => 1]);
        $this->ins(['parent_id' => $ofTecId, 'nivel' => 3, 'nombre' => 'Teléfonos IP',         'slug' => 'telefonos-ip',        'icono' => 'fas fa-phone',                'descripcion' => 'Teléfonos VoIP para centralitas y comunicaciones empresariales.', 'orden' => 2]);
        $this->ins(['parent_id' => $ofTecId, 'nivel' => 3, 'nombre' => 'Destructoras',         'slug' => 'destructoras',        'icono' => 'fas fa-file-circle-xmark',    'descripcion' => 'Destructoras de documentos en tiras y partículas para seguridad.', 'orden' => 3]);
        $this->ins(['parent_id' => $ofTecId, 'nivel' => 3, 'nombre' => 'Proyectores',          'slug' => 'proyectores',         'icono' => 'fas fa-film',                 'descripcion' => 'Proyectores para presentaciones, aulas y entretenimiento.', 'orden' => 4]);
        $this->ins(['parent_id' => $ofTecId, 'nivel' => 3, 'nombre' => 'Pantallas Proyección', 'slug' => 'pantallas-proyeccion','icono' => 'fas fa-expand',               'descripcion' => 'Pantallas enrollables y fijas para proyectores en oficinas.', 'orden' => 5]);

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
