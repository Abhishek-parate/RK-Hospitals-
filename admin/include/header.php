<?php
$adminName   = $_SESSION['admin_name']  ?? 'Admin';
$adminRole   = $_SESSION['admin_role']  ?? 'Administrator';
$adminAvatar = SITE_URL . '/admin/assets/img/profiles/avatar-01.jpg';
$initials    = strtoupper(substr($adminName, 0, 1));
?>
<!-- ══ HEADER ══════════════════════════════════════════════════════════════ -->
<div class="header">

    <!-- Logo -->
    <div class="header-left">
        <a href="<?= SITE_URL ?>/admin/index.php" class="logo" style="text-decoration:none;display:flex;align-items:center;gap:11px;">
            <!-- Icon mark -->
            <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(79,70,229,.4);">
                <i class="fas fa-hospital-alt" style="color:#fff;font-size:15px;"></i>
            </div>
            <!-- Wordmark -->
            <div style="line-height:1.2;">
                <div style="font-size:15px;font-weight:700;color:#fff;letter-spacing:-.3px;">RK Hospital</div>
                <div style="font-size:10px;color:#4a5272;letter-spacing:.5px;text-transform:uppercase;font-weight:500;">Admin Panel</div>
            </div>
        </a>
    </div>

    <!-- Sidebar toggle -->
    <a href="javascript:void(0);" id="toggle_btn" title="Toggle sidebar">
        <i class="fe fe-align-left"></i>
    </a>

    <!-- Menu Search -->
    <div class="top-nav-search">
        <form onsubmit="return false;" role="search">
            <button class="btn" type="button" tabindex="-1" aria-label="Search">
                <i class="fa fa-search"></i>
            </button>
            <input type="text" id="menuSearch" class="form-control"
                   placeholder="Search menu…" autocomplete="off" aria-label="Search menu">
        </form>
    </div>

    <!-- Mobile toggle -->
    <a class="mobile_btn" id="mobile_btn" aria-label="Open menu">
        <i class="fa fa-bars"></i>
    </a>

    <!-- Right side -->
    <ul class="nav user-menu ms-auto">

        <!-- Notifications -->
        <li class="nav-item dropdown noti-dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown" aria-label="Notifications">
                <i class="fe fe-bell"></i>
                <span class="badge rounded-pill">2</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end notifications" style="min-width:330px;">
                <div class="topnav-dropdown-header d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0 fw-600" style="color:#fff;font-size:13.5px;">Notifications</p>
                        <p class="mb-0 text-xs" style="color:rgba(255,255,255,.65);">2 new alerts</p>
                    </div>
                    <a href="javascript:void(0)" class="clear-noti small">Clear all</a>
                </div>
                <div class="noti-content" style="max-height:270px;overflow-y:auto;">
                    <ul class="notification-list list-unstyled mb-0">
                        <li class="notification-message">
                            <a href="#" style="text-decoration:none;">
                                <div style="display:flex;gap:12px;align-items:flex-start;padding:12px 18px;">
                                    <div style="width:36px;height:36px;border-radius:50%;background:#eef2ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="fe fe-user-plus" style="color:#4f46e5;font-size:14px;"></i>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <p class="mb-1 text-sm" style="color:#111827;font-weight:500;">Doctor profile updated</p>
                                        <p class="mb-0 text-xs" style="color:#9ca3af;">Dr. R.K. Agrawal · 5 mins ago</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="#" style="text-decoration:none;">
                                <div style="display:flex;gap:12px;align-items:flex-start;padding:12px 18px;">
                                    <div style="width:36px;height:36px;border-radius:50%;background:#ecfdf5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="fe fe-edit" style="color:#10b981;font-size:14px;"></i>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <p class="mb-1 text-sm" style="color:#111827;font-weight:500;">New blog post published</p>
                                        <p class="mb-0 text-xs" style="color:#9ca3af;">Blog · 12 mins ago</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="topnav-dropdown-footer text-center">
                    <a href="#" style="font-size:12.5px;color:#4f46e5;font-weight:500;">View all notifications →</a>
                </div>
            </div>
        </li>

        <!-- User -->
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link d-flex align-items-center gap-2"
               data-bs-toggle="dropdown" style="height:var(--hdr-h,66px);padding:0 16px;">
                <!-- Avatar with gradient initials as fallback -->
                <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0;box-shadow:0 2px 8px rgba(79,70,229,.3);">
                    <?= $initials ?>
                </div>
                <div class="d-none d-lg-block" style="line-height:1.2;">
                    <div style="font-size:13px;font-weight:600;color:#111827;"><?= htmlspecialchars($adminName) ?></div>
                    <div class="text-xs" style="color:#9ca3af;"><?= htmlspecialchars($adminRole) ?></div>
                </div>
                <i class="fe fe-chevron-down d-none d-lg-block" style="font-size:12px;color:#9ca3af;margin-left:2px;"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end" style="min-width:210px;margin-top:8px;">
                <!-- Profile header -->
                <div style="padding:16px 18px;background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:14px 14px 0 0;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:42px;height:42px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:#fff;flex-shrink:0;">
                            <?= $initials ?>
                        </div>
                        <div>
                            <div style="font-size:14px;font-weight:600;color:#fff;"><?= htmlspecialchars($adminName) ?></div>
                            <div style="font-size:11px;color:rgba(255,255,255,.7);"><?= htmlspecialchars($adminRole) ?></div>
                        </div>
                    </div>
                </div>
                <!-- Menu items -->
                <a class="dropdown-item" href="<?= SITE_URL ?>/admin/users/index.php">
                    <i class="fe fe-user" style="color:#4f46e5;"></i> My Profile
                </a>
                <a class="dropdown-item" href="<?= SITE_URL ?>/admin/logout.php" style="color:#ef4444 !important;">
                    <i class="fe fe-log-out" style="color:#ef4444;"></i> Sign Out
                </a>
            </div>
        </li>

    </ul>
</div>
<!-- ══ /HEADER ═════════════════════════════════════════════════════════════ -->
