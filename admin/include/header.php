<?php
$adminName   = $_SESSION['admin_name']  ?? 'Ryan Taylor';
$adminRole   = $_SESSION['admin_role']  ?? 'Administrator';
$adminAvatar = SITE_URL . '/admin/assets/img/profiles/avatar-01.jpg';
?>
<!-- Header -->
<div class="header">

    <!-- Logo -->
    <div class="header-left">
        <a href="<?= SITE_URL ?>/admin/index.php" class="logo">
            <img src="<?= SITE_URL ?>/admin/assets/img/logo.png" alt="Logo">
        </a>
        <a href="<?= SITE_URL ?>/admin/index.php" class="logo logo-small">
            <img src="<?= SITE_URL ?>/admin/assets/img/logo-small.png" alt="Logo" width="30" height="30">
        </a>
    </div>

    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fe fe-text-align-left"></i>
    </a>

    <!-- Search Bar -->
    <div class="top-nav-search">
        <form onsubmit="return false;">
            <input type="text" id="menuSearch" class="form-control" placeholder="Search here" autocomplete="off">
            <button class="btn" type="button"><i class="fa fa-search"></i></button>
        </form>
    </div>

    <!-- Mobile Menu Toggle -->
    <a class="mobile_btn" id="mobile_btn">
        <i class="fa fa-bars"></i>
    </a>

    <!-- Header Right Menu -->
    <ul class="nav user-menu">

        <!-- Notifications -->
        <li class="nav-item dropdown noti-dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <i class="fe fe-bell"></i> <span class="badge rounded-pill">3</span>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        <li class="notification-message">
                            <a href="#">
                                <div class="notify-block d-flex">
                                    <span class="avatar avatar-sm flex-shrink-0">
                                        <img class="avatar-img rounded-circle" src="<?= SITE_URL ?>/admin/assets/img/doctors/doctor-thumb-01.jpg" alt="">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details"><span class="noti-title">Dr. R.K. Agrawal</span> profile updated</p>
                                        <p class="noti-time"><span class="notification-time">5 mins ago</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>

        <!-- User Menu -->
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="<?= $adminAvatar ?>" width="31" alt="<?= htmlspecialchars($adminName) ?>">
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="<?= $adminAvatar ?>" alt="User" class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <h6><?= htmlspecialchars($adminName) ?></h6>
                        <p class="text-muted mb-0"><?= htmlspecialchars($adminRole) ?></p>
                    </div>
                </div>
                <a class="dropdown-item" href="<?= SITE_URL ?>/admin/users/index.php">My Profile</a>
                <a class="dropdown-item" href="<?= SITE_URL ?>/admin/logout.php">Logout</a>
            </div>
        </li>

    </ul>
    <!-- /Header Right Menu -->

</div>
<!-- /Header -->
