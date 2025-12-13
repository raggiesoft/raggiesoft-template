<?php
// public/errors/404.php
// Context: Page Not Found

$is_standalone = !defined('ROOT_PATH');

if ($is_standalone) {
    define('ROOT_PATH', realpath(__DIR__ . '/../../'));
    http_response_code(404);
    
    $siteConfig = [
        'name' => 'Error',
        'cdn_root' => 'https://assets.raggiesoft.com',
        'slug' => 'common'
    ];
    $pageTitle = "404 Not Found";
    
    require_once ROOT_PATH . '/includes/header.php';
    echo '<div class="container-fluid flex-grow-1 d-flex"><div class="row flex-grow-1"><main id="main-content" class="col-12 p-0">';
}
?>

<div class="container py-5 d-flex flex-column justify-content-center min-vh-75">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            
            <div class="mb-4">
                <i class="fa-duotone fa-compass-slash display-1 text-secondary opacity-50"></i>
            </div>

            <h1 class="display-1 fw-bold text-body-emphasis mb-2">404</h1>
            <h2 class="h4 text-muted text-uppercase mb-4">Page Not Found</h2>
            
            <p class="lead text-secondary mb-5">
                The requested URL <code><?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? ''); ?></code> was not found on this server. It may have been moved or deleted.
            </p>
            
            <div class="d-flex justify-content-center gap-3">
                <a href="/" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa-duotone fa-arrow-left me-2"></i>Home
                </a>
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