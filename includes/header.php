<?php
// includes/header.php
// Universal RaggieSoft Header v8.3 (Corporate Theme Fix)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'The Stardust Engine'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($ogDescription ?? 'Explore Telsus Minor, a sci-fi universe where the reality of a phantom saboteur named Knox is a family fighting a corrupt corporation.'); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://assets.raggiesoft.com">

    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Reenie+Beanie&display=swap" rel="stylesheet">

    <link rel="icon" href="https://assets.raggiesoft.com/stardust-engine/images/stardust-engine-logo.png" type="image/png">
    <link rel="apple-touch-icon" href="https://assets.raggiesoft.com/stardust-engine/images/stardust-engine-logo.png">
    <script src="https://kit.fontawesome.com/ec060982d4.js" crossorigin="anonymous"></script>

    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($ogUrl ?? 'https://thestardustengine.com'); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($ogTitle ?? $pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($ogDescription ?? 'A musical universe forged in the fires of CPI.'); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($ogImage ?? 'https://assets.raggiesoft.com/stardust-engine/images/stardust-engine-logo-social.jpg'); ?>">
    <meta name="twitter:card" content="summary_large_image">

    <style>
        /* Global Base (Default Dark, overridden by Corporate Theme) */
        body { margin: 0; overflow: hidden; background-color: #050508; color: #E0E0FF; font-family: 'Courier New', monospace; }
        #main-site-wrapper { opacity: 0; transition: opacity 0.6s ease-in-out; }
        
        /* Telemetry Overlay */
        #stardust-telemetry-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: #050508; z-index: 9999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: opacity 0.4s ease-in-out;
        }
        .telemetry-spinner {
            width: 50px; height: 50px;
            border: 2px solid rgba(112, 0, 255, 0.2);
            border-top: 2px solid #00FFFF; 
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-bottom: 25px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.1);
        }
        .telemetry-bar-container {
            width: 240px; height: 2px; background: rgba(255,255,255,0.1); 
            border-radius: 0; overflow: hidden; margin-bottom: 10px;
        }
        .telemetry-bar-fill {
            height: 100%; width: 0%; background-color: #7000FF; 
            box-shadow: 0 0 10px #7000FF;
            transition: width 0.2s ease-out;
        }
        .telemetry-status {
            font-size: 0.75rem; color: #00FFFF; 
            text-transform: uppercase; letter-spacing: 1px;
            min-height: 1.2em; 
        }
        .telemetry-detail {
            font-size: 0.65rem; color: #6c757d; margin-top: 5px; text-transform: uppercase;
        }
        .cursor { animation: blink 1s step-end infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        @keyframes blink { 50% { opacity: 0; } }
    </style>

    <?php
        // ===================================================================
        // RESOURCE MANIFEST GENERATOR (v2)
        // ===================================================================
        
        // 1. Resolve Context
        $site  = $currentSite ?? 'stardust-engine';
        $theme = $currentPageTheme ?? null;
        
        $cdn_root = "https://assets.raggiesoft.com";
        $path_common = $cdn_root . "/common/css/bootstrap-common"; 
        
        // 2. Determine Theme Path
        if ($site === 'corporate') {
            $path_theme = $cdn_root . "/common/css/raggiesoft-corporate";
        } elseif ($theme && $theme !== $site) { 
            // Only treat as a sub-theme if it DOESN'T match the site name
            $path_theme = $cdn_root . "/{$site}/css/bootstrap/{$theme}";
        } else {
            // Default Path (Root of bootstrap folder)
            $path_theme = $cdn_root . "/{$site}/css/bootstrap";
        }

        // 3. Build Queue
        $load_queue = [];
        
        // CSS Modules
        $css_modules = [
            ['file' => 'bootstrap-base.css',   'source' => 'common', 'name' => 'Core Framework'],
            ['file' => 'root.css',             'source' => 'theme',  'name' => 'Theme Variables'],
            ['file' => 'extras.css',           'source' => 'theme',  'name' => 'Visual FX Engine'],
            ['file' => 'bootstrap-header.css', 'source' => 'common', 'name' => 'Nav Systems'],
            ['file' => 'bootstrap-footer.css', 'source' => 'common', 'name' => 'Player Interface'],
            ['file' => 'safety-net.css',       'source' => 'theme',  'name' => 'Safety Overrides'],
            ['file' => 'raggiesoft-extras.css','source' => 'common', 'name' => 'Global Patches']
        ];

        foreach ($css_modules as $m) {
            $base = ($m['source'] === 'common') ? $path_common : $path_theme;
            $load_queue[] = [
                'type' => 'css',
                'url'  => $base . '/' . $m['file'] . '?v=' . time(),
                'name' => $m['name']
            ];
        }

        // Images
        $critical_images = [
            'System Logo' => 'https://assets.raggiesoft.com/stardust-engine/images/stardust-engine-logo.png'
        ];

        if (isset($customPageAssets) && is_array($customPageAssets)) {
            $critical_images = array_merge($critical_images, $customPageAssets);
        }

        foreach ($critical_images as $name => $url) {
            $load_queue[] = [
                'type' => 'image',
                'url'  => $url,
                'name' => $name
            ];
        }
    ?>

    <script>
        const windowLoadPromise = new Promise((resolve) => {
            if (document.readyState === 'complete') {
                resolve();
            } else {
                window.addEventListener('load', resolve);
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            const queue = <?php echo json_encode($load_queue); ?>;
            let loadedCount = 0;
            const total = queue.length;
            let isQueueFinished = false;
            
            const progressBar = document.getElementById('telemetry-fill');
            const statusText = document.getElementById('telemetry-text');
            const detailText = document.getElementById('telemetry-detail');
            const overlay = document.getElementById('stardust-telemetry-overlay');
            const siteContent = document.getElementById('main-site-wrapper');

            // Link Interceptor
            document.body.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (!link) return;
                const href = link.getAttribute('href');
                const target = link.getAttribute('target');
                const currentPath = window.location.pathname;
                
                if (href && !href.startsWith('#') && !href.startsWith('mailto:') && !href.startsWith('tel:') && target !== '_blank' && (href.startsWith('/') || href.includes(window.location.hostname)) && href !== currentPath && href !== window.location.href) {
                    overlay.style.display = 'flex';
                    void overlay.offsetWidth;
                    overlay.style.opacity = '1';
                    siteContent.style.opacity = '0';
                    statusText.innerHTML = "CALCULATING JUMP VECTORS<span class='cursor'>_</span>";
                    detailText.innerText = "TARGET LOCKED: " + href;
                    progressBar.style.width = '100%';
                    progressBar.style.backgroundColor = '#7000FF'; 
                }
            });

            function itemLoaded(item) {
                if (isQueueFinished) return;
                loadedCount++;
                const percent = (loadedCount / total) * 100;
                progressBar.style.width = percent + '%';
                const verbs = ["ACQUIRING", "PARSING", "DECRYPTING", "BUFFERING"];
                const randomVerb = verbs[Math.floor(Math.random() * verbs.length)];
                statusText.innerHTML = randomVerb + " DATA STREAM<span class='cursor'>_</span>";
                detailText.innerText = "VERIFIED: " + (item.name || 'Asset'); 
                if (loadedCount >= total) {
                    isQueueFinished = true;
                    attemptToCloseOverlay();
                }
            }

            function attemptToCloseOverlay() {
                if (!isQueueFinished) return;
                statusText.innerHTML = "RENDERING UI<span class='cursor'>_</span>";
                windowLoadPromise.then(() => {
                    finishLoading();
                });
            }

            function finishLoading() {
                statusText.innerHTML = "SYSTEM ONLINE<span class='cursor'>_</span>";
                detailText.innerText = "Connection Established.";
                progressBar.style.width = '100%';
                progressBar.style.backgroundColor = "#00FF9D"; 
                progressBar.style.boxShadow = "0 0 15px #00FF9D";
                setTimeout(() => {
                    overlay.style.opacity = '0';
                    siteContent.style.opacity = '1';
                    document.body.style.overflow = 'auto'; 
                    setTimeout(() => { overlay.style.display = 'none'; }, 500);
                }, 400);
            }

            setTimeout(() => {
                if (window.getComputedStyle(overlay).opacity !== '0') {
                    console.warn("Telemetry timeout. Forcing system start.");
                    finishLoading();
                }
            }, 5000);

            queue.forEach(item => {
                if (item.type === 'css') {
                    const link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.onload = () => itemLoaded(item);
                    link.onerror = () => itemLoaded(item); 
                    link.href = item.url;
                    document.head.appendChild(link);
                } 
                else if (item.type === 'image') {
                    const img = new Image();
                    img.onload = () => itemLoaded(item);
                    img.onerror = () => itemLoaded(item);
                    img.src = item.url;
                }
            });
        });
    </script>
    
    <noscript>
        <?php foreach ($load_queue as $item): 
            if($item['type'] === 'css'): ?>
            <link href="<?php echo $item['url']; ?>" rel="stylesheet">
        <?php endif; endforeach; ?>
        <style>#main-site-wrapper { opacity: 1; } #stardust-telemetry-overlay { display: none; }</style>
    </noscript>

