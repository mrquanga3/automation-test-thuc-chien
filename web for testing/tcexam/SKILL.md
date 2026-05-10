# SKILL.md — TCExam Development Skills & Lessons

## Language Selector Implementation

### Problem: Language Selector Positioning
**Issue:** Language dropdown appeared on the left side below logo instead of right side next to timer.

**Root Cause:** Parent `.right` CSS class has `flex-direction: column`, which stacks child elements vertically.

**Solution:** Add explicit `flex-direction: row;` to inner flex container to override parent's column layout.

```php
// In admin/code/tce_page_header.php and public/code/tce_page_header.php
echo '<div style="display:flex; flex-direction:row; align-items:center; gap:15px; justify-content:flex-end;">'.K_NEWLINE;
```

**Key Learning:** Child flex containers need explicit `flex-direction` when parent uses `flex-direction: column`.

---

### Problem: Language Dropdown Not Reflecting Selected Language
**Issue:** After changing language via dropdown, the page text changed correctly but dropdown still showed old language selection.

**Root Cause:** PHP's `setcookie()` sends HTTP headers but doesn't immediately update `$_COOKIE` superglobal in the same request. When page renders and dropdown checks `$_COOKIE['SessionUserLang']`, it still has the old value.

**Solution:** Manually update `$_COOKIE` immediately after `setcookie()`.

```php
// In shared/config/tce_config.php
if (isset($_POST['xlang'])
    and (strlen($_POST['xlang']) == 2)
    and (array_key_exists($_POST['xlang'], unserialize(K_AVAILABLE_LANGUAGES)))) {
    define('K_USER_LANG', $_POST['xlang']);
    setcookie('SessionUserLang', K_USER_LANG, time() + K_COOKIE_EXPIRE, K_COOKIE_PATH, K_COOKIE_DOMAIN, K_COOKIE_SECURE);
    $_COOKIE['SessionUserLang'] = K_USER_LANG;  // ← Add this line
}
```

**Key Learning:** When setting cookies in PHP, manually update `$_COOKIE` if same-request code needs to see the new value.

---

### Problem: Language Selection Sometimes Fails or Resets
**Issue:** Intermittently, changing language wouldn't persist or would reset to different language.

**Root Causes & Solutions:**

1. **Unreliable form submission handler**
   - Old: `onchange="document.getElementById('form_lang_header').submit();"`
   - New: `onchange="this.form.submit();"`
   - **Why:** `this.form.submit()` is more direct and avoids potential DOM lookup issues.

2. **Browser caching old language version**
   - Add no-cache headers to prevent serving cached pages with old language:
   ```php
   header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
   header('Cache-Control: post-check=0, pre-check=0', false);
   header('Pragma: no-cache');
   header('Expires: ' . date('r', time() - 86400));
   ```
   - **When:** Add in `shared/config/tce_config.php` after loading language resources.
   - **Why:** Ensures page always refreshes when language changes, preventing stale cached versions.

**Key Learning:** Language selection depends on three things working together:
1. Form reliably submits ✓
2. Cookie immediately reflects change ✓
3. Browser doesn't serve cached old version ✓

---

## Language Loading Priority (tce_config.php)

The language selection follows this priority order:

```
1. POST['xlang']           ← Form submission (highest priority)
2. REQUEST['lang']         ← URL parameter
3. COOKIE['SessionUserLang'] ← Saved from previous session
4. K_LANGUAGE ('en')       ← Default fallback
```

When implementing language changes, always use POST['xlang'] in dropdown forms.

---

## Verification Checklist

When testing language selector after changes:
- [ ] Dropdown appears on right side of header, next to timer
- [ ] Dropdown shows correct language selected immediately after change
- [ ] Page text updates to match selected language
- [ ] Selection persists after page navigation (uses cookie)
- [ ] Selection persists after browser refresh (uses cookie)
- [ ] No browser cache issues (test with fresh load)

---

## Files Involved

