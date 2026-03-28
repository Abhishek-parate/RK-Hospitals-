<?php
require_once 'include/config.php';

// ─── Get slug from URL ────────────────────────────────────────────────────────
$slug = isset($_GET['slug']) ? clean($_GET['slug']) : '';

if (empty($slug)) {
    header("Location: services.php");
    exit;
}

// ─── Fetch the service (Updated with Prepared Statements for Security) ─────────
$service_sql = "SELECT 
                  s.id, s.title, s.hero_title, s.hero_subtitle,
                  s.hero_image, s.hero_image_alt, s.slug,
                  s.short_description, s.h1_title, s.breadcrumb_json,
                  s.content, s.sections_json, s.faqs_json,
                  s.image, s.image_alt, s.gallery_json, s.icon,
                  s.related_services_json,
                  s.meta_title, s.meta_description, s.focus_keyword,
                  s.canonical_url, s.og_title, s.og_description,
                  s.og_image, s.og_type, s.twitter_title,
                  s.twitter_description, s.twitter_card,
                  s.robots_meta, s.schema_type, s.schema_json,
                  s.created_at, s.updated_at,
                  c.name AS category_name, c.slug AS category_slug
                FROM services s
                LEFT JOIN categories c ON s.category_id = c.id
                WHERE s.slug = ? AND s.is_published = 1
                LIMIT 1";

