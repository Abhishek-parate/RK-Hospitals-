<?php $base_url = "http://localhost/rkhospital/"; ?>
<?php include 'include/config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Contact Dr. Agrawal's R.K. Hospital Nagpur. Book appointment for Orthopedic Surgery, Robotic Knee Replacement, Gynecology & Pregnancy Care. Call +91 97660 57372. Located at Central Avenue, Nagpur.">
    <meta name="keywords"
        content="RK Hospital Nagpur contact, Dr Agrawal hospital appointment, orthopedic hospital contact Nagpur, gynecology hospital Nagpur, contact RK hospital">
    <meta name="author" content="Dr. Agrawal's R.K. Hospital Nagpur">
    <meta property="og:title" content="Contact Us | Dr. Agrawal's R.K. Hospital Nagpur">
    <meta property="og:description"
        content="Book appointment for Orthopedic Surgery, Robotic Knee Replacement, Gynecology & Pregnancy Care. Available 24/7.">
    <title>Contact Us | Dr. Agrawal's R.K. Hospital Nagpur</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/img/RK-Logo.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $base_url; ?>assets/img/RK-Logo.png">

    <!-- Theme Settings Js -->
    <script src="assets/js/theme-script.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/animate.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fontawesome/css/all.min.css">

    <!-- Iconsax CSS-->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/iconsax.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/feather.css">

    <!-- Slick CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/slick/slick.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/slick/slick-theme.css">

    <!-- Wow CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/wow/css/animate.css">

    <!-- select CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/select2/css/select2.min.css">

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fancybox/jquery.fancybox.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">

    <style>
    /* ═══════════════════════════════════════════
       THEME VARIABLES & DOCTOR CARD STYLES
    ═══════════════════════════════════════════ */
    :root {
        --red: #d32f2f;
        --red-dark: #b71c1c;
        --red-light: #ef5350;
        --red-bg: #fff5f5;
        --red-border: #fecaca;
        --text-dark: #1a1a2e;
        --text-mid: #374151;
        --text-soft: #6b7280;
        --white: #ffffff;
        --border: #e5e7eb;
        --shadow-sm: 0 2px 12px rgba(211, 47, 47, 0.08);
        --shadow-lg: 0 16px 48px rgba(211, 47, 47, 0.18);
    }

    .rk-eyebrow {
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--red);
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }

    .rk-eyebrow::before {
        content: '';
        width: 30px;
        height: 3px;
        background: var(--red);
        border-radius: 2px;
        flex-shrink: 0;
    }

    .rk-section-title {
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 6px;
        line-height: 1.25;
    }

    .rk-section-title span {
        color: var(--red);
    }

    /* DOCTOR CARD */
    .doc-card {
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        transition: all 0.32s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .doc-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-6px);
        border-color: var(--red-border);
    }

    .doc-banner {
        background: linear-gradient(135deg, #7f0000 0%, #c62828 100%);
        padding: 36px 28px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .doc-banner .deco-ring {
        position: absolute;
        border: 2px solid rgba(255, 255, 255, 0.07);
        border-radius: 50%;
    }

    .doc-banner .deco-ring.r1 {
        width: 180px;
        height: 180px;
        top: -60px;
        right: -50px;
    }

    .doc-banner .deco-ring.r2 {
        width: 110px;
        height: 110px;
        bottom: 10px;
        left: -30px;
    }

    .doc-banner::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 38px;
        background: var(--white);
        border-radius: 50% 50% 0 0 / 30px 30px 0 0;
    }

    .doc-photo-wrap {
        display: inline-block;
        position: relative;
        z-index: 2;
        margin-bottom: 8px;
    }

    .doc-photo-wrap img {
        width: 155px;
        height: 155px;
        border-radius: 50%;
        object-fit: cover;
        object-position: top;
        border: 5px solid #fff;
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.25);
        display: block;
    }

    .doc-photo-wrap::before {
        content: '';
        position: absolute;
        inset: -6px;
        border-radius: 50%;
        border: 3px solid rgba(255, 255, 255, 0.35);
    }

    .doc-spec-badge {
        position: absolute;
        bottom: 2px;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        background: linear-gradient(135deg, var(--red-dark), var(--red));
        color: #fff;
        font-size: 10.5px;
        font-weight: 700;
        padding: 4px 14px;
        border-radius: 100px;
        box-shadow: 0 3px 12px rgba(183, 28, 28, 0.45);
    }

    .doc-body {
        padding: 16px 26px 28px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .doc-name {
        font-size: 1.22rem;
        font-weight: 800;
        color: var(--text-dark);
        text-align: center;
        margin-bottom: 2px;
    }

    .doc-degree {
        font-size: 12px;
        color: var(--text-soft);
        text-align: center;
        margin-bottom: 16px;
    }

    .doc-hr {
        height: 1px;
        background: var(--border);
        margin: 0 0 15px;
    }

    .doc-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-bottom: 16px;
    }

    .doc-tag {
        background: var(--red-bg);
        color: var(--red-dark);
        font-size: 11px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 100px;
        border: 1px solid var(--red-border);
    }

    .doc-bio {
        font-size: 13.5px;
        color: var(--text-mid);
        line-height: 1.75;
        margin-bottom: 18px;
        flex: 1;
    }

    .doc-info-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        background: var(--red-bg);
        border: 1px solid var(--red-border);
        border-radius: 11px;
        padding: 12px 15px;
        margin-bottom: 20px;
    }

    .doc-info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: var(--text-mid);
    }

    .doc-info-item i {
        color: var(--red);
        font-size: 13px;
    }

    .doc-info-item strong {
        color: var(--text-dark);
    }

    .doc-actions {
        display: flex;
        gap: 10px;
    }

    .btn-rk-primary {
        flex: 1;
        display: block;
        text-align: center;
        background: linear-gradient(135deg, var(--red-dark), var(--red-light));
        color: #fff !important;
        font-size: 13.5px;
        font-weight: 700;
        padding: 12px 16px;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 4px 16px rgba(183, 28, 28, 0.32);
    }

    .btn-rk-primary:hover {
        background: linear-gradient(135deg, #7f0000, var(--red-dark));
        box-shadow: 0 6px 22px rgba(183, 28, 28, 0.45);
        transform: translateY(-1px);
    }

    .btn-rk-outline {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 12px 16px;
        border-radius: 10px;
        border: 2px solid var(--red);
        color: var(--red);
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
    }

    .btn-rk-outline:hover {
        background: var(--red);
        color: #fff;
    }

    @media (max-width: 768px) {
        .doc-actions {
            flex-direction: column;
        }

        .doc-info-strip {
            flex-direction: column;
            gap: 10px;
        }
    }
    .doc-read-more-btn {
    background: none;
    border: none;
    color: #c0392b;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 4px 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 4px;
}
.doc-read-more-btn:hover { text-decoration: underline; }
.doc-read-more-btn i { font-size: 0.7rem; transition: transform 0.2s; }
.doc-read-more-btn.open i { transform: rotate(180deg); }
    </style>
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">


        <?php include 'include/header.php'; ?>

        <!-- ═══════════════════════ HERO BANNER ═══════════════════════ -->
        <section class="contact-hero-banner">
            <img src="assets/img/home/image-crousel1.webp" alt="RK Hospital Nagpur Contact" class="banner-img">
            <div class="banner-grid-pattern"></div>
            <div class="banner-overlay"></div>

            <!-- Floating Stat Badges -->
            <div class="banner-stat-badge badge-left">
                <div class="badge-icon"><i class="fa-solid fa-star"></i></div>
                <div class="badge-text">
                    <div class="num">5.0 ★</div>
                    <div class="label">496+ Reviews</div>
                </div>
            </div>

            <div class="banner-stat-badge badge-right">
                <div class="badge-icon"><i class="fa-solid fa-clock"></i></div>
                <div class="badge-text">
                    <div class="num">24/7</div>
                    <div class="label">Emergency Care</div>
                </div>
            </div>

            <div class="banner-content">
                <div class="banner-eyebrow">
                    <i class="fa-solid fa-hospital"></i>
                    Dr. Agrawal's R.K. Hospital, Nagpur
                </div>
                <h1 class="banner-heading">
                    Get In Touch With<br>
                    <span>Our Specialists</span>
                </h1>
                <p class="banner-sub">
                    Book an appointment for Orthopedic Surgery, Robotic Knee Replacement, Gynecology & Pregnancy Care.
                    Available 24/7 for emergencies.
                </p>
                <div class="banner-cta-group">
                    <a href="tel:+919766057372" class="banner-btn-primary">
                        <i class="fa-solid fa-phone"></i>
                        Call Now: +91 97660 57372
                    </a>
                    <a href="#contact-form" class="banner-btn-outline">
                        <i class="fa-solid fa-calendar-check"></i>
                        Book Appointment
                    </a>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════ BREADCRUMB ═══════════════════════ -->
        <div class="breadcrumb-strip">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/"><i class="fa-solid fa-house me-1"></i>Home</a></li>
                        <li class="breadcrumb-item active">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- ═══════════════════════ QUICK INFO STRIP ═══════════════════════ -->
        <div class="quick-info-strip">
            <div class="quick-info-grid">
                <div class="quick-info-item">
                    <div class="qi-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="qi-text">
                        <div class="label">Our Location</div>
                        <div class="value">Central Avenue, Gandhibagh, Nagpur 440002</div>
                    </div>
                </div>
                <div class="quick-info-item">
                    <div class="qi-icon"><i class="fa-solid fa-phone-volume"></i></div>
                    <div class="qi-text">
                        <div class="label">Emergency & Appointment</div>
                        <div class="value">
                            <a href="tel:+919766057372">+91 97660 57372  </a>
                        </div>
                    </div>
                </div>
                <div class="quick-info-item">
                    <div class="qi-icon"><i class="fa-solid fa-clock"></i></div>
                    <div class="qi-text">
                        <div class="label">OPD Timings</div>
                        <div class="value">11AM–4PM · 7PM–9PM (Mon–Sat)</div>
                    </div>
                </div>
                <div class="quick-info-item">
                    <div class="qi-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <div class="qi-text">
                        <div class="label">Emergency Services</div>
                        <div class="value"><span class="open-badge">Open 24/7</span>&nbsp; Always Available</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════ MAIN CONTACT SECTION ═══════════════════════ -->
        <section class="contact-main-section" id="contact-form">
            <div class="container">

                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <div class="rk-eyebrow justify-content-center">Contact Information</div>
                        <h2 class="rk-section-title">We're Here To <span>Help You</span></h2>
                        <p style="color:var(--text-soft); font-size:15px; max-width:560px; margin: 8px auto 0;">
                            Reach out to our team for appointments, inquiries, or emergency care. We respond promptly.
                        </p>
                    </div>
                </div>

                <div class="row g-4">

                    <!-- LEFT: Contact Info Cards + Emergency -->
                    <div class="col-lg-5">

                        <!-- Address Card -->
                        <div class="row g-3">
                            <div class="col-12 wow fadeInLeft" data-wow-duration="0.8s">
                                <div class="contact-info-card">
                                    <div class="card-badge"><i class="fa-solid fa-location-dot"></i> Hospital Location
                                    </div>
                                    <div class="card-icon-wrap">
                                        <i class="fa-solid fa-building-columns"></i>
                                    </div>
                                    <h4>Hospital Address</h4>
                                    <p>27, Chandrashekhar Azad Square,<br>
                                        Central Avenue Road,<br>
                                        Beside Hotel Al Zam Zam, Gandhibagh,<br>
                                        Nagpur, Maharashtra – 440002</p>
                                    <a href="https://maps.google.com/?q=Dr.Agrawal%27s+R.K.Hospital+Nagpur"
                                        target="_blank" rel="noopener"
                                        style="color:var(--red); font-weight:700; margin-top:8px; display:inline-flex; align-items:center; gap:6px; font-size:13px;">
                                        <i class="fa-solid fa-diamond-turn-right"></i> Get Directions
                                    </a>
                                </div>
                            </div>

                            <!-- Phone Card -->
                            <div class="col-12 wow fadeInLeft" data-wow-duration="0.8s" data-wow-delay="0.1s">
                                <div class="contact-info-card">
                                    <div class="card-badge"><i class="fa-solid fa-phone"></i> Call Us</div>
                                    <div class="card-icon-wrap outline-style">
                                        <i class="fa-solid fa-phone-volume"></i>
                                    </div>
                                    <h4>Phone Numbers</h4>
                                    <a href="tel:+919766057372"
                                        style="font-weight:700; font-size:16px; color:var(--red);">+91 97660 57372</a>
                                 
                                    <p style="margin-top:10px; font-size:12.5px; color:var(--text-soft);">Available 24/7
                                        for Emergency · OPD: 11AM–4PM & 7PM–9PM</p>
                                </div>
                            </div>

                            <!-- OPD Timings Card -->
                            <div class="col-12 wow fadeInLeft" data-wow-duration="0.8s" data-wow-delay="0.2s">
                                <div class="contact-info-card">
                                    <div class="card-badge"><i class="fa-solid fa-calendar"></i> OPD Schedule</div>
                                    <div class="card-icon-wrap outline-style">
                                        <i class="fa-solid fa-clock"></i>
                                    </div>
                                    <h4>Working Hours</h4>
                                    <table class="opd-table">
                                        <tr>
                                            <td>Monday – Saturday</td>
                                            <td>11AM – 4PM</td>
                                        </tr>
                                        <tr>
                                            <td>Monday – Saturday</td>
                                            <td>7PM – 9PM</td>
                                        </tr>
                                        <tr>
                                            <td>Sunday</td>
                                            <td>By Appointment</td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Services</td>
                                            <td><span class="open-badge">24/7 Open</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Social Card -->
                            <div class="col-12 wow fadeInLeft" data-wow-duration="0.8s" data-wow-delay="0.3s">
                                <div class="sidebar-card">
                                    <h5><i class="fa-solid fa-share-nodes"></i> Connect With Us</h5>
                                    <div class="social-links-grid">
                                        <a href="#" class="social-link-card fb" target="_blank">
                                            <i class="fa-brands fa-facebook"></i> Facebook
                                        </a>
                                        <a href="#" class="social-link-card ig" target="_blank">
                                            <i class="fa-brands fa-instagram"></i> Instagram
                                        </a>
                                        <a href="https://wa.me/919766057372" class="social-link-card wa"
                                            target="_blank">
                                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                        </a>
                                        <a href="#" class="social-link-card yt" target="_blank">
                                            <i class="fa-brands fa-youtube"></i> YouTube
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- RIGHT: Contact Form -->
                    <div class="col-lg-7 wow fadeInRight" data-wow-duration="0.8s">
                        <div class="form-section-wrap">
                            <div class="form-section-header">
                                <h3>Book an Appointment</h3>
                                <p>Fill in the form and our team will get back to you within 30 minutes during OPD
                                    hours.</p>
                            </div>
                            <div class="form-section-body">
                                <form action="#" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="rk-form-group">
                                                <label>Full Name <span class="req">*</span></label>
                                                <input type="text" name="name" class="rk-form-control"
                                                    placeholder="e.g. Ramesh Sharma" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="rk-form-group">
                                                <label>Phone Number <span class="req">*</span></label>
                                                <input type="tel" name="phone" class="rk-form-control"
                                                    placeholder="+91 XXXXX XXXXX" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="rk-form-group">
                                                <label>Email Address</label>
                                                <input type="email" name="email" class="rk-form-control"
                                                    placeholder="your@email.com">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="rk-form-group">
                                                <label>Preferred Date</label>
                                                <input type="date" name="date" class="rk-form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="rk-form-group">
                                                <label>Choose Department / Service <span class="req">*</span></label>
                                                <div class="service-checkboxes">
                                                    <div class="service-checkbox-item">
                                                        <input type="checkbox" id="s1" name="service[]"
                                                            value="Robotic Knee Replacement">
                                                        <label for="s1">Robotic Knee Replacement</label>
                                                    </div>
                                                    <div class="service-checkbox-item">
                                                        <input type="checkbox" id="s2" name="service[]"
                                                            value="Hip Replacement">
                                                        <label for="s2">Hip Replacement Surgery</label>
                                                    </div>
                                                    <div class="service-checkbox-item">
                                                        <input type="checkbox" id="s3" name="service[]"
                                                            value="Spine Surgery">
                                                        <label for="s3">Spine & Back Pain</label>
                                                    </div>
                                                    <div class="service-checkbox-item">
                                                        <input type="checkbox" id="s4" name="service[]"
                                                            value="Fracture & Trauma">
                                                        <label for="s4">Fracture & Trauma Care</label>
                                                    </div>
                                                    <div class="service-checkbox-item">
                                                        <input type="checkbox" id="s5" name="service[]"
                                                            value="Pregnancy Care">
                                                        <label for="s5">Pregnancy & Delivery</label>
                                                    </div>
                                                    <div class="service-checkbox-item">
                                                        <input type="checkbox" id="s6" name="service[]"
                                                            value="Gynecology">
                                                        <label for="s6">Gynecology / PCOS</label>
                                                    </div>
                                                    <div class="service-checkbox-item">
                                                        <input type="checkbox" id="s7" name="service[]"
                                                            value="Infertility">
                                                        <label for="s7">Infertility Treatment</label>
                                                    </div>
                                                    <div class="service-checkbox-item">
                                                        <input type="checkbox" id="s8" name="service[]"
                                                            value="Laparoscopy">
                                                        <label for="s8">Laparoscopic Surgery</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="rk-form-group">
                                                <label>Your Message / Symptoms</label>
                                                <textarea name="message" class="rk-form-control"
                                                    placeholder="Briefly describe your condition or any specific queries..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn-submit-rk">
                                                Send Appointment Request
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </button>
                                            <div class="form-trust-badges">
                                                <div class="trust-badge">
                                                    <i class="fa-solid fa-shield-halved"></i>
                                                    100% Confidential
                                                </div>
                                                <div class="trust-badge">
                                                    <i class="fa-solid fa-bolt"></i>
                                                    Reply within 30 mins
                                                </div>
                                                <div class="trust-badge">
                                                    <i class="fa-solid fa-star"></i>
                                                    5★ Rated Hospital
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <!-- ═══════════════════════ DOCTORS STRIP ═══════════════════════ -->
        <section class="doctors-strip">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <div class="rk-eyebrow justify-content-center" style="color:#ff8a80;">Our Specialists</div>
                        <h2 class="rk-section-title" style="color:#fff; font-family:'Playfair Display',serif;">
                            Contact Our <span style="color:#ff8a80; font-style:italic;">Expert Doctors</span> Directly
                        </h2>
                    </div>
                </div>
                <?php
                $doc_sql    = "SELECT * FROM doctors WHERE is_published = 1 ORDER BY id ASC";
                $doc_result = $conn->query($doc_sql);
                $doc_count  = $doc_result ? $doc_result->num_rows : 0;

                // Responsive column width based on total doctor count
                if ($doc_count === 1)      $col_class = 'col-lg-8 col-md-10';
                elseif ($doc_count === 2)  $col_class = 'col-lg-6';
                elseif ($doc_count === 3)  $col_class = 'col-lg-4 col-md-6';
                else                       $col_class = 'col-lg-3 col-md-6';
                ?>

                <div class="row g-4 justify-content-center mb-5">

                    <?php if ($doc_count > 0): ?>
                    <?php while ($doc = $doc_result->fetch_assoc()): ?>

                    <?php
                        // Tags: comma-separated string -> up to 6 badge spans
                        $tags_html = '';
                        if (!empty($doc['tags'])) {
                            $tag_arr = array_slice(
                                array_filter(array_map('trim', explode(',', $doc['tags']))),
                                0, 6
                            );
                            foreach ($tag_arr as $t) {
                                $tags_html .= '<span class="doc-tag">' . htmlspecialchars($t) . '</span>';
                            }
                        }

                        // Photo: DB stores full relative path or just filename
                        $photo = !empty($doc['photo']) ? $doc['photo'] : 'assets/img/patients/default.jpg';
                        if (strpos($photo, 'assets/') !== 0 && strpos($photo, 'http') !== 0) {
                            $photo = 'assets/img/doctors/' . $photo;
                        }

                        // Bio: prefer bio column, fall back to excerpt
                        $bio_text = !empty($doc['bio']) ? $doc['bio'] : ($doc['excerpt'] ?? '');

                        // Location fallback
                        $location = !empty($doc['location']) ? htmlspecialchars($doc['location']) : 'Nagpur';
                    ?>

                    <div class="<?= $col_class ?>">
                        <div class="doc-card">

                            <div class="doc-banner">
                                <div class="deco-ring r1"></div>
                                <div class="deco-ring r2"></div>
                                <div class="doc-photo-wrap">
                                    <img src="<?= htmlspecialchars($photo) ?>"
                                        alt="<?= htmlspecialchars($doc['name']) ?> – <?= htmlspecialchars($doc['designation'] ?? '') ?>">
                                    <span
                                        class="doc-spec-badge"><?= htmlspecialchars($doc['designation'] ?? $doc['specialty'] ?? '') ?></span>
                                </div>
                            </div>

                            <div class="doc-body">
                                <div class="doc-name"><?= htmlspecialchars($doc['name']) ?></div>
                                <div class="doc-degree"><?= htmlspecialchars($doc['specialty'] ?? '') ?></div>
                                <div class="doc-hr"></div>

                                <?php if ($tags_html): ?>
                                <div class="doc-tags">
                                    <?= $tags_html ?>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($bio_text)): ?>
                                <p class="doc-bio" style="text-align:justify;">
                                    <?= nl2br(htmlspecialchars($bio_text)) ?>
                                </p>
                                <?php endif; ?>

                                <div class="doc-info-strip">
                                    <div class="doc-info-item">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span><?= $location ?></span>
                                    </div>
                                    <?php if (!empty($doc['consultation_fee'])): ?>
                                    <div class="doc-info-item">
                                        <i class="fa-solid fa-indian-rupee-sign"></i>
                                        <span>Consultation:
                                            <strong>₹<?= htmlspecialchars($doc['consultation_fee']) ?></strong></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
             
                                <div class="doc-actions">
                                    <a href="<?= SITE_URL ?>/doctors/<?= urlencode($doc['slug']) ?>"
                                        class="btn-rk-primary">
                                        View Profile
                                    </a>
                                    <a href="#contact-form" class="btn-rk-outline">
                                        <i class="fa-solid fa-calendar-check"></i> Book
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php endwhile; ?>

                    <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Doctor profiles coming soon. Please check back later.</p>
                    </div>
                    <?php endif; ?>

                </div>

                <!-- Emergency CTA -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="emergency-cta wow fadeInUp" data-wow-duration="0.8s">
                            <div class="emergency-icon">
                                <i class="fa-solid fa-truck-medical"></i>
                            </div>
                            <div class="emergency-text">
                                <h4>Medical Emergency? Call Immediately!</h4>
                                <p>24/7 Emergency services for accidents, fractures, trauma, and pregnancy emergencies
                                    in Nagpur</p>
                                <div class="emergency-numbers">
                                    <a href="tel:+919766057372" class="emergency-num-link">
                                        <i class="fa-solid fa-phone"></i> +91 97660 57372
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ═══════════════════════ MAP SECTION ═══════════════════════ -->
        <div class="map-section">
            <div class="container">

                <!-- Map iframe — clean, no floating card on top -->
                <div class="map-iframe-wrap wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s"
                    style="margin-bottom: 0; padding-bottom: 0;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.1061519931973!2d79.10822074564915!3d21.14817342644816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd4c79a161b6283%3A0xb92548dea3dc4756!2sDr.Agrawal&#39;s%20R.K.Hospital!5e0!3m2!1sen!2sin!4v1773395830626!5m2!1sen!2sin"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="RK Hospital Nagpur Location Map">
                    </iframe>
                </div>

            </div>
        </div>

        <?php include 'include/footer.php'; ?>

        <!-- Cursor -->
        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>
    </div>
    <!-- /Main Wrapper -->

    <!-- Offcanvas (same as index) -->
    <div class="offcanvas offcanvas-offset offcanvas-end support_popup" tabindex="-1" id="support_item">
        <div class="offcanvas-header">
            <a href="/"><img src="assets/img/logo.svg" alt="logo" class="img-fluid logo"></a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="isax isax-close-circle"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="about-popup-item">
                <h3 class="title">About RK Hospital</h3>
                <p>Leading Orthopedic & Gynecology Hospital in Nagpur with 25+ years of medical excellence.</p>
                <div class="about-img d-flex align-items-center gap-2 justify-content-between">
                    <img src="assets/img/home/about-doctor1.webp" alt="RK Hospital" class="img-fluid"
                        style="border-radius:8px;">
                    <img src="assets/img/home/about-doctor2.webp" alt="RK Hospital" class="img-fluid"
                        style="border-radius:8px;">
                    <img src="assets/img/home/about-doctor3.webp" alt="RK Hospital" class="img-fluid"
                        style="border-radius:8px;">
                </div>
            </div>
            <div class="about-popup-item">
                <h3 class="title">Hospital Address</h3>
                <p>27, Chandrashekhar Azad Square, Central Avenue Road, Nagpur 440002</p>
            </div>
            <div class="about-popup-item">
                <h3 class="title">Contact Information</h3>
                <div class="support-item mb-3">
                    <div class="avatar avatar-lg bg-primary rounded-circle">
                        <i class="isax isax-call-calling"></i>
                    </div>
                    <div>
                        <p class="title">Emergency Cases</p>
                        <h5 class="link"><a href="tel:+919766057372">+91 97660 57372</a></h5>
                    </div>
                </div>
            </div>
            <div class="about-popup-item border-0">
                <h3 class="title">Follow Us</h3>
                <ul class="d-flex align-items-center gap-2 social-iyem">
                    <li><a href="#" class="social-icon"><i class="fa-brands fa-facebook"></i></a></li>
                    <li><a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="https://wa.me/919766057372" class="social-icon" target="_blank"><i
                                class="fa-brands fa-whatsapp"></i></a></li>
                </ul>
            </div>
        </div>
        <img src="assets/img/bg/offcanvas-bg.png" alt="element" class="element-01">
    </div>

    <!-- ScrollToTop -->
    <div class="progress-wrap active-progress">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919px, 307.919px; stroke-dashoffset: 228.265px;">
            </path>
        </svg>
    </div>

    <!-- jQuery -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- Feather Icon JS -->
    <script src="assets/js/feather.min.js"></script>
    <!-- BacktoTop JS -->
    <script src="assets/js/backToTop.js"></script>
    <!-- Slick Slider -->
    <script src="assets/plugins/slick/slick.min.js"></script>
    <!-- Fancybox JS -->
    <script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>
    <!-- Wow JS -->
    <script src="assets/plugins/wow/js/wow.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>

    <script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    </script>
</body>

</html>