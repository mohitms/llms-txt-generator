# LLMS.txt Generator - Testing Walkthrough

This document outlines the standard test procedures to ensure the plugin is functioning correctly.

## 1. Fresh Installation Test
**Objective**: Verify plugin activates and registers correctly.

1.  **Install**: Upload the plugin folder to `wp-content/plugins/`.
2.  **Activate**: Go to *Plugins > Installed Plugins* and click **Activate**.
3.  **Check Menu**: Verify a new submenu exists under **Settings > LLMS.txt**.
4.  **Check Permalink**: Visit `your-site.com/llms.txt`. It should return a blank page (or empty text) and **not** a 404 error.

## 2. Settings & Saving Test
**Objective**: Verify data persistence and security (sanitization).

1.  **Navigate**: Go to **Settings > LLMS.txt**.
2.  **Input**: Enter the following test string:
    ```text
    # My LLMS.txt
    Context: <b>This bold tag should be removed</b>.
    Hello World.
    ```
3.  **Save**: Click **Save Changes**.
4.  **Verify UI**: The textarea should now display:
    ```text
    # My LLMS.txt
    Context: This bold tag should be removed.
    Hello World.
    ```
    *Note: If the `<b>` tag persists, sanitization is failing.*

## 3. Frontend Output Test
**Objective**: Verify the public endpoint serves the correct content.

1.  **Visit Endpoint**: Open `your-site.com/llms.txt` in a browser.
2.  **Check Content**:
    -   Must match exactly what is in the settings.
    -   Must be `Content-Type: text/plain`.
    -   Must **NOT** contain any WordPress theme elements (header, footer, styles).
3.  **View Source**: Right-click > "View Page Source". Ensure there is no HTML wrapper.

## 4. Permalink Change Test
**Objective**: Verify logic robustness when site permalinks change.

1.  **Change Structure**: Go to **Settings > Permalinks**.
2.  **Toggle**: Change from "Post name" to "Plain" (or vice versa).
3.  **Save**: Click "Save Changes".
4.  **Re-test Endpoint**: Visit `your-site.com/llms.txt`.
    -   It should still work.
    -   If it returns 404, the automatic flush on init/activation might have missed, or manual flush is required. Mention this in troubleshooting.

## 5. Deactivation Test
**Objective**: Verify clean-up.

1.  **Deactivate**: Go to Plugins page and Deactivate.
2.  **Test Endpoint**: Visit `your-site.com/llms.txt`.
3.  **Result**: Should return standard WordPress 404 page (or redirect to home depending on theme), NOT the text file.
