<?php
require_once 'include/config.php';

// ─── Get slug from URL ────────────────────────────────────────────────────────
$slug = isset($_GET['slug']) ? clean($_GET['slug']) : '';

if (empty($slug)) {
    header("Location: " . SITE_URL . "/blogs.php");
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
             LEFT JOIN categories c ON b.category_id = c.id
             LEFT JOIN doctors    a ON b.doctor_id   = a.id
             WHERE b.slug = ? AND b.is_published = 1
             LIMIT 1";

$stmt = $conn->prepare($blog_sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$blog_res = $stmt->get_result();

if (!$blog_res || $blog_res->num_rows === 0) {
    http_response_code(404);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <base href="<?= SITE_URL ?>/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Blog Not Found | Dr. Agrawal's R.K. Hospital</title>
    <link rel="shortcut icon" href="<?= asset('assets/img/RK-Logo.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
    <style>
        .error-404-wrap {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 60px 20px;
        }
        .error-404-code {
            font-size: 100px;
            font-weight: 800;
            color: #1a6ef5;
            line-height: 1;
            margin-bottom: 10px;
        }
        .error-404-title {
            font-size: 26px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 12px;
        }
        .error-404-msg {
            color: #6c757d;
            font-size: 15px;
            margin-bottom: 30px;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <?php $headerClass = 'header-default inner-header'; include 'include/header.php'; ?>
    <div class="main-wrapper">
        <div class="error-404-wrap">
            <div>
                <div class="error-404-code">404</div>
                <div class="error-404-title">Blog Post Not Found</div>
                <p class="error-404-msg">
                    The blog post you're looking for doesn't exist or may have been removed.
                    Please check the URL or browse our latest articles.
                </p>
                <a href="index.php" class="btn btn-primary me-2">
                    <i class="fa fa-home me-1"></i> Go to Home
                </a>
                <a href="<?= SITE_URL ?>/blogs.php" class="btn btn-outline-primary">
                    <i class="fa fa-newspaper-o me-1"></i> Browse Blogs
                </a>
            </div>
        </div>
    </div>
    <script src="<?= asset('assets/js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= asset('assets/js/script.js') ?>"></script>
</body>
</html>
<?php
    exit;
}

$blog = $blog_res->fetch_assoc();

// ─── Increment view count ──────────────────────────────────────────────────────
$view_stmt = $conn->prepare("UPDATE blogs SET views = views + 1 WHERE slug = ?");
$view_stmt->bind_param("s", $slug);
$view_stmt->execute();

// ─── Build tags array ──────────────────────────────────────────────────────────
$tags = !empty($blog['tags'])
    ? array_map('trim', explode(',', $blog['tags']))
    : [];

// ─── Sidebar: Categories with count ───────────────────────────────────────────
$categories_sql = "SELECT c.name, c.slug, COUNT(b.id) as blog_count 
                   FROM categories c 
                   LEFT JOIN blogs b ON b.category_id = c.id AND b.is_published = 1
                   GROUP BY c.id ORDER BY blog_count DESC";
$categories_res = $conn->query($categories_sql);

// ─── Sidebar: Latest 4 posts ───────────────────────────────────────────────────
$latest_sql = "SELECT b.title, b.slug, b.image, b.published_at 
               FROM blogs b 
               WHERE b.is_published = 1 AND b.slug != ?
               ORDER BY b.published_at DESC LIMIT 4";
$latest_stmt = $conn->prepare($latest_sql);
$latest_stmt->bind_param("s", $slug);
$latest_stmt->execute();
$latest_res = $latest_stmt->get_result();

// ─── SEO ───────────────────────────────────────────────────────────────────────
$meta_desc = truncate(strip_tags($blog['content']), 160);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <base href="<?= SITE_URL ?>/">
    <title><?= htmlspecialchars($blog['title']) ?> - Dr. Agrawal's R.K. Hospital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <?php if (!empty($tags)): ?>
    <meta name="keywords" content="<?= htmlspecialchars(implode(', ', $tags)) ?>">
    <?php endif; ?>
    <meta name="author" content="Dr. Agrawal's R.K. Hospital">

    <meta property="og:title" content="<?= htmlspecialchars($blog['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:image" content="<?= asset($blog['image']) ?>">
    <meta property="og:url" content="<?= SITE_URL ?>/blog/<?= urlencode($blog['slug']) ?>">
    <meta property="og:type" content="article">

    <link rel="shortcut icon" href="<?= asset('assets/img/RK-Logo.png') ?>" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('assets/img/RK-Logo.png') ?>">
    <script src="<?= asset('assets/js/theme-script.js') ?>"></script>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/iconsax.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/feather.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fancybox/jquery.fancybox.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">

    <style>
        /* =============================================
           RESPONSIVE BLOG DETAIL PAGE - CUSTOM STYLES
           ============================================= */

        /* ── Global overflow fix ──────────────────────── */
        * {
            box-sizing: border-box;
        }
        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        /* ── Page Layout ─────────────────────────────── */
        .content {
            padding-top: 40px;
            padding-bottom: 40px;
            overflow-x: hidden;
        }
        .content .container {
            padding-left: 15px;
            padding-right: 15px;
        }
        .content .row {
            margin-left: 0;
            margin-right: 0;
        }
        .content .row > [class*="col-"] {
            padding-left: 12px;
            padding-right: 12px;
        }

        /* ── Blog View wrapper ────────────────────────── */
        .blog-view {
            width: 100%;
            overflow-x: hidden;
        }

        /* ── Blog Title ───────────────────────────────── */
        .blog-view h3 {
            font-size: clamp(1.15rem, 4vw, 1.75rem);
            font-weight: 700;
            line-height: 1.35;
            margin-bottom: 1rem;
            color: #1a1a2e;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }

        /* ── Blog Hero Image ──────────────────────────── */
        .blog-image {
            margin-bottom: 1rem;
            border-radius: 10px;
            overflow: hidden;
        }
        .blog-image img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
            border-radius: 10px;
        }

        /* ── Blog Meta Info Row ───────────────────────── */
        .blog-info {
            padding: 12px 0;
            border-top: 1px solid #f0f0f0;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 1.25rem;
            gap: 10px;
        }
        .blog-info .post-left ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px 16px;
        }
        .blog-info .post-left ul li {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: #555;
        }
        .blog-views {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 4px;
        }

        /* Author row inside meta */
        .post-author a {
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: #333;
        }
        .post-author img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e0e8ff;
        }

        /* ── Blog Content ─────────────────────────────── */
        .blog-content {
            font-size: 15px;
            line-height: 1.8;
            color: #333;
            word-break: break-word;
            overflow-wrap: break-word;
        }
        .blog-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .blog-content h1, .blog-content h2, .blog-content h3,
        .blog-content h4, .blog-content h5 {
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            font-weight: 700;
            color: #1a1a2e;
            line-height: 1.35;
        }
        .blog-content p {
            margin-bottom: 1rem;
        }
        .blog-content ul, .blog-content ol {
            padding-left: 1.4rem;
            margin-bottom: 1rem;
        }
        .blog-content a {
            color: #1a6ef5;
            word-break: break-all;
        }
        .blog-content table {
            width: 100%;
            overflow-x: auto;
            display: block;
        }

        /* ── About Author Box ─────────────────────────── */
        .about-author {
            display: flex;
            gap: 16px;
            align-items: flex-start;
            background: #f8faff;
            border: 1px solid #e4edff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 1.5rem;
        }
        .about-author-img .author-img-wrap img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e0e8ff;
            flex-shrink: 0;
        }
        .author-details h5 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 2px;
            color: #1a1a2e;
        }
        .author-details p {
            font-size: 13.5px;
            color: #555;
        }

        /* ── Tags ─────────────────────────────────────── */
        .blog-tags .badge {
            background: #eef3ff;
            color: #1a6ef5;
            border: 1px solid #c7d8ff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s;
        }
        .blog-tags .badge:hover {
            background: #1a6ef5;
            color: #fff;
        }

        /* ── Sidebar Cards ────────────────────────────── */
        .sidebar-right .card {
            border-radius: 12px;
            border: 1px solid #eaeaea;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        }
        .sidebar-right .card-body {
            padding: 18px;
        }
        .sidebar-right .card h5 {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
        }

        /* Search widget */
        .search-widget .input-group .form-control {
            border-radius: 8px 0 0 8px;
            border-right: none;
            font-size: 14px;
        }
        .search-widget .input-group .btn {
            border-radius: 0 8px 8px 0;
        }

        /* Categories widget */
        .categories {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .categories li {
            border-bottom: 1px solid #f2f2f2;
        }
        .categories li:last-child {
            border-bottom: none;
        }
        .categories li a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 4px;
            font-size: 14px;
            color: #444;
            text-decoration: none;
            transition: color 0.2s;
        }
        .categories li a:hover {
            color: #1a6ef5;
        }
        .categories li a span {
            font-size: 12px;
            color: #999;
            background: #f5f5f5;
            border-radius: 10px;
            padding: 2px 8px;
        }

        /* Latest posts widget */
        .latest-posts {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .latest-posts li {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid #f2f2f2;
        }
        .latest-posts li:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .post-thumb {
            flex-shrink: 0;
        }
        .post-thumb img {
            width: 70px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .post-info p {
            font-size: 12px;
            color: #999;
            margin-bottom: 3px;
        }
        .post-info h4 {
            font-size: 13px;
            font-weight: 600;
            margin: 0;
            line-height: 1.4;
        }
        .post-info h4 a {
            color: #1a1a2e;
            text-decoration: none;
        }
        .post-info h4 a:hover {
            color: #1a6ef5;
        }

        /* Tags widget */
        .tags {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .tags .tag {
            background: #eef3ff;
            color: #1a6ef5;
            border: 1px solid #c7d8ff;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }
        .tags .tag:hover {
            background: #1a6ef5;
            color: #fff;
        }

        /* Consultation card */
        .consultation-card {
            background: linear-gradient(135deg, #1a6ef5, #0a4fc4) !important;
            border: none !important;
        }

        /* =============================================
           RESPONSIVE BREAKPOINTS
           ============================================= */

        /* Tablet (768px - 991px) */
        @media (max-width: 991px) {
            .sidebar-right {
                margin-top: 30px;
            }
            .blog-view h3 {
                font-size: 1.4rem;
            }
            .about-author {
                flex-direction: row;
                align-items: flex-start;
            }
            .about-author-img .author-img-wrap img {
                width: 65px;
                height: 65px;
            }
        }

        /* Mobile (max 767px) */
        @media (max-width: 767px) {
            .content {
                padding-top: 16px;
                padding-bottom: 30px;
            }
            .content .container {
                padding-left: 14px;
                padding-right: 14px;
            }
            .content .row {
                margin-left: 0;
                margin-right: 0;
            }
            .content .row > [class*="col-"] {
                padding-left: 0;
                padding-right: 0;
            }
            .blog-view h3 {
                font-size: 1.2rem;
                margin-bottom: 0.75rem;
                padding: 0;
            }

            /* Meta info stacks on mobile */
            .blog-info {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 8px;
                padding: 10px 0;
            }
            .blog-info .post-left ul {
                gap: 8px 12px;
            }
            .blog-views {
                margin-top: 0;
                justify-content: flex-start !important;
            }

            /* Author box stacks */
            .about-author {
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 16px;
            }
            .about-author-img .author-img-wrap img {
                width: 70px;
                height: 70px;
            }

            /* Sidebar comes below on mobile */
            .sidebar-right {
                margin-top: 24px;
            }

            /* Latest post thumbs smaller */
            .post-thumb img {
                width: 60px;
                height: 52px;
            }

            /* Blog content font adjust */
            .blog-content {
                font-size: 14.5px;
            }

            /* Blog content inner images */
            .blog-content img {
                max-width: 100% !important;
                width: 100% !important;
                height: auto !important;
            }
        }

        /* Small phones (max 480px) */
        @media (max-width: 480px) {
            .content .container {
                padding-left: 12px;
                padding-right: 12px;
            }
            .blog-view h3 {
                font-size: 1.1rem;
            }
            .blog-content {
                font-size: 14px;
            }
            .about-author-img .author-img-wrap img {
                width: 60px;
                height: 60px;
            }
            .blog-info .post-left ul {
                gap: 6px 10px;
            }
            .blog-tags .badge {
                font-size: 12px;
                padding: 5px 11px;
            }
        }
    </style>
</head>

<body>
    <div class="main-wrapper">

        <?php $headerClass = 'header-default inner-header'; include 'include/header.php'; ?>

        <div class="content">
            <div class="container">
                <div class="row">

                    <!-- ── Main Blog Content ─────────────────────────── -->
                    <div class="col-lg-8 col-md-12">
                        <div class="blog-view">

                            <h3 class="mb-3"><?= htmlspecialchars($blog['title']) ?></h3>

                            <div class="blog blog-single-post">

                                <!-- Blog Hero Image -->
                                <div class="blog-image mb-3">
                                    <img
                                        alt="<?= htmlspecialchars($blog['title']) ?>"
                                        src="<?= asset($blog['image']) ?>"
                                        class="img-fluid w-100"
                                    >
                                </div>

                                <!-- Blog Meta -->
                                <div class="blog-info d-flex align-items-center justify-content-between flex-wrap">
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
                                                        <img
                                                            src="<?= asset($blog['author_photo']) ?>"
                                                            alt="<?= htmlspecialchars($blog['author_name']) ?>"
                                                        >
                                                        <span><?= htmlspecialchars($blog['author_name']) ?></span>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="blog-views">
                                        <span class="badge badge-outline-dark me-1">
                                            <i class="isax isax-message-text me-1"></i>
                                            <?= (int)$blog['comments'] ?>
                                        </span>
                                        <span class="badge badge-outline-primary">
                                            <i class="isax isax-eye me-1"></i>
                                            <?= (int)$blog['views'] ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Blog Body Content -->
                                <div class="blog-content">
                                    <?= $blog['content'] ?>
                                </div>

                            </div>

                            <!-- About Author -->
                            <h4 class="mb-3 mt-4">About the Author</h4>
                            <div class="about-author">
                                <div class="about-author-img">
                                    <div class="author-img-wrap">
                                        <a href="<?= htmlspecialchars($blog['author_url']) ?>">
                                            <img
                                                class="img-fluid"
                                                alt="<?= htmlspecialchars($blog['author_name']) ?>"
                                                src="<?= asset($blog['author_photo']) ?>"
                                            >
                                        </a>
                                    </div>
                                </div>
                                <div class="author-details">
                                    <h5 class="mb-1"><?= htmlspecialchars($blog['author_name']) ?></h5>
                                    <p class="text-muted mb-2"><?= htmlspecialchars($blog['author_designation']) ?></p>
                                    <p class="mb-0"><?= htmlspecialchars($blog['author_bio']) ?></p>
                                </div>
                            </div>

                            <!-- Tags (below content) -->
                            <?php if (!empty($tags)): ?>
                            <h4 class="mb-3 mt-4">Tags</h4>
                            <div class="d-flex align-items-center flex-wrap blog-tags gap-2 mb-4">
                                <?php foreach ($tags as $tag): ?>
                                <a href="<?= SITE_URL ?>/blogs/<?= urlencode($tag) ?>" class="badge">
                                    <?= htmlspecialchars($tag) ?>
                                </a>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>

                    <!-- ── Sidebar ───────────────────────────────────── -->
                    <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

                        <!-- Search -->
                        <div class="card search-widget">
                            <div class="card-body">
                                <form method="GET" action="<?= SITE_URL ?>/blogs.php">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            name="search"
                                            placeholder="Search articles..."
                                            class="form-control"
                                        >
                                        <button type="submit" class="btn btn-primary">
                                            <i class="isax isax-search-normal"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="card category-widget">
                            <div class="card-body">
                                <h5 class="mb-3">Categories</h5>
                                <ul class="categories">
                                    <?php
                                    if ($categories_res) {
                                        $categories_res->data_seek(0);
                                        while ($cat = $categories_res->fetch_assoc()):
                                            $is_active = ($blog['category_slug'] === $cat['slug']);
                                    ?>
                                    <li>
                                        <a
                                            href="<?= SITE_URL ?>/blogs/<?= urlencode($cat['slug']) ?>"
                                            <?= $is_active ? 'style="font-weight:700;color:#1a6ef5;"' : '' ?>
                                        >
                                            <?= htmlspecialchars($cat['name']) ?>
                                            <span>(<?= $cat['blog_count'] ?>)</span>
                                        </a>
                                    </li>
                                    <?php endwhile; } ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Latest Articles -->
                        <div class="card post-widget">
                            <div class="card-body">
                                <h5 class="mb-3">Latest Articles</h5>
                                <ul class="latest-posts">
                                    <?php if ($latest_res) { while ($latest = $latest_res->fetch_assoc()): ?>
                                    <li>
                                        <div class="post-thumb">
                                            <a href="<?= SITE_URL ?>/blog/<?= htmlspecialchars($latest['slug']) ?>">
                                                <img
                                                    src="<?= asset($latest['image']) ?>"
                                                    alt="<?= htmlspecialchars($latest['title']) ?>"
                                                >
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
                                    <?php endwhile; } ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Tags Sidebar -->
                        <?php if (!empty($tags)): ?>
                        <div class="card tags-widget">
                            <div class="card-body">
                                <h5 class="mb-3">Tags</h5>
                                <ul class="tags">
                                    <?php foreach ($tags as $tag): ?>
                                    <li>
                                        <a href="<?= SITE_URL ?>/blogs/<?= urlencode($tag) ?>" class="tag">
                                            <?= htmlspecialchars($tag) ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Consultation CTA -->
                        <div class="card consultation-card">
                            <div class="card-body text-center text-white p-4">
                                <i class="isax isax-hospital" style="font-size:36px;display:block;margin-bottom:12px;"></i>
                                <h5 class="text-white mb-2">Need a Consultation?</h5>
                                <p class="mb-3" style="font-size:14px;opacity:0.9;color:white;">
                                    Book an appointment with our specialist doctors at R.K. Hospital, Nagpur.
                                </p>
                                <a href="contact-us" class="btn btn-light fw-semibold w-100">
                                    <i class="isax isax-calendar-add me-2"></i>Book Appointment
                                </a>
                                <p class="mt-2 mb-0" style="font-size:13px;opacity:0.85;color:wheat;">
                                    <i class="fa-solid fa-phone me-1"></i> 097660 57372
                                </p>
                            </div>
                        </div>

                    </div>
                    <!-- ── End Sidebar ───────────────────────────────── -->

                </div>
            </div>
        </div>

        <?php include 'include/footer.php'; ?>

    </div><!-- .main-wrapper -->

    <script src="<?= asset('assets/js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') ?>"></script>
    <script src="<?= asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') ?>"></script>
    <script src="<?= asset('assets/plugins/fancybox/jquery.fancybox.min.js') ?>"></script>
    <script src="<?= asset('assets/js/script.js') ?>"></script>

</body>
</html>
<?php $conn->close(); ?>