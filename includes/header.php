<?php
// includes/header.php
// Universal RaggieSoft Header v11.0 (Telemetry Enabled)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'RaggieSoft'); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Exo+2:ital,wght@0,100..900;1,100..900&family=Cinzel:wght@400;700&family=Crimson+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ec060982d4.js" crossorigin="anonymous"></script>

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($ogTitle ?? $pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($ogDescription ?? ''); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($ogImage ?? ''); ?>">

    <?php if ($telemetryConfig['active']): ?>
    <style>
        /* === TELEMETRY ENGINE STYLES === */
        /* These styles are injected critically to ensure they exist before the DOM paints */
        
        body { margin: 0; overflow: hidden; background-color: <?php echo $telemetryConfig['bgColor']; ?>; }
        
        #main-site-wrapper { opacity: 0; transition: opacity 0.6s ease-in-out; }
        
        #rs-telemetry-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: <?php echo $telemetryConfig['bgColor']; ?>; 
            z-index: 9999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: opacity 0.4s ease-in-out;
            font-family: <?php echo $telemetryConfig['font']; ?>;
        }

        .telemetry-spinner {
            width: 50px; height: 50px;
            border: 3px solid rgba(125, 125, 125, 0.2);
            border-top: 3px solid <?php echo $telemetryConfig['primaryColor']; ?>; 
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-bottom: 25px;
        }

        .telemetry-bar-container {
            width: 240px; height: 4px; 
            background: rgba(125,125,125,0.1); 
            border-radius: 2px; overflow: hidden; margin-bottom: 10px;
        }

        .telemetry-bar-fill {
            height: 100%; width: 0%; 
            background-color: <?php echo $telemetryConfig['primaryColor']; ?>; 
            transition: width 0.2s ease-out;
        }

        .telemetry-status {
            font-size: 0.85rem; 
            color: <?php echo $telemetryConfig['secondaryColor']; ?>; 
            text-transform: uppercase; 
            letter-spacing: 1px;
            font-weight: 700;
        }

        .telemetry-detail {
            font-size: 0.75rem; 
            color: <?php echo $telemetryConfig['textColor']; ?>; 
            margin-top: 5px; 
            opacity: 0.7;
        }

        .cursor { animation: blink 1s step-end infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        @keyframes blink { 50% { opacity: 0; } }
    </style>

    <script>
        const windowLoadPromise = new Promise((resolve) => {
            if (document.readyState === 'complete') resolve();
            else window.addEventListener('load', resolve);
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Receive Queue from Router
            const queue = <?php echo json_encode($load_queue ?? []); ?>;
            
            let loadedCount = 0;
            const total = queue.length;
            let isQueueFinished = false;
            
            const progressBar = document.getElementById('telemetry-fill');
            const statusText = document.getElementById('telemetry-text');
            const detailText = document.getElementById('telemetry-detail');
            const overlay = document.getElementById('rs-telemetry-overlay');
            const siteContent = document.getElementById('main-site-wrapper');
            const successColor = "<?php echo $telemetryConfig['successColor']; ?>";

            // --- INTERCEPTOR: LINK CLICK EFFECT ---
            document.body.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (!link) return;
                const href = link.getAttribute('href');
                const target = link.getAttribute('target');
                const currentPath = window.location.pathname;
                
                if (href && !href.startsWith('#') && !href.startsWith('mailto:') && target !== '_blank' && (href.startsWith('/') || href.includes(window.location.hostname)) && href !== currentPath) {
                    overlay.style.display = 'flex';
                    void overlay.offsetWidth; // Trigger reflow
                    overlay.style.opacity = '1';
                    siteContent.style.opacity = '0';
                    statusText.innerHTML = "NAVIGATING<span class='cursor'>_</span>";
                    detailText.innerText = "Target: " + href;
                    progressBar.style.width = '100%';
                }
            });

            // --- LOADER LOGIC ---
            function itemLoaded(item) {
                if (isQueueFinished) return;
                loadedCount++;
                const percent = (loadedCount / total) * 100;
                progressBar.style.width = percent + '%';
                
                const verbs = ["LOADING", "PARSING", "CONNECTING"];
                const randomVerb = verbs[Math.floor(Math.random() * verbs.length)];
                statusText.innerHTML = randomVerb + " ASSETS<span class='cursor'>_</span>";
                detailText.innerText = (item.name || 'Resource Verified'); 
                
                if (loadedCount >= total) {
                    isQueueFinished = true;
                    attemptToCloseOverlay();
                }
            }

            function attemptToCloseOverlay() {
                if (!isQueueFinished) return;
                statusText.innerHTML = "RENDERING<span class='cursor'>_</span>";
                windowLoadPromise.then(() => {
                    finishLoading();
                });
            }

            function finishLoading() {
                statusText.innerHTML = "READY<span class='cursor'>_</span>";
                detailText.innerText = "System Online";
                progressBar.style.width = '100%';
                progressBar.style.backgroundColor = successColor;
                
                setTimeout(() => {
                    overlay.style.opacity = '0';
                    siteContent.style.opacity = '1';
                    document.body.style.overflow = 'auto'; // Unlock scroll
                    setTimeout(() => { overlay.style.display = 'none'; }, 500);
                }, 300);
            }

            // Failsafe: Force load after 4 seconds
            setTimeout(() => {
                if (window.getComputedStyle(overlay).opacity !== '0') {
                    console.warn("Telemetry timeout. Forcing system start.");
                    finishLoading();
                }
            }, 4000);

            // Start Queue Processing
            if (total === 0) finishLoading();
            
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
    <?php endif; ?>
    
    <noscript>
        <?php if(isset($load_queue)): foreach ($load_queue as $item): 
            if($item['type'] === 'css'): ?>
            <link href="<?php echo $item['url']; ?>" rel="stylesheet">
        <?php endif; endforeach; endif; ?>
        <style>#main-site-wrapper { opacity: 1; } #rs-telemetry-overlay { display: none; } body { overflow: auto; }</style>
    </noscript>

</head>
<body class="d-flex flex-column min-vh-100">

    <?php if ($telemetryConfig['active']): ?>
    <div id="rs-telemetry-overlay">
        <div class="telemetry-spinner"></div>
        <div class="telemetry-bar-container">
            <div id="telemetry-fill" class="telemetry-bar-fill"></div>
        </div>
        <div id="telemetry-text" class="telemetry-status">INITIALIZING<span class="cursor">_</span></div>
        <div id="telemetry-detail" class="telemetry-detail">Connecting to RaggieSoft Network...</div>
    </div>
    <?php endif; ?>

    <div id="main-site-wrapper" class="d-flex flex-column flex-grow-1 h-100">

        <header class="sticky-top shadow-sm">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    
                    <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                        <?php if (isset($currentLogo) && !empty($currentLogo)): ?>
                            <img src="<?php echo $currentLogo; ?>" alt="Logo" height="32" class="me-2">
                        <?php endif; ?>
                        <span><?php echo htmlspecialchars($siteConfig['name'] ?? 'Site Name'); ?></span>
                    </a>

                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                        <span class="hamburger-bar"></span>
                        <span class="hamburger-bar"></span>
                        <span class="hamburger-bar"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="mainNav">
                        <?php 
                            $headerName = $pageConfig['header'] ?? 'header-default';
                            $headerFile = ROOT_PATH . '/includes/components/headers/' . $headerName . '.php';
                            if (file_exists($headerFile)) include $headerFile; 
                        ?>
                    </div>
                </div>
            </nav>
        </header>