</head>
<body class="d-flex flex-column min-vh-100">

    <div id="stardust-telemetry-overlay">
        <div class="telemetry-spinner"></div>
        <div class="telemetry-bar-container">
            <div id="telemetry-fill" class="telemetry-bar-fill"></div>
        </div>
        <div id="telemetry-text" class="telemetry-status text-uppercase">Initializing Sequence<span class="cursor">_</span></div>
        <div id="telemetry-detail" class="telemetry-detail">Waiting for handshake...</div>
    </div>

    <div id="main-site-wrapper" class="d-flex flex-column flex-grow-1 h-100">

        <header class="sticky-top shadow-sm">
        <nav class="navbar navbar-expand-lg border-bottom">
            <div class="container-fluid">

            <a class="navbar-brand text-uppercase" href="/" aria-label="Stardust Engine Home" 
                style="font-family: 'Audiowide', sans-serif; letter-spacing: 1px; font-size: 1.25rem;">
                <img src="https://assets.raggiesoft.com/stardust-engine/images/stardust-engine-logo.png" 
                    class="me-2" 
                    alt="The Stardust Engine Logo" 
                    style="height: 40px; margin-top: -4px;"><span class="d-none d-md-inline">The </span>Stardust Engine
            </a>

            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="hamburger-bar"></span>
                <span class="hamburger-bar"></span>
                <span class="hamburger-bar"></span>
                </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <?php
                if (isset($currentHeaderMenu) && file_exists($currentHeaderMenu)) {
                    include $currentHeaderMenu; 
                } else {
                    echo '<ul class="navbar-nav ms-auto mb-2 mb-md-0"><li class="nav-item"><span class="nav-link text-danger">Error: Menu definition not found.</span></li></ul>';
                }
                ?>
            </div>

            </div>
        </nav>
        </header>