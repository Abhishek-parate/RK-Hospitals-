<?php
/**
 * About Us Page — Dr. Agrawal's R.K. Hospital Nagpur
 * SEO-optimized | Red + Primary theme | Premium hospital design
 */
$base_url = "http://localhost/rkhospital/";
include 'include/config.php';
$page_title       = "About Dr. Agrawal's R.K. Hospital Nagpur | Best Orthopedic & Gynecology Hospital";
$meta_description = "Learn about Dr. Agrawal's R.K. Hospital Nagpur — a leading orthopedic & gynecology hospital with 25+ years of excellence in robotic knee replacement, hip replacement, spine surgery, and women's healthcare.";
$meta_keywords    = "RK Hospital Nagpur, about RK Hospital, Dr Rahul Agrawal orthopedic, Dr Priyanka Jain gynecologist, best hospital Nagpur, orthopedic hospital Nagpur, gynecology hospital Nagpur, robotic knee replacement Nagpur";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <meta name="author" content="Dr. Agrawal's R.K. Hospital Nagpur">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $base_url; ?>about-us.php">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta property="og:image" content="<?php echo $base_url; ?>assets/img/home/about-doctor1.webp">
    <meta property="og:site_name" content="Dr. Agrawal's R.K. Hospital Nagpur">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="twitter:image" content="<?php echo $base_url; ?>assets/img/home/about-doctor1.webp">

    <link rel="canonical" href="<?php echo $base_url; ?>about-us.php">

    <title><?php echo htmlspecialchars($page_title); ?></title>

    <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/img/RK-Logo.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $base_url; ?>assets/img/RK-Logo.png">

    <script src="<?php echo $base_url; ?>assets/js/theme-script.js"></script>

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/animate.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/iconsax.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/feather.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/wow/css/animate.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fancybox/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/about-us.css">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Hospital",
        "name": "Dr. Agrawal's R.K. Hospital",
        "url": "<?php echo $base_url; ?>",
        "logo": "<?php echo $base_url; ?>assets/img/logo.svg",
        "image": "<?php echo $base_url; ?>assets/img/home/about-doctor1.webp",
        "description": "<?php echo htmlspecialchars($meta_description); ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "27, Chandrashekhar Azad Square, Central Avenue Road, Beside Hotel Al Zam Zam, Gandhibagh",
            "addressLocality": "Nagpur",
            "addressRegion": "Maharashtra",
            "postalCode": "440002",
            "addressCountry": "IN"
        },
        "telephone": ["+919766057372", "+918999290433"],
        "openingHours": ["Mo-Sa 11:00-16:00", "Mo-Sa 19:00-21:00"],
        "medicalSpecialty": ["Orthopedic Surgery", "Gynecology", "Obstetrics", "Trauma Surgery"],
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "5",
            "reviewCount": "496"
        }
    }
    </script>

    <style>
/* ════════════════════════════════════════════════
   OUR STORY SECTION
════════════════════════════════════════════════ */
.rk-our-story-section {
    padding: 96px 0 100px;
    background: #fff;
    position: relative;
    overflow: hidden;
}

.rk-our-story-section::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 420px;
    height: 420px;
    background: radial-gradient(circle, rgba(220,53,69,0.05) 0%, transparent 70%);
    pointer-events: none;
}

.rk-our-story-section::after {
    content: '';
    position: absolute;
    bottom: -80px;
    left: -80px;
    width: 320px;
    height: 320px;
    background: radial-gradient(circle, rgba(13,110,253,0.04) 0%, transparent 70%);
    pointer-events: none;
}

/* ══ TOP: Centered Intro ════════════════════════ */
.rk-story-top-center {
    text-align: center;
    max-width: 740px;
    margin: 0 auto 64px;
}

.rk-story-main-heading {
    font-size: clamp(1.85rem, 3.2vw, 2.6rem);
    font-weight: 900;
    color: #1a1a2e;
    line-height: 1.22;
    margin: 10px 0 18px;
}

.rk-story-main-heading .accent {
    color: #dc3545;
}

.rk-story-intro-text {
    font-size: 1rem;
    color: #5a5a78;
    line-height: 1.82;
    margin-bottom: 36px;
}

/* Stat Strip */
.rk-story-stat-strip {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    border-radius: 18px;
    padding: 18px 36px;
    gap: 0;
    flex-wrap: wrap;
    justify-content: center;
}