| File | Purpose | Key Changes |
|------|---------|------------|
| `admin/code/tce_page_header.php` | Admin header with language selector | flex-direction, form submission |
| `public/code/tce_page_header.php` | Public header with language selector | flex-direction, form submission |
| `shared/config/tce_config.php` | Language loading logic | Cookie update, no-cache headers |
| `admin/styles/picoman.css` | Theme CSS | `.right` class has flex-direction: column |

---

## Testing with Playwright

Quick test script to verify language selection:

```javascript
const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  
  await page.goto('http://localhost/tcexam/public/code/tce_login.php');
  
  // Change language
  await page.locator('select[name="xlang"]').selectOption('vn');
  await page.waitForNavigation();
  
  // Verify dropdown and content
  const selectedLang = await page.locator('select[name="xlang"]').inputValue();
  const heading = await page.locator('h1').textContent();
  
  console.log('Selected language:', selectedLang); // Should be 'vn'
  console.log('Heading:', heading);                // Should be Vietnamese
  
  await browser.close();
})();
```

Run with: `npx node test-lang-selection.js`

---

## Custom Dropdown Implementation (Answer Selection)

### Problem: Native HTML Select Can't Detect Hover on Individual Options
**Issue:** Need to display detailed information (user, status, score, question, answer) when hovering over answer options in the rating editor, but native `<select>` elements don't expose individual `<option>` hover events to JavaScript.

**Root Cause:** HTML `<select>` dropdowns are browser-native components with limited JavaScript API access. The browser doesn't allow detecting which specific `<option>` is being hovered — only the selected option is accessible.

**Solution:** Replace native `<select>` with a custom div-based dropdown component:

```php
// In admin/code/tce_edit_rating.php
// 1. Use hidden input instead of native select
echo '<input type="hidden" name="testlog_id" id="testlog_id" value="'.$testlog_id.'">';

// 2. Create custom dropdown div structure
echo '<div id="custom-dropdown" class="custom-dropdown">';
echo '  <div class="dropdown-trigger">Display selected</div>';
echo '  <div class="dropdown-menu">';
echo '    <div class="dropdown-option" data-testlog-id="...">Option content</div>';
echo '  </div>';
echo '</div>';
```

**CSS & JavaScript:**
- Toggle dropdown visibility on trigger click
- Show formatted option content with proper text wrapping (max 100 chars per line)
- Handle click to select and submit form
- Each option displays: User | Status | Score | Question | Answer

**Key Features:**
- Full data attributes for each option: `data-testlog-id`, `data-user`, `data-status`, `data-score`, `data-question`, `data-answer`
- Multi-line option display with text wrapping
- Selected answer display shows formatted details on page load
- Consistent styling with other form dropdowns

**Files Modified:**
- `admin/code/tce_edit_rating.php` (lines 248-530+)

**Key Learning:** When native HTML elements don't support needed interactions, custom components using divs/spans with JavaScript provide full control.

---

## PDF Percentage Formatting Error

### Problem: Fatal TypeError in PDF Generation
**Issue:** When generating PDF reports, fatal error: `TypeError: round(): Argument #1 ($num) must be of type int|float, string given`

**Root Cause:** The `F_formatPdfPercentage()` function in `tce_functions_general.php` was receiving an empty string or null value instead of a numeric percentage. The `round()` function was called with a non-numeric value.

**Solution:** Add input validation to handle non-numeric or empty values:

```php
// In shared/code/tce_functions_general.php line 441
function F_formatPdfPercentage($num, $ratio = true)
{
    if (empty($num) || !is_numeric($num)) {
        return '(  0%)';  // ← Default to 0% for empty/invalid values
    }
    if ($ratio) {
        $num = (100 * $num);
    }
    return '('.sprintf('% 3d', round($num)).'%)';
}
```

**Why This Works:**
- Checks if value is empty or not numeric before calling `round()`
- Gracefully defaults to 0% for missing/invalid data
- Prevents fatal error while maintaining sensible fallback

**Files Modified:**
- `shared/code/tce_functions_general.php` (lines 441-447)

