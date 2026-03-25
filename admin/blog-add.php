<?php
require_once '../include/config.php';

$errors = [];

$categories = [];
$res = $conn->query("SELECT id, name FROM blog_categories ORDER BY name ASC");
if ($res) { while ($r = $res->fetch_assoc()) { $categories[] = $r; } }

$authors = [];
$res = $conn->query("SELECT id, name FROM blog_authors ORDER BY name ASC");
if ($res) { while ($r = $res->fetch_assoc()) { $authors[] = $r; } }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── Core Fields ──────────────────────────────────────────────
    $title        = trim($_POST['title'] ?? '');
    $slug         = trim($_POST['slug'] ?? '');
    $excerpt      = trim($_POST['excerpt'] ?? '');
    $content      = $_POST['content'] ?? '';
    $category_id  = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $author_id    = !empty($_POST['author_id'])   ? (int)$_POST['author_id']   : null;
    $tags         = trim($_POST['tags'] ?? '');
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $published_at = !empty($_POST['published_at']) ? trim($_POST['published_at']) : null;

    // ── SEO Fields ───────────────────────────────────────────────
    $meta_title       = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $focus_keyword    = trim($_POST['focus_keyword'] ?? '');
    $canonical_url    = trim($_POST['canonical_url'] ?? '');
    $og_title         = trim($_POST['og_title'] ?? '');
    $og_description   = trim($_POST['og_description'] ?? '');
    $og_type          = trim($_POST['og_type'] ?? 'article');
    $twitter_title    = trim($_POST['twitter_title'] ?? '');
    $twitter_description = trim($_POST['twitter_description'] ?? '');
    $robots_index     = trim($_POST['robots_index'] ?? 'index');
    $robots_follow    = trim($_POST['robots_follow'] ?? 'follow');
    $schema_type      = trim($_POST['schema_type'] ?? 'BlogPosting');
    $reading_time     = !empty($_POST['reading_time']) ? (int)$_POST['reading_time'] : null;

    // ── Validation ───────────────────────────────────────────────
    if (empty($title))   $errors[] = 'Title is required.';
    if (empty($content) || $content === '<p><br></p>') $errors[] = 'Content is required.';
    if (!empty($meta_title) && mb_strlen($meta_title) > 60)
        $errors[] = 'Meta title should not exceed 60 characters.';
    if (!empty($meta_description) && mb_strlen($meta_description) > 160)
        $errors[] = 'Meta description should not exceed 160 characters.';

    // ── Slug Generation ──────────────────────────────────────────
    if (empty($slug)) {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
    } else {
        $slug = strtolower(preg_replace('/[^a-z0-9-]+/', '-', $slug));
    }
    $slug    = trim($slug, '-');
    $slugEsc = $conn->real_escape_string($slug);

    $chk = $conn->query("SELECT id FROM blogs WHERE slug = '$slugEsc'");
    if ($chk && $chk->num_rows > 0) {
        $errors[] = 'Slug already exists. Please use a different one.';
    }

    // ── Auto-fill SEO defaults ───────────────────────────────────
    if (empty($meta_title))       $meta_title       = $title;
    if (empty($meta_description)) $meta_description = $excerpt;
    if (empty($og_title))         $og_title         = $meta_title;
    if (empty($og_description))   $og_description   = $meta_description;
    if (empty($twitter_title))    $twitter_title    = $meta_title;
    if (empty($twitter_description)) $twitter_description = $meta_description;

    // ── Image Upload ─────────────────────────────────────────────
    $imagePath   = '';
    $ogImagePath = '';
    if (!empty($_FILES['image']['name'])) {
        $allowedTypes = ['image/jpeg','image/png','image/webp','image/gif'];
        $fileType     = mime_content_type($_FILES['image']['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = 'Invalid image type. Allowed: JPG, PNG, WEBP, GIF.';
        } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Image size must be under 2MB.';
        } else {
            $uploadDir = '../assets/img/blog/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $ext      = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $fileName = 'blog-' . time() . '-' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                $imagePath   = 'assets/img/blog/' . $fileName;
                $ogImagePath = $imagePath;
            } else {
                $errors[] = 'Failed to upload image. Check folder permissions.';
            }
        }
    }

    // ── OG Image (separate) ──────────────────────────────────────
    if (!empty($_FILES['og_image']['name'])) {
        $fileType2 = mime_content_type($_FILES['og_image']['tmp_name']);
        if (in_array($fileType2, ['image/jpeg','image/png','image/webp'])) {
            $uploadDir = '../assets/img/blog/og/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $ext2     = strtolower(pathinfo($_FILES['og_image']['name'], PATHINFO_EXTENSION));
            $ogFile   = 'og-' . time() . '-' . uniqid() . '.' . $ext2;
            if (move_uploaded_file($_FILES['og_image']['tmp_name'], $uploadDir . $ogFile)) {
                $ogImagePath = 'assets/img/blog/og/' . $ogFile;
            }
        }
    }

    // ── Build Schema JSON ────────────────────────────────────────
    $schema_json = '';
    if (!empty($schema_type)) {
        $schemaData = [
            '@context' => 'https://schema.org',
            '@type'    => $schema_type,
            'headline' => $meta_title ?: $title,
            'description' => $meta_description ?: $excerpt,
            'url'      => (!empty($canonical_url) ? $canonical_url : ''),
            'image'    => (!empty($ogImagePath) ? $ogImagePath : ''),
            'datePublished' => $published_at ?: date('Y-m-d'),
            'dateModified'  => date('Y-m-d'),
        ];
        $schema_json = json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    // ── Insert ───────────────────────────────────────────────────
    if (empty($errors)) {
        $s = fn($v) => $conn->real_escape_string($v);

        $robots_meta = $robots_index . ',' . $robots_follow;
        $pubAt   = $published_at ? "'" . $s($published_at) . "'" : 'NULL';
        $catVal  = $category_id  ? (int)$category_id : 'NULL';
        $authVal = $author_id    ? (int)$author_id   : 'NULL';
        $rtVal   = $reading_time ? (int)$reading_time : 'NULL';

        $sql = "INSERT INTO blogs (
                    title, slug, excerpt, content, image,
                    category_id, author_id, tags, is_published, published_at,
                    meta_title, meta_description, focus_keyword, canonical_url,
                    og_title, og_description, og_image, og_type,
                    twitter_title, twitter_description,
                    robots_meta, schema_type, schema_json,
                    reading_time, views, comments, created_at, updated_at
                ) VALUES (
                    '{$s($title)}','{$s($slug)}','{$s($excerpt)}','{$s($content)}','{$s($imagePath)}',
                    $catVal,$authVal,'{$s($tags)}',$is_published,$pubAt,
                    '{$s($meta_title)}','{$s($meta_description)}','{$s($focus_keyword)}','{$s($canonical_url)}',
                    '{$s($og_title)}','{$s($og_description)}','{$s($ogImagePath)}','{$s($og_type)}',
                    '{$s($twitter_title)}','{$s($twitter_description)}',
                    '{$s($robots_meta)}','{$s($schema_type)}','{$s($schema_json)}',
                    $rtVal,0,0,NOW(),NOW()
                )";

        if ($conn->query($sql)) {
            header("Location: blogs.php?msg=added");
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
    <title>Add Blog — Admin Panel</title>
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
            --shadow:     0 4px 24px rgba(0,0,0,.45);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-base);
            color: var(--text-1);
            font-size: 14px;
        }

        /* ── Cards ── */
        .seo-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            margin-bottom: 18px;
            overflow: hidden;
            transition: border-color .2s;
        }
        .seo-card:hover { border-color: var(--border-2); }

        .seo-card-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg-card2);
        }
        .seo-card-header .icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }
        .seo-card-header h6 {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--text-2);
            margin: 0;
        }
        .seo-card-header .badge-pill {
            margin-left: auto;
            font-size: 10px;
            font-family: 'JetBrains Mono', monospace;
            padding: 3px 8px;
            border-radius: 20px;
            background: var(--accent-glow);
            color: var(--accent);
            border: 1px solid var(--accent)30;
        }

        .seo-card-body { padding: 18px; }

        /* ── Form Controls ── */
        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-2);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .4px;
            display: block;
        }
        .form-control, .form-select {
            background: var(--bg-base) !important;
            border: 1px solid var(--border) !important;
            border-radius: 8px !important;
            color: var(--text-1) !important;
            font-size: 13.5px !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 9px 13px !important;
            transition: border-color .2s, box-shadow .2s;
            width: 100%;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px var(--accent-glow) !important;
            outline: none;
        }
        .form-control::placeholder { color: var(--text-3) !important; }
        textarea.form-control { resize: vertical; }
        .form-select option { background: #1a1e28; color: var(--text-1); }

        /* ── Input Group ── */
        .input-group .form-control { border-radius: 8px 0 0 8px !important; }
        .input-group-text {
            background: var(--bg-card2) !important;
            border: 1px solid var(--border) !important;
            border-left: none !important;
            color: var(--text-2) !important;
            border-radius: 0 8px 8px 0 !important;
            font-size: 12px;
        }

        /* ── Char Counter ── */
        .char-counter {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 11px;
            color: var(--text-3);
            font-family: 'JetBrains Mono', monospace;
        }
        .char-counter .count { font-weight: 600; }
        .char-counter .count.ok    { color: var(--success); }
        .char-counter .count.warn  { color: var(--warning); }
        .char-counter .count.bad   { color: var(--danger); }

        /* ── Progress Bar ── */
        .char-bar {
            height: 3px;
            background: var(--border);
            border-radius: 4px;
            margin-top: 4px;
            overflow: hidden;
        }
        .char-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width .3s, background .3s;
        }

        /* ── SEO Score Widget ── */
        .seo-score-ring {
            width: 80px; height: 80px;
            position: relative;
            flex-shrink: 0;
        }
        .seo-score-ring svg { transform: rotate(-90deg); }
        .seo-score-ring .score-text {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-family: 'JetBrains Mono', monospace;
        }
        .seo-score-ring .score-num {
            font-size: 20px;
            font-weight: 700;
            line-height: 1;
            display: block;
        }
        .seo-score-ring .score-label {
            font-size: 9px;
            color: var(--text-3);
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .seo-checks { flex: 1; min-width: 0; }
        .seo-check-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 5px 0;
            font-size: 12.5px;
            color: var(--text-2);
            border-bottom: 1px solid var(--border);
        }
        .seo-check-item:last-child { border-bottom: none; }
        .seo-check-item .dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 4px;
        }
        .dot-ok   { background: var(--success); box-shadow: 0 0 6px var(--success)66; }
        .dot-warn { background: var(--warning); }
        .dot-bad  { background: var(--danger); }

        /* ── SERP Preview ── */
        .serp-preview {
            background: #fff;
            border: 1px solid #dfe1e5;
            border-radius: 8px;
            padding: 14px 16px;
            margin-top: 2px;
        }
        .serp-url {
            font-size: 12px;
            color: #202124;
            font-family: Arial, sans-serif;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .serp-title {
            font-size: 18px;
            color: #1a0dab;
            font-family: Arial, sans-serif;
            cursor: pointer;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 400;
            line-height: 1.3;
        }
        .serp-desc {
            font-size: 13px;
            color: #4d5156;
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin-top: 2px;
        }
        .serp-date {
            font-size: 12px;
            color: #70757a;
            font-family: Arial, sans-serif;
        }
        .serp-placeholder {
            color: #9aa0a6 !important;
            font-style: italic;
        }

        /* ── OG Preview ── */
        .og-preview-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            background: #f7f7f7;
            margin-top: 6px;
        }
        .og-preview-img {
            width: 100%; height: 130px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 12px;
        }
        .og-preview-img img { width: 100%; height: 100%; object-fit: cover; }
        .og-preview-body { padding: 10px 12px; background: #fff; }
        .og-preview-domain { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: .5px; font-family: Arial, sans-serif; }
        .og-preview-title  { font-size: 14px; font-weight: 700; color: #1a1a1a; font-family: Arial, sans-serif; margin: 2px 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .og-preview-desc   { font-size: 12px; color: #555; font-family: Arial, sans-serif; }

        /* ── Quill ── */
        .ql-toolbar.ql-snow {
            background: var(--bg-card2) !important;
            border-color: var(--border) !important;
            border-radius: 8px 8px 0 0 !important;
        }
        .ql-container.ql-snow {
            background: var(--bg-base) !important;
            border-color: var(--border) !important;
            border-radius: 0 0 8px 8px !important;
            color: var(--text-1) !important;
        }
        .ql-editor { min-height: 320px; font-size: 14px; line-height: 1.8; color: var(--text-1) !important; }
        .ql-editor.ql-blank::before { color: var(--text-3) !important; font-style: normal !important; }
        .ql-stroke { stroke: var(--text-2) !important; }
        .ql-fill   { fill:   var(--text-2) !important; }
        .ql-picker-label { color: var(--text-2) !important; }
        .ql-picker-options { background: var(--bg-card2) !important; border-color: var(--border) !important; }
        .ql-picker-item    { color: var(--text-1) !important; }

        /* ── Image Upload ── */
        .img-upload-zone {
            border: 2px dashed var(--border-2);
            border-radius: 8px;
            padding: 24px 16px;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s, background .2s;
            position: relative;
        }
        .img-upload-zone:hover { border-color: var(--accent); background: var(--accent-glow); }
        .img-upload-zone .upload-icon { font-size: 28px; color: var(--text-3); margin-bottom: 6px; }
        .img-upload-zone p { font-size: 12px; color: var(--text-3); margin: 0; }
        .img-upload-zone .preview-img {
            width: 100%; border-radius: 6px;
            object-fit: cover; display: none;
        }

        /* ── Toggle Switch ── */
        .form-switch .form-check-input {
            width: 42px !important; height: 22px !important;
            background-color: var(--bg-card2) !important;
            border-color: var(--border-2) !important;
            cursor: pointer;
        }
        .form-switch .form-check-input:checked {
            background-color: var(--accent) !important;
            border-color: var(--accent) !important;
        }
        .form-check-label { font-size: 13px; color: var(--text-1); cursor: pointer; }

        /* ── Buttons ── */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none;
            border-radius: 8px;
            color: #fff;
            font-weight: 600;
            font-size: 13.5px;
            padding: 10px 20px;
            width: 100%;
            cursor: pointer;
            transition: opacity .2s, transform .15s;
            display: flex; align-items: center; justify-content: center; gap: 7px;
        }
        .btn-primary-custom:hover { opacity: .88; transform: translateY(-1px); }
        .btn-secondary-custom {
            background: transparent;
            border: 1px solid var(--border-2);
            border-radius: 8px;
            color: var(--text-2);
            font-size: 13px;
            padding: 9px 20px;
            width: 100%;
            cursor: pointer;
            transition: border-color .2s, color .2s;
            text-decoration: none;
            display: block; text-align: center; margin-top: 8px;
        }
        .btn-secondary-custom:hover { border-color: var(--accent); color: var(--accent); }

        /* ── Tabs ── */
        .seo-tabs { display: flex; border-bottom: 1px solid var(--border); margin-bottom: 18px; }
        .seo-tab {
            padding: 9px 16px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-3);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: color .2s, border-color .2s;
            text-transform: uppercase;
            letter-spacing: .5px;
            user-select: none;
        }
        .seo-tab.active { color: var(--accent); border-bottom-color: var(--accent); }
        .seo-tab-pane { display: none; }
        .seo-tab-pane.active { display: block; }

        /* ── Robots ── */
        .robots-group { display: flex; gap: 8px; }
        .robots-btn {
            flex: 1; padding: 7px; text-align: center;
            border-radius: 8px; cursor: pointer;
            font-size: 12px; font-weight: 600;
            border: 1px solid var(--border-2);
            color: var(--text-2);
            background: transparent;
            transition: all .2s;
        }
        .robots-btn.active-index  { border-color: var(--success); color: var(--success); background: #22c55e15; }
        .robots-btn.active-noindex { border-color: var(--danger);  color: var(--danger);  background: #ef444415; }
        .robots-btn.active-follow  { border-color: var(--accent);  color: var(--accent);  background: var(--accent-glow); }
        .robots-btn.active-nofollow { border-color: var(--warning); color: var(--warning); background: #f59e0b15; }

        /* ── Keyword Density ── */
        .kd-bar { height: 6px; background: var(--border); border-radius: 4px; overflow: hidden; }
        .kd-fill { height: 100%; border-radius: 4px; background: var(--accent); transition: width .4s; }

        /* ── Page Header ── */
        .page-title-area {
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 0 16px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 24px;
        }
        .page-title-area h3 { font-size: 20px; font-weight: 700; }
        .breadcrumb-area { font-size: 12px; color: var(--text-3); margin-top: 3px; }
        .breadcrumb-area a { color: var(--text-3); text-decoration: none; }
        .breadcrumb-area a:hover { color: var(--accent); }
        .breadcrumb-area span { color: var(--text-2); }

        /* ── Alert ── */
        .alert-danger-custom {
            background: #ef444415;
            border: 1px solid #ef444430;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #fca5a5;
            font-size: 13px;
        }
        .alert-danger-custom ul { padding-left: 16px; margin: 0; }

        /* ── Keyword Tags ── */
        .keyword-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
        .keyword-tag {
            background: var(--bg-card2);
            border: 1px solid var(--border-2);
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 11px;
            color: var(--text-2);
            cursor: pointer;
            transition: border-color .15s, color .15s;
        }
        .keyword-tag:hover { border-color: var(--accent); color: var(--accent); }

        /* ── Schema type badges ── */
        .schema-options { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px; }
        .schema-opt {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid var(--border-2);
            color: var(--text-2);
            background: transparent;
            transition: all .15s;
        }
        .schema-opt.active { border-color: var(--accent2); color: var(--accent2); background: #7c5cfc15; }

        /* Override admin sidebar styles for dark theme consistency */
        .page-wrapper { margin-left: 235px; padding: 0; }
        .content { padding: 20px 24px 40px; }
        @media (max-width: 991px) { .page-wrapper { margin-left: 0; } }

        /* ── Reading Time ── */
        .reading-time-display {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 12px; color: var(--text-2);
            background: var(--bg-card2);
            border: 1px solid var(--border);
            padding: 4px 10px; border-radius: 20px;
            margin-top: 8px;
        }

        /* ── Status pills ── */
        .status-pill {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11px; font-weight: 600;
            padding: 3px 9px; border-radius: 20px;
        }
        .pill-live { background: #22c55e20; color: var(--success); border: 1px solid #22c55e40; }
        .pill-draft { background: #f59e0b15; color: var(--warning); border: 1px solid #f59e0b30; }

        small.hint { font-size: 11px; color: var(--text-3); display: block; margin-top: 5px; }
    </style>
</head>
<body>
<div class="main-wrapper" style="margin-top:40px;">

    <!-- ═══ HEADER ════════════════════════════════════════════════ -->
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

    <!-- ═══ SIDEBAR ═══════════════════════════════════════════════ -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title"><span>Main</span></li>
                    <li><a href="index.php"><i class="fe fe-home"></i><span>Dashboard</span></a></li>
                    <li><a href="appointment-list.html"><i class="fe fe-layout"></i><span>Appointments</span></a></li>
                    <li><a href="specialities.html"><i class="fe fe-users"></i><span>Specialities</span></a></li>
                    <li><a href="doctor-list.html"><i class="fe fe-user-plus"></i><span>Doctors</span></a></li>
                    <li><a href="patient-list.html"><i class="fe fe-user"></i><span>Patients</span></a></li>
                    <li class="active"><a href="blogs.php"><i class="fe fe-star-o"></i><span>Blogs</span></a></li>
                    <li><a href="transactions-list.html"><i class="fe fe-activity"></i><span>Transactions</span></a></li>
                    <li><a href="settings.html"><i class="fe fe-vector"></i><span>Settings</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ═══ PAGE WRAPPER ══════════════════════════════════════════ -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-title-area">
                <div>
                    <h3>✍️ Add New Blog</h3>
                    <div class="breadcrumb-area">
                        <a href="index.php">Dashboard</a> / <a href="blogs.php">Blogs</a> /
                        <span>Add Blog</span>
                    </div>
                </div>
                <a href="blogs.php" style="display:inline-flex;align-items:center;gap:6px;color:var(--text-2);font-size:13px;border:1px solid var(--border-2);padding:7px 14px;border-radius:8px;text-decoration:none;transition:all .2s;" onmouseover="this.style.borderColor='var(--accent)';this.style.color='var(--accent)'" onmouseout="this.style.borderColor='var(--border-2)';this.style.color='var(--text-2)'">
                    <i class="fe fe-arrow-left"></i> Back to Blogs
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

            <form method="POST" enctype="multipart/form-data" id="blogForm">
                <div class="row g-4">

                    <!-- ════════════ LEFT COLUMN ════════════ -->
                    <div class="col-xl-8 col-lg-7">

                        <!-- Blog Content Card -->
                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#4f8ef720;color:var(--accent)"><i class="fe fe-edit-3"></i></div>
                                <h6>Blog Content</h6>
                            </div>
                            <div class="seo-card-body">

                                <div class="mb-4">
                                    <label class="form-label">Title <span style="color:var(--danger)">*</span></label>
                                    <input type="text" name="title" id="blogTitle" class="form-control"
                                           placeholder="Enter an engaging blog title..."
                                           value="<?= $p('title') ?>">
                                    <div class="char-counter">
                                        <span>Title length</span>
                                        <span class="count" id="titleCount">0 chars</span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">URL Slug</label>
                                    <div class="input-group">
                                        <input type="text" name="slug" id="blogSlug" class="form-control"
                                               placeholder="auto-generated-from-title"
                                               value="<?= $p('slug') ?>">
                                        <span class="input-group-text" id="generateSlug" style="cursor:pointer;" title="Auto-generate from title">
                                            <i class="fa fa-refresh"></i>
                                        </span>
                                    </div>
                                    <small class="hint">Lowercase letters, numbers and hyphens only. Keep it short &amp; keyword-rich.</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Excerpt / Short Description</label>
                                    <textarea name="excerpt" id="blogExcerpt" class="form-control" rows="3"
                                              placeholder="Write a compelling 1-2 sentence summary shown in blog listings and social shares..."><?= $p('excerpt') ?></textarea>
                                    <div class="char-counter">
                                        <span>Excerpt</span>
                                        <span class="count" id="excerptCount">0 chars</span>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Content <span style="color:var(--danger)">*</span></label>
                                    <div id="quillEditor"></div>
                                    <textarea name="content" id="blogContent" class="d-none"><?= $p('content') ?></textarea>
                                    <div id="readingTimeDisplay" class="reading-time-display" style="display:none!important;">
                                        <i class="fe fe-clock"></i>
                                        <span id="readingTimeText">~0 min read</span>
                                    </div>
                                    <input type="hidden" name="reading_time" id="readingTimeInput">
                                </div>

                            </div>
                        </div>

                        <!-- SEO Settings Card -->
                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#22c55e20;color:var(--success)"><i class="fa fa-search"></i></div>
                                <h6>SEO Settings</h6>
                                <div class="badge-pill" id="seoScoreBadge">Score: 0/100</div>
                            </div>
                            <div class="seo-card-body">

                                <!-- SEO Tabs -->
                                <div class="seo-tabs">
                                    <div class="seo-tab active" data-tab="tab-meta">Meta Tags</div>
                                    <div class="seo-tab" data-tab="tab-og">Open Graph</div>
                                    <div class="seo-tab" data-tab="tab-twitter">Twitter Card</div>
                                    <div class="seo-tab" data-tab="tab-technical">Technical</div>
                                </div>

                                <!-- TAB: Meta Tags -->
                                <div class="seo-tab-pane active" id="tab-meta">

                                    <div class="mb-3">
                                        <label class="form-label">🔑 Focus Keyword</label>
                                        <input type="text" name="focus_keyword" id="focusKeyword" class="form-control"
                                               placeholder="Primary keyword you're targeting..."
                                               value="<?= $p('focus_keyword') ?>">
                                        <small class="hint">Used to analyse keyword density and SEO score in real-time.</small>
                                        <div id="keywordSuggestions" class="keyword-tags"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Meta Title <span style="color:var(--danger)">*</span></label>
                                        <input type="text" name="meta_title" id="metaTitle" class="form-control"
                                               placeholder="SEO title shown in Google search results..."
                                               value="<?= $p('meta_title') ?>" maxlength="70">
                                        <div class="char-bar"><div class="char-bar-fill" id="metaTitleBar" style="width:0%"></div></div>
                                        <div class="char-counter">
                                            <span>Ideal: 50–60 characters</span>
                                            <span class="count" id="metaTitleCount">0 / 60</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
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
       placeholder="https://yourdomain.com/blog/your-post-slug"
       value="<?= $p('canonical_url') ?>">
                                        <small class="hint">Leave blank to auto-generate. Use if this content exists on another URL.</small>
                                    </div>

                                    <!-- SERP Preview -->
                                    <label class="form-label" style="margin-bottom:8px;">🔍 Google SERP Preview</label>
                                    <div class="serp-preview">
                                        <div class="serp-url" id="serpUrl">https://yourdomain.com › blog › <span id="serpSlug">your-post-slug</span></div>
                                        <div class="serp-title" id="serpTitle"><span class="serp-placeholder">Your meta title will appear here...</span></div>
                                        <div class="serp-date" id="serpDate" style="color:#70757a;font-family:Arial,sans-serif;font-size:12px;">Mar 25, 2026 — </div>
                                        <div class="serp-desc" id="serpDesc"><span class="serp-placeholder">Your meta description will appear here. Make it compelling to improve click-through rate.</span></div>
                                    </div>

                                </div>

                                <!-- TAB: Open Graph -->
                                <div class="seo-tab-pane" id="tab-og">
                                    <div class="mb-3">
                                        <label class="form-label">OG Title</label>
                                        <input type="text" name="og_title" id="ogTitle" class="form-control"
                                               placeholder="Title shown when shared on Facebook, LinkedIn..."
                                               value="<?= $p('og_title') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">OG Description</label>
                                        <textarea name="og_description" id="ogDesc" class="form-control" rows="2"
                                                  placeholder="Description shown on social media shares..."><?= $p('og_description') ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">OG Type</label>
                                        <select name="og_type" class="form-select">
                                            <option value="article" <?= ($p('og_type')||'article')==='article' ? 'selected' : '' ?>>article</option>
                                            <option value="website" <?= $p('og_type')==='website' ? 'selected' : '' ?>>website</option>
                                            <option value="blog"    <?= $p('og_type')==='blog'    ? 'selected' : '' ?>>blog</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">OG Image (1200×630 recommended)</label>
                                        <div class="img-upload-zone" id="ogImageZone" onclick="document.getElementById('ogImageInput').click()">
                                            <div class="upload-icon"><i class="fe fe-image"></i></div>
                                            <p>Click to upload OG image</p>
                                            <small style="color:var(--text-3);font-size:11px;">JPG, PNG, WEBP · Ideal: 1200×630px</small>
                                            <img id="ogImagePreview" class="preview-img" alt="OG Preview">
                                        </div>
                                        <input type="file" name="og_image" id="ogImageInput" accept="image/*" class="d-none">
                                    </div>

                                    <!-- Facebook OG Preview -->
                                    <label class="form-label">📘 Facebook Preview</label>
                                    <div class="og-preview-card">
                                        <div class="og-preview-img" id="ogPreviewImgBox">
                                            <span>No OG image selected</span>
                                        </div>
                                        <div class="og-preview-body">
                                            <div class="og-preview-domain">yourdomain.com</div>
                                            <div class="og-preview-title" id="ogPreviewTitle">OG Title will appear here</div>
                                            <div class="og-preview-desc" id="ogPreviewDesc">OG description will appear here</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB: Twitter Card -->
                                <div class="seo-tab-pane" id="tab-twitter">
                                    <div class="mb-3" style="padding:10px;background:var(--bg-card2);border-radius:8px;border:1px solid var(--border);">
                                        <small style="color:var(--text-2);font-size:12px;">💡 <strong>Tip:</strong> Leave these blank to auto-inherit from Meta Title/Description on save.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Twitter Title</label>
                                        <input type="text" name="twitter_title" class="form-control"
                                               placeholder="Title shown on Twitter card..."
                                               value="<?= $p('twitter_title') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Twitter Description</label>
                                        <textarea name="twitter_description" class="form-control" rows="2"
                                                  placeholder="Description shown on Twitter card..."><?= $p('twitter_description') ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Twitter Card Type</label>
                                        <select name="twitter_card" class="form-select">
                                            <option value="summary_large_image" selected>summary_large_image (Recommended)</option>
                                            <option value="summary">summary</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- TAB: Technical SEO -->
                                <div class="seo-tab-pane" id="tab-technical">

                                    <div class="mb-4">
                                        <label class="form-label">Robots Meta Tag</label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="robots-group" id="robotsIndexGroup">
                                                    <button type="button" class="robots-btn active-index" data-val="index" onclick="setRobots('index',this)">✅ INDEX</button>
                                                    <button type="button" class="robots-btn" data-val="noindex" onclick="setRobots('noindex',this)">🚫 NOINDEX</button>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="robots-group" id="robotsFollowGroup">
                                                    <button type="button" class="robots-btn active-follow" data-val="follow" onclick="setFollow('follow',this)">🔗 FOLLOW</button>
                                                    <button type="button" class="robots-btn" data-val="nofollow" onclick="setFollow('nofollow',this)">⛔ NOFOLLOW</button>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="robots_index" id="robotsIndex" value="index">
                                        <input type="hidden" name="robots_follow" id="robotsFollow" value="follow">
                                        <small class="hint" id="robotsHint" style="color:var(--success)">✅ This page will be indexed and links followed by search engines.</small>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Schema / Structured Data Type</label>
                                        <div class="schema-options">
                                            <?php $schemas = ['BlogPosting','Article','NewsArticle','MedicalWebPage','FAQPage','HowTo']; ?>
                                            <?php foreach ($schemas as $s): ?>
                                            <button type="button" class="schema-opt <?= ($p('schema_type') ?: 'BlogPosting') === $s ? 'active' : '' ?>"
                                                    onclick="setSchema('<?= $s ?>',this)"><?= $s ?></button>
                                            <?php endforeach; ?>
                                        </div>
                                        <input type="hidden" name="schema_type" id="schemaType" value="<?= $p('schema_type') ?: 'BlogPosting' ?>">
                                        <small class="hint">For healthcare blogs, <strong>MedicalWebPage</strong> or <strong>Article</strong> gives best rich-result coverage.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Keyword Density Analyser</label>
                                        <div id="kdResults" style="color:var(--text-3);font-size:12px;">Enter a focus keyword above and write content to see density analysis.</div>
                                    </div>

                                </div>
                                <!-- /Tabs -->

                            </div>
                        </div><!-- /SEO card -->

                    </div><!-- /col-xl-8 -->

                    <!-- ════════════ RIGHT COLUMN ════════════ -->
                    <div class="col-xl-4 col-lg-5">

                        <!-- Live SEO Score Card -->
                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#22c55e15;color:var(--success)"><i class="fa fa-bar-chart"></i></div>
                                <h6>Live SEO Score</h6>
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

                        <!-- Publish Settings -->
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
                                        <label class="form-check-label" for="isPublished">Publish Immediately</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Scheduled Publish Date</label>
                                    <input type="datetime-local" name="published_at" class="form-control"
                                           value="<?= $p('published_at') ?>">
                                </div>
                                <button type="submit" class="btn-primary-custom">
                                    <i class="fe fe-save"></i> Save Blog Post
                                </button>
                                <a href="blogs.php" class="btn-secondary-custom">Cancel</a>
                            </div>
                        </div>

                        <!-- Category & Author -->
                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#f59e0b15;color:var(--warning)"><i class="fe fe-tag"></i></div>
                                <h6>Category & Author</h6>
                            </div>
                            <div class="seo-card-body">
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category_id" class="form-select">
                                        <option value="">— Select Category —</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['id'] ?>"
                                                <?= (isset($_POST['category_id']) && $_POST['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cat['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Author (Doctor)</label>
                                    <select name="author_id" class="form-select">
                                        <option value="">— Select Author —</option>
                                        <?php foreach ($authors as $author): ?>
                                            <option value="<?= $author['id'] ?>"
                                                <?= (isset($_POST['author_id']) && $_POST['author_id'] == $author['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($author['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#ef444415;color:var(--danger)"><i class="fe fe-image"></i></div>
                                <h6>Featured Image</h6>
                            </div>
                            <div class="seo-card-body">
                                <div class="img-upload-zone" id="mainImageZone" onclick="document.getElementById('imageInput').click()">
                                    <div id="imgPlaceholder">
                                        <div class="upload-icon"><i class="fe fe-upload-cloud"></i></div>
                                        <p style="font-size:13px;color:var(--text-2);margin-top:6px;">Click or drag to upload</p>
                                        <p>JPG, PNG, WEBP · Max 2MB</p>
                                    </div>
                                    <img id="imagePreview" class="preview-img" alt="Featured Image Preview">
                                </div>
                                <input type="file" name="image" id="imageInput" accept="image/*" class="d-none">
                                <small class="hint" style="margin-top:6px;">✅ Recommended: 1200×628px for best SERP appearance &amp; social shares.</small>
                                <div id="imageAltGroup" class="mt-2" style="display:none">
                                    <label class="form-label">Image Alt Text (SEO)</label>
                                    <input type="text" name="image_alt" id="imageAlt" class="form-control"
                                           placeholder="Describe the image for accessibility + SEO">
                                </div>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="seo-card">
                            <div class="seo-card-header">
                                <div class="icon" style="background:#4f8ef720;color:var(--accent)"><i class="fe fe-hash"></i></div>
                                <h6>Tags</h6>
                            </div>
                            <div class="seo-card-body">
                                <input type="text" name="tags" id="tagsInput" class="form-control"
                                       placeholder="e.g. Orthopedics, Surgery, Health Tips"
                                       value="<?= $p('tags') ?>">
                                <small class="hint">Comma-separated. Tags help with internal linking and discovery.</small>
                                <div id="tagPreview" class="keyword-tags mt-2"></div>
                            </div>
                        </div>

                    </div><!-- /col-xl-4 -->

                </div><!-- /row -->
            </form>

        </div>
    </div>
</div><!-- /main-wrapper -->

<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
/* ═══════════════════════════════════════════════════════════════
   QUILL EDITOR
══════════════════════════════════════════════════════════════════ */
var quill = new Quill('#quillEditor', {
    theme: 'snow',
    placeholder: 'Write your blog content here. Use headings, lists, and keywords naturally...',
    modules: {
        toolbar: [
            [{ header: [1,2,3,4,false] }],
            ['bold','italic','underline','strike'],
            [{ color:[] },{ background:[] }],
            [{ list:'ordered' },{ list:'bullet' }],
            [{ align:[] }],
            ['link','image'],
            ['blockquote','code-block'],
            ['clean']
        ]
    }
});

<?php if (!empty($_POST['content'])): ?>
quill.root.innerHTML = <?= json_encode($_POST['content']) ?>;
<?php endif; ?>

quill.on('text-change', function() {
    var html = quill.root.innerHTML;
    document.getElementById('blogContent').value = html;
    updateReadingTime(quill.getText());
    updateSeoScore();
    updateKdAnalysis();
    document.getElementById('readingTimeDisplay').style.display = 'inline-flex';
});

document.getElementById('blogForm').addEventListener('submit', function(e) {
    var content = quill.root.innerHTML;
    document.getElementById('blogContent').value = content;
    
    // Properly check empty content
    var textContent = quill.getText().trim();
    if (!textContent || textContent === '' || content === '<p><br></p>') {
        e.preventDefault();
        alert('Content is required! Please write something.');
        quill.focus();
        return false;
    }
    
    // Make sure hidden field has value before submit
    document.getElementById('blogContent').value = content;
    return true;
});

/* ═══════════════════════════════════════════════════════════════
   SLUG
══════════════════════════════════════════════════════════════════ */
function toSlug(str) {
    return str.toLowerCase().trim()
        .replace(/[^a-z0-9\s-]/g,'')
        .replace(/\s+/g,'-')
        .replace(/-+/g,'-');
}

document.getElementById('blogTitle').addEventListener('input', function() {
    if (!document.getElementById('blogSlug').dataset.manual) {
        document.getElementById('blogSlug').value = toSlug(this.value);
    }
    updateCharCount('blogTitle','titleCount',null,null,999);
    autoFillSeoFields();
    updateSeoScore();
    updateSerpPreview();
});

document.getElementById('blogSlug').addEventListener('input', function() {
    this.dataset.manual = 'true';
    this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g,'-');
    updateSerpPreview();
});

document.getElementById('generateSlug').addEventListener('click', function() {
    var s = document.getElementById('blogSlug');
    s.value = toSlug(document.getElementById('blogTitle').value);
    delete s.dataset.manual;
    updateSerpPreview();
});

/* ═══════════════════════════════════════════════════════════════
   CHAR COUNTERS + BAR
══════════════════════════════════════════════════════════════════ */
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
});
document.getElementById('metaDesc').addEventListener('input', function() {
    updateCharCount('metaDesc','metaDescCount','metaDescBar',160,120);
    updateSerpPreview();
    updateSeoScore();
});
document.getElementById('blogExcerpt').addEventListener('input', function() {
    updateCharCount('blogExcerpt','excerptCount',null,null,999);
    updateSeoScore();
});
document.getElementById('focusKeyword').addEventListener('input', function() {
    updateSeoScore();
    updateKdAnalysis();
    generateKeywordSuggestions(this.value);
});
document.getElementById('ogTitle').addEventListener('input', function() {
    document.getElementById('ogPreviewTitle').textContent = this.value || 'OG Title will appear here';
});
document.getElementById('ogDesc').addEventListener('input', function() {
    document.getElementById('ogPreviewDesc').textContent = this.value || 'OG description will appear here';
});

/* ═══════════════════════════════════════════════════════════════
   SERP PREVIEW
══════════════════════════════════════════════════════════════════ */
function updateSerpPreview() {
    var title = document.getElementById('metaTitle').value || document.getElementById('blogTitle').value;
    var desc  = document.getElementById('metaDesc').value  || document.getElementById('blogExcerpt').value;
    var slug  = document.getElementById('blogSlug').value  || 'your-post-slug';

    var titleEl = document.getElementById('serpTitle');
    var descEl  = document.getElementById('serpDesc');

    if (title) {
        titleEl.innerHTML = truncate(title, 60);
        titleEl.style.color = '#1a0dab';
    } else {
        titleEl.innerHTML = '<span class="serp-placeholder">Your meta title will appear here...</span>';
    }
    if (desc) {
        descEl.innerHTML = truncate(desc, 160);
        descEl.style.color = '#4d5156';
    } else {
        descEl.innerHTML = '<span class="serp-placeholder">Your meta description will appear here. Make it compelling to improve CTR.</span>';
    }
    document.getElementById('serpSlug').textContent = slug;
}

function truncate(str, max) {
    return str.length > max ? str.substring(0, max) + '…' : str;
}

/* ═══════════════════════════════════════════════════════════════
   READING TIME
══════════════════════════════════════════════════════════════════ */
function updateReadingTime(text) {
    var words = text.trim().split(/\s+/).filter(Boolean).length;
    var mins  = Math.max(1, Math.ceil(words / 220));
    document.getElementById('readingTimeText').textContent = '~' + mins + ' min read (' + words + ' words)';
    document.getElementById('readingTimeInput').value = mins;
}

/* ═══════════════════════════════════════════════════════════════
   AUTO-FILL SEO FIELDS
══════════════════════════════════════════════════════════════════ */
function autoFillSeoFields() {
    var title = document.getElementById('blogTitle').value;
    var mt = document.getElementById('metaTitle');
    if (!mt.dataset.manual && title) {
        mt.value = title.substring(0,60);
        updateCharCount('metaTitle','metaTitleCount','metaTitleBar',60,50);
        updateSerpPreview();
    }
}
document.getElementById('metaTitle').addEventListener('input', function() { this.dataset.manual = '1'; });

/* ═══════════════════════════════════════════════════════════════
   SEO SCORE ENGINE
══════════════════════════════════════════════════════════════════ */
function updateSeoScore() {
    var title     = document.getElementById('blogTitle').value;
    var slug      = document.getElementById('blogSlug').value;
    var metaT     = document.getElementById('metaTitle').value;
    var metaD     = document.getElementById('metaDesc').value;
    var keyword   = document.getElementById('focusKeyword').value.trim().toLowerCase();
    var excerpt   = document.getElementById('blogExcerpt').value;
    var content   = quill.getText();
    var contentLC = content.toLowerCase();

    var checks = [];

    // 1. Title
    if (title.length >= 30 && title.length <= 70)
        checks.push({ok:true,  msg:'Title length is good (' + title.length + ' chars)'});
    else if (title.length > 0)
        checks.push({ok:false, msg:'Title: aim for 30–70 chars (now ' + title.length + ')'});
    else
        checks.push({ok:false, msg:'Title is missing'});

    // 2. Keyword in title
    if (keyword && title.toLowerCase().includes(keyword))
        checks.push({ok:true,  msg:'Focus keyword in title ✓'});
    else if (keyword)
        checks.push({ok:false, msg:'Add focus keyword to title'});
    else
        checks.push({warn:true, msg:'No focus keyword set'});

    // 3. Meta title
    if (metaT.length >= 50 && metaT.length <= 60)
        checks.push({ok:true,  msg:'Meta title length perfect'});
    else if (metaT.length > 0)
        checks.push({warn:true, msg:'Meta title: aim for 50–60 chars'});
    else
        checks.push({ok:false, msg:'Meta title missing'});

    // 4. Meta description
    if (metaD.length >= 120 && metaD.length <= 160)
        checks.push({ok:true,  msg:'Meta description length ✓'});
    else if (metaD.length > 0)
        checks.push({warn:true, msg:'Meta desc: aim for 120–160 chars'});
    else
        checks.push({ok:false, msg:'Meta description missing'});

    // 5. Keyword in meta desc
    if (keyword && metaD.toLowerCase().includes(keyword))
        checks.push({ok:true,  msg:'Keyword in meta description ✓'});
    else if (keyword)
        checks.push({warn:true, msg:'Add keyword to meta description'});

    // 6. Slug
    if (slug.length > 0 && slug.length <= 60)
        checks.push({ok:true,  msg:'Slug is set and concise'});
    else if (slug.length > 60)
        checks.push({warn:true, msg:'Slug too long (keep under 60 chars)'});
    else
        checks.push({ok:false, msg:'Slug is missing'});

    // 7. Keyword in slug
    if (keyword && slug.includes(keyword.replace(/\s+/g,'-')))
        checks.push({ok:true,  msg:'Keyword in slug ✓'});
    else if (keyword)
        checks.push({warn:true, msg:'Include keyword in slug'});

    // 8. Content length
    var wc = content.trim().split(/\s+/).filter(Boolean).length;
    if (wc >= 600)
        checks.push({ok:true,  msg:'Content length (' + wc + ' words) ✓'});
    else if (wc >= 200)
        checks.push({warn:true, msg:'Content: aim for 600+ words (' + wc + ' now)'});
    else
        checks.push({ok:false, msg:'Content too short (' + wc + ' words)'});

    // 9. Excerpt
    if (excerpt.length >= 50)
        checks.push({ok:true,  msg:'Excerpt is set ✓'});
    else
        checks.push({warn:true, msg:'Add a 50+ char excerpt'});

    // 10. Keyword density
    if (keyword && wc > 50) {
        var re   = new RegExp(keyword, 'gi');
        var kc   = (contentLC.match(re) || []).length;
        var dens = (kc / wc * 100).toFixed(1);
        if (dens >= 0.5 && dens <= 2.5)
            checks.push({ok:true,  msg:'Keyword density ' + dens + '% (ideal)'});
        else if (dens > 2.5)
            checks.push({warn:true, msg:'Keyword density ' + dens + '% (too high)'});
        else
            checks.push({warn:true, msg:'Keyword density ' + dens + '% (too low)'});
    }

    // Score calc
    var score = 0;
    var weights = {ok:10, warn:5, bad:0};
    checks.forEach(function(c) {
        if (c.ok)   score += 10;
        else if (c.warn) score += 5;
    });
    score = Math.min(100, score);

    // Render checklist (show top 6)
    var html = '';
    checks.slice(0,6).forEach(function(c) {
        var cls = c.ok ? 'dot-ok' : (c.warn ? 'dot-warn' : 'dot-bad');
        html += '<div class="seo-check-item"><div class="dot '+cls+'"></div><span>'+c.msg+'</span></div>';
    });
    document.getElementById('seoChecklist').innerHTML = html;

    // Score ring
    var circ = 213.6;
    var offset = circ - (score/100 * circ);
    var ring = document.getElementById('scoreCircle');
    ring.style.strokeDashoffset = offset;
    ring.style.stroke = score >= 70 ? '#22c55e' : score >= 40 ? '#f59e0b' : '#ef4444';

    var numEl = document.getElementById('scoreNum');
    numEl.textContent = score;
    numEl.style.color = score >= 70 ? 'var(--success)' : score >= 40 ? 'var(--warning)' : 'var(--danger)';

    document.getElementById('seoScoreBadge').textContent = 'Score: ' + score + '/100';
}

/* ═══════════════════════════════════════════════════════════════
   KEYWORD DENSITY ANALYSER
══════════════════════════════════════════════════════════════════ */
function updateKdAnalysis() {
    var keyword = document.getElementById('focusKeyword').value.trim().toLowerCase();
    var content = quill.getText().toLowerCase();
    var kdEl    = document.getElementById('kdResults');

    if (!keyword || content.trim().length < 10) {
        kdEl.innerHTML = '<span style="color:var(--text-3);font-size:12px;">Enter a focus keyword and write content to see analysis.</span>';
        return;
    }
    var words  = content.trim().split(/\s+/).filter(Boolean);
    var re     = new RegExp(keyword,'gi');
    var kCount = (content.match(re) || []).length;
    var dens   = words.length > 0 ? (kCount / words.length * 100).toFixed(2) : 0;
    var color  = dens >= 0.5 && dens <= 2.5 ? 'var(--success)' : dens > 2.5 ? 'var(--danger)' : 'var(--warning)';

    kdEl.innerHTML =
        '<div style="display:flex;justify-content:space-between;margin-bottom:5px;">' +
        '<span style="font-size:12px;color:var(--text-2)">Keyword: <strong style="color:var(--text-1)">' + keyword + '</strong></span>' +
        '<span style="font-size:12px;font-weight:700;color:' + color + '">' + dens + '%</span></div>' +
        '<div class="kd-bar"><div class="kd-fill" style="width:' + Math.min(dens/3*100,100) + '%;background:' + color + '"></div></div>' +
        '<div style="display:flex;justify-content:space-between;margin-top:5px;font-size:11px;color:var(--text-3)">' +
        '<span>Found ' + kCount + ' times in ' + words.length + ' words</span>' +
        '<span>Ideal: 0.5%–2.5%</span></div>';
}

/* ═══════════════════════════════════════════════════════════════
   KEYWORD SUGGESTIONS
══════════════════════════════════════════════════════════════════ */
function generateKeywordSuggestions(kw) {
    if (!kw || kw.length < 3) { document.getElementById('keywordSuggestions').innerHTML = ''; return; }
    var suggestions = [
        'best ' + kw, kw + ' tips', kw + ' guide',
        kw + ' benefits', 'how to ' + kw, kw + ' 2025'
    ];
    var html = suggestions.map(function(s) {
        return '<span class="keyword-tag" onclick="document.getElementById(\'focusKeyword\').value=\'' +
               s.replace(/'/g,"\\'") + '\';updateSeoScore();updateKdAnalysis();">' + s + '</span>';
    }).join('');
    document.getElementById('keywordSuggestions').innerHTML = html;
}

/* ═══════════════════════════════════════════════════════════════
   ROBOTS BUTTONS
══════════════════════════════════════════════════════════════════ */
function setRobots(val, btn) {
    document.querySelectorAll('#robotsIndexGroup .robots-btn').forEach(function(b) {
        b.className = 'robots-btn';
    });
    btn.className = 'robots-btn ' + (val === 'index' ? 'active-index' : 'active-noindex');
    document.getElementById('robotsIndex').value = val;
    updateRobotsHint();
}
function setFollow(val, btn) {
    document.querySelectorAll('#robotsFollowGroup .robots-btn').forEach(function(b) {
        b.className = 'robots-btn';
    });
    btn.className = 'robots-btn ' + (val === 'follow' ? 'active-follow' : 'active-nofollow');
    document.getElementById('robotsFollow').value = val;
    updateRobotsHint();
}
function updateRobotsHint() {
    var idx = document.getElementById('robotsIndex').value;
    var flw = document.getElementById('robotsFollow').value;
    var hint = document.getElementById('robotsHint');
    var msg  = idx === 'index' && flw === 'follow'
        ? '✅ This page will be indexed and links followed.'
        : idx === 'noindex'
        ? '🚫 This page will NOT be indexed by search engines.'
        : '⚠️ Links on this page will NOT be followed.';
    hint.textContent = msg;
    hint.style.color = idx === 'index' ? 'var(--success)' : 'var(--danger)';
}

/* ═══════════════════════════════════════════════════════════════
   SCHEMA TYPE
══════════════════════════════════════════════════════════════════ */
function setSchema(val, btn) {
    document.querySelectorAll('.schema-opt').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('schemaType').value = val;
}

/* ═══════════════════════════════════════════════════════════════
   IMAGE UPLOAD
══════════════════════════════════════════════════════════════════ */
document.getElementById('imageInput').addEventListener('change', function() {
    if (this.files[0]) {
        var r = new FileReader();
        r.onload = function(e) {
            var preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
            document.getElementById('imgPlaceholder').style.display = 'none';
            document.getElementById('imageAltGroup').style.display = 'block';
            // auto-fill og image preview
            document.getElementById('ogPreviewImgBox').innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;">';
        };
        r.readAsDataURL(this.files[0]);
    }
});

document.getElementById('ogImageInput').addEventListener('change', function() {
    if (this.files[0]) {
        var r = new FileReader();
        r.onload = function(e) {
            document.getElementById('ogImagePreview').src = e.target.result;
            document.getElementById('ogImagePreview').style.display = 'block';
            document.getElementById('ogPreviewImgBox').innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;">';
        };
        r.readAsDataURL(this.files[0]);
    }
});

/* ═══════════════════════════════════════════════════════════════
   TABS
══════════════════════════════════════════════════════════════════ */
document.querySelectorAll('.seo-tab').forEach(function(tab) {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.seo-tab').forEach(function(t) { t.classList.remove('active'); });
        document.querySelectorAll('.seo-tab-pane').forEach(function(p) { p.classList.remove('active'); });
        this.classList.add('active');
        document.getElementById(this.dataset.tab).classList.add('active');
    });
});

/* ═══════════════════════════════════════════════════════════════
   TAG PREVIEW
══════════════════════════════════════════════════════════════════ */
document.getElementById('tagsInput').addEventListener('input', function() {
    var tags = this.value.split(',').map(function(t) { return t.trim(); }).filter(Boolean);
    document.getElementById('tagPreview').innerHTML = tags.map(function(t) {
        return '<span class="keyword-tag">' + t + '</span>';
    }).join('');
});

/* ═══════════════════════════════════════════════════════════════
   PUBLISH BADGE
══════════════════════════════════════════════════════════════════ */
function updatePublishBadge(cb) {
    var badge = document.getElementById('publishStatusBadge');
    if (cb.checked) {
        badge.textContent = 'Live';
        badge.style.background = '#22c55e15';
        badge.style.color = 'var(--success)';
        badge.style.borderColor = '#22c55e30';
    } else {
        badge.textContent = 'Draft';
        badge.style.background = '#f59e0b15';
        badge.style.color = 'var(--warning)';
        badge.style.borderColor = '#f59e0b30';
    }
}

/* ═══════════════════════════════════════════════════════════════
   INIT
══════════════════════════════════════════════════════════════════ */
updateSeoScore();
updateSerpPreview();
updateCharCount('blogTitle','titleCount',null,null,999);
updateCharCount('metaTitle','metaTitleCount','metaTitleBar',60,50);
updateCharCount('metaDesc','metaDescCount','metaDescBar',160,120);
updateCharCount('blogExcerpt','excerptCount',null,null,999);
</script>
</body>
</html>