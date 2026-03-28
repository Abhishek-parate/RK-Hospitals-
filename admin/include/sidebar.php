<?php
// Pass $activePage = 'blank-page' before including this file
$activePage = isset($activePage) ? $activePage : '';

function sidebarLink($label, $href, $icon, $active) {
    $cls = ($active === $href) ? ' class="active"' : '';
    echo "<li{$cls}><a href=\"{$href}\"><i class=\"fe fe-{$icon}\"></i> <span>{$label}</span></a></li>";
}
?>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li class="menu-title"><span>Main</span></li>
                <?php sidebarLink('Dashboard',     'index.php',            'home',      $activePage); ?>
                <?php sidebarLink('Appointments',  'appointment-list.php', 'layout',    $activePage); ?>
                <?php sidebarLink('Specialities',  'specialities.php',     'users',     $activePage); ?>
                <?php sidebarLink('Doctors', 'doctors/index.php', 'user-plus', $activePage); ?>
                <?php sidebarLink('Patients',      'patient-list.php',     'user',      $activePage); ?>
                <?php sidebarLink('Reviews',       'reviews.php',          'star-o',    $activePage); ?>
                <?php sidebarLink('Transactions',  'transactions-list.php','activity',  $activePage); ?>
                <?php sidebarLink('Settings',      'settings.php',         'vector',    $activePage); ?>

                <!-- Reports submenu -->
                <li class="submenu <?php echo ($activePage === 'invoice-report.php') ? 'active' : ''; ?>">
                    <a href="#"><i class="fe fe-document"></i> <span>Reports</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li <?php echo ($activePage === 'invoice-report.php') ? 'class="active"' : ''; ?>>
                            <a href="invoice-report.php">Invoice Reports</a>
                        </li>
                    </ul>
                </li>

                <li class="menu-title"><span>Pages</span></li>
                <?php sidebarLink('Profile', 'profile.php', 'user-plus', $activePage); ?>

                <!-- Authentication submenu -->
                <li class="submenu">
                    <a href="#"><i class="fe fe-document"></i> <span>Authentication</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                        <li><a href="forgot-password.php">Forgot Password</a></li>
                        <li><a href="lock-screen.php">Lock Screen</a></li>
                    </ul>
                </li>

                <!-- Error Pages submenu -->
                <li class="submenu">
                    <a href="#"><i class="fe fe-warning"></i> <span>Error Pages</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="error-404.php">404 Error</a></li>
                        <li><a href="error-500.php">500 Error</a></li>
                    </ul>
                </li>

                <?php sidebarLink('Blank Page', 'blank-page.php', 'file', $activePage); ?>

                <li class="menu-title"><span>UI Interface</span></li>
                <?php sidebarLink('Components', 'components.php', 'vector', $activePage); ?>

                <!-- Forms submenu -->
                <li class="submenu">
                    <a href="#"><i class="fe fe-layout"></i> <span>Forms</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="form-basic-inputs.php">Basic Inputs</a></li>
                        <li><a href="form-input-groups.php">Input Groups</a></li>
                        <li><a href="form-horizontal.php">Horizontal Form</a></li>
                        <li><a href="form-vertical.php">Vertical Form</a></li>
                        <li><a href="form-mask.php">Form Mask</a></li>
                        <li><a href="form-validation.php">Form Validation</a></li>
                    </ul>
                </li>

                <!-- Tables submenu -->
                <li class="submenu">
                    <a href="#"><i class="fe fe-table"></i> <span>Tables</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="tables-basic.php">Basic Tables</a></li>
                        <li><a href="data-tables.php">Data Table</a></li>
                    </ul>
                </li>

                <!-- Multi Level submenu -->
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fe fe-code"></i> <span>Multi Level</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li class="submenu">
                            <a href="javascript:void(0);"><span>Level 1</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="javascript:void(0);">Level 2</a></li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"><span>Level 2</span> <span
                                            class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="javascript:void(0);">Level 3</a></li>
                                        <li><a href="javascript:void(0);">Level 3</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0);">Level 2</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0);">Level 1</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->