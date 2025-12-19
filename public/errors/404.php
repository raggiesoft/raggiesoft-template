<?php
// public/errors/404.php
// Context: "Signal Lost"

$is_standalone = !defined('ROOT_PATH');

if ($is_standalone) {
    define('ROOT_PATH', realpath(__DIR__ . '/../../'));
    http_response_code(404);
    $pageTitle = "404 Page Not Found";
    $pageTheme = "light"; 
    require_once ROOT_PATH . '/includes/header.php';
    echo '<div class="container-fluid flex-grow-1 d-flex"><div class="row flex-grow-1"><main id="main-content" class="col-12 p-0">';
}
?>

<div class="container py-5 d-flex flex-column justify-content-center min-vh-75">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            <div class="mb-4">
                <i class="fa-duotone fa-file-circle-xmark display-1 text-secondary opacity-50"></i>
            </div>
            <h1 class="display-1 fw-bold text-secondary mb-0">404</h1>
            <h2 class="h4 text-uppercase text-muted letter-spacing-1 mb-4">Page Not Found</h2>
            
            <p class="lead mb-4">
                The requested coordinates do not exist on this chart.
            </p>

            <div class="d-flex justify-content-center gap-3">
                <a href="/" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="fa-duotone fa-house me-2"></i>Return Home
                </a>
                <button onclick="history.back()" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa-duotone fa-arrow-left me-2"></i>Go Back
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