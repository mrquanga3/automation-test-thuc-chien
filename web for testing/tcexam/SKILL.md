---
name: tcexam-config
description: Cấu hình lại TCExam — sửa đường dẫn cài đặt (K_PATH_MAIN, K_PATH_HOST, K_PATH_TCEXAM), thông tin database (host, port, name, user, password), và đổi theme giao diện (K_PUBLIC_THEME, K_ADMIN_THEME). Dùng khi gặp lỗi Warning file_put_contents/file_get_contents trỏ sai đường dẫn (vd "C:/xampp/htdocs/tcexam"), khi chuyển project sang máy/ổ đĩa khác, đổi URL truy cập, đổi credential DB, hoặc đổi/tạo theme mới.
---

# TCExam — Reconfigure paths, database & theme

Skill này dùng để sửa nhanh các file cấu hình chính của TCExam khi project bị di chuyển hoặc đổi môi trường:

- `shared/config/tce_paths.php` — đường dẫn filesystem & URL
- `shared/config/tce_db_config.php` — thông tin kết nối database
- `public/config/tce_config.php` & `admin/config/tce_config.php` — theme giao diện

## Triệu chứng thường gặp

Lỗi điển hình khi `K_PATH_MAIN` sai:
```
Warning: file_put_contents(C:/xampp/htdocs/tcexam/cache/lang/language_tmx_en.php):
Failed to open stream: No such file or directory in ...\shared\code\tce_tmx.php on line 123

Warning: file_get_contents(C:/xampp/htdocs/tcexam/shared/config/lang/language_tmx.xml):
Failed to open stream: No such file or directory in ...\shared\code\tce_tmx.php on line 140
```

Lỗi điển hình khi DB sai:
```
Access denied for user 'root'@'localhost'
Unknown database 'tcexam'
Can't connect to MySQL server on '127.0.0.1'
```

## Quy trình thực hiện

### Bước 1 — Xác định môi trường hiện tại

Trước khi sửa, hỏi user (hoặc tự suy ra) các giá trị sau:

| Tham số | Mô tả | Cách lấy |
|---|---|---|
| Đường dẫn cài đặt | Folder gốc tcexam trên ổ đĩa | Chính là project root, dùng forward slash `/` và kết thúc bằng `/` |
| URL Host | Origin truy cập web | Vd `http://localhost`, `http://103.245.237.118` |
| URL prefix | Sub-path nơi tcexam phục vụ | Vd `/tcexam/` (kết thúc bằng `/`) |
| DB Host / Port | MySQL host và port | Mặc định XAMPP: `localhost` / `3306` |
| DB Name | Tên database | Mặc định: `tcexam` |
| DB User / Password | Credential | Mặc định XAMPP: `root` / (rỗng) |

Nếu user không cung cấp đủ, dùng `AskUserQuestion` để hỏi — KHÔNG đoán đường dẫn hoặc credential.

### Bước 2 — Verify đường dẫn tồn tại

Trước khi ghi vào file, **luôn** kiểm tra folder cache hợp lệ:

```bash
ls "<K_PATH_MAIN_value>cache/lang"
```

Nếu folder không tồn tại → đường dẫn user cung cấp sai, hỏi lại.

### Bước 3 — Sửa `shared/config/tce_paths.php`

Các hằng số cần sửa (chỉ 3 dòng đầu, các hằng số khác phái sinh từ chúng nên tự cập nhật):

```php
define('K_PATH_HOST', '<URL host, KHÔNG có trailing slash>');
define('K_PATH_TCEXAM', '<URL prefix, ví dụ "/tcexam/" hoặc "/">');
define('K_PATH_MAIN', '<đường dẫn filesystem, dùng "/" và kết thúc "/">');
```

