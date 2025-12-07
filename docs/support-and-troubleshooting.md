# Support & Troubleshooting Guide

This guide describes common issues users might encounter with **LLMS.txt Generator** and their solutions.

## Common Issues

### 1. "I get a 404 Error when visiting /llms.txt"
**Cause**: WordPress Rewrite Rules have not been updated to recognize the new endpoint.
**Solution**:
1.  Log in to your WordPress Admin.
2.  Go to **Settings > Permalinks**.
3.  Scroll down and simply click **Save Changes**.
4.  This forces WordPress to rebuild the internal map of URLs. Try visiting `/llms.txt` again.

### 2. "I don't see the Settings Page"
**Cause**: Lack of user permissions.
**Solution**:
-   Ensure you are logged in as an **Administrator**.
-   The menu is located under **Settings > LLMS.txt**. It is not a top-level menu item.

### 3. "My changes aren't showing up (Old content still visible)"
**Cause**: Browser caching or server-side caching (e.g., WP Super Cache, Cloudflare).
**Solution**:
1.  **Browser**: Open the URL in an Incognito/Private window.
2.  **Server Cache**: If you use a caching plugin, clear/purge the cache.
3.  **Note**: The plugin sends `Cache-Control: no-cache` headers, but aggressive 3rd party caches may ignore this.

### 4. "HTML tags disappear after saving"
**Cause**: Working as intended.
**Explanation**:
-   The `llms.txt` standard requires plain text content.
-   To prevent security vulnerabilities (XSS) and ensure compatibility with AI agents, the plugin automatically strips all HTML tags (`<b>`, `<div>`, `<script>`, etc.) upon saving.

## For Developers / Support Agents

If a user reports an issue that isn't solved by the above:

1.  **Check `llms_txt_content` in `wp_options` table**:
    -   Does the DB row exist?
    -   Is it empty?
2.  **Debug Rewrite Rules**:
    -   Install "Rewrite Rules Inspector" plugin.
    -   Search for `llms.txt`. It should map to `index.php?llms_txt=1`.
3.  **Conflict Test**:
    -   Temporarily deactivate other plugins to see if something is intercepting the `llms.txt` URL.
