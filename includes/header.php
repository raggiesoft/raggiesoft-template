<?php
// includes/header.php
// Logic: Custom CDN Asset Loading

// 1. Resolve Context (Passed from Router)
$site  = $currentSite ?? 'new-project';
$theme = $currentPageTheme ?? 'light';

// NOTE: $cdnBaseUrl comes from settings.json via index.php
$cdn_root = $cdnBaseUrl ?? 'https://assets.raggiesoft.com'; 

// 2. PATH DEFINITIONS
// A. GLOBAL BASE: Pure Bootstrap
$path_bootstrap = $cdn_root . "/common/css/bootstrap.css";

// B. THEME DIRECTORY (Your Specific Logic)
if ($theme === 'corporate' || $theme === $site || $theme === 'light') {
    // Root Theme: assets/project/css/bootstrap
    $path_theme_base = $cdn_root . "/{$site}/css/bootstrap";
} else {
    // Named Sub-Theme: assets/project/css/bootstrap/theme-name
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

?>
<!doctype html>
<html lang="en" class="h-100" data-bs-theme="<?php echo htmlspecialchars($theme); ?>">
  <head>
    <?php 
    if (
        isset($settings['analytics']['enabled']) && 
        $settings['analytics']['enabled'] === true &&
        !empty($settings['analytics']['trackingId'])
    ): 
    ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($settings['analytics']['trackingId']); ?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '<?php echo htmlspecialchars($settings['analytics']['trackingId']); ?>');
        </script>
    <?php endif; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    
    <?php foreach ($css_load_queue as $cssUrl): ?>
        <link href="<?php echo $cssUrl . '?v=' . time(); ?>" rel="stylesheet">
    <?php endforeach; ?>

    <script src="https://kit.fontawesome.com/ec060982d4.js" crossorigin="anonymous"></script>
  </head>
  
  <body class="d-flex flex-column h-100">
    <header>
      <nav class="navbar navbar-expand-md sticky-top border-bottom">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">
             <?php echo $navbarBrandText ?? 'New Site'; ?>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
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