**Key Learning:** Functions receiving data from database/forms should validate input types before performing strict operations like `round()`, `intval()`, etc.

---

## REST API Documentation

### Overview

A custom REST API system has been implemented for programmatic user management and testing operations. The API uses a routing mechanism via the `route` query parameter and returns JSON responses with proper HTTP status codes.

**Base URL:** `http://localhost/tcexam/admin/code/tce_api.php?route=<endpoint>`

### Authentication

All API endpoints (except login) require Bearer token in the `Authorization` header.

#### Apache Configuration (XAMPP)

⚠️ **Important:** Apache must be configured to pass the Authorization header to PHP. Add this to `httpd-xampp.conf`:

```apache
<Directory "D:/automation-test-thuc-chien/web for testing/tcexam/">
    AllowOverride All
    Require all granted
    SetEnvIf Authorization .+ HTTP_AUTHORIZATION=$0
</Directory>
```

This directive tells Apache to copy the `Authorization` header into the `HTTP_AUTHORIZATION` server variable, which PHP can access via `$_SERVER['HTTP_AUTHORIZATION']`.

After adding this, restart Apache: `httpd.exe -k restart`

#### Login Endpoint
**Route:** `api/auth.login`  
**Method:** `POST`

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| user_name | Yes | string | Username |
| password | Yes | string | Password |

**Example Request:**
```bash
curl -X POST "http://localhost/tcexam/admin/code/tce_api.php?route=api/auth.login" \
  -d "user_name=admin&password=admin123"
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "Login successful",
  "token": "eyJjcmVhdGVkIjoiMjAyNi0wNS0xMFQxMDozMDowMFoiLCJ1c2VyX2lkIjoxLCJ1c2VyX2xldmVsIjoxMH0=.abc123signature456",
  "user_id": 1,
  "user_level": 10
}
```

**Using the Token:**
All subsequent requests must include the token in the `Authorization` header:

```bash
curl "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.list" \
  -H "Authorization: Bearer eyJjcmVhdGVkIjoiMjAyNi0wNS0xMFQxMDozMDowMFoiLCJ1c2VyX2lkIjoxLCJ1c2VyX2xldmVsIjoxMH0=.abc123signature456"
```

---

### User Management Endpoints

#### 1. Create User (Add)
**Route:** `api/user.add`  
**Method:** `POST`

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| user_name | Yes | string | Unique username |
| password | Yes | string | User password (will be hashed) |
| firstname | Yes | string | First name |
| lastname | Yes | string | Last name |
| email | Yes | string | Email address |
| user_level | No | int | User access level (default: 1). Values: 1-10 |

**Example Request:**
```bash
curl -X POST "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.add" \
  -d "user_name=john_doe&password=SecurePass123&firstname=John&lastname=Doe&email=john@example.com&user_level=1"
```

**Success Response (201 Created):**
```json
{
  "status": "success",
  "message": "User added successfully",
  "user_id": 5
}
```

**Error Response (400 Bad Request):**
```json
{
  "status": "error",
  "message": "Missing required field: user_name"
}
```

**Error Response (409 Conflict):**
```json
{
  "status": "error",
  "message": "User already exists"
}
```

---

#### 2. Update User (Edit)
**Route:** `api/user.edit`  
**Method:** `POST`

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| user_id | Yes | int | User ID to update |
| user_name | No | string | New username |
| firstname | No | string | New first name |
| lastname | No | string | New last name |
| email | No | string | New email |
| password | No | string | New password (will be hashed) |
| user_level | No | int | User access level (1-10) |

**Example Request:**
```bash
curl -X POST "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.edit" \
  -d "user_id=5&firstname=Jonathan&email=jonathan@example.com"
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "User updated successfully",
  "user_id": 5
}
```

**Error Response (404 Not Found):**
```json
{
  "status": "error",
  "message": "User not found"
}
```

---

#### 3. List Users
**Route:** `api/user.list`  
**Method:** `GET`

