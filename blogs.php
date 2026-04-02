<?php
require_once 'include/config.php';

// ─── Pagination ───────────────────────────────────────────
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * BLOGS_PER_PAGE;

// ─── Filters ──────────────────────────────────────────────
$cat_slug = '';
if (!empty($_GET['category'])) {
    $cat_slug = urldecode($_GET['category']);
    $cat_slug = preg_replace('/[^a-zA-Z0-9_\-\s]/', '', $cat_slug);
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// ─── Single WHERE block ────────────────────────────────────
$where = "WHERE b.is_published = 1";

if (!empty($cat_slug)) {
    $safe_cat  = $conn->real_escape_string($cat_slug);
    $where    .= " AND (c.slug = '$safe_cat' OR b.tags LIKE '%$safe_cat%')";
}

if (!empty($search)) {
    $safe_search = $conn->real_escape_string($search);
    $where      .= " AND (
                        b.title    LIKE '%$safe_search%'
                     OR b.excerpt  LIKE '%$safe_search%'
                     OR b.tags     LIKE '%$safe_search%'
                     OR c.name     LIKE '%$safe_search%'
                    )";
}

// ─── Total count (pagination) ─────────────────────────────
$count_sql   = "SELECT COUNT(*) as total 
                FROM blogs b
                LEFT JOIN categories c ON b.category_id = c.id
                $where";
$count_res   = $conn->query($count_sql);
$total_blogs = $count_res->fetch_assoc()['total'];
$total_pages = max(1, ceil($total_blogs / BLOGS_PER_PAGE));

// ─── Fetch Blogs ───────────────────────────────────────────
$blogs_sql = "SELECT
                b.id, b.title, b.slug, b.excerpt, b.image,
                b.views, b.comments, b.published_at,
                c.name  AS category_name,
                c.slug  AS category_slug,
                a.name  AS author_name,
                a.photo AS author_photo,
                a.profile_url AS author_url
              FROM blogs b
              LEFT JOIN categories c ON b.category_id = c.id
              LEFT JOIN doctors    a ON b.doctor_id   = a.id
              $where
              ORDER BY b.published_at DESC
              LIMIT " . (int)BLOGS_PER_PAGE . " OFFSET $offset";
$blogs_res = $conn->query($blogs_sql);

// ─── Sidebar: Categories ───────────────────────────────────
$categories_sql = "SELECT c.name, c.slug, COUNT(b.id) as blog_count
                   FROM categories c
                   LEFT JOIN blogs b ON b.category_id = c.id AND b.is_published = 1
                   GROUP BY c.id
                   ORDER BY blog_count DESC";
$categories_res = $conn->query($categories_sql);

// ─── Sidebar: Latest 4 Posts ───────────────────────────────
$latest_sql = "SELECT b.title, b.slug, b.image, b.published_at
               FROM blogs b
               WHERE b.is_published = 1
               ORDER BY b.published_at DESC
               LIMIT 4";
$latest_res = $conn->query($latest_sql);

// ─── Sidebar: All Unique Tags ──────────────────────────────
$tags_sql = "SELECT tags FROM blogs WHERE is_published = 1 AND tags IS NOT NULL AND tags != ''";
$tags_res = $conn->query($tags_sql);
$all_tags = [];
while ($row = $tags_res->fetch_assoc()) {
    foreach (array_map('trim', explode(',', $row['tags'])) as $tag) {
        if (!empty($tag) && !in_array($tag, $all_tags)) {
            $all_tags[] = $tag;
        }
    }
}

// ─── Helpers ───────────────────────────────────────────────
function blogCategoryUrl($slug) {
    return SITE_URL . '/blogs/' . urlencode($slug);
}

