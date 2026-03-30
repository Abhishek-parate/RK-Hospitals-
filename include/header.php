<?php
/**
 * include/header.php — RK Hospital public navbar
 * Uses SITE_URL from config.php. Detects active nav item from REQUEST_URI.
 */

$_base = rtrim(SITE_URL, '/') . '/';

// Detect active nav item
$_uri = strtok($_SERVER['REQUEST_URI'], '?');
$_uri = rtrim($_uri, '/');

function navActive(string $segment): string {
    global $_uri;
    if ($segment === 'home') {
        return preg_match('#/rkhospital/?$#', $_uri) ? ' class="active"' : '';
    }
    return (strpos($_uri, '/' . $segment) !== false) ? ' class="active"' : '';
}
?>
<!-- Header -->
<header class="header header-fixed">
    <div class="container">
        <nav class="navbar navbar-expand-lg header-nav">

            <!-- Logo / Mobile Toggle -->
            <div class="navbar-header">
                <a id="mobile_btn" href="javascript:void(0);">
                    <span class="bar-icon">
                        <span></span><span></span><span></span>
                    </span>
                </a>
                <a href="<?= $_base ?>" class="navbar-brand logo">
                    <img src="<?= $_base ?>assets/img/logo.svg" class="img-fluid" alt="RK Hospital">
                </a>
            </div>

            <!-- Main Nav -->
            <div class="header-menu">
                <div class="main-menu-wrapper">

                    <!-- Mobile header inside drawer -->
                    <div class="menu-header">
                        <a href="<?= $_base ?>" class="menu-logo">
                            <img src="<?= $_base ?>assets/img/logo.svg" class="img-fluid" alt="RK Hospital">
                        </a>
                        <a id="menu_close" class="menu-close" href="javascript:void(0);">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>

                    <ul class="main-nav">

                        <li<?= navActive('home') ?>>
                            <a href="<?= $_base ?>">Home</a>
                        </li>

                        <li<?= navActive('doctors') ?>>
                            <a href="<?= $_base ?>doctors">Doctors</a>
                        </li>

                        <li<?= navActive('service') ?>>
                            <a href="<?= $_base ?>services">Services</a>
                        </li>

                        <li<?= navActive('blog') ?>>
                            <a href="<?= $_base ?>blogs">Blogs</a>
                        </li>

                        <li<?= navActive('about') ?>>
                            <a href="<?= $_base ?>about-us">About Us</a>
                        </li>

                        <li<?= navActive('contact') ?>>
                            <a href="<?= $_base ?>contact-us">Contact</a>
                        </li>

                    </ul>
                </div>
            </div>

            <!-- Right CTA -->
            <ul class="nav header-navbar-rht">
                <li>
                    <a href="<?= $_base ?>contact-us" class="btn btn-primary theme-5-btn">
                        <span class="icon"><i class="isax isax-calendar-edit me-2"></i></span>
                        <span>Book Appointment</span>
                    </a>
                </li>
            </ul>

        </nav>
    </div>
</header>
<!-- /Header -->