**Lưu ý quan trọng:**
- `K_PATH_MAIN` LUÔN dùng forward slash `/`, kể cả trên Windows (vd `D:/path/to/tcexam/`)
- `K_PATH_MAIN` LUÔN kết thúc bằng `/`
- Path có khoảng trắng (vd `web for testing`) vẫn hợp lệ với `file_get_contents`/`file_put_contents` của PHP, KHÔNG cần escape
- KHÔNG sửa các hằng số khác trong file này (đoạn "DO NOT CHANGE" từ comment line 56 trở xuống)

Dùng tool `Edit` để thay 3 dòng `define` tương ứng. Match từng dòng riêng để tránh sai sót.

### Bước 4 — Sửa `shared/config/tce_db_config.php` (nếu cần)

Các hằng số cần sửa:

```php
define('K_DATABASE_HOST', 'localhost');     // hoặc 127.0.0.1
define('K_DATABASE_PORT', '3306');           // null nếu dùng socket
define('K_DATABASE_NAME', 'tcexam');
define('K_DATABASE_USER_NAME', 'root');
define('K_DATABASE_USER_PASSWORD', '');
define('K_TABLE_PREFIX', 'tce_');            // hiếm khi cần đổi
```

KHÔNG sửa các `K_TABLE_*` từ line 70 trở xuống (đoạn "DO NOT CHANGE").

### Bước 5 — Xoá cache để rebuild với path mới

Sau khi đổi `K_PATH_MAIN`, file cache ngôn ngữ cũ vẫn còn ở thư mục cũ. Tcexam sẽ tự sinh lại trong thư mục mới khi reload — không cần làm thêm gì. Nhưng nếu thấy lỗi vẫn xuất hiện, có thể xoá thủ công các file `cache/lang/language_tmx_*.php` để force rebuild:

```powershell
Remove-Item "<K_PATH_MAIN>cache/lang/language_tmx_*.php" -Force
```

**KHÔNG xoá file `language_tmx.xml` nguồn** trong `shared/config/lang/`.

### Bước 6 — Kiểm tra

1. Reload trang admin/public của tcexam.
2. Xác nhận không còn warning `file_put_contents` / `file_get_contents`.
3. Đăng nhập thử để verify DB connection.

## Theme switching

TCExam có 2 vùng giao diện độc lập: **public** (storefront cho user làm bài) và **admin** (quản trị). Mỗi vùng load CSS theo hằng số `K_*_THEME`.

### Theme có sẵn

| Vùng | Hằng số | File config | Theme đóng gói |
|---|---|---|---|
| Public | `K_PUBLIC_THEME` | `public/config/tce_config.php:75` | `default`, `picoman` |
| Admin | `K_ADMIN_THEME` | `admin/config/tce_config.php:97` | `default`, `picoman` (picoman do copy từ public — không phải upstream) |

### Cách build path CSS

```php
K_SITE_STYLE     = K_PATH_STYLE_SHEETS . K_PUBLIC_THEME . '.css'
                 // → '../styles/picoman.css' (relative từ public/code/)
K_SITE_STYLE_RTL = K_PATH_STYLE_SHEETS . K_PUBLIC_THEME . '_rtl.css'
                 // dùng cho ngôn ngữ phải-sang-trái (Arabic, Hebrew, Farsi, Urdu)
```

Tương tự cho admin: `K_TCEXAM_STYLE`, `K_TCEXAM_STYLE_RTL`.

### Đổi sang theme có sẵn