**Parameters:**
| Parameter | Required | Type | Default | Description |
|-----------|----------|------|---------|-------------|
| page | No | int | 1 | Page number |
| limit | No | int | 50 | Results per page |

**Example Request:**
```bash
curl "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.list&page=1&limit=20"
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "page": 1,
  "limit": 20,
  "users": [
    {
      "user_id": 1,
      "user_name": "admin",
      "firstname": "Admin",
      "lastname": "User",
      "email": "admin@example.com",
      "user_level": 10
    },
    {
      "user_id": 5,
      "user_name": "john_doe",
      "firstname": "John",
      "lastname": "Doe",
      "email": "john@example.com",
      "user_level": 1
    }
  ]
}
```

---

#### 4. Get Single User
**Route:** `api/user.get`  
**Method:** `GET`

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| user_id | Yes | int | User ID to retrieve |

**Example Request:**
```bash
curl "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.get&user_id=5"
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "user": {
    "user_id": 5,
    "user_name": "john_doe",
    "firstname": "John",
    "lastname": "Doe",
    "email": "john@example.com",
    "user_level": 1
  }
}
```

**Error Response (404 Not Found):**
```json
{
  "status": "error",
  "message": "User not found"
}
```

---

#### 5. Delete User
**Route:** `api/user.delete`  
**Method:** `POST`

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| user_id | Yes | int | User ID to delete |

**Example Request:**
```bash
curl -X POST "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.delete" \
  -d "user_id=5"
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "User deleted successfully",
  "user_id": 5
}
```

**Error Response (404 Not Found):**
```json
{
  "status": "error",
  "message": "User not found"
}
```

---

### HTTP Status Codes

| Code | Meaning | When Used |
|------|---------|-----------|
| 200 | OK | Successful GET, POST update/delete |
| 201 | Created | Successful user creation |
| 400 | Bad Request | Missing required fields |
| 404 | Not Found | User doesn't exist |
| 405 | Method Not Allowed | Wrong HTTP method (POST vs GET) |
| 409 | Conflict | User already exists (on create) |
| 500 | Server Error | Database error |

---

### PowerShell Examples

#### Step 1: Login to Get Token
```powershell
$loginUri = "http://localhost/tcexam/admin/code/tce_api.php?route=api/auth.login"
$loginBody = @{
    user_name = "admin"
    password = "admin123"
}
$loginResponse = Invoke-WebRequest -Uri $loginUri -Method POST -Body $loginBody -ContentType "application/x-www-form-urlencoded"
$loginData = $loginResponse.Content | ConvertFrom-Json
$token = $loginData.token
```

#### Add User
```powershell
$uri = "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.add"
$headers = @{ "Authorization" = "Bearer $token" }
$body = @{
    user_name = "testuser"
    password = "TestPass123"
    firstname = "Test"
    lastname = "User"
    email = "test@example.com"
    user_level = "1"
}
$response = Invoke-WebRequest -Uri $uri -Method POST -Body $body -Headers $headers -ContentType "application/x-www-form-urlencoded"
$response.Content | ConvertFrom-Json
```

#### Edit User
```powershell
$uri = "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.edit"
$headers = @{ "Authorization" = "Bearer $token" }
$body = @{
    user_id = "5"
    firstname = "Updated"
    email = "newemail@example.com"
}
$response = Invoke-WebRequest -Uri $uri -Method POST -Body $body -Headers $headers -ContentType "application/x-www-form-urlencoded"
$response.Content | ConvertFrom-Json
```

#### List Users
```powershell
$uri = "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.list&page=1&limit=50"
$headers = @{ "Authorization" = "Bearer $token" }
$response = Invoke-WebRequest -Uri $uri -Method GET -Headers $headers
$response.Content | ConvertFrom-Json
```

#### Get Single User
```powershell
$uri = "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.get&user_id=5"
$headers = @{ "Authorization" = "Bearer $token" }
$response = Invoke-WebRequest -Uri $uri -Method GET -Headers $headers
$response.Content | ConvertFrom-Json
```

