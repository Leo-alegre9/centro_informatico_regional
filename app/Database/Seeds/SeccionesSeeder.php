<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeccionesSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        // ── 1. Insertar secciones base ────────────────────────────────────────

        $secciones = [
            [
                'slug'        => 'inicio',
                'nombre'      => 'Página de inicio',
                'descripcion' => 'Aparece en el carrusel de productos de la página principal.',
                'icono'       => 'fas fa-home',
                'activo'      => 1,
                'orden'       => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'catalogo',
                'nombre'      => 'Catálogo general',
                'descripcion' => 'Aparece en la sección destacada del índice del catálogo.',
                'icono'       => 'fas fa-th-large',
                'activo'      => 1,
                'orden'       => 2,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'rubro',
                'nombre'      => 'Sección de rubro',
                'descripcion' => 'Aparece como producto destacado al explorar el rubro principal.',
                'icono'       => 'fas fa-folder-open',
                'activo'      => 1,
                'orden'       => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'subrubro',
                'nombre'      => 'Subrubro / Categoría',
                'descripcion' => 'Aparece en la página de su subrubro o categoría directa.',
                'icono'       => 'fas fa-tag',
                'activo'      => 1,
                'orden'       => 4,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'destacado',
                'nombre'      => 'Carrusel destacado',
                'descripcion' => 'Aparece en los carruseles de productos destacados del catálogo.',
                'icono'       => 'fas fa-star',
                'activo'      => 1,
                'orden'       => 5,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'carrusel_promo',
                'nombre'      => 'Carrusel promocional',
                'descripcion' => 'Reservado para carruseles de promociones y ofertas especiales.',
                'icono'       => 'fas fa-bullhorn',
                'activo'      => 1,
                'orden'       => 6,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        $this->db->table('secciones')->insertBatch($secciones);

        // ── 2. Obtener IDs de secciones recién creadas ────────────────────────

        $seccionIds = [];
        foreach ($this->db->table('secciones')->get()->getResultArray() as $row) {
            $seccionIds[$row['slug']] = (int) $row['id'];
        }

        // ── 3. Migrar productos existentes ────────────────────────────────────

        $productos = $this->db
            ->table('productos')
            ->select('id, activo, destacado')
            ->get()
            ->getResultArray();

        $pivotRows = [];

        foreach ($productos as $p) {
            $pid = (int) $p['id'];

            if ((int) $p['activo'] === 1) {
                // Todo producto activo se muestra en su subrubro (comportamiento actual)
                $pivotRows[] = [
                    'producto_id' => $pid,
                    'seccion_id'  => $seccionIds['subrubro'],
                    'activo'      => 1,
                    'orden'       => 0,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];
            }

            if ((int) $p['destacado'] === 1) {
                // Productos destacados pasan al carrusel de inicio
                $pivotRows[] = [
                    'producto_id' => $pid,
                    'seccion_id'  => $seccionIds['inicio'],
                    'activo'      => 1,
                    'orden'       => 0,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];

                // Y al carrusel destacado del catálogo
                $pivotRows[] = [
                    'producto_id' => $pid,
                    'seccion_id'  => $seccionIds['destacado'],
                    'activo'      => 1,
                    'orden'       => 0,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];
            }
        }

        if (!empty($pivotRows)) {
            $this->db->table('producto_secciones')->insertBatch($pivotRows);
        }

        echo "SeccionesSeeder: " . count($secciones) . " secciones creadas, " . count($pivotRows) . " asignaciones migradas.\n";
    }
}
