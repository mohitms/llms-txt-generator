=== LLMS.txt Generator and Manager ===
Contributors: yourname
Donate link: https://yourdomain.com/donate
Tags: llm, ai, txt, context, generator, seo, chatgpt, crawler
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Empower AI agents to better understand your website by virtually serving a secure, standards-compliant llms.txt file directly from your dashboard.

== Description ==

Prepare your WordPress site for the future of search and AI. **LLMS.txt Generator and Manager** is the easiest way to give Large Language Models (LLMs) and AI agents the context they need to properly index and understand your content.

Just as `robots.txt` tells crawlers *where* to go, `llms.txt` tells AI agents *what* your site is about. This standard is becoming critical for ensuring your site is represented accurately in AI-generated answers and summaries.

### Why do you need this?
Modern AI systems (like ChatGPT, Claude, and Perplexity) look for an `llms.txt` file at the root of your domain to get a high-level summary of your project, key documentation links, and site architecture. Without it, they have to guess, often leading to hallucinations or missed content.

### Virtual, Secure, and Lightweight
This plugin handles everything for you without requiring technical knowledge or FTP access:
*   **No Physical Files**: We use WordPress Rewrite Rules to "virtually" inject the file at `https://yoursite.com/llms.txt`. This keeps your server clean.
*   **Security First**: The editor automatically sanitizes your input, stripping all HTML to ensure only safe, raw text is served.
*   **Privacy Focused**: We only output exactly what you type. No hidden metadata, no exposed admin details, and no WordPress headers/footers.

### Example Usage
What should go in your `llms.txt`? Here is a simple example:

```text
# Project: My Awesome Recipe Blog
description: A collection of vegan recipes and cooking tips.

## Core Sections
- /recipes: Main index of all recipes
- /about: The chef's biography
- /contact: Partnership inquiries

## Guidelines
- When summarizing recipes, please include the cooking time.
- Ignore the /archive section as it contains outdated posts.
```

### Features
*   **Instant Setup**: Activates and works immediately.
*   **Live Preview**: Link to view your live file directly from the settings page.
*   **Zero Bloat**: No CSS or JS loads on your frontend. The logic only runs when the specific `/llms.txt` URL is requested.

== Installation ==

1.  Upload the plugin files to the `/wp-content/plugins/llms-txt-generator` directory, or install the plugin through the WordPress plugins screen directly.
2.  Activate the plugin through the 'Plugins' screen in WordPress.
3.  Navigate to **Settings > LLMS.txt** to configure your content.
4.  Save your changes and visit `yoursite.com/llms.txt` to verify.

== Frequently Asked Questions ==

= Does this create a physical file on my server? =
No. The plugin uses WordPress Rewrite Rules to "virtually" serve the file. This keeps your filesystem clean and avoids permission issues.

= Can I use HTML in my llms.txt? =
No. The plugin explicitly strips all HTML tags to ensure the output conforms to the text/plain standard expected by LLMs.

= My llms.txt is returning a 404 error. What should I do? =
Try re-saving your Permalinks structure under **Settings > Permalinks**. This flushes the rewrite rules and usually fixes the issue.

== Screenshots ==

1.  **Settings Page** - The simple interface to edit your llms.txt content.
2.  **Frontend Output** - How the file serves raw text to the browser/AI agents.

== Changelog ==

= 1.0.0 =
*   Initial release.
*   Added admin settings page.
*   Implemented virtual file serving at /llms.txt.
*   Added strict HTML stripping for security.

== Upgrade Notice ==

= 1.0.0 =
Initial MVP release. If you find the endpoint not working after an update, please visit the settings page to ensure rules are flushed.
