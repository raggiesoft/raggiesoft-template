<?php
// public/errors/500.php
// Context: Critical Application Error

$is_standalone = !defined('ROOT_PATH');

if ($is_standalone) {
    define('ROOT_PATH', realpath(__DIR__ . '/../../'));
    http_response_code(500);
    
    $siteConfig = [
        'name' => 'Error',
        'cdn_root' => 'https://assets.raggiesoft.com',
        'slug' => 'common'
    ];
    $pageTitle = "500 Internal Error";
    
    // Wrap header load in try/catch because 500s often mean PHP is broken
    try {
        require_once ROOT_PATH . '/includes/header.php';
    } catch (Throwable $e) {
        echo "<h1>Critical System Error</h1><p>The layout could not be loaded.</p>";
        exit;
    }
    echo '<div class="container-fluid flex-grow-1 d-flex"><div class="row flex-grow-1"><main id="main-content" class="col-12 p-0">';
}
?>

<div class="container py-5 d-flex flex-column justify-content-center min-vh-75">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            
            <div class="mb-4">
                <i class="fa-duotone fa-bug display-1 text-danger"></i>
            </div>

            <h1 class="display-1 fw-bold text-danger mb-2">500</h1>
            <h2 class="h4 text-muted text-uppercase mb-4">Internal Server Error</h2>
            
            <div class="card bg-body-tertiary border-danger border-opacity-25 shadow-sm mb-5 text-start">
                <div class="card-body p-4">
                    <h5 class="card-title text-danger fw-bold">
                        <i class="fa-duotone fa-triangle-exclamation me-2"></i>System Failure
                    </h5>
                    <p class="card-text text-secondary mb-0">
                        The server encountered an internal error and was unable to complete your request. Please try refreshing the page in a few moments.
                    </p>
                </div>
            </div>
            
            <a href="/" class="btn btn-outline-danger rounded-pill px-4">
                <i class="fa-duotone fa-rotate-right me-2"></i>Try Again
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