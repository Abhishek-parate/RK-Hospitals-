<?php
$base_url = "http://localhost/rkhospital/";
require_once 'include/config.php';

// ── Slug Resolution ───────────────────────────────────────────
$slug = '';
if (!empty($_GET['slug'])) {
    $slug = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['slug']);
} elseif (!empty($_SERVER['REQUEST_URI'])) {
    $uri   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $parts = explode('/', trim($uri, '/'));
    if (count($parts) >= 2 && $parts[count($parts) - 2] === 'doctors') {
        $slug = preg_replace('/[^a-zA-Z0-9_-]/', '', end($parts));
    }
}

// ── Fetch Doctor ──────────────────────────────────────────────
$stmt = $conn->prepare("SELECT * FROM doctors WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$doctor = $stmt->get_result()->fetch_assoc();

if (!$doctor) {
    header("Location: " . SITE_URL . "/error-404.html");
    exit;
}

// ── Decode JSON Fields ────────────────────────────────────────
$education       = !empty($doctor['education_json'])  ? json_decode($doctor['education_json'], true)  : [];
$experience      = !empty($doctor['experience_json']) ? json_decode($doctor['experience_json'], true) : [];
$awards          = !empty($doctor['awards_json'])      ? json_decode($doctor['awards_json'], true)      : [];
$specializations = !empty($doctor['specializations'])
    ? array_filter(array_map('trim', explode(',', $doctor['specializations'])))
    : [];

// ── Sanitize nulls ────────────────────────────────────────────
$doctorName         = trim($doctor['name']             ?? '');
$doctorDesig        = trim($doctor['designation']      ?? '');
$doctorSpecialty    = trim($doctor['specialty']        ?? '');
$doctorBio          = trim($doctor['bio']              ?? '');
$doctorLocation     = trim($doctor['location']         ?? '');
$doctorFee          = trim($doctor['consultation_fee'] ?? '');
$doctorSatisfaction = (int)($doctor['satisfaction_rate'] ?? 0);
$doctorFeedback     = (int)($doctor['feedback_count']    ?? 0);
$doctorPhoto        = trim($doctor['photo']            ?? '');
$doctorMap          = trim($doctor['map_iframe']       ?? '');
$doctorFeatureImage = trim($doctor['feature_image']    ?? '');

$hasPhoto       = !empty($doctorPhoto)        && $doctorPhoto        !== 'default.jpg';
$hasBannerImage = !empty($doctorFeatureImage) && $doctorFeatureImage !== 'default.jpg';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Profile of <?= htmlspecialchars($doctorName) ?> at Dr. Agrawal's R.K. Hospital Nagpur.">
    <title><?= htmlspecialchars($doctorName) ?> | Dr. Agrawal's R.K. Hospital Nagpur</title>

    <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/img/RK-Logo.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $base_url; ?>assets/img/RK-Logo.png">

    <script src="<?= $base_url ?>assets/js/theme-script.js"></script>

    <link rel="stylesheet" href="<?= $base_url ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/animate.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/iconsax.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/feather.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/plugins/slick/slick.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/plugins/slick/slick-theme.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/plugins/wow/css/animate.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">

    <style>
        :root {
            --brand-primary: #1d4ed8;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --bg-page: #f1f5f9;
            --card-shadow: 0 10px 40px rgba(15, 23, 42, 0.05);
            --border-soft: #e2e8f0;
            --font-main: 'Inter', sans-serif;
            --font-heading: 'Playfair Display', serif;
        }

        body { background-color: var(--bg-page); font-family: var(--font-main); color: var(--text-dark); }

        /* ── Profile Header Background ── */
        .profile-header-bg {
            position: relative;
            width: 100%;
            height: 70vh; /* Taller banner */
            min-height: 350px;
            background: <?= $hasBannerImage ? 'url("'.asset($doctorFeatureImage).'") center/cover no-repeat' : '#1e293b' ?>;
            display: flex;
            align-items: flex-start;
            padding-top: 40px;
        }
   

        /* Top Breadcrumb pill */
        .breadcrumb-transparent {
            position: relative; z-index: 10;
            background: rgba(255, 255, 255, 0.12);
            padding: 8px 18px; border-radius: 30px;
            display: inline-flex; align-items: center; gap: 8px;
            margin-bottom: 20px;
            backdrop-filter: blur(4px);
        }
        .breadcrumb-transparent a, .breadcrumb-transparent span { 
            color: #fff; font-size: 13.5px; text-decoration: none; font-weight: 500;
        }
        .breadcrumb-transparent a:hover { color: #93c5fd; }
        .breadcrumb-transparent .separator { color: rgba(255,255,255,0.5); margin: 0 2px; }
        .breadcrumb-transparent i { color: #fff; margin-right: 4px; font-size: 13px;}

        /* ── Master Profile Card (Moved BELOW the banner) ── */
        .master-profile-wrap {
            position: relative;
            z-index: 20;
            margin-top: 30px; 
            margin-bottom: 40px;
        }
        .master-profile-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            padding: 30px;
            display: flex; gap: 30px; align-items: center;
        }
        
        /* Avatar */
        .mp-avatar-wrap { flex-shrink: 0; position: relative; display: flex; align-items: center;}
        .mp-avatar {
            width: 140px; height: 140px; object-fit: cover;
            border-radius: 16px;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            background: #f8fafc;
        }
        .mp-verified {
            position: absolute; bottom: -4px; right: -4px;
            background: #10b981; color: #fff; width: 28px; height: 28px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 13px; border: 3px solid #fff;
        }
        
        /* Info (Name, Desig, Tags) */
        .mp-info { flex-grow: 1; }
        .mp-info h1 { 
            font-family: var(--font-heading); font-size: 2.2rem; 
            margin: 0 0 4px; color: #0f172a; font-weight: 800;
        }
        .mp-info .designation { 
            font-size: 1.05rem; color: #2563eb; 
            font-weight: 500; margin-bottom: 16px; 
            text-transform: lowercase;
        }
        .mp-tags { display: flex; gap: 10px; flex-wrap: wrap; }
        .mp-tag { 
            padding: 6px 14px; border-radius: 6px; font-size: 12.5px; font-weight: 500; 
            display: inline-flex; align-items: center; gap: 6px; 
        }
        .mp-tag.specialty { background: #eff6ff; color: #2563eb; }
        .mp-tag.specialty i { font-size: 14px; }
        .mp-tag.location { background: #f1f5f9; color: #475569; }
        .mp-tag.location i { font-size: 13px; }
        
        /* Stats (Right side) */
        .mp-stats { 
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            border-left: 1px solid #e2e8f0; 
            padding-left: 40px; padding-right: 20px; flex-shrink: 0; 
        }
        .stat-block { text-align: center; }
        .stat-block h3 { 
            font-size: 1.7rem; font-weight: 800; margin: 0 0 2px; color: #0f172a; 
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .stat-block h3 i { color: #f59e0b; font-size: 1.1rem; }
        .stat-block p { 
            font-size: 10px; color: #64748b; margin: 0; 
            font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; 
        }

        /* ── Rest of Page Cards ── */
        .doc-card {
            background: #fff; border-radius: 16px; padding: 30px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.02);
            border: 1px solid #e2e8f0; margin-bottom: 24px;
        }
        .doc-card-title {
            font-family: var(--font-heading); font-size: 1.4rem; color: var(--text-dark);
            margin-bottom: 20px; display: flex; align-items: center; gap: 12px;
            padding-bottom: 15px; border-bottom: 1px solid var(--border-soft);
        }
        .doc-card-title .icon-box {
            background: #eff6ff; color: var(--brand-primary);
            width: 36px; height: 36px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; font-size: 16px;
        }

        /* ── Timeline ── */
        .modern-timeline { position: relative; padding-left: 25px; }
        .modern-timeline::before {
            content: ''; position: absolute; left: 5px; top: 0; bottom: 0;
            width: 2px; border-left: 2px dashed #cbd5e1;
        }
        .mt-item { position: relative; margin-bottom: 25px; }
        .mt-item:last-child { margin-bottom: 0; }
        .mt-dot {
            position: absolute; left: -25px; top: 4px;
            width: 12px; height: 12px; border-radius: 50%;
            background: #fff; border: 2px solid var(--brand-primary);
            box-shadow: 0 0 0 4px #fff;
        }
        .mt-content h5 { font-size: 1.05rem; font-weight: 600; margin: 0 0 4px; color: var(--text-dark); }
        .mt-content .highlight { display: inline-block; background: #eff6ff; color: var(--brand-primary); padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 500; margin-bottom: 6px; }
        .mt-content .date { font-size: 13px; color: var(--text-muted); font-weight: 400; display: flex; align-items: center; gap: 6px;}

        /* Sidebar info */
        .info-list { list-style: none; padding: 0; margin: 0; }
        .info-list li { display: flex; gap: 15px; margin-bottom: 18px; align-items: flex-start; }
        .info-list li:last-child { margin-bottom: 0; }
        .info-list i { font-size: 18px; color: var(--brand-primary); margin-top: 3px; }
        .info-list .info-label { font-size: 12px; color: var(--text-muted); font-weight: 500; text-transform: uppercase; margin-bottom: 2px;}
        .info-list .info-val { font-size: 14px; font-weight: 600; color: var(--text-dark); }

        /* Sticky Sidebar Class */
        .sticky-sidebar {
            position: sticky;
            top: 100px; /* Adjust this value based on your header height */
            z-index: 10;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .master-profile-card { flex-direction: column; text-align: center; gap: 20px; padding: 25px; }
            .mp-stats { border-left: none; border-top: 1px solid var(--border-soft); padding-left: 0; padding-top: 20px; width: 100%; }
            .mp-tags { justify-content: center; }
            
            /* Disable sticky on mobile so it flows naturally */
            .sticky-sidebar {
                position: static;
            }
        }
    </style>
</head>

<body>
    <div class="main-wrapper">

        <?php include 'include/header.php'; ?>

        <div class="profile-header-bg">
            <div class="container">
              
            </div>
        </div>


                <!-- ═══════════════════════ BREADCRUMB ═══════════════════════ -->
        <div class="breadcrumb-strip">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/"><i class="fa-solid fa-house me-1"></i>Home</a></li>
                        <li class="breadcrumb-item active"><span><?= htmlspecialchars($doctorName) ?></span></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container pb-5">
            
            <div class="master-profile-wrap wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                <div class="master-profile-card">
                    <div class="mp-avatar-wrap">
                        <img src="<?= asset($hasPhoto ? $doctorPhoto : 'assets/img/doctors/default.jpg') ?>" 
                             alt="<?= htmlspecialchars($doctorName) ?>" class="mp-avatar">
                        <div class="mp-verified" title="Verified Doctor"><i class="fa-solid fa-check"></i></div>
                    </div>
                    
                    <div class="mp-info">
                        <h1><?= htmlspecialchars($doctorName) ?></h1>
                        <div class="designation"><?= !empty($doctorDesig) ? htmlspecialchars($doctorDesig) : 'mbbs' ?></div>
                        
                        <div class="mp-tags">
                            <?php if (!empty($doctorSpecialty)): ?>
                                <span class="mp-tag specialty"><i class="fa-solid fa-stethoscope"></i> <?= htmlspecialchars($doctorSpecialty) ?></span>
                            <?php else: ?>
                                <span class="mp-tag specialty"><i class="fa-solid fa-stethoscope"></i> Cardiologist</span>
                            <?php endif; ?>
                            
                            <?php if (!empty($doctorLocation)): ?>
                                <span class="mp-tag location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($doctorLocation) ?></span>
                            <?php else: ?>
                                <span class="mp-tag location"><i class="fa-solid fa-location-dot"></i> nagpur</span>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row g-4">
                
                <div class="col-lg-8">
                    
                 <?php if (!empty($doctorBio)): ?>
<div class="doc-card wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
    <h2 class="doc-card-title">
        <div class="icon-box"><i class="fa-regular fa-user"></i></div>
        About The Doctor
    </h2>
    <?php
        $bio = str_replace(["\r\n", "\r"], "\n", trim($doctorBio));
        
       
        $paras = preg_split('/\n\n+/', $bio);
        $paras = array_filter(array_map('trim', $paras));
        
        foreach ($paras as $para):
          
            $para = preg_replace('/\n/', ' ', $para);
    ?>
    <p style="font-size:1rem; line-height:1.8; color:var(--text-muted); margin:0 0 16px 0; text-align:justify;">
        <?= htmlspecialchars($para) ?>
    </p>
    <?php endforeach; ?>
</div>
<?php endif; ?>

                    <?php if (!empty($experience)): ?>
                    <div class="doc-card wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                        <h2 class="doc-card-title">
                            <div class="icon-box"><i class="fa-solid fa-briefcase-medical"></i></div>
                            Clinical Experience
                        </h2>
                        <div class="modern-timeline">
                            <?php foreach ($experience as $exp): ?>
                            <div class="mt-item">
                                <div class="mt-dot"></div>
                                <div class="mt-content">
                                    <?php if (!empty($exp['title'])): ?><h5><?= htmlspecialchars($exp['title']) ?></h5><?php endif; ?>
                                    <?php if (!empty($exp['year'])): ?>
                                        <div class="date"><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($exp['year']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($education)): ?>
                    <div class="doc-card wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                        <h2 class="doc-card-title">
                            <div class="icon-box"><i class="fa-solid fa-graduation-cap"></i></div>
                            Education & Training
                        </h2>
                        <div class="modern-timeline">
                            <?php foreach ($education as $edu): ?>
                            <div class="mt-item">
                                <div class="mt-dot"></div>
                                <div class="mt-content">
                                    <?php if (!empty($edu['title'])): ?><h5><?= htmlspecialchars($edu['title']) ?></h5><?php endif; ?>
                                    <?php if (!empty($edu['degree'])): ?><span class="highlight"><?= htmlspecialchars($edu['degree']) ?></span><?php endif; ?>
                                    <?php if (!empty($edu['year'])): ?>
                                        <div class="date"><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($edu['year']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>

                <div class="col-lg-4">
                    <div class="sticky-sidebar">
                        
                        <div class="doc-card wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                            <h2 class="doc-card-title" style="font-size: 1.25rem;">
                                <div class="icon-box" style="width: 32px; height: 32px; font-size: 14px;"><i class="fa-solid fa-circle-info"></i></div>
                                Quick Info
                            </h2>
                            <ul class="info-list">
                                <li>
                                    <i class="fa-solid fa-wallet"></i>
                                    <div>
                                        <div class="info-label">Consultation Fee</div>
                                        <div class="info-val"><?= !empty($doctorFee) ? htmlspecialchars($doctorFee) : 'Contact Hospital' ?></div>
                                    </div>
                                </li>
                                <li>
                                    <i class="fa-solid fa-clock"></i>
                                    <div>
                                        <div class="info-label">OPD Timings</div>
                                        <div class="info-val">Mon - Sat</div>
                                        <div style="font-size: 13px; color: var(--text-muted); margin-top:2px;">11AM - 4PM & 7PM - 9PM</div>
                                    </div>
                                </li>
                                <li>
                                    <i class="fa-solid fa-language"></i>
                                    <div>
                                        <div class="info-label">Languages Spoken</div>
                                        <div class="info-val">English, Hindi, Marathi</div>
                                    </div>
                                </li>
                            </ul>
                            
                            <a href="<?= $base_url ?>contact-us" class="btn btn-primary w-100 mt-4" style="background: var(--brand-primary); border: none; padding: 12px; border-radius: 8px; font-weight: 500;">
                                <i class="fa-regular fa-calendar-check me-2"></i> Book Appointment
                            </a>
                        </div>

                        <?php if (!empty($specializations)): ?>
                        <div class="doc-card wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                            <h2 class="doc-card-title" style="font-size: 1.25rem;">
                                <div class="icon-box" style="width: 32px; height: 32px; font-size: 14px;"><i class="fa-solid fa-microscope"></i></div>
                                Expertise
                            </h2>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                <?php foreach ($specializations as $spec): ?>
                                    <span style="background: #f1f5f9; color: var(--text-dark); border: 1px solid var(--border-soft); padding: 6px 12px; border-radius: 6px; font-size: 12.5px; font-weight: 500;"><?= htmlspecialchars($spec) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($doctorMap)): ?>
                        <div class="doc-card wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.5s">
                            <h2 class="doc-card-title" style="font-size: 1.25rem;">
                                <div class="icon-box" style="width: 32px; height: 32px; font-size: 14px;"><i class="fa-solid fa-map-location-dot"></i></div>
                                Location
                            </h2>
                            <div style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border-soft);">
                                <?= str_replace('<iframe', '<iframe style="width:100%; height:200px; border:0; display:block;" allowfullscreen="" loading="lazy"', $doctorMap) ?>
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
    
    <div class="progress-wrap active-progress">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919px, 307.919px; stroke-dashoffset: 228.265px;"></path>
        </svg>
    </div>

    <script src="<?= $base_url ?>assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?= $base_url ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $base_url ?>assets/js/feather.min.js"></script>
    <script src="<?= $base_url ?>assets/js/backToTop.js"></script>
    <script src="<?= $base_url ?>assets/plugins/slick/slick.min.js"></script>
    <script src="<?= $base_url ?>assets/plugins/fancybox/jquery.fancybox.min.js"></script>
    <script src="<?= $base_url ?>assets/plugins/wow/js/wow.min.js"></script>
    <script src="<?= $base_url ?>assets/js/script.js"></script>
</body>
</html>