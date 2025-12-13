<?php
ob_start(); 
// RaggieSoft "Elara" Router (Template Edition v1.1)
// Update: Added explicit site context switching for the Ad Astra theme.

define('ROOT_PATH', dirname(__DIR__));
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strlen($request_uri) > 1) {
    $request_uri = rtrim($request_uri, '/');
}

// --- 1. GLOBAL CONFIGURATION ---
$siteConfig = [
    'name'          => 'RaggieSoft Template',
    'slug'          => 'portfolio',           // Default CDN Folder
    'cdn_root'      => 'https://assets.raggiesoft.com',
    'default_theme' => 'corporate', 
    'default_logo'  => 'https://assets.raggiesoft.com/portfolio/images/logo.png',
    'default_view'  => 'pages/home'
];

// --- 2. TELEMETRY THEME (NEW) ---
// Define the colors for the loading screen here.
$telemetryConfig = [
    'active'         => true,                 // Master kill switch
    'bgColor'        => '#ffffff',            // Background (Paper White for Portfolio)
    'primaryColor'   => '#0d6efd',            // Progress Bar (Bootstrap Primary)
    'secondaryColor' => '#6c757d',            // Status Text (Secondary Grey)
    'successColor'   => '#198754',            // Completion Flash (Success Green)
    'textColor'      => '#212529',            // Detail Text (Dark Body)
    'font'           => 'system-ui, sans-serif' // Font Stack
];

require_once ROOT_PATH . '/includes/utils/data-loader.php';

// Default Page Meta
$pageConfig = [
    'title'       => $siteConfig['name'],
    'site'        => $siteConfig['slug'], // Defaults to 'portfolio'
    'theme'       => $siteConfig['default_theme'],
    'logo'        => $siteConfig['default_logo'],
    'view'        => 'errors/404',
    'header'      => 'header-default',
    'sidebar'     => 'sidebar-default',
    'showSidebar' => false 
];`


// --- 2. ROUTE DEFINITIONS ---
$routes = [
    
    '/' => [
        'view'  => 'pages/home',
        'title' => 'Home - ' . $siteConfig['name']
    ],

    '/about' => [
        'view'        => 'pages/about',
        'title'       => 'About Me',
        'showSidebar' => true
    ],

    // -- AD ASTRA THEME DEMO --
    // CRITICAL: We must change 'site' to 'stardust-engine' because 
    // the Ad Astra CSS files live in /stardust-engine/css/bootstrap/ad-astra/
    '/mission-log' => [
        'view'        => 'pages/templates/ad-astra',
        'title'       => 'Mission Log: Ad Astra',
        
        // CONTEXT SWITCH: Point to the Stardust Engine CDN folder
        'site'        => 'stardust-engine',
        
        // THEME ACTIVATION: Load the sub-theme CSS
        'theme'       => 'ad-astra',
        
        // OPTIONAL: Update Logo to match context
        'logo'        => 'https://assets.raggiesoft.com/stardust-engine/images/stardust-engine-logo.png',
        
        'showSidebar' => false
    ]
];

// --- 3. ROUTING LOGIC ---
if (isset($routes[$request_uri])) {
    $pageConfig = array_merge($pageConfig, $routes[$request_uri]);
} else {
    // Auto-Discovery
    $potential_path = 'pages' . $request_uri;
    if (file_exists(ROOT_PATH . '/' . $potential_path . '.php')) {
        $pageConfig['view'] = $potential_path;
        $slug = basename($request_uri);
        $pageConfig['title'] = ucwords(str_replace('-', ' ', $slug)) . ' - ' . $siteConfig['name'];
    }
}

// --- 4. THEME ENGINE ---

// Determine Context
$currentSite      = $pageConfig['site'];  // Will be 'stardust-engine' for /mission-log
$currentPageTheme = $pageConfig['theme']; // Will be 'ad-astra' for /mission-log
$currentLogo      = $pageConfig['logo'];
$cdn_root         = $siteConfig['cdn_root'];

// Build Paths based on Context
$path_bootstrap = $cdn_root . "/common/css/bootstrap/bootstrap.css";
$path_common_css = $cdn_root . "/common/css/bootstrap-common";
$path_site_css = $cdn_root . "/" . $currentSite . "/css/bootstrap";

// Resolve Sub-Theme
$path_active_theme = ($currentPageTheme && $currentPageTheme !== 'corporate') 
    ? $path_site_css . "/" . $currentPageTheme 
    : $path_site_css;

// Build CSS Stack
$css_files = [
    $path_bootstrap,
    $path_common_css . '/raggiesoft-extras.css',
    $path_active_theme . '/root.css',
    $path_active_theme . '/extras.css',
    $path_active_theme . '/header.css',
    $path_active_theme . '/footer.css',
    $path_active_theme . '/safety-net.css'
];

// --- 5. RENDER ---

if (!file_exists(ROOT_PATH . '/' . $pageConfig['view'] . '.php')) {
    http_response_code(404);
    $pageConfig['view'] = 'errors/404';
}

$pageTitle = $pageConfig['title'];
$showSidebar = $pageConfig['showSidebar'];

require_once ROOT_PATH . '/includes/header.php';

echo '<div class="container-fluid flex-grow-1 d-flex">';
echo '  <div class="row flex-grow-1">';

if ($showSidebar) {
    $sidebarFile = ROOT_PATH . '/includes/components/sidebars/' . $pageConfig['sidebar'] . '.php';
    if (file_exists($sidebarFile)) {
        echo '<aside class="col-md-3 col-lg-2 d-none d-md-block bg-body-tertiary border-end p-3">';
        include $sidebarFile;
        echo '</aside>';
        echo '<main id="main-content" class="col-md-9 col-lg-10 p-0">';
    } else {
        echo '<main id="main-content" class="col-12 p-0">';
    }
} else {
    echo '<main id="main-content" class="col-12 p-0">';
}

require_once ROOT_PATH . '/' . $pageConfig['view'] . '.php';

echo '    </main>';
echo '  </div>';
echo '</div>';

require_once ROOT_PATH . '/includes/footer.php';
ob_end_flush();
?>