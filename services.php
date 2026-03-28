<?php
require_once 'include/config.php';

// ─── Pagination ───────────────────────────────────────────────────────────────
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * SERVICES_PER_PAGE;

// ─── Category Filter ──────────────────────────────────────────────────────────
$cat_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$search = isset($_GET['search'])   ? clean($_GET['search']) : '';

// ─── Build WHERE clause ───────────────────────────────────────────────────────
$where = "WHERE s.is_published = 1";
if (!empty($cat_id)) {
    $where .= " AND s.category_id = $cat_id";
}
if (!empty($search)) {
    $safe_search = $conn->real_escape_string($search);
    $where .= " AND (s.title LIKE '%$safe_search%' OR s.short_description LIKE '%$safe_search%' OR s.focus_keyword LIKE '%$safe_search%')";
}

// ─── Total services count (for pagination) ────────────────────────────────────
$count_sql = "SELECT COUNT(*) as total FROM services s $where";
$count_res        = $conn->query($count_sql);
$total_services   = $count_res->fetch_assoc()['total'];
$total_pages      = ceil($total_services / SERVICES_PER_PAGE);

// ─── Fetch services ───────────────────────────────────────────────────────────
$services_sql = "SELECT 
                    s.id, s.title, s.slug, s.short_description,
                    s.image, s.image_alt, s.icon,
                    s.category_id, s.sort_order,
                    c.name AS category_name, c.slug AS category_slug
                 FROM services s
                 LEFT JOIN categories c ON s.category_id = c.id
                 $where
                 ORDER BY s.sort_order ASC, s.id ASC
                 LIMIT " . SERVICES_PER_PAGE . " OFFSET $offset";
$services_res = $conn->query($services_sql);

// ─── Sidebar: Categories with count ──────────────────────────────────────────
$categories_sql = "SELECT c.id, c.name, c.slug, COUNT(s.id) as service_count 
                   FROM categories c 
                   LEFT JOIN services s ON s.category_id = c.id AND s.is_published = 1
                   GROUP BY c.id 
                   ORDER BY service_count DESC";
$categories_res = $conn->query($categories_sql);

// ─── Sidebar: Latest 4 services ───────────────────────────────────────────────
$latest_sql = "SELECT title, slug, image, image_alt, created_at 
               FROM services 
               WHERE is_published = 1 
               ORDER BY created_at DESC LIMIT 4";
$latest_res = $conn->query($latest_sql);

