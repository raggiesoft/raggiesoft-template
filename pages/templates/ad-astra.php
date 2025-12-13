<?php
// pages/templates/ad-astra.php
// Theme: "Ad Astra" (Sci-Fi / High Contrast)
// Best for: Narrative deep dives, immersive audio experiences, or "Space Mode".

// ⚠️ CRITICAL CONFIGURATION NOTE:
// To use this template effectively, you MUST update your Router (public/index.php) 
// for this specific route to set TWO values:
//
//   1. 'site'  => 'stardust-engine'   <-- REQUIRED: Tells the asset loader to look in the /stardust-engine/ CDN folder
//   2. 'theme' => 'ad-astra'          <-- REQUIRED: Tells the loader to grab the specific sub-theme CSS
//
// If you do not set 'site' to 'stardust-engine', the system will try to find the 
// theme inside your default site folder (e.g., /portfolio/css/ad-astra/), which 
// likely does not exist, causing the page to load broken/unstyled.

// 1. Page Configuration
$pageTitle = "New Mission Log";

// 2. Hero Background Image
// Uses the transparent star pattern from the Common library
$heroImage = $cdn_root . '/common/patterns/stars-transparent.png'; 
?>

<div class="starfield-container">
    <div class="starfield-twinkling"></div>
</div>

<div class="container pb-5 glass-container">
    
    <div style="background: linear-gradient(to bottom right, rgba(5, 5, 8, 0.8), rgba(5, 5, 8, 0.6)), url('<?php echo $heroImage; ?>') center/cover no-repeat;">
        <div class="text-center mb-5 pt-5 fade-in-up">
            
            <span class="badge rounded-pill border border-warning text-warning mb-3 px-3 py-2 shadow-glow">
                <i class="fa-duotone fa-rocket-launch me-2"></i>Mission Status
            </span>
            
            <h1 class="display-1 fw-bold text-uppercase text-glow-primary mb-0" 
                style="font-family: 'Audiowide', sans-serif; letter-spacing: 4px;">
                Page Title
            </h1>
            
            <p class="h5 text-info fw-light text-uppercase mt-2" 
               style="font-family: 'Exo 2', sans-serif; letter-spacing: 2px;">
                Operational Sector 4
            </p>
        </div>

        <div class="row justify-content-center align-items-center mb-5 p-4 p-md-5">
            <div class="col-lg-8">
                <div class="card border-primary shadow-lg h-100" style="background: rgba(10, 5, 20, 0.6); backdrop-filter: blur(20px);">
                    <div class="card-body p-5 text-center">
                        <p class="lead text-white mb-4">
                            This template uses the <strong>Ad Astra</strong> theme engine. 
                            Text is high-contrast, backgrounds are translucent, and neon glows are enabled by default.
                        </p>
                        <button class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-glow" style="font-family: 'Audiowide';">
                            <i class="fa-duotone fa-shuttle-space me-2"></i> Engage Thrusters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            
            <div class="card terminal-card p-4">
                <div class="terminal-header">
                    <i class="fa-duotone fa-satellite-dish me-2"></i>
                    Incoming Transmission // Source: Unknown
                </div>
                
                <div class="small opacity-75 mb-3 font-monospace">
                    > ENCRYPTION: VERIFIED<br>
                    > TIMESTAMP: <?php echo date('Y-m-d H:i:s'); ?>
                </div>
                
                <div class="terminal-text text-light">
                    <p>
                        <strong>LOG ENTRY:</strong> The system is functioning within normal parameters. 
                        Use this section for lore dumps, code snippets, or narrative content that needs to feel "in-universe."
                    </p>
                    <p class="mb-0 text-white-50 small">
                        Verify your vector coordinates before proceeding.
                    </p>
                </div>
                
                <p class="mb-0 text-end fw-bold blink-text text-success mt-3">
                    // END TRANSMISSION //
                </p>
            </div>

        </div>
    </div>

</div>