#!/usr/bin/env python3
import os
import re
from pathlib import Path
from html.parser import HTMLParser

# Configuration
BASE_DIR = r"d:\automation-test-thuc-chien\web for testing\demoqa2\the-internet.herokuapp.com"
TEMPLATE_FILE = os.path.join(BASE_DIR, "template.html")

# Menu structure mapping
MENU_STRUCTURE = {
    'checkboxes': ('Form & Input', 'CURRENT_MENU_FORM'),
    'dropdown': ('Form & Input', 'CURRENT_MENU_FORM'),
    'add_remove_elements': ('Form & Input', 'CURRENT_MENU_FORM'),
    'inputs': ('Form & Input', 'CURRENT_MENU_FORM'),
    'key_presses': ('Form & Input', 'CURRENT_MENU_FORM'),
    'upload': ('Form & Input', 'CURRENT_MENU_FORM'),

    'basic_auth': ('Authentication', 'CURRENT_MENU_AUTH'),
    'digest_auth': ('Authentication', 'CURRENT_MENU_AUTH'),
    'login': ('Authentication', 'CURRENT_MENU_AUTH'),
    'forgot_password': ('Authentication', 'CURRENT_MENU_AUTH'),

    'drag_and_drop': ('Interactions', 'CURRENT_MENU_INTERACTIONS'),
    'hovers': ('Interactions', 'CURRENT_MENU_INTERACTIONS'),
    'context_menu': ('Interactions', 'CURRENT_MENU_INTERACTIONS'),
    'floating_menu': ('Interactions', 'CURRENT_MENU_INTERACTIONS'),

    'dynamic_content': ('Dynamic Content', 'CURRENT_MENU_DYNAMIC'),
    'dynamic_controls': ('Dynamic Content', 'CURRENT_MENU_DYNAMIC'),
    'dynamic_loading': ('Dynamic Content', 'CURRENT_MENU_DYNAMIC'),
    'disappearing_elements': ('Dynamic Content', 'CURRENT_MENU_DYNAMIC'),
    'entry_ad': ('Dynamic Content', 'CURRENT_MENU_DYNAMIC'),
    'exit_intent': ('Dynamic Content', 'CURRENT_MENU_DYNAMIC'),
    'infinite_scroll': ('Dynamic Content', 'CURRENT_MENU_DYNAMIC'),

    'challenging_dom': ('Advanced DOM', 'CURRENT_MENU_ADVANCED'),
    'large': ('Advanced DOM', 'CURRENT_MENU_ADVANCED'),
    'shifting_content': ('Advanced DOM', 'CURRENT_MENU_ADVANCED'),
    'shadowdom': ('Advanced DOM', 'CURRENT_MENU_ADVANCED'),

    'javascript_alerts': ('JavaScript', 'CURRENT_MENU_JS'),
    'javascript_error': ('JavaScript', 'CURRENT_MENU_JS'),
    'jqueryui': ('JavaScript', 'CURRENT_MENU_JS'),
    'tinymce': ('JavaScript', 'CURRENT_MENU_JS'),

    'frames': ('Windows & Frames', 'CURRENT_MENU_WINDOWS'),
    'nested_frames': ('Windows & Frames', 'CURRENT_MENU_WINDOWS'),
    'windows': ('Windows & Frames', 'CURRENT_MENU_WINDOWS'),

    'download': ('Files', 'CURRENT_MENU_FILES'),
    'download_secure': ('Files', 'CURRENT_MENU_FILES'),

    'abtest': ('Testing Patterns', 'CURRENT_MENU_TESTING'),
    'broken_images': ('Testing Patterns', 'CURRENT_MENU_TESTING'),
    'geolocation': ('Testing Patterns', 'CURRENT_MENU_TESTING'),
    'horizontal_slider': ('Testing Patterns', 'CURRENT_MENU_TESTING'),
    'notification_message_rendered': ('Testing Patterns', 'CURRENT_MENU_TESTING'),
    'notification': ('Testing Patterns', 'CURRENT_MENU_TESTING'),
    'redirector': ('Testing Patterns', 'CURRENT_MENU_TESTING'),
    'slow': ('Testing Patterns', 'CURRENT_MENU_TESTING'),
    'status_codes': ('Testing Patterns', 'CURRENT_MENU_TESTING'),
    'tables': ('Testing Patterns', 'CURRENT_MENU_TESTING'),
    'typos': ('Testing Patterns', 'CURRENT_MENU_TESTING'),
}

