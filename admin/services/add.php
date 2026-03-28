<?php
// C:\xamppnew\htdocs\rkhospital\admin\services\add.php

require_once './../../include/config.php';

// ── Helper: Convert Image to WebP ────────────────────────────
function convertToWebp($source, $destination, $quality = 80) {
    $info = getimagesize($source);
    if (!$info) return false;

    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);
    } elseif ($info['mime'] == 'image/webp') {
        $image = imagecreatefromwebp($source);
    } else {
        return false;
    }

    $success = imagewebp($image, $destination, $quality);
    imagedestroy($image);
    return $success;
}

$errors = [];

// Fetch Categories
$categories = [];
$res = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");
if ($res) { while ($r = $res->fetch_assoc()) { $categories[] = $r; } }

// Fetch All Services for "Related Services" Dropdown
$all_services = [];
$res_srv = $conn->query("SELECT slug, title FROM services ORDER BY title ASC");
if ($res_srv) { while ($r = $res_srv->fetch_assoc()) { $all_services[] = $r; } }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── Core Fields ──────────────────────────────────────────────
    $title             = trim($_POST['title'] ?? '');
    $slug              = trim($_POST['slug'] ?? '');
    $h1_title          = trim($_POST['h1_title'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $content           = $_POST['content'] ?? '';
    $category_id       = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $icon              = trim($_POST['icon'] ?? '');
    $sort_order        = (int)($_POST['sort_order'] ?? 0);
    $is_published      = isset($_POST['is_published']) ? 1 : 0;

    // ── Hero Fields ──────────────────────────────────────────────
    $hero_title        = trim($_POST['hero_title'] ?? '');
    $hero_subtitle     = trim($_POST['hero_subtitle'] ?? '');
    $hero_image_alt    = trim($_POST['hero_image_alt'] ?? '');
    $image_alt         = trim($_POST['image_alt'] ?? '');

    // ── SEO Fields ───────────────────────────────────────────────
    $meta_title          = trim($_POST['meta_title'] ?? '');
    $meta_description    = trim($_POST['meta_description'] ?? '');
    $focus_keyword       = trim($_POST['focus_keyword'] ?? '');
    $canonical_url       = trim($_POST['canonical_url'] ?? '');
    $og_title            = trim($_POST['og_title'] ?? '');
    $og_description      = trim($_POST['og_description'] ?? '');
    $og_type             = trim($_POST['og_type'] ?? 'website');
    $twitter_title       = trim($_POST['twitter_title'] ?? '');
    $twitter_description = trim($_POST['twitter_description'] ?? '');
    $twitter_card        = trim($_POST['twitter_card'] ?? 'summary_large_image');
    $robots_index        = trim($_POST['robots_index'] ?? 'index');
    $robots_follow       = trim($_POST['robots_follow'] ?? 'follow');
    $schema_type         = trim($_POST['schema_type'] ?? 'MedicalProcedure');
    
    // ── Validation ───────────────────────────────────────────────
    if (empty($title))   $errors[] = 'Service Title is required.';
    if (empty($content) || $content === '<p><br></p>') $errors[] = 'Content is required.';
    if (empty($category_id)) $errors[] = 'Please select a Category.';

    // ── Slug Generation ──────────────────────────────────────────
    if (empty($slug)) {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
    } else {
        $slug = strtolower(preg_replace('/[^a-z0-9-]+/', '-', $slug));
    }
    $slug    = trim($slug, '-');
    $slugEsc = $conn->real_escape_string($slug);

    $chk = $conn->query("SELECT id FROM services WHERE slug = '$slugEsc'");
    if ($chk && $chk->num_rows > 0) {
        $errors[] = 'Slug already exists. Please use a different one.';
    }

    // ── Auto-fill SEO defaults ───────────────────────────────────
    if (empty($meta_title))       $meta_title       = $title;
    if (empty($meta_description)) $meta_description = $short_description;
    if (empty($og_title))         $og_title         = $meta_title;
    if (empty($og_description))   $og_description   = $meta_description;
    if (empty($twitter_title))    $twitter_title    = $meta_title;
    if (empty($twitter_description)) $twitter_description = $meta_description;

    // ── Image Uploads ─────────────────────────────────────────────
    $imagePath     = '';
    $heroImagePath = '';
    $ogImagePath   = '';
    $seoBaseName   = !empty($slug) ? $slug : 'service';
    $uploadDir     = '../../assets/img/services/';

    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    // 1. Main Image
    if (!empty($_FILES['image']['name'])) {
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        if (in_array($fileType, ['image/jpeg','image/png','image/webp','image/gif'])) {
            $fileName = $seoBaseName . '-main-' . uniqid() . '.webp';
            if (convertToWebp($_FILES['image']['tmp_name'], $uploadDir . $fileName, 85)) {
                $imagePath = 'assets/img/services/' . $fileName;
                if (empty($ogImagePath)) $ogImagePath = $imagePath;
            }
        }
    }

    // 2. Hero Image
    if (!empty($_FILES['hero_image']['name'])) {
        $fileType = mime_content_type($_FILES['hero_image']['tmp_name']);
        if (in_array($fileType, ['image/jpeg','image/png','image/webp','image/gif'])) {
            $fileName = $seoBaseName . '-hero-' . uniqid() . '.webp';
            if (convertToWebp($_FILES['hero_image']['tmp_name'], $uploadDir . $fileName, 85)) {
                $heroImagePath = 'assets/img/services/' . $fileName;
            }
        }
    }

    // 3. OG Image
    if (!empty($_FILES['og_image']['name'])) {
        $fileType = mime_content_type($_FILES['og_image']['tmp_name']);
        if (in_array($fileType, ['image/jpeg','image/png','image/webp','image/gif'])) {
            $fileName = $seoBaseName . '-og-' . uniqid() . '.webp';
            if (convertToWebp($_FILES['og_image']['tmp_name'], $uploadDir . $fileName, 80)) {
                $ogImagePath = 'assets/img/services/' . $fileName;
            }
        }
    }

    // ── Automated JSON Generation ────────────────────────────────

    // 1. FAQs Builder
    $faqs = [];
    if (!empty($_POST['faq_q']) && is_array($_POST['faq_q'])) {
        foreach ($_POST['faq_q'] as $index => $q) {
            $a = $_POST['faq_a'][$index] ?? '';
            if (!empty(trim($q)) && !empty(trim($a))) {
                $faqs[] = ['q' => trim($q), 'a' => trim($a)];
            }
        }
    }
    $faqs_json_raw = empty($faqs) ? '' : json_encode($faqs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    // 2. Sections Builder
    $sections = [];
    if (!empty($_POST['sec_h2']) && is_array($_POST['sec_h2'])) {
        foreach ($_POST['sec_h2'] as $index => $h2) {
            $sec_content  = $_POST['sec_content'][$index] ?? '';
            $sec_list_raw = $_POST['sec_list'][$index] ?? '';
            
            $list_array = array_values(array_filter(array_map('trim', explode("\n", $sec_list_raw))));

            if (!empty(trim($h2)) || !empty(trim($sec_content)) || !empty($list_array)) {
                $sec = [];
                if (!empty(trim($h2))) $sec['h2'] = trim($h2);
                if (!empty(trim($sec_content))) $sec['content'] = trim($sec_content);
                if (!empty($list_array)) $sec['list'] = $list_array;
                $sections[] = $sec;
            }
        }
    }
    $sections_json_raw = empty($sections) ? '' : json_encode($sections, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    // 3. Related Services Builder
    $related_services = [];
    if (!empty($_POST['related_services']) && is_array($_POST['related_services'])) {
        $related_services = array_map('trim', $_POST['related_services']);
    }
    $related_services_json_raw = empty($related_services) ? '' : json_encode($related_services, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    // 4. Auto Breadcrumb Builder
    $catName = 'Services';
    if ($category_id) {
        $catRes = $conn->query("SELECT name FROM categories WHERE id = $category_id");
        if ($catRes && $catRes->num_rows > 0) $catName = $catRes->fetch_assoc()['name'];
    }
    $breadcrumbData = [
        ['name' => 'Home', 'url' => '/'],
        ['name' => 'Services', 'url' => '/services.php'],
        ['name' => $catName, 'url' => '/services.php?category=' . urlencode(strtolower($catName))],
        ['name' => $title, 'url' => '/' . $slug]
    ];
    $breadcrumb_json_raw = json_encode($breadcrumbData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    // 5. Gallery Upload Builder
    $gallery = [];
    if (!empty($_FILES['gallery_images']['name'][0])) {
        $galleryDir = '../../assets/img/services/gallery/';
        if (!is_dir($galleryDir)) mkdir($galleryDir, 0755, true);
        
        foreach ($_FILES['gallery_images']['name'] as $key => $name) {
            if ($_FILES['gallery_images']['error'][$key] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['gallery_images']['tmp_name'][$key];
                $fileType = mime_content_type($tmp_name);
                
                if (in_array($fileType, ['image/jpeg','image/png','image/webp','image/gif'])) {
                    $galFileName = $seoBaseName . '-gallery-' . uniqid() . '.webp';
                    if (convertToWebp($tmp_name, $galleryDir . $galFileName, 80)) {
                        $gallery[] = [
                            'src' => 'assets/img/services/gallery/' . $galFileName,
                            'alt' => $title
                        ];
                    }
                }
            }
        }
    }
    $gallery_json_raw = empty($gallery) ? '' : json_encode($gallery, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    // ── Build Schema JSON ────────────────────────────────────────
    $schema_json_final = '';
    if (!empty($schema_type)) {
        $schemaData = [
            '@context'    => 'https://schema.org',
            '@type'       => $schema_type,
            'name'        => $meta_title ?: $title,
            'description' => $meta_description ?: $short_description,
            'url'         => (!empty($canonical_url) ? $canonical_url : ''),
            'image'       => (!empty($ogImagePath) ? $ogImagePath : '')
        ];
        $schema_json_final = json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    // ── Insert ───────────────────────────────────────────────────
    if (empty($errors)) {
        $s = fn($v) => $v !== '' ? "'" . $conn->real_escape_string($v) . "'" : "NULL";
        $s_raw = fn($v) => $conn->real_escape_string($v);

        $robots_meta = $robots_index . ',' . $robots_follow;
        $catVal  = $category_id ? (int)$category_id : 'NULL';

        $sql = "INSERT INTO services (
                    title, hero_title, hero_subtitle, hero_image, hero_image_alt,
                    slug, short_description, h1_title, breadcrumb_json, content,
                    sections_json, faqs_json, image, image_alt, gallery_json, icon,
                    category_id, related_services_json, is_published, sort_order,
                    meta_title, meta_description, focus_keyword, canonical_url,
                    og_title, og_description, og_image, og_type,
                    twitter_title, twitter_description, twitter_card,
                    robots_meta, schema_type, schema_json, created_at, updated_at
                ) VALUES (
                    {$s($title)}, {$s($hero_title)}, {$s($hero_subtitle)}, {$s($heroImagePath)}, {$s($hero_image_alt)},
                    {$s($slug)}, {$s($short_description)}, {$s($h1_title)}, {$s($breadcrumb_json_raw)}, '{$s_raw($content)}',
                    {$s($sections_json_raw)}, {$s($faqs_json_raw)}, {$s($imagePath)}, {$s($image_alt)}, {$s($gallery_json_raw)}, {$s($icon)},
                    $catVal, {$s($related_services_json_raw)}, $is_published, $sort_order,
                    {$s($meta_title)}, {$s($meta_description)}, {$s($focus_keyword)}, {$s($canonical_url)},
                    {$s($og_title)}, {$s($og_description)}, {$s($ogImagePath)}, {$s($og_type)},
                    {$s($twitter_title)}, {$s($twitter_description)}, {$s($twitter_card)},
                    {$s($robots_meta)}, {$s($schema_type)}, {$s($schema_json_final)}, NOW(), NOW()
                )";

        if ($conn->query($sql)) {
            header("Location: index.php?msg=added");
            exit;
        } else {
            $errors[] = 'Database error: ' . $conn->error;
        }
    }
}

// helpers for repopulate
$p = fn($k) => htmlspecialchars($_POST[$k] ?? '');

$pageTitle  = 'Add New Service';
$activePage = 'services';
$assetBase  = '../';

$extraCSS = '
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    :root {
        --success: #198754;
        --warning: #ffc107;
        --danger: #dc3545;
        --text-1: #212529;
        --text-2: #6c757d;
        --text-3: #adb5bd;
    }

    /* ── Form Labels ── */
    .form-label { font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; }
    
    /* ── Input Group ── */
    .input-group-text { background: #f8f9fa; color: #6c757d; font-size: 0.875rem; border-color: #dee2e6; }
    .form-control, .form-select { font-size: 0.9rem; padding: 0.6rem 1rem; border-color: #dee2e6; }
    .form-control:focus, .form-select:focus { border-color: #86b7fe; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }

    /* ── Char Counter ── */
    .char-counter { display: flex; justify-content: space-between; margin-top: 6px; font-size: 0.7rem; color: #adb5bd; font-family: monospace; }
    .char-counter .count { font-weight: 700; }
    .char-counter .count.ok    { color: var(--success); }
    .char-counter .count.warn  { color: var(--warning); }
    .char-counter .count.bad   { color: var(--danger); }
    .char-bar { height: 4px; background: #e9ecef; border-radius: 4px; margin-top: 6px; overflow: hidden; }
    .char-bar-fill { height: 100%; border-radius: 4px; transition: width .3s, background .3s; }

    /* ── SEO Score Widget ── */
    .seo-score-ring { width: 70px; height: 70px; position: relative; flex-shrink: 0; }
    .seo-score-ring svg { transform: rotate(-90deg); width: 100%; height: 100%; }
    .seo-score-ring .score-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; }
    .seo-score-ring .score-num { font-size: 1.25rem; font-weight: 800; line-height: 1; display: block; }
    .seo-score-ring .score-label { font-size: 0.55rem; color: #adb5bd; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .seo-checks { flex: 1; min-width: 0; }
    .seo-check-item { display: flex; align-items: flex-start; gap: 8px; padding: 6px 0; font-size: 0.8rem; color: #495057; border-bottom: 1px solid #f1f3f5; }
    .seo-check-item:last-child { border-bottom: none; }
    .seo-check-item .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 5px; }
    .dot-ok   { background: var(--success); box-shadow: 0 0 4px rgba(25, 135, 84, 0.4); }
    .dot-warn { background: var(--warning); }
    .dot-bad  { background: var(--danger); }

    /* ── SERP & OG Preview ── */
    .serp-preview { background: #fff; border: 1px solid #dfe1e5; border-radius: 0.5rem; padding: 1rem; margin-top: 0.25rem; }
    .serp-url { font-size: 0.75rem; color: #202124; font-family: Arial, sans-serif; margin-bottom: 2px; }
    .serp-title { font-size: 1.125rem; color: #1a0dab; font-family: Arial, sans-serif; cursor: pointer; line-height: 1.3; margin-bottom: 2px; }
    .serp-desc { font-size: 0.85rem; color: #4d5156; font-family: Arial, sans-serif; line-height: 1.5; }
    .serp-date { font-size: 0.85rem; color: #70757a; font-family: Arial, sans-serif; }
    .serp-placeholder { color: #9aa0a6 !important; font-style: italic; }

    .og-preview-card { border: 1px solid #e0e0e0; border-radius: 0.5rem; overflow: hidden; background: #f8f9fa; margin-top: 6px; }
    .og-preview-img { width: 100%; height: 160px; background: #e9ecef; display: flex; align-items: center; justify-content: center; color: #adb5bd; font-size: 0.8rem; overflow: hidden;}
    .og-preview-img img { width: 100%; height: 100%; object-fit: cover; }
    .og-preview-body { padding: 0.75rem 1rem; background: #fff; border-top: 1px solid #e0e0e0; }
    .og-preview-domain { font-size: 0.65rem; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-family: Arial, sans-serif; }
    .og-preview-title  { font-size: 1rem; font-weight: 700; color: #1a1a1a; font-family: Arial, sans-serif; margin: 4px 0; }
    .og-preview-desc   { font-size: 0.85rem; color: #495057; font-family: Arial, sans-serif; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    /* ── Quill Editor ── */
    .ql-toolbar.ql-snow { background: #f8f9fa; border-color: #dee2e6; border-radius: 0.5rem 0.5rem 0 0; font-family: inherit; }
    .ql-container.ql-snow { border-color: #dee2e6; border-radius: 0 0 0.5rem 0.5rem; font-family: inherit; }
    .ql-editor { min-height: 350px; font-size: 0.95rem; line-height: 1.7; color: #212529; }

    /* ── Image Upload Zones ── */
    .img-upload-zone { border: 2px dashed #dee2e6; border-radius: 0.75rem; padding: 2.5rem 1.5rem; text-align: center; cursor: pointer; transition: all 0.2s ease; background: #f8f9fa; position: relative; }
    .img-upload-zone:hover { border-color: #0d6efd; background: #f1f7ff; }
    .img-upload-zone .upload-icon { font-size: 2rem; color: #adb5bd; margin-bottom: 0.5rem; }
    .img-upload-zone p { font-size: 0.85rem; color: #6c757d; margin: 0; font-weight: 500; }
    .img-upload-zone .preview-img { width: 100%; border-radius: 0.5rem; object-fit: cover; display: none; margin-top: 10px; max-height: 200px; }

    /* ── Utilities ── */
    .keyword-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
    .keyword-tag { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 20px; padding: 3px 12px; font-size: 0.75rem; color: #495057; cursor: pointer; transition: all 0.15s; }
    .keyword-tag:hover { border-color: #0d6efd; color: #0d6efd; background: #f1f7ff; }

    .schema-options, .robots-group { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 6px; }
    .schema-opt, .robots-btn { padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; cursor: pointer; border: 1px solid #dee2e6; color: #6c757d; background: #fff; transition: all 0.15s; flex: 1; text-align: center; }
    .schema-opt.active, .robots-btn.active-index { border-color: var(--success); color: var(--success); background: rgba(25, 135, 84, 0.05); }
    .robots-btn.active-noindex, .robots-btn.active-nofollow { border-color: var(--danger); color: var(--danger); background: rgba(220, 53, 69, 0.05); }
    .robots-btn.active-follow { border-color: var(--success); color: var(--success); background: rgba(25, 135, 84, 0.05); }

    .kd-bar { height: 5px; background: #e9ecef; border-radius: 4px; overflow: hidden; margin: 6px 0; }
    .kd-fill { height: 100%; border-radius: 4px; background: #0d6efd; transition: width .4s; }

    .nav-pills .nav-link { color: #6c757d; border-radius: 20px; font-size: 0.85rem; font-weight: 600; padding: 0.5rem 1rem; transition: all 0.2s; }
    .nav-pills .nav-link.active { background-color: #e7f1ff; color: #0d6efd; }
    
    /* ── Dynamic Rows ── */
    .dynamic-row { background: #fff; border: 1px solid #dee2e6; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 1rem; position: relative; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .remove-row-btn { position: absolute; top: 10px; right: 10px; background: #ffebee; color: #dc3545; border: none; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; }
    .remove-row-btn:hover { background: #dc3545; color: #fff; }
</style>
';

require_once '../include/head.php';
?>

<div class="main-wrapper">

    <?php require_once '../include/header.php'; ?>
    <?php require_once '../include/sidebar.php'; ?>

    <div class="page-wrapper" style="background-color: #f4f6f9; min-height: 100vh;">
        <div class="content container-fluid pt-4 pb-5">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <div>
                    <h3 class="fw-bolder text-dark mb-1">Create Service</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb small bg-transparent p-0 m-0">
                            <li class="breadcrumb-item"><a href="../index.php" class="text-muted text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="index.php" class="text-muted text-decoration-none">Services</a></li>
                            <li class="breadcrumb-item active text-secondary fw-medium">Add New</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="index.php" class="btn btn-light rounded-pill px-4 py-2 shadow-sm fw-semibold border d-inline-flex align-items-center gap-2">
                        <i class="fa fa-arrow-left"></i> Back to Services
                    </a>
                </div>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-4 d-flex align-items-start gap-3" role="alert">
                    <i class="fa fa-exclamation-triangle mt-1 fs-5"></i>
                    <div>
                        <div class="fw-bold mb-1">Please fix the following errors:</div>
                        <ul class="mb-0 ps-3 small">
                            <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" id="serviceForm">
                <div class="row g-4">

                    <div class="col-xl-8 col-lg-7">

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3">
                                <div class="bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fa fa-edit"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing: 0.5px;">Service Content</h6>
                            </div>
                            <div class="card-body p-4">

                                <div class="mb-4">
                                    <label class="form-label">Service Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="serviceTitle" class="form-control"
                                           placeholder="Enter an engaging service title..."
                                           value="<?= $p('title') ?>">
                                    <div class="char-counter">
                                        <span>Title length</span>
                                        <span class="count" id="titleCount">0 chars</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">URL Slug</label>
                                        <div class="input-group">
                                            <input type="text" name="slug" id="serviceSlug" class="form-control"
                                                   placeholder="auto-generated-from-title"
                                                   value="<?= $p('slug') ?>">
                                            <button type="button" class="btn btn-light border text-secondary" id="generateSlug" title="Auto-generate from title">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">Lowercase, numbers and hyphens only.</small>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">H1 Title (Overrides default on page)</label>
                                        <input type="text" name="h1_title" class="form-control" placeholder="e.g. Best PCOD Treatment in Nagpur" value="<?= $p('h1_title') ?>">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Short Description (Excerpt)</label>
                                    <textarea name="short_description" id="shortDescription" class="form-control" rows="3"
                                              placeholder="Write a compelling 1-2 sentence summary..."><?= $p('short_description') ?></textarea>
                                    <div class="char-counter">
                                        <span>Description length</span>
                                        <span class="count" id="excerptCount">0 chars</span>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        <span>Main Content <span class="text-danger">*</span></span>
                                    </label>
                                    <div id="quillEditor" class="bg-white"></div>
                                    <textarea name="content" id="serviceContent" class="d-none"><?= $p('content') ?></textarea>
                                </div>

                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3">
                                <div class="bg-info-subtle text-info rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fa fa-image"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing: 0.5px;">Hero Section (Top Banner)</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <label class="form-label">Hero Title</label>
                                    <input type="text" name="hero_title" class="form-control" placeholder="Large title on banner..." value="<?= $p('hero_title') ?>">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Hero Subtitle</label>
                                    <textarea name="hero_subtitle" class="form-control" rows="3" placeholder="Subtitle text under the hero title..."><?= $p('hero_subtitle') ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Hero Background Image</label>
                                        <div class="img-upload-zone" onclick="document.getElementById('heroImageInput').click()" style="padding: 1.5rem;">
                                            <div id="heroImgPlaceholder">
                                                <div class="upload-icon"><i class="fa fa-cloud-upload-alt"></i></div>
                                                <small class="text-muted">Upload Hero Banner</small>
                                            </div>
                                            <img id="heroImagePreview" class="preview-img shadow-sm" alt="Hero Preview" style="display:none;">
                                        </div>
                                        <input type="file" name="hero_image" id="heroImageInput" accept="image/*" class="d-none">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Hero Image Alt Text</label>
                                        <input type="text" name="hero_image_alt" class="form-control" placeholder="Alt text for SEO" value="<?= $p('hero_image_alt') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3">
                                <div class="bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fa fa-magic"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing: 0.5px;">Page Builder (Auto JSON)</h6>
                            </div>
                            <div class="card-body p-4">
                                
                                <h5 class="mb-3 border-bottom pb-2 text-dark"><i class="fa fa-list me-2 text-primary"></i>Content Sections</h5>
                                <div id="sectionsContainer">
                                    <?php 
                                    $sec_h2s = $_POST['sec_h2'] ?? [];
                                    $sec_contents = $_POST['sec_content'] ?? [];
                                    $sec_lists = $_POST['sec_list'] ?? [];
                                    foreach ($sec_h2s as $idx => $h2): 
                                    ?>
                                        <div class="dynamic-row" id="sec_<?= $idx ?>">
                                            <button type="button" class="remove-row-btn" onclick="document.getElementById('sec_<?= $idx ?>').remove()"><i class="fa fa-trash"></i></button>
                                            <div class="mb-3">
                                                <label class="form-label">Heading (H2)</label>
                                                <input type="text" name="sec_h2[]" class="form-control" value="<?= htmlspecialchars($h2) ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Paragraph Content</label>
                                                <textarea name="sec_content[]" class="form-control" rows="3"><?= htmlspecialchars($sec_contents[$idx] ?? '') ?></textarea>
                                            </div>
                                            <div>
                                                <label class="form-label">Bullet List (One item per line)</label>
                                                <textarea name="sec_list[]" class="form-control" rows="3"><?= htmlspecialchars($sec_lists[$idx] ?? '') ?></textarea>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm fw-bold mb-5" id="addSectionBtn">
                                    <i class="fa fa-plus me-1"></i> Add Content Section
                                </button>

                                <h5 class="mb-3 border-bottom pb-2 text-dark"><i class="fa fa-question-circle me-2 text-primary"></i>FAQs</h5>
                                <div id="faqContainer">
                                    <?php 
                                    $faq_qs = $_POST['faq_q'] ?? [];
                                    $faq_as = $_POST['faq_a'] ?? [];
                                    foreach ($faq_qs as $idx => $q): 
                                    ?>
                                        <div class="dynamic-row" id="faq_<?= $idx ?>">
                                            <button type="button" class="remove-row-btn" onclick="document.getElementById('faq_<?= $idx ?>').remove()"><i class="fa fa-trash"></i></button>
                                            <div class="mb-3">
                                                <label class="form-label">Question</label>
                                                <input type="text" name="faq_q[]" class="form-control" value="<?= htmlspecialchars($q) ?>">
                                            </div>
                                            <div>
                                                <label class="form-label">Answer</label>
                                                <textarea name="faq_a[]" class="form-control" rows="2"><?= htmlspecialchars($faq_as[$idx] ?? '') ?></textarea>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm fw-bold mb-5" id="addFaqBtn">
                                    <i class="fa fa-plus me-1"></i> Add FAQ
                                </button>

                                <h5 class="mb-3 border-bottom pb-2 text-dark"><i class="fa fa-link me-2 text-primary"></i>Related Services</h5>
                                <div>
                                    <label class="form-label">Select Related Services</label>
                                    <select name="related_services[]" class="form-control select2-multiple" multiple="multiple">
                                        <?php 
                                        $selected_related = $_POST['related_services'] ?? [];
                                        foreach ($all_services as $srv): 
                                            $sel = in_array($srv['slug'], $selected_related) ? 'selected' : '';
                                        ?>
                                            <option value="<?= htmlspecialchars($srv['slug']) ?>" <?= $sel ?>><?= htmlspecialchars($srv['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success-subtle text-success rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fa fa-search"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing: 0.5px;">SEO Settings</h6>
                                </div>
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1 fw-bold" id="seoScoreBadge">Score: 0/100</span>
                            </div>
                            <div class="card-body p-4">

                                <ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-meta" type="button" role="tab">Meta Tags</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-og" type="button" role="tab">Open Graph</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-twitter" type="button" role="tab">Twitter Card</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-technical" type="button" role="tab">Technical</button>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="tab-meta" role="tabpanel">

                                        <div class="mb-4">
                                            <label class="form-label text-primary"><i class="fa fa-key me-1"></i> Focus Keyword</label>
                                            <input type="text" name="focus_keyword" id="focusKeyword" class="form-control bg-primary-subtle border-primary-subtle text-primary-emphasis fw-bold"
                                                   placeholder="Primary keyword you're targeting..."
                                                   value="<?= $p('focus_keyword') ?>">
                                            <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">Used to analyse keyword density and SEO score in real-time.</small>
                                            <div id="keywordSuggestions" class="keyword-tags"></div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Meta Title <span class="text-danger">*</span></label>
                                            <input type="text" name="meta_title" id="metaTitle" class="form-control"
                                                   placeholder="SEO title shown in Google search results..."
                                                   value="<?= $p('meta_title') ?>" maxlength="70">
                                            <div class="char-bar"><div class="char-bar-fill" id="metaTitleBar" style="width:0%"></div></div>
                                            <div class="char-counter">
                                                <span>Ideal: 50–60 characters</span>
                                                <span class="count" id="metaTitleCount">0 / 60</span>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Meta Description</label>
                                            <textarea name="meta_description" id="metaDesc" class="form-control" rows="3"
                                                      placeholder="Compelling description shown under your title in Google (max 160 chars)..."
                                                      maxlength="180"><?= $p('meta_description') ?></textarea>
                                            <div class="char-bar"><div class="char-bar-fill" id="metaDescBar" style="width:0%"></div></div>
                                            <div class="char-counter">
                                                <span>Ideal: 120–160 characters</span>
                                                <span class="count" id="metaDescCount">0 / 160</span>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Canonical URL</label>
                                            <input type="text" name="canonical_url" id="canonicalUrl" class="form-control"
                                                   placeholder="https://yourdomain.com/service/your-service-slug"
                                                   value="<?= $p('canonical_url') ?>">
                                            <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">Leave blank to auto-generate.</small>
                                        </div>

                                        <div class="mt-4">
                                            <label class="form-label"><i class="fab fa-google text-muted me-1"></i> Google SERP Preview</label>
                                            <div class="serp-preview">
                                                <div class="serp-url" id="serpUrl">rkhospital.com › service › <span id="serpSlug">your-service-slug</span></div>
                                                <div class="serp-title" id="serpTitle"><span class="serp-placeholder">Your meta title will appear here...</span></div>
                                                <div class="serp-date d-inline-block pe-1" id="serpDate"><?= date('M j, Y') ?> — </div>
                                                <div class="serp-desc d-inline" id="serpDesc"><span class="serp-placeholder">Your meta description will appear here. Make it compelling.</span></div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="tab-og" role="tabpanel">
                                        <div class="mb-4">
                                            <label class="form-label">OG Title</label>
                                            <input type="text" name="og_title" id="ogTitle" class="form-control"
                                                   placeholder="Title shown when shared on Facebook, LinkedIn..."
                                                   value="<?= $p('og_title') ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">OG Description</label>
                                            <textarea name="og_description" id="ogDesc" class="form-control" rows="2"
                                                      placeholder="Description shown on social media shares..."><?= $p('og_description') ?></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">OG Type</label>
                                            <select name="og_type" class="form-select">
                                                <option value="website" <?= ($p('og_type')||'website')==='website' ? 'selected' : '' ?>>website</option>
                                                <option value="article" <?= $p('og_type')==='article' ? 'selected' : '' ?>>article</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab-twitter" role="tabpanel">
                                        <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis rounded-3 p-3 mb-4 d-flex align-items-center gap-2">
                                            <i class="fa fa-lightbulb"></i>
                                            <small class="fw-medium">Leave these blank to auto-inherit from Meta Title/Description on save.</small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Twitter Title</label>
                                            <input type="text" name="twitter_title" class="form-control"
                                                   placeholder="Title shown on Twitter card..."
                                                   value="<?= $p('twitter_title') ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Twitter Description</label>
                                            <textarea name="twitter_description" class="form-control" rows="3"
                                                      placeholder="Description shown on Twitter card..."><?= $p('twitter_description') ?></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Twitter Card Type</label>
                                            <select name="twitter_card" class="form-select">
                                                <option value="summary_large_image" selected>summary_large_image (Recommended)</option>
                                                <option value="summary">summary</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab-technical" role="tabpanel">
                                        <?php 
                                            $robots = explode(',', $p('robots_meta') ?: 'index,follow');
                                            $rIndex = $robots[0] ?? 'index';
                                            $rFollow = $robots[1] ?? 'follow';
                                        ?>
                                        <div class="mb-4">
                                            <label class="form-label">Robots Meta Tag</label>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <div class="robots-group" id="robotsIndexGroup">
                                                        <button type="button" class="robots-btn shadow-sm <?= $rIndex==='index'?'active-index':'' ?>" data-val="index" onclick="setRobots('index',this)">✅ INDEX</button>
                                                        <button type="button" class="robots-btn shadow-sm <?= $rIndex==='noindex'?'active-noindex':'' ?>" data-val="noindex" onclick="setRobots('noindex',this)">🚫 NOINDEX</button>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="robots-group" id="robotsFollowGroup">
                                                        <button type="button" class="robots-btn shadow-sm <?= $rFollow==='follow'?'active-follow':'' ?>" data-val="follow" onclick="setFollow('follow',this)">🔗 FOLLOW</button>
                                                        <button type="button" class="robots-btn shadow-sm <?= $rFollow==='nofollow'?'active-nofollow':'' ?>" data-val="nofollow" onclick="setFollow('nofollow',this)">⛔ NOFOLLOW</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="robots_index" id="robotsIndex" value="<?= $rIndex ?>">
                                            <input type="hidden" name="robots_follow" id="robotsFollow" value="<?= $rFollow ?>">
                                            <small class="fw-medium mt-2 d-block text-success" id="robotsHint">✅ This page will be indexed and links followed by search engines.</small>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Schema Type</label>
                                            <div class="schema-options">
                                                <?php $schemas = ['MedicalProcedure','MedicalSpecialty','MedicalClinic','Service']; ?>
                                                <?php foreach ($schemas as $s): ?>
                                                <button type="button" class="schema-opt shadow-sm <?= ($p('schema_type') ?: 'MedicalProcedure') === $s ? 'active' : '' ?>"
                                                        onclick="setSchema('<?= $s ?>',this)"><?= $s ?></button>
                                                <?php endforeach; ?>
                                            </div>
                                            <input type="hidden" name="schema_type" id="schemaType" value="<?= $p('schema_type') ?: 'MedicalProcedure' ?>">
                                        </div>

                                        <div class="mb-3 p-3 bg-light rounded-3 border">
                                            <label class="form-label text-dark mb-2">Keyword Density Analyser</label>
                                            <div id="kdResults" style="color:#6c757d;font-size:0.8rem;">Enter a focus keyword in Meta Tags and write content to see density analysis.</div>
                                        </div>
                                    </div>

                                </div> 
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-4 col-lg-5">

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fa fa-paper-plane"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing: 0.5px;">Publish</h6>
                                </div>
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-1 fw-bold" id="publishStatusBadge">Draft</span>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <div class="form-check form-switch d-flex align-items-center gap-2 m-0 p-0">
                                        <input class="form-check-input ms-0 me-2 mt-0" type="checkbox" role="switch" id="isPublished"
                                               name="is_published" value="1" style="width: 40px; height: 20px;"
                                               <?= !empty($_POST['is_published']) ? 'checked' : '' ?>
                                               onchange="updatePublishBadge(this)">
                                        <label class="form-check-label fw-bold text-dark" for="isPublished">Publish Immediately</label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Sort Order (Higher = lower in list)</label>
                                    <input type="number" name="sort_order" class="form-control" value="<?= $p('sort_order') ?: '0' ?>">
                                </div>
                                <hr class="border-light-subtle my-4">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm fw-bold mb-2 d-flex align-items-center justify-content-center gap-2">
                                    <i class="fa fa-save"></i> Save Service
                                </button>
                                <a href="index.php" class="btn btn-light w-100 rounded-pill py-2 border text-secondary fw-semibold d-block text-center">Cancel</a>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3">
                                <div class="bg-success-subtle text-success rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fa fa-chart-line"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing: 0.5px;">Live SEO Audit</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex gap-3 align-items-center mb-4">
                                    <div class="seo-score-ring">
                                        <svg viewBox="0 0 80 80">
                                            <circle cx="40" cy="40" r="34" fill="none" stroke="#e9ecef" stroke-width="8"/>
                                            <circle id="scoreCircle" cx="40" cy="40" r="34" fill="none" stroke="#198754"
                                                    stroke-width="8" stroke-linecap="round"
                                                    stroke-dasharray="213.6" stroke-dashoffset="213.6"
                                                    style="transition:stroke-dashoffset .5s ease-out, stroke .5s;"/>
                                        </svg>
                                        <div class="score-text">
                                            <span class="score-num text-success" id="scoreNum">0</span>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="fw-bolder mb-0 text-dark">Overall Health</h5>
                                        <span class="small text-muted fw-medium" id="scoreVerdict">Review required</span>
                                    </div>
                                </div>
                                <div class="seo-checks" id="seoChecklist"></div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3">
                                <div class="bg-info-subtle text-info rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fa fa-tags"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing: 0.5px;">Taxonomy & Icon</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select rounded-3">
                                        <option value="">— Select Category —</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['id'] ?>" <?= (isset($_POST['category_id']) && $_POST['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cat['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Icon Class (e.g. flaticon-baby)</label>
                                    <input type="text" name="icon" class="form-control rounded-3" placeholder="flaticon-..." value="<?= $p('icon') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3">
                                <div class="bg-danger-subtle text-danger rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fa fa-image"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing: 0.5px;">Featured Image & Gallery</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <label class="form-label">Main Image (Thumbnail)</label>
                                    <div class="img-upload-zone" id="mainImageZone" onclick="document.getElementById('imageInput').click()" style="padding: 1.5rem;">
                                        <div id="imgPlaceholder">
                                            <div class="upload-icon"><i class="fa fa-cloud-upload-alt"></i></div>
                                            <small class="text-muted" style="font-size: 0.75rem;">JPG, PNG, WEBP</small>
                                        </div>
                                        <img id="imagePreview" class="preview-img shadow-sm" alt="Preview" style="display:none;">
                                    </div>
                                    <input type="file" name="image" id="imageInput" accept="image/*" class="d-none">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Main Image Alt Text</label>
                                    <input type="text" name="image_alt" class="form-control" value="<?= $p('image_alt') ?>">
                                </div>
                                <hr class="border-light-subtle my-4">
                                <div class="mb-4">
                                    <label class="form-label">Gallery Images (Auto JSON)</label>
                                    <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
                                    <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">Hold CTRL to select multiple.</small>
                                </div>
                                <hr class="border-light-subtle my-4">
                                <div class="mb-4">
                                    <label class="form-label">Social (OG) Image</label>
                                    <div class="img-upload-zone" id="ogImageZone" onclick="document.getElementById('ogImageInput').click()" style="padding: 1.5rem;">
                                        <div id="ogImgPlaceholder">
                                            <div class="upload-icon"><i class="fa fa-share-nodes"></i></div>
                                            <small class="text-muted" style="font-size: 0.75rem;">Upload OG Image</small>
                                        </div>
                                        <img id="ogImagePreview" class="preview-img shadow-sm" alt="OG Preview" style="display:none;">
                                    </div>
                                    <input type="file" name="og_image" id="ogImageInput" accept="image/*" class="d-none">
                                </div>
                            </div>
                        </div>

                    </div></div></form>

        </div>
    </div>
</div>

<?php
$extraJS = '
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
// Select2
$(document).ready(function() {
    $(".select2-multiple").select2({
        placeholder: "Search and select related services",
        allowClear: true
    });
});

// Dynamic Builders (Sections & FAQs)
document.getElementById("addSectionBtn").addEventListener("click", function() {
    const container = document.getElementById("sectionsContainer");
    const id = Date.now();
    const html = `
        <div class="dynamic-row" id="sec_${id}">
            <button type="button" class="remove-row-btn" onclick="document.getElementById(\'sec_${id}\').remove()"><i class="fa fa-trash"></i></button>
            <div class="mb-3">
                <label class="form-label">Heading (H2)</label>
                <input type="text" name="sec_h2[]" class="form-control" placeholder="e.g. Treatment Options">
            </div>
            <div class="mb-3">
                <label class="form-label">Paragraph Content</label>
                <textarea name="sec_content[]" class="form-control" rows="3" placeholder="Description..."></textarea>
            </div>
            <div>
                <label class="form-label">Bullet List (One item per line)</label>
                <textarea name="sec_list[]" class="form-control" rows="3" placeholder="Point 1\nPoint 2\nPoint 3..."></textarea>
            </div>
        </div>
    `;
    container.insertAdjacentHTML("beforeend", html);
});

document.getElementById("addFaqBtn").addEventListener("click", function() {
    const container = document.getElementById("faqContainer");
    const id = Date.now();
    const html = `
        <div class="dynamic-row" id="faq_${id}">
            <button type="button" class="remove-row-btn" onclick="document.getElementById(\'faq_${id}\').remove()"><i class="fa fa-trash"></i></button>
            <div class="mb-3">
                <label class="form-label">Question</label>
                <input type="text" name="faq_q[]" class="form-control" placeholder="e.g. Is this safe?">
            </div>
            <div>
                <label class="form-label">Answer</label>
                <textarea name="faq_a[]" class="form-control" rows="2" placeholder="Provide the answer..."></textarea>
            </div>
        </div>
    `;
    container.insertAdjacentHTML("beforeend", html);
});

/* ═══════════════════════════════════════════════════════════════
   QUILL EDITOR
══════════════════════════════════════════════════════════════════ */
var quill = new Quill("#quillEditor", {
    theme: "snow",
    placeholder: "Write your main service content here...",
    modules: {
        toolbar: [
            [{ header: [2,3,4,false] }],
            ["bold","italic","underline","strike"],
            [{ color:[] },{ background:[] }],
            [{ list:"ordered" },{ list:"bullet" }],
            [{ align:[] }],
            ["link","image","blockquote"],
            ["clean"]
        ]
    }
});

' . (!empty($_POST['content']) ? 'quill.clipboard.dangerouslyPasteHTML(' . json_encode($_POST['content']) . ');' : '') . '

quill.on("text-change", function() {
    var html = quill.root.innerHTML;
    document.getElementById("serviceContent").value = html;
    updateSeoScore();
    updateKdAnalysis();
});

document.getElementById("serviceForm").addEventListener("submit", function(e) {
    var content = quill.root.innerHTML;
    document.getElementById("serviceContent").value = content;
    
    var textContent = quill.getText().trim();
    if (!textContent || textContent === "" || content === "<p><br></p>") {
        e.preventDefault();
        alert("Main content is required!");
        quill.focus();
        return false;
    }
    return true;
});

/* ═══════════════════════════════════════════════════════════════
   SLUG & CANONICAL
══════════════════════════════════════════════════════════════════ */
function toSlug(str) {
    return str.toLowerCase().trim().replace(/[^a-z0-9\s-]/g,"").replace(/\s+/g,"-").replace(/-+/g,"-");
}

document.getElementById("serviceTitle").addEventListener("input", function() {
    if (!document.getElementById("serviceSlug").dataset.manual) {
        document.getElementById("serviceSlug").value = toSlug(this.value);
    }
    updateCharCount("serviceTitle","titleCount",null,null,999);
    autoFillSeoFields();
    updateSeoScore();
    updateSerpPreview();
});

function autoFillCanonical(slug) {
    var canon = document.getElementById("canonicalUrl");
    if (canon && canon.value === "") {
        canon.value = window.location.origin + "/rkhospital/service/" + slug;
    }
}

document.getElementById("serviceSlug").addEventListener("input", function() {
    this.dataset.manual = "true";
    this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g,"-");
    updateSerpPreview();
    autoFillCanonical(this.value);
});

document.getElementById("generateSlug").addEventListener("click", function() {
    var s = document.getElementById("serviceSlug");
    s.value = toSlug(document.getElementById("serviceTitle").value);
    delete s.dataset.manual;
    updateSerpPreview();
    autoFillCanonical(s.value);
});

/* ═══════════════════════════════════════════════════════════════
   CHAR COUNTERS & SERP
══════════════════════════════════════════════════════════════════ */
function updateCharCount(fieldId, countId, barId, max, warnAt) {
    var el = document.getElementById(fieldId);
    if (!el) return;
    var len = el.value.length;
    var countEl = document.getElementById(countId);
    if (countEl) {
        countEl.textContent = max ? len + " / " + max : len + " chars";
        countEl.className = "count";
        if (max) {
            if (len > max)        countEl.classList.add("bad");
            else if (len > warnAt) countEl.classList.add("warn");
            else if (len >= 10)    countEl.classList.add("ok");
        }
    }
    if (barId && max) {
        var pct = Math.min(len / max * 100, 100);
        var bar = document.getElementById(barId);
        bar.style.width  = pct + "%";
        bar.style.background = len > max ? "var(--danger)" : len > warnAt ? "var(--warning)" : "var(--success)";
    }
}

["metaTitle", "metaDesc", "shortDescription", "ogTitle", "ogDesc"].forEach(function(id) {
    var el = document.getElementById(id);
    if(el) {
        el.addEventListener("input", function() {
            if(id === "metaTitle") { updateCharCount("metaTitle","metaTitleCount","metaTitleBar",60,50); this.dataset.manual = "1"; }
            if(id === "metaDesc")  updateCharCount("metaDesc","metaDescCount","metaDescBar",160,120);
            if(id === "shortDescription") updateCharCount("shortDescription","excerptCount",null,null,999);
            
            updateSerpPreview();
            updateSeoScore();
        });
    }
});

function updateSerpPreview() {
    var title = document.getElementById("metaTitle").value || document.getElementById("serviceTitle").value;
    var desc  = document.getElementById("metaDesc").value  || document.getElementById("shortDescription").value;
    var slug  = document.getElementById("serviceSlug").value  || "your-service-slug";

    var titleEl = document.getElementById("serpTitle");
    var descEl  = document.getElementById("serpDesc");

    titleEl.innerHTML = title ? truncate(title, 60) : \'<span class="serp-placeholder">Your meta title will appear here...</span>\';
    descEl.innerHTML  = desc ? truncate(desc, 160) : \'<span class="serp-placeholder">Your meta description will appear here.</span>\';
    document.getElementById("serpSlug").textContent = slug;
}

function truncate(str, max) { return str.length > max ? str.substring(0, max) + "…" : str; }

/* ═══════════════════════════════════════════════════════════════
   SEO ENGINE & HELPERS
══════════════════════════════════════════════════════════════════ */
function autoFillSeoFields() {
    var title = document.getElementById("serviceTitle").value;
    var mt = document.getElementById("metaTitle");
    if (!mt.dataset.manual && title) {
        mt.value = title.substring(0,60);
        updateCharCount("metaTitle","metaTitleCount","metaTitleBar",60,50);
    }
}

document.getElementById("focusKeyword").addEventListener("input", function() {
    updateSeoScore();
    updateKdAnalysis();
    generateKeywordSuggestions(this.value);
});

function updateSeoScore() {
    var title     = document.getElementById("serviceTitle").value;
    var metaT     = document.getElementById("metaTitle").value;
    var metaD     = document.getElementById("metaDesc").value;
    var keyword   = document.getElementById("focusKeyword").value.trim().toLowerCase();
    var content   = quill.getText();
    
    var checks = [];

    if (title.length >= 30 && title.length <= 70) checks.push({ok:true,  msg:"Title length is good (" + title.length + " chars)"});
    else if (title.length > 0) checks.push({ok:false, msg:"Title: aim for 30–70 chars"});
    else checks.push({ok:false, msg:"Title is missing"});

    if (keyword && title.toLowerCase().includes(keyword)) checks.push({ok:true,  msg:"Focus keyword in title"});
    else if (keyword) checks.push({ok:false, msg:"Add focus keyword to title"});
    else checks.push({warn:true, msg:"No focus keyword set"});

    if (metaT.length >= 50 && metaT.length <= 60) checks.push({ok:true,  msg:"Meta title length perfect"});
    else if (metaT.length > 0) checks.push({warn:true, msg:"Meta title: aim for 50–60 chars"});
    else checks.push({ok:false, msg:"Meta title missing"});

    if (metaD.length >= 120 && metaD.length <= 160) checks.push({ok:true,  msg:"Meta description length perfect"});
    else if (metaD.length > 0) checks.push({warn:true, msg:"Meta desc: aim for 120–160 chars"});
    else checks.push({ok:false, msg:"Meta description missing"});

    var wc = content.trim().split(/\s+/).filter(Boolean).length;
    if (wc >= 600) checks.push({ok:true,  msg:"Content length (" + wc + " words) is good"});
    else if (wc >= 200) checks.push({warn:true, msg:"Content length: aim for 600+ words"});
    else checks.push({ok:false, msg:"Content too short"});

    var score = 0;
    checks.forEach(function(c) { if (c.ok) score += 20; else if (c.warn) score += 10; });
    score = Math.min(100, score);

    var html = "";
    checks.slice(0,5).forEach(function(c) {
        var cls = c.ok ? "dot-ok" : (c.warn ? "dot-warn" : "dot-bad");
        html += "<div class=\"seo-check-item\"><div class=\"dot "+cls+"\"></div><span>"+c.msg+"</span></div>";
    });
    document.getElementById("seoChecklist").innerHTML = html;

    var circ = 213.6;
    var offset = circ - (score/100 * circ);
    var ring = document.getElementById("scoreCircle");
    ring.style.strokeDashoffset = offset;
    
    var color = score >= 80 ? "var(--success)" : score >= 50 ? "var(--warning)" : "var(--danger)";
    ring.style.stroke = color;

    var numEl = document.getElementById("scoreNum");
    numEl.textContent = score;
    numEl.style.color = color;
    
    var verdict = score >= 80 ? "Excellent. Ready to rank!" : score >= 50 ? "Good, but needs tweaks." : "Requires improvements.";
    document.getElementById("scoreVerdict").textContent = verdict;
    
    var badge = document.getElementById("seoScoreBadge");
    badge.textContent = "Score: " + score + "/100";
    badge.className = "badge border rounded-pill px-3 py-1 fw-bold " + (score >= 80 ? "bg-success-subtle text-success border-success-subtle" : score >= 50 ? "bg-warning-subtle text-warning-emphasis border-warning-subtle" : "bg-danger-subtle text-danger border-danger-subtle");
}

function updateKdAnalysis() {
    var keyword = document.getElementById("focusKeyword").value.trim().toLowerCase();
    var content = quill.getText().toLowerCase();
    var kdEl    = document.getElementById("kdResults");

    if (!keyword || content.trim().length < 10) {
        kdEl.innerHTML = "Enter a focus keyword in Meta Tags and write content to see analysis.";
        return;
    }
    var words  = content.trim().split(/\s+/).filter(Boolean);
    var re     = new RegExp(keyword,"gi");
    var kCount = (content.match(re) || []).length;
    var dens   = words.length > 0 ? (kCount / words.length * 100).toFixed(2) : 0;
    var color  = dens >= 0.5 && dens <= 2.5 ? "var(--success)" : dens > 2.5 ? "var(--danger)" : "var(--warning)";

    kdEl.innerHTML =
        "<div class=\"d-flex justify-content-between mb-1\">" +
        "<span class=\"fw-bold text-dark\">" + keyword + "</span>" +
        "<span class=\"fw-bold\" style=\"color:" + color + "\">" + dens + "%</span></div>" +
        "<div class=\"kd-bar\"><div class=\"kd-fill\" style=\"width:" + Math.min(dens/3*100,100) + "%;background:" + color + "\"></div></div>" +
        "<div class=\"d-flex justify-content-between mt-1\" style=\"font-size:0.75rem;\">" +
        "<span>Found " + kCount + " times</span><span>Ideal: 0.5%–2.5%</span></div>";
}

function generateKeywordSuggestions(kw) {
    if (!kw || kw.length < 3) { document.getElementById("keywordSuggestions").innerHTML = ""; return; }
    var suggestions = ["best " + kw, kw + " treatment", kw + " in Nagpur"];
    var html = suggestions.map(function(s) {
        return "<span class=\"keyword-tag shadow-sm\" onclick=\"document.getElementById(\'focusKeyword\').value=\'" + s.replace(/\'/g,"\\\'") + "\';updateSeoScore();updateKdAnalysis();\">" + s + "</span>";
    }).join("");
    document.getElementById("keywordSuggestions").innerHTML = html;
}

/* ═══════════════════════════════════════════════════════════════
   TOGGLES & UPLOADS
══════════════════════════════════════════════════════════════════ */
function setRobots(val, btn) {
    document.querySelectorAll("#robotsIndexGroup .robots-btn").forEach(function(b) { b.classList.remove("active-index", "active-noindex"); });
    btn.classList.add(val === "index" ? "active-index" : "active-noindex");
    document.getElementById("robotsIndex").value = val;
    updateRobotsHint();
}
function setFollow(val, btn) {
    document.querySelectorAll("#robotsFollowGroup .robots-btn").forEach(function(b) { b.classList.remove("active-follow", "active-nofollow"); });
    btn.classList.add(val === "follow" ? "active-follow" : "active-nofollow");
    document.getElementById("robotsFollow").value = val;
    updateRobotsHint();
}
function updateRobotsHint() {
    var idx = document.getElementById("robotsIndex").value;
    var hint = document.getElementById("robotsHint");
    hint.textContent = idx === "index" ? "✅ This page will be indexed and links followed." : "🚫 This page will NOT be indexed.";
    hint.className = "fw-medium mt-2 d-block " + (idx === "index" ? "text-success" : "text-danger");
}

function setSchema(val, btn) {
    document.querySelectorAll(".schema-opt").forEach(function(b) { b.classList.remove("active"); });
    btn.classList.add("active");
    document.getElementById("schemaType").value = val;
}

function updatePublishBadge(cb) {
    var badge = document.getElementById("publishStatusBadge");
    if (cb.checked) {
        badge.textContent = "Live";
        badge.className = "badge bg-success-subtle text-success-emphasis border border-success-subtle rounded-pill px-3 py-1 fw-bold";
    } else {
        badge.textContent = "Draft";
        badge.className = "badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-1 fw-bold";
    }
}

// Reusable Image Preview Logic
function setupImagePreview(inputId, previewId, placeholderId) {
    var input = document.getElementById(inputId);
    if(input) {
        input.addEventListener("change", function() {
            if (this.files && this.files[0]) {
                var r = new FileReader();
                r.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                    document.getElementById(previewId).style.display = "block";
                    document.getElementById(placeholderId).style.display = "none";
                };
                r.readAsDataURL(this.files[0]);
            }
        });
    }
}

setupImagePreview("imageInput", "imagePreview", "imgPlaceholder");
setupImagePreview("heroImageInput", "heroImagePreview", "heroImgPlaceholder");
setupImagePreview("ogImageInput", "ogImagePreview", "ogImgPlaceholder");

// Init
setTimeout(function(){
    updateCharCount("serviceTitle","titleCount",null,null,999);
    updateCharCount("metaTitle","metaTitleCount","metaTitleBar",60,50);
    updateCharCount("metaDesc","metaDescCount","metaDescBar",160,120);
    updateCharCount("shortDescription","excerptCount",null,null,999);
    
    updateSeoScore();
    updateSerpPreview();
    updateKdAnalysis();
    updateRobotsHint();
    if(document.getElementById("isPublished").checked) updatePublishBadge(document.getElementById("isPublished"));
}, 100);

</script>
';

require_once '../include/footer.php';
?>