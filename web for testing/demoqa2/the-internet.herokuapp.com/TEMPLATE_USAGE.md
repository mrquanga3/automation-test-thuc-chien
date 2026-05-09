# Hướng dẫn sử dụng Template

## Cách tạo page mới

### Bước 1: Copy template.html
```
1. Mở template.html
2. Copy toàn bộ nội dung
3. Tạo file mới, ví dụ: context_menu.html
4. Paste nội dung vào
```

### Bước 2: Chỉnh sửa các placeholder

#### a) Đổi PAGE_TITLE
```html
<!-- Trước: -->
<title>PAGE_TITLE - The Internet</title>

<!-- Sau: -->
<title>Context Menu - The Internet</title>
```

#### b) Đánh dấu menu item hiện tại (thêm class="active")
Tìm menu item của page hiện tại và thêm `class="active"`:

**Ví dụ: context_menu.html**
```html
<!-- Tìm trong menu "Interactions": -->
<a href="context_menu.html" class="active">Context Menu</a>
```

**Ví dụ: checkboxes.html**
```html
<!-- Tìm trong menu "Form & Input": -->
<a href="checkboxes.html" class="active">Checkboxes</a>
```

#### c) Mở menu group của page hiện tại (thêm class="open")
Thêm `class="open"` vào div.menu-items của menu group hiện tại:

**Ví dụ: context_menu.html (thuộc "Interactions")**
```html
<div class="menu-items open">  <!-- Thêm open -->
    <a href="drag_and_drop.html">Drag and Drop</a>
    <a href="hovers.html">Hovers</a>
    <a href="context_menu.html" class="active">Context Menu</a>
    <a href="floating_menu.html">Floating Menu</a>
</div>
```

#### d) Replace nội dung trang
Tìm comment:
```html
<!-- PAGE CONTENT GOES HERE -->
```

Thay thế bằng nội dung thực tế của page. Lấy từ file `.html` cũ (nếu có).

## Ví dụ hoàn chỉnh: context_menu.html

```html
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Context Menu - The Internet</title>
    <!-- CSS và scripts giữ nguyên -->
    ...
</head>
<body>
    ...
    <div id="container">
        <div id="sidebar">
            ...
            <!-- Menu "Interactions" được mở -->
            <div class="menu-group">
                <div class="menu-group-title" onclick="toggleMenu(this)">
                    <span>Interactions</span>
                    <span class="arrow">▶</span>
                </div>
                <div class="menu-items open">  <!-- ← Thêm open -->
                    <a href="drag_and_drop.html">Drag and Drop</a>
                    <a href="hovers.html">Hovers</a>
                    <a href="context_menu.html" class="active">Context Menu</a> <!-- ← Thêm active -->
                    <a href="floating_menu.html">Floating Menu</a>
                </div>
            </div>
            ...
        </div>

        <div id="content">
            <div id="page-content">
                <!-- Nội dung thực tế của trang -->
                <div class="example">
                    <h3>Context Menu</h3>
                    <p>Right-click in the box below...</p>
                    <div id='hot-spot' style="border-style: dashed; ...">
                    </div>
                </div>
                <script>
                function displayMessage() {
                  window.alert('You selected a context menu')
                }
                </script>
                <!-- End PAGE CONTENT -->
            </div>
            <div id='page-footer'>
                <hr>
                <div>Powered by <a target="_blank" href="...">Elemental Selenium</a></div>
            </div>
        </div>
    </div>
</body>
</html>
```

## Các menu group cần lưu ý

- **Form & Input** → `CURRENT_MENU_FORM`
- **Authentication** → `CURRENT_MENU_AUTH`
- **Interactions** → `CURRENT_MENU_INTERACTIONS`
- **Dynamic Content** → `CURRENT_MENU_DYNAMIC`
- **Advanced DOM** → `CURRENT_MENU_ADVANCED`
- **JavaScript** → `CURRENT_MENU_JS`
- **Windows & Frames** → `CURRENT_MENU_WINDOWS`
- **Files** → `CURRENT_MENU_FILES`
- **Testing Patterns** → `CURRENT_MENU_TESTING`

## Khi cần update menu

1. Chỉnh template.html
2. Copy menu mới
3. Paste vào tất cả các file .html
4. Chỉ cần giữ lại `class="active"` và `class="open"` cho page hiện tại
