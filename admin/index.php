<?php
require_once __DIR__ . '/../include/config.php';

// ── Stats ─────────────────────────────────────────────────────────────────────
$totalDoctors   = (int)$conn->query("SELECT COUNT(*) AS c FROM doctors")->fetch_assoc()['c'];
$totalBlogs     = (int)$conn->query("SELECT COUNT(*) AS c FROM blogs")->fetch_assoc()['c'];
$publishedBlogs = (int)$conn->query("SELECT COUNT(*) AS c FROM blogs WHERE is_published=1")->fetch_assoc()['c'];
$totalUsers     = (int)$conn->query("SELECT COUNT(*) AS c FROM admin_users")->fetch_assoc()['c'];

$totalServices = 0;
$svcCheck = $conn->query("SHOW TABLES LIKE 'services'");
if ($svcCheck && $svcCheck->num_rows > 0) {
    $totalServices = (int)$conn->query("SELECT COUNT(*) AS c FROM services")->fetch_assoc()['c'];
}

// ── Recent data ───────────────────────────────────────────────────────────────
$recentDoctors = [];
$res = $conn->query("SELECT id, name, designation, photo FROM doctors ORDER BY id DESC LIMIT 6");
if ($res) while ($r = $res->fetch_assoc()) $recentDoctors[] = $r;

