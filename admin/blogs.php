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

// ── Stats ────────────────────────────────────────────────────────
$statsRes = $conn->query("SELECT 
    COUNT(*) as total,
    SUM(is_published) as published,
    SUM(!is_published) as drafts,
    SUM(views) as total_views,
    SUM(comments) as total_comments,
    AVG(views) as avg_views
    FROM blogs");
$stats = $statsRes ? $statsRes->fetch_assoc() : [];

// ── SEO Score Calculator (PHP) ───────────────────────────────────
function calcSeoScore($blog) {
    $score = 0;
    $issues = [];
    $good = [];

    // Meta title
    $mt = $blog['meta_title'] ?? '';
    if (strlen($mt) >= 50 && strlen($mt) <= 60) { $score += 15; $good[] = 'Meta title perfect length'; }
    elseif (strlen($mt) > 0) { $score += 7; $issues[] = 'Meta title not ideal (50-60 chars)'; }
    else { $issues[] = 'Meta title missing'; }

    // Meta description
    $md = $blog['meta_description'] ?? '';
    if (strlen($md) >= 120 && strlen($md) <= 160) { $score += 15; $good[] = 'Meta description perfect'; }
    elseif (strlen($md) > 0) { $score += 7; $issues[] = 'Meta desc not ideal (120-160 chars)'; }
    else { $issues[] = 'Meta description missing'; }

    // Focus keyword
    $kw = strtolower($blog['focus_keyword'] ?? '');
    if (!empty($kw)) {
        $score += 5; $good[] = 'Focus keyword set';
        // Keyword in title
        if (strpos(strtolower($blog['title']), $kw) !== false) { $score += 10; $good[] = 'Keyword in title'; }
        else { $issues[] = 'Keyword missing from title'; }
        // Keyword in meta desc
        if (strpos(strtolower($md), $kw) !== false) { $score += 10; $good[] = 'Keyword in meta desc'; }
        else { $issues[] = 'Keyword missing from meta desc'; }
        // Keyword in slug
        $kwSlug = str_replace(' ', '-', $kw);
        if (strpos($blog['slug'] ?? '', $kwSlug) !== false) { $score += 5; $good[] = 'Keyword in slug'; }
        else { $issues[] = 'Keyword not in slug'; }
    } else {
        $issues[] = 'No focus keyword set';
    }

    // Content length (estimate from excerpt)
    $content = strip_tags($blog['content'] ?? '');
    $wc = str_word_count($content);
    if ($wc >= 600) { $score += 15; $good[] = "Good content length ($wc words)"; }
    elseif ($wc >= 200) { $score += 8; $issues[] = "Content short ($wc words, aim 600+)"; }
    else { $issues[] = "Content too short ($wc words)"; }

    // Image
    if (!empty($blog['image'])) { $score += 5; $good[] = 'Featured image set'; }
    else { $issues[] = 'No featured image'; }

    // OG Tags
    if (!empty($blog['og_title'])) { $score += 5; $good[] = 'OG title set'; }
    else { $issues[] = 'OG title missing'; }

    // Schema
    if (!empty($blog['schema_type'])) { $score += 5; $good[] = 'Schema markup set'; }
    else { $issues[] = 'No schema type'; }

    // Reading time
    if (!empty($blog['reading_time'])) { $score += 5; $good[] = 'Reading time set'; }

    $score = min(100, $score);
    return ['score' => $score, 'issues' => $issues, 'good' => $good];
}

function seoGrade($score) {
    if ($score >= 80) return ['A', '#22c55e'];
    if ($score >= 65) return ['B', '#84cc16'];
    if ($score >= 50) return ['C', '#f59e0b'];
    if ($score >= 35) return ['D', '#f97316'];
    return ['F', '#ef4444'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs SEO Dashboard — Admin Panel</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">

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
            --orange:     #f97316;
            --text-1:     #e8eaf0;
            --text-2:     #8891a8;
            --text-3:     #555d74;
            --radius:     10px;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-base); color: var(--text-1); font-size: 14px; }

        /* ── Stats Cards ── */
        .stat-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; margin-bottom: 24px; }
        @media(max-width:1200px){ .stat-grid { grid-template-columns: repeat(3,1fr); } }
        @media(max-width:768px) { .stat-grid { grid-template-columns: repeat(2,1fr); } }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 18px;
            position: relative;
            overflow: hidden;
            transition: border-color .2s, transform .2s;
        }
        .stat-card:hover { border-color: var(--border-2); transform: translateY(-2px); }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
        }
        .stat-card.accent::before  { background: var(--accent); }
        .stat-card.success::before { background: var(--success); }
        .stat-card.warning::before { background: var(--warning); }
        .stat-card.danger::before  { background: var(--danger); }
        .stat-card.purple::before  { background: var(--accent2); }

        .stat-label { font-size: 11px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: .6px; margin-bottom: 6px; }
        .stat-value { font-size: 28px; font-weight: 800; font-family: 'JetBrains Mono', monospace; line-height: 1; }
        .stat-sub   { font-size: 11px; color: var(--text-3); margin-top: 4px; }
        .stat-icon  { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); font-size: 28px; opacity: .08; }

        /* ── Main Card ── */
        .main-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }
        .main-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--bg-card2);
            display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
        }
        .main-card-header h5 { font-size: 14px; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 8px; }

        /* ── Search ── */
        .search-box {
            display: flex; gap: 8px; align-items: center;
        }
        .search-input {
            background: var(--bg-base) !important;
            border: 1px solid var(--border) !important;
            border-radius: 8px !important;
            color: var(--text-1) !important;
            font-size: 13px !important;
            padding: 7px 13px !important;
            min-width: 220px;
        }
        .search-input:focus { border-color: var(--accent) !important; outline: none; box-shadow: 0 0 0 3px var(--accent-glow) !important; }
        .search-input::placeholder { color: var(--text-3) !important; }
        .btn-search {
            background: var(--accent); border: none; color: #fff;
            padding: 7px 14px; border-radius: 8px; font-size: 12px; cursor: pointer;
            transition: opacity .2s;
        }
        .btn-search:hover { opacity: .85; }
        .btn-clear {
            background: transparent; border: 1px solid var(--border-2); color: var(--text-2);
            padding: 7px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center;
            transition: border-color .2s, color .2s;
        }
        .btn-clear:hover { border-color: var(--danger); color: var(--danger); }

        /* ── Table ── */
        .seo-table { width: 100%; border-collapse: collapse; }
        .seo-table thead th {
            background: var(--bg-card2);
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--text-3);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .seo-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }
        .seo-table tbody tr:hover { background: var(--bg-card2); }
        .seo-table tbody tr:last-child { border-bottom: none; }
        .seo-table td { padding: 12px 14px; vertical-align: middle; }

        /* ── Blog thumb ── */
        .blog-thumb {
            width: 46px; height: 46px; object-fit: cover;
            border-radius: 8px; border: 1px solid var(--border);
        }
        .thumb-placeholder {
            width: 46px; height: 46px; border-radius: 8px;
            background: var(--bg-card2); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-3); font-size: 18px;
        }

        /* ── Blog title cell ── */
        .blog-title-main {
            font-weight: 600; font-size: 13.5px; color: var(--text-1);
            display: block; margin-bottom: 2px;
            max-width: 220px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .blog-slug { font-size: 11px; color: var(--text-3); font-family: 'JetBrains Mono', monospace; }

        /* ── Category badge ── */
        .cat-badge {
            display: inline-flex; align-items: center; gap: 4px;
            background: var(--accent-glow); color: var(--accent);
            border: 1px solid #4f8ef730; border-radius: 20px;
            padding: 3px 9px; font-size: 11px; font-weight: 600;
        }

        /* ── Status badge ── */
        .badge-pub {
            display: inline-flex; align-items: center; gap: 5px;
            background: #22c55e15; color: var(--success);
            border: 1px solid #22c55e30; border-radius: 20px;
            padding: 4px 10px; font-size: 11px; font-weight: 600;
            text-decoration: none; transition: all .15s;
        }
        .badge-draft {
            display: inline-flex; align-items: center; gap: 5px;
            background: #f59e0b15; color: var(--warning);
            border: 1px solid #f59e0b30; border-radius: 20px;
            padding: 4px 10px; font-size: 11px; font-weight: 600;
            text-decoration: none; transition: all .15s;
        }
        .badge-pub:hover, .badge-draft:hover { opacity: .8; }

        /* ── SEO Score Cell ── */
        .seo-score-cell { display: flex; align-items: center; gap: 10px; }
        .seo-ring { position: relative; flex-shrink: 0; }
        .seo-ring svg { transform: rotate(-90deg); }
        .seo-ring-num {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: 10px; font-weight: 800;
            font-family: 'JetBrains Mono', monospace;
        }
        .seo-grade {
            font-size: 18px; font-weight: 800;
            font-family: 'JetBrains Mono', monospace;
            line-height: 1;
        }
        .seo-score-label { font-size: 10px; color: var(--text-3); }

        /* ── SEO Issues Tooltip ── */
        .seo-issues-btn {
            background: transparent; border: 1px solid var(--border-2);
            color: var(--text-3); border-radius: 6px;
            padding: 3px 8px; font-size: 11px; cursor: pointer;
            transition: all .15s; white-space: nowrap;
        }
        .seo-issues-btn:hover { border-color: var(--warning); color: var(--warning); }
        .seo-issues-btn.no-issues { border-color: #22c55e30; color: var(--success); }

        /* ── Prediction bar ── */
        .predict-bar { width: 80px; height: 6px; background: var(--border); border-radius: 4px; overflow: hidden; }
        .predict-fill { height: 100%; border-radius: 4px; transition: width .4s; }

        /* ── Actions ── */
        .action-btns { display: flex; gap: 6px; justify-content: flex-end; }
        .btn-act {
            width: 32px; height: 32px; border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 13px; border: 1px solid; cursor: pointer;
            text-decoration: none; transition: all .15s;
        }
        .btn-act-edit   { border-color: var(--accent);   color: var(--accent);  background: var(--accent-glow); }
        .btn-act-edit:hover { background: var(--accent); color: #fff; }
        .btn-act-del    { border-color: #ef444430; color: var(--danger); background: #ef444410; }
        .btn-act-del:hover { background: var(--danger); color: #fff; border-color: var(--danger); }

        /* ── SEO Modal ── */
        .seo-modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.7); z-index: 9999;
            align-items: center; justify-content: center;
        }
        .seo-modal-overlay.show { display: flex; }
        .seo-modal {
            background: var(--bg-card);
            border: 1px solid var(--border-2);
            border-radius: 14px;
            width: 520px; max-width: 95vw;
            max-height: 85vh;
            overflow-y: auto;
            padding: 0;
            box-shadow: 0 20px 60px rgba(0,0,0,.6);
            animation: slideUp .2s ease;
        }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-head {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--bg-card2);
            border-radius: 14px 14px 0 0;
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-head h5 { font-size: 14px; font-weight: 700; margin: 0; }
        .modal-close {
            background: transparent; border: none; color: var(--text-2);
            font-size: 18px; cursor: pointer; padding: 0; line-height: 1;
            transition: color .15s;
        }
        .modal-close:hover { color: var(--danger); }
        .modal-body { padding: 20px; }

        /* ── Score ring in modal ── */
        .modal-score-area {
            display: flex; align-items: center; gap: 20px;
            padding: 16px; background: var(--bg-card2);
            border-radius: 10px; margin-bottom: 18px;
            border: 1px solid var(--border);
        }
        .modal-ring { position: relative; }
        .modal-ring svg { transform: rotate(-90deg); }
        .modal-ring-text {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .modal-ring-num { font-size: 22px; font-weight: 800; font-family: 'JetBrains Mono', monospace; display: block; }
        .modal-ring-label { font-size: 9px; color: var(--text-3); text-transform: uppercase; }

        .score-meta { flex: 1; }
        .score-grade-big { font-size: 42px; font-weight: 900; font-family: 'JetBrains Mono', monospace; line-height: 1; }
        .score-verdict { font-size: 13px; color: var(--text-2); margin-top: 4px; }

        /* ── Checklist ── */
        .check-section { margin-bottom: 14px; }
        .check-section-title {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .6px; color: var(--text-3); margin-bottom: 8px;
        }
        .check-item {
            display: flex; align-items: flex-start; gap: 8px;
            padding: 7px 10px; border-radius: 7px; margin-bottom: 4px;
            font-size: 12.5px;
        }
        .check-item.good  { background: #22c55e0d; color: #86efac; }
        .check-item.issue { background: #ef44440d; color: #fca5a5; }
        .check-item.warn  { background: #f59e0b0d; color: #fcd34d; }
        .check-dot { font-size: 14px; flex-shrink: 0; margin-top: -1px; }

        /* ── Prediction ── */
        .predict-section {
            background: var(--bg-card2); border: 1px solid var(--border);
            border-radius: 10px; padding: 14px; margin-bottom: 14px;
        }
        .predict-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: var(--text-3); margin-bottom: 10px; }
        .predict-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-size: 12px; }
        .predict-label { color: var(--text-2); }
        .predict-val { font-weight: 700; font-family: 'JetBrains Mono', monospace; }
        .predict-bar-full { width: 100%; height: 5px; background: var(--border); border-radius: 4px; overflow: hidden; margin-top: 3px; }
        .predict-bar-inner { height: 100%; border-radius: 4px; }

        /* ── Add Blog Button ── */
        .btn-add-blog {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none; color: #fff; font-weight: 600; font-size: 13px;
            padding: 9px 18px; border-radius: 8px; cursor: pointer;
            text-decoration: none; transition: opacity .2s, transform .15s;
        }
        .btn-add-blog:hover { opacity: .88; transform: translateY(-1px); color: #fff; }

        /* ── Pagination ── */
        .pagination-area {
            display: flex; justify-content: space-between; align-items: center;
            padding: 14px 20px; border-top: 1px solid var(--border);
            background: var(--bg-card2);
        }
        .pag-info { font-size: 12px; color: var(--text-3); }
        .pag-btns { display: flex; gap: 4px; }
        .pag-btn {
            width: 32px; height: 32px; border-radius: 7px; font-size: 12px;
            font-weight: 600; border: 1px solid var(--border-2); color: var(--text-2);
            background: transparent; display: flex; align-items: center; justify-content: center;
            text-decoration: none; transition: all .15s;
        }
        .pag-btn:hover { border-color: var(--accent); color: var(--accent); }
        .pag-btn.active { background: var(--accent); color: #fff; border-color: var(--accent); }
        .pag-btn.disabled { opacity: .35; pointer-events: none; }

        /* ── Empty state ── */
        .empty-state { text-align: center; padding: 60px 20px; color: var(--text-3); }
        .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; }
        .empty-state p { font-size: 14px; }

        /* ── Alert ── */
        .alert-custom {
            border-radius: 8px; padding: 12px 16px; margin-bottom: 18px;
            font-size: 13px; display: flex; align-items: center; gap: 10px;
        }
        .alert-success { background: #22c55e15; border: 1px solid #22c55e30; color: #86efac; }
        .alert-danger  { background: #ef444415; border: 1px solid #ef444430; color: #fca5a5; }

        /* ── Views sparkline ── */
        .views-cell { display: flex; align-items: center; gap: 6px; }
        .views-num { font-family: 'JetBrains Mono', monospace; font-size: 13px; font-weight: 600; }
        .views-bar-wrap { width: 40px; }

        /* Page header */
        .page-title-area {
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 0 16px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 24px;
        }
        .page-title-area h3 { font-size: 20px; font-weight: 800; }
        .breadcrumb-area { font-size: 12px; color: var(--text-3); margin-top: 3px; }
        .breadcrumb-area a { color: var(--text-3); text-decoration: none; }
        .breadcrumb-area a:hover { color: var(--accent); }
        .page-wrapper { margin-left: 235px; }
        .content { padding: 20px 24px 40px; }
        @media(max-width:991px){ .page-wrapper { margin-left: 0; } }

        .seo-bar-mini { width: 50px; height: 4px; background: var(--border); border-radius: 4px; overflow: hidden; margin-top: 3px; }
        .seo-bar-mini-fill { height: 100%; border-radius: 4px; }
    </style>
</head>
<body>
<div class="main-wrapper">

    <!-- HEADER -->
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
        <ul class="nav user-menu"></ul>
    </div>

    <!-- SIDEBAR -->
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

    <!-- PAGE WRAPPER -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-title-area">
                <div>
                    <h3>📊 Blog SEO Dashboard</h3>
                    <div class="breadcrumb-area">
                        <a href="index.php">Dashboard</a> /
                        <span>Blogs & SEO Analytics</span>
                    </div>
                </div>
                <a href="blog-add.php" class="btn-add-blog">
                    <i class="fa fa-plus"></i> Add New Blog
                </a>
            </div>

            <!-- ALERTS -->
            <?php if (isset($_GET['msg'])):
                $msgMap = [
                    'deleted' => ['danger',  '🗑️ Blog deleted successfully.'],
                    'added'   => ['success', '✅ Blog added successfully.'],
                    'updated' => ['success', '✅ Blog updated successfully.'],
                ];
                [$msgType, $msgText] = $msgMap[$_GET['msg']] ?? ['success', 'Action completed.'];
            ?>
                <div class="alert-custom alert-<?= $msgType ?>">
                    <span><?= $msgText ?></span>
                </div>
            <?php endif; ?>

            <!-- STATS GRID -->
            <div class="stat-grid">
                <div class="stat-card accent">
                    <div class="stat-label">Total Blogs</div>
                    <div class="stat-value" style="color:var(--accent)"><?= (int)($stats['total'] ?? 0) ?></div>
                    <div class="stat-sub">All time posts</div>
                    <div class="stat-icon"><i class="fe fe-file-text"></i></div>
                </div>
                <div class="stat-card success">
                    <div class="stat-label">Published</div>
                    <div class="stat-value" style="color:var(--success)"><?= (int)($stats['published'] ?? 0) ?></div>
                    <div class="stat-sub">Live on website</div>
                    <div class="stat-icon"><i class="fe fe-globe"></i></div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-label">Drafts</div>
                    <div class="stat-value" style="color:var(--warning)"><?= (int)($stats['drafts'] ?? 0) ?></div>
                    <div class="stat-sub">Pending publish</div>
                    <div class="stat-icon"><i class="fe fe-edit"></i></div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-label">Total Views</div>
                    <div class="stat-value" style="color:var(--accent2)"><?= number_format((int)($stats['total_views'] ?? 0)) ?></div>
                    <div class="stat-sub">Avg: <?= number_format((float)($stats['avg_views'] ?? 0), 0) ?>/post</div>
                    <div class="stat-icon"><i class="fe fe-eye"></i></div>
                </div>
                <div class="stat-card danger">
                    <div class="stat-label">Comments</div>
                    <div class="stat-value" style="color:var(--danger)"><?= number_format((int)($stats['total_comments'] ?? 0)) ?></div>
                    <div class="stat-sub">Total engagement</div>
                    <div class="stat-icon"><i class="fe fe-message-circle"></i></div>
                </div>
            </div>

            <!-- MAIN TABLE CARD -->
            <div class="main-card">
                <div class="main-card-header">
                    <h5>
                        <i class="fa fa-list-alt" style="color:var(--accent)"></i>
                        All Blogs
                        <span style="background:var(--accent-glow);color:var(--accent);border:1px solid #4f8ef730;border-radius:20px;padding:2px 8px;font-size:11px;font-family:'JetBrains Mono',monospace;">
                            <?= $totalRecords ?> total
                        </span>
                    </h5>
                    <form method="GET" class="search-box">
                        <input type="text" name="search" class="search-input form-control"
                               placeholder="🔍 Search title, author, category..."
                               value="<?= htmlspecialchars($search) ?>">
                        <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                        <?php if ($search): ?>
                            <a href="blogs.php" class="btn-clear">Clear</a>
                        <?php endif; ?>
                    </form>
                </div>

                <div style="overflow-x:auto;">
                    <table class="seo-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Blog</th>
                                <th>Category</th>
                                <th>SEO Score</th>
                                <th>Issues</th>
                                <th>CTR Predict</th>
                                <th>Views</th>
                                <th>Status</th>
                                <th>Published</th>
                                <th style="text-align:right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($blogs)): ?>
                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <i class="fa fa-inbox"></i>
                                            <p>No blogs found<?= $search ? ' for "' . htmlspecialchars($search) . '"' : '' ?>.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($blogs as $i => $blog):
                                    $seo = calcSeoScore($blog);
                                    $score = $seo['score'];
                                    [$grade, $gradeColor] = seoGrade($score);
                                    $circ = 113.1; // 2*pi*18
                                    $offset = $circ - ($score / 100 * $circ);
                                    $issueCount = count($seo['issues']);
                                    $goodCount  = count($seo['good']);

                                    // CTR prediction based on score + meta quality
                                    $mtLen = strlen($blog['meta_title'] ?? '');
                                    $mdLen = strlen($blog['meta_description'] ?? '');
                                    $ctrBase = ($score / 100) * 8; // max ~8%
                                    if ($mtLen >= 50 && $mtLen <= 60) $ctrBase += 1;
                                    if ($mdLen >= 120 && $mdLen <= 160) $ctrBase += 0.5;
                                    $ctrBase = min(9.9, $ctrBase);
                                    $ctrColor = $ctrBase >= 5 ? 'var(--success)' : ($ctrBase >= 3 ? 'var(--warning)' : 'var(--danger)');

                                    // Rank prediction
                                    $rankPotential = $score >= 80 ? 'Top 10' : ($score >= 60 ? 'Top 30' : ($score >= 40 ? 'Top 50' : 'Low'));
                                ?>
                                <tr>
                                    <td style="color:var(--text-3);font-size:12px;font-family:'JetBrains Mono',monospace;">
                                        <?= $offset + $i + 1 ?>
                                    </td>

                                    <!-- Blog Image + Title -->
                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <?php if (!empty($blog['image'])): ?>
                                                <img src="../<?= htmlspecialchars($blog['image']) ?>"
                                                     class="blog-thumb"
                                                     onerror="this.src='assets/img/placeholder.jpg'" alt="">
                                            <?php else: ?>
                                                <div class="thumb-placeholder"><i class="fe fe-image"></i></div>
                                            <?php endif; ?>
                                            <div>
                                                <span class="blog-title-main" title="<?= htmlspecialchars($blog['title']) ?>">
                                                    <?= htmlspecialchars(mb_strimwidth($blog['title'], 0, 45, '…')) ?>
                                                </span>
                                                <span class="blog-slug"><?= htmlspecialchars(mb_strimwidth($blog['slug'] ?? '', 0, 30, '…')) ?></span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Category -->
                                    <td>
                                        <?php if (!empty($blog['category_name'])): ?>
                                            <span class="cat-badge"><i class="fa fa-tag" style="font-size:9px;"></i><?= htmlspecialchars($blog['category_name']) ?></span>
                                        <?php else: ?>
                                            <span style="color:var(--text-3);font-size:12px;">—</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- SEO Score Ring -->
                                    <td>
                                        <div class="seo-score-cell">
                                            <div class="seo-ring">
                                                <svg width="42" height="42" viewBox="0 0 42 42">
                                                    <circle cx="21" cy="21" r="18" fill="none" stroke="var(--border)" stroke-width="4"/>
                                                    <circle cx="21" cy="21" r="18" fill="none" stroke="<?= $gradeColor ?>"
                                                            stroke-width="4" stroke-linecap="round"
                                                            stroke-dasharray="<?= $circ ?>"
                                                            stroke-dashoffset="<?= $offset ?>"/>
                                                </svg>
                                                <div class="seo-ring-num" style="color:<?= $gradeColor ?>"><?= $score ?></div>
                                            </div>
                                            <div>
                                                <div class="seo-grade" style="color:<?= $gradeColor ?>"><?= $grade ?></div>
                                                <div class="seo-score-label"><?= $score ?>/100</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Issues -->
                                    <td>
                                        <button class="seo-issues-btn <?= $issueCount === 0 ? 'no-issues' : '' ?>"
                                                onclick="openSeoModal(<?= $blog['id'] ?>)"
                                                data-id="<?= $blog['id'] ?>">
                                            <?php if ($issueCount === 0): ?>
                                                ✅ Perfect
                                            <?php else: ?>
                                                ⚠️ <?= $issueCount ?> issue<?= $issueCount > 1 ? 's' : '' ?>
                                            <?php endif; ?>
                                        </button>
                                    </td>

                                    <!-- CTR Prediction -->
                                    <td>
                                        <div style="font-size:13px;font-weight:700;font-family:'JetBrains Mono',monospace;color:<?= $ctrColor ?>">
                                            ~<?= number_format($ctrBase, 1) ?>%
                                        </div>
                                        <div class="seo-bar-mini">
                                            <div class="seo-bar-mini-fill" style="width:<?= min(100,$ctrBase/10*100) ?>%;background:<?= $ctrColor ?>"></div>
                                        </div>
                                        <div style="font-size:10px;color:var(--text-3);margin-top:2px;"><?= $rankPotential ?></div>
                                    </td>

                                    <!-- Views -->
                                    <td>
                                        <div class="views-cell">
                                            <span class="views-num" style="color:var(--accent2)"><?= number_format((int)$blog['views']) ?></span>
                                        </div>
                                        <div style="font-size:10px;color:var(--text-3);"><?= (int)$blog['comments'] ?> comments</div>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <a href="blogs.php?toggle=<?= $blog['id'] ?>" title="Click to toggle">
                                            <?php if ($blog['is_published']): ?>
                                                <span class="badge-pub"><span style="width:6px;height:6px;border-radius:50%;background:var(--success);display:inline-block;"></span> Live</span>
                                            <?php else: ?>
                                                <span class="badge-draft"><span style="width:6px;height:6px;border-radius:50%;background:var(--warning);display:inline-block;"></span> Draft</span>
                                            <?php endif; ?>
                                        </a>
                                    </td>

                                    <!-- Published At -->
                                    <td style="font-size:12px;color:var(--text-2);white-space:nowrap;">
                                        <?= !empty($blog['published_at'])
                                            ? date('d M Y', strtotime($blog['published_at']))
                                            : '<span style="color:var(--text-3)">Not set</span>' ?>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <div class="action-btns">
                                            <a href="blog-edit.php?id=<?= $blog['id'] ?>" class="btn-act btn-act-edit" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="blogs.php?delete=<?= $blog['id'] ?>" class="btn-act btn-act-del" title="Delete"
                                               onclick="return confirm('Delete this blog permanently?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Hidden SEO data for modal -->
                                <script>
                                window._seoData = window._seoData || {};
                                window._seoData[<?= $blog['id'] ?>] = {
                                    title: <?= json_encode($blog['title']) ?>,
                                    score: <?= $score ?>,
                                    grade: <?= json_encode($grade) ?>,
                                    gradeColor: <?= json_encode($gradeColor) ?>,
                                    issues: <?= json_encode($seo['issues']) ?>,
                                    good: <?= json_encode($seo['good']) ?>,
                                    ctr: <?= number_format($ctrBase, 1) ?>,
                                    rank: <?= json_encode($rankPotential) ?>,
                                    metaTitle: <?= json_encode($blog['meta_title'] ?? '') ?>,
                                    metaDesc: <?= json_encode($blog['meta_description'] ?? '') ?>,
                                    keyword: <?= json_encode($blog['focus_keyword'] ?? '') ?>,
                                    slug: <?= json_encode($blog['slug'] ?? '') ?>,
                                    schema: <?= json_encode($blog['schema_type'] ?? '') ?>,
                                    robots: <?= json_encode($blog['robots_meta'] ?? '') ?>,
                                    readingTime: <?= (int)($blog['reading_time'] ?? 0) ?>,
                                    views: <?= (int)$blog['views'] ?>,
                                    editUrl: 'blog-edit.php?id=<?= $blog['id'] ?>'
                                };
                                </script>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="pagination-area">
                    <div class="pag-info">
                        Showing <?= $offset + 1 ?>–<?= min($offset + $limit, $totalRecords) ?> of <?= $totalRecords ?> blogs
                    </div>
                    <div class="pag-btns">
                        <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>"
                           class="pag-btn <?= $page <= 1 ? 'disabled' : '' ?>">
                            <i class="fa fa-chevron-left"></i>
                        </a>
                        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <a href="?page=<?= $p ?>&search=<?= urlencode($search) ?>"
                               class="pag-btn <?= $p === $page ? 'active' : '' ?>"><?= $p ?></a>
                        <?php endfor; ?>
                        <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>"
                           class="pag-btn <?= $page >= $totalPages ? 'disabled' : '' ?>">
                            <i class="fa fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<!-- ════════ SEO MODAL ════════ -->
<div class="seo-modal-overlay" id="seoModalOverlay" onclick="if(event.target===this)closeSeoModal()">
    <div class="seo-modal">
        <div class="modal-head">
            <h5 id="modalTitle">SEO Analysis</h5>
            <button class="modal-close" onclick="closeSeoModal()">✕</button>
        </div>
        <div class="modal-body" id="modalBody">
            <!-- JS renders here -->
        </div>
    </div>
</div>

<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/js/script.js"></script>

<script>
function openSeoModal(id) {
    var d = window._seoData[id];
    if (!d) return;

    document.getElementById('modalTitle').textContent = '🔍 SEO Report — ' + d.title.substring(0, 40) + (d.title.length > 40 ? '…' : '');

    var circ = 226.2;
    var off  = circ - (d.score / 100 * circ);
    var verdicts = {
        'A': '🏆 Excellent! This post is highly SEO optimized.',
        'B': '✅ Good SEO. A few tweaks will push it higher.',
        'C': '⚠️ Average. Fix the issues below for better ranking.',
        'D': '🔴 Needs work. Multiple SEO problems detected.',
        'F': '❌ Poor SEO. This post needs significant improvements.'
    };

    var goodHtml = d.good.map(function(g) {
        return '<div class="check-item good"><span class="check-dot">✅</span><span>' + g + '</span></div>';
    }).join('');
    var issueHtml = d.issues.map(function(iss) {
        return '<div class="check-item issue"><span class="check-dot">❌</span><span>' + iss + '</span></div>';
    }).join('');

    // Predictions
    var rankColors = {'Top 10':'#22c55e','Top 30':'#84cc16','Top 50':'#f59e0b','Low':'#ef4444'};
    var rankColor  = rankColors[d.rank] || '#888';
    var rankPct    = {'Top 10':90,'Top 30':65,'Top 50':40,'Low':15}[d.rank] || 15;
    var ctrPct     = Math.min(100, parseFloat(d.ctr) / 10 * 100);
    var ctrColor   = parseFloat(d.ctr) >= 5 ? '#22c55e' : parseFloat(d.ctr) >= 3 ? '#f59e0b' : '#ef4444';

    // Meta preview
    var metaHtml = '';
    if (d.metaTitle || d.metaDesc) {
        metaHtml = '<div style="background:#fff;border:1px solid #dfe1e5;border-radius:8px;padding:12px 14px;margin-bottom:14px;">' +
            '<div style="font-size:11px;color:#202124;font-family:Arial,sans-serif;margin-bottom:2px;">rkhospitals.com › blog › ' + (d.slug || '') + '</div>' +
            '<div style="font-size:16px;color:#1a0dab;font-family:Arial,sans-serif;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + (d.metaTitle || '<em style="color:#888">No meta title</em>') + '</div>' +
            '<div style="font-size:12px;color:#4d5156;font-family:Arial,sans-serif;margin-top:2px;">' + (d.metaDesc || '<em style="color:#888">No meta description</em>') + '</div>' +
            '</div>';
    }

    // Improvement tips
    var tips = [];
    if (!d.keyword) tips.push('🔑 Set a focus keyword to unlock keyword analysis');
    if (!d.metaTitle) tips.push('🏷️ Add a meta title (50–60 chars) for Google visibility');
    if (!d.metaDesc) tips.push('📋 Write a meta description (120–160 chars) to improve CTR');
    if (d.schema === '') tips.push('🔖 Add Schema markup — use MedicalWebPage for healthcare blogs');
    if (d.readingTime === 0) tips.push('⏱️ Content seems short — aim for 600+ words');

    var tipsHtml = tips.length > 0 ? '<div class="check-section"><div class="check-section-title">💡 Quick Wins</div>' +
        tips.map(function(t){ return '<div class="check-item warn"><span class="check-dot">💡</span><span>' + t + '</span></div>'; }).join('') + '</div>' : '';

    document.getElementById('modalBody').innerHTML =
        // Score area
        '<div class="modal-score-area">' +
            '<div class="modal-ring">' +
                '<svg width="80" height="80" viewBox="0 0 80 80">' +
                    '<circle cx="40" cy="40" r="36" fill="none" stroke="var(--border)" stroke-width="6"/>' +
                    '<circle cx="40" cy="40" r="36" fill="none" stroke="' + d.gradeColor + '" stroke-width="6" stroke-linecap="round" stroke-dasharray="' + circ + '" stroke-dashoffset="' + off + '" style="transition:stroke-dashoffset .6s"/>' +
                '</svg>' +
                '<div class="modal-ring-text">' +
                    '<span class="modal-ring-num" style="color:' + d.gradeColor + '">' + d.score + '</span>' +
                    '<span class="modal-ring-label">/ 100</span>' +
                '</div>' +
            '</div>' +
            '<div class="score-meta">' +
                '<div class="score-grade-big" style="color:' + d.gradeColor + '">' + d.grade + '</div>' +
                '<div class="score-verdict">' + (verdicts[d.grade] || '') + '</div>' +
                '<div style="margin-top:8px;display:flex;gap:12px;">' +
                    '<div><div style="font-size:10px;color:var(--text-3)">Keyword</div><div style="font-size:12px;font-weight:600;color:var(--text-1)">' + (d.keyword || '—') + '</div></div>' +
                    '<div><div style="font-size:10px;color:var(--text-3)">Schema</div><div style="font-size:12px;font-weight:600;color:var(--text-1)">' + (d.schema || '—') + '</div></div>' +
                    '<div><div style="font-size:10px;color:var(--text-3)">Robots</div><div style="font-size:12px;font-weight:600;color:var(--text-1)">' + (d.robots || '—') + '</div></div>' +
                '</div>' +
            '</div>' +
        '</div>' +

        // SERP Preview
        (metaHtml ? '<div class="check-section"><div class="check-section-title">🔍 Google SERP Preview</div>' + metaHtml + '</div>' : '') +

        // Predictions
        '<div class="predict-section">' +
            '<div class="predict-title">📈 SEO Predictions</div>' +
            '<div class="predict-row"><span class="predict-label">Estimated CTR</span><span class="predict-val" style="color:' + ctrColor + '">~' + d.ctr + '%</span></div>' +
            '<div class="predict-bar-full"><div class="predict-bar-inner" style="width:' + ctrPct + '%;background:' + ctrColor + '"></div></div>' +
            '<div class="predict-row" style="margin-top:10px;"><span class="predict-label">Ranking Potential</span><span class="predict-val" style="color:' + rankColor + '">' + d.rank + '</span></div>' +
            '<div class="predict-bar-full"><div class="predict-bar-inner" style="width:' + rankPct + '%;background:' + rankColor + '"></div></div>' +
            '<div class="predict-row" style="margin-top:10px;"><span class="predict-label">Reading Time</span><span class="predict-val" style="color:var(--accent)">' + (d.readingTime ? '~' + d.readingTime + ' min' : 'Not set') + '</span></div>' +
            '<div style="margin-top:10px;font-size:11px;color:var(--text-3)">Views so far: <strong style="color:var(--text-1)">' + d.views.toLocaleString() + '</strong></div>' +
        '</div>' +

        // Good checks
        (goodHtml ? '<div class="check-section"><div class="check-section-title">✅ What\'s Working (' + d.good.length + ')</div>' + goodHtml + '</div>' : '') +

        // Issues
        (issueHtml ? '<div class="check-section"><div class="check-section-title">❌ Issues Found (' + d.issues.length + ')</div>' + issueHtml + '</div>' : '') +

        // Quick wins
        tipsHtml +

        // CTA
        '<a href="' + d.editUrl + '" style="display:flex;align-items:center;justify-content:center;gap:8px;background:linear-gradient(135deg,var(--accent),var(--accent2));color:#fff;padding:11px;border-radius:8px;text-decoration:none;font-weight:600;font-size:13px;margin-top:4px;">✏️ Fix SEO Issues — Edit Blog</a>';

    document.getElementById('seoModalOverlay').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeSeoModal() {
    document.getElementById('seoModalOverlay').classList.remove('show');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeSeoModal();
});
</script>
</body>
</html>