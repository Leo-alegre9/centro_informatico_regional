# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Centro Informático Regional** — a web application for a computer repair and IT services company. Built on CodeIgniter 4 (MVC framework). Currently in early development with a working landing page and no backend business logic yet.

- **Backend**: PHP 8.2+, CodeIgniter 4.7.x
- **Frontend**: Server-rendered HTML, Bootstrap 5.3.8 (CDN), Font Awesome 6, SweetAlert2 (CDN)
- **Database**: MySQL, database name `cir2`
- **Dev server**: XAMPP on Windows, base URL `http://localhost:8080/`

## Common Commands

```bash
# Start development server (alternative to XAMPP)
php spark serve --host localhost --port 8080

# Run all tests
composer test
# or
php vendor/bin/phpunit

# Database
php spark migrate              # Run pending migrations
php spark db:seed SeederName   # Run a specific seeder
php spark migrate:rollback     # Roll back last migration

# Code generation
php spark make:controller Name
php spark make:model Name
php spark make:migration Name
php spark list                 # See all available spark commands
```

## Architecture

Standard CodeIgniter 4 MVC layout under `app/`:

- **`app/Config/Routes.php`** — all URL routing lives here (currently just `GET /` → `Home::index`)
- **`app/Controllers/`** — one controller per feature area; all extend `BaseController`
- **`app/Models/`** — database models using CI4's `Model` class (currently empty)
- **`app/Views/`** — PHP templates; `componentes/` holds reusable partials (e.g., `footer.php`)
- **`app/Database/Migrations/`** — schema migrations (currently empty)
- **`public/`** — web root; `index.php` is the front controller

Environment config is in `.env` (gitignored). The example template is `.env.example`. Test database uses SQLite3 in-memory (configured in `phpunit.xml.dist`).

## Key Conventions

- Views use inline CSS and Bootstrap utility classes — no separate CSS files yet.
- The footer component (`app/Views/componentes/footer.php`) is included via `view()` calls and outputs dynamic copyright year.
- `writable/` (cache, logs, sessions, uploads) is managed by the framework — do not commit contents.
- CI4's `spark` CLI is the primary tool for code generation and database operations; prefer it over creating files manually.
