# CLAUDE.md - TestLink Navigation & Menu System

## Project Overview

TestLink is an open-source test management system. This project uses the **Dashio theme** with a sidebar navigation system for admin pages.

## Local URL

- **Testlink**: `http://localhost/testlink/`

## Key Directories

| Path | Purpose |
|------|---------|
| `lib/` | PHP controllers (user management, events, metrics, etc.) |
| `gui/templates/dashio/` | Smarty templates for Dashio theme |
| `gui/templates/dashio/aside.tpl` | Main sidebar navigation menu |
| `gui/templates/dashio/labels/` | Language labels by template |
| `cfg/` | Configuration files |

## Database

- **Driver**: MySQLi
- **Host**: `localhost`
- **Database**: `testlink` (configurable in `config_db.inc.php`)

## Sidebar Navigation System

### Key Concepts

- **Menu Structure**: Defined in `aside.tpl` with main menu and submenu items
- **Active Highlighting**: Uses `activeMenu` (main menu) and `activeSubmenu` (submenu items) arrays
- **Navigation Data**: Populated by `initUserEnv()` function in `lib/general/common.php`
- **CSS Styling**: Active items get `.active` class → cyan color (#4ECDC4)

### Implementation Pattern

For any page to show sidebar with proper highlighting:

1. **PHP**: Call `initUserEnv()` and set `$gui->activeMenu['key']` and `$gui->activeSubmenu['key']`
2. **Template**: Include hamburger button, `aside.tpl`, main-content wrapper, and `supportJS.inc.tpl`

See **SKILL.md** for detailed step-by-step implementation guide.

## Common PHP Files

- `lib/events/eventviewer.php` — Event Viewer page
- `lib/usermanagement/usersView.php` — User Management
- `lib/usermanagement/usersAssign.php` — Role Assignment
- `lib/project/projectView.php` — Project Management
- `lib/results/metricsDashboard.php` — Metrics Dashboard
- `lib/general/common.php` — Navigation initialization (`initUserEnv()`)

## Template Variables

- `$gui->activeMenu['key']` — Main menu active indicator
- `$gui->activeSubmenu['key']` — Submenu active indicator
- `$gui->uri->*` — Navigation URIs
- `$gui->showMenu.*` — Menu visibility flags
- `$gui->grants.*` — User permissions

## Important Notes

- Smarty template engine with `.tpl` files
- Frame-based layout: main page may load content in iframe
- JavaScript in `left-bar-scripts.js` handles sidebar toggle and frame navigation
- Cache-busting: Use `?v={$smarty.now|date_format:'%Y%m%d%H%M%S'}` for script includes
