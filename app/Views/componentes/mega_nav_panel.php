<?php
/**
 * Mega Nav Panel — navegación por categorías con drill-down.
 *
 * Variables:
 *   $megaMenuData  array   Output de CategoriaModel::getMegaMenu()
 *   $mnpTema       string  'dark' (default) | 'light'
 */
$mnpTema = $mnpTema ?? 'dark';
$isDark  = ($mnpTema !== 'light');
$mnpId   = 'mnp-' . substr(md5(uniqid('', true)), 0, 8);

if (empty($megaMenuData)) return;
?>

<style>
#<?= $mnpId ?> {
    border-radius: 16px;
    overflow: hidden;
    background: <?= $isDark ? '#111827' : '#fff' ?>;
    <?= !$isDark ? 'border: 1.5px solid #e9ecef;' : '' ?>
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}

/* ── Chips row (desktop) ── */
#<?= $mnpId ?> .mnp-chips-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid <?= $isDark ? 'rgba(255,255,255,0.07)' : '#e9ecef' ?>;
}
#<?= $mnpId ?> .mnp-chip {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 0.45rem 1.1rem;
    border-radius: 50px;
    font-size: 0.84rem;
    font-weight: 600;
    cursor: pointer;
    border: 1.5px solid <?= $isDark ? 'rgba(255,255,255,0.12)' : '#dee2e6' ?>;
    background: <?= $isDark ? 'rgba(255,255,255,0.04)' : '#f8f9fa' ?>;
    color: <?= $isDark ? 'rgba(255,255,255,0.55)' : '#6B7280' ?>;
    transition: color .18s, background .18s, border-color .18s;
    white-space: nowrap;
    user-select: none;
}
#<?= $mnpId ?> .mnp-chip:hover {
    color: <?= $isDark ? '#fff' : '#111827' ?>;
    background: <?= $isDark ? 'rgba(255,255,255,0.09)' : '#f1f3f5' ?>;
    border-color: <?= $isDark ? 'rgba(255,255,255,0.22)' : '#adb5bd' ?>;
}
#<?= $mnpId ?> .mnp-chip.active {
    background: #FF0033;
    border-color: #FF0033;
    color: #fff;
}
#<?= $mnpId ?> .mnp-chip .mnp-arrow {
    font-size: 0.65rem;
    transition: transform .2s;
    opacity: .7;
}
#<?= $mnpId ?> .mnp-chip.active .mnp-arrow {
    transform: rotate(180deg);
    opacity: 1;
}

/* ── Panel de subrubros (desktop) ── */
#<?= $mnpId ?> .mnp-panel {
    padding: 1.4rem 1.25rem 1.5rem;
}
#<?= $mnpId ?> .mnp-pane-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 0.75rem;
    margin-bottom: 1rem;
    border-bottom: 1px solid <?= $isDark ? 'rgba(255,255,255,0.07)' : '#e9ecef' ?>;
}
#<?= $mnpId ?> .mnp-pane-title {
    font-size: .9rem;
    font-weight: 700;
    color: <?= $isDark ? '#fff' : '#111827' ?>;
    display: flex;
    align-items: center;
    gap: 7px;
}
#<?= $mnpId ?> .mnp-pane-title i { color: #FF0033; font-size: .82rem; }
#<?= $mnpId ?> .mnp-ver-todo {
    color: #FF0033;
    font-size: .8rem;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: gap .18s;
}
#<?= $mnpId ?> .mnp-ver-todo:hover { gap: 9px; }
#<?= $mnpId ?> .mnp-subs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1.25rem 1.5rem;
}
#<?= $mnpId ?> .mnp-sub-header {
    color: <?= $isDark ? 'rgba(255,255,255,0.85)' : '#111827' ?>;
    font-size: .84rem;
    font-weight: 700;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: .35rem;
    transition: color .15s;
}
#<?= $mnpId ?> .mnp-sub-header:hover { color: #FF0033; }
#<?= $mnpId ?> .mnp-sub-header i { font-size: .73rem; opacity: .6; flex-shrink: 0; }
#<?= $mnpId ?> .mnp-subsub-link {
    color: <?= $isDark ? 'rgba(255,255,255,0.42)' : '#6B7280' ?>;
    font-size: .77rem;
    text-decoration: none;
    display: block;
    padding: 2px 0 2px .1rem;
    transition: color .15s;
}
#<?= $mnpId ?> .mnp-subsub-link:hover { color: #FF0033; }

