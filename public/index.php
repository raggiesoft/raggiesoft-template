<?php
// includes/header.php
// v6.0 - The "Elara" Standard Header
// Features: Dynamic Themes, Analytics, Reactive Loader, & BfCache Fix.

// 1. Resolve Context
$site  = $currentSite ?? 'stardust-engine'; // Default to your project slug
$theme = $currentPageTheme ?? $site;

// Ensure CDN Root exists
$cdn_root = $cdnBaseUrl ?? 'https://assets.raggiesoft.com';

// Theme Reset Logic (If theme == site, use root structure)
if ($site !== 'stardust-engine' && $theme === 'stardust-engine') {
    $theme = $site;
}

// Logic: Force Dark Mode for specific themes (optional)
$force_dark_mode = ($theme === 'ad-astra');

// 2. Path Definitions
$path_bootstrap = $cdn_root . "/common/css/bootstrap.css";

// Theme Directory Logic
if ($theme === 'corporate' || $theme === $site || $theme === 'light') {
    $path_theme_base = $cdn_root . "/{$site}/css/bootstrap";
} else {
    $path_theme_base = $cdn_root . "/{$site}/css/bootstrap/{$theme}";
}

// 3. Build CSS Queue
$css_load_queue = [
    $path_bootstrap,                    
    $path_theme_base . '/root.css',     
    $path_theme_base . '/extras.css',   
    $path_theme_base . '/header.css',   
    $path_theme_base . '/footer.css',   
    $path_theme_base . '/safety-net.css'
];