Public — sửa [public/config/tce_config.php:75](public/config/tce_config.php#L75):
```php
define('K_PUBLIC_THEME', 'picoman');  // hoặc 'default'
```

Admin — sửa [admin/config/tce_config.php:97](admin/config/tce_config.php#L97):
```php
define('K_ADMIN_THEME', 'default');
```

### Tạo theme mới

Mỗi theme cần đủ 3 file:

| File | Vai trò |
|---|---|
| `<area>/styles/<name>.css` | CSS chính (LTR — left to right) |
| `<area>/styles/<name>_rtl.css` | CSS cho ngôn ngữ RTL (bắt buộc, có thể giống LTR nếu không cần đảo) |
| `<area>/config/theme/<name>.php` | Đoạn footer extra (script, markup phụ — có thể để file rỗng `<?php` nếu không cần) |

`<area>` là `public` hoặc `admin`. Quy trình:

1. Copy 3 file của theme mẫu (`default` hoặc `picoman`) sang tên mới.
2. Tuỳ biến CSS — dùng DevTools inspect các class TCExam dùng (vd `.tceformbox`, `.tcecontentbox`, `#qTopBar`, `.warning`, `.error`, `#testform`).
3. Đổi `K_*_THEME` sang tên mới.
4. Hard refresh trình duyệt (Ctrl+F5) để bỏ cache CSS cũ.

### Bẫy thường gặp khi đổi theme

- **"Đổi rồi mà không thấy gì"** — kiểm tra đúng vùng:
  - `K_PUBLIC_THEME` chỉ áp dụng `/tcexam/public/*` — KHÔNG ảnh hưởng `/tcexam/admin/*`
  - `K_ADMIN_THEME` chỉ áp dụng `/tcexam/admin/*`
- **Browser cache CSS** — Ctrl+F5 hoặc DevTools → Network → Disable cache.
- **PHP OPcache** — restart Apache trong XAMPP Control Panel nếu config thay đổi không có hiệu lực.
- **Thiếu file `_rtl.css`** — TCExam sẽ 404 khi user dùng ngôn ngữ Arabic/Hebrew/Farsi/Urdu. Luôn tạo cả LTR và RTL.
- **Quên file `config/theme/<name>.php`** — TCExam `include` file này ở footer, thiếu sẽ raise warning. Tạo file rỗng (`<?php`) nếu không cần script phụ.

## Tham khảo nhanh — vị trí các define

| Hằng số | File | Line ước chừng |
|---|---|---|
| `K_PATH_HOST` | `shared/config/tce_paths.php` | ~34 |
| `K_PATH_TCEXAM` | `shared/config/tce_paths.php` | ~39 |
| `K_PATH_MAIN` | `shared/config/tce_paths.php` | ~44 |
| `K_DATABASE_HOST` | `shared/config/tce_db_config.php` | ~38 |
| `K_DATABASE_PORT` | `shared/config/tce_db_config.php` | ~47 |
| `K_DATABASE_NAME` | `shared/config/tce_db_config.php` | ~52 |
| `K_DATABASE_USER_NAME` | `shared/config/tce_db_config.php` | ~57 |
| `K_DATABASE_USER_PASSWORD` | `shared/config/tce_db_config.php` | ~62 |
| `K_PUBLIC_THEME` | `public/config/tce_config.php` | ~75 |
| `K_ADMIN_THEME` | `admin/config/tce_config.php` | ~97 |

Số line có thể lệch nếu file đã được chỉnh sửa — luôn `Read` file trước khi `Edit` để xác nhận context.

## Bẫy thường gặp

- **Trộn `\` và `/` trong K_PATH_MAIN** → PHP có thể đọc được nhưng một số đoạn code dùng `basename()` / so sánh chuỗi sẽ lỗi. Luôn dùng `/`.
- **Quên trailing slash** → `K_PATH_LANG_CACHE = K_PATH_MAIN.'cache/lang/'` sẽ thiếu separator → path sai.
- **Sửa nhầm file `.default`** trong `shared/config.default/` — đó là template gốc, KHÔNG được TCExam load. Luôn sửa file trong `shared/config/` (không có `.default`).
- **K_PATH_HOST có trailing slash** → các URL ghép sẽ có double slash `//`. Để host KHÔNG có `/` cuối; còn `K_PATH_TCEXAM` thì BẮT BUỘC có `/` ở hai đầu (vd `/tcexam/`).
- **DB password chứa ký tự đặc biệt** → đặt trong single quote `'...'` để tránh PHP interpolate.