$recentBlogs = [];
$res = $conn->query("
    SELECT b.id, b.title, b.is_published, b.views, b.created_at, c.name AS category
    FROM blogs b LEFT JOIN categories c ON c.id = b.category_id
    ORDER BY b.created_at DESC LIMIT 6
");
if ($res) while ($r = $res->fetch_assoc()) $recentBlogs[] = $r;

$recentUsers = [];
$res = $conn->query("SELECT id, name, email, created_at FROM admin_users ORDER BY created_at DESC LIMIT 5");
if ($res) while ($r = $res->fetch_assoc()) $recentUsers[] = $r;

// ── Meta ──────────────────────────────────────────────────────────────────────
$pageTitle  = 'Dashboard';
$activePage = 'dashboard';
$assetBase  = '';

require_once __DIR__ . '/include/head.php';
?>

    <?php require_once __DIR__ . '/include/header.php'; ?>
    <?php require_once __DIR__ . '/include/sidebar.php'; ?>

    <!-- ══ PAGE WRAPPER ══════════════════════════════════════════════════════ -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- ── Page Header ── -->
            <div class="page-header">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h3 class="page-title">Dashboard</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Overview</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div style="background:#fff;border:1.5px solid #e5e9f2;border-radius:9px;padding:8px 14px;display:flex;align-items:center;gap:8px;box-shadow:0 1px 3px rgba(0,0,0,.04);">
                            <i class="fe fe-calendar" style="color:#4f46e5;font-size:14px;"></i>
                            <span style="font-size:13px;font-weight:500;color:#374151;"><?= date('d M Y') ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Stat Cards ── -->
            <div class="row g-3 mb-4">

                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card s-indigo">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="stat-icon si-indigo">
                                <i class="fe fe-user-plus"></i>
                            </div>
                            <span style="font-size:11px;font-weight:600;background:#eef2ff;color:#4f46e5;padding:3px 10px;border-radius:99px;">Doctors</span>
                        </div>
                        <div class="stat-value"><?= $totalDoctors ?></div>
                        <div class="stat-label">Total Doctors</div>
                        <div class="stat-progress mt-3">
                            <div class="stat-progress-bar" style="width:<?= min(100, $totalDoctors * 15) ?>%"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card s-emerald">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="stat-icon si-emerald">
                                <i class="fe fe-edit-2"></i>
                            </div>
                            <span style="font-size:11px;font-weight:600;background:#ecfdf5;color:#059669;padding:3px 10px;border-radius:99px;"><?= $publishedBlogs ?> live</span>
                        </div>
                        <div class="stat-value"><?= $totalBlogs ?></div>
                        <div class="stat-label">Total Blogs</div>
                        <div class="stat-progress mt-3">
                            <div class="stat-progress-bar" style="width:<?= $totalBlogs > 0 ? min(100, round(($publishedBlogs/$totalBlogs)*100)) : 0 ?>%"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card s-amber">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="stat-icon si-amber">
                                <i class="fe fe-briefcase"></i>
                            </div>
                            <span style="font-size:11px;font-weight:600;background:#fffbeb;color:#d97706;padding:3px 10px;border-radius:99px;">Services</span>
                        </div>
                        <div class="stat-value"><?= $totalServices ?></div>
                        <div class="stat-label">Total Services</div>
                        <div class="stat-progress mt-3">
                            <div class="stat-progress-bar" style="width:<?= min(100, $totalServices * 10) ?>%"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card s-cyan">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="stat-icon si-cyan">
                                <i class="fe fe-lock"></i>
                            </div>
                            <span style="font-size:11px;font-weight:600;background:#ecfeff;color:#0891b2;padding:3px 10px;border-radius:99px;">Users</span>
                        </div>
                        <div class="stat-value"><?= $totalUsers ?></div>
                        <div class="stat-label">Admin Users</div>
                        <div class="stat-progress mt-3">
                            <div class="stat-progress-bar" style="width:<?= min(100, $totalUsers * 20) ?>%"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ── Quick Actions ── -->
            <div class="card mb-4" style="border-radius:14px;">
                <div class="card-body" style="padding:16px 20px;">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <span style="font-size:12px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;white-space:nowrap;">Quick Add</span>
                        <div style="width:1px;height:20px;background:#e5e9f2;"></div>
                        <div class="quick-actions">
                            <a href="<?= SITE_URL ?>/admin/doctors/add.php" class="quick-pill qp-indigo">
                                <i class="fe fe-user-plus" style="font-size:13px;"></i> Add Doctor
                            </a>
                            <a href="<?= SITE_URL ?>/admin/blog/add.php" class="quick-pill qp-emerald">
                                <i class="fe fe-edit-2" style="font-size:13px;"></i> New Blog
                            </a>
                            <a href="<?= SITE_URL ?>/admin/services/add.php" class="quick-pill qp-amber">
                                <i class="fe fe-briefcase" style="font-size:13px;"></i> Add Service
                            </a>
                            <a href="<?= SITE_URL ?>/admin/users/add.php" class="quick-pill qp-slate">
                                <i class="fe fe-lock" style="font-size:13px;"></i> Add User
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Doctors + Blogs ── -->
            <div class="row g-3 mb-3">

                <!-- Recent Doctors -->
                <div class="col-lg-6">
                    <div class="card h-100 mb-0">
                        <div class="card-header">
                            <h4 class="card-title d-flex align-items-center gap-2">
                                <span style="width:24px;height:24px;border-radius:6px;background:#eef2ff;display:inline-flex;align-items:center;justify-content:center;">
                                    <i class="fe fe-user-plus" style="font-size:12px;color:#4f46e5;"></i>
                                </span>
                                Recent Doctors
                            </h4>
                            <a href="<?= SITE_URL ?>/admin/doctors/index.php" class="btn btn-white btn-sm">View All</a>
                        </div>
                        <div style="padding:0;">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Doctor</th>
                                        <th>Designation</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($recentDoctors)): ?>
                                    <tr><td colspan="3" class="text-center py-5" style="color:#9ca3af;">
                                        <i class="fe fe-user-plus" style="font-size:28px;display:block;margin-bottom:8px;opacity:.3;"></i>
                                        No doctors yet
                                    </td></tr>
                                    <?php else: foreach ($recentDoctors as $doc):
                                        $photo = SITE_URL . '/' . ltrim($doc['photo'] ?? 'assets/img/patients/default.jpg', '/');
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="<?= htmlspecialchars($photo) ?>"
                                                     onerror="this.src='<?= SITE_URL ?>/assets/img/patients/default.jpg'"
                                                     style="width:34px;height:34px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid #f0f0f5;">
                                                <span class="fw-500" style="font-size:13.5px;"><?= htmlspecialchars($doc['name']) ?></span>
                                            </div>
                                        </td>
                                        <td class="text-sm" style="color:#6b7280;">
                                            <?= htmlspecialchars(mb_strimwidth($doc['designation'] ?? '—', 0, 28, '…')) ?>
                                        </td>
                                        <td class="text-end">
                                            <a href="<?= SITE_URL ?>/admin/doctors/edit.php?id=<?= $doc['id'] ?>"
                                               class="btn btn-white btn-xs"><i class="fe fe-edit-2" style="color:#4f46e5;"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Blogs -->
                <div class="col-lg-6">
                    <div class="card h-100 mb-0">
                        <div class="card-header">
                            <h4 class="card-title d-flex align-items-center gap-2">
                                <span style="width:24px;height:24px;border-radius:6px;background:#ecfdf5;display:inline-flex;align-items:center;justify-content:center;">
                                    <i class="fe fe-edit-2" style="font-size:12px;color:#10b981;"></i>
                                </span>
                                Recent Blogs
                            </h4>
                            <a href="<?= SITE_URL ?>/admin/blog/index.php" class="btn btn-white btn-sm">View All</a>
                        </div>
                        <div style="padding:0;">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($recentBlogs)): ?>
                                    <tr><td colspan="3" class="text-center py-5" style="color:#9ca3af;">
                                        <i class="fe fe-edit" style="font-size:28px;display:block;margin-bottom:8px;opacity:.3;"></i>
                                        No blogs yet
                                    </td></tr>
                                    <?php else: foreach ($recentBlogs as $blog): ?>
                                    <tr>
                                        <td style="max-width:180px;">
                                            <a href="<?= SITE_URL ?>/admin/blog/edit.php?id=<?= $blog['id'] ?>"
                                               style="color:#111827;font-weight:500;font-size:13px;text-decoration:none;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                <?= htmlspecialchars($blog['title']) ?>
                                            </a>
                                            <span class="text-xs" style="color:#9ca3af;"><?= number_format($blog['views']) ?> views</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-light badge-primary" style="font-size:10.5px;">
                                                <?= htmlspecialchars($blog['category'] ?? '—') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($blog['is_published']): ?>
                                                <span class="badge badge-success">Published</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Draft</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ── Admin Users ── -->
            <div class="card mb-0">
                <div class="card-header">
                    <h4 class="card-title d-flex align-items-center gap-2">
                        <span style="width:24px;height:24px;border-radius:6px;background:#ecfeff;display:inline-flex;align-items:center;justify-content:center;">
                            <i class="fe fe-lock" style="font-size:12px;color:#06b6d4;"></i>
                        </span>
                        Admin Users
                    </h4>
                    <a href="<?= SITE_URL ?>/admin/users/add.php" class="btn btn-primary btn-sm">
                        <i class="fe fe-plus me-1"></i> Add User
                    </a>
                </div>
                <div style="padding:0;">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Joined</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentUsers)): ?>
                            <tr><td colspan="5" class="text-center py-5" style="color:#9ca3af;">No users found.</td></tr>
                            <?php else: foreach ($recentUsers as $i => $u):
                                $uInitial = strtoupper(substr($u['name'], 0, 1));
                            ?>
                            <tr>
                                <td class="text-sm" style="color:#9ca3af;width:40px;"><?= $i + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-initial"><?= $uInitial ?></div>
                                        <span class="fw-500" style="font-size:13.5px;"><?= htmlspecialchars($u['name']) ?></span>
                                    </div>
                                </td>
                                <td class="text-sm" style="color:#6b7280;"><?= htmlspecialchars($u['email']) ?></td>
                                <td class="text-sm" style="color:#6b7280;"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                                <td class="text-end">
                                    <a href="<?= SITE_URL ?>/admin/users/edit.php?id=<?= $u['id'] ?>"
                                       class="btn btn-white btn-xs"><i class="fe fe-edit-2" style="color:#4f46e5;"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="height:36px;"></div>

        </div>
    </div>
    <!-- ══ /PAGE WRAPPER ═════════════════════════════════════════════════════ -->

<?php require_once __DIR__ . '/include/footer.php'; ?>
