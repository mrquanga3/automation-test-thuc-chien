#!/usr/bin/env python3
import os
import re
from pathlib import Path

BASE_DIR = r"d:\automation-test-thuc-chien\web for testing\demoqa2\the-internet.herokuapp.com"
TEMPLATE_FILE = os.path.join(BASE_DIR, "template.html")

# Menu structure
MENU_STRUCTURE = {
    'checkboxes': ('Form & Input', 'open'),
    'dropdown': ('Form & Input', 'open'),
    'add_remove_elements': ('Form & Input', 'open'),
    'inputs': ('Form & Input', 'open'),
    'key_presses': ('Form & Input', 'open'),
    'upload': ('Form & Input', 'open'),
    'basic_auth': ('Authentication', 'open'),
    'digest_auth': ('Authentication', 'open'),
    'login': ('Authentication', 'open'),
    'forgot_password': ('Authentication', 'open'),
    'drag_and_drop': ('Interactions', 'open'),
    'hovers': ('Interactions', 'open'),
    'context_menu': ('Interactions', 'open'),
    'floating_menu': ('Interactions', 'open'),
    'dynamic_content': ('Dynamic Content', 'open'),
    'dynamic_controls': ('Dynamic Content', 'open'),
    'dynamic_loading': ('Dynamic Content', 'open'),
    'disappearing_elements': ('Dynamic Content', 'open'),
    'entry_ad': ('Dynamic Content', 'open'),
    'exit_intent': ('Dynamic Content', 'open'),
    'infinite_scroll': ('Dynamic Content', 'open'),
    'challenging_dom': ('Advanced DOM', 'open'),
    'large': ('Advanced DOM', 'open'),
    'shifting_content': ('Advanced DOM', 'open'),
    'shadowdom': ('Advanced DOM', 'open'),
    'javascript_alerts': ('JavaScript', 'open'),
    'javascript_error': ('JavaScript', 'open'),
    'jqueryui': ('JavaScript', 'open'),
    'tinymce': ('JavaScript', 'open'),
    'frames': ('Windows & Frames', 'open'),
    'nested_frames': ('Windows & Frames', 'open'),
    'windows': ('Windows & Frames', 'open'),
    'download': ('Files', 'open'),
    'download_secure': ('Files', 'open'),
    'abtest': ('Testing Patterns', 'open'),
    'broken_images': ('Testing Patterns', 'open'),
    'geolocation': ('Testing Patterns', 'open'),
    'horizontal_slider': ('Testing Patterns', 'open'),
    'notification_message_rendered': ('Testing Patterns', 'open'),
    'redirector': ('Testing Patterns', 'open'),
    'slow': ('Testing Patterns', 'open'),
    'status_codes': ('Testing Patterns', 'open'),
    'tables': ('Testing Patterns', 'open'),
    'typos': ('Testing Patterns', 'open'),
}

def get_page_title(filename):
    """Generate title from filename"""
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
        'abtest': 'A/B Testing',
        'basic_auth': 'Basic Auth',
        'broken_images': 'Broken Images',
        'context_menu': 'Context Menu',
        'shadowdom': 'Shadow DOM',
        'slow': 'Slow Resources',
        'windows': 'Multiple Windows',
    }
    key = filename.replace('.html', '').replace('_', '_').lower()
    return title_map.get(key, key.replace('_', ' ').title())

def extract_content(html_file):
    """Extract page content from old HTML file"""
    try:
        with open(html_file, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()

        # Try to extract from <div class="example">
        match = re.search(r'<div[^>]*class="example"[^>]*>.*?</div>(?:\s*</br>)?', content, re.DOTALL)
        if match:
            return match.group(0).strip()

        # Try to extract from h3
        match = re.search(r'<h3>.*?</div>\s*(?:</div>)?', content, re.DOTALL)
        if match:
            return match.group(0).strip()

        return "<p>Content not available</p>"
    except:
        return "<p>Error loading content</p>"

def get_menu_key(filename):
    """Get menu key from filename"""
    key = filename.replace('.html', '').lower()
    if key == 'index':
        return None
    return key

def create_subfolder_file(filepath, depth=1):
    """Create a properly formatted file for a subfolder"""
    try:
        with open(TEMPLATE_FILE, 'r', encoding='utf-8') as f:
            template = f.read()

        filename = os.path.basename(filepath)
        page_key = get_menu_key(filename)

        if not page_key:
            # For index.html, get key from parent directory
            parent_dir = os.path.basename(os.path.dirname(filepath))
            page_key = parent_dir

        page_title = get_page_title(filename)
        content = extract_content(filepath)

        # Create output
        output = template.replace('PAGE_TITLE', page_title)
        output = output.replace('<!-- PAGE CONTENT GOES HERE -->', content)

        # Fix paths for nested directories
        prefix = '../' * depth

        # Replace CSS/JS paths
        output = re.sub(
            r'href="(css/|js/)',
            f'href="{prefix}\\1',
            output
        )
        output = re.sub(
            r'src="(js/)',
            f'src="{prefix}\\1',
            output
        )

        # Replace menu links
        if page_key in MENU_STRUCTURE:
            menu_name, open_class = MENU_STRUCTURE[page_key]

            # Replace href for current page (use current file name or index.html)
            if filename == 'index.html':
                current_href = 'index.html'
            else:
                current_href = filename

            output = re.sub(
                f'(<a href="{current_href}")([^>]*)>',
                f'\\1\\2 class="active">',
                output
            )

            # Add class="open" to the menu group - simple approach
            # Replace first occurrence of menu-items within this menu group
            menu_group_pattern = menu_name.replace('&', r'\&')
            # Find the menu group and add open class to its items
            pattern = f'(<span>{menu_group_pattern}</span>.*?<div class="menu-items")'
            output = re.sub(
                pattern,
                r'\1 open',
                output,
                flags=re.DOTALL
            )

        # Write file
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(output)

        return True
    except Exception as e:
        print(f"Error processing {filepath}: {e}")
        return False

def get_depth(filepath):
    """Get directory depth relative to BASE_DIR"""
    rel_path = os.path.relpath(filepath, BASE_DIR)
    return rel_path.count(os.sep)

def main():
    print(f"Converting all subfolder files in {BASE_DIR}...\n")

    # Find all HTML files in subdirectories
    converted = 0
    for root, dirs, files in os.walk(BASE_DIR):
        # Skip root directory
        if root == BASE_DIR:
            continue

        for file in files:
            if file.endswith('.html') and file not in ['template.html']:
                filepath = os.path.join(root, file)
                depth = get_depth(filepath)

                if create_subfolder_file(filepath, depth):
                    rel_path = os.path.relpath(filepath, BASE_DIR)
                    print(f"✓ {rel_path}")
                    converted += 1

    print()
    print(f"✅ Converted {converted} subfolder files")

if __name__ == '__main__':
    main()
