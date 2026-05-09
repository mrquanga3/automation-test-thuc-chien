#!/usr/bin/env python3
import os
import re
from pathlib import Path

BASE_DIR = r"d:\automation-test-thuc-chien\web for testing\demoqa2\the-internet.herokuapp.com"

# Map of direct file links that need ../ prefix in subdirectories
FILES_TO_FIX = [
    'checkboxes.html', 'dropdown.html', 'inputs.html', 'key_presses.html', 'upload.html',
    'basic_auth.html', 'login.html', 'forgot_password.html',
    'drag_and_drop.html', 'hovers.html', 'context_menu.html', 'floating_menu.html',
    'dynamic_content.html', 'dynamic_controls.html', 'dynamic_loading.html',
    'disappearing_elements.html', 'entry_ad.html', 'exit_intent.html', 'infinite_scroll.html',
    'challenging_dom.html', 'large.html', 'shifting_content.html', 'shadowdom.html',
    'javascript_alerts.html', 'javascript_error.html', 'tinymce.html',
    'frames.html', 'nested_frames.html', 'windows.html',
    'download.html', 'download_secure.html',
    'abtest.html', 'broken_images.html', 'geolocation.html', 'horizontal_slider.html',
    'notification_message_rendered.html', 'redirector.html', 'slow.html', 'status_codes.html',
    'tables.html', 'typos.html'
]

def fix_subfolder_file(filepath):
    """Fix relative paths in files that are in subdirectories"""
    # Check if file is in a subdirectory
    rel_path = os.path.relpath(filepath, BASE_DIR)
    parts = rel_path.split(os.sep)

    # Only process files in subdirectories (depth > 1)
    if len(parts) <= 1:
        return False

    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()

        original = content

        # Replace all direct file links with ../filename
        for filename in FILES_TO_FIX:
            # Match href="filename.html" but not href="../filename.html"
            pattern = f'href="{filename}"'
            replacement = f'href="../{filename}"'
            content = content.replace(pattern, replacement)

        # Also fix subfolder links like digest_auth/index.html
        # Replace href="digest_auth/index.html" with href="../digest_auth/index.html"
        content = re.sub(
            r'href="([a-z_]+/index\.html)"(?!["\s]*/)',
            r'href="../\1"',
            content
        )

        if content != original:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            return True
        return False
    except Exception as e:
        print(f"Error processing {filepath}: {e}")
        return False

def main():
    print(f"Fixing relative paths in {BASE_DIR}...\n")

    fixed_count = 0
    for root, dirs, files in os.walk(BASE_DIR):
        for file in files:
            if file.endswith('.html') and file not in ['template.html', 'index.html']:
                filepath = os.path.join(root, file)
                if fix_subfolder_file(filepath):
                    rel_path = os.path.relpath(filepath, BASE_DIR)
                    print(f"✓ Fixed: {rel_path}")
                    fixed_count += 1

    print()
    print(f"✅ Fixed {fixed_count} files")

if __name__ == '__main__':
    main()