#### Delete User
```powershell
$uri = "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.delete"
$headers = @{ "Authorization" = "Bearer $token" }
$body = @{ user_id = "5" }
$response = Invoke-WebRequest -Uri $uri -Method POST -Body $body -Headers $headers -ContentType "application/x-www-form-urlencoded"
$response.Content | ConvertFrom-Json
```

#### Bash/curl Examples

**Step 1: Login to get token**
```bash
LOGIN_RESPONSE=$(curl -s -X POST "http://localhost/tcexam/admin/code/tce_api.php?route=api/auth.login" \
  -d "user_name=admin&password=1234")
TOKEN=$(echo "$LOGIN_RESPONSE" | grep -o '"token":"[^"]*"' | cut -d'"' -f4)
echo "Token: $TOKEN"
```

**Add user**
```bash
curl -X POST "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.add" \
  -H "Authorization: Bearer $TOKEN" \
  -d "user_name=testuser&password=TestPass123&firstname=Test&lastname=User&email=test@example.com&user_level=1"
```

**Edit user**
```bash
curl -X POST "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.edit" \
  -H "Authorization: Bearer $TOKEN" \
  -d "user_id=5&firstname=Updated&email=newemail@example.com"
```

**List users**
```bash
curl "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.list&page=1&limit=50" \
  -H "Authorization: Bearer $TOKEN"
```

**Get user**
```bash
curl "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.get&user_id=5" \
  -H "Authorization: Bearer $TOKEN"
```

**Delete user**
```bash
curl -X POST "http://localhost/tcexam/admin/code/tce_api.php?route=api/user.delete" \
  -H "Authorization: Bearer $TOKEN" \
  -d "user_id=5"
```

**Note:** Use `curl.exe` on Windows via PowerShell (with `.exe` extension). On Linux/Mac, use `curl` directly.

---

### Module Management Endpoints

#### 1. Create Module (Add)
**Route:** `api/module.add`  
**Method:** `POST`  
**Permission:** Admin only (level 10)

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| module_name | Yes | string | Module name |
| module_enabled | No | int | 1 (enabled) or 0 (disabled), default: 0 |

**Example Request (bash):**
```bash
curl -X POST "http://localhost/tcexam/admin/code/tce_api.php?route=api/module.add" \
  -H "Authorization: Bearer $TOKEN" \
  -d "module_name=Mathematics&module_enabled=1"
```

**Success Response (201 Created):**
```json
{
  "status": "success",
  "message": "Module added successfully",
  "module_id": 12
}
```

---

#### 2. Update Module (Edit)
**Route:** `api/module.edit`  
**Method:** `POST`  
**Permission:** Admin only (level 10)

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| module_id | Yes | int | Module ID to update |
| module_name | No | string | New module name |
| module_enabled | No | int | 1 or 0 |

---

#### 3. Get Single Module
**Route:** `api/module.get`  
**Method:** `GET`  
**Permission:** Authenticated users

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| module_id | Yes | int | Module ID to retrieve |

---

#### 4. List Modules
**Route:** `api/module.list`  
**Method:** `GET`  
**Permission:** Authenticated users

**Success Response (200 OK):**
```json
{
  "status": "success",
  "modules": [
    {
      "module_id": 1,
      "module_name": "Mathematics",
      "module_enabled": 1
    },
    {
      "module_id": 12,
      "module_name": "Physics",
      "module_enabled": 1
    }
  ]
}
```

---

#### 5. Delete Module
**Route:** `api/module.delete`  
**Method:** `POST`  
**Permission:** Admin only (level 10)

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| module_id | Yes | int | Module ID to delete |

---

### Topic (Subject) Management Endpoints

Topics are organized under modules. Database table: `tce_subjects`

#### 1. Create Topic (Add)
**Route:** `api/topic.add`  
**Method:** `POST`  
**Permission:** Admin only (level 10)

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| module_id | Yes | int | Parent module ID |
| topic_name | Yes | string | Topic name |
| topic_description | No | string | Topic description |
| topic_enabled | No | int | 1 (enabled) or 0 (disabled), default: 0 |

