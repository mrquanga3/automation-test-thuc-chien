# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is an **OpenCart 3.x** PHP e-commerce application used as the **Application Under Test (AUT)** for automation testing practice. It runs locally via **XAMPP**.

## Local URLs

| Endpoint | URL |
|---|---|
| Storefront | `http://localhost/opencart/` |
| Admin panel | `http://localhost/opencart/administrator/` |
| REST API | `http://localhost/opencart/api.php/<table_name>/{id}` |

## Database

- **Driver:** MySQLi
- **Host:** `127.0.0.1:3306`
- **Database:** `opencart`
- **Table prefix:** `oc_`
- **Credentials:** admin / admin (local dev only)

Config files: `opencart/config.php` (storefront), `opencart/administrator/config.php` (admin).

## REST API

The `opencart/opencart-rest-api/` plugin exposes all database tables as a REST API. Authentication uses an API key passed in the request header:

```
key: <your-api-key>
```

Generate the key in Admin → System → Users → API. Supports GET / POST / PUT / DELETE on any `oc_*` table.

Config file: `opencart/opencart-rest-api/config_api.php` — set `OPENCART_V3 = true` for OpenCart 3, enable `SESSION_LOG` for access logging, enable `RESTRICT_IP` to whitelist IPs.

## Architecture

OpenCart follows a custom MVC-L pattern. Request flow: `index.php` → Router → Controller → Model → View (Twig templates).

| Directory | Purpose |
|---|---|
| `opencart/catalog/` | Storefront MVC (controllers, models, views, language) |
| `opencart/administrator/` | Admin panel MVC |
| `opencart/system/` | Core framework (engine, library, config) |
| `opencart/extension/` | Extensions/plugins |
| `opencart/image/` | Product and site images |
| `storage1/` | Runtime storage: cache, logs, sessions, uploads, Composer vendor libs |

Controllers map directly to URL routes: `catalog/controller/product/product.php` handles `/index.php?route=product/product`.

Events are registered via the admin and dispatched through `opencart/system/engine/` — see `opencart/catalog/controller/event/` for catalog-side event handlers.

## Storage

`storage1/` is the XAMPP storage path (`D:/xampp/storage1/`) and contains:
- `vendor/` — Composer dependencies (AWS SDK, Guzzle, Twig, SCSS)
- `cache/`, `logs/`, `session/`, `upload/`, `download/`
