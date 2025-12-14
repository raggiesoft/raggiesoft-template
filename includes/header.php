<?php
// includes/header.php
// v4.2 - Feature: Forced Dark Mode for 'Ad Astra' theme + Sticky Header

// 1. Resolve Context
$site  = $currentSite ?? 'template-site';
$theme = $currentPageTheme ?? $site;
$cdn_root = "https://assets.raggiesoft.com";

// LOGIC: Force Dark Mode for 'ad-astra' theme
// If this is true, we will skip the JS auto-detector and force the HTML tag to dark.
$force_dark_mode = ($theme === 'ad-astra');

// 2. PATH DEFINITIONS
// A. GLOBAL BASE: Pure Bootstrap 5.3.8
$path_bootstrap = $cdn_root . "/common/css/bootstrap.css";

// B. THEME DIRECTORY
if ($theme === 'corporate' || $theme === $site) {
    $path_theme_base = $cdn_root . "/{$site}/css/bootstrap";
} else {
    $path_theme_base = $cdn_root . "/{$site}/css/bootstrap/{$theme}";
}

// 3. BUILD CSS QUEUE
$css_load_queue = [
    $path_bootstrap,                    
    $path_theme_base . '/root.css',     
    $path_theme_base . '/extras.css',   
    $path_theme_base . '/header.css',   
    $path_theme_base . '/footer.css',   
    $path_theme_base . '/safety-net.css'
];

// 4. CRITICAL IMAGES
$critical_images = [
    'https://assets.raggiesoft.com/stardust-engine/images/stardust-engine-logo.png'
];
if (isset($customPageAssets) && is_array($customPageAssets)) {
    $critical_images = array_merge($critical_images, $customPageAssets);
}

?>
<!doctype html>
<html lang="en" class="h-100" <?php echo $force_dark_mode ? 'data-bs-theme="dark"' : ''; ?>>
  <head>
    
    <?php if (! $force_dark_mode): ?>
    <script>
      (function() {
        // A. Define Helpers
        const getStoredTheme = () => localStorage.getItem('theme');
        const getPreferredTheme = () => {
          const storedTheme = getStoredTheme();
          if (storedTheme) {
            return storedTheme;
          }
          return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        };

        const setTheme = theme => {
          if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
          } else {
            document.documentElement.setAttribute('data-bs-theme', theme);
          }
        };

        // B. Initial Set (Run Immediately)
        setTheme(getPreferredTheme());

        // C. Real-Time Listener (The Fix)
        // Watches for OS-level changes (e.g., Mac switching to Night Mode)
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            const storedTheme = getStoredTheme();
            // Only update if the user hasn't explicitly locked a preference
            if (!storedTheme || storedTheme === 'auto') {
                setTheme(getPreferredTheme());
            }
        });
      })();
    </script>
    <?php endif; ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo htmlspecialchars($pageTitle ?? 'The Stardust Engine'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($ogDescription ?? 'The official archive of The Stardust Engine.'); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($ogTitle ?? $pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($ogDescription ?? ''); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($ogImage ?? ''); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($ogUrl ?? "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>">

    <?php foreach ($css_load_queue as $cssUrl): ?>
<link href="<?php echo $cssUrl . '?v=' . time(); ?>" rel="stylesheet">
    <?php endforeach; ?>

    <script src="https://kit.fontawesome.com/74d30f40e0.js" crossorigin="anonymous"></script>

    <?php foreach ($critical_images as $imgUrl): ?>
<link rel="preload" as="image" href="<?php echo $imgUrl; ?>">
    <?php endforeach; ?>
    
    <link rel="icon" type="image/png" href="https://assets.raggiesoft.com/common/images/favicons/favicon-32x32.png">
  </head>
  
  <body class="d-flex flex-column h-100">
    
    <header>
      <nav class="navbar navbar-expand-md sticky-top border-bottom border-primary border-opacity-50 bg-body">
        <div class="container-fluid">
          
          <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="https://assets.raggiesoft.com/stardust-engine/images/stardust-engine-logo.png" 
                 alt="Stardust Logo" height="30" class="me-2 d-inline-block align-text-top shadow-glow rounded-circle">
            <span class="fw-bold text-uppercase d-none d-sm-inline" style="font-family: 'Audiowide', sans-serif;">
                The Stardust Engine
            </span>
          </a>
          
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" 
                  aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <?php 
                if (isset($currentHeaderMenu) && file_exists($currentHeaderMenu)) {
                    include $currentHeaderMenu;
                } else {
                    include ROOT_PATH . '/includes/components/headers/header-default.php';
                }
            ?>
          </div>
        </div>
      </nav>
    </header>   