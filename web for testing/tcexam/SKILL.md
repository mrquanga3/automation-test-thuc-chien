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