/* ── Accordion (mobile) — oculto en desktop ── */
#<?= $mnpId ?> .mnp-accordion { display: none; }

@media (max-width: 767px) {
    #<?= $mnpId ?> .mnp-chips-row { display: none !important; }
    #<?= $mnpId ?> .mnp-panel     { display: none !important; }
    #<?= $mnpId ?> .mnp-accordion { display: block !important; }

    #<?= $mnpId ?> .mnp-acc-item {
        border-bottom: 1px solid <?= $isDark ? 'rgba(255,255,255,0.07)' : '#e9ecef' ?>;
    }
    #<?= $mnpId ?> .mnp-acc-item:last-child { border-bottom: none; }
    #<?= $mnpId ?> .mnp-acc-hdr {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .8rem 1rem;
        cursor: pointer;
        color: <?= $isDark ? 'rgba(255,255,255,0.8)' : '#374151' ?>;
        font-size: .9rem;
        font-weight: 700;
        user-select: none;
        transition: color .15s;
    }
    #<?= $mnpId ?> .mnp-acc-hdr:hover { color: #FF0033; }
    #<?= $mnpId ?> .mnp-acc-hdr .mnp-acc-left { display: flex; align-items: center; gap: 8px; }
    #<?= $mnpId ?> .mnp-acc-hdr .mnp-acc-arrow {
        font-size: .68rem;
        transition: transform .22s;
        opacity: .5;
    }
    #<?= $mnpId ?> .mnp-acc-hdr.open .mnp-acc-arrow { transform: rotate(180deg); opacity: 1; }
    #<?= $mnpId ?> .mnp-acc-body { display: none; padding: .4rem 1rem .9rem; }
    #<?= $mnpId ?> .mnp-acc-body.open { display: block; }
    #<?= $mnpId ?> .mnp-acc-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: .6rem;
        margin-bottom: .6rem;
    }
    #<?= $mnpId ?> .mnp-acc-link {
        color: <?= $isDark ? 'rgba(255,255,255,0.55)' : '#6B7280' ?>;
        font-size: .82rem;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: .4rem .6rem;
        border-radius: 8px;
        border: 1px solid <?= $isDark ? 'rgba(255,255,255,0.07)' : '#e9ecef' ?>;
        background: <?= $isDark ? 'rgba(255,255,255,0.02)' : 'rgba(0,0,0,0.02)' ?>;
        transition: color .15s, border-color .15s, background .15s;
    }
    #<?= $mnpId ?> .mnp-acc-link:hover {
        color: #FF0033;
        border-color: rgba(255,0,51,.25);
        background: rgba(255,0,51,.04);
    }
    #<?= $mnpId ?> .mnp-acc-link i { font-size: .7rem; flex-shrink: 0; }
    #<?= $mnpId ?> .mnp-acc-ver-todo {
        color: #FF0033;
        font-size: .79rem;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        transition: gap .18s;
        margin-top: .25rem;
    }
    #<?= $mnpId ?> .mnp-acc-ver-todo:hover { gap: 9px; }
}
</style>

