# Setup XAMPP (Windows)

Hướng dẫn cài đặt và cấu hình môi trường XAMPP trên máy Windows mới, tương tự cấu hình tại `D:\xampp`.

## Bước 1 — Tải và cài đặt XAMPP

1. Tải XAMPP 8.2.12 Windows x64 từ trang chính thức apachefriends.org
2. Chạy installer, chọn components: **Apache, MySQL, PHP, phpMyAdmin** (bỏ FileZilla, Mercury, Tomcat nếu không cần)
3. Chọn thư mục cài đặt theo ý muốn (ví dụ `D:\xampp`)
4. Sau khi cài xong, mở **XAMPP Control Panel** (`xampp-control.exe`) và bật Apache + MySQL

## Bước 2 — Xác nhận cấu hình cơ bản

Đọc file `<xampp_root>\apache\conf\httpd.conf` và kiểm tra:
- `DocumentRoot` trỏ đúng vào `<xampp_root>/htdocs`
- Dòng `Include conf/extra/httpd-vhosts.conf` tồn tại (không bị comment)

Đọc `<xampp_root>\xampp-control.ini` để xác nhận Apache=1 và MySQL=1.

## Bước 3 — Trỏ thư mục web project (Alias)

Nếu project nằm ngoài htdocs (ví dụ có khoảng trắng trong đường dẫn), thêm vào `httpd.conf` ngay SAU block `</Directory>` của htdocs:

```apache
Alias /testlink "D:/automation-test-thuc-chien/web for testing/testlink"
<Directory "D:/automation-test-thuc-chien/web for testing/testlink">
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride All
    Require all granted
</Directory>
```

Thay `/testlink` và đường dẫn tương ứng với project thực tế. **Luôn dùng dấu nháy kép cho path có khoảng trắng.**

## Bước 4 — Trỏ thư mục web project (VirtualHost — nếu muốn hostname riêng)

Thêm vào `<xampp_root>\apache\conf\extra\httpd-vhosts.conf`:

```apache
# Block mặc định — phải có để localhost vẫn hoạt động
<VirtualHost *:80>
    DocumentRoot "<xampp_root>/htdocs"
    ServerName localhost
</VirtualHost>

# Block cho project
<VirtualHost *:80>
    DocumentRoot "D:/path/to/project"
    ServerName myproject.local
    <Directory "D:/path/to/project">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Sau đó thêm vào `C:\Windows\System32\drivers\etc\hosts` (cần quyền Admin):
```
127.0.0.1    myproject.local
```

## Bước 5 — Restart Apache và kiểm tra

Restart Apache từ XAMPP Control Panel (Stop → Start).

Kiểm tra:
- `http://localhost` → XAMPP dashboard
- `http://localhost/phpmyadmin` → phpMyAdmin
- `http://localhost/<alias>` hoặc `http://myproject.local` → project

Nếu lỗi:
- **403 Forbidden** → kiểm tra lại `<Directory>` block, đặc biệt `Require all granted`
- **500 Internal Server Error** → xem log tại `<xampp_root>\apache\logs\error.log`
- **Apache không start** → lỗi syntax trong httpd.conf hoặc httpd-vhosts.conf; chạy `<xampp_root>\apache\bin\httpd.exe -t` để kiểm tra syntax

## Bước 6 — Cấu hình PHP (tùy chọn)

File config: `<xampp_root>\php\php.ini`

Các setting hay cần chỉnh cho môi trường dev:
```ini
display_errors = On
error_reporting = E_ALL
max_execution_time = 120
upload_max_filesize = 64M
post_max_size = 64M
```

## Thông tin phiên bản tham chiếu

| Component | Version |
|-----------|---------|
| XAMPP | 8.2.12 |
| Apache | 2.4.58 |
| MariaDB | 10.4.32 |
| PHP | 8.2.12 (64-bit, thread-safe) |
| phpMyAdmin | 5.2.1 |

## Lệnh hữu ích

```bat
# Kiểm tra syntax Apache config
<xampp_root>\apache\bin\httpd.exe -t

# Chạy PHP CLI
<xampp_root>\php\php.exe script.php
<xampp_root>\php\php.exe -l script.php   # kiểm tra syntax

# Kết nối MariaDB qua CLI
<xampp_root>\mysql\bin\mysql.exe -u root -p
```

Mật khẩu root mặc định sau cài đặt là rỗng. Đặt mật khẩu mới ngay sau khi cài xong qua phpMyAdmin.