$stmt = $conn->prepare($service_sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$service_res = $stmt->get_result();

if (!$service_res || $service_res->num_rows === 0) {
    http_response_code(404);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="<?= SITE_URL ?>/"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Service Not Found | Dr. Agrawal's R.K. Hospital</title>    
    <link rel="shortcut icon" href="<?= asset('assets/img/favicon.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
    <style>
        .error-404-wrap { min-height: 80vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 60px 20px; }
        .error-404-code { font-size: 100px; font-weight: 800; color: #1a6ef5; line-height: 1; margin-bottom: 10px; }
        .error-404-title { font-size: 26px; font-weight: 700; color: #1a1a2e; margin-bottom: 12px; }
        .error-404-msg { color: #6c757d; font-size: 15px; margin-bottom: 30px; max-width: 440px; margin-left: auto; margin-right: auto; }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="error-404-wrap">
            <div>
                <div class="error-404-code">404</div>
                <div class="error-404-title">Service Not Found</div>
                <p class="error-404-msg">The service page you're looking for doesn't exist or may have been removed. Please check the URL or browse our services.</p>
                <a href="index.php" class="btn btn-primary me-2"><i class="fa fa-home me-1"></i> Go to Home</a>
                <a href="services.php" class="btn btn-outline-primary"><i class="fa fa-th-large me-1"></i> Browse Services</a>
            </div>
        </div>
    </div>
    <script src="<?= asset('assets/js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
<?php
    exit;
}

$service = $service_res->fetch_assoc();

// ─── Decode JSON fields ───────────────────────────────────────────────────────
$faqs            = !empty($service['faqs_json'])            ? json_decode($service['faqs_json'], true)            : [];
$sections        = !empty($service['sections_json'])        ? json_decode($service['sections_json'], true)        : [];
$gallery         = !empty($service['gallery_json'])         ? json_decode($service['gallery_json'], true)         : [];
$related_slugs   = !empty($service['related_services_json'])? json_decode($service['related_services_json'], true): [];
$breadcrumb_data = !empty($service['breadcrumb_json'])      ? json_decode($service['breadcrumb_json'], true)      : [];

// ─── SEO values with fallbacks ────────────────────────────────────────────────
$meta_title       = !empty($service['meta_title'])       ? $service['meta_title']       : $service['title'] . ' in Nagpur | RK Hospital';
$meta_desc        = !empty($service['meta_description']) ? $service['meta_description'] : truncate(strip_tags($service['short_description'] ?? $service['content']), 160);
$canonical        = !empty($service['canonical_url'])    ? $service['canonical_url']    : SITE_URL . '/service/' . $service['slug'];
$og_title         = !empty($service['og_title'])         ? $service['og_title']         : $meta_title;
$og_desc          = !empty($service['og_description'])   ? $service['og_description']   : $meta_desc;
$og_image         = !empty($service['og_image'])         ? $service['og_image']         : ($service['hero_image'] ?: $service['image']);
$twitter_title    = !empty($service['twitter_title'])    ? $service['twitter_title']    : $og_title;
$twitter_desc     = !empty($service['twitter_description'])? $service['twitter_description'] : $og_desc;
$hero_img         = !empty($service['hero_image'])       ? $service['hero_image']       : 'assets/img/service/service-01.jpg';
$page_h1          = !empty($service['h1_title'])         ? $service['h1_title']         : $service['title'];
$hero_title       = !empty($service['hero_title'])       ? $service['hero_title']       : $service['title'];
$hero_subtitle    = $service['hero_subtitle'] ?? $service['short_description'] ?? '';

// ─── Sidebar: All published services ─────────────────────────────────────────
$all_services_sql = "SELECT s.title, s.slug, s.icon, c.name AS category_name
                     FROM services s
                     LEFT JOIN categories c ON s.category_id = c.id
                     WHERE s.is_published = 1
                     ORDER BY s.sort_order ASC, s.title ASC";
$all_services_res = $conn->query($all_services_sql);

// ─── Sidebar: Related services ───────────────────────────────────────────────
$related_services = [];
if (!empty($related_slugs)) {
    $in_slugs = implode("','", array_map('clean', $related_slugs));
    $rel_sql  = "SELECT title, slug, icon FROM services WHERE slug IN ('$in_slugs') AND is_published = 1 LIMIT 5";
} else {
    $rel_sql = "SELECT title, slug, icon FROM services 
                WHERE category_id = (SELECT category_id FROM services WHERE slug = '$slug')
                AND slug != '$slug' AND is_published = 1 LIMIT 5";
}
$rel_res = $conn->query($rel_sql);
while ($r = $rel_res->fetch_assoc()) {
    $related_services[] = $r;
}

// ─── Latest blogs (sidebar) ───────────────────────────────────────────────────
$latest_blogs_sql = "SELECT b.title, b.slug, b.image, b.published_at 
                     FROM blogs b 
                     WHERE b.is_published = 1
                     ORDER BY b.published_at DESC LIMIT 3";
$latest_blogs_res = $conn->query($latest_blogs_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <base href="<?= SITE_URL ?>/">

    <title><?= htmlspecialchars($meta_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <?php if (!empty($service['focus_keyword'])): ?>
    <meta name="keywords" content="<?= htmlspecialchars($service['focus_keyword']) ?>">
    <?php endif; ?>
    <meta name="author" content="RK Hospital Nagpur">
    <meta name="robots" content="<?= htmlspecialchars($service['robots_meta'] ?? 'index,follow') ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>">

    <meta property="og:type" content="<?= htmlspecialchars($service['og_type'] ?? 'website') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($og_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($og_desc) ?>">
    <meta property="og:image" content="<?= htmlspecialchars(SITE_URL . '/' . $og_image) ?>">

    <meta name="twitter:card" content="<?= htmlspecialchars($service['twitter_card'] ?? 'summary_large_image') ?>">
    <meta name="twitter:title" content="<?= htmlspecialchars($twitter_title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($twitter_desc) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars(SITE_URL . '/' . $og_image) ?>">

    <?php if (!empty($service['schema_json'])): ?>
    <script type="application/ld+json"><?= $service['schema_json'] ?></script>
    <?php else: ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MedicalWebPage",
        "name": "<?= addslashes(htmlspecialchars($service['title'])) ?>",
        "description": "<?= addslashes(htmlspecialchars($meta_desc)) ?>",
        "url": "<?= $canonical ?>",
        "breadcrumb": {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {"@type":"ListItem","position":1,"name":"Home","item":"<?= SITE_URL ?>"},
                {"@type":"ListItem","position":2,"name":"Services","item":"<?= SITE_URL ?>/services.php"},
                {"@type":"ListItem","position":3,"name":"<?= addslashes(htmlspecialchars($service['title'])) ?>","item":"<?= $canonical ?>"}
            ]
        },
        "publisher": {
            "@type": "Hospital",
            "name": "Dr. Agrawal's R.K. Hospital",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Central Avenue, Ladpura, Itwari",
                "addressLocality": "Nagpur",
                "addressRegion": "Maharashtra",
                "addressCountry": "IN"
            },
            "telephone": "097660 57372"
        }
    }
    </script>
    <?php endif; ?>

    <?php if (!empty($faqs)): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            <?php foreach ($faqs as $i => $faq): ?>
            {
                "@type": "Question",
                "name": "<?= addslashes(htmlspecialchars($faq['q'])) ?>",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "<?= addslashes(htmlspecialchars($faq['a'])) ?>"
                }
            }<?= ($i < count($faqs) - 1) ? ',' : '' ?>
            <?php endforeach; ?>
        ]
    }
    </script>
    <?php endif; ?>

    <link rel="shortcut icon" href="<?= asset('assets/img/favicon.png') ?>" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('assets/img/apple-touch-icon.png') ?>">

    <script src="<?= asset('assets/js/theme-script.js') ?>"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/animate.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/iconsax.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/feather.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/slick/slick.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/slick/slick-theme.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/wow/css/animate.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/select2/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fancybox/jquery.fancybox.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">

    <style>
        /* ── Appointment Form Styles ─────────────────────────────────── */
        .date-icon {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%); color: #0d6efd; pointer-events: none;
        }
        .flatpickr-calendar { border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,.1); }
        .flatpickr-day.selected { background: #0d6efd; border-color: #0d6efd; }
        .flatpickr-day:hover { background: #e7f1ff; color: #0d6efd; }

        /* ── Custom bullet points ────────────────────────────────────── */
        .custom-point {
            position: relative; padding: 16px 16px 16px 45px;
            background: #fff; border-radius: 10px;
            transition: all .3s ease; border: 1px solid #f1f1f1;
        }
        .custom-point:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.05); }
        .custom-point::before {
            content: ""; position: absolute; left: 15px; top: 20px;
            width: 12px; height: 12px; border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #00c6ff);
            box-shadow: 0 0 0 4px rgba(13,110,253,.15);
        }
        .custom-point h6 { margin-bottom: 5px; font-weight: 600; color: #0b1c39; }
        .custom-point p  { margin: 0; font-size: 14px; color: #6c757d; }

        /* ── Icon badge ──────────────────────────────────────────────── */
        .icon-style {
            width: 60px; height: 60px; background: #6f42c1;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
        }
        .icon-style i { color: #fff; font-size: 24px; }

        /* ── Service nav list (sidebar) ──────────────────────────────── */
        .service-nav-list { list-style: none; padding: 0; margin: 0; }
        .service-nav-list li a {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px; color: #444;
            text-decoration: none; font-size: 14px; font-weight: 500;
            transition: background .2s, color .2s;
        }
        .service-nav-list li a:hover,
        .service-nav-list li.active a {
            background: #e7f1ff; color: #0d6efd;
        }
        .service-nav-list li.active a { font-weight: 700; }
        .service-nav-list li a i { font-size: 18px; color: #0d6efd; flex-shrink: 0; }

        /* ── Gallery grid ────────────────────────────────────────────── */
        .service-gallery img {
            border-radius: 10px; object-fit: cover;
            width: 100%; height: 140px; transition: transform .3s;
        }
        .service-gallery a:hover img { transform: scale(1.04); }

        /* ── About section ───────────────────────────────────────────── */
        .aboutsection { padding: 40px 0 0; }
    </style>
</head>

<body>

    <div class="main-wrapper">

        <div class="header-theme header-theme-two">
            <button type="button" id="dark-mode-toggle" class="theme-toggle moon">
                <i class="isax isax-moon5"></i>
            </button>
            <button type="button" id="light-mode-toggle" class="theme-toggle sun">
                <i class="isax isax-sun-15"></i>
            </button>
        </div>

        <?php include 'include/header.php'; ?>

        <div class="breadcrumb-bar" style="
            min-height: 500px;
            display: flex; align-items: center; position: relative;
            background: url('<?= asset($hero_img) ?>') center center / cover no-repeat;">

            <div style="position:absolute;inset:0;background:rgba(0,0,0,.50);"></div>

            <div class="container" style="position:relative;z-index:2;">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">

                        <?php if (!empty($service['category_name'])): ?>
                        <span class="badge mb-3 px-3 py-2"
                              style="background:rgba(255,255,255,.2);color:#fff;font-size:13px;border:1px solid rgba(255,255,255,.4);border-radius:30px;">
                            <?= htmlspecialchars($service['category_name']) ?>
                        </span>
                        <?php endif; ?>

                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item">
                                    <a href="index.php"><i class="isax isax-home-15"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="services.php">Services</a>
                                </li>
                                <?php if (!empty($service['category_name'])): ?>
                                <li class="breadcrumb-item">
                                    <a href="services.php?category=<?= urlencode($service['category_slug']) ?>">
                                        <?= htmlspecialchars($service['category_name']) ?>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= htmlspecialchars($service['title']) ?>
                                </li>
                            </ol>

                            <h1 class="breadcrumb-title"><?= htmlspecialchars($page_h1) ?></h1>

                            <?php if (!empty($hero_subtitle)): ?>
                            <p style="color:rgba(255,255,255,.85);max-width:620px;margin:12px auto 0;font-size:16px;">
                                <?= htmlspecialchars($hero_subtitle) ?>
                            </p>
                            <?php endif; ?>
                        </nav>

                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($hero_title) || !empty($service['short_description'])): ?>
        <div class="about-sec aboutsection">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-5 mb-4 mb-lg-0">
                        <div class="about-img-ten">
                            <div class="about-img-01">
                                <img src="<?= asset($service['image'] ?: 'assets/img/service/service-02.jpg') ?>"
                                     class="img-fluid"
                                     alt="<?= htmlspecialchars($service['image_alt'] ?: $service['title'] . ' - RK Hospital') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="about-content-ten">
                            <div class="section-header section-header-ten">
                                <div class="section-sub-title">
                                    <span class="dot"></span>
                                    <?= htmlspecialchars($service['category_name'] ?? 'Medical Services') ?> — Nagpur
                                </div>
                                <h2 class="section-title"><?= htmlspecialchars($hero_title) ?></h2>
                                <?php if (!empty($service['short_description'])): ?>
                                <p><?= htmlspecialchars($service['short_description']) ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="mission-item-ten wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1s">
                                <div class="mission-icon">
                                    <div class="mission-inner icon-style">
                                        <i class="fa-solid fa-user-doctor"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="custom-title">Expert Specialists in Nagpur</h3>
                                    <p>Experienced doctors and surgeons trusted by thousands of patients across Nagpur and Central India.</p>
                                </div>
                            </div>

                            <div class="mission-item-ten wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="1s">
                                <div class="mission-icon">
                                    <div class="mission-inner icon-style">
                                        <i class="fa-solid fa-heart-pulse"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="custom-title">Personalised, Comprehensive Treatment</h3>
                                    <p>Combining advanced diagnostics, modern procedures, and compassionate follow-up care — all under one roof.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="content">
            <div class="container">
                <div class="row">

                    <div class="col-md-7 col-lg-9 col-xl-9">

                        <div class="card">
                            <div class="card-body">
                                <div class="doctor-widget">
                                    <div class="doc-info-left">
                                        <div class="doctor-img1">
                                            <img src="<?= asset($service['image'] ?: 'assets/img/service/service-02.jpg') ?>"
                                                 class="img-fluid"
                                                 alt="<?= htmlspecialchars($service['image_alt'] ?: $service['title'] . ' Nagpur') ?>">
                                        </div>
                                        <div class="doc-info-cont">
                                            <h2 class="doc-name mb-2"><?= htmlspecialchars($service['title']) ?></h2>
                                            <p class="text-muted mb-1">
                                                <i class="isax isax-hospital me-1 text-primary"></i>
                                                Department of <?= htmlspecialchars($service['category_name'] ?? 'Medical Services') ?>
                                            </p>
                                            <p class="text-muted mb-2">
                                                <i class="isax isax-location me-1 text-primary"></i>
                                                RK Hospital, Nagpur, Maharashtra
                                            </p>
                                            <?php if (!empty($service['short_description'])): ?>
                                            <p><?= htmlspecialchars($service['short_description']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body pt-0">

                                <h2 class="pt-4">
                                    About <?= htmlspecialchars($service['title']) ?> at RK Hospital
                                </h2>
                                <hr>

                                <div class="tab-content pt-3">
                                    <div class="tab-pane fade show active">

                                        <?php if (!empty($service['content'])): ?>
                                        <div class="widget about-widget">
                                            <div class="service-content">
                                                <?= $service['content'] /* Stored as HTML from admin */ ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if (!empty($sections)): ?>
                                        <?php foreach ($sections as $section): ?>
                                        <div class="widget about-widget">
                                            <?php if (!empty($section['h2'])): ?>
                                            <h3 class="widget-title"><?= htmlspecialchars($section['h2']) ?></h3>
                                            <?php endif; ?>
                                            <?php if (!empty($section['content'])): ?>
                                            <p><?= nl2br(htmlspecialchars($section['content'])) ?></p>
                                            <?php endif; ?>
                                            <?php if (!empty($section['list'])): ?>
                                            <div class="experience-box">
                                                <ul class="experience-list">
                                                    <?php foreach ($section['list'] as $item): ?>
                                                    <li>
                                                        <div class="experience-user"><div class="before-circle"></div></div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <p><?= htmlspecialchars($item) ?></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; ?>
                                        <?php endif; ?>

                                        <?php if (!empty($gallery)): ?>
                                        <div class="widget about-widget">
                                            <h3 class="widget-title">Gallery</h3>
                                            <div class="row g-3 service-gallery">
                                                <?php foreach ($gallery as $img): ?>
                                                <div class="col-md-4 col-6">
                                                    <a href="<?= htmlspecialchars($img['src']) ?>" data-fancybox="service-gallery">
                                                        <img src="<?= htmlspecialchars($img['src']) ?>"
                                                             alt="<?= htmlspecialchars($img['alt'] ?? $service['title']) ?>">
                                                    </a>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <div class="widget about-widget">
                                            <h3 class="widget-title">
                                                Why Choose RK Hospital for <?= htmlspecialchars($service['title']) ?> in Nagpur?
                                            </h3>
                                            <div class="row g-4 mt-2">
                                                <div class="col-md-6">
                                                    <div class="custom-point">
                                                        <h6>Experienced Specialists</h6>
                                                        <p>Senior consultants with years of focused expertise in <?= htmlspecialchars($service['title']) ?>.</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom-point">
                                                        <h6>Advanced Equipment</h6>
                                                        <p>State-of-the-art diagnostic and surgical technology for accurate results and safe procedures.</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom-point">
                                                        <h6>Personalised Care Plans</h6>
                                                        <p>Every patient receives an individualised treatment plan tailored to their condition and lifestyle.</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom-point">
                                                        <h6>Easy Appointment Booking</h6>
                                                        <p>Book online or call us. Flexible slots including evenings and weekends available.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if (!empty($faqs)): ?>
                                        <div class="widget about-widget mb-0">
                                            <h3 class="widget-title">
                                                Frequently Asked Questions about <?= htmlspecialchars($service['title']) ?>
                                            </h3>
                                            <div class="accordion mt-3" id="faq-service">
                                                <?php foreach ($faqs as $fi => $faq): ?>
                                                <div class="accordion-item">
                                                    <h4 class="accordion-header">
                                                        <a href="javascript:void(0);"
                                                           class="accordion-button <?= $fi > 0 ? 'collapsed' : '' ?>"
                                                           data-bs-toggle="collapse"
                                                           data-bs-target="#sfaq<?= $fi ?>"
                                                           aria-expanded="<?= $fi === 0 ? 'true' : 'false' ?>">
                                                            <?= htmlspecialchars($faq['q']) ?>
                                                        </a>
                                                    </h4>
                                                    <div id="sfaq<?= $fi ?>"
                                                         class="accordion-collapse collapse <?= $fi === 0 ? 'show' : '' ?>"
                                                         data-bs-parent="#faq-service">
                                                        <div class="accordion-body">
                                                            <p><?= nl2br(htmlspecialchars($faq['a'])) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                    </div>
                                </div>

                            </div>
                        </div>
                        </div>
                    <div class="col-md-5 col-lg-3 col-xl-3 theiaStickySidebar">

                        <div class="card search-filter">
                            <div class="card-body">
                                <h4 class="card-title mb-3">
                                    <i class="isax isax-calendar-add me-2 text-primary"></i>Book an Appointment
                                </h4>
                                <form action="booking.php" method="POST" id="appointmentForm" novalidate>
                                    <input type="hidden" name="department"
                                           value="<?= htmlspecialchars($service['category_slug'] ?? 'general') ?>">
                                    <input type="hidden" name="service_id"
                                           value="<?= (int)$service['id'] ?>">

                                    <div class="mb-3">
                                        <label class="form-label" for="apptName">
                                            Full Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" id="apptName" class="form-control"
                                               placeholder="Enter your full name" autocomplete="name">
                                        <div class="invalid-feedback">
                                            Please enter your full name (letters only, min 3 characters).
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="apptPhone">
                                            Phone Number <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel" name="phone" id="apptPhone" class="form-control"
                                               placeholder="+91 XXXXX XXXXX" maxlength="13" autocomplete="tel">
                                        <div class="invalid-feedback">
                                            Enter a valid 10-digit Indian mobile number.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="appointmentDate">
                                            Preferred Date <span class="text-danger">*</span>
                                        </label>
                                        <div class="position-relative">
                                            <input type="text" name="date" id="appointmentDate"
                                                   class="form-control" placeholder="Select Date" readonly>
                                            <span class="date-icon">
                                                <i class="isax isax-calendar"></i>
                                            </span>
                                        </div>
                                        <div class="text-danger small mt-1" id="dateError" style="display:none;">
                                            Please select a preferred appointment date.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="apptService">
                                            Service <span class="text-danger">*</span>
                                        </label>
                                        <select name="service" id="apptService" class="form-control select">
                                            <option value="">-- Select a Service --</option>
                                            <?php
                                            if ($all_services_res) {
                                                $all_services_res->data_seek(0);
                                                while ($sv = $all_services_res->fetch_assoc()):
                                                    $sel = ($sv['slug'] === $service['slug']) ? 'selected' : '';
                                            ?>
                                            <option value="<?= htmlspecialchars($sv['slug']) ?>" <?= $sel ?>>
                                                <?= htmlspecialchars($sv['title']) ?>
                                            </option>
                                            <?php endwhile; } ?>
                                        </select>
                                        <div class="invalid-feedback">Please select a service.</div>
                                    </div>

                                    <div class="clinic-booking mt-3">
                                        <button type="submit" class="btn btn-primary btn-primary-gradient w-100">
                                            <i class="isax isax-calendar-add me-2"></i>Book Appointment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card search-filter">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Our Services</h4>
                                <ul class="service-nav-list">
                                    <?php
                                    if ($all_services_res) {
                                        $all_services_res->data_seek(0);
                                        while ($sv = $all_services_res->fetch_assoc()):
                                            $active = ($sv['slug'] === $service['slug']) ? 'active' : '';
                                    ?>
                                    <li class="<?= $active ?>">
                                        <a href="single-service.php?slug=<?= urlencode($sv['slug']) ?>">
                                            <i class="isax isax-arrow-right-3"></i>
                                            <?= htmlspecialchars($sv['title']) ?>
                                        </a>
                                    </li>
                                    <?php endwhile; } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card search-filter">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Quick Contact</h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="contact-icon"><i class="isax isax-call-calling"></i></div>
                                            <div>
                                                <p class="mb-0 text-muted small">Emergency / OPD</p>
                                                <a href="tel:+910976605737"><b>097660 57372</b></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="contact-icon"><i class="isax isax-messages-3"></i></div>
                                            <div>
                                                <p class="mb-0 text-muted small">Email Us</p>
                                                <a href="mailto:info@rkhospital.com"><b>info@rkhospital.com</b></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="contact-icon"><i class="isax isax-location"></i></div>
                                            <div>
                                                <p class="mb-0 text-muted small">Location</p>
                                                <b>Central Avenue, Itwari, Nagpur</b>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0 border-0">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="contact-icon"><i class="isax isax-clock"></i></div>
                                            <div>
                                                <p class="mb-0 text-muted small">Working Hours</p>
                                                <b>Mon–Sat: 9AM – 7PM</b>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php if (!empty($related_services)): ?>
                        <div class="card search-filter">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Related Services</h4>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($related_services as $rs): ?>
                                    <li class="list-group-item px-0 border-0 py-1">
                                        <a href="single-service.php?slug=<?= urlencode($rs['slug']) ?>"
                                           class="d-flex align-items-center gap-2 text-dark">
                                            <i class="isax isax-arrow-right-3 text-primary"></i>
                                            <?= htmlspecialchars($rs['title']) ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if ($latest_blogs_res && $latest_blogs_res->num_rows > 0): ?>
                        <div class="card post-widget search-filter">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Latest Articles</h4>
                                <ul class="latest-posts">
                                    <?php while ($lb = $latest_blogs_res->fetch_assoc()): ?>
                                    <li>
                                        <div class="post-thumb">
                                            <a href="blog/<?= htmlspecialchars($lb['slug']) ?>">
                                                <img class="img-fluid"
                                                     src="<?= htmlspecialchars($lb['image']) ?>"
                                                     alt="<?= htmlspecialchars($lb['title']) ?>">
                                            </a>
                                        </div>
                                        <div class="post-info">
                                            <p><?= formatDate($lb['published_at']) ?></p>
                                            <h4>
                                                <a href="blog/<?= htmlspecialchars($lb['slug']) ?>">
                                                    <?= htmlspecialchars($lb['title']) ?>
                                                </a>
                                            </h4>
                                        </div>
                                    </li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        </div>
                    </div>
            </div>
        </div>
        <?php include 'include/footer.php'; ?>

        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>
    </div>
    <div class="offcanvas offcanvas-offset offcanvas-end support_popup" tabindex="-1" id="support_item">
        <div class="offcanvas-header">
            <a href="index.php"><img src="<?= asset('assets/img/logo.svg') ?>" alt="logo" class="img-fluid logo"></a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="isax isax-close-circle"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="about-popup-item">
                <h3 class="title">About RK Hospital</h3>
                <p>Modern healthcare platform providing compassionate, advanced medical services to patients across Nagpur and Central India.</p>
            </div>
            <div class="about-popup-item">
                <h3 class="title">Our Location</h3>
                <div class="loction-item">
                    <h4 class="title">Nagpur</h4>
                    <p class="location">Central Avenue, Ladpura, Itwari, Nagpur</p>
                </div>
            </div>
            <div class="about-popup-item border-0">
                <h3 class="title">Follow Us</h3>
                <ul class="d-flex align-items-center gap-2 social-iyem">
                    <li><a href="#" class="social-icon"><i class="fa-brands fa-facebook"></i></a></li>
                    <li><a href="#" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a></li>
                    <li><a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="#" class="social-icon"><i class="fa-brands fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
        <img src="<?= asset('assets/img/bg/offcanvas-bg.png') ?>" alt="element" class="element-01">
    </div>

    <div class="progress-wrap active-progress">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                  style="transition:stroke-dashoffset 10ms linear;stroke-dasharray:307.919px,307.919px;stroke-dashoffset:228.265px;">
            </path>
        </svg>
    </div>

    <script src="<?= asset('assets/js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') ?>"></script>
    <script src="<?= asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') ?>"></script>
    <script src="<?= asset('assets/plugins/select2/js/select2.min.js') ?>"></script>
    <script src="<?= asset('assets/js/feather.min.js') ?>"></script>
    <script src="<?= asset('assets/js/backToTop.js') ?>"></script>
    <script src="<?= asset('assets/plugins/slick/slick.min.js') ?>"></script>
    <script src="<?= asset('assets/plugins/fancybox/jquery.fancybox.min.js') ?>"></script>
    <script src="<?= asset('assets/plugins/wow/js/wow.min.js') ?>"></script>
    <script src="<?= asset('assets/js/script.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
    // ── Flatpickr init ─────────────────────────────────────────────────────
    flatpickr("#appointmentDate", {
        minDate: "today",
        dateFormat: "j M Y",
        disableMobile: true,
        animate: true
    });

    // ── Sticky Sidebar ────────────────────────────────────────────────────
    $(document).ready(function () {
        if ($('.theiaStickySidebar').length) {
            $(".theiaStickySidebar").theiaStickySidebar({ additionalMarginTop: 30 });
        }
        // Select2
        if ($.fn.select2) {
            $('.select').select2({ minimumResultsForSearch: Infinity });
        }
        // WOW
        new WOW().init();
        // Feather
        if (typeof feather !== 'undefined') feather.replace();
    });
    </script>

    <script>
    (function () {
        'use strict';

        var form     = document.getElementById('appointmentForm');
        if (!form) return;

        var nameEl    = document.getElementById('apptName');
        var phoneEl   = document.getElementById('apptPhone');
        var dateEl    = document.getElementById('appointmentDate');
        var serviceEl = document.getElementById('apptService');
        var dateError = document.getElementById('dateError');

        function isValidName(v)    { return v.trim().length >= 3 && /^[a-zA-Z\s'.]+$/.test(v.trim()); }
        function isValidPhone(v)   { var c = v.replace(/[\s\-]/g,''); return /^(\+91|91)?[6-9]\d{9}$/.test(c); }
        function isValidDate(v)    { return v.trim() !== ''; }
        function isValidService(v) { return v !== ''; }

        function markValid(el)    { el.classList.remove('is-invalid'); el.classList.add('is-valid'); }
        function markInvalid(el)  { el.classList.remove('is-valid'); el.classList.add('is-invalid'); }
        function clearMark(el)    { el.classList.remove('is-valid','is-invalid'); }

        function markDateValid()   { dateEl.classList.remove('is-invalid'); dateEl.classList.add('is-valid'); dateError.style.display = 'none'; }
        function markDateInvalid() { dateEl.classList.remove('is-valid'); dateEl.classList.add('is-invalid'); dateError.style.display = 'block'; }

        nameEl.addEventListener('blur',  function() { isValidName(this.value) ? markValid(this) : markInvalid(this); });
        nameEl.addEventListener('input', function() { if (this.classList.contains('is-invalid')) { isValidName(this.value) ? markValid(this) : markInvalid(this); } });

        phoneEl.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+\s]/g,'');
            this.value.trim() ? (isValidPhone(this.value) ? markValid(this) : markInvalid(this)) : clearMark(this);
        });
        phoneEl.addEventListener('blur', function() {
            !this.value.trim() ? markInvalid(this) : (isValidPhone(this.value) ? markValid(this) : markInvalid(this));
        });

        serviceEl.addEventListener('change', function() { isValidService(this.value) ? markValid(this) : markInvalid(this); });

        if (typeof flatpickr !== 'undefined') {
            flatpickr('#appointmentDate', {
                minDate: 'today', dateFormat: 'j M Y', disableMobile: true, animate: true,
                onChange: function(d) { d.length > 0 ? markDateValid() : markDateInvalid(); }
            });
        }

        form.addEventListener('submit', function (e) {
            var valid = true;
            if (!isValidName(nameEl.value))        { markInvalid(nameEl);    valid = false; } else markValid(nameEl);
            if (!isValidPhone(phoneEl.value))       { markInvalid(phoneEl);   valid = false; } else markValid(phoneEl);
            if (!isValidDate(dateEl.value))         { markDateInvalid();       valid = false; } else markDateValid();
            if (!isValidService(serviceEl.value))   { markInvalid(serviceEl); valid = false; } else markValid(serviceEl);

            if (!valid) {
                e.preventDefault(); e.stopPropagation();
                var firstErr = form.querySelector('.is-invalid');
                if (firstErr) { firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' }); firstErr.focus(); }
            }
        });
    })();
    </script>

</body>
</html>
<?php $conn->close(); ?>