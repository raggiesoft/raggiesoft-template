<?php
ob_start(); 
// Elara Router v1.0 (Boilerplate)
// Purpose: JSON-driven routing with H1 Auto-Discovery

define('ROOT_PATH', dirname(__DIR__));
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Normalize trailing slashes
if (strlen($request_uri) > 1) {
    $request_uri = rtrim($request_uri, '/');
}

// --- 1. LOAD GLOBAL SETTINGS ---
$settingsFile = ROOT_PATH . '/data/settings.json';

if (!file_exists($settingsFile)) {
    die('Critical Error: Configuration file (data/settings.json) missing.');
}

$settings = json_decode(file_get_contents($settingsFile), true);

// Extract Globals
$siteName = $settings['siteName']; 
$cdnBaseUrl = $settings['cdnBaseUrl'];
$defaultTheme = $settings['defaultTheme']; 

// Build Page Defaults
$defaults = array_merge($settings['defaults'], [
    'title' => $siteName, 
    'theme' => $defaultTheme,
    // Auto-generate OG Metadata
    'ogUrl' => "https://" . $_SERVER['HTTP_HOST'] . $request_uri,
]);

// --- 2. ROUTE DISCOVERY ---
// Scans /data/routes/*.json for route configurations
$routes = [];
$routeDirectory = ROOT_PATH . '/data/routes';

if (is_dir($routeDirectory)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($routeDirectory, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && strtolower($file->getExtension()) === 'json') {
            $routeData = json_decode(file_get_contents($file->getPathname()), true);
            if (is_array($routeData)) {
                $routes = array_merge($routes, $routeData);
            }
        }
    }
}

// --- 3. PAGE RESOLUTION ---
$pageConfig = $routes[$request_uri] ?? [];

// Auto-Discovery: If not in JSON, look for PHP file matching URI
if (!isset($pageConfig['view'])) {
    $potentialPath = 'pages' . $request_uri;
    
    if (file_exists(ROOT_PATH . '/' . $potentialPath . '.php')) {
        $pageConfig['view'] = $potentialPath;
    } elseif (is_dir(ROOT_PATH . '/' . $potentialPath)) {
        // Check for index/overview files if it's a directory
        if (file_exists(ROOT_PATH . '/' . $potentialPath . '/index.php')) {
            $pageConfig['view'] = $potentialPath . '/index';
        }
    }
}

// --- 4. INTELLIGENT METADATA (THE REQUESTED FEATURE) ---
if (isset($pageConfig['view'])) {
    
    // Auto-Sidebar Logic based on URL patterns
    if (!isset($pageConfig['sidebar'])) {
        foreach (($settings['sidebarMap'] ?? []) as $urlStart => $sidebarFile) {
            if (str_starts_with($request_uri, $urlStart)) {
                $pageConfig['sidebar'] = $sidebarFile;
                $pageConfig['showSidebar'] = true;
                break; 
            }
        }
    }

    // === H1 TITLE SCRAPER ===
    // If title is NOT in JSON, read the file and grab the first <h1>
    if (!isset($pageConfig['title'])) {
        $titleFound = false;
        $viewPath = ROOT_PATH . '/' . $pageConfig['view'] . '.php';
        
        if (file_exists($viewPath)) {
            $content = file_get_contents($viewPath);
            // Regex to find <h1>Content</h1>
            if (preg_match('/<h1[^>]*>(.*?)<\/h1>/si', $content, $matches)) {
                $h1Text = trim(strip_tags($matches[1])); 
                // Ensure we didn't grab PHP code
                if (!str_contains($h1Text, '<?')) {
                    $pageConfig['title'] = $h1Text . ' - ' . $siteName;
                    $titleFound = true;
                }
            }
        }
        
        // Fallback: If no H1 found, prettify the URL slug
        if (!$titleFound) {
            $slug = basename($request_uri);
            $pageConfig['title'] = ($slug === '' || $slug === 'index.php') 
                ? 'Home - ' . $siteName 
                : ucwords(str_replace('-', ' ', $slug)) . ' - ' . $siteName;
        }
    }
}

// --- 5. RENDER VIEW ---
$config = array_merge($defaults, $pageConfig);

// Handle Errors
if (!isset($pageConfig['view']) || !file_exists(ROOT_PATH . '/' . $pageConfig['view'] . '.php')) {
    http_response_code(404);
    $config['view'] = 'public/errors/404'; // Create this file!
    $config['title'] = "Page Not Found - " . $siteName;
}

// Extract Vars for Templates
$pageTitle = $config['title'];
$showSidebar = $config['showSidebar'];
$navbarBrandLogo = $config['navbarBrandLogo'] ?? null;

// Determine Header/Sidebar Files
$headerFile = 'header-default';
foreach (($settings['headerMap'] ?? []) as $urlStart => $mappedFile) {
    if (str_starts_with($request_uri, $urlStart)) {
        $headerFile = $mappedFile;
        break;
    }
}

// Load Templates
require_once ROOT_PATH . '/includes/header.php';

echo '<div class="container-fluid flex-grow-1 d-flex p-0">';
echo '  <div class="row flex-grow-1 m-0 w-100">';

if ($showSidebar) {
    $sidebarPath = ROOT_PATH . '/includes/components/sidebars/' . $config['sidebar'] . '.php';
    if (file_exists($sidebarPath)) {
        echo '    <aside class="col-md-3 col-lg-2 d-none d-md-block bg-light border-end p-3">';
        include $sidebarPath;
        echo '    </aside>';
        echo '    <main id="main-content" class="col-md-9 col-lg-10 p-0">';
    } else {
        echo '    <main id="main-content" class="col-12 p-0">';
    }
} else {
    echo '    <main id="main-content" class="col-12 p-0">'; 
}

// Load the actual Page Content
include ROOT_PATH . '/' . $config['view'] . '.php';

echo '    </main>'; 
echo '  </div>'; 
echo '</div>'; 

require_once ROOT_PATH . '/includes/footer.php';
ob_end_flush();
?>