**Example Request (bash):**
```bash
curl -X POST "http://localhost/tcexam/admin/code/tce_api.php?route=api/topic.add" \
  -H "Authorization: Bearer $TOKEN" \
  -d "module_id=12&topic_name=Algebra&topic_description=Fundamentals of algebra&topic_enabled=1"
```

**Success Response (201 Created):**
```json
{
  "status": "success",
  "message": "Topic added successfully",
  "topic_id": 10
}
```

---

#### 2. Update Topic (Edit)
**Route:** `api/topic.edit`  
**Method:** `POST`  
**Permission:** Admin only (level 10)

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| topic_id | Yes | int | Topic ID to update |
| topic_name | No | string | New topic name |
| topic_description | No | string | New description |
| topic_enabled | No | int | 1 or 0 |

---

#### 3. Get Single Topic
**Route:** `api/topic.get`  
**Method:** `GET`  
**Permission:** Authenticated users

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| topic_id | Yes | int | Topic ID to retrieve |

---

#### 4. List Topics by Module
**Route:** `api/topic.list`  
**Method:** `GET`  
**Permission:** Authenticated users

**Parameters:**
| Parameter | Required | Type | Default | Description |
|-----------|----------|------|---------|-------------|
| module_id | No | int | - | Filter by module (if not provided, lists all topics) |
| page | No | int | 1 | Page number |
| limit | No | int | 50 | Results per page |

**Success Response (200 OK):**
```json
{
  "status": "success",
  "subjects": [
    {
      "subject_id": 10,
      "subject_module_id": 12,
      "subject_name": "Algebra",
      "subject_description": "Fundamentals of algebra",
      "subject_enabled": 1
    }
  ]
}
```

---

#### 5. Delete Topic
**Route:** `api/topic.delete`  
**Method:** `POST`  
**Permission:** Admin only (level 10)

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| topic_id | Yes | int | Topic ID to delete |

---

### Question Management Endpoints

Questions belong to topics. Database table: `tce_questions`

#### 1. Create Question (Add)
**Route:** `api/question.add`  
**Method:** `POST`  
**Permission:** Admin only (level 10)

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| topic_id | Yes | int | Parent topic ID |
| question_description | Yes | string | Question text |
| question_type | No | int | Question type (1=single choice, 2=multiple choice, etc.), default: 1 |
| question_difficulty | No | int | Difficulty level (1-5), default: 1 |
| question_explanation | No | string | Answer explanation |
| question_enabled | No | int | 1 (enabled) or 0 (disabled), default: 0 |

**Example Request (bash):**
```bash
curl -X POST "http://localhost/tcexam/admin/code/tce_api.php?route=api/question.add" \
  -H "Authorization: Bearer $TOKEN" \
  -d "topic_id=10&question_description=What is 2+2?&question_type=1&question_difficulty=1&question_enabled=1"
```

**Success Response (201 Created):**
```json
{
  "status": "success",
  "message": "Question added successfully",
  "question_id": 218
}
```

---

#### 2. Update Question (Edit)
**Route:** `api/question.edit`  
**Method:** `POST`  
**Permission:** Admin only (level 10)

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| question_id | Yes | int | Question ID to update |
| question_description | No | string | New question text |
| question_type | No | int | Question type |
| question_difficulty | No | int | Difficulty level (1-5) |
| question_explanation | No | string | New explanation |
| question_enabled | No | int | 1 or 0 |

---

#### 3. Get Single Question
**Route:** `api/question.get`  
**Method:** `GET`  
**Permission:** Authenticated users

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| question_id | Yes | int | Question ID to retrieve |

---

#### 4. List Questions by Topic
**Route:** `api/question.list`  
**Method:** `GET`  
**Permission:** Authenticated users

**Parameters:**
| Parameter | Required | Type | Default | Description |
|-----------|----------|------|---------|-------------|
| topic_id | No | int | - | Filter by topic ID |
| page | No | int | 1 | Page number |
| limit | No | int | 50 | Results per page |

