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

// Fetch published doctors for submenu
$_navDoctors = [];
$_navDoctorsRes = $conn->query("SELECT name, slug, designation, photo FROM doctors WHERE is_published = 1 ORDER BY name ASC LIMIT 8");
if ($_navDoctorsRes) {
    while ($_navDr = $_navDoctorsRes->fetch_assoc()) {
        $_navDoctors[] = $_navDr;
    }
}
?>
<!-- Doctors dropdown — refined UI -->
<style>
/* ── Parent menu item ── */
.main-nav .has-submenu {
    position: relative;
}

/* ── Dropdown container (CENTER aligned under Doctors) ── */
.main-nav .has-submenu .submenu.sub-menu-default {
    position: absolute !important;
    top: 100% !important;

    left: 50% !important;
    /* center under title */
    transform: translateX(-50%) translateY(6px);

    margin-top: 0 !important;
    /* remove gap */

    min-width: 240px !important;
    max-width: 270px !important;
    padding: 6px 0 !important;

    border-radius: 12px !important;
    box-shadow: 0 8px 30px rgba(0, 0, 0, .12) !important;
    border: 1px solid #ebebeb !important;
    background: #fff !important;

    opacity: 0;
    visibility: hidden;
    transition: all 0.18s ease;
    z-index: 999;
}

/* ── Show dropdown ── */
.main-nav .has-submenu:hover .submenu.sub-menu-default {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}

/* 🔥 Invisible hover bridge (prevents vanish issue) */
.main-nav .has-submenu::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    height: 12px;
}

/* ── Divider between items ── */
.main-nav .has-submenu .submenu.sub-menu-default>li {
    padding: 0 !important;
    margin: 0 !important;
    border-bottom: 1px solid #f4f4f4 !important;
}

.main-nav .has-submenu .submenu.sub-menu-default>li:last-child {
    border-bottom: none !important;
}

/* ── Each row link ── */
.main-nav .has-submenu .submenu.sub-menu-default>li>a {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    padding: 8px 14px !important;
    text-align: left !important;
    text-decoration: none !important;
    transition: background .15s ease !important;
    background: transparent !important;
    color: inherit !important;
}

.main-nav .has-submenu .submenu.sub-menu-default>li>a:hover {
    background: #f0f4ff !important;
}

.main-nav .has-submenu .submenu.sub-menu-default>li>a:hover strong {
    color: #2563eb !important;
}

/* ── Avatar ── */
.main-nav .has-submenu .submenu.sub-menu-default>li>a .rk-nav-avatar {
    width: 36px !important;
    height: 36px !important;
    border-radius: 50% !important;
    object-fit: cover !important;
    flex-shrink: 0 !important;
    border: 2px solid #e8eaf6 !important;
}

/* ── Text block ── */
.main-nav .has-submenu .submenu.sub-menu-default>li>a .rk-nav-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
    text-align: left;
}

.main-nav .has-submenu .submenu.sub-menu-default>li>a .rk-nav-info strong {
    display: block;
    font-size: .83rem !important;
    font-weight: 600 !important;
    color: #1a1a2e !important;
    line-height: 1.3 !important;
    transition: color .15s;
}

.main-nav .has-submenu .submenu.sub-menu-default>li>a .rk-nav-info small {
    display: block;
    font-size: .72rem !important;
    color: #8a8a9a !important;
    line-height: 1.2 !important;
    font-weight: 400 !important;
}

/* ── Logo Fix (Smaller + Proper Alignment) ── */
.navbar-brand.logo {
    display: flex;
    align-items: center;
    padding: 0 !important;
}

.navbar-brand.logo img {
    height: 55px !important;   /* 🔥 reduced from 80px */
    width: auto !important;
    max-width: 100% !important;
    object-fit: contain;
}

/* Optional: adjust navbar height balance */
.header-nav {
    min-height: 70px;
    display: flex;
    align-items: center;
}

/* Mobile Fix */
@media (max-width: 575.98px) {
    .navbar-brand.logo img {
        height: 40px !important;
    }
}
</style>
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
                    <img src="<?= $_base ?>assets/img/rk-hospital-best-hospital-in-nagpur.png" class="img-fluid" alt="RK Hospital">
                </a>
            </div>

            <!-- Main Nav -->
            <div class="header-menu">
                <div class="main-menu-wrapper">

                    <!-- Mobile drawer header -->
                    <div class="menu-header">
                        <a href="<?= $_base ?>" class="menu-logo">
                            <img src="<?= $_base ?>assets/img/rk-hospital-best-hospital-in-nagpur.png" class="img-fluid" alt="RK Hospital">
                        </a>
                        <a id="menu_close" class="menu-close" href="javascript:void(0);">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>

                    <ul class="main-nav">

                        <li<?= navActive('home') ?>>
                            <a href="<?= $_base ?>">Home</a>
                            </li>

                            <li class="has-submenu<?= strpos($_uri, '#') !== false ? ' active' : '' ?>">
                                <a href="<?= $_base ?>#">
                                    Doctors <span><i class="fa-solid fa-chevron-down"></i></span>
                                </a>
                                <?php if (!empty($_navDoctors)): ?>
                                <ul class="submenu sub-menu-one sub-menu-default">
                                    <?php foreach ($_navDoctors as $_dr): ?>
                                    <li>
                                        <a href="<?= $_base ?>doctors/<?= htmlspecialchars($_dr['slug']) ?>">
                                            <img src="<?= $_base . htmlspecialchars($_dr['photo']) ?>"
                                                alt="<?= htmlspecialchars($_dr['name']) ?>" class="rk-nav-avatar"
                                                onerror="this.src='<?= $_base ?>assets/img/doctors/default.jpg'">
                                            <span class="rk-nav-info">
                                                <strong><?= htmlspecialchars($_dr['name']) ?></strong>
                                                <?php if (!empty($_dr['designation'])): ?>
                                                <small><?= htmlspecialchars($_dr['designation']) ?></small>
                                                <?php endif; ?>
                                            </span>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
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