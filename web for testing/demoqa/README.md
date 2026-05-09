# DemoQA - Offline Automation Testing Practice Platform

A local mirror of [practice.expandtesting.com](https://practice.expandtesting.com) running on XAMPP for offline automation testing practice.

## Overview

DemoQA is a comprehensive web application designed for practicing **UI and API test automation** using popular tools like:
- Selenium
- Cypress
- Playwright
- WebdriverIO
- Postman

## Quick Start

### 1. Start XAMPP
```bash
# Start Apache web server
# Access: http://localhost/demoqa/
```

### 2. Access Pages

| Page | URL | Purpose |
|------|-----|---------|
| Home | `http://localhost/demoqa/` | Navigation hub |
| Login | `http://localhost/demoqa/practice.expandtesting.com/login.html` | Login form practice |
| Upload | `http://localhost/demoqa/practice.expandtesting.com/upload.html` | File upload practice |
| Forms | `http://localhost/demoqa/practice.expandtesting.com/inputs.html` | Form field practice |
| Tables | `http://localhost/demoqa/practice.expandtesting.com/tables.html` | Table navigation practice |
| Dropdowns | `http://localhost/demoqa/practice.expandtesting.com/dropdown.html` | Dropdown practice |

### 3. Test Automation Scenarios

The site includes practice scenarios for:
- ✅ Login with valid/invalid credentials
- ✅ Form filling and validation
- ✅ File uploads with size limits
- ✅ Table sorting and filtering
- ✅ Dynamic content loading
- ✅ AJAX interactions
- ✅ Window handling
- ✅ IFrame interactions
- ✅ Drag and drop
- ✅ Mouse hover actions
- ✅ JavaScript alerts and dialogs
- ✅ Status codes (200, 404, 500)
- ✅ Cookie handling
- ✅ Geolocation
- ✅ And many more...

## Test Case Documentation

Each feature has detailed test cases available at:
```
/test-cases/[feature-name].html
```

Examples:
- `/test-cases/login.html` - Login test cases
- `/test-cases/register.html` - Registration test cases

## Tips & Guides

Automation tips are available at:
```
/tips/[topic-name].html
```

Examples:
- `/tips/css-selector-cheat-sheet.html`
- `/tips/how-to-automate-mfa-authentication.html`
- `/tips/javascript-async-await-playwright-guide.html`

## Bookstore Application

A sample e-commerce application for testing shopping flows:
```
/bookstore/
```

Features:
- Browse books by category
- Add to cart
- Search functionality
- User authentication
- Order simulation

## Technical Details

### Technologies Used
- **Frontend:** HTML5, Bootstrap 5, jQuery
- **Practice Areas:** CSS selectors, XPath, form automation, AJAX, DOM manipulation
- **Test Data:** Predefined test users and scenarios

### Test Credentials

Some pages contain hardcoded test credentials for practice:

| Page | Username | Password | Purpose |
|------|----------|----------|---------|
| Login | `practice` | `SuperSecretPassword!` | Successful login |
| - | Various | Various | Error scenarios |

### File Structure

```
demoqa/
├── practice.expandtesting.com/
│   ├── index.html                    # Home page
│   ├── login.html                    # Login form
│   ├── register.html                 # Registration form
│   ├── upload.html                   # File upload
│   ├── test-cases/                   # Test case documentation
│   ├── tips/                         # Automation tips & guides
│   ├── bookstore/                    # E-commerce demo
│   ├── assets/
│   │   ├── css/                      # Stylesheets
│   │   ├── images/                   # Images & icons
│   │   ├── js/                       # JavaScript files
│   │   └── plugins/                  # jQuery plugins
│   └── script/                       # Custom JavaScript
├── CLAUDE.md                         # Claude Code instructions
├── README.md                         # This file
└── SKILL.md                          # Skills & techniques guide
```

## Maintenance & Updates

### Recent Cleanups (2026-05-09)

The following unwanted elements were removed:
- ✅ Socket.io 404 errors (removed all socket.io script references)
- ✅ Google AdSense ads (removed all `<ins>` tags and ad-related CSS)
- ✅ Promotional ad-bar banner (removed `<div class="ad-bar">` sections)

See [SKILL.md](SKILL.md) for detailed cleanup techniques.

### Affected Files

- **167+ HTML files** cleaned
- **0 socket.io references** remaining
- **0 Google ads** remaining
- **0 ad-bars** remaining

## Browser Compatibility

Tested and working on:
- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari
- ✅ All modern browsers with ES6 support

## Common Scenarios to Practice

### 1. Login Automation
- Navigate to login page
- Enter credentials
- Click login button
- Assert redirect to secure area
- Assert success message

### 2. Form Filling
- Locate form fields
- Fill text inputs
- Select from dropdowns
- Check/uncheck checkboxes
- Click submit button
- Validate error/success messages

### 3. File Upload
- Locate file input
- Upload file
- Verify upload success
- Validate file size constraints

### 4. Table Operations
- Find table rows/cells
- Click table links
- Sort columns
- Filter data
- Paginate results

### 5. Dynamic Content
- Wait for AJAX requests
- Handle loading spinners
- Wait for element visibility
- Handle dynamic IDs/selectors

## Troubleshooting

### Page shows 404 errors in console
**Solution:** Clear browser cache (Ctrl+F5) and refresh.

### Links return 404
**Ensure** you're accessing through `http://localhost/demoqa/` alias, not directly by file path.

### Form submission doesn't work
**Expected:** Form validation happens client-side only. No actual backend submission.

### Navigation menu missing
**Check:** Browser console for JavaScript errors. Verify Apache is running.

## Resources

- **Official Site:** https://practice.expandtesting.com
- **Author:** [Tawfik Nouri](https://www.linkedin.com/in/tawfiknouri/)
- **Contact:** expand.testing@gmail.com
- **GitHub Examples:** https://github.com/HelioGuilherme66/robot_framework_examples

## License & Usage

This is a mirror for **offline practice and learning purposes**. Respect the original site's terms and the author's work.

## Contributing

For improvements and updates to this local mirror, see [SKILL.md](SKILL.md) for bulk HTML modification techniques.

---

**Last Updated:** 2026-05-09
**Total Files:** 167+ HTML pages
**Status:** ✅ All cleanups complete - Ready for testing
