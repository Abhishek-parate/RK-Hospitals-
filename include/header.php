<?php
/**
 * include/header.php — RK Hospital shared navbar
 * Pages can set $headerClass before including to switch style.
 *   Inner pages:  $headerClass = 'header-default inner-header';
 *   Homepage:     (leave unset — defaults to 'header-fixed')
 */

$_base        = rtrim(SITE_URL, '/') . '/';
$_headerClass = $headerClass ?? 'header-fixed';

// Auto-detect active nav item from URI
$_uri = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

function navActive(string $segment): string {
    global $_uri;
    if ($segment === 'home') {
        return preg_match('#/rkhospital/?$#', $_uri) ? ' class="active"' : '';
    }
    return (strpos($_uri, '/' . $segment) !== false) ? ' class="active"' : '';
}
?>
<!-- Header -->
<header class="header <?= $_headerClass ?>">
    <div class="container">
        <nav class="navbar navbar-expand-lg header-nav">

            <!-- Logo / Mobile Toggle -->
            <div class="navbar-header">
                <a id="mobile_btn" href="javascript:void(0);">
                    <i class="fa-solid fa-bars"></i>
                </a>
                <a href="<?= $_base ?>" class="navbar-brand logo">
                    <img src="<?= $_base ?>assets/img/RK-Logo.png" class="img-fluid" alt="RK Hospital">
                </a>
            </div>

            <!-- Main Nav -->
            <div class="header-menu">
                <div class="main-menu-wrapper">

                    <!-- Mobile drawer header -->
                    <div class="menu-header">
                        <a href="<?= $_base ?>" class="menu-logo">
                            <img src="<?= $_base ?>assets/img/RK-Logo.png" class="img-fluid" alt="RK Hospital">
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
                    <a href="<?= $_base ?>contact-us" class="btn btn-md btn-primary-gradient d-none d-lg-inline-block">
                        <i class="isax isax-calendar-edit me-2"></i><span>Book Appointment</span>
                    </a>
                </li>
            </ul>

        </nav>
    </div>
</header>
<!-- /Header -->
