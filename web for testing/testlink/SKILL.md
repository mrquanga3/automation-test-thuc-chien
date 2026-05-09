# TestLink Sidebar Menu Submenu Highlighting

## Problem
Submenu items in the sidebar navigation are not visually highlighted when their respective pages are active, making it unclear which submenu section the user is currently viewing.

## Solution Overview
Implement a submenu highlighting system by:
1. Adding `activeSubmenu` array assignments in PHP page files
2. Updating the template to apply CSS class bindings
3. Ensuring navigation data is properly merged from `initUserEnv()`

## Step-by-Step Implementation Guide

### Step 1: Identify the Page and Menu Item
- Locate the menu item in `gui/templates/dashio/aside.tpl`
- Identify the URI key used (e.g., `events`, `projectView`, `metrics_dashboard`)
- Find the corresponding PHP file that handles that page

Example:
```html
{if $gui->grants->event_viewer == "yes"}
  <li><a id="events" href="{$gui->uri->events}">{$labels.event_viewer}</a></li>
{/if}
```
- Menu item: Event Viewer
- URI key: `events`
- PHP file: `lib/events/eventviewer.php`

### Step 2: Add PHP-Side Setup

#### Option A: For pages that already call `initUserEnv()`
If the page already has `initUserEnv()` call (most common):

```php
list($add2args,$gui) = initUserEnv($dbHandler,$args);
$gui->activeMenu['system'] = 'active';  // Set main menu as active
$gui->activeSubmenu['submenu_key'] = 'active';  // Add this line
```

Replace `'system'` with the appropriate main menu key (`'system'`, `'projects'`, etc.)
Replace `'submenu_key'` with the URI key from aside.tpl

#### Option B: For pages that don't call `initUserEnv()` yet
Add the call and merge data:

```php
// Before template rendering
list($navArgs, $navGui) = initUserEnv($db, $args, 
  array('caller' => basename(__FILE__)));
$gui = initializeGui($db,$args);

// Merge navigation data
$gui->uri = $navGui->uri;
$gui->showMenu = $navGui->showMenu;
$gui->grants = $navGui->grants;
$gui->activeMenu = $navGui->activeMenu;
$gui->access = $navGui->access;
$gui->countPlans = $navGui->countPlans;

// Set active menu items
$gui->activeMenu['projects'] = 'active';
$gui->activeSubmenu['submenu_key'] = 'active';
```

### Step 3: Update Template (aside.tpl)

Add class binding to the submenu `<li>` tag:

**Before:**
```html
<li><a href="{$gui->uri->events}">{$labels.event_viewer}</a></li>
```

**After:**
```html
<li class="{$gui->activeSubmenu.events}"><a href="{$gui->uri->events}">{$labels.event_viewer}</a></li>
```

The class binding uses the submenu key from the URI.

### Step 4: Verify Template Includes Sidebar

Ensure the page template includes the sidebar and hamburger button:

```smarty
{include file="inc_head.tpl" openHead="yes"}

</head>
<body style="background-color: #eaeaea">
<div style="position: fixed; top: 0; left: 0; z-index: 100; padding: 10px;">
  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="{$labels.toggle_navigation}" 
       style="cursor: pointer; color: white; font-size: 20px;"></div>
</div>
{include file="aside.tpl"}
<div id="main-content">
  <!-- page content here -->
</div>
{include file="supportJS.inc.tpl"}
</body>
</html>
```

### Step 5: Add Required Language Labels

Ensure `toggle_navigation` and `reload_main_view` are included in the `lang_get` call:

```smarty
{lang_get var="labels" 
          s='event_viewer,...,toggle_navigation,reload_main_view'}
```

## Common Menu Structures

### System Menu Items
- `events` → `lib/events/eventviewer.php`
- `user_mgmt` → `lib/usermanagement/usersView.php`
- `cfieldsView` → `lib/cfields/cfieldsView.php`
- `issueTrackerView` → `lib/issuetrackers/issueTrackerView.php`
- `codeTrackerView` → `lib/codetrackers/codeTrackerView.php`

