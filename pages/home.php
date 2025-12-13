<?php
// pages/home.php
// The Default Landing Page

// Example: How to fetch data (once you have a json file)
// $news = getSiteData('news.json'); 
?>

<div class="px-4 py-5 my-5 text-center">
    
    <div class="mb-4">
        <i class="fa-duotone fa-rocket-launch display-1 text-primary"></i>
    </div>
    
    <h1 class="display-4 fw-bold text-body-emphasis">
        Welcome to <?php echo htmlspecialchars($siteConfig['name']); ?>
    </h1>
    
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4 text-secondary">
            This project is powered by the <strong>RaggieSoft Standard Edition</strong> template. 
            It features the Elara Router, CDN asset integration, and a dynamic theming engine.
        </p>
        
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="/about" class="btn btn-primary btn-lg px-4 gap-3">
                <i class="fa-duotone fa-circle-info me-2"></i>View "About" Page
            </a>
            <a href="https://github.com/raggiesoft" target="_blank" class="btn btn-outline-secondary btn-lg px-4">
                <i class="fa-brands fa-github me-2"></i>GitHub
            </a>
        </div>
    </div>
</div>

<div class="container px-4 py-5" id="features">
    <h2 class="pb-2 border-bottom text-uppercase fs-5 text-secondary fw-bold">System Architecture</h2>
    
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
        
        <div class="col d-flex align-items-start">
            <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3 rounded p-3">
                <i class="fa-duotone fa-palette text-primary"></i>
            </div>
            <div>
                <h3 class="fs-4 text-body-emphasis">Theme Engine</h3>
                <p>
                    Change the entire look of the site by modifying the <code>default_theme</code> variable in <code>index.php</code>. 
                    Supports "Corporate", "Ad Astra", "Crucible", and more.
                </p>
            </div>
        </div>

        <div class="col d-flex align-items-start">
            <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3 rounded p-3">
                <i class="fa-duotone fa-cloud-arrow-down text-warning"></i>
            </div>
            <div>
                <h3 class="fs-4 text-body-emphasis">CDN Native</h3>
                <p>
                    This codebase is 100% logic. All binary assets (CSS, JS, Images, Fonts) are loaded remotely from <code>assets.raggiesoft.com</code>, keeping your repo lightweight.
                </p>
            </div>
        </div>

        <div class="col d-flex align-items-start">
            <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3 rounded p-3">
                <i class="fa-duotone fa-compass text-success"></i>
            </div>
            <div>
                <h3 class="fs-4 text-body-emphasis">Smart Routing</h3>
                <p>
                    No complex configuration required. Simply add a PHP file to the <code>/pages/</code> directory, and the Elara Router will automatically map a URL to it.
                </p>
            </div>
        </div>

    </div>
</div>