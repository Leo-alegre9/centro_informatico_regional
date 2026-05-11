<style>
    .catalogo-hero {
        background: linear-gradient(135deg, #070c1a 0%, var(--dark-2) 60%, #180a10 100%);
        padding: 3rem 0 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .catalogo-hero-glow {
        position: absolute;
        width: 450px; height: 450px;
        background: radial-gradient(circle, rgba(255,0,51,0.11) 0%, transparent 70%);
        top: -120px; right: -80px;
        border-radius: 50%;
        pointer-events: none;
    }
    .breadcrumb-cir {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 0.82rem;
        color: rgba(255,255,255,0.4);
        margin-bottom: 1.6rem;
        flex-wrap: wrap;
    }
    .breadcrumb-cir a {
        color: rgba(255,255,255,0.5);
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-cir a:hover { color: var(--rojo); }
    .breadcrumb-cir .sep { color: rgba(255,255,255,0.2); }
    .breadcrumb-cir .current { color: var(--rojo); font-weight: 600; }
    .catalogo-rubro-icon {
        width: 70px; height: 70px;
        background: rgba(255,0,51,0.1);
        border: 2px solid rgba(255,0,51,0.28);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: var(--rojo);
        margin-bottom: 1.1rem;
    }
    .catalogo-rubro-title {
        color: #fff;
        font-size: clamp(1.8rem, 3.5vw, 2.7rem);
        font-weight: 900;
        margin-bottom: 0.5rem;
        line-height: 1.15;
    }
    .catalogo-rubro-desc {
        color: rgba(255,255,255,0.58);
        font-size: 1rem;
        line-height: 1.75;
        max-width: 580px;
        margin-bottom: 0;
    }
    .rubros-nav {
        margin-top: 2.5rem;
        display: flex;
        gap: 0.55rem;
        flex-wrap: wrap;
    }
    .rubro-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 13px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        border: 1.5px solid rgba(255,255,255,0.13);
        color: rgba(255,255,255,0.6);
        transition: border-color 0.2s, color 0.2s, background 0.2s;
        white-space: nowrap;
    }
    .rubro-chip:hover {
        border-color: rgba(255,0,51,0.5);
        color: var(--rojo);
        background: rgba(255,0,51,0.05);
    }
    .rubro-chip.activo {
        background: var(--rojo);
        border-color: var(--rojo);
        color: #fff;
    }
</style>

<!-- ═══════════════════════════════════════════════
     CATÁLOGO HEADER
═══════════════════════════════════════════════ -->
<div class="catalogo-hero">
    <div class="catalogo-hero-glow"></div>
    <div class="container position-relative" style="z-index:1;">

        <nav class="breadcrumb-cir" aria-label="breadcrumb">
            <?php foreach ($breadcrumb as $i => $crumb): ?>
                <?php if ($i > 0): ?><span class="sep">/</span><?php endif; ?>
                <?php if ($crumb['url'] !== null): ?>
                    <a href="<?= esc($crumb['url']) ?>"><?php if ($i === 0): ?><i class="fas fa-home"></i> <?php endif; ?><?= esc($crumb['nombre']) ?></a>
                <?php else: ?>
                    <span class="current"><?= esc($crumb['nombre']) ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>

        <div class="catalogo-rubro-icon">
            <i class="<?= esc($current['icono']) ?>"></i>
        </div>
        <h1 class="catalogo-rubro-title"><?= esc($current['nombre']) ?></h1>
        <p class="catalogo-rubro-desc"><?= esc($current['descripcion']) ?></p>

        <?php if (!empty($siblings)): ?>
        <nav class="rubros-nav" aria-label="Navegación de rubros">
            <?php foreach ($siblings as $key => $sibling): ?>
            <a href="<?= esc($sibling['url']) ?>"
               class="rubro-chip <?= $sibling['activo'] ? 'activo' : '' ?>">
                <i class="<?= esc($sibling['icono']) ?>"></i>
                <?= esc($sibling['nombre']) ?>
            </a>
            <?php endforeach; ?>
        </nav>
        <?php endif; ?>

    </div>
</div>