// 4. Critical Images (Preload)
$critical_images = [
    $navbarBrandLogo ?? '' // Preload logo if set
];
if (isset($customPageAssets) && is_array($customPageAssets)) {
    $critical_images = array_merge($critical_images, $customPageAssets);
}
?>
<!doctype html>
<html lang="en" class="h-100" <?php echo $force_dark_mode ? 'data-bs-theme="dark"' : ''; ?>>
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
    
    <title><?php echo htmlspecialchars($pageTitle ?? 'Page Title'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($ogDescription ?? ''); ?>">
    
    <meta property="og:title" content="<?php echo htmlspecialchars($ogTitle ?? $pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($ogDescription ?? ''); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($ogImage ?? ''); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($ogUrl ?? "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>">

    <?php foreach ($css_load_queue as $cssUrl): ?>
        <link href="<?php echo $cssUrl . '?v=' . time(); ?>" rel="stylesheet">
    <?php endforeach; ?>

    <script src="https://kit.fontawesome.com/ec060982d4.js" crossorigin="anonymous"></script>

    <?php foreach ($critical_images as $imgUrl): ?>
        <?php if($imgUrl): ?><link rel="preload" as="image" href="<?php echo $imgUrl; ?>"><?php endif; ?>
    <?php endforeach; ?>
    
    <link rel="icon" type="image/png" href="<?php echo $cdn_root; ?>/common/images/favicons/favicon-32x32.png">
    
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mrs+Saint+Delafield&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Mrs+Saint+Delafield&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@700&display=swap" rel="stylesheet">
    
    <style>
        /* Logo Filters */
        .navbar-brand-corporate-img { mix-blend-mode: multiply; }
        [data-bs-theme="dark"] .navbar-brand-corporate-img {
            filter: invert(1) grayscale(100%);
            mix-blend-mode: screen;
        }
        
        /* Loader Styles (Embedded to ensure instant render) */
        #page-loader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: #050508; z-index: 99999;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            opacity: 1; visibility: visible;
            transition: opacity 0.5s ease-in-out, visibility 0s 0s;
        }
        #page-loader.loader-hidden {
            opacity: 0; visibility: hidden;
            transition: opacity 0.5s ease-in-out, visibility 0s 0.5s;
        }
        .loader-progress-container {
            width: 300px; height: 4px; background-color: #333; margin-top: 20px; position: relative; overflow: hidden;
        }
        .loader-progress-bar {
            height: 100%; background-color: #0dcaf0; width: 0%; transition: width 0.2s ease; box-shadow: 0 0 10px #0dcaf0;
        }
    </style>
  </head>
  
  <body class="d-flex flex-column h-100">
    
    <div id="page-loader">
        <div class="spinner-border text-info mb-3" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h4 class="text-white text-uppercase" style="font-family: 'Audiowide', sans-serif; letter-spacing: 2px;">
            <?php echo htmlspecialchars($settings['siteName'] ?? 'Loading'); ?>
        </h4>
        <div class="loader-progress-container">
            <div class="loader-progress-bar" id="loader-bar"></div>
        </div>
        <div class="text-info font-monospace small mt-2" id="loader-text">> CONNECTING...</div>
    </div>
    
    <script>
    (function() {
        const loader = document.getElementById('page-loader');
        const bar = document.getElementById('loader-bar');
        const text = document.getElementById('loader-text');
        
        let progress = 0;
        let progressInterval;

        // 1. Zeno's Paradox: Heartbeat Animation
        // Moves the bar fast at first, then slows down, never hitting 100% until real load event.
        function startHeartbeat() {
            if (progressInterval) clearInterval(progressInterval);
            progress = 10;
            if(bar) bar.style.width = '10%';
            
            progressInterval = setInterval(() => {
                let step = (95 - progress) / 80; // Decaying increment
                if (step < 0.1) step = 0.1; 
                progress += step;
                if (progress > 95) progress = 95; 
                
                if(bar) bar.style.width = progress + '%';
                
                // Narrative Feedback
                if(text) {
                    if (progress < 30) text.innerText = "> ESTABLISHING UPLINK...";
                    else if (progress < 50) text.innerText = "> RECEIVING DATA...";
                    else if (progress < 70) text.innerText = "> ALLOCATING MEMORY...";
                    else text.innerText = "> PROCESSING...";
                }
            }, 50);
        }

        // 2. Interactive State (HTML Parsed, waiting for images)
        document.addEventListener('readystatechange', () => {
            if (document.readyState === 'interactive') {
                progress = 75;
                if(bar) bar.style.width = '75%';
                if(text) text.innerText = "> ASSEMBLING LAYOUT...";
            }
        });

        // 3. Complete State (Everything Loaded)
        function finishLoad() {
            if (progressInterval) clearInterval(progressInterval);
            if(bar) bar.style.width = '100%';
            if(text) text.innerText = "> SYSTEM READY.";
            
            setTimeout(() => { 
                if(loader) loader.classList.add('loader-hidden'); 
            }, 500);
        }

        // --- EXECUTION ---
        startHeartbeat(); 
        window.addEventListener('load', finishLoad);
        
        // --- OUTGOING LINK HANDLER ---
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (!link) return;
            const href = link.getAttribute('href');
            const target = link.getAttribute('target');
            
            if (link.classList.contains('dropdown-toggle') || link.getAttribute('role') === 'button') return;
            if (!href || href === '#' || href.startsWith('#')) return;
            if (target === '_blank') return;
            if (link.href && link.href.indexOf(window.location.hostname) === -1) return;
            if (link.hasAttribute('download')) return;

            if(loader) {
                text.innerText = "> NAVIGATING...";
                bar.style.width = '0%'; 
                loader.classList.remove('loader-hidden');
                startHeartbeat(); 
            }
        });

        // --- THE CRITICAL FIX: Browser Back Button (bfcache) ---
        // Prevents the loader from staying visible when hitting "Back"
        window.addEventListener('pageshow', (event) => {
            if (event.persisted && loader) {
                loader.classList.add('loader-hidden');
            }
        });
    })();
    </script>
    
    <header>
      <nav class="navbar navbar-expand-md sticky-top border-bottom border-primary border-opacity-50 bg-body">
        <div class="container-fluid">
          
          <a class="navbar-brand d-flex align-items-center" href="<?php echo htmlspecialchars($navbarBrandLink ?? '/'); ?>">
            
            <?php if (!empty($navbarBrandLogo)): ?>
            <img src="<?php echo htmlspecialchars($navbarBrandLogo); ?>" 
                 alt="<?php echo htmlspecialchars($navbarBrandAlt ?? 'Logo'); ?>" 
                 height="30" 
                 class="me-2 d-inline-block align-text-top <?php echo htmlspecialchars($navbarBrandClass ?? ''); ?>">
            <?php endif; ?>
            
            <span class="fw-bold text-uppercase" style="font-family: 'Audiowide', sans-serif;">
              <?php echo strip_tags($navbarBrandText ?? $settings['siteName'] ?? 'Elara Site', '<span>'); ?>
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