// ─── Sidebar: All unique focus keywords as tags ───────────────────────────────
$tags_sql = "SELECT focus_keyword FROM services WHERE is_published = 1 AND focus_keyword IS NOT NULL AND focus_keyword != ''";
$tags_res = $conn->query($tags_sql);
$all_tags = [];
while ($row = $tags_res->fetch_assoc()) {
    $tag_list = array_map('trim', explode(',', $row['focus_keyword']));
    foreach ($tag_list as $tag) {
        if (!empty($tag) && !in_array($tag, $all_tags)) {
            $all_tags[] = $tag;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Our Services - Dr. Agrawal's R.K. Hospital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore all medical services at Dr. Agrawal's R.K. Hospital, Nagpur — orthopedics, gynecology, surgery, maternity care, and more.">
    <meta name="keywords" content="hospital services, orthopedic, gynecology, RK Hospital Nagpur, medical care Nagpur">
    <meta name="author" content="Dr. Agrawal's R.K. Hospital">

    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <script src="assets/js/theme-script.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/iconsax.css">
    <link rel="stylesheet" href="assets/css/feather.css">
    <link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="main-wrapper">

    <!-- Header -->
    <header class="header header-default inner-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg header-nav">
                <div class="navbar-header">
                    <a id="mobile_btn" href="javascript:void(0);">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                    <a href="index-7.html" class="navbar-brand logo">
                        <img src="assets/img/RK-Logo.png" class="img-fluid" alt="Logo">
                    </a>
                </div>
                <div class="header-menu">
                    <div class="main-menu-wrapper">
                        <div class="menu-header">
                            <a href="index-7.html" class="menu-logo">
                                <img src="assets/img/RK-Logo.png" class="img-fluid" alt="Logo">
                            </a>
                            <a id="menu_close" class="menu-close" href="javascript:void(0);">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                        <ul class="main-nav">
                            <li class="has-submenu megamenu">
                                <a href="index-7.html" class="main-menu">Home</a>
                            </li>
                            <li class="has-submenu">
                                <a href="two-doctor.html" class="main-menu">Doctors</a>
                            </li>
                            <li class="has-submenu">
                                <a href="about-us.html" class="main-menu">About Us</a>
                            </li>
                            <li class="has-submenu active">
                                <a href="#" class="main-menu" onclick="toggleMobileSubmenu(this); return false;">
                                    Service
                                    <span><i class="fa-solid fa-chevron-down"></i></span>
                                </a>
                                <ul class="submenu sub-menu-one sub-menu-default">
                                    <li><a href="hospital-services.html">Hospital Services</a></li>
                                    <li><a href="gynecology-services.html">Gynecology Services</a></li>
                                    <li><a href="orthopedic-services.html">Orthopedic Services</a></li>
                                    <li><a href="services.php">All Services</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu">
                                <a href="blog-grid.php" class="main-menu">Blogs</a>
                            </li>
                            <li class="has-submenu">
                                <a href="contact-us.html" class="main-menu">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <li>
                    <a href="contact-us.html"
                       class="btn btn-md btn-primary-gradient d-none d-lg-inline-block"
                       style="background: #1a6ef5 !important; color: #fff !important; border-color: #1a6ef5 !important;">
                        <i class="isax isax-lock-1 me-2"></i><span>Book Now</span>
                    </a>
                </li>
            </nav>
        </div>
    </header>
    <!-- /Header -->

    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="row">

                <!-- ─── Services Grid ──────────────────────────────────────── -->
                <div class="col-lg-8 col-md-12">
                    <div class="row blog-grid-row">

                        <?php if ($services_res && $services_res->num_rows > 0): ?>
                            <?php while ($service = $services_res->fetch_assoc()): ?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="blog grid-blog">
                                        <div class="blog-image">
                                            <a href="service/<?= htmlspecialchars($service['slug']) ?>">
                                                <img class="img-fluid"
                                                     src="<?= htmlspecialchars($service['image']) ?>"
                                                     alt="<?= htmlspecialchars($service['image_alt'] ?: $service['title']) ?>">
                                            </a>
                                            <?php if (!empty($service['category_name'])): ?>
                                                <span class="badge badge-cyan category-slug">
                                                    <?= htmlspecialchars($service['category_name']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="blog-content">
                                            <ul class="entry-meta meta-item">
                                                <li>
                                                    <div class="post-author">
                                                        <?php if (!empty($service['icon'])): ?>
                                                            <i class="<?= htmlspecialchars($service['icon']) ?> me-1"></i>
                                                        <?php endif; ?>
                                                        <span><?= htmlspecialchars($service['category_name'] ?: 'General') ?></span>
                                                    </div>
                                                </li>
                                            </ul>
                                            <h3 class="blog-title">
                                                <a href="service/<?= htmlspecialchars($service['slug']) ?>">
                                                    <?= htmlspecialchars($service['title']) ?>
                                                </a>
                                            </h3>
                                            <p class="mb-0"><?= htmlspecialchars($service['short_description']) ?></p>
                                            <div class="mt-3">
                                                <a href="service/<?= htmlspecialchars($service['slug']) ?>"
                                                   class="btn btn-sm"
                                                   style="background:#1a6ef5; color:#fff; border-color:#1a6ef5;">
                                                    Learn More <i class="fa-solid fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>

                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-info mt-3">
                                    <?php if (!empty($search)): ?>
                                        No services found for "<strong><?= htmlspecialchars($search) ?></strong>".
                                        <a href="services.php">Clear search</a>
                                    <?php elseif (!empty($cat_id)): ?>
                                        No services found in this category.
                                        <a href="services.php">View all services</a>
                                    <?php else: ?>
                                        No services published yet. Check back soon!
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- ─── Pagination ─────────────────────────────────────── -->
                    <?php if ($total_pages > 1): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pagination dashboard-pagination mt-md-3 mt-0 mb-4">
                                    <ul>
                                        <!-- Prev -->
                                        <li>
                                            <a href="?page=<?= max(1, $page - 1) ?>&category=<?= $cat_id ?>&search=<?= urlencode($search) ?>"
                                               class="page-link prev <?= $page == 1 ? 'disabled' : '' ?>">Prev</a>
                                        </li>

                                        <!-- Page Numbers -->
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li>
                                                <a href="?page=<?= $i ?>&category=<?= $cat_id ?>&search=<?= urlencode($search) ?>"
                                                   class="page-link <?= $i == $page ? 'active' : '' ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <!-- Next -->
                                        <li>
                                            <a href="?page=<?= min($total_pages, $page + 1) ?>&category=<?= $cat_id ?>&search=<?= urlencode($search) ?>"
                                               class="page-link next <?= $page == $total_pages ? 'disabled' : '' ?>">Next</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- /Pagination -->

                </div>
                <!-- /Services Grid -->

                <!-- ─── Sidebar ────────────────────────────────────────────── -->
                <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

                    <!-- Search -->
                    <div class="card search-widget">
                        <div class="card-body">
                            <form class="search-form" method="GET" action="services.php">
                                <div class="input-group">
                                    <input type="text" name="search"
                                           placeholder="Search services..."
                                           value="<?= htmlspecialchars($search) ?>"
                                           class="form-control">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="isax isax-search-normal"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Search -->

                    <!-- Latest Services -->
                    <div class="card post-widget">
                        <div class="card-body">
                            <h5 class="mb-3">Latest Services</h5>
                            <ul class="latest-posts">
                                <?php
                                $latest_res->data_seek(0);
                                while ($latest = $latest_res->fetch_assoc()):
                                ?>
                                    <li>
                                        <div class="post-thumb">
                                            <a href="service/<?= htmlspecialchars($latest['slug']) ?>">
                                                <img class="img-fluid"
                                                     src="<?= htmlspecialchars($latest['image']) ?>"
                                                     alt="<?= htmlspecialchars($latest['image_alt'] ?: $latest['title']) ?>">
                                            </a>
                                        </div>
                                        <div class="post-info">
                                            <p><?= formatDate($latest['created_at']) ?></p>
                                            <h4>
                                                <a href="service/<?= htmlspecialchars($latest['slug']) ?>">
                                                    <?= htmlspecialchars($latest['title']) ?>
                                                </a>
                                            </h4>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /Latest Services -->

                    <!-- Categories -->
                    <div class="card category-widget">
                        <div class="card-body">
                            <h5 class="mb-3">Categories</h5>
                            <ul class="categories">
                                <?php
                                $categories_res->data_seek(0);
                                while ($cat = $categories_res->fetch_assoc()):
                                    $active = ($cat_id === (int)$cat['id']) ? 'style="font-weight:600;"' : '';
                                ?>
                                    <li>
                                        <a href="services.php?category=<?= (int)$cat['id'] ?>" <?= $active ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                            <span>(<?= $cat['service_count'] ?>)</span>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                                <?php if (!empty($cat_id)): ?>
                                    <li><a href="services.php">View All</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /Categories -->

                    <!-- Tags (Focus Keywords) -->
                    <div class="card tags-widget">
                        <div class="card-body">
                            <h5 class="mb-3">Keywords</h5>
                            <ul class="tags">
                                <?php foreach ($all_tags as $tag): ?>
                                    <li>
                                        <a href="services.php?search=<?= urlencode($tag) ?>" class="tag">
                                            <?= htmlspecialchars($tag) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /Tags -->

                    <!-- Book Appointment CTA -->
                    <div class="card" style="background: linear-gradient(135deg, #1a6ef5, #0d4fbf); color:#fff;">
                        <div class="card-body text-center py-4">
                            <i class="fa-solid fa-calendar-check fa-2x mb-3"></i>
                            <h5 class="mb-2">Need a Consultation?</h5>
                            <p class="mb-3" style="font-size:0.9rem; opacity:0.9;">Book an appointment with our specialists today.</p>
                            <a href="contact-us.html"
                               class="btn btn-light btn-sm fw-semibold"
                               style="color:#1a6ef5;">
                                Book Now
                            </a>
                        </div>
                    </div>
                    <!-- /Book Appointment CTA -->

                </div>
                <!-- /Sidebar -->

            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Footer -->
    <footer class="footer inner-footer">
        <div class="footer-top">
            <div class="container">
                <div class="row align-items-start">
                    <div class="col-xl-2 col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <div class="footer-logo mb-3">
                                <img src="assets/img/RK-Logo.png" alt="RK Hospital Logo" class="img-fluid logo">
                            </div>
                            <p>Dr. Agrawal's R.K. Hospital provides quality healthcare in Nagpur with advanced medical facilities and compassionate care.</p>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-6">
                        <div class="footer-widget footer-menu">
                            <h6 class="footer-title">Quick Links</h6>
                            <ul>
                                <li><a href="index-7.html">Home</a></li>
                                <li><a href="about-us.html">About Us</a></li>
                                <li><a href="two-doctor.html">Doctors</a></li>
                                <li><a href="contact-us.html">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-6">
                        <div class="footer-widget footer-menu">
                            <h6 class="footer-title">Treatments</h6>
                            <ul>
                                <li><a href="orthopedic-services.html">Orthopedic Services</a></li>
                                <li><a href="gynecology-services.html">Gynecology Services</a></li>
                                <li><a href="hospital-services.html">Hospital Services</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-6">
                        <div class="footer-widget footer-menu">
                            <h6 class="footer-title">Policies</h6>
                            <ul>
                                <li><a href="#">Legal Notice</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Refund Policy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-12">
                        <div class="footer-widget">
                            <h6 class="footer-title">Reach Us</h6>
                            <p class="mb-2"><strong>Dr. Agrawal's R.K. Hospital</strong><br>Central Avenue, Ladpura<br>Itwari, Nagpur</p>
                            <p class="mb-1"><strong>Phone:</strong> 097660 57372</p>
                            <p class="mb-0"><strong>Email:</strong> info@rkhospital.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p class="text-center mb-0">Copyright &copy; <?= date('Y') ?> Dr. Agrawal's R.K. Hospital, Nagpur. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <!-- /Footer -->

</div>
<!-- /Main Wrapper -->

<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
<script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
<?php $conn->close(); ?>