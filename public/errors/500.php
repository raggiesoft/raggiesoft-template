<?php
// public/errors/500.php
// Context: "Critical Engine Stall"

$is_standalone = !defined('ROOT_PATH');

// Retrieve Context
$errorType = $config['error_type'] ?? 'general';
$errorDetails = $config['error_details'] ?? 'An unexpected condition was encountered.';

$isCollision = ($errorType === 'collision');
$errorTitle = $isCollision ? 'Configuration Error' : 'System Error';
$errorIcon = $isCollision ? 'fa-shuffle' : 'fa-triangle-exclamation';

if ($is_standalone) {
    define('ROOT_PATH', realpath(__DIR__ . '/../../'));
    http_response_code(500);
    $pageTitle = "500 Server Error";
    require_once ROOT_PATH . '/includes/header.php';
    echo '<div class="container-fluid flex-grow-1 d-flex"><div class="row flex-grow-1"><main id="main-content" class="col-12 p-0">';
}
?>

<div class="container py-5 d-flex flex-column justify-content-center min-vh-75">
    <div class="row justify-content-center text-center">
        <div class="col-lg-8">
            
            <div class="mb-4">
                <i class="fa-duotone <?php echo $errorIcon; ?> display-1 text-danger opacity-75"></i>
            </div>

            <h1 class="display-1 fw-bold text-danger mb-0">500</h1>
            <h2 class="h4 text-uppercase text-muted letter-spacing-1 mb-4">
                <?php echo $errorTitle; ?>
            </h2>
            
            <div class="card bg-light border-danger text-start mb-5 mx-auto shadow-sm" style="max-width: 600px;">
                <div class="card-header bg-danger text-white font-monospace">
                    <i class="fa-solid fa-bug me-2"></i> Diagnostic Report
                </div>
                <div class="card-body font-monospace text-dark">
                    <p class="mb-0">
                        <?php echo $errorDetails; ?>
                    </p>
                </div>
            </div>
            
            <div class="d-flex justify-content-center gap-3">
                <a href="/" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa-duotone fa-power-off me-2"></i>System Restart
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