<?php
// includes/footer.php
// Template Footer
// Automatically updates the year and site name.

// Ensure $cdn_root is available (fallback if header didn't set it)
$cdn_root = $cdn_root ?? 'https://assets.raggiesoft.com';
?>

<footer class="mt-auto py-5 border-top">
    <div class="container text-center">
        
        <h2 class="h4 fw-bold text-uppercase">
            <?php echo htmlspecialchars($siteName ?? 'My Website'); ?>
        </h2>
        
        <p class="mt-2 text-body-secondary">
            Powered by the Elara Router.
        </p>

        <p class="mt-4 small text-body-secondary">
            &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($siteName ?? 'My Website'); ?>. All Rights Reserved.
            <br>
            <a href="/license" class="link-secondary text-decoration-none">Privacy & Terms</a>
        </p>

        <div class="mt-4 d-flex justify-content-center gap-4">
            <a href="#" aria-label="GitHub" class="link-secondary fs-4">
                <i class="fa-brands fa-github"></i>
            </a>
            <a href="#" aria-label="Twitter" class="link-secondary fs-4">
                <i class="fa-brands fa-twitter"></i>
            </a>
        </div>
        
    </div>
</footer>

<script src="<?php echo $cdn_root; ?>/common/js/bootstrap.js"></script>

</body>
</html>