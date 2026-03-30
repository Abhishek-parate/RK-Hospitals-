<!-- C:\xamppnew\htdocs\rkhospital\admin\include\footer.php -->
<?php

// Usage: set $extraJS before including this file for page-specific scripts
// Example: $extraJS = '<script src="..."></script>';
?>

        <?php if (!empty($extraJS)) echo $extraJS; ?>

        <!-- jQuery -->
        <script src="<?= SITE_URL ?>/admin/assets/js/jquery-3.7.1.min.js"></script>
        <!-- Bootstrap Core JS -->
        <script src="<?= SITE_URL ?>/admin/assets/js/bootstrap.bundle.min.js"></script>
        <!-- Slimscroll JS -->
        <script src="<?= SITE_URL ?>/admin/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <!-- Custom JS -->
        <script src="<?= SITE_URL ?>/admin/assets/js/script.js"></script>

        <!-- Sidebar menu search -->
        <script>
        (function () {
            var input = document.getElementById('menuSearch');
            if (!input) return;
            input.addEventListener('input', function () {
                var q = this.value.trim().toLowerCase();
                var menu = document.getElementById('sidebar-menu');
                if (!menu) return;
                var items = menu.querySelectorAll('#sidebar-menu > ul > li');
                items.forEach(function (li) {
                    if (li.classList.contains('menu-title')) { li.style.display = ''; return; }
                    if (!q) {
                        li.style.display = '';
                        var sub = li.querySelector('ul');
                        if (sub && !li.classList.contains('active')) sub.style.display = 'none';
                        return;
                    }
                    var matched = li.innerText.toLowerCase().indexOf(q) !== -1;
                    li.style.display = matched ? '' : 'none';
                    if (matched && li.classList.contains('submenu')) {
                        var sub = li.querySelector('ul');
                        if (sub) sub.style.display = 'block';
                    }
                });
                if (q) {
                    var allLi = menu.querySelectorAll('#sidebar-menu > ul > li');
                    allLi.forEach(function (li, idx) {
                        if (!li.classList.contains('menu-title')) return;
                        var hasVisible = false;
                        for (var i = idx + 1; i < allLi.length; i++) {
                            if (allLi[i].classList.contains('menu-title')) break;
                            if (allLi[i].style.display !== 'none') { hasVisible = true; break; }
                        }
                        li.style.display = hasVisible ? '' : 'none';
                    });
                }
            });
        })();
        </script>

    </div>
    <!-- /Main Wrapper -->

</body>
</html>
