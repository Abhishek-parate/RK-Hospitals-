<?php
// Include configuration
require_once 'include/config.php';

// Fetch by slug from .htaccess rewrite rule (/doctors/{slug})
$slug = '';
if (!empty($_GET['slug'])) {
    $slug = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['slug']);
} elseif (!empty($_SERVER['REQUEST_URI'])) {
    $uri   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $parts = explode('/', trim($uri, '/'));
    if (count($parts) >= 2 && $parts[count($parts)-2] === 'doctors') {
        $slug = preg_replace('/[^a-zA-Z0-9_-]/', '', end($parts));
    }
}

// 1. Fetch Main Doctor Profile
$stmt = $conn->prepare("SELECT * FROM doctors WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$doctor = $stmt->get_result()->fetch_assoc();

if (!$doctor) {
    header("Location: " . SITE_URL . "/error-404.html");
    exit;
}

// Decode JSON data
$education = !empty($doctor['education_json']) ? json_decode($doctor['education_json'], true) : [];
$experience = !empty($doctor['experience_json']) ? json_decode($doctor['experience_json'], true) : [];
$awards = !empty($doctor['awards_json']) ? json_decode($doctor['awards_json'], true) : [];
$specializations = !empty($doctor['specializations']) ? explode(',', $doctor['specializations']) : [];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($doctor['name']) ?> – Doctor Profile | RK Hospital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Playfair+Display:wght@500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/plugins/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
    <style>
    :root {
        --blue-600: #2563EB;
        --blue-500: #3B82F6;
        --blue-100: #DBEAFE;
        --blue-50: #EFF6FF;
        --teal-500: #14B8A6;
        --slate-900: #0F172A;
        --slate-800: #1E293B;
        --slate-700: #334155;
        --slate-500: #64748B;
        --slate-300: #CBD5E1;
        --slate-100: #F1F5F9;
        --slate-50: #F8FAFC;
        --white: #FFFFFF;
        --gold: #F59E0B;
        --green-500: #22C55E;
        --red-500: #EF4444;
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 20px;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
        --shadow-md: 0 4px 20px rgba(15, 23, 42, .08);
        --shadow-lg: 0 12px 40px rgba(15, 23, 42, .12);
        --font-body: 'DM Sans', sans-serif;
        --font-display: 'Playfair Display', serif;
    }

    body {
        font-family: var(--font-body);
        color: var(--slate-800);
        background: var(--slate-50);
    }

    .content {
        padding: 40px 0 60px;
    }

    .doc-profile-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 0;
        overflow: hidden;
        border: 1px solid rgba(203, 213, 225, .6);
        margin-bottom: 24px;
    }

    .doc-profile-card::before {
        content: '';
        display: block;
        height: 5px;
        background: linear-gradient(90deg, var(--blue-600) 0%, var(--teal-500) 100%);
    }

    .doc-profile-card .card-inner {
        padding: 32px 36px 28px;
        display: flex;
        gap: 28px;
        align-items: center;
    }

    .doc-avatar-wrap {
        flex-shrink: 0;
        position: relative;
    }

    .doc-avatar-wrap img {
        width: 120px;
        height: 120px;
        border-radius: var(--radius-md);
        object-fit: cover;
        border: 3px solid var(--white);
        box-shadow: var(--shadow-md);
    }

    .doc-verified-badge {
        position: absolute;
        bottom: -6px;
        right: -6px;
        background: var(--blue-600);
        color: #fff;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        box-shadow: 0 0 0 3px var(--white);
    }

    .doc-info-main {
        flex: 1;
        min-width: 0;
    }

    .doc-info-main h2 {
        font-family: var(--font-display);
        font-size: 1.65rem;
        font-weight: 600;
        color: var(--slate-900);
        margin: 0 0 4px;
        letter-spacing: -0.3px;
    }

    .doc-degrees {
        font-size: .875rem;
        color: var(--slate-500);
        margin-bottom: 8px;
    }

    .doc-specialty-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--blue-50);
        color: var(--blue-600);
        border: 1px solid var(--blue-100);
        font-size: .78rem;
        font-weight: 600;
        padding: 3px 11px;
        border-radius: 20px;
        margin-bottom: 12px;
        letter-spacing: .3px;
        text-transform: uppercase;
    }

    .doc-actions-panel {
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 0;
        min-width: 230px;
        padding-left: 28px;
        border-left: 1px solid var(--slate-200);
    }

    .doc-stats {
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 100%;
        margin-bottom: 20px;
    }

    .doc-stat {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: .875rem;
        color: var(--slate-700);
    }

    .doc-stat i {
        color: var(--blue-500);
        font-size: 1rem;
        width: 20px;
        text-align: center;
        flex-shrink: 0;
    }

    .doc-stat strong {
        font-weight: 600;
        color: var(--slate-900);
    }

    .btn-book {
        display: block;
        width: 100%;
        background: linear-gradient(135deg, var(--blue-600) 0%, #1D4ED8 100%);
        color: var(--white);
        font-family: var(--font-body);
        font-size: .9rem;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 12px;
        border: none;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(37, 99, 235, .35);
        transition: all .2s;
    }

    .btn-book:hover {
        color: var(--white);
        box-shadow: 0 6px 20px rgba(37, 99, 235, .45);
        transform: translateY(-1px);
    }

    .doc-tabs-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(203, 213, 225, .6);
        overflow: hidden;
        padding: 36px;
    }

    .section-title {
        font-family: var(--font-display);
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--slate-900);
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--blue-100);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: var(--blue-500);
        font-size: 1rem;
    }

    .about-text {
        font-size: .9rem;
        color: var(--slate-600);
        line-height: 1.75;
        margin-bottom: 32px;
    }

    .two-col-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        margin-bottom: 32px;
    }

    .timeline-section {
        margin-bottom: 32px;
    }

    .timeline {
        list-style: none;
        padding: 0;
        margin: 0;
        position: relative;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 11px;
        top: 6px;
        bottom: 0;
        width: 2px;
        background: var(--blue-100);
    }

    .timeline li {
        display: flex;
        gap: 18px;
        margin-bottom: 20px;
        position: relative;
    }

    .timeline-dot {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--white);
        border: 2.5px solid var(--blue-500);
        position: relative;
        z-index: 1;
        margin-top: 2px;
    }

    .timeline-body h5 {
        font-size: .9rem;
        font-weight: 600;
        color: var(--slate-900);
        margin: 0 0 3px;
    }

    .timeline-body .degree {
        font-size: .82rem;
        font-weight: 600;
        color: var(--blue-600);
        background: var(--blue-50);
        padding: 1px 8px;
        border-radius: 4px;
        display: inline-block;
        margin-bottom: 3px;
    }

    .timeline-body .year {
        font-size: .8rem;
        color: var(--slate-500);
    }

    .awards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }

    .award-card {
        background: linear-gradient(135deg, var(--blue-50), #FFFBEB);
        border: 1px solid #FDE68A;
        border-radius: var(--radius-md);
        padding: 20px;
    }

    .award-year-badge {
        display: inline-block;
        background: var(--gold);
        color: #fff;
        font-size: .72rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        margin-bottom: 10px;
    }

    .award-card h5 {
        font-size: .9rem;
        font-weight: 700;
        margin: 0 0 6px;
    }

    .award-card p {
        font-size: .82rem;
        color: var(--slate-600);
        margin: 0;
    }

    .spec-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 28px;
    }

    .spec-chip {
        background: linear-gradient(135deg, var(--blue-50), #F0FDF4);
        color: var(--blue-700);
        font-size: .82rem;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 20px;
        border: 1px solid var(--blue-100);
    }

    .loc-map-wrap {
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid var(--slate-200);
        box-shadow: var(--shadow-sm);
        width: 100%;
    }

    .loc-map-wrap iframe {
        width: 100% !important;
        height: 450px;
        border: 0;
        display: block;
    }

    @media (max-width: 900px) {
        .doc-profile-card .card-inner {
            flex-direction: column;
        }

        .doc-actions-panel {
            width: 100%;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .two-col-grid {
            grid-template-columns: 1fr;
        }

        .awards-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 580px) {
        .awards-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <?php require_once 'include/header.php'; ?>

    <div class="content">
        <div class="container">
            <div class="doc-profile-card">
                <div class="card-inner">
                    <div class="doc-avatar-wrap">
                        <img src="<?= asset($doctor['photo'] && $doctor['photo'] !== 'default.jpg' ? $doctor['photo'] : 'assets/img/doctors/default.jpg') ?>"
                            alt="<?= htmlspecialchars($doctor['name']) ?>">
                        <div class="doc-verified-badge" title="Verified Doctor"><i class="fas fa-check"></i></div>
                    </div>
                    <div class="doc-info-main">
                        <h2><?= htmlspecialchars($doctor['name']) ?></h2>
                        <p class="doc-degrees"><?= htmlspecialchars($doctor['designation']) ?></p>
                        <?php if(!empty($doctor['specialty'])): ?>
                        <span class="doc-specialty-tag">
                            <?= htmlspecialchars($doctor['specialty']) ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="doc-actions-panel">
                        <div class="doc-stats">
                            <div class="doc-stat">
                                <i class="far fa-thumbs-up"></i>
                                <div><strong><?= (int)$doctor['satisfaction_rate'] ?>%</strong> Satisfaction</div>
                            </div>
                            <div class="doc-stat">
                                <i class="far fa-comment"></i>
                                <div><strong><?= (int)$doctor['feedback_count'] ?></strong> Feedbacks</div>
                            </div>
                            <div class="doc-stat">
                                <i class="fas fa-map-marker-alt"></i>
                                <div><?= htmlspecialchars($doctor['location'] ?: 'Nagpur, India') ?></div>
                            </div>
                            <div class="doc-stat">
                                <i class="far fa-money-bill-alt"></i>
                                <div>
                                    <strong><?= htmlspecialchars($doctor['consultation_fee'] ?: 'Contact Us') ?></strong>
                                </div>
                            </div>
                        </div>
                        <a href="<?= SITE_URL ?>/booking.html" class="btn-book"
                            style="margin-top:8px;display:flex;align-items:center;justify-content:center;gap:8px;">
                            <i class="fas fa-calendar-check"></i> Book Appointment
                        </a>
                    </div>
                </div>
            </div>

            <div class="doc-tabs-card">
                <div class="tab-content-area">
                    <div id="tab-overview" class="tab-pane active" style="display:block;">
                        <h3 class="section-title"><i class="fas fa-info-circle"></i>About Me</h3>
                        <p class="about-text">
                            <?= !empty($doctor['bio']) ? nl2br(htmlspecialchars($doctor['bio'])) : 'Biography coming soon.' ?>
                        </p>

                        <div class="two-col-grid">
                            <div>
                                <h3 class="section-title"><i class="fas fa-graduation-cap"></i>Education</h3>
                                <div class="timeline-section">
                                    <ul class="timeline">
                                        <?php if(!empty($education)): ?>
                                        <?php foreach($education as $edu): ?>
                                        <li>
                                            <div class="timeline-dot"></div>
                                            <div class="timeline-body">
                                                <h5><?= htmlspecialchars($edu['title']) ?></h5>
                                                <span class="degree"><?= htmlspecialchars($edu['degree']) ?></span>
                                                <div class="year"><?= htmlspecialchars($edu['year']) ?></div>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <li>
                                            <p>Education history not updated yet.</p>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <h3 class="section-title"><i class="fas fa-briefcase"></i>Work & Experience</h3>
                                <div class="timeline-section">
                                    <ul class="timeline">
                                        <?php if(!empty($experience)): ?>
                                        <?php foreach($experience as $exp): ?>
                                        <li>
                                            <div class="timeline-dot"></div>
                                            <div class="timeline-body">
                                                <h5><?= htmlspecialchars($exp['title']) ?></h5>
                                                <div class="year"><?= htmlspecialchars($exp['year']) ?></div>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <li>
                                            <p>Experience history not updated yet.</p>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <h3 class="section-title"><i class="fas fa-trophy"></i>Awards</h3>
                        <div class="awards-grid">
                            <?php if(!empty($awards)): ?>
                            <?php foreach($awards as $awd): ?>
                            <div class="award-card">
                                <div class="award-year-badge"><?= htmlspecialchars($awd['year']) ?></div>
                                <h5><?= htmlspecialchars($awd['title']) ?></h5>
                                <p><?= htmlspecialchars($awd['desc']) ?></p>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p>No awards listed yet.</p>
                            <?php endif; ?>
                        </div>

                        <h3 class="section-title"><i class="fas fa-microscope"></i>Specializations</h3>
                        <div class="spec-grid" style="margin-bottom: 32px;">
                            <?php if(!empty($specializations)): ?>
                            <?php foreach($specializations as $spec): ?>
                            <span class="spec-chip"><?= htmlspecialchars(trim($spec)) ?></span>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p>No specializations listed yet.</p>
                            <?php endif; ?>
                        </div>

                        <?php if(!empty($doctor['map_iframe'])): ?>
                        <h3 class="section-title"><i class="fas fa-map-marker-alt"></i>Hospital Location</h3>
                        <div class="loc-map-wrap">
                            <?= $doctor['map_iframe'] ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'include/footer.php'; ?>
    <script src="<?= asset('assets/js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>