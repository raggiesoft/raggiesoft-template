<?php
// includes/footer.php
// RaggieSoft "Elara" Footer (Standard Edition)
?>
    <footer class="mt-auto py-5 border-top">
        <div class="container text-center">
            <h4 class="h6 fw-bold text-uppercase text-body-secondary mb-3">
                <?php echo htmlspecialchars($siteConfig['name'] ?? 'RaggieSoft'); ?>
            </h4>
            
            <p class="small text-muted mb-4">
                &copy; <?php echo date('Y'); ?>. All rights reserved.
                <br>
                Powered by the Elara Router.
            </p>
        </div>
    </footer>

    <script src="https://assets.raggiesoft.com/common/js/bootstrap.js"></script>

</body>
</html>