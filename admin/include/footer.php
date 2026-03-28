<!-- C:\xamppnew\htdocs\rkhospital\admin\include\footer.php -->
<?php

// Usage: set $extraJS before including this file for page-specific scripts
// Example: $extraJS = '<script src="..."></script>';
?>

        <?php if (!empty($extraJS)) echo $extraJS; ?>

        <!-- jQuery -->
        <script src="<?= $assetBase ?? '' ?>assets/js/jquery-3.7.1.min.js"></script>

        <!-- Bootstrap Core JS -->
        <script src="<?= $assetBase ?? '' ?>assets/js/bootstrap.bundle.min.js"></script>

        <!-- Slimscroll JS -->
        <script src="<?= $assetBase ?? '' ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Custom JS -->
        <script src="<?= $assetBase ?? '' ?>assets/js/script.js"></script>

    </div>
    <!-- /Main Wrapper -->

</body>
</html>
