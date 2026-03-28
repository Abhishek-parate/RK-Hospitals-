<?php
require_once '../include/config.php';

$errors = [];

// Fetch Categories
$categories = [];
$res = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");
if ($res) { while ($r = $res->fetch_assoc()) { $categories[] = $r; } }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── Core Fields ──────────────────────────────────────────────
    $title             = trim($_POST['title'] ?? '');
    $slug              = trim($_POST['slug'] ?? '');
    $h1_title          = trim($_POST['h1_title'] ?? '');
    $hero_title        = trim($_POST['hero_title'] ?? '');
    $hero_subtitle     = trim($_POST['hero_subtitle'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $content           = $_POST['content'] ?? '';
    $category_id       = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $icon              = trim($_POST['icon'] ?? '');
    $sort_order        = !empty($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;
    $is_published      = isset($_POST['is_published']) ? 1 : 0;

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
    $schema_type         = trim($_POST['schema_type'] ?? 'MedicalWebPage');
    
    // ── Validation ───────────────────────────────────────────────
    if (empty($title))   $errors[] = 'Service Title is required.';
    if (empty($content) || $content === '<p><br></p>') $errors[] = 'Service Content is required.';
    
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

    // ── Auto-fill Fallbacks ──────────────────────────────────────
    if (empty($h1_title))         $h1_title = $title;
    if (empty($hero_title))       $hero_title = $title;
    if (empty($meta_title))       $meta_title = $title;
    if (empty($meta_description)) $meta_description = $short_description;
    if (empty($og_title))         $og_title = $meta_title;
    if (empty($og_description))   $og_description = $meta_description;
    if (empty($twitter_title))    $twitter_title = $meta_title;
    if (empty($twitter_description)) $twitter_description = $meta_description;

    // ── Image Upload Helper ──────────────────────────────────────
    function uploadImage($fileKey, $folder) {
        global $errors;
        if (empty($_FILES[$fileKey]['name'])) return '';
        
        $allowedTypes = ['image/jpeg','image/png','image/webp','image/gif'];
        $fileType     = mime_content_type($_FILES[$fileKey]['tmp_name']);
        
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Invalid $fileKey type. Allowed: JPG, PNG, WEBP.";
            return '';
        } elseif ($_FILES[$fileKey]['size'] > 2 * 1024 * 1024) {
            $errors[] = "$fileKey size must be under 2MB.";
            return '';
        }
        
        $uploadDir = "../assets/img/$folder/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        
        $ext      = strtolower(pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION));
        $fileName = $fileKey . '-' . time() . '-' . uniqid() . '.' . $ext;
        
        if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $uploadDir . $fileName)) {
            return "assets/img/$folder/" . $fileName;
        }
        $errors[] = "Failed to upload $fileKey.";
        return '';
    }

    $imagePath     = uploadImage('image', 'service');
    $heroImagePath = uploadImage('hero_image', 'service');
    $ogImagePath   = uploadImage('og_image', 'service/og');

    // If OG is empty, fallback to main or hero
    if (empty($ogImagePath)) {
        $ogImagePath = $heroImagePath ?: $imagePath;
    }

    // ── Build Schema JSON ────────────────────────────────────────
    $schema_json = '';
    if (!empty($schema_type)) {
        $schemaData = [
            '@context'    => 'https://schema.org',
            '@type'       => $schema_type,
            'name'        => $meta_title ?: $title,
            'description' => $meta_description ?: $short_description,
            'url'         => (!empty($canonical_url) ? $canonical_url : ''),
            'image'       => (!empty($ogImagePath) ? $ogImagePath : '')
        ];
        $schema_json = json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    // ── Insert ───────────────────────────────────────────────────
    if (empty($errors)) {
        $s = fn($v) => $conn->real_escape_string($v);

        $robots_meta = $robots_index . ',' . $robots_follow;
        $catVal  = $category_id  ? (int)$category_id : 'NULL';

        $sql = "INSERT INTO services (
                    title, h1_title, hero_title, hero_subtitle, slug, short_description, content, 
                    image, hero_image, icon, category_id, sort_order, is_published,
                    meta_title, meta_description, focus_keyword, canonical_url,
                    og_title, og_description, og_image, og_type,
                    twitter_title, twitter_description, twitter_card,
                    robots_meta, schema_type, schema_json,
                    created_at, updated_at
                ) VALUES (
                    '{$s($title)}','{$s($h1_title)}','{$s($hero_title)}','{$s($hero_subtitle)}','{$s($slug)}','{$s($short_description)}','{$s($content)}',
                    '{$s($imagePath)}','{$s($heroImagePath)}','{$s($icon)}',$catVal,$sort_order,$is_published,
                    '{$s($meta_title)}','{$s($meta_description)}','{$s($focus_keyword)}','{$s($canonical_url)}',
                    '{$s($og_title)}','{$s($og_description)}','{$s($ogImagePath)}','{$s($og_type)}',
                    '{$s($twitter_title)}','{$s($twitter_description)}','{$s($twitter_card)}',
                    '{$s($robots_meta)}','{$s($schema_type)}','{$s($schema_json)}',
                    NOW(),NOW()
                )";

        if ($conn->query($sql)) {
            header("Location: services.php?msg=added");
            exit;
        } else {
            $errors[] = 'Database error: ' . $conn->error;
        }
    }
}