**Success Response (200 OK):**
```json
{
  "status": "success",
  "page": 1,
  "limit": 50,
  "questions": [
    {
      "question_id": 218,
      "question_subject_id": 10,
      "question_description": "What is 2+2?",
      "question_type": 1,
      "question_difficulty": 1,
      "question_enabled": 1
    }
  ]
}
```

---

#### 5. Delete Question
**Route:** `api/question.delete`  
**Method:** `POST`  
**Permission:** Admin only (level 10)

**Parameters:**
| Parameter | Required | Type | Description |
|-----------|----------|------|-------------|
| question_id | Yes | int | Question ID to delete |

---

### Implementation Details

**File:** `admin/code/tce_api.php`

**Database Tables & Columns Used:**

**Users Table** (`tce_users`):
- `user_id` - Primary key
- `user_name` - Unique username
- `user_password` - Hashed password
- `user_firstname` - First name
- `user_lastname` - Last name
- `user_email` - Email address
- `user_level` - Access level (1-10, NOT user_status)

**Modules Table** (`tce_modules`):
- `module_id` - Primary key
- `module_name` - Module name
- `module_enabled` - 1 (enabled) or 0 (disabled)
- `module_user_id` - User who created the module

**Topics/Subjects Table** (`tce_subjects`):
- `subject_id` - Primary key
- `subject_module_id` - Parent module ID
- `subject_name` - Topic name
- `subject_description` - Description
- `subject_enabled` - 1 (enabled) or 0 (disabled)
- `subject_user_id` - User who created the topic

**Questions Table** (`tce_questions`):
- `question_id` - Primary key
- `question_subject_id` - Parent topic ID
- `question_description` - Question text
- `question_explanation` - Answer explanation
- `question_type` - Question type (1=single, 2=multiple, etc.)
- `question_difficulty` - Difficulty level (1-5)
- `question_enabled` - 1 (enabled) or 0 (disabled)

**Features:**
- JSON request/response format
- SQL injection protection via `F_escape_sql()`
- Password hashing using PHP's `password_hash()` (PASSWORD_DEFAULT algorithm)
- Duplicate user detection before creation
- Flexible partial updates (only update provided fields)
- Proper HTTP status codes for all scenarios
- CORS headers enabled for cross-origin requests
- Exit statements prevent duplicate responses

**Security Considerations:**
- Passwords are never returned in API responses
- All user input is escaped before database operations
- Only existing resources can be updated/deleted
- Database errors are caught and returned as JSON
- **Permission-based access control across all endpoints:**
  
  **User Management:**
  - **Add user** (`api/user.add`) — **Admin only** (level 10)
  - **Edit user** (`api/user.edit`) — **Admin can edit any user; non-admin can edit themselves only**
    - Non-admin users attempting to edit other users get 403 Forbidden
    - Non-admin users cannot modify their own `user_level`
  - **Delete user** (`api/user.delete`) — **Admin only** (level 10)
  - **Get user** (`api/user.get`) — Any authenticated user
  - **List users** (`api/user.list`) — Any authenticated user
  
  **Module Management:**
  - **Add module** (`api/module.add`) — **Admin only** (level 10)
  - **Edit module** (`api/module.edit`) — **Admin only** (level 10)
  - **Delete module** (`api/module.delete`) — **Admin only** (level 10)
  - **Get module** (`api/module.get`) — Any authenticated user
  - **List modules** (`api/module.list`) — Any authenticated user
  
  **Topic Management:**
  - **Add topic** (`api/topic.add`) — **Admin only** (level 10)
  - **Edit topic** (`api/topic.edit`) — **Admin only** (level 10)
  - **Delete topic** (`api/topic.delete`) — **Admin only** (level 10)
  - **Get topic** (`api/topic.get`) — Any authenticated user
  - **List topics** (`api/topic.list`) — Any authenticated user
  
  **Question Management:**
  - **Add question** (`api/question.add`) — **Admin only** (level 10)
  - **Edit question** (`api/question.edit`) — **Admin only** (level 10)
  - **Delete question** (`api/question.delete`) — **Admin only** (level 10)
  - **Get question** (`api/question.get`) — Any authenticated user
  - **List questions** (`api/question.list`) — Any authenticated user

