<?php
// public/errors/504.php
// Context: Upstream Timeout

$is_standalone = !defined('ROOT_PATH');

if ($is_standalone) {
    define('ROOT_PATH', realpath(__DIR__ . '/../../'));
    http_response_code(504);
    
    $siteConfig = [ 'name' => 'Error', 'cdn_root' => 'https://assets.raggiesoft.com', 'slug' => 'common' ];
    $pageTitle = "504 Timeout";
    
    require_once ROOT_PATH . '/includes/header.php';
    echo '<div class="container-fluid flex-grow-1 d-flex"><div class="row flex-grow-1"><main id="main-content" class="col-12 p-0">';
}
?>

<div class="container py-5 d-flex flex-column justify-content-center min-vh-75">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            
            <div class="mb-4">
                <i class="fa-duotone fa-hourglass-clock display-1 text-secondary opacity-50"></i>
            </div>

            <h1 class="display-1 fw-bold text-body-emphasis mb-2">504</h1>
            <h2 class="h4 text-muted text-uppercase mb-4">Gateway Timeout</h2>
            
            <p class="lead text-secondary mb-5">
                The upstream server failed to send a request in the time allowed. The operation may have taken too long to complete.
            </p>
            
            <div class="d-flex justify-content-center gap-3">
                <button onclick="location.reload()" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="fa-duotone fa-rotate-right me-2"></i>Retry
                </button>
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