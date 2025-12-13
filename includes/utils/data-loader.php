<?php
// includes/utils/data-loader.php
// RaggieSoft JSON Data Fetcher (Template Edition v1.0)

/**
 * Fetches and decodes a JSON file from the defined CDN for the current site.
 * * It relies on the global $siteConfig settings from public/index.php to 
 * determine the correct URL structure.
 *
 * @param string $filename  The name of the file (e.g., 'projects.json')
 * @param string $subfolder Optional subfolder in the CDN (default: 'json')
 * @return array The decoded data as an associative array, or an empty array on failure.
 */
function getSiteData($filename, $subfolder = 'json') {
    // 1. Access Global Configuration
    global $siteConfig; 
    
    // Safety check: Ensure configuration exists before trying to build a URL
    if (!isset($siteConfig['cdn_root']) || !isset($siteConfig['slug'])) {
        // Optional: Log error to php_error_log in production
        return [];
    }

    // 2. Construct the URL
    // Pattern: [CDN_ROOT] / [SITE_SLUG] / [SUBFOLDER] / [FILENAME]
    // Example: https://assets.raggiesoft.com/portfolio/json/projects.json
    $url = $siteConfig['cdn_root'] . '/' . $siteConfig['slug'] . '/' . $subfolder . '/' . $filename;
    
    // 3. Fetch Content
    // We use @ to suppress PHP warnings if the file is missing on the CDN
    $json_content = @file_get_contents($url);
    
    // 4. Validate Response
    if ($json_content === false) {
        return [];
    }
    
    // 5. Decode and Return
    // Returns an empty array [] if JSON is invalid or null
    return json_decode($json_content, true) ?? [];
}
?>