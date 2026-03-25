<?php
require_once '../include/config.php';

$limit  = 10;
$page   = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search     = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchLike = '%' . $conn->real_escape_string($search) . '%';

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    $conn->query("DELETE FROM blogs WHERE id = $deleteId");
    header("Location: blogs.php?msg=deleted");
    exit;
}

if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
    $toggleId = (int)$_GET['toggle'];
    $conn->query("UPDATE blogs SET is_published = NOT is_published WHERE id = $toggleId");
    header("Location: blogs.php");
    exit;
}

$sql = "SELECT b.*, bc.name AS category_name, ba.name AS author_name
        FROM blogs b
        LEFT JOIN blog_categories bc ON b.category_id = bc.id
        LEFT JOIN blog_authors ba ON b.author_id = ba.id
        WHERE b.title LIKE '$searchLike' OR ba.name LIKE '$searchLike' OR bc.name LIKE '$searchLike'
        ORDER BY b.created_at DESC
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
$blogs  = [];
if ($result) { while ($row = $result->fetch_assoc()) { $blogs[] = $row; } }

$countResult = $conn->query("SELECT COUNT(*) AS total FROM blogs b
    LEFT JOIN blog_categories bc ON b.category_id = bc.id
    LEFT JOIN blog_authors ba ON b.author_id = ba.id
    WHERE b.title LIKE '$searchLike' OR ba.name LIKE '$searchLike' OR bc.name LIKE '$searchLike'");
$totalRecords = $countResult ? (int)$countResult->fetch_assoc()['total'] : 0;
$totalPages   = $totalRecords > 0 ? (int)ceil($totalRecords / $limit) : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs - Admin Panel</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <style>
        .blog-thumb { width:50px; height:50px; object-fit:cover; border-radius:6px; }
        .badge-published { background:#28a745; color:#fff; padding:4px 10px; border-radius:20px; font-size:11px; }
        .badge-draft     { background:#dc3545; color:#fff; padding:4px 10px; border-radius:20px; font-size:11px; }
        .action-btns a   { margin-right:4px; }

        /* ✅ Force action buttons to show side by side */
        .action-btns { white-space: nowrap; }
        .btn-action-edit   { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #0d6efd; color:#0d6efd; background:#fff; margin-right:4px; }
        .btn-action-delete { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #dc3545; color:#dc3545; background:#fff; }
        .btn-action-edit:hover   { background:#0d6efd; color:#fff; }
        .btn-action-delete:hover { background:#dc3545; color:#fff; }
    </style>
</head>
<body>
<div class="main-wrapper">

    <div class="header">
        <div class="header-left">
            <a href="index.php" class="logo"><img src="assets/img/logo.png" alt="Logo"></a>
            <a href="index.php" class="logo logo-small"><img src="assets/img/logo-small.png" alt="Logo" width="30" height="30"></a>
        </div>
        <a href="javascript:void(0);" id="toggle_btn"><i class="fe fe-text-align-left"></i></a>
        <div class="top-nav-search">
            <form>
                <input type="text" class="form-control" placeholder="Search here">
                <button class="btn" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <a class="mobile_btn" id="mobile_btn"><i class="fa fa-bars"></i></a>
        <ul class="nav user-menu">
            <li class="nav-item dropdown has-arrow">
                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                   
                </a>
              
            </li>
        </ul>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title"><span>Main</span></li>
                    <li><a href="index.php"><i class="fe fe-home"></i> <span>Dashboard</span></a></li>
                    <li><a href="appointment-list.html"><i class="fe fe-layout"></i> <span>Appointments</span></a></li>
                    <li><a href="specialities.html"><i class="fe fe-users"></i> <span>Specialities</span></a></li>
                    <li><a href="doctor-list.html"><i class="fe fe-user-plus"></i> <span>Doctors</span></a></li>
                    <li><a href="patient-list.html"><i class="fe fe-user"></i> <span>Patients</span></a></li>
                    <li class="active"><a href="blogs.php"><i class="fe fe-star-o"></i> <span>Blogs</span></a></li>
                    <li><a href="transactions-list.html"><i class="fe fe-activity"></i> <span>Transactions</span></a></li>
                    <li><a href="settings.html"><i class="fe fe-vector"></i> <span>Settings</span></a></li>
                    <li class="menu-title"><span>Pages</span></li>
                    <li><a href="profile.html"><i class="fe fe-user-plus"></i> <span>Profile</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3 class="page-title">Blogs</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Blogs</li>
                        </ul>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="blog-add.php" class="btn btn-primary btn-rounded">
                            <i class="fa fa-plus me-1"></i> Add Blog
                        </a>
                    </div>
                </div>
            </div>

            <?php if (isset($_GET['msg'])):
                $msgMap = [
                    'deleted' => ['danger',  'Blog deleted successfully.'],
                    'added'   => ['success', 'Blog added successfully.'],
                    'updated' => ['success', 'Blog updated successfully.'],
                ];
                [$msgType, $msgText] = $msgMap[$_GET['msg']] ?? ['info', 'Action completed.'];
            ?>
                <div class="alert alert-<?= $msgType ?> alert-dismissible fade show">
                    <?= htmlspecialchars($msgText) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card card-table">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="card-title mb-0">
                            Blog List <span class="badge bg-primary ms-2"><?= $totalRecords ?></span>
                        </h4>
                        <form method="GET" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control form-control-sm"
                                   placeholder="Search title, author, category..."
                                   style="min-width:220px;"
                                   value="<?= htmlspecialchars($search) ?>">
                            <button class="btn btn-sm btn-outline-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                            <?php if ($search): ?>
                                <a href="blogs.php" class="btn btn-sm btn-outline-secondary">Clear</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Views</th>
                                    <th>Comments</th>
                                    <th>Status</th>
                                    <th>Published At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($blogs)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">
                                            <i class="fa fa-exclamation-circle me-2"></i>
                                            No blogs found<?= $search ? ' for "' . htmlspecialchars($search) . '"' : '' ?>.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($blogs as $i => $blog): ?>
                                        <tr>
                                            <td><?= $offset + $i + 1 ?></td>

                                            <td>
                                                <?php if (!empty($blog['image'])): ?>
                                                    <img src="../<?= htmlspecialchars($blog['image']) ?>"
                                                         alt="thumb" class="blog-thumb"
                                                         onerror="this.src='assets/img/placeholder.jpg'">
                                                <?php else: ?>
                                                    <span class="text-muted">
                                                        <i class="fa fa-image" style="font-size:22px;"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <strong><?= htmlspecialchars(mb_strimwidth($blog['title'], 0, 50, '...')) ?></strong><br>
                                                <small class="text-muted"><?= htmlspecialchars($blog['slug']) ?></small>
                                            </td>

                                            <td>
                                                <?php if (!empty($blog['category_name'])): ?>
                                                    <span class="badge bg-info text-white">
                                                        <?= htmlspecialchars($blog['category_name']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">—</span>
                                                <?php endif; ?>
                                            </td>

                                            <td><?= htmlspecialchars($blog['author_name'] ?? '—') ?></td>
                                            <td><?= (int)$blog['views'] ?></td>
                                            <td><?= (int)$blog['comments'] ?></td>

                                            <td>
                                                <a href="blogs.php?toggle=<?= $blog['id'] ?>" title="Click to toggle">
                                                    <?php if ($blog['is_published']): ?>
                                                        <span class="badge-published">Published</span>
                                                    <?php else: ?>
                                                        <span class="badge-draft">Draft</span>
                                                    <?php endif; ?>
                                                </a>
                                            </td>

                                            <td>
                                                <?= !empty($blog['published_at'])
                                                    ? date('d M Y', strtotime($blog['published_at']))
                                                    : '<span class="text-muted">Not set</span>' ?>
                                            </td>

                                            <!-- ✅ ACTION BUTTONS — FontAwesome icons guaranteed to show -->
                                            <td class="text-end action-btns">

                                                <!-- Edit Button -->
                                                <a href="blog-edit.php?id=<?= $blog['id'] ?>"
                                                   class="btn-action-edit" title="Edit Blog">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <a href="blogs.php?delete=<?= $blog['id'] ?>"
                                                   class="btn-action-delete" title="Delete Blog"
                                                   onclick="return confirm('Are you sure you want to delete this blog?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($totalPages > 1): ?>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                Showing <?= $offset + 1 ?> – <?= min($offset + $limit, $totalRecords) ?> of <?= $totalRecords ?> entries
                            </small>
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">
                                            <i class="fa fa-chevron-left"></i>
                                        </a>
                                    </li>
                                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                                        <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $p ?>&search=<?= urlencode($search) ?>">
                                                <?= $p ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">
                                            <i class="fa fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>