def extract_content(html_file):
    """Extract page content from old HTML file"""
    try:
        with open(html_file, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()

        # Try to extract from <div class="example">
        match = re.search(r'<div[^>]*class="example"[^>]*>.*?</div>\s*(?:</br>)?', content, re.DOTALL)
        if match:
            return match.group(0)

        # Try to extract from main content div
        match = re.search(r'<div[^>]*id="content"[^>]*>.*?</div>\s*</div>', content, re.DOTALL)
        if match:
            return match.group(0)

        # Fallback: get everything from <body>
        match = re.search(r'<body[^>]*>(.*?)</body>', content, re.DOTALL)
        if match:
            return match.group(1).strip()

        return "<p>Content not found</p>"
    except Exception as e:
        print(f"Error extracting content from {html_file}: {e}")
        return "<p>Error loading content</p>"

def get_page_key(filename):
    """Get the menu key from filename"""
    # Remove .html extension and handle special cases
    key = filename.replace('.html', '').replace('_', '_').lower()

    # Handle index.html in subdirectories
    if 'index' in key:
        # Get parent directory name
        parts = key.split('/')
        if len(parts) > 1:
            key = parts[0]

    return key

def get_page_title(filename):
    """Generate page title from filename"""
    # Handle special naming
    title_map = {
        'add_remove_elements': 'Add/Remove Elements',
        'digest_auth': 'Digest Authentication',
        'javascript_alerts': 'JavaScript Alerts',
        'javascript_error': 'JavaScript onload Error',
        'jqueryui': 'JQuery UI Menus',
        'tinymce': 'WYSIWYG Editor',
        'challenging_dom': 'Challenging DOM',
        'disappearing_elements': 'Disappearing Elements',
        'dynamic_content': 'Dynamic Content',
        'dynamic_controls': 'Dynamic Controls',
        'dynamic_loading': 'Dynamic Loading',
        'download_secure': 'Secure File Download',
        'entry_ad': 'Entry Ad',
        'exit_intent': 'Exit Intent',
        'floating_menu': 'Floating Menu',
        'drag_and_drop': 'Drag and Drop',
        'forgot_password': 'Forgot Password',
        'horizontal_slider': 'Horizontal Slider',
        'infinite_scroll': 'Infinite Scroll',
        'large': 'Large & Deep DOM',
        'nested_frames': 'Nested Frames',
        'notification_message_rendered': 'Notification Messages',
        'redirector': 'Redirect Link',
        'shifting_content': 'Shifting Content',
        'status_codes': 'Status Codes',
        'sortable_data_tables': 'Sortable Data Tables',
        'abtest': 'A/B Testing',
        'basic_auth': 'Basic Auth',
        'broken_images': 'Broken Images',
        'context_menu': 'Context Menu',
        'shadowdom': 'Shadow DOM',
        'slow': 'Slow Resources',
        'windows': 'Multiple Windows',
        'form_authentication': 'Form Authentication',
        'javascript_on_load_error': 'JavaScript onload Error',
        'key_presses': 'Key Presses',
    }

    key = filename.replace('.html', '').replace('_', '_').lower()
    if 'index' in key:
        parts = key.split('/')
        if len(parts) > 1:
            key = parts[0]

    return title_map.get(key, key.replace('_', ' ').title())

def convert_file(html_file, page_key):
    """Convert a single HTML file to use template"""
    if html_file.endswith('template.html') or html_file.endswith('index.html'):
        return False

    try:
        with open(TEMPLATE_FILE, 'r', encoding='utf-8') as f:
            template = f.read()

        # Get page info
        page_title = get_page_title(os.path.basename(html_file))

        # Extract content from old file
        content = extract_content(html_file)

        # Replace placeholders in template
        output = template.replace('PAGE_TITLE', page_title)
        output = output.replace('<!-- PAGE CONTENT GOES HERE -->', content)

        # Find menu info for this page
        if page_key in MENU_STRUCTURE:
            menu_name, menu_marker = MENU_STRUCTURE[page_key]

            # Add class="active" to current menu item
            # This is a simple replacement - find the link text and add class
            output = re.sub(
                f'(<a href="{os.path.basename(html_file)}"[^>]*)>',
                r'\1 class="active">',
                output
            )

            # Add class="open" to current menu group
            # Find and replace the menu-items div for this group
            menu_class_pattern = menu_marker
            output = output.replace(
                '<div class="menu-items">',
                '<div class="menu-items open">',
                1
            )

        # Write converted file
        with open(html_file, 'w', encoding='utf-8') as f:
            f.write(output)

        print(f"✓ Converted: {os.path.basename(html_file)}")
        return True

    except Exception as e:
        print(f"✗ Error converting {html_file}: {e}")
        return False

def main():
    """Main conversion function"""
    print(f"Converting pages in {BASE_DIR}...")
    print()

    # Get all HTML files
    html_files = []
    for root, dirs, files in os.walk(BASE_DIR):
        for file in files:
            if file.endswith('.html') and file not in ['template.html', 'index.html']:
                html_files.append(os.path.join(root, file))

    # Convert each file
    converted_count = 0
    for html_file in sorted(html_files):
        page_key = get_page_key(os.path.relpath(html_file, BASE_DIR))
        if convert_file(html_file, page_key):
            converted_count += 1

    print()
    print(f"✅ Converted {converted_count} pages")

if __name__ == '__main__':
    main()
