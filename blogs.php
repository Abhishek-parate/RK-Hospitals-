<?php
require_once 'include/config.php';

// ─── Pagination ───────────────────────────────────────────────────────────────
$page     = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset   = ($page - 1) * BLOGS_PER_PAGE;

// ─── Category Filter ──────────────────────────────────────────────────────────
$cat_slug = isset($_GET['category']) ? clean($_GET['category']) : '';
$search   = isset($_GET['search'])   ? clean($_GET['search'])   : '';

// ─── Build WHERE clause ───────────────────────────────────────────────────────
$where = "WHERE b.is_published = 1";
if (!empty($cat_slug)) {
    $where .= " AND c.slug = '$cat_slug'";
}
if (!empty($search)) {
    $where .= " AND (b.title LIKE '%$search%' OR b.excerpt LIKE '%$search%' OR b.tags LIKE '%$search%')";
}

// ─── Total blogs count (for pagination) ───────────────────────────────────────
$count_sql = "SELECT COUNT(*) as total FROM blogs b 
              LEFT JOIN categories c ON b.category_id = c.id 
              $where";
$count_res   = $conn->query($count_sql);
$total_blogs = $count_res->fetch_assoc()['total'];
$total_pages = ceil($total_blogs / BLOGS_PER_PAGE);

// ─── Fetch blogs ──────────────────────────────────────────────────────────────
$blogs_sql = "SELECT 
                b.id, b.title, b.slug, b.excerpt, b.image,
                b.views, b.comments, b.published_at,
                c.name  AS category_name, c.slug AS category_slug,
                a.name  AS author_name,   a.photo AS author_photo, a.profile_url AS author_url
              FROM blogs b
              LEFT JOIN categories c ON b.category_id = c.id
              LEFT JOIN doctors    a ON b.doctor_id   = a.id
              $where
              ORDER BY b.published_at DESC
              LIMIT " . BLOGS_PER_PAGE . " OFFSET $offset";
$blogs_res = $conn->query($blogs_sql);

// ─── Sidebar: Categories with count ──────────────────────────────────────────
$categories_sql = "SELECT c.name, c.slug, COUNT(b.id) as blog_count 
                   FROM categories c 
                   LEFT JOIN blogs b ON b.category_id = c.id AND b.is_published = 1
                   GROUP BY c.id ORDER BY blog_count DESC";
$categories_res = $conn->query($categories_sql);

// ─── Sidebar: Latest 4 posts ──────────────────────────────────────────────────
$latest_sql = "SELECT b.title, b.slug, b.image, b.published_at 
               FROM blogs b 
               WHERE b.is_published = 1 
               ORDER BY b.published_at DESC LIMIT 4";
$latest_res = $conn->query($latest_sql);

