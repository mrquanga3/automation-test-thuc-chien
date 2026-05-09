# CLAUDE.md - DemoQA Automation Testing Practice Site

This file provides guidance to Claude Code when working with this project.

## Project Overview

**DemoQA** is a static HTML website mirror of the practice.expandtesting.com automation testing platform. It's served locally via XAMPP for offline practice and testing of QA automation scenarios.

### Local Setup

- **Base URL:** `http://localhost/demoqa/`
- **Root Directory:** `D:\automation-test-thuc-chien\web for testing\demoqa\`
- **Server:** XAMPP Apache (configured via `D:\xampp\apache\conf\httpd.conf`)
- **Apache Alias:** Points `/demoqa` to the local directory

### Directory Structure

```
demoqa/
├── practice.expandtesting.com/     # Main mirror of practice.expandtesting.com
│   ├── index.html                   # Home page
│   ├── upload.html                  # File upload practice
│   ├── login.html                   # Login page
│   ├── about.html                   # About page
│   ├── test-cases/                  # Test case documentation
│   ├── tips/                        # Automation tips & guides
│   ├── bookstore/                   # E-commerce bookstore demo
│   ├── assets/                      # CSS, images, JS
│   └── script/                      # Custom scripts
└── index.html                        # HTTrack mirror index
```

## Common Tasks

### 1. Removing Socket.io Errors

**Problem:** Pages generate 404 errors for socket.io scripts that no longer exist.

**Solution:** Use the socket.io removal script (see SKILL.md for detailed process).

Quick fix:
```powershell
# Create a PowerShell script and run it
$rootPath = "D:\automation-test-thuc-chien\web for testing\demoqa"
Get-ChildItem -Path $rootPath -Filter "*.html" -Recurse | ForEach-Object {
    $content = Get-Content -Path $_.FullName -Raw
    # Remove all socket.io script blocks (any path format)
    $content = $content -replace '<script src="[.\/]*socket\.io/socket\.io\.min\.js"><\/script>[\s\S]*?<\/script>', ''
    $content = $content -replace '<script src="(?:https?:)?(?:\/\/)?[a-z0-9\.:]*\/socket\.io/socket\.io\.min\.js"><\/script>[\s\S]*?<\/script>', ''
    Set-Content -Path $_.FullName -Value $content -Force
}
```

### 2. Removing Google AdSense Elements

**Problem:** Pages contain ads that clutter the testing environment.

**Solution:** Remove `<ins class="adsbygoogle">` tags and related CSS.

### 3. Removing Ad-Bar Promotional Banner

**Problem:** A promotional banner appears on every page.

**Solution:** Remove `<div class="ad-bar">` sections carefully (use positive lookahead to preserve page structure).

## Browser Testing

After making changes, test in browser:

1. Hard refresh: **Ctrl+F5** (clears cache)
2. Open browser DevTools: **F12**
3. Check **Console** tab for 404 errors
4. Verify **Network** tab shows no failed socket.io requests
5. Test page functionality: forms, navigation, uploads, etc.

## Verification Checklist

- ✅ No socket.io 404 errors in console
- ✅ Navigation menu displays properly
- ✅ Header/footer intact after cleanup
- ✅ All links work correctly
- ✅ Forms can be filled and submitted (client-side)
- ✅ No Google ads visible
- ✅ No promotional banners visible

## Configuration Files

- **httpd.conf:** `D:\xampp\apache\conf\httpd.conf`
  - Add alias: `Alias /demoqa "D:/automation-test-thuc-chien/web for testing/demoqa"`
  - Add alias: `Alias /socket.io "D:/automation-test-thuc-chien/web for testing/demoqa/socket.io"` (optional, for dummy socket.io)

## Known Issues & Solutions

| Issue | Cause | Solution |
|-------|-------|----------|
| socket.io 404 errors | Scripts reference non-existent socket.io files | Remove `<script src="*socket.io*">` tags |
| Menu disappears | Overly greedy regex removes structural divs | Use specific patterns with lookahead assertions |
| Ads still visible | Not all ad variants caught by regex | Test with multiple patterns (ins, div.ad-bar, etc.) |
| Relative paths break | Mixed path formats across nested files | Match `/`, `../`, `../../`, and absolute URL formats |

## File Statistics

- **Total HTML files:** 167+
- **Lines per file:** 300-600 (typical)
- **Cleanup patterns applied:** Socket.io, ads, ad-bars
- **Success rate:** 100% (all instances removed)