.stat-strip-item {
    text-align: center;
    padding: 6px 28px;
}

.stat-strip-num {
    font-size: 1.65rem;
    font-weight: 900;
    color: #fff;
    letter-spacing: -0.5px;
    line-height: 1;
}

.stat-strip-lbl {
    font-size: 0.67rem;
    color: rgba(255,255,255,0.52);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
    margin-top: 5px;
}

.stat-strip-sep {
    width: 1px;
    height: 38px;
    background: rgba(255,255,255,0.12);
    flex-shrink: 0;
}

/* ══ BOTTOM: Body Row ═══════════════════════════ */
.rk-story-body-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

@media (max-width: 991px) {
    .rk-story-body-row {
        grid-template-columns: 1fr;
        gap: 48px;
    }
}

/* ══ LEFT: Image Column ════════════════════════ */
.rk-story-img-col { /* wrapper */ }

.rk-story-visual {
    position: relative;
    padding-bottom: 90px;
    padding-right: 56px;
}

/* Main Image */
.story-img-main {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 64px rgba(0,0,0,0.13);
    z-index: 2;
}

.story-img-main img {
    width: 100%;
    height: 460px;
    object-fit: cover;
    object-position: top center;
    display: block;
    transition: transform 0.55s ease;
}

.story-img-main:hover img {
    transform: scale(1.035);
}

/* Experience Badge */
.story-exp-badge {
    position: absolute;
    top: 28px;
    left: -20px;
    background: linear-gradient(135deg, #dc3545, #b02a37);
    color: #fff;
    border-radius: 18px;
    padding: 16px 18px;
    box-shadow: 0 10px 30px rgba(220,53,69,0.38);
    z-index: 5;
    text-align: center;
    min-width: 96px;
}

.story-exp-badge .exp-num {
    font-size: 1.9rem;
    font-weight: 900;
    line-height: 1;
    letter-spacing: -1px;
}

.story-exp-badge .exp-label {
    font-size: 0.62rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.88;
    margin-top: 4px;
    line-height: 1.3;
}

/* Floating Secondary Image */
.story-img-float {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 210px;
    border-radius: 18px;
    overflow: hidden;
    border: 5px solid #fff;
    box-shadow: 0 12px 36px rgba(0,0,0,0.16);
    z-index: 3;
}

.story-img-float img {
    width: 100%;
    height: 170px;
    object-fit: cover;
    object-position: top center;
    display: block;
    transition: transform 0.45s ease;
}

.story-img-float:hover img {
    transform: scale(1.04);
}

/* Floating Stat Card */
.story-float-card {
    position: absolute;
    bottom: 30px;
    left: 20px;
    background: #fff;
    border-radius: 14px;
    padding: 13px 16px;
    display: flex;
    align-items: center;
    gap: 11px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.11);
    border: 1px solid #eef0f4;
    z-index: 4;
    min-width: 185px;
}

.sfc-icon {
    width: 38px;
    height: 38px;
    background: rgba(220,53,69,0.09);
    color: #dc3545;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.sfc-num {
    font-size: 1.05rem;
    font-weight: 900;
    color: #1a1a2e;
    line-height: 1;
}

.sfc-lbl {
    font-size: 0.66rem;
    color: #8c8fa5;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-top: 3px;
}

/* ══ RIGHT: Content Column ══════════════════════ */
.rk-story-content-col { /* wrapper */ }

.story-body-lead {
    font-size: 0.97rem;
    font-weight: 500;
    color: #3a3a5c;
    line-height: 1.8;
    border-left: 3px solid #dc3545;
    padding-left: 16px;
    margin-bottom: 16px;
}

.story-body-text {
    font-size: 0.9rem;
    color: #5a5a78;
    line-height: 1.82;
    margin-bottom: 28px;
}

/* Highlights Grid */
.rk-story-highlights {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 32px;
}

.story-hl-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #3a3a5c;
    padding: 9px 13px;
    border-radius: 10px;
    background: #f8f9fb;
    border: 1px solid #eef0f4;
    transition: background 0.2s, border-color 0.2s, transform 0.2s;
    cursor: default;
}

.story-hl-item:hover {
    background: #fff5f5;
    border-color: #fecaca;
    transform: translateX(4px);
}

.hl-icon {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    flex-shrink: 0;
}

