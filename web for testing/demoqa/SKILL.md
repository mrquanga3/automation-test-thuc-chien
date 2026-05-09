# SKILL.md - HTML Cleanup & Bulk Modification Techniques

A comprehensive guide to the skills and techniques used to fix common issues in the DemoQA project.

## Table of Contents

1. [Socket.io 404 Error Fix](#socketio-404-error-fix)
2. [Bulk HTML Regex Patterns](#bulk-html-regex-patterns)
3. [PowerShell Scripting for Bulk Changes](#powershell-scripting-for-bulk-changes)
4. [Common Pitfalls & Solutions](#common-pitfalls--solutions)
5. [Advanced Techniques](#advanced-techniques)

---

## Socket.io 404 Error Fix

### Problem Analysis

**Symptoms:**
- Browser console shows multiple 404 errors
- Requests like: `GET http://localhost/socket.io/2FIO=4transport=polling&t=...` fail
- Pages load but with console errors

**Root Cause:**
The mirrored HTML files contain socket.io script references that point to non-existent files:
```html
<script src="socket.io/socket.io.min.js"></script>
<script>
    window.onload = function () {
        const socket = io();
        socket.emit('pageChange', { page: window.location.href });
    }
</script>
```

### Solution: Remove Socket.io Scripts

The fix requires removing:
1. The script tag: `<script src="*.socket.io/socket.io.min.js"></script>`
2. The initialization code: `<script>window.onload = function() { ... }</script>`

### Implementation

#### Step 1: Identify All Path Formats

Socket.io paths vary by directory depth:

| Directory Depth | Path Format | Example |
|---|---|---|
| Root level | `socket.io/` | `<script src="socket.io/socket.io.min.js">` |
| 1 level down | `../socket.io/` | Used in `/test-cases/login.html` |
| 2 levels down | `../../socket.io/` | Used in `/bookstore/books/` |
| Absolute root | `/socket.io/` | Fallback format |
| Absolute HTTPS | `https://practice.expandtesting.com/socket.io/` | Full URL variant |

#### Step 2: Create PowerShell Script

```powershell
$rootPath = Get-Location
Get-ChildItem -Path $rootPath -Filter "*.html" -Recurse | ForEach-Object {
    $content = Get-Content -Path $_.FullName -Raw

    # Remove all socket.io script blocks with ANY path format
    # Pattern 1: Relative paths (., .., ../.., etc.)
    $content = $content -replace '<script src="[.\/]*socket\.io/socket\.io\.min\.js"><\/script>[\s\S]*?<\/script>', ''
    
    # Pattern 2: Absolute URLs (http://, https://)
    $content = $content -replace '<script src="(?:https?:)?(?:\/\/)?[a-z0-9\.:]*\/socket\.io/socket\.io\.min\.js"><\/script>[\s\S]*?<\/script>', ''

    Set-Content -Path $_.FullName -Value $content -Force
}
```

#### Step 3: Execute & Verify

```powershell
# Run script
& .\remove-socketio-all.ps1

# Verify removal
grep -r "socket\.io/socket\.io\.min\.js" .
# Should return: Found 0 total occurrences
```

### Verification Checklist

- [ ] Browser console shows no socket.io 404 errors
- [ ] Network tab shows no failed `/socket.io/` requests
- [ ] Page functionality unaffected
- [ ] Load time improved (fewer failed requests)

---

## Bulk HTML Regex Patterns

### Key Regex Concepts

#### 1. Matching Multi-line Content

**Problem:** Default regex `.` doesn't match newlines.

**Solution:** Use `[\s\S]` to match any character including newlines.

```powershell
# ❌ Wrong - stops at newline
'<script src="socket.io/socket.io.min.js"></script><script>...'
$content = $content -replace '<script src=".*"><\/script>[\s\S]*?<\/script>', ''

# ✅ Correct - matches across lines
$content = $content -replace '<script src="[.\/]*socket\.io.*?<\/script>[\s\S]*?<\/script>', ''
```

#### 2. Non-Greedy Matching

**Problem:** `.*` is greedy and matches too much.

**Solution:** Use `*?` for non-greedy matching.

```powershell
# ❌ Greedy - removes from first <div> to LAST </div>
$content = $content -replace '<div>[\s\S]*?</div>', ''

# ✅ Non-greedy - removes only the closest match
$content = $content -replace '<div class="ad-bar">[\s\S]*?</div>', ''
```

#### 3. Escaping Special Characters

**Problem:** Regex special characters (`.`, `[`, `*`, etc.) need escaping.

```powershell
# ❌ Wrong
$content = $content -replace '<script src="socket.io/socket.io.min.js">', ''

# ✅ Correct - escape dots
$content = $content -replace '<script src="socket\.io/socket\.io\.min\.js">', ''
```

#### 4. Character Classes

```powershell
# Match any character in brackets
[abc]      # a, b, or c
[a-z]      # lowercase letters
[0-9]      # digits
[.\-]      # literal . or -
[a-zA-Z0-9] # alphanumeric

# Negated character class
[^a-z]     # anything NOT lowercase
```

#### 5. Quantifiers

```powershell
*      # 0 or more
+      # 1 or more
?      # 0 or 1
{n}    # exactly n
{n,}   # n or more
{n,m}  # between n and m

*?     # non-greedy (0 or more, match shortest)
+?     # non-greedy (1 or more, match shortest)
```

### Common HTML Patterns

#### Pattern 1: Remove Script Tags

```powershell
# Remove specific script by src
$content = $content -replace '<script src="path/to/script\.js"><\/script>', ''

# Remove all scripts between two tags
$content = $content -replace '<script>[\s\S]*?<\/script>', ''
```

#### Pattern 2: Remove Specific Divs

```powershell
# Remove ad-bar by class
$content = $content -replace '<div class="ad-bar">[\s\S]*?<\/div>', ''

# Remove with attributes (non-greedy on attributes)
$content = $content -replace '<div[^>]*class="ad-bar"[^>]*>[\s\S]*?<\/div>', ''
```

#### Pattern 3: Remove Google AdSense

```powershell
# Remove ins tag
$content = $content -replace '<ins class="adsbygoogle"[^>]*><\/ins>', ''

# Remove CSS rules
$content = $content -replace 'ins\.adsbygoogle\[data-ad-status="unfilled"\]\s*\{[^}]*\}', ''

# Remove push scripts
$content = $content -replace '\(adsbygoogle = window\.adsbygoogle \|\| \[\]\)\.push\(\{[^}]*\}\);', ''
```

#### Pattern 4: Remove Comments

```powershell
# Remove HTML comments
$content = $content -replace '<!--[\s\S]*?-->', ''
```

---

## PowerShell Scripting for Bulk Changes

### Template: Basic Bulk Replace

```powershell
# Set working directory
$rootPath = "D:\path\to\demoqa"
cd $rootPath

# Process all HTML files recursively
Get-ChildItem -Path $rootPath -Filter "*.html" -Recurse | ForEach-Object {
    # Read file content
    $content = Get-Content -Path $_.FullName -Raw
    
    # Apply regex replacements
    $content = $content -replace 'PATTERN1', 'REPLACEMENT1'
    $content = $content -replace 'PATTERN2', 'REPLACEMENT2'
    
    # Write back to file
    Set-Content -Path $_.FullName -Value $content -Force
}

Write-Host "✅ Bulk replacement complete"
```

### Template: With Verification

```powershell
$rootPath = "D:\path\to\demoqa"
$fileCount = 0
$patternCount = 0

Get-ChildItem -Path $rootPath -Filter "*.html" -Recurse | ForEach-Object {
    $content = Get-Content -Path $_.FullName -Raw
    $before = $content
    
    # Apply replacements
    $content = $content -replace 'PATTERN', ''
    
    # Check if file was modified
    if ($before -ne $content) {
        $fileCount++
        Set-Content -Path $_.FullName -Value $content -Force
    }
    
    # Count occurrences
    if ($before -match 'PATTERN') {
        $patternCount += ([regex]::Matches($before, 'PATTERN')).Count
    }
}

Write-Host "✅ Modified $fileCount files"
Write-Host "✅ Removed $patternCount occurrences"
```

### Template: Dry Run (Preview Changes)

```powershell
$rootPath = "D:\path\to\demoqa"
$matchCount = 0

Get-ChildItem -Path $rootPath -Filter "*.html" -Recurse | ForEach-Object {
    $content = Get-Content -Path $_.FullName -Raw
    
    if ($content -match 'PATTERN') {
        $matchCount += ([regex]::Matches($content, 'PATTERN')).Count
        Write-Host "Found in: $($_.FullName)"
    }
}

Write-Host "Total matches: $matchCount"
Write-Host "Would modify: $(($matchCount -gt 0) ? 'Yes' : 'No')"
```

### Best Practices

1. **Always backup first:**
   ```powershell
   Copy-Item -Path "demoqa" -Destination "demoqa_backup" -Recurse
   ```

2. **Test on single file first:**
   ```powershell
   $testFile = Get-ChildItem -Path "demoqa" -Filter "upload.html" -Recurse | Select-Object -First 1
   $content = Get-Content -Path $testFile.FullName -Raw
   $content = $content -replace 'PATTERN', ''
   # Verify output manually before applying to all
   ```

3. **Use version control:**
   ```powershell
   git add .
   git commit -m "Remove socket.io from all HTML files"
   ```

4. **Log changes:**
   ```powershell
   $logFile = "cleanup.log"
   "Modified files:" | Out-File -FilePath $logFile
   Get-ChildItem -Path $rootPath -Filter "*.html" -Recurse | Where-Object { ... } | 
       ForEach-Object { $_.FullName } | Out-File -FilePath $logFile -Append
   ```

---

## Common Pitfalls & Solutions

### Pitfall 1: Greedy Regex Removes Too Much

**Problem:**
```powershell
# This removes from first <div> to LAST </div> on the page
$content = $content -replace '<div>[\s\S]*</div>', ''
```

**Result:** Header, navigation, content - everything between first and last div is gone!

**Solution:** Use non-greedy matching and be specific:
```powershell
# Only remove ad-bars
$content = $content -replace '<div class="ad-bar">[\s\S]*?</div>', ''

# Or use lookahead to ensure we don't match structural divs
$content = $content -replace '<div class="ad-bar">[\s\S]*?</div>\s*(?=</main>)', ''
```

### Pitfall 2: Missing Path Variants

**Problem:**
```powershell
# Only matches socket.io/ - misses ../ and /socket.io/
$content = $content -replace '<script src="socket\.io/socket\.io\.min\.js">[\s\S]*?</script>', ''
```

**Solution:** Test across all directory levels first:
```powershell
# Find all variants
grep -r 'socket\.io' . | grep -o 'src="[^"]*socket\.io' | sort -u

# Then match all variants
$content = $content -replace '<script src="[.\/]*socket\.io/socket\.io\.min\.js">[\s\S]*?</script>', ''
$content = $content -replace '<script src="https?://[^/]*/socket\.io/socket\.io\.min\.js">[\s\S]*?</script>', ''
```

### Pitfall 3: Escaping Issues in PowerShell

**Problem:**
```powershell
# Backslash in regex conflicts with PowerShell escaping
$content = $content -replace '<script src="\.\.\/socket\.io', '' # Wrong!
```

**Solution:** Use raw string literals:
```powershell
# Use @' '@ for raw strings
$pattern = @'<script src="[.\/]*socket\.io/socket\.io\.min\.js"><\/script>[\s\S]*?<\/script>'@
$content = $content -replace $pattern, ''
```

### Pitfall 4: Regex Timeout on Large Files

**Problem:**
```powershell
# Complex regex on 600+ line files can be slow
$content = $content -replace '<script[^>]*>[\s\S]*?</script>', ''
```

**Solution:** Simplify or split into multiple passes:
```powershell
# Pass 1: Remove specific script tags
$content = $content -replace '<script src="socket\.io[^>]*>[\s\S]*?</script>', ''

# Pass 2: Remove orphaned <script> tags
$content = $content -replace '<script>\s*window\.onload\s*=[\s\S]*?</script>', ''
```

---

## Advanced Techniques

### Technique 1: Lookahead Assertions

Use lookahead to match patterns without consuming the lookahead text.

```powershell
# Remove ad-bar but only if followed by specific structure
# (?=...) is positive lookahead
$content = $content -replace '<div class="ad-bar">[\s\S]*?</div>\s*(?=\n\s*<header)', ''

# Negative lookahead (?!...) - match if NOT followed by
$content = $content -replace '<script[^>]*>(?!window\.location)[^<]*</script>', ''
```

### Technique 2: Lookbehind Assertions

Match patterns that are preceded by specific text (less common in HTML).

```powershell
# (?<=...) is positive lookbehind
# Remove </div> only if preceded by specific closing tag
$content = $content -replace '(?<=</div>)\s*</div>', ''
```

### Technique 3: Conditional Replacement

```powershell
Get-ChildItem -Path $rootPath -Filter "*.html" -Recurse | ForEach-Object {
    $content = Get-Content -Path $_.FullName -Raw
    
    # Only remove ads from certain directories
    if ($_.FullName -match "bookstore") {
        $content = $content -replace '<ins class="adsbygoogle"[^>]*><\/ins>', ''
    }
    
    Set-Content -Path $_.FullName -Value $content -Force
}
```

### Technique 4: Multi-line Replacements with Placeholders

```powershell
# For complex replacements, use a two-step approach
$pattern = 'PLACEHOLDER_SOCKET_IO_SCRIPT'

# Step 1: Replace with placeholder
$content = $content -replace '<script src="[.\/]*socket\.io[^>]*>[\s\S]*?</script>', $pattern

# Step 2: Verify placeholder is in right place
if ($content -match $pattern) {
    Write-Host "Safe to remove placeholder"
    $content = $content -replace $pattern, ''
}
```

### Technique 5: Preserve Specific Elements During Bulk Cleanup

```powershell
# Remove all <div class="ad"> EXCEPT those with id="important-div"
Get-ChildItem -Path $rootPath -Filter "*.html" -Recurse | ForEach-Object {
    $content = Get-Content -Path $_.FullName -Raw
    
    # Match ad divs that DON'T have id="important-div"
    $content = $content -replace '<div class="ad"(?!id="important-div")>[\s\S]*?</div>', ''
    
    Set-Content -Path $_.FullName -Value $content -Force
}
```

---

## Practical Examples

### Example 1: Complete Socket.io Cleanup

See [Socket.io 404 Error Fix](#socketio-404-error-fix) above.

### Example 2: Remove Multiple Ad Variants

```powershell
$rootPath = "D:\automation-test-thuc-chien\web for testing\demoqa"

Get-ChildItem -Path $rootPath -Filter "*.html" -Recurse | ForEach-Object {
    $content = Get-Content -Path $_.FullName -Raw
    
    # Remove Google AdSense ins tags
    $content = $content -replace '<ins class="adsbygoogle"[^>]*><\/ins>', ''
    
    # Remove ad push script
    $content = $content -replace '\(adsbygoogle = window\.adsbygoogle \|\| \[\]\)\.push\({[^}]*}\);?', ''
    
    # Remove ad-bar div wrapper
    $content = $content -replace '<div class="ad-bar">[\s\S]*?</div>', ''
    
    # Remove associated CSS rules
    $content = $content -replace 'ins\.adsbygoogle\[data-ad-status="unfilled"\]\s*\{[^}]*\}', ''
    
    Set-Content -Path $_.FullName -Value $content -Force
}
```

### Example 3: Safe Header Removal

When removing elements, use lookahead to prevent removing structural elements:

```powershell
$content = $content -replace '<div class="ad-bar">[\s\S]*?</div>\s*(?=\n\s*<header)', ''
# or
$content = $content -replace '<div class="ad-bar">[\s\S]*?</div>\s*(?=<\/div>\s*<\/main>)', ''
```

---

## Key Learnings

✅ **Always test before applying to all files**
- Use grep/Select-String to find patterns first
- Test on one file manually
- Then run on all files

✅ **Use non-greedy matching for HTML**
- `[\s\S]*?` not `[\s\S]*`
- Match from opening to closing tag carefully

✅ **Handle path variants**
- Files at different depths have different relative paths
- Test across the entire directory tree

✅ **Verify after cleanup**
- Use grep to confirm removals
- Check browser console for errors
- Test page functionality

✅ **Keep backups**
- Version control (git) is your safety net
- Always `git commit` before bulk operations

---

**Last Updated:** 2026-05-09
**Techniques Documented:** 15+
**Files Successfully Cleaned:** 167+
