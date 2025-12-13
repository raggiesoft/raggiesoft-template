<?php
// pages/templates/default.php
// Theme: Corporate / Standard
// Context: Generic Content Page

// Page Metadata (Optional Override)
// $pageTitle = "Standard Page Template";
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-2">
                    Standard Page Title
                </h1>
                <p class="lead text-secondary">
                    A concise subtitle that explains the page's purpose.
                </p>
            </div>

            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body p-4 p-md-5">
                    <h2 class="h4 fw-bold text-body mb-3">Primary Content Area</h2>
                    <p class="text-muted mb-4">
                        This is a standard content block. It uses the default Bootstrap spacing and typography settings defined in <code>root.css</code>.
                    </p>
                    
                    <h3 class="h5 fw-bold text-body mt-4 mb-2">Sub-Section Header</h3>
                    <p class="text-muted">
                        Use this template for documentation, privacy policies, or simple informational pages that don't require complex layouts.
                    </p>
                    
                    <div class="alert alert-info border-info mt-4">
                        <i class="fa-duotone fa-circle-info me-2"></i>
                        <strong>Pro Tip:</strong> You can copy this file to <code>/pages/new-page.php</code> and the router will automatically serve it at <code>/new-page</code>.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>