.hl-red    { background: rgba(220,53,69,0.10);  color: #dc3545; }
.hl-blue   { background: rgba(13,110,253,0.10); color: #0d6efd; }
.hl-green  { background: rgba(25,135,84,0.10);  color: #198754; }
.hl-orange { background: rgba(253,126,20,0.10); color: #fd7e14; }
.hl-pink   { background: rgba(214,51,132,0.10); color: #d63384; }
.hl-purple { background: rgba(111,66,193,0.10); color: #6f42c1; }
.hl-yellow { background: rgba(255,193,7,0.13);  color: #c49a00; }
.hl-teal   { background: rgba(13,202,240,0.10); color: #0d8daa; }

/* CTA Row */
.story-cta-row {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    align-items: center;
}

/* ══ Responsive ═════════════════════════════════ */
@media (max-width: 991px) {
    .rk-our-story-section { padding: 72px 0 80px; }

    .rk-story-visual {
        padding-right: 44px;
        padding-bottom: 72px;
        max-width: 480px;
        margin: 0 auto;
    }
}

@media (max-width: 575px) {
    .rk-our-story-section { padding: 56px 0 60px; }

    .rk-story-top-center { margin-bottom: 44px; }

    .rk-story-stat-strip {
        padding: 14px 16px;
        gap: 4px;
        border-radius: 14px;
    }
    .stat-strip-item   { padding: 4px 14px; }
    .stat-strip-num    { font-size: 1.25rem; }
    .stat-strip-sep    { display: none; }

    .story-img-main img  { height: 280px; }

    .story-exp-badge {
        top: 14px;
        left: -10px;
        min-width: 78px;
        padding: 10px 12px;
    }
    .story-exp-badge .exp-num { font-size: 1.4rem; }

    .story-img-float { width: 150px; }
    .story-img-float img { height: 120px; }

    .story-float-card  { min-width: 160px; left: 10px; }

    .rk-story-highlights { grid-template-columns: 1fr; }

    .story-cta-row { flex-direction: column; align-items: stretch; }
    .story-cta-row .rk-btn-primary,
    .story-cta-row .rk-btn-outline { text-align: center; justify-content: center; }
}

/* ════════════════════════════════════════════════
   AWARDS & ACCREDITATIONS OVERRIDE (Top Icon Layout)
════════════════════════════════════════════════ */
.rk-award-card {
    display: flex !important;
    flex-direction: column !important; /* Forces top-to-bottom */
    align-items: center !important;    /* Centers horizontally */
    text-align: center;                /* Centers text */
    background: #fff;
    padding: 40px 24px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.06);
    border: 1px solid #eef0f4;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.rk-award-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 50px rgba(0,0,0,0.1);
}

.rk-award-card .aw-icon {
    width: 72px;
    height: 72px;
    background: linear-gradient(135deg, #dc3545, #b02a37);
    color: #fff;
    font-size: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 18px;
    margin-bottom: 24px; /* Space between icon and text */
    box-shadow: 0 10px 24px rgba(220,53,69,0.35);
}

.rk-award-card .aw-content h4 {
    font-size: 1.15rem;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 12px;
    line-height: 1.4;
}

.rk-award-card .aw-content p {
    font-size: 0.9rem;
    color: #5a5a78;
    line-height: 1.7;
    margin-bottom: 0;
}
    </style>
</head>

<body>



    <div class="main-wrapper">

        <?php include 'include/header.php'; ?>

        <section class="contact-hero-banner">
            <img src="<?= $base_url ?>assets/img/home/image-crousel2.webp" alt="RK Hospital Nagpur About Us" class="banner-img">
            <div class="banner-grid-pattern"></div>
            <div class="banner-overlay"></div>

            <div class="banner-stat-badge badge-left">
                <div class="badge-icon"><i class="fa-solid fa-award"></i></div>
                <div class="badge-text">
                    <div class="num">25+</div>
                    <div class="label">Years of Excellence</div>
                </div>
            </div>

            <div class="banner-stat-badge badge-right">
                <div class="badge-icon"><i class="fa-solid fa-star"></i></div>
                <div class="badge-text">
                    <div class="num">5.0 ★</div>
                    <div class="label">496+ Reviews</div>
                </div>
            </div>

            <div class="banner-content">
                <div class="banner-eyebrow">
                    <i class="fa-solid fa-hospital"></i>
                    Dr. Agrawal's R.K. Hospital, Nagpur
                </div>
                <h1 class="banner-heading">
                    About Our<br>
                    <span>Hospital & Doctors</span>
                </h1>
                <p class="banner-sub">
                    Over 25 years of compassionate care in Orthopedic Surgery, Robotic Knee Replacement, Gynecology &amp; Pregnancy Care — trusted by thousands of families in Nagpur.
                </p>
                <div class="banner-cta-group">
                    <a href="tel:+919766057372" class="banner-btn-primary">
                        <i class="fa-solid fa-phone"></i>
                        Call Now: +91 97660 57372
                    </a>
                    <a href="<?= $base_url ?>contact-us" class="banner-btn-outline">
                        <i class="fa-solid fa-calendar-check"></i>
                        Book Appointment
                    </a>
                </div>
            </div>
        </section>

        <div class="breadcrumb-strip">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $base_url ?>"><i class="fa-solid fa-house me-1"></i>Home</a></li>
                        <li class="breadcrumb-item active">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>

        </section>
        <section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-lg-6 col-md-12">
                <div class="about-img-info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="about-inner-img">
                                <div class="about-img">
                                    <img src="assets/img/home/about-doctor1.webp" class="img-fluid" alt="Orthopedic Surgeon in Nagpur RK Hospital">
                                </div>
                                <div class="about-img">
                                    <img src="assets/img/home/about-doctor3.webp" class="img-fluid" alt="Gynecology Treatment RK Hospital Nagpur">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="about-inner-img">
                                <div class="about-box">
                                    <h4>25+ Years of Medical Excellence in Nagpur</h4>
                                </div>
                                <div class="about-img">
                                    <img src="assets/img/home/about-doctor2.webp" class="img-fluid" alt="Robotic Knee Replacement Surgery Nagpur">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="section-inner-header about-inner-header">
                    <h6>About Dr. Agrawal's R.K. Hospital</h6>
                    <h2>
                        Leading Orthopedic & Gynecology Hospital in 
                        <span class="text-danger">Nagpur</span>
                    </h2>
                </div>

                <div class="about-content">
                    <div class="about-content-details" style="text-align: justify;">

                        <p>
                            Dr. Agrawal's R.K. Hospital is one of the most trusted and advanced healthcare centers in Nagpur, specializing in Orthopedics and Gynecology. Known for its excellence in robotic knee replacement, hip replacement, spine surgery, and trauma care, the hospital provides world-class treatment using modern technology and highly experienced specialists.
                        </p>

                        <p>
                            Our gynecology and obstetrics department offers comprehensive pregnancy care, high-risk pregnancy management, and advanced laparoscopic surgeries. With a strong focus on patient safety, hygiene, and personalized care, we ensure the best outcomes for both mother and baby.
                        </p>

                        <p>
                            With a 5-star patient rating and a reputation for successful surgeries, expert doctors, and supportive staff, R.K. Hospital stands as a leading choice for quality healthcare in Nagpur. We are available 24/7 for emergency services, ensuring timely and reliable medical care when you need it most.
                        </p>

                    </div>

                    <div class="about-contact">
                        <div class="about-contact-icon">
                            <span><i class="isax isax-call-calling5"></i></span>
                        </div>
                        <div class="about-contact-text">
                            <p>24/7 Emergency & Appointment</p>
                            <h4>+91 97660 57372</h4>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<section class="rk-our-story-section" aria-labelledby="story-heading">
    <div class="container">

        <div class="rk-story-top-center wow fadeInUp" data-wow-duration="0.9s">
            <div class="rk-section-eyebrow">Our Story</div>
            <h2 class="rk-story-main-heading" id="story-heading">
                Building a Legacy of <span class="accent">Healing &amp; Trust</span> in Nagpur
            </h2>
            <p class="rk-story-intro-text">
                Dr. Agrawal's R.K. Hospital was founded with a single, unwavering commitment — to bring the
                highest standard of medical care within reach of every patient in Nagpur and the Vidarbha region.
                What began as a vision has grown into one of Nagpur's most trusted multi-specialty hospitals.
            </p>

            <div class="rk-story-stat-strip">
                <div class="stat-strip-item">
                    <div class="stat-strip-num">25+</div>
                    <div class="stat-strip-lbl">Years of Excellence</div>
                </div>
                <div class="stat-strip-sep"></div>
                <div class="stat-strip-item">
                    <div class="stat-strip-num">25K+</div>
                    <div class="stat-strip-lbl">Patients Treated</div>
                </div>
                <div class="stat-strip-sep"></div>
                <div class="stat-strip-item">
                    <div class="stat-strip-num">5.0★</div>
                    <div class="stat-strip-lbl">Google Rating</div>
                </div>
                <div class="stat-strip-sep"></div>
                <div class="stat-strip-item">
                    <div class="stat-strip-num">496+</div>
                    <div class="stat-strip-lbl">Verified Reviews</div>
                </div>
            </div>
        </div>
        <div class="rk-story-body-row">

            <div class="rk-story-img-col wow fadeInLeft" data-wow-duration="1s">
                <div class="rk-story-visual">

                    <div class="story-img-main">
                        <img
                            src="assets/img/about/hospital.jpeg"
                            alt="Dr. Rahul Agrawal — Best Orthopedic Surgeon Nagpur at R.K. Hospital"
                            loading="lazy"
                        >
                    </div>

                    </div>
            </div>
            <div class="rk-story-content-col wow fadeInRight" data-wow-duration="1s">

                <p class="story-body-lead">
                    Equipped with <strong>state-of-the-art robotic surgical technology</strong>, modular operation
                    theatres, and a team of highly experienced specialists who have collectively performed
                    thousands of successful surgeries across orthopedics and gynecology.
                </p>
                <p class="story-body-text">
                    From complex robotic knee and hip replacement surgeries to high-risk pregnancy management,
                    spine treatment, and advanced laparoscopic gynecology — we are a complete healthcare
                    destination for patients across Nagpur, Wardha, Amravati, and beyond.
                </p>

                <div class="rk-story-highlights">

                    <div class="story-hl-item">
                        <div class="hl-icon hl-red"><i class="fa-solid fa-robot"></i></div>
                        <span>Robotic Joint Replacement</span>
                    </div>
                    <div class="story-hl-item">
                        <div class="hl-icon hl-blue"><i class="fa-solid fa-kit-medical"></i></div>
                        <span>Modular Operation Theatres</span>
                    </div>
                    <div class="story-hl-item">
                        <div class="hl-icon hl-green"><i class="fa-solid fa-shield-halved"></i></div>
                        <span>Cashless Insurance Facility</span>
                    </div>
                    <div class="story-hl-item">
                        <div class="hl-icon hl-orange"><i class="fa-solid fa-truck-medical"></i></div>
                        <span>24/7 Emergency &amp; Trauma Care</span>
                    </div>
                    <div class="story-hl-item">
                        <div class="hl-icon hl-pink"><i class="fa-solid fa-baby"></i></div>
                        <span>High-Risk Pregnancy Care</span>
                    </div>
                    <div class="story-hl-item">
                        <div class="hl-icon hl-purple"><i class="fa-solid fa-stethoscope"></i></div>
                        <span>Advanced Laparoscopic Surgery</span>
                    </div>
                    <div class="story-hl-item">
                        <div class="hl-icon hl-yellow"><i class="fa-solid fa-star"></i></div>
                        <span>5★ Rated Patient Care</span>
                    </div>
                    <div class="story-hl-item">
                        <div class="hl-icon hl-teal"><i class="fa-solid fa-user-doctor"></i></div>
                        <span>Experienced Specialist Doctors</span>
                    </div>

                </div>
                <div class="story-cta-row">
                    <a href="contact-us" class="rk-btn-primary">
                        <i class="fa-solid fa-calendar-check"></i>
                        Book Appointment
                    </a>
                    <a href="tel:+919766057372" class="rk-btn-outline">
                        <i class="fa-solid fa-phone"></i>
                        Call: +91 97660 57372
                    </a>
                </div>

            </div>
            </div>
        </div>
</section>
<section class="rk-awards-section" aria-labelledby="awards-heading">
            <div class="container">
                <div class="rk-section-header center">
                    <div class="rk-section-eyebrow">Recognition &amp; Trust</div>
                    <h2 class="rk-heading" id="awards-heading">
                        Awards &amp; <span class="accent">Accreditations</span>
                    </h2>
                    <p class="lead">
                        Our commitment to excellence has earned us recognition from patients and the medical community alike — consistently rated among the best hospitals in Nagpur.
                    </p>
                </div>

                <div class="row g-4">

                    <div class="col-lg-3 col-md-6 d-flex">
                        <div class="rk-award-card w-100 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                            <div class="aw-icon" aria-hidden="true"><i class="fa-solid fa-star"></i></div>
                            <div class="aw-content">
                                <h4>5-Star Google Rating</h4>
                                <p>496+ verified patient reviews with consistent 5-star ratings on Google for orthopedic and gynecology care.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex">
                        <div class="rk-award-card w-100 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                            <div class="aw-icon" aria-hidden="true"><i class="fa-solid fa-certificate"></i></div>
                            <div class="aw-content">
                                <h4>Fellowship in Joint Replacement</h4>
                                <p>Dr. Rahul Agrawal holds FIJR fellowship — specialized advanced training in joint replacement surgery.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex">
                        <div class="rk-award-card w-100 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                            <div class="aw-icon" aria-hidden="true"><i class="fa-solid fa-shield-halved"></i></div>
                            <div class="aw-content">
                                <h4>Cashless Insurance Empanelled</h4>
                                <p>Empanelled with major TPA and insurance companies for seamless, cashless treatment across all services.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex">
                        <div class="rk-award-card w-100 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">
                            <div class="aw-icon" aria-hidden="true"><i class="fa-solid fa-trophy"></i></div>
                            <div class="aw-content">
                                <h4>Trusted by 25,000+ Patients</h4>
                                <p>Over 25 years of consistent care, thousands of successful surgeries, and a loyal patient base across Vidarbha.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>

        <?php include 'include/footer.php'; ?>

    </div>
    <div class="offcanvas offcanvas-offset offcanvas-end support_popup" tabindex="-1" id="support_item">
        <div class="offcanvas-header">
            <a href="/">
                <img src="<?php echo $base_url; ?>assets/img/logo.svg" alt="RK Hospital Nagpur Logo" class="img-fluid logo">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="isax isax-close-circle"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="about-popup-item">
                <h3 class="title">About R.K. Hospital</h3>
                <p>Nagpur's leading orthopedic &amp; gynecology hospital — delivering world-class surgical care since 1999.</p>
            </div>
            <div class="about-popup-item">
                <h3 class="title">Our Location</h3>
                <div class="loction-item">
                    <h4 class="title">Nagpur, Maharashtra</h4>
                    <p class="location">27, Chandrashekhar Azad Square, Central Avenue Road, Beside Hotel Al Zam Zam, Gandhibagh, Nagpur — 440002</p>
                </div>
            </div>
            <div class="about-popup-item">
                <h3 class="title">Contact Information</h3>
                <div class="support-item mb-3">
                    <div class="avatar avatar-lg bg-primary rounded-circle">
                        <i class="isax isax-call-calling"></i>
                    </div>
                    <div>
                        <p class="title">Emergency &amp; Appointments</p>
                        <h5 class="link"><a href="tel:+919766057372">+91 97660 57372</a></h5>
                    </div>
                </div>
                <div class="support-item">
                    <div class="avatar avatar-lg bg-primary rounded-circle">
                        <i class="isax isax-headphone5"></i>
                    </div>
                    <div>
                        <p class="title">Alternate Number</p>
                        <h5 class="link"><a href="tel:+918999290433">+91 89992 90433</a></h5>
                    </div>
                </div>
            </div>
            <div class="about-popup-item border-0">
                <h3 class="title">Follow Us</h3>
                <ul class="d-flex align-items-center gap-2 social-iyem">
                    <li><a href="#" class="social-icon" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a></li>
                    <li><a href="#" class="social-icon" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="#" class="social-icon" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
        <img src="<?php echo $base_url; ?>assets/img/bg/offcanvas-bg.png" alt="" class="element-01" aria-hidden="true">
    </div>

    <div class="progress-wrap active-progress">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102" aria-hidden="true">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition:stroke-dashoffset 10ms linear;stroke-dasharray:307.919px,307.919px;stroke-dashoffset:228.265px;">
            </path>
        </svg>
    </div>

    <script src="<?php echo $base_url; ?>assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/feather.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/backToTop.js"></script>
    <script src="<?php echo $base_url; ?>assets/plugins/fancybox/jquery.fancybox.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/counter.js"></script>
    <script src="<?php echo $base_url; ?>assets/plugins/wow/js/wow.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/script.js"></script>
    <script>
        // Initialize WOW.js animations
        new WOW().init();
    </script>

</body>
</html>