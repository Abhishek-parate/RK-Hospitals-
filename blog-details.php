<?php
require_once 'include/config.php';

// ─── Get slug from URL ────────────────────────────────────────────────────────
$slug = isset($_GET['slug']) ? clean($_GET['slug']) : '';

if (empty($slug)) {
    header("Location: blog-grid.php");
    exit;
}

// ─── Fetch the blog post ──────────────────────────────────────────────────────
$blog_sql = "SELECT 
               b.id, b.title, b.slug, b.content, b.image,
               b.views, b.comments, b.published_at, b.tags,
               c.name  AS category_name, c.slug AS category_slug,
               a.name  AS author_name,   a.photo AS author_photo,
               a.profile_url AS author_url, a.designation AS author_designation,
               a.bio   AS author_bio
             FROM blogs b
             LEFT JOIN blog_categories c ON b.category_id = c.id
             LEFT JOIN blog_authors    a ON b.author_id   = a.id
             WHERE b.slug = '$slug' AND b.is_published = 1
             LIMIT 1";
$blog_res = $conn->query($blog_sql);

if (!$blog_res || $blog_res->num_rows === 0) {
    header("HTTP/1.0 404 Not Found");
    include '404.php'; 
    exit;
}

$blog = $blog_res->fetch_assoc();

// ─── Increment view count ─────────────────────────────────────────────────────
$conn->query("UPDATE blogs SET views = views + 1 WHERE slug = '$slug'");

// ─── Build tags array ─────────────────────────────────────────────────────────
$tags = !empty($blog['tags'])
    ? array_map('trim', explode(',', $blog['tags']))
    : [];

// ─── Sidebar: Categories with count ──────────────────────────────────────────
$categories_sql = "SELECT c.name, c.slug, COUNT(b.id) as blog_count 
                   FROM blog_categories c 
                   LEFT JOIN blogs b ON b.category_id = c.id AND b.is_published = 1
                   GROUP BY c.id ORDER BY blog_count DESC";
$categories_res = $conn->query($categories_sql);

// ─── Sidebar: Latest 4 posts (excluding current) ─────────────────────────────
$latest_sql = "SELECT b.title, b.slug, b.image, b.published_at 
               FROM blogs b 
               WHERE b.is_published = 1 AND b.slug != '$slug'
               ORDER BY b.published_at DESC LIMIT 4";
$latest_res = $conn->query($latest_sql);

