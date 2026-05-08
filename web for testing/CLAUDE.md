# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is an **OpenCart 3.x** PHP e-commerce application used as the **Application Under Test (AUT)** for automation testing practice. It runs locally via **XAMPP**.

## Local URLs

| Endpoint | URL |
|---|---|
| Storefront | `http://localhost/opencart/` |
| Admin panel | `http://localhost/opencart/administrator/` |
| Admin API | `http://localhost/opencart/administrator/index.php?route=api/login` |
| CRUD API | `http://localhost/opencart/api.php/<table_name>/{id}` |

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

## Admin API (Custom)

Custom API endpoints built for automation testing. Requires Session Cookie and `Authorization` header.

- **Login:** `POST /administrator/index.php?route=api/login` (Body: `username`, `password`) -> Returns `user_token`.
- **Users:**
  - `GET  route=api/user` — List (supports `?page=`, `?limit=`, `?sort=`, `?order=`)
  - `GET  route=api/user.get&user_id=N` — Get single user
  - `POST route=api/user.add` — Create (fields: `username`, `password`, `firstname`, `lastname`, `email`, `user_group_id`, `status`)
  - `POST route=api/user.edit&user_id=N` — Update
  - `POST route=api/user.delete&user_id=N` — Delete
- **User Groups:**
  - `GET  route=api/user_group` — List
  - `GET  route=api/user_group.get&user_group_id=N` — Get single group
  - `POST route=api/user_group.add` — Create (fields: `name`, `permission[access][]`, `permission[modify][]`)
  - `POST route=api/user_group.edit&user_group_id=N` — Update
  - `POST route=api/user_group.delete&user_group_id=N` — Delete
- **Categories:**
  - `GET  route=api/category` — List
  - `GET  route=api/category.get&category_id=N` — Get single category
  - `POST route=api/category.add` — Create (fields: `parent_id`, `image`, `sort_order`, `status`, `category_description[1][name]`, etc.)
  - `POST route=api/category.edit&category_id=N` — Update
  - `POST route=api/category.delete&category_id=N` — Delete
- **Products:**
  - `GET  route=api/product` — List (supports `?page=`, `?limit=`)
  - `GET  route=api/product.get&product_id=N` — Get single product
  - `POST route=api/product.add` — Create (fields: `model`, `price`, `quantity`, `status`, `image`, `product_description[1][name]`, etc.)
  - `POST route=api/product.edit&product_id=N` — Update
  - `POST route=api/product.delete&product_id=N` — Delete
- **Customers:**
  - `GET  route=api/customer` — List (supports `?page=`, `?limit=`, `?sort=`, `?order=`, `?filter_name=`, `?filter_email=`, `?filter_status=`, `?filter_customer_group_id=`)
  - `GET  route=api/customer.get&customer_id=N` — Get single customer
  - `POST route=api/customer.add` — Create (fields: `firstname`, `lastname`, `email`, `telephone`, `password`, `customer_group_id`, `store_id`, `status`, `newsletter`, `safe`)
  - `POST route=api/customer.edit&customer_id=N` — Update (leave `password` empty to keep unchanged)
  - `POST route=api/customer.delete&customer_id=N` — Delete (cascades: address, wishlist, history, etc.)

### Running API Tests (curl - PowerShell/Windows)

**Step 1: Login to get token and session**
```powershell
curl.exe -X POST "http://localhost/opencart/administrator/index.php?route=api/login" `
     -d "username=admin&password=admin" `
     -c cookie.txt
```

**Step 2: Examples of using the token**

*Get User List:*
```powershell
curl.exe -X GET "http://localhost/opencart/administrator/index.php?route=api/user" `
     -H "Authorization: Bearer <TOKEN>" `
     -b cookie.txt
```

*Get Single User:*
```powershell
curl.exe -X GET "http://localhost/opencart/administrator/index.php?route=api/user.get&user_id=1" `
     -H "Authorization: Bearer <TOKEN>" `
     -b cookie.txt
```

*Get Single Product:*
```powershell
curl.exe -X GET "http://localhost/opencart/administrator/index.php?route=api/product.get&product_id=40" `
     -H "Authorization: Bearer <TOKEN>" `
     -b cookie.txt
```

*Create Category:*
```powershell
curl.exe -X POST "http://localhost/opencart/administrator/index.php?route=api/category.add" `
     -H "Authorization: Bearer <TOKEN>" `
     -b cookie.txt `
     -d "image=catalog/demo/hp_1.jpg&parent_id=0&sort_order=1&status=1&category_description[1][name]=New Category&category_description[1][meta_title]=Meta&category_description[1][description]=Desc"
```

*Delete Category:*
```powershell
curl.exe -X POST "http://localhost/opencart/administrator/index.php?route=api/category.delete&category_id=20" `
     -H "Authorization: Bearer <TOKEN>" `
     -b cookie.txt
```

*Update Product:*
```powershell
curl.exe -X POST "http://localhost/opencart/administrator/index.php?route=api/product.edit&product_id=40" `
     -H "Authorization: Bearer <TOKEN>" `
     -b cookie.txt `
     -d "model=Product 1&price=100.00&quantity=10&status=1&product_description[1][name]=Updated Name&product_description[1][meta_title]=Meta"
```

*Delete Product:*
```powershell
curl.exe -X POST "http://localhost/opencart/administrator/index.php?route=api/product.delete&product_id=40" `
     -H "Authorization: Bearer <TOKEN>" `
     -b cookie.txt
```

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