function blogPageUrl($pageNum, $catSlug, $searchStr) {
    if (!empty($catSlug)) {
        $url  = SITE_URL . '/blogs/' . urlencode($catSlug) . '?page=' . $pageNum;
        if (!empty($searchStr)) $url .= '&search=' . urlencode($searchStr);
    } else {
        $url  = SITE_URL . '/blogs.php?page=' . $pageNum;
        if (!empty($searchStr)) $url .= '&search=' . urlencode($searchStr);
    }
    return $url;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= !empty($cat_slug) ? ucfirst(str_replace('-', ' ', $cat_slug)) . ' Blogs' : 'Blogs' ?> - Dr. Agrawal's
        R.K. Hospital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Read health articles and blogs from Dr. Agrawal's R.K. Hospital, Nagpur — covering orthopedics, gynecology, surgery, pregnancy, and general wellness.">
    <meta name="keywords"
        content="hospital blog, orthopedic tips, gynecology advice, pregnancy care, RK Hospital Nagpur, health awareness">
    <meta name="author" content="Dr. Agrawal's R.K. Hospital">

    <link rel="shortcut icon" href="<?= SITE_URL ?>/assets/img/RK-Logo.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= SITE_URL ?>/assets/img/RK-Logo.png">
    <script src="<?= SITE_URL ?>/assets/js/theme-script.js"></script>
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/iconsax.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/feather.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/plugins/fancybox/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
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
                                        <a href="<?= SITE_URL ?>/blog/<?= htmlspecialchars($blog['slug']) ?>">
                                            <img class="img-fluid" src="<?= htmlspecialchars($blog['image']) ?>"
                                                alt="<?= htmlspecialchars($blog['title']) ?>">
                                        </a>
                                        <?php if (!empty($blog['category_name']) && !empty($blog['category_slug'])): ?>
                                        <span class="badge badge-cyan category-slug"
                                            onclick="window.location='<?= blogCategoryUrl($blog['category_slug']) ?>'"
                                            style="cursor:pointer;">
                                            <?= htmlspecialchars($blog['category_name']) ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="blog-content">
                                        <ul class="entry-meta meta-item">
                                            <li>
                                                <div class="post-author">
                                                    <a href="<?= htmlspecialchars($blog['author_url'] ?? '#') ?>">
                                                        <?php if (!empty($blog['author_photo'])): ?>
                                                        <img src="<?= htmlspecialchars($blog['author_photo']) ?>"
                                                            alt="<?= htmlspecialchars($blog['author_name'] ?? '') ?>">
                                                        <?php endif; ?>
                                                        <span><?= htmlspecialchars($blog['author_name'] ?? 'RK Hospital') ?></span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <i class="isax isax-calendar-1 me-1"></i>
                                                <?= formatDate($blog['published_at']) ?>
                                            </li>
                                        </ul>
                                        <h3 class="blog-title">
                                            <a href="<?= SITE_URL ?>/blog/<?= htmlspecialchars($blog['slug']) ?>">
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
                                    <a href="<?= SITE_URL ?>/blogs.php">Clear search</a>
                                    
                                    <?php elseif (!empty($cat_slug)): ?>
                                    No blogs found in this category.
                                    <a href="<?= SITE_URL ?>/blogs.php">View all blogs</a>
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
                                            <a href="<?= blogPageUrl(max(1, $page - 1), $cat_slug, $search) ?>"
                                                class="page-link prev <?= $page == 1 ? 'disabled' : '' ?>">Prev</a>
                                        </li>

                                        <!-- Page Numbers -->
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li>
                                            <a href="<?= blogPageUrl($i, $cat_slug, $search) ?>"
                                                class="page-link <?= $i == $page ? 'active' : '' ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                        <?php endfor; ?>

                                        <!-- Next -->
                                        <li>
                                            <a href="<?= blogPageUrl(min($total_pages, $page + 1), $cat_slug, $search) ?>"
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
                                <form method="GET" action="">
                                    <div class="input-group">
                                        <input type="text" name="search" placeholder="Search..."
                                            value="<?= htmlspecialchars($search) ?>" class="form-control">
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
                                            <a href="<?= SITE_URL ?>/blog/<?= htmlspecialchars($latest['slug']) ?>">
                                                <img class="img-fluid" src="<?= htmlspecialchars($latest['image']) ?>"
                                                    alt="<?= htmlspecialchars($latest['title']) ?>">
                                            </a>
                                        </div>
                                        <div class="post-info">
                                            <p><?= formatDate($latest['published_at']) ?></p>
                                            <h4>
                                                <a href="<?= SITE_URL ?>/blog/<?= htmlspecialchars($latest['slug']) ?>">
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
                                    $active = ($cat_slug === $cat['slug']) ? 'style="font-weight:600; color:#d32f2f;"' : '';
                                ?>
                                    <li>
                                        <!-- Clean URL: /blogs/gynecology -->
                                        <a href="<?= blogCategoryUrl($cat['slug']) ?>" <?= $active ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                            <span>(<?= $cat['blog_count'] ?>)</span>
                                        </a>
                                    </li>
                                    <?php endwhile; ?>
                                    <?php if (!empty($cat_slug)): ?>
                                    <li><a href="<?= SITE_URL ?>/blogs.php">View All</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <!-- /Categories -->

                        <div class="card tags-widget">
                            <div class="card-body">
                                <h5 class="mb-3">Tags</h5>
                                <ul class="tags">
                                    <?php foreach ($all_tags as $tag): ?>
                                    <li>
                                        <a href="<?= SITE_URL ?>/blogs/<?= urlencode($tag) ?>" class="tag">
                                            <?= htmlspecialchars($tag) ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!-- /Sidebar -->

                </div>
            </div>
        </div>
        <!-- /Page Content -->

       <?php include 'include/footer.php'; ?>
        <!-- /Footer -->

    </div>
    <!-- /Main Wrapper -->

    <script src="<?= SITE_URL ?>/assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?= SITE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= SITE_URL ?>/assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
    <script src="<?= SITE_URL ?>/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
    <script src="<?= SITE_URL ?>/assets/plugins/fancybox/jquery.fancybox.min.js"></script>
    <script src="<?= SITE_URL ?>/assets/js/script.js"></script>
</body>

</html>
<?php $conn->close(); ?>