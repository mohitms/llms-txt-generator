import { test, expect } from '@playwright/test';

test('Plugin activation and basic content check', async ({ page }) => {
    // 1. Visit the site (assuming freshly installed environment via wp-env usually requires login logic, 
    // but for public endpoint test we can just check 404 vs 200)

    // Note: In a real CI environment with wp-env, we need to ensure the plugin is activated. 
    // wp-env usually handles this via .wp-env.json mapping.
    // For this basic test, we'll check the public URL.

    const response = await page.goto('/llms.txt');

    // Logic: 
    // If plugin is ON, it should be 200 text/plain.
    // If OFF, it might be 404 or redirect.

    // We expect it to be 200 because we will configure wp-env to activate it.
    expect(response.status()).toBe(200);
    const headers = response.headers();
    expect(headers['content-type']).toContain('text/plain');

    const content = await page.body();
    // Check for the default content we seeded
    expect(content.toString()).toContain('#');
});