// ─── SEO: meta description from content ──────────────────────────────────────
$meta_desc = truncate(strip_tags($blog['content']), 160);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($blog['title']) ?> - Dr. Agrawal's R.K. Hospital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <?php if (!empty($tags)): ?>
    <meta name="keywords" content="<?= htmlspecialchars(implode(', ', $tags)) ?>">
    <?php endif; ?>
    <meta name="author" content="Dr. Agrawal's R.K. Hospital">

    <!-- Open Graph (Facebook/WhatsApp share) -->
    <meta property="og:title"       content="<?= htmlspecialchars($blog['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:image"       content="<?= SITE_URL . '/' . htmlspecialchars($blog['image']) ?>">
    <meta property="og:url"         content="<?= SITE_URL ?>/blog-details.php?slug=<?= urlencode($blog['slug']) ?>">
    <meta property="og:type"        content="article">

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
                            <li class="has-submenu">
                                <a href="#" class="main-menu" onclick="toggleMobileSubmenu(this); return false;">
                                    Service
                                    <span><i class="fa-solid fa-chevron-down"></i></span>
                                </a>
                                <ul class="submenu sub-menu-one sub-menu-default">
                                    <li><a href="hospital-services.html">Hospital Services</a></li>
                                    <li><a href="gynecology-services.html">Gynecology Services</a></li>
                                    <li><a href="orthopedic-services.html">Orthopedic Services</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu active">
                                <a href="blog-grid.php" class="main-menu">Blogs</a>
                            </li>
                            <li class="has-submenu">
                                <a href="contact-us.html" class="main-menu">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <li>
                    <a href="contact-us.html" class="btn btn-md btn-primary-gradient d-none d-lg-inline-block"
                       style="background: #1a6ef5 !important; color: #fff !important; border-color: #1a6ef5 !important;">
                        <i class="isax isax-lock-1 me-2"></i><span>Book Now</span>
                    </a>
                </li>
            </nav>
        </div>
    </header>
    <!-- /Header -->

    <!-- Page Content -->
    <div class="content" style="padding-top: 40px;">
        <div class="container">
            <div class="row">

                <!-- ─── Blog Detail ────────────────────────────────────────── -->
                <div class="col-lg-8 col-md-12">
                    <div class="blog-view">
                        <h3 class="mb-3"><?= htmlspecialchars($blog['title']) ?></h3>
                        <div class="blog blog-single-post">

                            <!-- Blog Image -->
                            <div class="blog-image">
                                <a href="javascript:void(0);">
                                    <img alt="<?= htmlspecialchars($blog['title']) ?>"
                                         src="<?= htmlspecialchars($blog['image']) ?>"
                                         class="img-fluid">
                                </a>
                            </div>

                            <!-- Blog Meta -->
                            <div class="blog-info d-md-flex align-items-center justify-content-between flex-wrap">
                                <div class="post-left">
                                    <ul>
                                        <li>
                                            <span class="badge badge-dark fs-14 fw-medium">
                                                <?= htmlspecialchars($blog['category_name']) ?>
                                            </span>
                                        </li>
                                        <li>
                                            <i class="isax isax-calendar"></i>
                                            <?= formatDate($blog['published_at']) ?>
                                        </li>
                                        <li>
                                            <div class="post-author">
                                                <a href="<?= htmlspecialchars($blog['author_url']) ?>">
                                                    <img src="<?= htmlspecialchars($blog['author_photo']) ?>"
                                                         alt="<?= htmlspecialchars($blog['author_name']) ?>">
                                                    <span><?= htmlspecialchars($blog['author_name']) ?></span>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="blog-views d-flex align-items-center justify-content-md-end">
                                    <span class="badge badge-outline-dark me-2">
                                        <i class="isax isax-message-text me-1"></i>
                                        <?= (int)$blog['comments'] ?>
                                    </span>
                                    <span class="badge badge-outline-primary">
                                        <i class="isax isax-eye me-1"></i>
                                        <?= (int)$blog['views'] ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Blog Content (stored as HTML in DB) -->
                            <div class="blog-content">
                                <?= $blog['content'] /* HTML content - stored safely from admin */ ?>
                            </div>

                        </div>

                        <!-- About Author -->
                        <h4 class="mb-3">About the Author</h4>
                        <div class="about-author">
                            <div class="about-author-img">
                                <div class="author-img-wrap">
                                    <a href="<?= htmlspecialchars($blog['author_url']) ?>">
                                        <img class="img-fluid"
                                             alt="<?= htmlspecialchars($blog['author_name']) ?>"
                                             src="<?= htmlspecialchars($blog['author_photo']) ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="author-details">
                                <h5 class="mb-1"><?= htmlspecialchars($blog['author_name']) ?></h5>
                                <p class="text-muted mb-2" style="font-size: 13px;">
                                    <?= htmlspecialchars($blog['author_designation']) ?>
                                </p>
                                <p class="mb-0"><?= htmlspecialchars($blog['author_bio']) ?></p>
                            </div>
                        </div>

                        <!-- Tags -->
                        <?php if (!empty($tags)): ?>
                            <h4 class="mb-3 mt-4">Tags</h4>
                            <div class="d-flex align-items-center flex-wrap blog-tags gap-3 mb-4">
                                <?php foreach ($tags as $tag): ?>
                                    <a href="blog-grid.php?search=<?= urlencode($tag) ?>" class="badge">
                                        <?= htmlspecialchars($tag) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                <!-- /Blog Detail -->

                <!-- ─── Sidebar ────────────────────────────────────────────── -->
                <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

                    <!-- Search -->
                    <div class="card search-widget">
                        <div class="card-body">
                            <form class="search-form" method="GET" action="blog-grid.php">
                                <div class="input-group">
                                    <input type="text" name="search"
                                           placeholder="Search articles..."
                                           class="form-control">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="isax isax-search-normal"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Search -->

                    <!-- Categories -->
                    <div class="card category-widget">
                        <div class="card-body">
                            <h5 class="mb-3">Categories</h5>
                            <ul class="categories">
                                <?php
                                $categories_res->data_seek(0);
                                while ($cat = $categories_res->fetch_assoc()):
                                    $active = ($blog['category_slug'] === $cat['slug']) ? 'style="font-weight:600;"' : '';
                                ?>
                                    <li>
                                        <a href="blog-grid.php?category=<?= urlencode($cat['slug']) ?>" <?= $active ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                            <span>(<?= $cat['blog_count'] ?>)</span>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /Categories -->

                    <!-- Latest Articles -->
                    <div class="card post-widget">
                        <div class="card-body">
                            <h5 class="mb-3">Latest Articles</h5>
                            <ul class="latest-posts">
                                <?php while ($latest = $latest_res->fetch_assoc()): ?>
                                    <li>
                                        <div class="post-thumb">
                                            <a href="blog-details.php?slug=<?= htmlspecialchars($latest['slug']) ?>">
                                                <img class="img-fluid"
                                                     src="<?= htmlspecialchars($latest['image']) ?>"
                                                     alt="<?= htmlspecialchars($latest['title']) ?>">
                                            </a>
                                        </div>
                                        <div class="post-info">
                                            <p><?= formatDate($latest['published_at']) ?></p>
                                            <h4>
                                                <a href="blog-details.php?slug=<?= htmlspecialchars($latest['slug']) ?>">
                                                    <?= htmlspecialchars($latest['title']) ?>
                                                </a>
                                            </h4>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /Latest Articles -->

                    <!-- Tags Widget -->
                    <?php if (!empty($tags)): ?>
                    <div class="card tags-widget">
                        <div class="card-body">
                            <h5 class="mb-3">Tags</h5>
                            <ul class="tags">
                                <?php foreach ($tags as $tag): ?>
                                    <li>
                                        <a href="blog-grid.php?search=<?= urlencode($tag) ?>" class="tag">
                                            <?= htmlspecialchars($tag) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- /Tags Widget -->

                    <!-- Book Appointment CTA -->
                    <div class="card" style="background: linear-gradient(135deg, #1a6ef5, #0a4fc4); border: none;">
                        <div class="card-body text-center text-white p-4">
                            <i class="isax isax-hospital" style="font-size: 36px; display: block; margin-bottom: 12px;"></i>
                            <h5 class="text-white mb-2">Need a Consultation?</h5>
                            <p class="mb-3" style="font-size: 14px; opacity: 0.9; color: white;">
                                Book an appointment with our specialist doctors at R.K. Hospital, Nagpur.
                            </p>
                            <a href="contact-us.html" class="btn btn-light fw-semibold w-100">
                                <i class="isax isax-calendar-add me-2"></i>Book Appointment
                            </a>
                            <p class="mt-2 mb-0" style="font-size: 13px; opacity: 0.85; color: wheat;">
                                <i class="fa-solid fa-phone me-1"></i> 097660 57372
                            </p>
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