// helpers for repopulate
$p = fn($k) => htmlspecialchars($_POST[$k] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service — Admin Panel</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        :root {
            --bg-base:    #0d0f14;
            --bg-card:    #13161d;
            --bg-card2:   #1a1e28;
            --border:     #252a38;
            --border-2:   #2e3447;
            --accent:     #4f8ef7;
            --accent-glow:#4f8ef720;
            --accent2:    #7c5cfc;
            --success:    #22c55e;
            --warning:    #f59e0b;
            --danger:     #ef4444;
            --text-1:     #e8eaf0;
            --text-2:     #8891a8;
            --text-3:     #555d74;
            --radius:     10px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-base); color: var(--text-1); font-size: 14px; }

        /* ── Cards ── */
        .seo-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); margin-bottom: 18px; overflow: hidden; transition: border-color .2s; }
        .seo-card:hover { border-color: var(--border-2); }
        .seo-card-header { padding: 14px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 10px; background: var(--bg-card2); }
        .seo-card-header .icon { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }
        .seo-card-header h6 { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--text-2); margin: 0; }
        .seo-card-header .badge-pill { margin-left: auto; font-size: 10px; font-family: 'JetBrains Mono', monospace; padding: 3px 8px; border-radius: 20px; background: var(--accent-glow); color: var(--accent); border: 1px solid var(--accent)30; }
        .seo-card-body { padding: 18px; }

        /* ── Form Controls ── */
        .form-label { font-size: 12px; font-weight: 600; color: var(--text-2); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .4px; display: block; }
        .form-control, .form-select { background: var(--bg-base) !important; border: 1px solid var(--border) !important; border-radius: 8px !important; color: var(--text-1) !important; font-size: 13.5px !important; padding: 9px 13px !important; width: 100%; }
        .form-control:focus, .form-select:focus { border-color: var(--accent) !important; box-shadow: 0 0 0 3px var(--accent-glow) !important; outline: none; }
        .form-select option { background: #1a1e28; color: var(--text-1); }

        .input-group .form-control { border-radius: 8px 0 0 8px !important; }
        .input-group-text { background: var(--bg-card2) !important; border: 1px solid var(--border) !important; border-left: none !important; color: var(--text-2) !important; border-radius: 0 8px 8px 0 !important; font-size: 12px; }

        /* ── Char Counter & Bar ── */
        .char-counter { display: flex; justify-content: space-between; margin-top: 5px; font-size: 11px; color: var(--text-3); font-family: 'JetBrains Mono', monospace; }
        .char-counter .count { font-weight: 600; }
        .char-counter .count.ok    { color: var(--success); }
        .char-counter .count.warn  { color: var(--warning); }
        .char-counter .count.bad   { color: var(--danger); }
        .char-bar { height: 3px; background: var(--border); border-radius: 4px; margin-top: 4px; overflow: hidden; }
        .char-bar-fill { height: 100%; border-radius: 4px; transition: width .3s, background .3s; }

        /* ── SEO Widget & SERP (same as blog) ── */
        .seo-score-ring { width: 80px; height: 80px; position: relative; flex-shrink: 0; }
        .seo-score-ring svg { transform: rotate(-90deg); }
        .seo-score-ring .score-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; font-family: 'JetBrains Mono', monospace; }
        .seo-score-ring .score-num { font-size: 20px; font-weight: 700; line-height: 1; display: block; }
        .seo-score-ring .score-label { font-size: 9px; color: var(--text-3); text-transform: uppercase; }
        .seo-checks { flex: 1; min-width: 0; }
        .seo-check-item { display: flex; align-items: flex-start; gap: 8px; padding: 5px 0; font-size: 12.5px; color: var(--text-2); border-bottom: 1px solid var(--border); }
        .seo-check-item .dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; margin-top: 4px; }
        .dot-ok   { background: var(--success); box-shadow: 0 0 6px var(--success)66; }
        .dot-warn { background: var(--warning); }
        .dot-bad  { background: var(--danger); }

        .serp-preview { background: #fff; border: 1px solid #dfe1e5; border-radius: 8px; padding: 14px 16px; margin-top: 2px; }
        .serp-url { font-size: 12px; color: #202124; font-family: Arial, sans-serif; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .serp-title { font-size: 18px; color: #1a0dab; font-family: Arial, sans-serif; cursor: pointer; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.3; }
        .serp-desc { font-size: 13px; color: #4d5156; font-family: Arial, sans-serif; line-height: 1.5; margin-top: 2px; }
        .serp-placeholder { color: #9aa0a6 !important; font-style: italic; }

        /* ── Quill ── */
        .ql-toolbar.ql-snow { background: var(--bg-card2) !important; border-color: var(--border) !important; border-radius: 8px 8px 0 0 !important; }
        .ql-container.ql-snow { background: var(--bg-base) !important; border-color: var(--border) !important; border-radius: 0 0 8px 8px !important; color: var(--text-1) !important; }
        .ql-editor { min-height: 320px; font-size: 14px; line-height: 1.8; color: var(--text-1) !important; }
        .ql-editor.ql-blank::before { color: var(--text-3) !important; font-style: normal !important; }
        .ql-stroke { stroke: var(--text-2) !important; }
        .ql-fill   { fill:   var(--text-2) !important; }
        .ql-picker-label { color: var(--text-2) !important; }
        .ql-picker-options { background: var(--bg-card2) !important; border-color: var(--border) !important; }
        .ql-picker-item    { color: var(--text-1) !important; }

        /* ── Image Upload Zone ── */
        .img-upload-zone { border: 2px dashed var(--border-2); border-radius: 8px; padding: 24px 16px; text-align: center; cursor: pointer; transition: border-color .2s, background .2s; position: relative; }
        .img-upload-zone:hover { border-color: var(--accent); background: var(--accent-glow); }
        .img-upload-zone .upload-icon { font-size: 28px; color: var(--text-3); margin-bottom: 6px; }
        .img-upload-zone p { font-size: 12px; color: var(--text-3); margin: 0; }
        .img-upload-zone .preview-img { width: 100%; border-radius: 6px; object-fit: cover; display: none; }

        /* ── Buttons & Switches ── */
        .form-switch .form-check-input { width: 42px !important; height: 22px !important; background-color: var(--bg-card2) !important; border-color: var(--border-2) !important; cursor: pointer; }
        .form-switch .form-check-input:checked { background-color: var(--accent) !important; border-color: var(--accent) !important; }
        .form-check-label { font-size: 13px; color: var(--text-1); cursor: pointer; }

        .btn-primary-custom { background: linear-gradient(135deg, var(--accent), var(--accent2)); border: none; border-radius: 8px; color: #fff; font-weight: 600; font-size: 13.5px; padding: 10px 20px; width: 100%; cursor: pointer; transition: opacity .2s, transform .15s; display: flex; align-items: center; justify-content: center; gap: 7px; }
        .btn-primary-custom:hover { opacity: .88; transform: translateY(-1px); }
        .btn-secondary-custom { background: transparent; border: 1px solid var(--border-2); border-radius: 8px; color: var(--text-2); font-size: 13px; padding: 9px 20px; width: 100%; cursor: pointer; transition: border-color .2s, color .2s; text-decoration: none; display: block; text-align: center; margin-top: 8px; }
        .btn-secondary-custom:hover { border-color: var(--accent); color: var(--accent); }

        .seo-tabs { display: flex; border-bottom: 1px solid var(--border); margin-bottom: 18px; }
        .seo-tab { padding: 9px 16px; font-size: 12px; font-weight: 600; color: var(--text-3); cursor: pointer; border-bottom: 2px solid transparent; text-transform: uppercase; letter-spacing: .5px; }
        .seo-tab.active { color: var(--accent); border-bottom-color: var(--accent); }
        .seo-tab-pane { display: none; }
        .seo-tab-pane.active { display: block; }

        .page-title-area { display: flex; align-items: center; justify-content: space-between; padding: 20px 0 16px; border-bottom: 1px solid var(--border); margin-bottom: 24px; }
        .page-title-area h3 { font-size: 20px; font-weight: 700; }
        .breadcrumb-area { font-size: 12px; color: var(--text-3); margin-top: 3px; }
        .breadcrumb-area a { color: var(--text-3); text-decoration: none; }
        .breadcrumb-area a:hover { color: var(--accent); }

        .alert-danger-custom { background: #ef444415; border: 1px solid #ef444430; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; color: #fca5a5; font-size: 13px; }
        .alert-danger-custom ul { padding-left: 16px; margin: 0; }

        .page-wrapper { margin-left: 235px; padding: 0; }
        .content { padding: 20px 24px 40px; }
        @media (max-width: 991px) { .page-wrapper { margin-left: 0; } }

        small.hint { font-size: 11px; color: var(--text-3); display: block; margin-top: 5px; }
    </style>
</head>
<body>
<div class="main-wrapper" style="margin-top:40px;">

    <div class="header">
        <div class="header-left">
            <a href="index.php" class="logo"><img src="assets/img/logo.png" alt="Logo"></a>
            <a href="index.php" class="logo logo-small"><img src="assets/img/logo-small.png" alt="Logo" width="30" height="30"></a>
        </div>
        <a href="javascript:void(0);" id="toggle_btn"><i class="fe fe-text-align-left"></i></a>
        <a class="mobile_btn" id="mobile_btn"><i class="fa fa-bars"></i></a>
        <ul class="nav user-menu">
            <li class="nav-item dropdown has-arrow"></li>
        </ul>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title"><span>Main</span></li>
                    <li><a href="index.php"><i class="fe fe-home"></i><span>Dashboard</span></a></li>
                    <li><a href="appointment-list.html"><i class="fe fe-layout"></i><span>Appointments</span></a></li>
                    <li class="active"><a href="services.php"><i class="fe fe-briefcase"></i><span>Services</span></a></li>
                    <li><a href="doctor-list.html"><i class="fe fe-user-plus"></i><span>Doctors</span></a></li>
                    <li><a href="patient-list.html"><i class="fe fe-user"></i><span>Patients</span></a></li>
                    <li><a href="blogs.php"><i class="fe fe-star-o"></i><span>Blogs</span></a></li>
                    <li><a href="settings.html"><i class="fe fe-vector"></i><span>Settings</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-title-area">
                <div>
                    <h3>➕ Add New Service</h3>
                    <div class="breadcrumb-area">
                        <a href="index.php">Dashboard</a> / <a href="services.php">Services</a> /
                        <span>Add Service</span>
                    </div>
                </div>
                <a href="services.php" style="display:inline-flex;align-items:center;gap:6px;color:var(--text-2);font-size:13px;border:1px solid var(--border-2);padding:7px 14px;border-radius:8px;text-decoration:none;transition:all .2s;" onmouseover="this.style.borderColor='var(--accent)';this.style.color='var(--accent)'" onmouseout="this.style.borderColor='var(--border-2)';this.style.color='var(--text-2)'">
                    <i class="fe fe-arrow-left"></i> Back to Services
                </a>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert-danger-custom">
                    <ul>
                        <?php foreach ($errors as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" id="serviceForm">
                <div class="row g-4">

                    <div class="col-xl-8 col-lg-7">

                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#4f8ef720;color:var(--accent)"><i class="fe fe-edit-3"></i></div>
                                <h6>Service Content</h6>
                            </div>
                            <div class="seo-card-body">

                                <div class="mb-4">
                                    <label class="form-label">Service Title (Internal/Menu) <span style="color:var(--danger)">*</span></label>
                                    <input type="text" name="title" id="serviceTitle" class="form-control"
                                           placeholder="e.g., Cardiology, Joint Replacement"
                                           value="<?= $p('title') ?>">
                                    <div class="char-counter">
                                        <span>Used for menus and admin</span>
                                        <span class="count" id="titleCount">0 chars</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">URL Slug</label>
                                        <div class="input-group">
                                            <input type="text" name="slug" id="serviceSlug" class="form-control"
                                                   placeholder="auto-generated"
                                                   value="<?= $p('slug') ?>">
                                            <span class="input-group-text" id="generateSlug" style="cursor:pointer;" title="Auto-generate">
                                                <i class="fa fa-refresh"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">H1 Tag (Main Page Title)</label>
                                        <input type="text" name="h1_title" class="form-control"
                                               placeholder="e.g., Advanced Cardiology Services in Nagpur"
                                               value="<?= $p('h1_title') ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Hero Title (Banner)</label>
                                        <input type="text" name="hero_title" class="form-control"
                                               placeholder="Title overlay on banner"
                                               value="<?= $p('hero_title') ?>">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Hero Subtitle</label>
                                        <input type="text" name="hero_subtitle" class="form-control"
                                               placeholder="Subtitle overlay on banner"
                                               value="<?= $p('hero_subtitle') ?>">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Short Description / Excerpt</label>
                                    <textarea name="short_description" id="serviceExcerpt" class="form-control" rows="3"
                                              placeholder="Summary shown in service grids..."><?= $p('short_description') ?></textarea>
                                    <div class="char-counter">
                                        <span>Summary length</span>
                                        <span class="count" id="excerptCount">0 chars</span>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Main Content <span style="color:var(--danger)">*</span></label>
                                    <div id="quillEditor"></div>
                                    <textarea name="content" id="serviceContent" class="d-none"><?= $p('content') ?></textarea>
                                </div>

                            </div>
                        </div>

                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#22c55e20;color:var(--success)"><i class="fa fa-search"></i></div>
                                <h6>SEO Settings</h6>
                                <div class="badge-pill" id="seoScoreBadge">Score: 0/100</div>
                            </div>
                            <div class="seo-card-body">

                                <div class="seo-tabs">
                                    <div class="seo-tab active" data-tab="tab-meta">Meta Tags</div>
                                    <div class="seo-tab" data-tab="tab-og">Open Graph & Twitter</div>
                                    <div class="seo-tab" data-tab="tab-technical">Technical</div>
                                </div>

                                <div class="seo-tab-pane active" id="tab-meta">
                                    <div class="mb-3">
                                        <label class="form-label">🔑 Focus Keyword</label>
                                        <input type="text" name="focus_keyword" id="focusKeyword" class="form-control"
                                               placeholder="Primary keyword for this service..."
                                               value="<?= $p('focus_keyword') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Meta Title <span style="color:var(--danger)">*</span></label>
                                        <input type="text" name="meta_title" id="metaTitle" class="form-control"
                                               placeholder="SEO title shown in Google search results..."
                                               value="<?= $p('meta_title') ?>" maxlength="70">
                                        <div class="char-bar"><div class="char-bar-fill" id="metaTitleBar" style="width:0%"></div></div>
                                        <div class="char-counter">
                                            <span>Ideal: 50–60 chars</span>
                                            <span class="count" id="metaTitleCount">0 / 60</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Meta Description</label>
                                        <textarea name="meta_description" id="metaDesc" class="form-control" rows="3"
                                                  maxlength="180"><?= $p('meta_description') ?></textarea>
                                        <div class="char-bar"><div class="char-bar-fill" id="metaDescBar" style="width:0%"></div></div>
                                        <div class="char-counter">
                                            <span>Ideal: 120–160 chars</span>
                                            <span class="count" id="metaDescCount">0 / 160</span>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Canonical URL</label>
                                        <input type="text" name="canonical_url" class="form-control" value="<?= $p('canonical_url') ?>">
                                    </div>

                                    <label class="form-label" style="margin-bottom:8px;">🔍 Google SERP Preview</label>
                                    <div class="serp-preview">
                                        <div class="serp-url">rkhospital.com › service › <span id="serpSlug">your-service-slug</span></div>
                                        <div class="serp-title" id="serpTitle"><span class="serp-placeholder">Meta title preview...</span></div>
                                        <div class="serp-desc" id="serpDesc"><span class="serp-placeholder">Meta description preview...</span></div>
                                    </div>
                                </div>

                                <div class="seo-tab-pane" id="tab-og">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">OG Title (Facebook/LinkedIn)</label>
                                            <input type="text" name="og_title" class="form-control" value="<?= $p('og_title') ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Twitter Title</label>
                                            <input type="text" name="twitter_title" class="form-control" value="<?= $p('twitter_title') ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">OG Description</label>
                                            <textarea name="og_description" class="form-control" rows="2"><?= $p('og_description') ?></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Twitter Description</label>
                                            <textarea name="twitter_description" class="form-control" rows="2"><?= $p('twitter_description') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">OG Image (Social Share Image)</label>
                                        <div class="img-upload-zone" onclick="document.getElementById('ogImageInput').click()">
                                            <div class="upload-icon"><i class="fe fe-image"></i></div>
                                            <p>Upload specific SEO Share Image (1200x630)</p>
                                            <img id="ogImagePreview" class="preview-img mt-2">
                                        </div>
                                        <input type="file" name="og_image" id="ogImageInput" accept="image/*" class="d-none">
                                    </div>
                                </div>

                                <div class="seo-tab-pane" id="tab-technical">
                                    <div class="mb-4">
                                        <label class="form-label">Schema Type (JSON-LD)</label>
                                        <select name="schema_type" class="form-select">
                                            <option value="MedicalWebPage" selected>MedicalWebPage (Recommended for Services)</option>
                                            <option value="WebPage">WebPage</option>
                                            <option value="Service">Service</option>
                                            <option value="MedicalSpecialty">MedicalSpecialty</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><div class="col-xl-4 col-lg-5">

                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#22c55e15;color:var(--success)"><i class="fa fa-bar-chart"></i></div>
                                <h6>SEO Analysis</h6>
                            </div>
                            <div class="seo-card-body">
                                <div style="display:flex;gap:16px;align-items:flex-start;">
                                    <div class="seo-score-ring">
                                        <svg width="80" height="80" viewBox="0 0 80 80">
                                            <circle cx="40" cy="40" r="34" fill="none" stroke="#252a38" stroke-width="7"/>
                                            <circle id="scoreCircle" cx="40" cy="40" r="34" fill="none" stroke="#22c55e"
                                                    stroke-width="7" stroke-linecap="round"
                                                    stroke-dasharray="213.6" stroke-dashoffset="213.6"
                                                    style="transition:stroke-dashoffset .5s, stroke .5s"/>
                                        </svg>
                                        <div class="score-text">
                                            <span class="score-num" id="scoreNum" style="color:var(--success)">0</span>
                                            <span class="score-label">/ 100</span>
                                        </div>
                                    </div>
                                    <div class="seo-checks" id="seoChecklist"></div>
                                </div>
                            </div>
                        </div>

                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#7c5cfc20;color:var(--accent2)"><i class="fe fe-send"></i></div>
                                <h6>Publish Settings</h6>
                                <span class="badge-pill" id="publishStatusBadge" style="background:#f59e0b15;color:var(--warning);border-color:#f59e0b30;">Draft</span>
                            </div>
                            <div class="seo-card-body">
                                <div class="mb-3">
                                    <div class="form-check form-switch d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="checkbox" id="isPublished"
                                               name="is_published" value="1"
                                               <?= !empty($_POST['is_published']) ? 'checked' : '' ?>
                                               onchange="updatePublishBadge(this)">
                                        <label class="form-check-label" for="isPublished">Publish Live</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Sort Order</label>
                                        <input type="number" name="sort_order" class="form-control" value="<?= $p('sort_order') ?: '0' ?>">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Category</label>
                                        <select name="category_id" class="form-select">
                                            <option value="">— Select —</option>
                                            <?php foreach ($categories as $cat): ?>
                                                <option value="<?= $cat['id'] ?>" <?= ($p('category_id') == $cat['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($cat['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn-primary-custom mt-2">
                                    <i class="fe fe-save"></i> Save Service
                                </button>
                                <a href="services.php" class="btn-secondary-custom">Cancel</a>
                            </div>
                        </div>

                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#ef444415;color:var(--danger)"><i class="fe fe-image"></i></div>
                                <h6>Content Image (Small)</h6>
                            </div>
                            <div class="seo-card-body">
                                <div class="img-upload-zone" onclick="document.getElementById('imageInput').click()">
                                    <div class="upload-icon"><i class="fe fe-upload-cloud"></i></div>
                                    <p>Inner page side image</p>
                                    <img id="imagePreview" class="preview-img mt-2">
                                </div>
                                <input type="file" name="image" id="imageInput" accept="image/*" class="d-none">
                            </div>
                        </div>

                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#f59e0b15;color:var(--warning)"><i class="fe fe-monitor"></i></div>
                                <h6>Hero Banner Image</h6>
                            </div>
                            <div class="seo-card-body">
                                <div class="img-upload-zone" onclick="document.getElementById('heroImageInput').click()">
                                    <div class="upload-icon"><i class="fe fe-layout"></i></div>
                                    <p>Top banner background (1920x600)</p>
                                    <img id="heroImagePreview" class="preview-img mt-2">
                                </div>
                                <input type="file" name="hero_image" id="heroImageInput" accept="image/*" class="d-none">
                            </div>
                        </div>

                    </div></div></form>

        </div>
    </div>
</div>

<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
// Initialize Quill
var quill = new Quill('#quillEditor', {
    theme: 'snow',
    placeholder: 'Write service description...',
    modules: {
        toolbar: [
            [{ header: [2,3,4,false] }],
            ['bold','italic','underline'],
            [{ list:'ordered' },{ list:'bullet' }],
            ['link','clean']
        ]
    }
});

<?php if (!empty($_POST['content'])): ?>
quill.root.innerHTML = <?= json_encode($_POST['content']) ?>;
<?php endif; ?>

quill.on('text-change', function() {
    document.getElementById('serviceContent').value = quill.root.innerHTML;
    updateSeoScore();
});

document.getElementById('serviceForm').addEventListener('submit', function(e) {
    document.getElementById('serviceContent').value = quill.root.innerHTML;
    if (!quill.getText().trim()) {
        e.preventDefault();
        alert('Content is required!');
    }
});

// Image Upload Previews
function setupImagePreview(inputId, previewId) {
    document.getElementById(inputId).addEventListener('change', function() {
        if (this.files[0]) {
            var r = new FileReader();
            r.onload = function(e) {
                var img = document.getElementById(previewId);
                img.src = e.target.result;
                img.style.display = 'block';
            };
            r.readAsDataURL(this.files[0]);
        }
    });
}
setupImagePreview('imageInput', 'imagePreview');
setupImagePreview('heroImageInput', 'heroImagePreview');
setupImagePreview('ogImageInput', 'ogImagePreview');

// Slug & Title
function toSlug(str) {
    return str.toLowerCase().trim().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');
}

document.getElementById('serviceTitle').addEventListener('input', function() {
    if (!document.getElementById('serviceSlug').dataset.manual) {
        document.getElementById('serviceSlug').value = toSlug(this.value);
    }
    updateCharCount('serviceTitle','titleCount',null,null,999);
    autoFillSeoFields();
    updateSeoScore();
    updateSerpPreview();
});

document.getElementById('serviceSlug').addEventListener('input', function() {
    this.dataset.manual = 'true';
    this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g,'-');
    updateSerpPreview();
});

document.getElementById('generateSlug').addEventListener('click', function() {
    var s = document.getElementById('serviceSlug');
    s.value = toSlug(document.getElementById('serviceTitle').value);
    delete s.dataset.manual;
    updateSerpPreview();
});

// SEO Chars
function updateCharCount(fieldId, countId, barId, max, warnAt) {
    var el = document.getElementById(fieldId);
    if (!el) return;
    var len = el.value.length;
    var countEl = document.getElementById(countId);
    if (countEl) {
        countEl.textContent = max ? len + ' / ' + max : len + ' chars';
        countEl.className = 'count';
        if (max) {
            if (len > max)        countEl.classList.add('bad');
            else if (len > warnAt) countEl.classList.add('warn');
            else if (len >= 10)    countEl.classList.add('ok');
        }
    }
    if (barId && max) {
        var pct = Math.min(len / max * 100, 100);
        var bar = document.getElementById(barId);
        bar.style.width  = pct + '%';
        bar.style.background = len > max ? 'var(--danger)' : len > warnAt ? 'var(--warning)' : 'var(--success)';
    }
}

document.getElementById('metaTitle').addEventListener('input', function() {
    updateCharCount('metaTitle','metaTitleCount','metaTitleBar',60,50);
    updateSerpPreview();
    updateSeoScore();
    this.dataset.manual = '1';
});
document.getElementById('metaDesc').addEventListener('input', function() {
    updateCharCount('metaDesc','metaDescCount','metaDescBar',160,120);
    updateSerpPreview();
    updateSeoScore();
});
document.getElementById('serviceExcerpt').addEventListener('input', function() {
    updateCharCount('serviceExcerpt','excerptCount',null,null,999);
    updateSeoScore();
});

function autoFillSeoFields() {
    var title = document.getElementById('serviceTitle').value;
    var mt = document.getElementById('metaTitle');
    if (!mt.dataset.manual && title) {
        mt.value = title.substring(0,60);
        updateCharCount('metaTitle','metaTitleCount','metaTitleBar',60,50);
        updateSerpPreview();
    }
}

function updateSerpPreview() {
    var title = document.getElementById('metaTitle').value || document.getElementById('serviceTitle').value;
    var desc  = document.getElementById('metaDesc').value  || document.getElementById('serviceExcerpt').value;
    var slug  = document.getElementById('serviceSlug').value || 'slug';

    document.getElementById('serpTitle').innerHTML = title ? title : '<span class="serp-placeholder">Meta title preview...</span>';
    document.getElementById('serpDesc').innerHTML  = desc ? desc.substring(0,160) : '<span class="serp-placeholder">Meta description preview...</span>';
    document.getElementById('serpSlug').textContent = slug;
}

// SEO Engine
function updateSeoScore() {
    var title = document.getElementById('serviceTitle').value;
    var metaT = document.getElementById('metaTitle').value;
    var metaD = document.getElementById('metaDesc').value;
    var kw    = document.getElementById('focusKeyword').value.trim().toLowerCase();

    var checks = [];
    if (title.length > 5) checks.push({ok:true, msg:'Service title is set'});
    else checks.push({ok:false, msg:'Add service title'});

    if (metaT.length >= 40 && metaT.length <= 60) checks.push({ok:true, msg:'Meta title length is good'});
    else checks.push({warn:true, msg:'Check Meta Title length (50-60 chars)'});

    if (metaD.length >= 120 && metaD.length <= 160) checks.push({ok:true, msg:'Meta desc length is good'});
    else checks.push({warn:true, msg:'Check Meta Desc length (120-160 chars)'});

    if (kw && metaT.toLowerCase().includes(kw)) checks.push({ok:true, msg:'Keyword in Meta Title'});
    else if (kw) checks.push({warn:true, msg:'Add Keyword to Meta Title'});

    var score = 0;
    checks.forEach(c => score += c.ok ? 25 : (c.warn ? 10 : 0));
    score = Math.min(100, score);

    var html = '';
    checks.slice(0,4).forEach(c => {
        var cls = c.ok ? 'dot-ok' : (c.warn ? 'dot-warn' : 'dot-bad');
        html += '<div class="seo-check-item"><div class="dot '+cls+'"></div><span>'+c.msg+'</span></div>';
    });
    document.getElementById('seoChecklist').innerHTML = html;

    var circ = 213.6;
    document.getElementById('scoreCircle').style.strokeDashoffset = circ - (score/100 * circ);
    document.getElementById('scoreCircle').style.stroke = score >= 70 ? '#22c55e' : score >= 40 ? '#f59e0b' : '#ef4444';
    document.getElementById('scoreNum').textContent = score;
    document.getElementById('scoreNum').style.color = score >= 70 ? 'var(--success)' : score >= 40 ? 'var(--warning)' : 'var(--danger)';
    document.getElementById('seoScoreBadge').textContent = 'Score: ' + score + '/100';
}

// Tabs
document.querySelectorAll('.seo-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.seo-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.seo-tab-pane').forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        document.getElementById(this.dataset.tab).classList.add('active');
    });
});

// Status Badge
function updatePublishBadge(cb) {
    var b = document.getElementById('publishStatusBadge');
    if (cb.checked) {
        b.textContent = 'Live'; b.style.background = '#22c55e15'; b.style.color = 'var(--success)'; b.style.borderColor = '#22c55e30';
    } else {
        b.textContent = 'Draft'; b.style.background = '#f59e0b15'; b.style.color = 'var(--warning)'; b.style.borderColor = '#f59e0b30';
    }
}

// Init
updateCharCount('metaTitle','metaTitleCount','metaTitleBar',60,50);
updateCharCount('metaDesc','metaDescCount','metaDescBar',160,120);
updateSerpPreview();
updateSeoScore();
updatePublishBadge(document.getElementById('isPublished'));
</script>
</body>
</html>