<?php
// pages/templates/sidebar-page.php
// Theme: Corporate / Standard
// Context: Documentation or Case Study
// Requirement: Set 'showSidebar' => true in public/index.php route config.
?>

<div class="container-fluid py-4">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Current Page</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12">
            
            <h1 class="display-5 fw-bold text-primary border-bottom border-primary pb-2 mb-4">
                Sidebar Page Template
            </h1>
            
            <p class="lead text-secondary mb-5">
                This layout is optimized for dense information. The navigation lives on the left (handled by the Router), leaving this area free for content.
            </p>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card h-100 border-secondary bg-transparent">
                        <div class="card-body">
                            <h3 class="h5 text-secondary fw-bold"><i class="fa-duotone fa-layer-group me-2"></i>Structural Element</h3>
                            <p class="small text-muted mb-0">
                                This template uses <code>container-fluid</code> to maximize the available space next to the sidebar. Perfect for dashboards or long-form reading.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card h-100 border-secondary bg-transparent">
                        <div class="card-body">
                            <h3 class="h5 text-secondary fw-bold"><i class="fa-duotone fa-code me-2"></i>Responsive Design</h3>
                            <p class="small text-muted mb-0">
                                On mobile devices, the sidebar automatically collapses or disappears (depending on your CSS), and this content expands to fill the screen.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>