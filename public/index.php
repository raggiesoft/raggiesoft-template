<?php
// RaggieSoft Elara Router v2.2 (CDN Theme Version)
// A lightweight, file-based router for narrative websites.

define('ROOT_PATH', dirname(__DIR__));
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Sanitize: Remove trailing slash if not root
if (strlen($request_uri) > 1) {
    $request_uri = rtrim($request_uri, '/');
}

// --- 1. GLOBAL DEFAULTS ---
// CONFIG: Configure these for your specific project!
$siteName = 'New Narrative Project';
$projectSlug = 'project-name'; // e.g., 'stardust-engine' or 'luna-and-leo'
$cdnBaseUrl = 'https://assets.raggiesoft.com';

// Theme Logic:
// 'raggiesoft' = The Global Default (common/css/theme-raggiesoft.css)
// Any other name = Project Specific (project-name/css/theme-name.css)
$defaultTheme = 'raggiesoft'; 

$defaults = [
    'view' => 'errors/404',
    'title' => $siteName,
    'theme' => $defaultTheme,
    'showSidebar' => false, 
    'sidebar' => 'sidebar-default',
    'ogTitle' => $siteName,
    'ogDescription' => "A RaggieSoft Narrative Project.",
    'ogImage' => $cdnBaseUrl . "/images/default-og.jpg",
    'ogUrl' => "https://your-domain.com" . $request_uri
];

// --- 2. ROUTE CONFIGURATION ---
$routes = [
    '/' => [
        'view' => 'pages/home',
        'title' => 'Home - ' . $siteName
    ],
    // Example: A page using a specific theme variant
    // '/special-page' => [
    //     'view' => 'pages/special',
    //     'theme' => 'crucible' // Loads from /$projectSlug/css/theme-crucible.css
    // ],
];

// --- 3. SMART ROUTER LOGIC ---

// A. Check for Explicit Configuration
$pageConfig = $routes[$request_uri] ?? [];

// B. Auto-Discovery Logic
if (!isset($pageConfig['view'])) {
    $potentialPath = 'pages' . $request_uri;
    if (file_exists(ROOT_PATH . '/' . $potentialPath . '.php')) {
        $pageConfig['view'] = $potentialPath;
    } elseif (is_dir(ROOT_PATH . '/' . $potentialPath) && file_exists(ROOT_PATH . '/' . $potentialPath . '/overview.php')) {
        $pageConfig['view'] = $potentialPath . '/overview';
    }
}

// C. Auto-Title Logic
if (!isset($pageConfig['title'])) {
    $slug = basename($request_uri);
    $prettySlug = ucwords(str_replace('-', ' ', $slug));
    $pageConfig['title'] = $prettySlug . ' - ' . $siteName;
}

// --- 4. MERGE & RENDER ---
$config = array_merge($defaults, $pageConfig);

// Extract variables for the view
$pageTitle = $config['title'];
$currentPageTheme = $config['theme'];
$showSidebar = $config['showSidebar'];
// OG Tags
$ogTitle = $config['ogTitle'];
$ogDescription = $config['ogDescription'];
$ogImage = $config['ogImage'];
$ogUrl = $config['ogUrl'];

// Render Layout
require_once ROOT_PATH . '/includes/header.php';

// Sidebar Logic
echo '<div class="container-fluid flex-grow-1 d-flex">';
echo '  <div class="row flex-grow-1">';

if ($showSidebar) {
    $sidebarPath = ROOT_PATH . '/includes/components/sidebars/' . $config['sidebar'] . '.php';
    echo '    <aside class="col-md-3 col-lg-2 d-none d-md-block bg-body-tertiary border-end p-3">';
    if (file_exists($sidebarPath)) {
        require_once $sidebarPath;
    } else {
        echo "";
    }
    echo '    </aside>';
    echo '    <main id="main-content" class="col-md-9 col-lg-10 p-4">';
} else {
    echo '    <main id="main-content" class="col-12 p-0">'; 
}

// Load View
if (file_exists(ROOT_PATH . '/' . $config['view'] . '.php')) {
    require_once ROOT_PATH . '/' . $config['view'] . '.php';
} else {
    http_response_code(404);
    require_once ROOT_PATH . '/errors/404.php';
}

echo '    </main>'; 
echo '  </div>'; 
echo '</div>'; 

require_once ROOT_PATH . '/includes/footer.php';
?>