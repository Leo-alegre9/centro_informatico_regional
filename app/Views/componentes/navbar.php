<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    /* ══════════════════════════════════════════════════════════
       MEGA DROPDOWN — Estilo Naldo: sidebar + columnas de cats
    ══════════════════════════════════════════════════════════ */
    .mega-dropdown {
        position: fixed;
        top: var(--header-h, 120px);
        left: 0; right: 0;
        background: #fff;
        z-index: 1028;
        box-shadow: 0 12px 32px rgba(0,0,0,0.1), 0 2px 8px rgba(0,0,0,0.06);
        display: none;
        border-top: 3px solid #FF0033;
        animation: megaSlideIn 0.2s cubic-bezier(.4,0,.2,1);
    }
    @keyframes megaSlideIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .mega-dropdown.open { display: block; }

    /* ── Layout principal: sidebar | panel ── */
    .mega-body {
        display: flex;
        max-width: 1400px;
        margin: 0 auto;
        max-height: 500px;
        min-height: 360px;
    }

    /* ══ Sidebar izquierdo ══════════════════════════════════ */
    .mega-sidebar {
        width: 245px;
        flex-shrink: 0;
        background: #F7F8FA;
        border-right: 1px solid #E8ECF0;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
    }
    .mega-sidebar-hdr {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.9rem 1.1rem 0.7rem;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.76rem;
        font-weight: 800;
        color: #111827;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        border-bottom: 1px solid #E8ECF0;
        flex-shrink: 0;
    }
    .mega-sidebar-hdr i { color: #FF0033; font-size: 0.78rem; }

    .mega-rubro-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 0.62rem 1.1rem;
        cursor: pointer;
        user-select: none;
        border-left: 3px solid transparent;
        background: transparent;
        transition: background 0.12s, border-color 0.12s;
        text-decoration: none;
    }
    .mega-rubro-item:hover {
        background: #ECEEF2;
        border-left-color: rgba(255,0,51,0.35);
    }
    .mega-rubro-item.active {
        background: #fff;
        border-left-color: #FF0033;
    }
    .mri-icon {
        width: 28px; height: 28px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 6px;
        background: #E5E7EB;
        color: #6B7280;
        font-size: 0.74rem;
        flex-shrink: 0;
        transition: background 0.12s, color 0.12s;
    }
    .mega-rubro-item:hover .mri-icon,
    .mega-rubro-item.active .mri-icon {
        background: rgba(255,0,51,0.09);
        color: #FF0033;
    }
    .mri-name {
        flex: 1;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.84rem;
        font-weight: 500;
        color: #374151;
        transition: color 0.12s;
        white-space: nowrap;
    }
    .mega-rubro-item:hover .mri-name,
    .mega-rubro-item.active .mri-name {
        color: #111827;
        font-weight: 600;
    }
    .mri-arrow {
        font-size: 0.58rem;
        color: #C9CDD4;
        flex-shrink: 0;
        transition: color 0.12s;
    }
    .mega-rubro-item.active .mri-arrow { color: #FF0033; }

    .mega-sidebar-footer {
        margin-top: auto;
        padding: 0.7rem 1.1rem;
        border-top: 1px solid #E8ECF0;
        flex-shrink: 0;
    }
    .mega-sidebar-all-link {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #FF0033;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.76rem;
        font-weight: 700;
        text-decoration: none;
        transition: opacity 0.14s;
    }
    .mega-sidebar-all-link:hover { opacity: 0.72; }

    /* ══ Panel derecho: columnas de categorías ══════════════ */
    .mega-panel-wrap {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #fff;
    }

    .mega-panel {
        flex: 1;
        display: none;
        flex-direction: column;
        animation: megaPanelIn 0.16s ease;
        min-height: 0;
    }
    .mega-panel.active { display: flex; }
    @keyframes megaPanelIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    /* Fila de columnas (scrollable horizontalmente si hay muchas) */
    .mega-panel-cols {
        flex: 1;
        display: flex;
        overflow-x: auto;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #E5E7EB transparent;
    }
    .mega-panel-cols::-webkit-scrollbar { height: 4px; }
    .mega-panel-cols::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 4px; }

    /* Una columna = una subcategoría */
    .mega-panel-col {
        flex: 1;
        min-width: 160px;
        max-width: 215px;
        padding: 1.2rem 1rem 1rem;
        display: flex;
        flex-direction: column;
        border-right: 1px solid #F0F2F5;
    }
    .mega-panel-col:last-child { border-right: none; }

    /* Título de la subcategoría */
    .mpc-title {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        color: #111827;
        text-decoration: none;
        display: block;
        margin-bottom: 0.6rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: color 0.13s;
        line-height: 1.3;
    }
    .mpc-title:hover { color: #FF0033; }

    /* Imagen representativa (placeholder con ícono) */
    .mpc-img {
        width: 100%;
        aspect-ratio: 1.75;
        background: #F5F7FA;
        border: 1px solid #EEF0F3;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
        flex-shrink: 0;
        overflow: hidden;
        transition: background 0.15s, border-color 0.15s;
    }
    .mega-panel-col:hover .mpc-img {
        background: #EEF1F8;
        border-color: #D8DCE6;
    }
    .mpc-img i {
        font-size: 1.65rem;
        color: #C4C9D4;
        transition: color 0.15s;
    }
    .mega-panel-col:hover .mpc-img i { color: #9CA3AF; }

    /* Lista de sub-subcategorías */
    .mpc-list {
        list-style: none;
        padding: 0; margin: 0;
        flex: 1;
    }
    .mpc-list li { padding: 0; margin: 0; }
    .mpc-list li a {
        display: block;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.76rem;
        color: #6B7280;
        text-decoration: none;
        padding: 3px 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: color 0.12s;
    }
    .mpc-list li a:hover { color: #111827; }
    .mpc-list li a::before {
        content: '·';
        margin-right: 5px;
        color: #D1D5DB;
    }

    /* "Ver todo" de cada columna */
    .mpc-all {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.73rem;
        font-weight: 600;
        color: #FF0033;
        text-decoration: none;
        margin-top: 0.5rem;
        flex-shrink: 0;
        transition: gap 0.14s, color 0.13s;
    }
    .mpc-all:hover { gap: 7px; color: #cc0029; }
    .mpc-all i { font-size: 0.57rem; }

    /* Footer del panel: "Ver todo en [Rubro]" */
    .mega-panel-footer {
        flex-shrink: 0;
        padding: 0.55rem 1.1rem;
        border-top: 1px solid #F0F2F5;
        background: #FAFBFC;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .mega-panel-footer-title {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.74rem;
        font-weight: 600;
        color: #9CA3AF;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .mega-panel-footer-title i { font-size: 0.68rem; }
    .mega-panel-footer-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.74rem;
        font-weight: 700;
        color: #FF0033;
        text-decoration: none;
        transition: gap 0.14s;
    }
    .mega-panel-footer-link:hover { gap: 8px; }
    .mega-panel-footer-link i { font-size: 0.58rem; }

    /* Placeholder cuando no hay nada seleccionado */
    .mega-panel-placeholder {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #D1D5DB;
        font-family: 'Inter', system-ui, sans-serif;
    }
    .mega-panel-placeholder i { font-size: 2rem; }
    .mega-panel-placeholder span { font-size: 0.82rem; }

    /* ══════════════════════════════════════════════════════════
       SITE HEADER — fondo blanco, comercial, premium
    ══════════════════════════════════════════════════════════ */
    .site-header {
        background: #fff;
        position: sticky;
        top: 0;
        z-index: 1030;
        box-shadow: 0 1px 0 #E8ECF0;
        transition: box-shadow 0.3s ease;
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
    }
    .site-header.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.1); }

    /* ── Barra superior ── */
    .header-top { border-bottom: 1px solid #EEF0F3; }
    .header-top-inner {
        display: grid;
        grid-template-columns: 22fr 56fr 22fr;
        align-items: center;
        gap: 1.25rem;
        height: 78px;
        transition: height 0.3s ease;
    }
    .site-header.scrolled .header-top-inner { height: 60px; }

    /* ── Brand ── */
    .header-brand {
        display: flex; align-items: center; gap: 10px;
        text-decoration: none; flex-shrink: 0; transition: opacity 0.2s;
    }
    .header-brand:hover { opacity: 0.85; }
    .header-logo {
        height: 50px; width: auto; object-fit: contain;
        display: block; flex-shrink: 0; transition: height 0.3s ease;
    }
    .site-header.scrolled .header-logo { height: 38px; }
    .header-brand-text { display: flex; flex-direction: column; gap: 1px; line-height: 1.1; }
    .brand-main {
        color: #111827; font-size: 0.9rem; font-weight: 800;
        letter-spacing: 0.03em; text-transform: uppercase; white-space: nowrap;
        transition: font-size 0.3s;
    }
    .site-header.scrolled .brand-main { font-size: 0.8rem; }
    .brand-sub {
        color: #FF0033; font-size: 0.6rem; font-weight: 700;
        letter-spacing: 0.28em; text-transform: uppercase; white-space: nowrap;
        transition: font-size 0.3s;
    }
    .site-header.scrolled .brand-sub { font-size: 0.55rem; }

    /* ── Buscador ── */
    .header-search {
        display: flex; align-items: center;
        background: #F4F6F9; border: 1.5px solid #E8ECF0; border-radius: 50px;
        overflow: hidden; transition: border-color 0.22s, box-shadow 0.22s; width: 100%;
    }
    .header-search:focus-within {
        border-color: #FF0033; box-shadow: 0 0 0 3px rgba(255,0,51,0.08); background: #fff;
    }
    .header-search-input {
        flex: 1; border: none; background: transparent; padding: 0.6rem 1.1rem;
        font-family: 'Inter', system-ui, sans-serif; font-size: 0.875rem;
        color: #111827; outline: none; min-width: 0;
    }
    .header-search-input::placeholder { color: #9CA3AF; }
    .header-search-btn {
        display: flex; align-items: center; justify-content: center;
        width: 44px; height: 44px; background: #FF0033; border: none;
        border-radius: 0 50px 50px 0; color: #fff; font-size: 0.9rem;
        cursor: pointer; flex-shrink: 0; transition: background 0.2s;
    }
    .header-search-btn:hover { background: #cc0029; }

    /* ── Acciones ── */
    .header-actions {
        display: flex; align-items: center; justify-content: flex-end; gap: 0.6rem;
    }
    .header-wa-btn {
        display: inline-flex; align-items: center; gap: 7px;
        background: #FF0033; color: #fff !important;
        font-family: 'Inter', system-ui, sans-serif; font-size: 0.84rem; font-weight: 700;
        padding: 0.5rem 1.2rem; border-radius: 50px; text-decoration: none; white-space: nowrap;
        box-shadow: 0 3px 12px rgba(255,0,51,0.25);
        transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
    }
    .header-wa-btn:hover {
        background: #cc0029; box-shadow: 0 5px 18px rgba(255,0,51,0.38);
        transform: translateY(-1px); color: #fff !important;
    }
    .header-admin-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: #FFF5F7; border: 1.5px solid rgba(255,0,51,0.25);
        color: #FF0033 !important; font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.8rem; font-weight: 700; padding: 0.42rem 0.9rem;
        border-radius: 50px; text-decoration: none; white-space: nowrap;
        transition: background 0.2s, border-color 0.2s;
    }
    .header-admin-badge:hover {
        background: #FFE4EA; border-color: rgba(255,0,51,0.45); color: #FF0033 !important;
    }
    .header-admin-logout {
        display: flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 8px;
        background: #F9FAFB; border: 1.5px solid #E5E7EB;
        color: #6B7280 !important; font-size: 0.85rem; text-decoration: none;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
    }
    .header-admin-logout:hover {
        background: #FFF5F7; border-color: rgba(255,0,51,0.3); color: #FF0033 !important;
    }

    /* ── Hamburguesa ── */
    .header-toggler {
        display: flex; flex-direction: column; justify-content: center; align-items: center;
        width: 40px; height: 40px; background: #F9FAFB; border: 1.5px solid #E5E7EB;
        border-radius: 8px; cursor: pointer; gap: 5px; padding: 0; flex-shrink: 0;
        transition: background 0.2s, border-color 0.2s;
    }
    .header-toggler:hover { background: #FFF5F7; border-color: rgba(255,0,51,0.3); }
    .header-toggler .hbar {
        display: block; width: 18px; height: 2px; background: #374151; border-radius: 2px;
        transition: transform 0.25s ease, opacity 0.2s, width 0.2s; transform-origin: center;
    }
    .header-toggler.open .hbar:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    .header-toggler.open .hbar:nth-child(2) { opacity: 0; width: 0; }
    .header-toggler.open .hbar:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    /* ══ Barra de navegación ══════════════════════════════════ */
    .header-nav { background: #fff; border-top: 1px solid #EEF0F3; }
    .header-nav-inner { display: flex; align-items: stretch; height: 44px; gap: 0; }
    .hnav-link {
        position: relative; display: inline-flex; align-items: center; gap: 5px;
        color: #374151; font-family: 'Inter', system-ui, sans-serif; font-size: 0.84rem;
        font-weight: 500; padding: 0 1rem; text-decoration: none; white-space: nowrap;
        cursor: pointer; user-select: none; transition: color 0.18s;
        border-bottom: 2px solid transparent;
    }
    .hnav-link::after {
        content: ''; position: absolute; bottom: -1px; left: 0; right: 0; height: 2px;
        background: #FF0033; border-radius: 2px 2px 0 0;
        transform: scaleX(0); transition: transform 0.22s cubic-bezier(.4,0,.2,1); transform-origin: center;
    }
    .hnav-link:hover { color: #FF0033; text-decoration: none; }
    .hnav-link:hover::after,
    .hnav-link.active::after,
    .hnav-link.mega-open::after { transform: scaleX(1); }
    .hnav-link.active { color: #FF0033; font-weight: 600; }
    .hnav-link.mega-open { color: #FF0033; }
    .hnav-link .hnav-arrow { font-size: 0.62rem; opacity: 0.6; transition: transform 0.2s, opacity 0.2s; }
    .hnav-link.mega-open .hnav-arrow { transform: rotate(180deg); opacity: 1; }
    .hnav-sep { width: 1px; background: #EEF0F3; margin: 8px 0; flex-shrink: 0; }

    /* ══ Panel mobile ════════════════════════════════════════ */
    .mobile-panel {
        background: #fff; border-top: 1px solid #EEF0F3; overflow: hidden;
        max-height: 0; transition: max-height 0.36s cubic-bezier(.4,0,.2,1);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .mobile-panel.open { max-height: 85vh; overflow-y: auto; }
    .mob-inner { padding: 0.75rem 0 1.5rem; }
    .mob-search-wrap { padding: 0.5rem 1rem 0.75rem; border-bottom: 1px solid #EEF0F3; }
    .mob-search-form {
        display: flex; align-items: center; background: #F4F6F9;
        border: 1.5px solid #E8ECF0; border-radius: 50px; overflow: hidden; transition: border-color 0.22s;
    }
    .mob-search-form:focus-within { border-color: #FF0033; }
    .mob-search-form input {
        flex: 1; border: none; background: transparent; padding: 0.58rem 1rem;
        font-size: 0.875rem; color: #111827; outline: none; font-family: 'Inter', system-ui, sans-serif;
    }
    .mob-search-form input::placeholder { color: #9CA3AF; }
    .mob-search-form button {
        display: flex; align-items: center; justify-content: center;
        width: 40px; height: 40px; background: #FF0033; border: none;
        border-radius: 0 50px 50px 0; color: #fff; font-size: 0.88rem;
        cursor: pointer; flex-shrink: 0; transition: background 0.2s;
    }
    .mob-search-form button:hover { background: #cc0029; }
    .mob-lnk {
        display: flex; align-items: center; gap: 10px; color: #374151;
        font-family: 'Inter', system-ui, sans-serif; font-size: 0.9rem; font-weight: 500;
        padding: 0.72rem 1.2rem; text-decoration: none; border-bottom: 1px solid #F3F4F6;
        transition: color 0.15s, background 0.15s;
    }
    .mob-lnk:hover { color: #FF0033; background: #FFF5F7; }
    .mob-lnk.active { color: #FF0033; font-weight: 600; }
    .mob-lnk i { font-size: 0.8rem; opacity: 0.5; width: 16px; text-align: center; flex-shrink: 0; }
    .mob-acc-hdr {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.72rem 1.2rem; color: #374151; font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.9rem; font-weight: 500; cursor: pointer; border-bottom: 1px solid #F3F4F6;
        transition: color 0.15s, background 0.15s; user-select: none;
    }
    .mob-acc-hdr span { display: flex; align-items: center; gap: 10px; }
    .mob-acc-hdr span i { font-size: 0.8rem; opacity: 0.5; }
    .mob-acc-hdr:hover { color: #FF0033; background: #FFF5F7; }
    .mob-acc-arrow { font-size: 0.68rem; opacity: 0.5; transition: transform 0.22s, opacity 0.2s; }
    .mob-acc-hdr.open .mob-acc-arrow { transform: rotate(180deg); opacity: 1; }
    .mob-acc-body {
        display: none; background: #FAFAFA;
        padding: 0.4rem 1.2rem 0.7rem 1.6rem; border-bottom: 1px solid #F3F4F6;
    }
    .mob-acc-body.open { display: block; }
    .mega-mobile-link {
        color: #6B7280; font-family: 'Inter', system-ui, sans-serif; font-size: .84rem;
        text-decoration: none; display: block; padding: 5px 0; transition: color .15s;
    }
    .mega-mobile-link:hover { color: #FF0033; }
    .mega-mobile-link.ver-todo { color: #FF0033; font-weight: 600; margin-top: .3rem; }
    .mega-mob-rubro-item { border-bottom: 1px solid #F3F4F6; }
    .mega-mob-rubro-item:last-of-type { border-bottom: none; }
    .mega-mob-rubro-hdr {
        display: flex; align-items: center; justify-content: space-between;
        padding: .5rem 0; color: #4B5563; font-size: .84rem; font-weight: 600;
        cursor: pointer; user-select: none; transition: color .15s;
    }
    .mega-mob-rubro-hdr:hover, .mega-mob-rubro-hdr.open { color: #FF0033; }
    .mega-mob-rubro-arrow { font-size: .65rem; opacity: .5; transition: transform .2s; }
    .mega-mob-rubro-hdr.open .mega-mob-rubro-arrow { transform: rotate(90deg); opacity: 1; }
    .mega-mob-rubro-body { display: none; padding: .1rem 0 .4rem .6rem; }
    .mega-mob-rubro-body.open { display: block; }
    .mob-actions {
        padding: 1rem 1.2rem; border-top: 1px solid #EEF0F3;
        display: flex; flex-wrap: wrap; gap: 0.7rem;
    }

    /* ══ Responsive ══════════════════════════════════════════ */
    @media (max-width: 991px) {
        .header-nav     { display: none !important; }
        .header-actions { display: none !important; }
        .header-search  { display: none !important; }
        .mega-dropdown  { display: none !important; }
        .header-top-inner { grid-template-columns: 1fr auto; }
        .header-logo { height: 40px; }
    }
    @media (min-width: 992px) {
        .header-toggler { display: none !important; }
        .mobile-panel   { display: none !important; }
    }
    @media (max-width: 575px) {
        .brand-main { font-size: 0.8rem; }
        .brand-sub  { font-size: 0.55rem; }
    }

    /* ── Botón de inicio de sesión profesional ── */
    .header-login-btn {
        display: inline-flex; align-items: center; gap: 7px;
        background: transparent; color: #374151 !important;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.82rem; font-weight: 600;
        padding: 0.44rem 1.05rem; border-radius: 8px;
        text-decoration: none; white-space: nowrap;
        border: 1.5px solid #E5E7EB;
        transition: background 0.18s, border-color 0.18s, color 0.18s;
    }
    .header-login-btn:hover {
        background: #F9FAFB; border-color: #D1D5DB; color: #111827 !important;
    }
    .header-login-btn i { font-size: 0.8rem; }

    /* ── Botón flotante de WhatsApp ── */
    .floating-wa {
        position: fixed;
        bottom: 28px; right: 28px;
        z-index: 9998;
        width: 56px; height: 56px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: #25D366; color: #fff !important;
        text-decoration: none;
        box-shadow: 0 6px 24px rgba(37,211,102,0.4);
        animation: floatWaIn 0.55s cubic-bezier(.4,0,.2,1) 0.9s both;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .floating-wa:hover {
        transform: translateY(-3px) scale(1.07);
        box-shadow: 0 10px 32px rgba(37,211,102,0.52);
        color: #fff !important;
    }
    .floating-wa .fwa-icon { font-size: 1.45rem; line-height: 1; }
    .floating-wa-text { display: none; }
    /* Anillo pulsante */
    .floating-wa::before {
        content: '';
        position: absolute;
        inset: -6px; border-radius: 50%;
        border: 2px solid rgba(37,211,102,0.45);
        animation: floatWaPulse 2.8s ease-in-out infinite 1.4s;
        pointer-events: none;
    }
    @keyframes floatWaIn {
        from { opacity: 0; transform: translateY(20px) scale(0.88); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes floatWaPulse {
        0%, 100% { opacity: 0.85; transform: scale(1); }
        50%       { opacity: 0;    transform: scale(1.22); }
    }
    @media (max-width: 575px) {
        .floating-wa { width: 50px; height: 50px; bottom: 20px; right: 20px; }
        .floating-wa .fwa-icon { font-size: 1.25rem; }
    }
</style>

<?php
$adminLoggedIn = session()->get('admin_logged_in');
$adminNombre   = session()->get('admin_nombre');
$currentPath   = trim(service('request')->getUri()->getPath(), '/');
$isHome        = ($currentPath === '' || $currentPath === 'index.php');
$isCatalogo    = (strncmp($currentPath, 'catalogo', 8) === 0);
$isServicio    = ($currentPath === 'servicio-tecnico');
$isNosotros    = ($currentPath === 'nosotros');
$isContacto    = ($currentPath === 'contacto');
$isInformatica = (strncmp($currentPath, 'catalogo/informatica', 20) === 0);
$isMuebles     = (strncmp($currentPath, 'catalogo/muebles', 16) === 0);
$isElectro     = (strncmp($currentPath, 'catalogo/electrodomesticos', 26) === 0);
$isLinea       = (strncmp($currentPath, 'catalogo/linea-comercial', 24) === 0);

$_megaModel = new \App\Models\CategoriaModel();
$_megaData  = $_megaModel->getMegaMenu();
?>

<!-- ═══════════════════════════════════════════════════════════
     HEADER PRINCIPAL
═══════════════════════════════════════════════════════════ -->
<header class="site-header" id="siteHeader">

    <div class="header-top">
        <div class="container header-top-inner">

            <a href="<?= base_url('/') ?>" class="header-brand">
                <img src="<?= base_url('assets/img/logo_sinfondo.png') ?>"
                     alt="Centro Informático Regional" class="header-logo">
                <div class="header-brand-text">
                    <span class="brand-main">Centro Informático</span>
                    <span class="brand-sub">Regional</span>
                </div>
            </a>

            <form action="<?= base_url('catalogo/buscar') ?>" method="GET"
                  class="header-search" role="search">
                <input type="search" name="q" class="header-search-input"
                       placeholder="Buscar productos, marcas o categorías..."
                       autocomplete="off" aria-label="Buscar">
                <button type="submit" class="header-search-btn" aria-label="Buscar">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <div class="header-actions">
                <?php if ($adminLoggedIn): ?>
                    <a href="<?= base_url('admin/dashboard') ?>" class="header-admin-badge"
                       title="Panel de administración">
                        <i class="fas fa-shield-halved"></i> Panel
                    </a>
                    <a href="<?= base_url('admin/logout') ?>" class="header-admin-logout"
                       title="Cerrar sesión (<?= esc($adminNombre) ?>)">
                        <i class="fas fa-right-from-bracket"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('admin/login') ?>" class="header-login-btn"
                       title="Iniciar sesión">
                        <i class="fas fa-right-to-bracket"></i> Iniciar sesión
                    </a>
                <?php endif; ?>
            </div>

            <button class="header-toggler" id="headerToggler"
                    aria-label="Abrir menú" aria-expanded="false">
                <span class="hbar"></span>
                <span class="hbar"></span>
                <span class="hbar"></span>
            </button>

        </div>
    </div>

    <nav class="header-nav" aria-label="Navegación principal">
        <div class="container">
            <div class="header-nav-inner">

                <a href="<?= base_url('/') ?>"
                   class="hnav-link<?= $isHome ? ' active' : '' ?>">
                    Inicio
                </a>

                <div class="hnav-link" id="mega-trigger-btn"
                     role="button" tabindex="0"
                     aria-haspopup="true" aria-expanded="false">
                    Catálogo <i class="fas fa-chevron-down hnav-arrow"></i>
                </div>

                <div class="hnav-sep"></div>

                <a href="<?= base_url('servicio-tecnico') ?>"
                   class="hnav-link<?= $isServicio ? ' active' : '' ?>">
                    <i class="fas fa-screwdriver-wrench" style="font-size:.72rem;opacity:.55;"></i>
                    Servicio Técnico
                </a>
                <a href="<?= base_url('nosotros') ?>"
                   class="hnav-link<?= $isNosotros ? ' active' : '' ?>">
                    <i class="fas fa-building" style="font-size:.72rem;opacity:.55;"></i>
                    Nosotros
                </a>
                <a href="<?= base_url('contacto') ?>"
                   class="hnav-link<?= $isContacto ? ' active' : '' ?>">
                    Contacto
                </a>

            </div>
        </div>
    </nav>

    <div class="mobile-panel" id="mobilePanel" aria-hidden="true">
        <div class="mob-inner">

            <div class="mob-search-wrap">
                <form action="<?= base_url('catalogo/buscar') ?>" method="GET"
                      class="mob-search-form" role="search">
                    <input type="search" name="q" placeholder="Buscar productos..."
                           autocomplete="off" aria-label="Buscar">
                    <button type="submit" aria-label="Buscar">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <a href="<?= base_url('/') ?>"
               class="mob-lnk nav-mob-close<?= $isHome ? ' active' : '' ?>">
                <i class="fas fa-home"></i> Inicio
            </a>

            <div class="mob-acc-hdr" id="mega-mobile-toggle" role="button" tabindex="0">
                <span><i class="fas fa-layer-group"></i> Catálogo</span>
                <i class="fas fa-chevron-down mob-acc-arrow"></i>
            </div>
            <div class="mob-acc-body" id="mega-mobile-body">
                <?php if (!empty($_megaData)): ?>
                    <?php foreach ($_megaData as $r): ?>
                    <div class="mega-mob-rubro-item">
                        <div class="mega-mob-rubro-hdr" role="button" tabindex="0">
                            <span>
                                <i class="<?= esc($r['icono']) ?>" style="margin-right:5px;font-size:.78rem;opacity:.6;"></i>
                                <?= esc($r['nombre']) ?>
                            </span>
                            <i class="fas fa-chevron-right mega-mob-rubro-arrow"></i>
                        </div>
                        <div class="mega-mob-rubro-body">
                            <?php foreach ($r['hijos'] as $sub): ?>
                            <a href="<?= base_url('catalogo/'.esc($r['slug']).'/'.esc($sub['slug'])) ?>"
                               class="mega-mobile-link nav-mob-close">
                                <i class="<?= esc($sub['icono']) ?>" style="margin-right:4px;font-size:.72rem;opacity:.5;"></i>
                                <?= esc($sub['nombre']) ?>
                            </a>
                            <?php endforeach; ?>
                            <a href="<?= base_url('catalogo/'.esc($r['slug'])) ?>"
                               class="mega-mobile-link ver-todo nav-mob-close">
                                Ver todo en <?= esc($r['nombre']) ?> &rarr;
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <a href="<?= base_url('catalogo') ?>"
                       class="mega-mobile-link ver-todo nav-mob-close"
                       style="margin-top:.4rem;border-top:1px solid #F3F4F6;padding-top:.5rem;display:block;">
                        Ver catálogo completo &rarr;
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('catalogo') ?>" class="mega-mobile-link nav-mob-close">Ver catálogo</a>
                <?php endif; ?>
            </div>

            <a href="<?= base_url('servicio-tecnico') ?>"
               class="mob-lnk nav-mob-close<?= $isServicio ? ' active' : '' ?>">
                <i class="fas fa-screwdriver-wrench"></i> Servicio Técnico
            </a>
            <a href="<?= base_url('nosotros') ?>"
               class="mob-lnk nav-mob-close<?= $isNosotros ? ' active' : '' ?>">
                <i class="fas fa-building"></i> Nosotros
            </a>
            <a href="<?= base_url('contacto') ?>"
               class="mob-lnk nav-mob-close<?= $isContacto ? ' active' : '' ?>">
                <i class="fas fa-envelope"></i> Contacto
            </a>

            <div class="mob-actions">
                <?php if ($adminLoggedIn): ?>
                    <a href="<?= base_url('admin/dashboard') ?>" class="header-admin-badge">
                        <i class="fas fa-shield-halved"></i> Panel Admin
                    </a>
                    <a href="<?= base_url('admin/logout') ?>" class="header-admin-logout"
                       title="Cerrar sesión">
                        <i class="fas fa-right-from-bracket"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('admin/login') ?>" class="header-login-btn"
                       style="width:100%; justify-content:center;">
                        <i class="fas fa-right-to-bracket"></i> Iniciar sesión
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>

</header>

<!-- Botón flotante de WhatsApp -->
<a href="https://wa.me/5493704616482?text=Hola%2C%20quiero%20consultar%20sobre%20sus%20productos"
   target="_blank" rel="noopener noreferrer"
   class="floating-wa"
   aria-label="Consultar por WhatsApp">
    <i class="fab fa-whatsapp fwa-icon"></i>
    <span class="floating-wa-text">Consultar por WhatsApp</span>
</a>

<!-- ═══════════════════════════════════════════════════════════
     MEGA DROPDOWN — Estilo Naldo: sidebar + columnas de cats
═══════════════════════════════════════════════════════════ -->
<div class="mega-dropdown" id="mega-dropdown" role="dialog" aria-label="Menú de categorías">

    <?php if (!empty($_megaData)): ?>

    <div class="mega-body">

        <!-- ══ Sidebar izquierdo: rubros ══ -->
        <div class="mega-sidebar">
            <div class="mega-sidebar-hdr">
                <i class="fas fa-bars"></i> Categorías
            </div>

            <?php foreach ($_megaData as $rubro): ?>
            <div class="mega-rubro-item"
                 data-pane="mgp-<?= (int)$rubro['id'] ?>"
                 role="button" tabindex="0">
                <span class="mri-icon"><i class="<?= esc($rubro['icono']) ?>"></i></span>
                <span class="mri-name"><?= esc($rubro['nombre']) ?></span>
                <i class="fas fa-chevron-right mri-arrow"></i>
            </div>
            <?php endforeach; ?>

            <div class="mega-sidebar-footer">
                <a href="<?= base_url('catalogo') ?>" class="mega-sidebar-all-link">
                    <i class="fas fa-th-large"></i> Ver catálogo completo
                </a>
            </div>
        </div>

        <!-- ══ Panel derecho: columnas de categorías ══ -->
        <div class="mega-panel-wrap" id="mega-panel-wrap">

            <?php foreach ($_megaData as $rubro): ?>
            <div id="mgp-<?= (int)$rubro['id'] ?>" class="mega-panel">

                <!-- Columnas de subcategorías -->
                <div class="mega-panel-cols">
                    <?php if (!empty($rubro['hijos'])): ?>
                        <?php foreach ($rubro['hijos'] as $sub): ?>
                        <div class="mega-panel-col">

                            <!-- Título: enlace a la subcategoría -->
                            <a href="<?= base_url('catalogo/'.esc($rubro['slug']).'/'.esc($sub['slug'])) ?>"
                               class="mpc-title">
                                <?= esc($sub['nombre']) ?>
                            </a>

                            <!-- Imagen representativa (placeholder con ícono) -->
                            <div class="mpc-img">
                                <i class="<?= esc($sub['icono']) ?>"></i>
                            </div>

                            <!-- Sub-subcategorías -->
                            <?php if (!empty($sub['hijos'])): ?>
                            <ul class="mpc-list">
                                <?php foreach ($sub['hijos'] as $subsub): ?>
                                <li>
                                    <a href="<?= base_url('catalogo/'.esc($rubro['slug']).'/'.esc($sub['slug']).'/'.esc($subsub['slug'])) ?>">
                                        <?= esc($subsub['nombre']) ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>

                            <!-- Ver todo de esta subcategoría -->
                            <a href="<?= base_url('catalogo/'.esc($rubro['slug']).'/'.esc($sub['slug'])) ?>"
                               class="mpc-all">
                                Ver todo <i class="fas fa-arrow-right"></i>
                            </a>

                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:2rem;color:#9CA3AF;">
                            <div style="text-align:center;">
                                <i class="<?= esc($rubro['icono']) ?>" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
                                <a href="<?= base_url('catalogo/'.esc($rubro['slug'])) ?>"
                                   style="font-family:'Inter',system-ui,sans-serif;font-size:.84rem;color:#FF0033;font-weight:600;text-decoration:none;">
                                    Ver <?= esc($rubro['nombre']) ?> &rarr;
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer: "Ver todo en Rubro" -->
                <div class="mega-panel-footer">
                    <span class="mega-panel-footer-title">
                        <i class="<?= esc($rubro['icono']) ?>"></i>
                        <?= esc($rubro['nombre']) ?>
                    </span>
                    <a href="<?= base_url('catalogo/'.esc($rubro['slug'])) ?>"
                       class="mega-panel-footer-link">
                        Ver todo en <?= esc($rubro['nombre']) ?>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            </div><!-- /.mega-panel -->
            <?php endforeach; ?>

            <!-- Placeholder inicial -->
            <div id="mega-panel-placeholder" class="mega-panel-placeholder">
                <i class="fas fa-layer-group"></i>
                <span>Pasá el cursor por una categoría</span>
            </div>

        </div><!-- /.mega-panel-wrap -->

    </div><!-- /.mega-body -->

    <?php else: ?>
    <div style="padding:2rem;color:#9CA3AF;font-family:'Inter',system-ui,sans-serif;font-size:.9rem;">
        No hay categorías disponibles.
    </div>
    <?php endif; ?>

</div><!-- /.mega-dropdown -->

<script>
(function () {

    /* ── Sincronizar --header-h ── */
    var siteHeader = document.getElementById('siteHeader');
    var megaDrop   = document.getElementById('mega-dropdown');

    function syncHeaderHeight() {
        if (siteHeader) {
            document.documentElement.style.setProperty('--header-h', siteHeader.offsetHeight + 'px');
        }
    }
    syncHeaderHeight();

    window.addEventListener('scroll', function () {
        siteHeader.classList.toggle('scrolled', window.scrollY > 55);
        syncHeaderHeight();
    }, { passive: true });
    window.addEventListener('resize', syncHeaderHeight, { passive: true });

    /* ── Mobile panel toggle ── */
    var toggler     = document.getElementById('headerToggler');
    var mobilePanel = document.getElementById('mobilePanel');

    function openPanel() {
        mobilePanel.classList.add('open');
        mobilePanel.setAttribute('aria-hidden', 'false');
        toggler.classList.add('open');
        toggler.setAttribute('aria-expanded', 'true');
    }
    function closePanel() {
        mobilePanel.classList.remove('open');
        mobilePanel.setAttribute('aria-hidden', 'true');
        toggler.classList.remove('open');
        toggler.setAttribute('aria-expanded', 'false');
    }
    if (toggler && mobilePanel) {
        toggler.addEventListener('click', function () {
            mobilePanel.classList.contains('open') ? closePanel() : openPanel();
        });
    }
    document.querySelectorAll('.nav-mob-close').forEach(function (el) {
        el.addEventListener('click', closePanel);
    });

    /* ── DESKTOP: Mega dropdown ── */
    var trigger     = document.getElementById('mega-trigger-btn');
    var placeholder = document.getElementById('mega-panel-placeholder');

    if (trigger && megaDrop) {
        var rubroItems  = megaDrop.querySelectorAll('.mega-rubro-item');
        var panels      = megaDrop.querySelectorAll('.mega-panel');
        var activeId    = null;

        function selectRubro(paneId) {
            if (activeId === paneId) return;
            activeId = paneId;

            rubroItems.forEach(function (r) { r.classList.remove('active'); });
            panels.forEach(function (p) { p.classList.remove('active'); });
            if (placeholder) placeholder.style.display = 'none';

            var item = megaDrop.querySelector('[data-pane="' + paneId + '"]');
            if (item) item.classList.add('active');

            var panel = document.getElementById(paneId);
            if (panel) panel.classList.add('active');
        }

        function resetPanels() {
            rubroItems.forEach(function (r) { r.classList.remove('active'); });
            panels.forEach(function (p) { p.classList.remove('active'); });
            if (placeholder) placeholder.style.display = 'flex';
            activeId = null;
        }

        function openMega() {
            syncHeaderHeight();
            megaDrop.classList.add('open');
            trigger.classList.add('mega-open');
            trigger.setAttribute('aria-expanded', 'true');
            /* Auto-seleccionar el primer rubro */
            if (rubroItems.length > 0) {
                selectRubro(rubroItems[0].dataset.pane);
            }
        }

        function closeMega() {
            megaDrop.classList.remove('open');
            trigger.classList.remove('mega-open');
            trigger.setAttribute('aria-expanded', 'false');
            resetPanels();
        }

        /* Hover sobre rubro → muestra sus columnas */
        rubroItems.forEach(function (item) {
            item.addEventListener('mouseenter', function () {
                selectRubro(item.dataset.pane);
            });
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                selectRubro(item.dataset.pane);
            });
            item.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    selectRubro(item.dataset.pane);
                }
            });
        });

        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            megaDrop.classList.contains('open') ? closeMega() : openMega();
        });
        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                megaDrop.classList.contains('open') ? closeMega() : openMega();
            }
            if (e.key === 'Escape') closeMega();
        });
        document.addEventListener('click', function (e) {
            if (!megaDrop.contains(e.target) && e.target !== trigger) closeMega();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeMega();
        });
    }

    /* ── Mobile: acordeón Catálogo ── */
    var mobToggle = document.getElementById('mega-mobile-toggle');
    var mobBody   = document.getElementById('mega-mobile-body');
    if (mobToggle && mobBody) {
        mobToggle.addEventListener('click', function () {
            var isOpen = mobBody.classList.contains('open');
            mobBody.classList.toggle('open', !isOpen);
            mobToggle.classList.toggle('open', !isOpen);
        });
        mobToggle.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); mobToggle.click(); }
        });
    }

    /* ── Sub-acordeón por rubro (mobile) ── */
    document.querySelectorAll('.mega-mob-rubro-hdr').forEach(function (hdr) {
        function toggleRubro() {
            var body   = hdr.nextElementSibling;
            var isOpen = hdr.classList.contains('open');
            document.querySelectorAll('.mega-mob-rubro-hdr').forEach(function (h) {
                h.classList.remove('open');
                if (h.nextElementSibling) h.nextElementSibling.classList.remove('open');
            });
            if (!isOpen) {
                hdr.classList.add('open');
                if (body) body.classList.add('open');
            }
        }
        hdr.addEventListener('click', toggleRubro);
        hdr.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggleRubro(); }
        });
    });

})();
</script>
