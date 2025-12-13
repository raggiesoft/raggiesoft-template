<?php
// public/errors/502.php
// Context: Upstream Error (PHP-FPM down)

$is_standalone = !defined('ROOT_PATH');

if ($is_standalone) {
    define('ROOT_PATH', realpath(__DIR__ . '/../../'));
    http_response_code(502);
    
    $siteConfig = [ 'name' => 'Error', 'cdn_root' => 'https://assets.raggiesoft.com', 'slug' => 'common' ];
    $pageTitle = "502 Bad Gateway";
    
    require_once ROOT_PATH . '/includes/header.php';
    echo '<div class="container-fluid flex-grow-1 d-flex"><div class="row flex-grow-1"><main id="main-content" class="col-12 p-0">';
}
?>

<div class="container py-5 d-flex flex-column justify-content-center min-vh-75">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            
            <div class="mb-4">
                <i class="fa-duotone fa-server display-1 text-secondary opacity-50"></i>
            </div>

            <h1 class="display-1 fw-bold text-body-emphasis mb-2">502</h1>
            <h2 class="h4 text-muted text-uppercase mb-4">Bad Gateway</h2>
            
            <p class="lead text-secondary mb-5">
                The server received an invalid response from the upstream server. This usually indicates a temporary restart or a connectivity issue.
            </p>
            
            <button onclick="location.reload()" class="btn btn-primary rounded-pill px-4">
                <i class="fa-duotone fa-rotate me-2"></i>Refresh Page
            </button>

        </div>
    </div>
</div>

<?php
if ($is_standalone) {
    echo '</main></div></div>';
    require_once ROOT_PATH . '/includes/footer.php';
}
?>