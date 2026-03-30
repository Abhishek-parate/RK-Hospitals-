    <!-- jQuery -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>

    <!-- Sidebar Menu Search -->
    <script>
    (function () {
        var input = document.getElementById('menuSearch');
        if (!input) return;

        input.addEventListener('input', function () {
            var q = this.value.trim().toLowerCase();
            var menu = document.getElementById('sidebar-menu');
            if (!menu) return;

            // All top-level <li> inside the main <ul>
            var items = menu.querySelectorAll('#sidebar-menu > ul > li');

            items.forEach(function (li) {
                if (li.classList.contains('menu-title')) {
                    // Always show section titles; hide later if all siblings are hidden
                    li.style.display = '';
                    return;
                }

                if (!q) {
                    li.style.display = '';
                    // Collapse any open submenus back
                    var sub = li.querySelector('ul');
                    if (sub) sub.style.display = 'none';
                    return;
                }

                // Check if this item or any of its children match
                var text = li.innerText.toLowerCase();
                var matched = text.indexOf(q) !== -1;

                li.style.display = matched ? '' : 'none';

                // If submenu parent matched, expand it so children are visible
                if (matched && li.classList.contains('submenu')) {
                    var sub = li.querySelector('ul');
                    if (sub) sub.style.display = 'block';
                }
            });

            // Hide section titles that have no visible siblings below them
            if (q) {
                var allLi = menu.querySelectorAll('#sidebar-menu > ul > li');
                allLi.forEach(function (li, idx) {
                    if (!li.classList.contains('menu-title')) return;
                    // Look for a visible non-title item before the next title
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

</body>
</html>