**Bug Fixes & Improvements:**
- Fixed double response issue by adding `exit;` after each handler function
- Corrected column names to match actual TCExam schema (`user_level` instead of `user_status`)
- Added permission checks to enforce user level restrictions on sensitive operations
- Extended API with 15 additional endpoints (5 for modules, 5 for topics, 5 for questions) following the same security and permission patterns
- All 25+ endpoints (users + modules + topics + questions) use consistent Bearer token authentication and HTTP status codes
- Added comprehensive test suite (`test_api_modules.sh`) validating all new endpoints in sequence

---

### Key Learning

When building REST APIs:
1. Use proper HTTP methods (GET for retrieval, POST for mutation)
2. Return appropriate status codes for different scenarios
3. Always escape user input before database operations
4. Hash sensitive data (passwords) immediately on input
5. Validate required fields before processing
6. Return consistent JSON structure across all endpoints
7. Provide meaningful error messages without exposing internal details
8. **Exit immediately after handler execution** — without `exit;`, handler functions continue to execute causing duplicate responses
9. **Verify against actual database schema** — column names vary by system (e.g., TCExam uses `user_level` not `user_status`)

---

### API Testing

**User API Test File:** `test_api.sh` (Bash/curl test script)

**Purpose:** Comprehensive test suite that validates all 5 user management endpoints in sequence:
1. Add User — creates a test user with timestamp-based unique name
2. Get Single User — retrieves the created user
3. List Users — retrieves paginated user list
4. Update User — updates user's firstname and email
5. Verify Update — confirms changes were applied
6. Delete User — removes the test user
7. Verify Deletion — confirms user no longer exists

**Run the tests:**
```bash
# Using Git Bash (Windows) or bash (Linux/Mac)
bash test_api.sh
```

---

**Module, Topic, Question API Test File:** `test_api_modules.sh` (Bash/curl test script)

**Purpose:** Comprehensive test suite that validates all 15 endpoints (5 for modules, 5 for topics, 5 for questions):

Module Tests (1-4):
1. Add Module
2. Get Single Module
3. List Modules
4. Update Module

Topic Tests (5-8):
5. Add Topic
6. Get Single Topic
7. List Topics by Module
8. Update Topic

Question Tests (9-12):
9. Add Question
10. Get Single Question
11. List Questions by Topic
12. Update Question

Cleanup Tests (13-15):
13. Delete Question
14. Delete Topic
15. Delete Module

**Run the tests:**
```bash
# Using Git Bash (Windows) or bash (Linux/Mac)
bash test_api_modules.sh

# Or on Linux/Mac
./test_api.sh
```

**Features:**
- Color-coded output (blue for test names, green for success, red for failures, yellow for warnings)
- Uses `jq` for JSON parsing when available (graceful fallback to raw output)
- Extracts `user_id` from response and uses it for subsequent tests
- Timestamp-based unique usernames prevent conflicts with previous test runs
- Clear pass/fail messages for each test stage

**Output Example:**
```
==========================================
TCExam REST API Test Suite
==========================================

[TEST 1] Adding User
Request: POST api/user.add
...
✓ User created with ID: 42

[TEST 2] Getting Single User
...
✓ User retrieved successfully

...

[TEST 7] Verifying Deletion
...
✓ Deletion verified - user no longer exists

==========================================
✓ All tests completed!
==========================================
```

**Troubleshooting:**
- If tests fail with "Could not get user_id", check API is running (`http://localhost/tcexam/admin/code/tce_api.php`)
- If database errors appear, verify TCExam database connection in `shared/config/tce_db_config.php`
- If jq not installed, script will output raw JSON but tests still work

---
