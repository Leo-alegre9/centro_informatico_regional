<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table         = 'categorias';
    protected $allowedFields = ['parent_id', 'nivel', 'nombre', 'slug', 'icono', 'descripcion', 'activo', 'orden'];
    protected $useTimestamps = true;

    public function getRubros(): array
    {
        return $this->where('nivel', 1)->where('activo', 1)->orderBy('orden', 'ASC')->findAll();
    }

    public function getChildren(int $parentId): array
    {
        return $this->where('parent_id', $parentId)->where('activo', 1)->orderBy('orden', 'ASC')->findAll();
    }

    public function getCategoriaMap(): array
    {
        return array_column($this->findAll(), null, 'id');
    }

    public function getPathForId(int $id, array $map): string
    {
        $parts   = [];
        $current = $map[$id] ?? null;
        while ($current) {
            array_unshift($parts, $current['nombre']);
            $current = $current['parent_id'] ? ($map[$current['parent_id']] ?? null) : null;
        }
        return implode(' › ', $parts);
    }

    /** Finds the deepest category matching the slug path. Returns null if not found. */
    public function findBySlugPath(string $rubro, ?string $subrubro = null, ?string $subSub = null): ?array
    {
        $nivel1 = $this->where('nivel', 1)->where('slug', $rubro)->where('activo', 1)->first();
        if (!$nivel1) {
            return null;
        }

        if ($subrubro === null) {
            return $nivel1;
        }

        $nivel2 = $this->where('nivel', 2)->where('parent_id', $nivel1['id'])->where('slug', $subrubro)->where('activo', 1)->first();
        if (!$nivel2) {
            return null;
        }

        if ($subSub === null) {
            return $nivel2;
        }

        return $this->where('nivel', 3)->where('parent_id', $nivel2['id'])->where('slug', $subSub)->where('activo', 1)->first();
    }

    /**
     * Builds the JERARQUIA structure for the admin product form JS.
     * Returns an associative array keyed by rubro slug.
     */
    public function buildJerarquia(): array
    {
        $all = $this->where('activo', 1)->orderBy('nivel', 'ASC')->orderBy('orden', 'ASC')->findAll();

        $byId  = array_column($all, null, 'id');
        $jerarquia = [];

        foreach ($all as $cat) {
            if ((int)$cat['nivel'] === 1) {
                $jerarquia[$cat['slug']] = [
                    'id'         => (int)$cat['id'],
                    'nombre'     => $cat['nombre'],
                    'subrubros'  => [],
                    'labels'     => [],
                    'ids'        => [],
                    'tieneSubSub'=> false,
                    'subSub'     => [],
                ];
            }
        }

        foreach ($all as $cat) {
            if ((int)$cat['nivel'] === 2 && $cat['parent_id']) {
                $parentSlug = $byId[$cat['parent_id']]['slug'] ?? null;
                if ($parentSlug && isset($jerarquia[$parentSlug])) {
                    $jerarquia[$parentSlug]['subrubros'][] = $cat['slug'];
                    $jerarquia[$parentSlug]['labels'][]    = $cat['nombre'];
                    $jerarquia[$parentSlug]['ids'][]       = (int)$cat['id'];
                }
            }
        }

        foreach ($all as $cat) {
            if ((int)$cat['nivel'] === 3 && $cat['parent_id']) {
                $parent      = $byId[$cat['parent_id']] ?? null;
                if (!$parent) continue;
                $grandparent = $byId[$parent['parent_id']] ?? null;
                if (!$grandparent) continue;

                $rubroSlug   = $grandparent['slug'];
                $subSlug     = $parent['slug'];

                if (!isset($jerarquia[$rubroSlug])) continue;

                $jerarquia[$rubroSlug]['tieneSubSub'] = true;

                if (!isset($jerarquia[$rubroSlug]['subSub'][$subSlug])) {
                    $jerarquia[$rubroSlug]['subSub'][$subSlug] = ['keys' => [], 'labels' => [], 'ids' => []];
                }

                $jerarquia[$rubroSlug]['subSub'][$subSlug]['keys'][]   = $cat['slug'];
                $jerarquia[$rubroSlug]['subSub'][$subSlug]['labels'][] = $cat['nombre'];
                $jerarquia[$rubroSlug]['subSub'][$subSlug]['ids'][]    = (int)$cat['id'];
            }
        }

        return $jerarquia;
    }

    /** Returns the rubro/subrubro/sub_subrubro slug path for a given leaf categoria_id. */
    public function getSlugPath(int $categoriaId): array
    {
        $map  = $this->getCategoriaMap();
        $cat  = $map[$categoriaId] ?? null;
        $path = ['rubro' => '', 'subrubro' => '', 'sub_subrubro' => ''];

        if (!$cat) {
            return $path;
        }

        if ((int)$cat['nivel'] === 2) {
            $parent = $map[$cat['parent_id']] ?? null;
            $path['rubro']    = $parent['slug'] ?? '';
            $path['subrubro'] = $cat['slug'];
        } elseif ((int)$cat['nivel'] === 3) {
            $parent      = $map[$cat['parent_id']] ?? null;
            $grandparent = $parent ? ($map[$parent['parent_id']] ?? null) : null;
            $path['rubro']        = $grandparent['slug'] ?? '';
            $path['subrubro']     = $parent['slug'] ?? '';
            $path['sub_subrubro'] = $cat['slug'];
        }

        return $path;
    }
}
