import { test, expect } from '@playwright/test';

test('Plugin activation and basic content check', async ({ page }) => {
    // Explicitly go to admin to ensure we are running (optional if wp-env is configured right, but safer)
    // Actually, for a simple public test, we assume wp-env works via .wp-env.json
    // But let's debug the response specifically.

    console.log('Navigating to /llms.txt...');
    const response = await page.goto('/llms.txt');
    console.log(`Response status: ${response.status()}`);

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