// ─── Sidebar: All unique tags ─────────────────────────────────────────────────
$tags_sql = "SELECT tags FROM blogs WHERE is_published = 1 AND tags IS NOT NULL AND tags != ''";
$tags_res = $conn->query($tags_sql);
$all_tags = [];
while ($row = $tags_res->fetch_assoc()) {
    $tag_list = array_map('trim', explode(',', $row['tags']));
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
    <title>Blogs - Dr. Agrawal's R.K. Hospital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Read health articles and blogs from Dr. Agrawal's R.K. Hospital, Nagpur — covering orthopedics, gynecology, surgery, pregnancy, and general wellness.">
    <meta name="keywords" content="hospital blog, orthopedic tips, gynecology advice, pregnancy care, RK Hospital Nagpur, health awareness">
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

    <?php $headerClass = 'header-default inner-header'; include 'include/header.php'; ?>

    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="row">

                <!-- ─── Blog Grid ──────────────────────────────────────────── -->
                <div class="col-lg-8 col-md-12">
                    <div class="row blog-grid-row">

                        <?php if ($blogs_res && $blogs_res->num_rows > 0): ?>
                            <?php while ($blog = $blogs_res->fetch_assoc()): ?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="blog grid-blog">
                                        <div class="blog-image">
                                            <a href="blog/<?= htmlspecialchars($blog['slug']) ?>">
                                                <img class="img-fluid"
                                                     src="<?= htmlspecialchars($blog['image']) ?>"
                                                     alt="<?= htmlspecialchars($blog['title']) ?>">
                                            </a>
                                            <span class="badge badge-cyan category-slug">
                                                <?= htmlspecialchars($blog['category_name']) ?>
                                            </span>
                                        </div>
                                        <div class="blog-content">
                                            <ul class="entry-meta meta-item">
                                                <li>
                                                    <div class="post-author">
                                                        <a href="<?= htmlspecialchars($blog['author_url']) ?>">
                                                            <img src="<?= htmlspecialchars($blog['author_photo']) ?>"
                                                                 alt="<?= htmlspecialchars($blog['author_name']) ?>">
                                                            <span><?= htmlspecialchars($blog['author_name']) ?></span>
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <i class="isax isax-calendar-1 me-1"></i>
                                                    <?= formatDate($blog['published_at']) ?>
                                                </li>
                                            </ul>
                                            <h3 class="blog-title">
                                                <a href="blog/<?= htmlspecialchars($blog['slug']) ?>">
                                                    <?= htmlspecialchars($blog['title']) ?>
                                                </a>
                                            </h3>
                                            <p class="mb-0"><?= htmlspecialchars($blog['excerpt']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>

                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-info mt-3">
                                    <?php if (!empty($search)): ?>
                                        No blogs found for "<strong><?= htmlspecialchars($search) ?></strong>".
                                        <a href="blog-grid.php">Clear search</a>
                                    <?php elseif (!empty($cat_slug)): ?>
                                        No blogs found in this category.
                                        <a href="blog-grid.php">View all blogs</a>
                                    <?php else: ?>
                                        No blogs published yet. Check back soon!
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
                                            <a href="?page=<?= max(1, $page - 1) ?>&category=<?= urlencode($cat_slug) ?>&search=<?= urlencode($search) ?>"
                                               class="page-link prev <?= $page == 1 ? 'disabled' : '' ?>">Prev</a>
                                        </li>

                                        <!-- Page Numbers -->
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li>
                                                <a href="?page=<?= $i ?>&category=<?= urlencode($cat_slug) ?>&search=<?= urlencode($search) ?>"
                                                   class="page-link <?= $i == $page ? 'active' : '' ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <!-- Next -->
                                        <li>
                                            <a href="?page=<?= min($total_pages, $page + 1) ?>&category=<?= urlencode($cat_slug) ?>&search=<?= urlencode($search) ?>"
                                               class="page-link next <?= $page == $total_pages ? 'disabled' : '' ?>">Next</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- /Pagination -->

                </div>
                <!-- /Blog Grid -->

                <!-- ─── Sidebar ────────────────────────────────────────────── -->
                <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

                    <!-- Search -->
                    <div class="card search-widget">
                        <div class="card-body">
                            <form class="search-form" method="GET" action="blog-grid.php">
                                <div class="input-group">
                                    <input type="text" name="search"
                                           placeholder="Search..."
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

                    <!-- Latest Posts -->
                    <div class="card post-widget">
                        <div class="card-body">
                            <h5 class="mb-3">Latest News</h5>
                            <ul class="latest-posts">
                                <?php
                                $latest_res->data_seek(0);
                                while ($latest = $latest_res->fetch_assoc()):
                                ?>
                                    <li>
                                        <div class="post-thumb">
                                            <a href="blog/<?= htmlspecialchars($latest['slug']) ?>">
                                                <img class="img-fluid"
                                                     src="<?= htmlspecialchars($latest['image']) ?>"
                                                     alt="<?= htmlspecialchars($latest['title']) ?>">
                                            </a>
                                        </div>
                                        <div class="post-info">
                                            <p><?= formatDate($latest['published_at']) ?></p>
                                            <h4>
                                                <a href="blog/<?= htmlspecialchars($latest['slug']) ?>">
                                                    <?= htmlspecialchars($latest['title']) ?>
                                                </a>
                                            </h4>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /Latest Posts -->

                    <!-- Categories -->
                    <div class="card category-widget">
                        <div class="card-body">
                            <h5 class="mb-3">Categories</h5>
                            <ul class="categories">
                                <?php
                                $categories_res->data_seek(0);
                                while ($cat = $categories_res->fetch_assoc()):
                                    $active = ($cat_slug === $cat['slug']) ? 'style="font-weight:600;"' : '';
                                ?>
                                    <li>
                                        <a href="blog-grid.php?category=<?= urlencode($cat['slug']) ?>" <?= $active ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                            <span>(<?= $cat['blog_count'] ?>)</span>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                                <?php if (!empty($cat_slug)): ?>
                                    <li><a href="blog-grid.php">View All</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /Categories -->

                    <!-- Tags -->
                    <div class="card tags-widget">
                        <div class="card-body">
                            <h5 class="mb-3">Tags</h5>
                            <ul class="tags">
                                <?php foreach ($all_tags as $tag): ?>
                                    <li>
                                        <a href="blog-grid.php?search=<?= urlencode($tag) ?>" class="tag">
                                            <?= htmlspecialchars($tag) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /Tags -->

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
                                <li><a href="contact-us">Contact Us</a></li>
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