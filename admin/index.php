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
$res = $conn->query("SELECT id, name, designation, photo FROM doctors ORDER BY id DESC LIMIT 5");
if ($res) while ($r = $res->fetch_assoc()) $recentDoctors[] = $r;

$recentBlogs = [];
$res = $conn->query("
    SELECT b.id, b.title, b.is_published, b.views, b.created_at, c.name AS category
    FROM blogs b LEFT JOIN categories c ON c.id = b.category_id
    ORDER BY b.created_at DESC LIMIT 5
");
if ($res) while ($r = $res->fetch_assoc()) $recentBlogs[] = $r;

$recentUsers = [];
$res = $conn->query("SELECT id, name, email, created_at FROM admin_users ORDER BY created_at DESC LIMIT 5");
if ($res) while ($r = $res->fetch_assoc()) $recentUsers[] = $r;

$pageTitle  = 'Dashboard';
$activePage = 'dashboard';
$assetBase  = '';

require_once __DIR__ . '/include/head.php';
?>

    <?php require_once __DIR__ . '/include/header.php'; ?>
    <?php require_once __DIR__ . '/include/sidebar.php'; ?>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Welcome Admin!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Stat Cards -->
            <div class="row">

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-primary border-primary">
                                    <i class="fe fe-users"></i>
                                </span>
                                <div class="dash-count">
                                    <h3><?= $totalDoctors ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Doctors</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary" style="width:<?= min(100,$totalDoctors*15) ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-success">
                                    <i class="fe fe-edit"></i>
                                </span>
                                <div class="dash-count">
                                    <h3><?= $totalBlogs ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Blogs <small class="text-success">(<?= $publishedBlogs ?> published)</small></h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width:<?= $totalBlogs>0 ? min(100,round(($publishedBlogs/$totalBlogs)*100)) : 0 ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-danger border-danger">
                                    <i class="fe fe-briefcase"></i>
                                </span>
                                <div class="dash-count">
                                    <h3><?= $totalServices ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Services</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger" style="width:<?= min(100,$totalServices*10) ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-warning border-warning">
                                    <i class="fe fe-lock"></i>
                                </span>
                                <div class="dash-count">
                                    <h3><?= $totalUsers ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Admin Users</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning" style="width:<?= min(100,$totalUsers*20) ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tables Row -->
            <div class="row">

                <!-- Recent Doctors -->
                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Recent Doctors</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Doctor Name</th>
                                            <th>Designation</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($recentDoctors)): ?>
                                        <tr><td colspan="3" class="text-center text-muted">No doctors found.</td></tr>
                                        <?php else: foreach ($recentDoctors as $doc): ?>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="<?= SITE_URL ?>/admin/doctors/edit.php?id=<?= $doc['id'] ?>" class="avatar avatar-sm me-2">
                                                        <img class="avatar-img rounded-circle"
                                                             src="<?= SITE_URL ?>/<?= htmlspecialchars(ltrim($doc['photo'] ?? 'assets/img/patients/default.jpg', '/')) ?>"
                                                             alt="" onerror="this.src='<?= SITE_URL ?>/assets/img/patients/default.jpg'">
                                                    </a>
                                                    <a href="<?= SITE_URL ?>/admin/doctors/edit.php?id=<?= $doc['id'] ?>">
                                                        <?= htmlspecialchars($doc['name']) ?>
                                                    </a>
                                                </h2>
                                            </td>
                                            <td><?= htmlspecialchars(mb_strimwidth($doc['designation'] ?? '—', 0, 35, '…')) ?></td>
                                            <td>
                                                <a href="<?= SITE_URL ?>/admin/doctors/edit.php?id=<?= $doc['id'] ?>" class="btn btn-sm btn-white">
                                                    <i class="fe fe-pencil text-primary"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Blogs -->
                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Recent Blogs</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Views</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($recentBlogs)): ?>
                                        <tr><td colspan="4" class="text-center text-muted">No blogs found.</td></tr>
                                        <?php else: foreach ($recentBlogs as $blog): ?>
                                        <tr>
                                            <td>
                                                <a href="<?= SITE_URL ?>/admin/blog/edit.php?id=<?= $blog['id'] ?>">
                                                    <?= htmlspecialchars(mb_strimwidth($blog['title'], 0, 35, '…')) ?>
                                                </a>
                                            </td>
                                            <td><?= htmlspecialchars($blog['category'] ?? '—') ?></td>
                                            <td><?= number_format($blog['views']) ?></td>
                                            <td>
                                                <?php if ($blog['is_published']): ?>
                                                    <span class="badge bg-success-light text-success">Published</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger-light text-danger">Draft</span>
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

            </div>

            <!-- Admin Users -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-table">
                        <div class="card-header">
                            <h4 class="card-title">Admin Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Joined</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($recentUsers)): ?>
                                        <tr><td colspan="5" class="text-center text-muted">No users found.</td></tr>
                                        <?php else: foreach ($recentUsers as $i => $u): ?>
                                        <tr>
                                            <td><?= $i+1 ?></td>
                                            <td><?= htmlspecialchars($u['name']) ?></td>
                                            <td><?= htmlspecialchars($u['email']) ?></td>
                                            <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                                            <td>
                                                <a href="<?= SITE_URL ?>/admin/users/edit.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-white">
                                                    <i class="fe fe-pencil text-primary"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /Page Wrapper -->

<?php require_once __DIR__ . '/include/footer.php'; ?>
