# CLAUDE.md — TCExam (local automation testing fork)

This file gives Claude Code context for working with the TCExam install in this directory. Parent project context (OpenCart) is in `../CLAUDE.md`.

## Project Overview

**TCExam** is an open-source CBA (Computer-Based Assessment) platform — written in PHP, used here as an Application Under Test for automation practice. Upstream: <https://github.com/tecnickcom/tcexam>.

The codebase is shipped as the original tecnickcom source plus local config tweaks (paths, host, theme) for running on this Windows + XAMPP machine.

## Local URLs

| Endpoint | URL |
|---|---|
| Public area (test takers) | `http://localhost/tcexam/public/` |
| Admin panel | `http://localhost/tcexam/admin/` |
| Login (admin default) | `admin / admin` (change after first login) |

## Filesystem layout

Project root: `D:/automation-test-thuc-chien/web for testing/tcexam/` (paths use forward slashes; spaces are part of the path).

| Directory | Purpose |
|---|---|
| `admin/` | Admin panel — code, config, styles, language |
| `public/` | Public test-taker area — same MVC layout |
| `shared/` | Shared code, config, language TMX, third-party libs (PHPMailer, jscalendar, vk, radius, cas) |
| `cache/` | Runtime cache (language `.php` files generated from TMX, OMR scans, etc.) |
| `cache/lang/` | Compiled language cache, regenerated when TMX file changes |
| `fonts/` | TCPDF fonts |
| `accounts/` | Local notes (e.g. `account.txt` — credentials, NOT under upstream) |

## Configuration files

| File | Purpose |
|---|---|
| `shared/config/tce_paths.php` | Filesystem paths and host URL — local-machine specific |
| `shared/config/tce_db_config.php` | Database connection (MySQL) |
| `shared/config/tce_config.php` | Shared runtime constants (language list, session lifetime, timezone) |
| `admin/config/tce_config.php` | Admin theme + behaviour |
| `admin/config/tce_auth.php` | Admin page access levels |
| `public/config/tce_config.php` | Public theme + behaviour |
| `public/config/tce_auth.php` | Public page access levels |

`*.default/` siblings are upstream templates — TCExam does **not** load them. Always edit the non-`.default` version.

### Current values (this machine)

```php
// shared/config/tce_paths.php
K_PATH_HOST    = 'http://localhost'
K_PATH_TCEXAM  = '/tcexam/'
K_PATH_MAIN    = 'D:/automation-test-thuc-chien/web for testing/tcexam/'

// shared/config/tce_db_config.php
K_DATABASE_TYPE          = 'MYSQL'
K_DATABASE_HOST          = 'localhost'
K_DATABASE_PORT          = '3306'
K_DATABASE_NAME          = 'tcexam'
K_DATABASE_USER_NAME     = 'root'
K_DATABASE_USER_PASSWORD = ''
K_TABLE_PREFIX           = 'tce_'

// public/config/tce_config.php
K_PUBLIC_THEME = 'picoman'   // alt: 'default'
// admin/config/tce_config.php
K_ADMIN_THEME  = 'picoman'   // alt: 'default' — picoman files copied from public/
```

## Database

- **Driver:** MySQLi (PHP)
- **Host:** `localhost:3306`
- **Database:** `tcexam`
- **Table prefix:** `tce_` (every domain table is `tce_*`)
- **Common tables:** `tce_users`, `tce_user_groups`, `tce_modules`, `tce_subjects`, `tce_questions`, `tce_answers`, `tce_tests`, `tce_tests_users`, `tce_tests_logs`, `tce_tests_logs_answers`, `tce_sessions`, `tce_sslcerts`

Schema and seed data: `admin/sql/` (run via phpMyAdmin or `mysql` CLI when initialising a fresh DB).

## Themes

TCExam picks a CSS file based on `K_PUBLIC_THEME` / `K_ADMIN_THEME`:

| Area | Constant | Available themes |
|---|---|---|
| Public | `K_PUBLIC_THEME` in `public/config/tce_config.php:75` | `default`, `picoman` |
| Admin | `K_ADMIN_THEME` in `admin/config/tce_config.php:97` | `default`, `picoman` (picoman files copied from public area) |

Each theme needs three files: `<area>/styles/<name>.css`, `<area>/styles/<name>_rtl.css` (right-to-left languages), `<area>/config/theme/<name>.php` (extra footer scripts/markup).

## Architecture

Procedural PHP, no MVC framework. Each page is a self-contained `*.php` script under `admin/code/` or `public/code/`. Shared logic in `shared/code/`. Common page skeleton:

```
include('../config/tce_config.php');         // bootstrap (DB, language, auth)
require_once('../../shared/code/tce_authorization.php');
require_once('../code/tce_xhtml_header.php'); // <head>, theme CSS
// page logic
require_once('../code/tce_page_header.php');  // top nav
// page body
require_once('../code/tce_page_footer.php');  // footer + theme PHP
require_once('../../shared/code/tce_page_footer.php');
```

Routing = direct URL to `.php` file. No router. URL examples:
- `/tcexam/admin/code/index.php` — admin home
- `/tcexam/admin/code/tce_edit_test.php?testid=N` — edit a test
- `/tcexam/public/code/index.php` — user home
- `/tcexam/public/code/tce_test_execute.php?testid=N` — take a test

Language: TMX (`shared/config/lang/language_tmx.xml`) is parsed once and cached as PHP arrays in `cache/lang/language_tmx_<lang>.php`. Delete those `.php` files to force a rebuild after editing the TMX.

## Common operations

### Reset language cache
```powershell
Remove-Item "D:/automation-test-thuc-chien/web for testing/tcexam/cache/lang/language_tmx_*.php" -Force
```

### Switch a theme
Edit the relevant `K_*_THEME` constant — see [SKILL.md](SKILL.md) §Theme switching.

### Reconfigure paths or DB
Run through [SKILL.md](SKILL.md) — covers move-to-new-machine, change-credential, fix-path-warnings.

### Tail PHP errors
Errors go to XAMPP's PHP log (`D:/xampp/php/logs/php_error_log`) unless `K_USE_ERROR_LOG=true` in `shared/config/tce_config.php`, in which case they also go to `log/tce_errors.log`.

## Conventions when editing

- Keep `*.default/` files untouched — they are the upstream copy. Edit `*/config/*.php` instead.
- After editing the TMX language file, clear `cache/lang/` to force rebuild.
- Don't commit local-machine paths in `tce_paths.php` to upstream — they're machine-specific.
- All path constants use `/`, not `\`, even on Windows. Always trailing slash on directory paths.
- Admin/public split: code under `admin/` requires login at admin level (`K_AUTH_ADMINISTRATOR=10`); code under `public/` is for end users.