Set main menu: `$gui->activeMenu['system'] = 'active';`

### Projects Menu Items
- `projectView` → `lib/project/projectView.php`
- `usersAssign` → `lib/usermanagement/usersAssign.php`
- `cfAssignment` → `lib/cfields/cfieldsTprojectAssign.php`
- `keywordsView` → `lib/keywords/keywordsView.php`
- `platformsView` → `lib/platforms/platformsView.php`
- `metrics_dashboard` → `lib/results/metricsDashboard.php`

Set main menu: `$gui->activeMenu['projects'] = 'active';`

## Testing Approach

1. **Navigate to the page directly:**
   - Open browser and go to the PHP file URL
   - E.g., `http://localhost/testlink/lib/events/eventviewer.php`

2. **Check sidebar visibility:**
   - Click hamburger button at top-left
   - Verify sidebar menu items appear with correct hierarchy

3. **Verify active highlighting:**
   - Use browser developer tools to inspect the submenu `<li>` element
   - Check that it has `class="active"`
   - Verify the text color changes to cyan (#4ECDC4)

4. **Test on different pages:**
   - Navigate to different menu items
   - Verify only the current page's submenu item is highlighted
   - Verify main menu section remains highlighted

## CSS Styling Reference

The active submenu styling is handled by existing CSS:

```css
ul.sidebar-menu li ul.sub li.active a { 
  color: #4ECDC4;  /* Cyan color for active submenu items */
}
```

This rule is already defined in the Dashio theme, so once the `active` class is applied, the styling is automatic.

## Debugging Tips

### Issue: Sidebar menu items not showing
**Cause:** Navigation data not merged properly
**Solution:** Verify that `initUserEnv()` is called and data is merged into `$gui`:
```php
$gui->uri = $navGui->uri;
$gui->showMenu = $navGui->showMenu;
$gui->grants = $navGui->grants;
```

### Issue: Active class not applied
**Cause:** `activeSubmenu` array not set in PHP or submenu key mismatch
**Solution:** 
- Verify submenu key matches the URI key in aside.tpl
- Check that `$gui->activeSubmenu['key']` is set before template rendering

### Issue: Sidebar not showing on page load
**Cause:** Template doesn't include `aside.tpl`
**Solution:** Add the following after `<body>` tag:
```smarty
{include file="aside.tpl"}
<div id="main-content">
```

### Issue: Hamburger button doesn't work
**Cause:** Missing JavaScript or incorrect HTML structure
**Solution:** 
- Ensure `supportJS.inc.tpl` is included
- Verify hamburger button has `fa-bars` class
- Verify `#sidebar` element exists

## Files Modified in Last Implementation

1. **PHP Files** (added activeSubmenu assignments):
   - `lib/events/eventviewer.php`
   - `lib/usermanagement/usersView.php`
   - `lib/cfields/cfieldsView.php`
   - `lib/issuetrackers/issueTrackerView.php`
   - `lib/codetrackers/codeTrackerView.php`
   - `lib/project/projectView.php`
   - `lib/usermanagement/usersAssign.php`
   - `lib/cfields/cfieldsTprojectAssign.php`
   - `lib/keywords/keywordsView.php`
   - `lib/platforms/platformsView.php`
   - `lib/results/metricsDashboard.php`

2. **Template Files**:
   - `gui/templates/dashio/aside.tpl` (added class bindings for all submenu items)
   - `gui/templates/dashio/events/eventviewer.tpl` (added hamburger + sidebar)
   - `gui/templates/dashio/usermanagement/usersView.tpl` (added hamburger + sidebar)
   - `gui/templates/dashio/usermanagement/usersAssign.tpl` (added hamburger + sidebar)
   - `gui/templates/dashio/results/metricsDashboard.tpl` (added hamburger + sidebar)

## Related Files

- Theme CSS: `gui/templates/dashio/styles/` (handles `.active` class styling)
- Navigation initialization: `lib/general/common.php` (initUserEnv function)
- JavaScript: `gui/templates/dashio/dashio-template/lib/left-bar-scripts.js` (hamburger toggle)