<div id="<?= $mnpId ?>">

    <!-- ── Fila de chips (desktop) ── -->
    <div class="mnp-chips-row">
        <?php foreach ($megaMenuData as $rubro): ?>
        <button type="button" class="mnp-chip"
                data-pane="<?= $mnpId ?>-pane-<?= (int) $rubro['id'] ?>">
            <i class="<?= esc($rubro['icono']) ?>"></i>
            <?= esc($rubro['nombre']) ?>
            <i class="fas fa-chevron-down mnp-arrow"></i>
        </button>
        <?php endforeach; ?>
    </div>

    <!-- ── Panel de contenido (desktop) — oculto por defecto ── -->
    <div class="mnp-panel" id="<?= $mnpId ?>-panel" style="display:none;">
        <?php foreach ($megaMenuData as $rubro): ?>
        <div id="<?= $mnpId ?>-pane-<?= (int) $rubro['id'] ?>" style="display:none;">
            <div class="mnp-pane-header">
                <span class="mnp-pane-title">
                    <i class="<?= esc($rubro['icono']) ?>"></i>
                    <?= esc($rubro['nombre']) ?>
                </span>
                <a href="<?= base_url('catalogo/' . esc($rubro['slug'])) ?>" class="mnp-ver-todo">
                    Ver todo <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <?php if (!empty($rubro['hijos'])): ?>
            <div class="mnp-subs-grid">
                <?php foreach ($rubro['hijos'] as $sub): ?>
                <div>
                    <a href="<?= base_url('catalogo/' . esc($rubro['slug']) . '/' . esc($sub['slug'])) ?>"
                       class="mnp-sub-header">
                        <i class="<?= esc($sub['icono']) ?>"></i>
                        <?= esc($sub['nombre']) ?>
                    </a>
                    <?php foreach ($sub['hijos'] as $subsub): ?>
                    <a href="<?= base_url('catalogo/' . esc($rubro['slug']) . '/' . esc($sub['slug']) . '/' . esc($subsub['slug'])) ?>"
                       class="mnp-subsub-link">
                        <?= esc($subsub['nombre']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <a href="<?= base_url('catalogo/' . esc($rubro['slug'])) ?>" class="mnp-ver-todo">
                <i class="<?= esc($rubro['icono']) ?>"></i>
                Explorar <?= esc($rubro['nombre']) ?> <i class="fas fa-arrow-right"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ── Acordeón (mobile) ── -->
    <div class="mnp-accordion">
        <?php foreach ($megaMenuData as $rubro): ?>
        <div class="mnp-acc-item">
            <div class="mnp-acc-hdr" role="button" tabindex="0">
                <span class="mnp-acc-left">
                    <i class="<?= esc($rubro['icono']) ?>"></i>
                    <?= esc($rubro['nombre']) ?>
                </span>
                <i class="fas fa-chevron-down mnp-acc-arrow"></i>
            </div>
            <div class="mnp-acc-body">
                <?php if (!empty($rubro['hijos'])): ?>
                <div class="mnp-acc-grid">
                    <?php foreach ($rubro['hijos'] as $sub): ?>
                    <a href="<?= base_url('catalogo/' . esc($rubro['slug']) . '/' . esc($sub['slug'])) ?>"
                       class="mnp-acc-link">
                        <i class="<?= esc($sub['icono']) ?>"></i>
                        <?= esc($sub['nombre']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <a href="<?= base_url('catalogo/' . esc($rubro['slug'])) ?>" class="mnp-acc-ver-todo">
                    Ver todo en <?= esc($rubro['nombre']) ?> <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>

<script>
(function () {
    var wrap = document.getElementById('<?= $mnpId ?>');
    if (!wrap) return;

    var panel     = document.getElementById('<?= $mnpId ?>-panel');
    var chips     = wrap.querySelectorAll('.mnp-chip');
    var activeId  = null; // ID del pane activo

    /* ── Desktop: chip → mostrar/ocultar panel ── */
    chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            var paneId  = chip.dataset.pane;
            var same    = (activeId === paneId);

            /* Ocultar pane anterior */
            if (activeId) {
                var prev = document.getElementById(activeId);
                if (prev) prev.style.display = 'none';
            }
            chips.forEach(function (c) { c.classList.remove('active'); });

            if (same) {
                /* Mismo chip: cerrar todo */
                panel.style.display = 'none';
                activeId = null;
            } else {
                /* Chip nuevo: mostrar pane */
                var pane = document.getElementById(paneId);
                if (pane) pane.style.display = 'block';
                panel.style.display = 'block';
                chip.classList.add('active');
                activeId = paneId;
            }
        });
    });

    /* ── Mobile: acordeón ── */
    wrap.querySelectorAll('.mnp-acc-hdr').forEach(function (hdr) {
        function toggle() {
            var body   = hdr.nextElementSibling;
            var isOpen = body.classList.contains('open');
            wrap.querySelectorAll('.mnp-acc-body').forEach(function (b) { b.classList.remove('open'); });
            wrap.querySelectorAll('.mnp-acc-hdr').forEach(function (h) { h.classList.remove('open'); });
            if (!isOpen) {
                body.classList.add('open');
                hdr.classList.add('open');
            }
        }
        hdr.addEventListener('click', toggle);
        hdr.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggle(); }
        });
    });
})();
</script>
