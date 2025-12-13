<?php
// public/errors/503.php
// Context: Maintenance Mode / Overload

$is_standalone = !defined('ROOT_PATH');

if ($is_standalone) {
    define('ROOT_PATH', realpath(__DIR__ . '/../../'));
    http_response_code(503);
    
    $siteConfig = [ 'name' => 'Error', 'cdn_root' => 'https://assets.raggiesoft.com', 'slug' => 'common' ];
    $pageTitle = "503 Maintenance";
    
    require_once ROOT_PATH . '/includes/header.php';
    echo '<div class="container-fluid flex-grow-1 d-flex"><div class="row flex-grow-1"><main id="main-content" class="col-12 p-0">';
}
?>

<div class="container py-5 d-flex flex-column justify-content-center min-vh-75">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            
            <div class="mb-4">
                <i class="fa-duotone fa-helmet-safety display-1 text-info"></i>
            </div>

            <h1 class="display-1 fw-bold text-info mb-2">503</h1>
            <h2 class="h4 text-muted text-uppercase mb-4">Service Unavailable</h2>
            
            <div class="card bg-body-tertiary border-info border-opacity-25 shadow-sm mb-5 text-start">
                <div class="card-body p-4">
                    <h5 class="card-title text-info fw-bold">
                        <i class="fa-duotone fa-screwdriver-wrench me-2"></i>Maintenance In Progress
                    </h5>
                    <p class="card-text text-secondary mb-0">
                        The server is currently unavailable due to maintenance or high load. Please check back shortly.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
if ($is_standalone) {
    echo '</main></div></div>';
    require_once ROOT_PATH . '/includes/footer.php';
}
?>