<?php
// public/errors/403.php
// Context: Access Denied / Forbidden

$is_standalone = !defined('ROOT_PATH');

if ($is_standalone) {
    define('ROOT_PATH', realpath(__DIR__ . '/../../'));
    http_response_code(403);
    
    // Fallback Config for Header (Required if Router didn't load)
    $siteConfig = [
        'name' => 'Error',
        'cdn_root' => 'https://assets.raggiesoft.com',
        'slug' => 'common' // Uses common assets if site slug is unknown
    ];
    $pageTitle = "403 Access Denied";
    
    require_once ROOT_PATH . '/includes/header.php';
    echo '<div class="container-fluid flex-grow-1 d-flex"><div class="row flex-grow-1"><main id="main-content" class="col-12 p-0">';
}
?>

<div class="container py-5 d-flex flex-column justify-content-center min-vh-75">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            
            <div class="mb-4">
                <i class="fa-duotone fa-shield-xmark display-1 text-warning"></i>
            </div>

            <h1 class="display-1 fw-bold text-body-emphasis mb-2">403</h1>
            <h2 class="h4 text-muted text-uppercase mb-4">Access Denied</h2>
            
            <div class="card bg-body-tertiary border-0 shadow-sm mb-5 text-start">
                <div class="card-body p-4">
                    <h5 class="card-title text-warning fw-bold">
                        <i class="fa-duotone fa-lock me-2"></i>Permission Restricted
                    </h5>
                    <p class="card-text text-secondary mb-0">
                        You do not have the necessary permissions to view this resource. If you believe this is an error, please contact the site administrator or attempt to log in.
                    </p>
                </div>
            </div>
            
            <a href="/" class="btn btn-primary rounded-pill px-4">
                <i class="fa-duotone fa-house me-2"></i>Return Home
            </a>

        </div>
    </div>
</div>

<?php
if ($is_standalone) {
    echo '</main></div></div>';
    require_once ROOT_PATH . '/includes/footer.php';
}
?>