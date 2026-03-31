<?php $base_url = "http://localhost/rkhospital/"; ?>
<?php include 'include/config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
    <meta name="keywords"
        content="practo clone, doccure, doctor appointment, Practo clone html template, doctor booking template">
    <meta name="author" content="Practo Clone HTML Template - Doctor Booking Template">
    <meta property="og:url" content="https://doccure.dreamstechnologies.com/html/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Doctors Appointment HTML Website Templates | Doccure">
    <meta property="og:description"
        content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
    <meta property="og:image" content="assets/img/preview-banner.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="https://doccure.dreamstechnologies.com/html/">
    <meta property="twitter:url" content="https://doccure.dreamstechnologies.com/html/">
    <meta name="twitter:title" content="Doctors Appointment HTML Website Templates | Doccure">
    <meta name="twitter:description"
        content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
    <meta name="twitter:image" content="assets/img/preview-banner.jpg">
    <title>Doccure</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/img/RK-Logo.png" type="image/x-icon">

    <!-- Apple Touch Icon -->
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

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
    <style>
    /* ═══════════════════════════════════════════
		   THEME VARIABLES — matches homepage red/white
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
        --off-white: #f9fafb;
        --border: #e5e7eb;
        --shadow-sm: 0 2px 12px rgba(211, 47, 47, 0.08);
        --shadow-md: 0 6px 28px rgba(211, 47, 47, 0.13);
        --shadow-lg: 0 16px 48px rgba(211, 47, 47, 0.18);
    }


    /* ─── SECTION LABEL (matches homepage "Our Specialty Services" style) ─── */
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


    /* ─── DOCTOR CARD ─── */
    .doc-card {
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        transition: all 0.32s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .doc-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-6px);
        border-color: var(--red-border);
    }

    /* Top red banner with photo — mirrors homepage card style */
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

    /* Red ring around photo — matches homepage circular photo style */
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
        letter-spacing: 0.4px;
    }

    /* Card body */
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

    /* Specialty tags — pill style matching homepage badges */
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

    /* Info strip */
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

    /* Buttons — red gradient matching homepage CTA */
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
        transition: all 0.22s;
        box-shadow: 0 4px 16px rgba(183, 28, 28, 0.32);
        letter-spacing: 0.3px;
    }

    .btn-rk-primary:hover {
        background: linear-gradient(135deg, #7f0000, var(--red-dark));
        box-shadow: 0 6px 22px rgba(183, 28, 28, 0.45);
        transform: translateY(-1px);
        color: #fff !important;
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
        transition: all 0.22s;
        white-space: nowrap;
    }

    .btn-rk-outline:hover {
        background: var(--red);
        color: #fff;
    }

    .banner-section-full {
        width: 100%;
        height: auto !important;
        overflow: hidden;
        position: relative;
        background: transparent !important;
    }

    .banner-carousel-full,
    .banner-carousel-full .slick-list,
    .banner-carousel-full .slick-track {
        height: auto !important;
    }

    .banner-slide {
        width: 100%;
        height: auto !important;
    }

    .banner-slide img {
        width: 100% !important;
        height: auto !important;
        object-fit: unset !important;
        display: block;
        background: transparent !important;
    }

    /* remove gap issue */
    .banner-carousel-full .slick-slide {
        margin: 0;
    }

    /* dots style (optional premium look) */
    .banner-carousel-full .slick-dots {
        bottom: 20px;
    }

    .banner-carousel-full .slick-dots li button:before {
        color: #fff;
        font-size: 10px;
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 768px) {
        .doctors-hero h1 {
            font-size: 1.8rem;
        }

        .hero-stats-grid {
            grid-template-columns: 1fr 1fr;
        }

        .hero-stat .s-num {
            font-size: 1.6rem;
        }

        .doc-actions {
            flex-direction: column;
        }

        .doc-info-strip {
            flex-direction: column;
            gap: 10px;
        }
    }

    .speciality-section .spaciality-item .custom-title {
        font-size: 21px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        width: 100% !important;
    }

    .speciality-section .spaciality-item p {
        font-size: 16px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .btn-view-all-rk {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #1a1a2e;
        color: #fff !important;
        font-size: 15px;
        font-weight: 700;
        padding: 14px 40px;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.25s ease;
        letter-spacing: 0.4px;
    }

    .btn-view-all-rk:hover {
        background: #b71c1c;
        color: #fff !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(183, 28, 28, 0.35);
    }

    /* ── Sticky header ── */
    header.header.sticky {
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 999;
        background: #fff !important;
        box-shadow: 0 2px 16px rgba(0, 0, 0, .10);
        animation: slideDown .3s ease forwards;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-100%);
        }

        to {
            transform: translateY(0);
        }
    }

    /* ─────────────────────────────────────────
   WORK SECTION TEXT FIX (SCOPED ONLY)
──────────────────────────────────────── */

    /* Target ONLY this section */
    .work-section-seven .work-item-two .custom-title {
        font-size: 18px !important;
        line-height: 1.4 !important;
        font-weight: 600 !important;
    }

    /* Paragraph inside work cards */
    .work-section-seven .work-item-two p {
        font-size: 14px !important;
        line-height: 1.7 !important;
        text-align: justify !important;
        color: #555 !important;
    }

    /* Reduce number size */
    .work-section-seven .count-number {
        font-size: 30px !important;
    }

    /* Improve spacing */
    .work-section-seven .work-item-two {
        padding: 18px !important;
    }

    /* Optional: slight heading improvement */
    .work-section-seven .section-title {
        font-size: 26px !important;
    }

    /* Mobile fix */
    @media (max-width: 768px) {
        .work-section-seven .work-item-two .custom-title {
            font-size: 16px !important;
        }

        .work-section-seven .work-item-two p {
            font-size: 13.5px !important;
        }
    }

    /* About section text justify ONLY */
    .about-section .about-content-details p {
        text-align: justify;
    }

    /* Reduce ONLY step card titles */
    .choose-step-nine .choose-step .custom-title {
        font-size: 20px;
        /* adjust if needed (16–18 best) */
        line-height: 1.4;
    }

    /* ─────────────────────────────────────────
       FAQ SECTION TITLE FONT SIZE FIX
    ──────────────────────────────────────── */
    .faq-section-eight .accordion-button {
        font-size: 16px !important;
        /* Adjust this number (e.g., 15px or 17px) if needed */
        font-weight: 600 !important;
        line-height: 1.5 !important;
    }

    @media (max-width: 768px) {
        .faq-section-eight .accordion-button {
            font-size: 15px !important;
            /* Slightly smaller on mobile devices */
        }
    }

    /* ─────────────────────────────────────────
       FAQ MAIN HEADING FONT SIZE FIX
    ──────────────────────────────────────── */
    .faq-section-eight .section-header-eight .section-title {
        font-size: 32px !important;
        /* Adjust this number down (e.g., 28px) if you want it even smaller */
        line-height: 1.3 !important;
    }

    @media (max-width: 768px) {
        .faq-section-eight .section-header-eight .section-title {
            font-size: 24px !important;
            /* Smaller size for mobile screens */
        }
    }

    /* ─────────────────────────────────────────
       REDUCE SPACING BETWEEN FAQ TITLE & ACCORDION
    ──────────────────────────────────────── */
    .faq-section-eight .section-header-eight {
        margin-bottom: 12px !important;
        /* Adjust this number to make the gap smaller or larger */
    }
    </style>
</head>

<body><a href="https://doccure.dreamstechnologies.com/cdn-cgi/content?id=9AwWJ6OYRjeADANYsu6BhO8Xh1spBbpICR_64ULwChU-1773164928.2015598-1.0.1.1-pqZR2On.5acTxHq8lZV9fTE0YFo5d6y17w8iArEoNAk"
        aria-hidden="true" rel="nofollow noopener" style="display: none !important; visibility: hidden !important"></a>

    <!-- Main Wrapper -->
    <div class="main-wrapper">


        <?php $headerClass = 'header-default inner-header'; include 'include/header.php'; ?>
        <!-- Full Width Image Carousel Banner -->
        <section class="banner-section-full">

            <div class="banner-carousel-full">

                <!-- Slide 1 -->
                <div class="banner-slide">
                    <img src="assets/img/home/image-crousel1.webp" alt="doctor">
                </div>

                <!-- Slide 2 -->
                <div class="banner-slide">
                    <img src="assets/img/home/image-crousel2.webp" alt="doctor">
                </div>

                <!-- Slide 3 -->
                <div class="banner-slide">
                    <img src="assets/img/home/image-crousel3.webp" alt="doctor">
                </div>

                <!-- Slide 4 -->
                <div class="banner-slide">
                    <img src="assets/img/home/image-crousel4.webp" alt="doctor">
                </div>

            </div>

        </section>

        <!-- Speciality Section -->
        <section class="speciality-section section overflow-hidden">
            <div class="container">
                <div class="section-header section-header-one text-center wow fadeInUp" data-wow-duration="1s">
                    <div class="title">Top Specialties</div>
                    <h2 class="section-title">Advanced Treatments <span class="text-danger">At RK Hospital Nagpur</span>
                    </h2>
                </div>
                <div class="speciality-slider-info">
                    <div class="spciality-slider">
                        <div class="slide-item wow fadeInUp" data-wow-duration="1s">
                            <div class="spaciality-item">
                                <div class="spaciality-img">
                                    <img src="assets/img/home/Menstrual-Hormonal-Disorder-Treatment.webp" alt="img">
                                    <span class="spaciality-icon">
                                        <img src="assets/img/home/hormonal.svg" alt="img">
                                    </span>
                                </div>
                                <h3 class="custom-title"><a href="#">Hormonal Disorders</a></h3>
                                <p class="mb-0">Menstrual Treatment</p>
                            </div>
                        </div>

                        <div class="slide-item wow fadeInUp" data-wow-duration="1s">
                            <div class="spaciality-item">
                                <div class="spaciality-img">
                                    <img src="assets/img/home/Pregnancy-Care-Antenatal-Delivery.webp" alt="img">
                                    <span class="spaciality-icon">
                                        <img src="assets/img/home/pregnant.svg" alt="img">
                                    </span>
                                </div>
                                <h3 class="custom-title"><a href="#">Pregnancy Care</a></h3>
                                <p class="mb-0">Antenatal & Delivery</p>
                            </div>
                        </div>

                        <div class="slide-item wow fadeInUp" data-wow-duration="1s">
                            <div class="spaciality-item">
                                <div class="spaciality-img">
                                    <img src="assets/img/home/Fracture-Trauma-Care.webp" alt="img">
                                    <span class="spaciality-icon">
                                        <img src="assets/img/home/broken-bone.svg" alt="img">
                                    </span>
                                </div>
                                <h3 class="custom-title"><a href="#">Fracture & Trauma</a></h3>
                                <p class="mb-0">Emergency Treatment</p>
                            </div>
                        </div>

                        <div class="slide-item wow fadeInUp" data-wow-duration="1s">
                            <div class="spaciality-item">
                                <div class="spaciality-img">
                                    <img src="assets/img/home/Hip-replacement.webp" alt="img">
                                    <span class="spaciality-icon">
                                        <img src="assets/img/home/hip-replacement.svg" alt="img">
                                    </span>
                                </div>
                                <h3 class="custom-title"><a href="#">Hip Replacement</a></h3>
                                <p class="mb-0">Joint Surgery</p>
                            </div>
                        </div>

                        <div class="slide-item wow fadeInUp" data-wow-duration="1s">
                            <div class="spaciality-item">
                                <div class="spaciality-img">
                                    <img src="assets/img/home/Robotic-Joint-Replacement-Surgery.webp" alt="img">
                                    <span class="spaciality-icon">
                                        <img src="assets/img/home/robotic-surgery.svg" alt="img">
                                    </span>
                                </div>
                                <h3 class="custom-title"><a href="#">Robotic Surgery</a></h3>
                                <p class="mb-0">Joint Replacement</p>
                            </div>
                        </div>

                        <div class="slide-item wow fadeInUp" data-wow-duration="1s">
                            <div class="spaciality-item">
                                <div class="spaciality-img">
                                    <img src="assets/img/home/Spine-Back-Pain-Treatment.webp" alt="img">
                                    <span class="spaciality-icon">
                                        <img src="assets/img/home/spine.svg" alt="img">
                                    </span>
                                </div>
                                <h3 class="custom-title"><a href="#">Spine & Back Pain</a></h3>
                                <p class="mb-0">Pain Treatment</p>
                            </div>
                        </div>

                        <div class="slide-item wow fadeInUp" data-wow-duration="1s">
                            <div class="spaciality-item">
                                <div class="spaciality-img">
                                    <img src="assets/img/home/Infertility-&-FamilyPlanning(2).webp" alt="img">
                                    <span class="spaciality-icon">
                                        <img src="assets/img/home/infertility.svg" alt="img">
                                    </span>
                                </div>
                                <h3 class="custom-title"><a href="#">Infertility Treatment</a></h3>
                                <p class="mb-0">Advanced Care</p>
                            </div>
                        </div>

                        <div class="slide-item wow fadeInUp" data-wow-duration="1s">
                            <div class="spaciality-item">
                                <div class="spaciality-img">
                                    <img src="assets/img/home/RoutineCheckups-&-PreventiveCare.webp" alt="img">
                                    <span class="spaciality-icon">
                                        <img src="assets/img/home/medical-checkup.svg" alt="img">
                                    </span>
                                </div>
                                <h3 class="custom-title"><a href="#">Routine Checkups</a></h3>
                                <p class="mb-0">Preventive Care</p>
                            </div>
                        </div>

                    </div>

                    <div class="slide-btn">
                        <button type="button" class="slick-arrow spciality-prev"><i
                                class="isax isax-arrow-left"></i></button>
                        <button type="button" class="slick-arrow spciality-next"><i
                                class="isax isax-arrow-right-1"></i></button>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Speciality Section -->
        <!-- About Us -->
        <section class="about-section">
            <div class="container">
                <div class="row align-items-center">

                    <!-- Images (same as your code, just improve alt text) -->
                    <div class="col-lg-6 col-md-12">
                        <div class="about-img-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="about-inner-img">
                                        <div class="about-img">
                                            <img src="assets/img/home/about-doctor1.webp" class="img-fluid"
                                                alt="Orthopedic Surgeon in Nagpur RK Hospital">
                                        </div>
                                        <div class="about-img">
                                            <img src="assets/img/home/about-doctor3.webp" class="img-fluid"
                                                alt="Gynecology Treatment RK Hospital Nagpur">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="about-inner-img">
                                        <div class="about-box">
                                            <h4>25+ Years of Medical Excellence in Nagpur</h4>
                                        </div>
                                        <div class="about-img">
                                            <img src="assets/img/home/about-doctor2.webp" class="img-fluid"
                                                alt="Robotic Knee Replacement Surgery Nagpur">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="col-lg-6 col-md-12">
                        <div class="section-inner-header about-inner-header">
                            <h6>About Dr. Agrawal's R.K. Hospital</h6>
                            <h2>
                                Leading Orthopedic & Gynecology Hospital in
                                <span class="text-danger">Nagpur</span>
                            </h2>
                        </div>

                        <div class="about-content">
                            <div class="about-content-details">

                                <p>
                                    Dr. Agrawal's R.K. Hospital is one of the most trusted and advanced healthcare
                                    centers in Nagpur, specializing in Orthopedics and Gynecology. Known for its
                                    excellence in robotic knee replacement, hip replacement, spine surgery, and trauma
                                    care, the hospital provides world-class treatment using modern technology and highly
                                    experienced specialists.
                                </p>

                                <p>
                                    Our gynecology and obstetrics department offers comprehensive pregnancy care,
                                    high-risk pregnancy management, and advanced laparoscopic surgeries. With a strong
                                    focus on patient safety, hygiene, and personalized care, we ensure the best outcomes
                                    for both mother and baby.
                                </p>

                                <p>
                                    With a 5-star patient rating and a reputation for successful surgeries, expert
                                    doctors, and supportive staff, R.K. Hospital stands as a leading choice for quality
                                    healthcare in Nagpur. We are available 24/7 for emergency services, ensuring timely
                                    and reliable medical care when you need it most.
                                </p>

                            </div>

                            <!-- Contact -->
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
        <!-- /About Us -->

        <section class="work-section-seven section">
            <div class="container">

                <div class="row">
                    <div class="col-xxl-10 col-lg-11 mx-auto">
                        <div class="section-header section-header-seven text-center">
                            <div class="section-sub-title" style="color:#004D8F;">
                                Top Orthopedic & Gynecology Hospital in Nagpur | Dr. Agrawal's R.K. Hospital
                            </div>

                            <h2 class="section-title">
                                Best Robotic Joint Replacement & Women's Care at
                                <span style="color:#E8002D;">
                                    R.K. Hospital Nagpur
                                </span>
                            </h2>

                            <p>
                                Dr. Agrawal's R.K. Hospital is one of the best hospitals in Nagpur for orthopedic
                                surgery, robotic knee replacement, hip replacement, spine treatment, and gynecology
                                care. Equipped with advanced medical technology, modular operation theatres, and
                                experienced doctors, we provide high-quality, safe, and affordable treatment. Our
                                hospital is known for excellent patient care, successful surgeries, and 24/7 emergency
                                services in Nagpur and nearby areas.
                            </p>

                            <p>
                                Whether you are looking for the best orthopedic doctor in Nagpur, a trusted maternity
                                hospital, or advanced trauma care, R.K. Hospital ensures personalized treatment with
                                faster recovery and long-term results.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row g-4">

                    <!-- Work Item 1 -->
                    <div class="col-xl-3 col-md-6 d-flex wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1s">
                        <div class="work-item-two flex-fill">
                            <h3 class="custom-title">Robotic Knee Replacement & Hip Surgery Nagpur</h3>
                            <div class="work-info">
                                <div class="work-icon">
                                    <img src="assets/img/icons/work-01.svg"
                                        alt="Best Robotic Knee Replacement Hospital in Nagpur" class="img-fluid">
                                </div>
                                <div class="count-number">01</div>
                            </div>
                            <p>
                                Specialized in robotic-assisted knee and hip replacement surgery in Nagpur offering high
                                precision, minimal pain, shorter hospital stay, and faster recovery for patients.
                            </p>
                        </div>
                    </div>

                    <!-- Work Item 2 -->
                    <div class="col-xl-3 col-md-6 d-flex wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="2s">
                        <div class="work-item-two flex-fill">
                            <h3 class="custom-title">Advanced Gynecology & Pregnancy Care</h3>
                            <div class="work-info">
                                <div class="work-icon">
                                    <img src="assets/img/icons/work-02.svg"
                                        alt="Best Gynecology Hospital in Nagpur for Pregnancy Care" class="img-fluid">
                                </div>
                                <div class="count-number">02</div>
                            </div>
                            <p>
                                Complete women’s healthcare including PCOS treatment, infertility solutions, fibroids
                                treatment, laparoscopic gynecology surgery, and safe pregnancy care in Nagpur.
                            </p>
                        </div>
                    </div>

                    <!-- Work Item 3 -->
                    <div class="col-xl-3 col-md-6 d-flex wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="3s">
                        <div class="work-item-two flex-fill">
                            <h3 class="custom-title">Spine Surgery, Back Pain & Trauma Care Nagpur</h3>
                            <div class="work-info">
                                <div class="work-icon">
                                    <img src="assets/img/icons/work-03.svg"
                                        alt="Spine Specialist and Trauma Care Hospital in Nagpur" class="img-fluid">
                                </div>
                                <div class="count-number">03</div>
                            </div>
                            <p>
                                Expert treatment for spine, slip disc, fractures, accident injuries, sports
                                injuries, and orthopedic trauma care with advanced diagnostics and rehabilitation.
                            </p>
                        </div>
                    </div>

                    <!-- Work Item 4 -->
                    <div class="col-xl-3 col-md-6 d-flex wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="4s">
                        <div class="work-item-two flex-fill">
                            <h3 class="custom-title">Best Maternity & High-Risk Pregnancy Hospital Nagpur</h3>
                            <div class="work-info">
                                <div class="work-icon">
                                    <img src="assets/img/icons/work-04.svg"
                                        alt="High Risk Pregnancy and Delivery Hospital in Nagpur" class="img-fluid">
                                </div>
                                <div class="count-number">04</div>
                            </div>
                            <p>
                                Trusted maternity hospital in Nagpur providing high-risk pregnancy care,
                                delivery, C-section, prenatal checkups, and postnatal care with 24/7 expert support.
                            </p>
                        </div>
                    </div>

                </div>

                <div class="text-center">
                    <div class="connect-badge">
                        Looking for the best orthopedic or gynecology hospital in Nagpur? Visit Dr. Agrawal's R.K.
                        Hospital today for expert consultation and advanced treatment.
                        <span>Book Appointment Now | Call +91 97660 57372</span>
                    </div>
                </div>
            </div>
        </section>
        <!-- Why Choose Section Start -->
        <section class="whychoose-section-nine section">
            <div class="container">
                <div class="section-header section-header-nine text-center wow fadeInUp" data-wow-duration="1s">
                    <div class="title"><span class="dot"></span>WHY CHOOSE US</div>
                    <h2 class="section-title">
                        Why Patients Trust
                        <span class="text-white">
                            Dr. Agrawal's R.K. Hospital Nagpur
                        </span>
                    </h2>
                    <p style="color:#fff;">
                        Recognized as one of the best orthopedic and gynecology hospitals in Nagpur, we provide advanced
                        treatment, expert doctors, and 24/7 emergency care with a strong focus on patient safety and
                        successful outcomes.
                    </p>
                </div>

                <!-- start row -->
                <div class="row">

                    <!-- Left -->
                    <div class="col-lg-3">
                        <div class="choose-item-nine wow fadeInUp" data-wow-duration="1s">
                            <h3 class="custom-title">Advanced Orthopedic & Joint Replacement</h3>
                            <p class="description">
                                Specialized in robotic knee replacement, hip replacement, spine surgery, and trauma care
                                with high success rates in Nagpur.
                            </p>
                        </div>

                        <div class="choose-item-nine wow fadeInUp" data-wow-duration="2s">
                            <h3 class="custom-title">Modern Technology & Operation Theatres</h3>
                            <p class="description">
                                Equipped with advanced diagnostic systems, modular OT, and robotic-assisted surgical
                                technology for precise and safe treatment.
                            </p>
                        </div>
                    </div>

                    <!-- Center -->
                    <div class="col-lg-6">
                        <div class="choose-img-nine">
                            <video playsinline autoplay muted loop id="video">
                                <source src="assets/img/home/RK-hospital.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>

                    <!-- Right -->
                    <div class="col-lg-3">
                        <div class="choose-item-nine right-item wow fadeInUp" data-wow-duration="1s">
                            <h3 class="custom-title">Expert Doctors & 5-Star Patient Care</h3>
                            <p class="description">
                                Experienced orthopedic surgeons and gynecologists delivering personalized care with
                                excellent patient satisfaction and trusted results.
                            </p>
                        </div>

                        <div class="choose-item-nine right-item wow fadeInUp" data-wow-duration="2s">
                            <h3 class="custom-title">24/7 Emergency & Trauma Services</h3>
                            <p class="description">
                                круглосуточная emergency care for accidents, fractures, pregnancy emergencies, and
                                critical conditions in Nagpur.
                            </p>
                        </div>
                    </div>

                </div>
                <!-- end row -->

                <!-- Steps -->
                <div class="row choose-step-nine g-3 justify-content-center">

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="choose-step wow fadeInUp" data-wow-duration="1s">
                            <div class="step-icon">
                                <img src="assets/img/bg/choose-step-bg.png" class="img-fluid bg-one">
                                <img src="assets/img/icons/step-icon-1.png" class="img-fluid icon">
                            </div>
                            <div class="step-content">
                                <span class="level">Step 1</span>
                                <h3 class="custom-title">Book Your Appointment Now</h3>
                                <p>
                                    Call or visit Dr. Agrawal's R.K. Hospital Nagpur to consult with our expert
                                    orthopedic or gynecology specialists.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="choose-step wow fadeInUp" data-wow-duration="2s">
                            <div class="step-icon">
                                <img src="assets/img/bg/choose-step-bg.png" class="img-fluid bg-one">
                                <img src="assets/img/icons/step-icon-2.png" class="img-fluid icon">
                            </div>
                            <div class="step-content">
                                <span class="level">Step 2</span>
                                <h3 class="custom-title">Diagnosis & Treatment Plan</h3>
                                <p>
                                    Get accurate diagnosis using advanced technology and receive a personalized
                                    treatment plan for faster recovery.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="choose-step wow fadeInUp" data-wow-duration="3s">
                            <div class="step-icon">
                                <img src="assets/img/bg/choose-step-bg.png" class="img-fluid bg-one">
                                <img src="assets/img/icons/step-icon-3.png" class="img-fluid icon">
                            </div>
                            <div class="step-content">
                                <span class="level">Step 3</span>
                                <h3 class="custom-title">Advanced Treatment & Recovery</h3>
                                <p>
                                    Receive world-class treatment including robotic surgery, maternity care, or trauma
                                    management with continuous support.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <img src="assets/img/home/why-choose-bg.png" alt="Best Hospital in Nagpur RK Hospital"
                class="img-fluid choose-bg-5">
        </section>
        <!-- Why Choose Section Start-->


        <!-- Services Section -->
        <section class="services-section wow fadeInUp" data-wow-duration="1s">
            <div class="horizontal-slide d-flex" data-direction="right" data-speed="slow">
                <div class="slide-list d-flex gap-4">

                    <div class="services-slide">
                        <h6><a href="#">Best Orthopedic & Gynecology Hospital in Nagpur</a></h6>
                    </div>

                    <div class="services-slide">
                        <h6><a href="#">Robotic Knee & Hip Replacement Surgery Nagpur</a></h6>
                    </div>

                    <div class="services-slide">
                        <h6><a href="#">Spine, Back Pain & Trauma Treatment</a></h6>
                    </div>

                    <div class="services-slide">
                        <h6><a href="#">Pregnancy Care, Normal Delivery & C-Section</a></h6>
                    </div>

                    <div class="services-slide">
                        <h6><a href="#">Infertility Treatment & Women's Health Care</a></h6>
                    </div>

                    <div class="services-slide">
                        <h6><a href="#">24/7 Emergency & Accident Trauma Care</a></h6>
                    </div>

                    <div class="services-slide">
                        <h6><a href="#">Laparoscopic & Minimally Invasive Surgery</a></h6>
                    </div>

                </div>
            </div>
        </section>
        <!-- /Services Section -->




        <section class="services-section-seven section" style="padding-top: 20px;">
            <div class="container">

                <div class="section-header section-header-seven">
                    <div class="row g-4 align-items-center">

                        <div class="col-xl-8">
                            <div class="section-sub-title" style="color:#004D8F;">
                                Best Medical Services in Nagpur | R.K. Hospital
                            </div>

                            <h2 class="section-title">
                                Advanced Orthopedic & Gynecology Treatments at
                                <span style="color:#ED1C24;">
                                    Dr. Agrawal's R.K. Hospital Nagpur
                                </span>
                            </h2>
                            <p>
                                We provide world-class orthopedic surgery, robotic joint replacement, spine treatment,
                                trauma care, and advanced gynecology services in Nagpur with modern technology and
                                experienced doctors.
                            </p>
                        </div>

                        <div class="col-xl-4">
                            <div class="text-xl-end">
                                <a href="<?= SITE_URL ?>/services.php" class="btn btn-white theme-7-btn">
                                    View All Services
                                    <span class="icon"><i class="isax isax-arrow-right-3"></i></span>
                                </a>
                            </div>
                        </div>

                        <!-- Service 1 -->
                        <div class="services-item-seven">
                            <div class="service-header">
                                <h3 class="custom-title">Robotic Knee Replacement in Nagpur</h3>
                            </div>
                            <div class="service-content">
                                <p>
                                    Advanced robotic knee replacement surgery with high precision, less pain, faster
                                    recovery, and long-lasting results by expert orthopedic surgeons.
                                </p>
                            </div>
                            <div class="service-img">
                                <img src="assets/img/home/ecg.webp" alt="Robotic Knee Replacement Hospital Nagpur"
                                    class="img-fluid">
                            </div>
                        </div>

                        <!-- Service 2 -->
                        <div class="services-item-seven">
                            <div class="service-header">
                                <h3 class="custom-title">Robotic Hip Replacement Surgery Nagpur</h3>
                            </div>
                            <div class="service-content">
                                <p>
                                    Minimally invasive hip replacement surgery using robotic technology for accurate
                                    implant positioning and quicker recovery.
                                </p>
                            </div>
                            <div class="service-img">
                                <img src="assets/img/home/robotic.webp" alt="Hip Replacement Surgery Hospital Nagpur"
                                    class="img-fluid">
                            </div>
                        </div>

                        <!-- Service 3 -->
                        <div class="services-item-seven active">
                            <div class="service-header">
                                <h3 class="custom-title">Spine Surgery & Back Pain Treatment Nagpur</h3>
                            </div>
                            <div class="service-content">
                                <p>
                                    Specialized spine treatment for slip disc, back pain, spinal stenosis, and
                                    deformities using advanced and minimally invasive techniques.
                                </p>
                            </div>
                            <div class="service-img">
                                <img src="assets/img/home/spline.webp" alt="Spine Surgery Hospital in Nagpur"
                                    class="img-fluid">
                            </div>
                        </div>

                        <!-- Service 4 -->
                        <div class="services-item-seven">
                            <div class="service-header">
                                <h3 class="custom-title">Pregnancy Care & Delivery Hospital Nagpur</h3>
                            </div>
                            <div class="service-content">
                                <p>
                                    Complete maternity services including antenatal care, normal delivery, C-section,
                                    and postnatal care in a safe and hygienic environment.
                                </p>
                            </div>
                            <div class="service-img">
                                <img src="assets/img/home/delivery.webp" alt="Pregnancy Hospital in Nagpur"
                                    class="img-fluid">
                            </div>
                        </div>

                        <!-- Service 5 -->
                        <div class="services-item-seven">
                            <div class="service-header">
                                <h3 class="custom-title">Laparoscopic Gynecology Surgery Nagpur</h3>
                            </div>
                            <div class="service-content">
                                <p>
                                    Advanced laparoscopic (keyhole) surgery for fibroids, ovarian cysts, endometriosis,
                                    and other gynecological conditions with faster recovery.
                                </p>
                            </div>
                            <div class="service-img">
                                <img src="assets/img/home/laparoscopic.webp"
                                    alt="Laparoscopic Gynecology Surgery Nagpur" class="img-fluid">
                            </div>
                        </div>

                    </div>

                    <img src="assets/img/bg/service-bg-01.png" alt="Best Hospital Services in Nagpur RK Hospital"
                        class="service-bg-01">
                </div>
            </div>
        </section>



        <!-- ==================== Doctors Listing ==================== -->
        <section class="section" style="background: #fff; padding: 56px 0 80px;">
            <div class="container">

                <!-- Section Header -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="rk-eyebrow">Our Expert Doctors in Nagpur</div>
                        <h2 class="rk-section-title">
                            Meet the Specialists at
                            <span>Dr. Agrawal's R.K. Hospital Nagpur</span>
                        </h2>
                        <p style="color: var(--text-soft); font-size:15px; margin-top:6px;">
                            Trusted by patients for advanced orthopedic surgery and gynecology care in Nagpur with high
                            success rates
                        </p>
                    </div>
                </div>

                <!-- Doctor Cards — Dynamic from DB -->
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

                <div class="row g-4 justify-content-center">

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

                        // Profile URL
                        $profile_link = !empty($doc['slug']) ? 'doctor/' . htmlspecialchars($doc['slug']) : '#';
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
                                <p class="doc-bio">
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
                                            <strong>&#8377;<?= htmlspecialchars($doc['consultation_fee']) ?></strong></span>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <div class="doc-actions">
                                    <a href="<?= SITE_URL ?>/doctors/<?= urlencode($doc['slug']) ?>"
                                        class="btn-rk-primary">
                                        View Profile
                                    </a>
                                    <a href="<?= SITE_URL ?>/contact-us.php" class="btn-rk-outline">
                                        Book Appointment
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
            </div>
        </section>
        <!-- ==================== /Doctors Listing ==================== -->



        <!-- Testimonial Section -->
        <section class="testimonial-section-one section">
            <div class="container">

                <div class="section-header section-header-one text-center wow fadeInUp" data-wow-duration="1s">
                    <div class="title">Patient Reviews</div>
                    <h2 class="section-title">
                        496+ Patients Trust
                        <span class="text-danger">Dr. Agrawal's R.K. Hospital Nagpur</span>
                    </h2>
                    <p>
                        Rated 5★ by patients for orthopedic surgery, pregnancy care, and advanced treatment in Nagpur
                    </p>
                </div>

                <div class="testimonials-slider">

                    <!-- Review 1 -->
                    <div class="slide-item">
                        <div class="testimonials-item wow fadeInUp">
                            <div class="testimonials-info">
                                <div class="review-star d-flex justify-content-between">
                                    <div class="rating d-flex">
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </div>
                                </div>
                                <div class="testimonial-content">
                                    <h3 class="title">Excellent Gynecology Treatment</h3>
                                    <p class="description">
                                        I had a very positive experience at RK Hospital. Dr. Priyanka Jain Agrawal
                                        performed a laparoscopic hysterectomy with great expertise. The staff was
                                        supportive, hospital was clean, and the cashless insurance process was smooth.
                                        Highly recommended hospital in Nagpur.
                                    </p>
                                </div>
                                <div class="testimonial-author">
                                    <div>
                                        <p class="author-name">Jaishree Jaiswal</p>
                                        <p class="author-location">Nagpur</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review 2 -->
                    <div class="slide-item">
                        <div class="testimonials-item wow fadeInUp">
                            <div class="testimonials-info">
                                <div class="review-star d-flex justify-content-between">
                                    <div class="rating d-flex">
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </div>
                                </div>
                                <div class="testimonial-content">
                                    <h3 class="title">Best Pregnancy & Delivery Care</h3>
                                    <p class="description">
                                        We chose Dr. Priyanka Jain for delivery and it was the best decision. The doctor
                                        is knowledgeable and always available. The staff and hospital environment were
                                        very positive. Perfect place for a smooth and stress-free maternity journey in
                                        Nagpur.
                                    </p>
                                </div>
                                <div class="testimonial-author">
                                    <div>
                                        <p class="author-name">Shreya Jain</p>
                                        <p class="author-location">Nagpur</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review 3 -->
                    <div class="slide-item">
                        <div class="testimonials-item wow fadeInUp">
                            <div class="testimonials-info">
                                <div class="review-star d-flex justify-content-between">
                                    <div class="rating d-flex">
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </div>
                                </div>
                                <div class="testimonial-content">
                                    <h3 class="title">Successful Hip Replacement Surgery</h3>
                                    <p class="description">
                                        My mother underwent femur head replacement surgery at RK Hospital. Dr. Agrawal
                                        is very kind and explains everything clearly. Staff is cooperative and prompt.
                                        One of the best orthopedic hospitals in Nagpur.
                                    </p>
                                </div>
                                <div class="testimonial-author">
                                    <div>
                                        <p class="author-name">Madhavi Naik</p>
                                        <p class="author-location">Nagpur</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review 4 -->
                    <div class="slide-item">
                        <div class="testimonials-item wow fadeInUp">
                            <div class="testimonials-info">
                                <div class="review-star d-flex justify-content-between">
                                    <div class="rating d-flex">
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </div>
                                </div>
                                <div class="testimonial-content">
                                    <h3 class="title">Clean & Hygienic Hospital</h3>
                                    <p class="description">
                                        RK Hospital is very clean and hygienic. Staff provides excellent service and
                                        truly cares for patients. Easily accessible location in Nagpur. Highly
                                        recommended for orthopedic and gynecology treatment.
                                    </p>
                                </div>
                                <div class="testimonial-author">
                                    <div>
                                        <p class="author-name">Rushi Pande</p>
                                        <p class="author-location">Nagpur</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="text-center mt-5">
                    <a href="https://www.google.com/maps/place/Dr.Agrawal's+R.K.Hospital/@21.1493999,79.1136561,17z/data=!3m1!4b1!4m6!3m5!1s0x3bd4c79a161b6283:0xb92548dea3dc4756!8m2!3d21.1493999!4d79.1136561!16s%2Fg%2F11y28_whc0?entry=ttu&g_ep=EgoyMDI2MDMyNC4wIKXMDSoASAFQAw%3D%3D"
                        target="_blank" rel="noopener noreferrer" class="btn-view-all-rk">
                        Read More &nbsp;<i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        </section>
        <!-- /Testimonial Section -->



        <!-- Start Faq -->
        <section class="faq-section-eight section">
            <div class="container">
                <div class="row">

                    <div class="col-lg-5 mb-4 mb-lg-0">
                        <div class="faq-support w-100 position-relative">
                            <img src="assets/img/faq.webp" alt="RK Hospital Nagpur FAQ" class="img-fluid"
                                style="width: 100%; height: 520px; object-fit: cover; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="section-header section-header-eight">
                            <div class="section-sub-title">
                                <span class="dot"></span>FAQs – RK Hospital Nagpur
                            </div>
                            <h2 class="section-title">
                                Frequently Asked Questions about
                                <span class="line">Dr. Agrawal's R.K. Hospital</span>
                            </h2>
                        </div>

                        <div class="faq-info wow zoomIn">
                            <div class="accordion" id="faq-details-one">

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <a class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            What are the operating hours of RK Hospital Nagpur?
                                        </a>
                                    </h3>
                                    <div id="faq1" class="accordion-collapse collapse show"
                                        data-bs-parent="#faq-details-one">
                                        <div class="accordion-body">
                                            <p>
                                                Dr. Agrawal's R.K. Hospital Nagpur is open 24/7 for emergency services.
                                                OPD timings are 11:00 AM to 4:00 PM and 7:00 PM to 9:00 PM (Mon–Sat).
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <a class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#faq2">
                                            How can I book an appointment at RK Hospital Nagpur?
                                        </a>
                                    </h3>
                                    <div id="faq2" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-details-one">
                                        <div class="accordion-body">
                                            <p>
                                                You can book an appointment by calling +91 97660 57372 or 8999290433.
                                                Walk-in and online booking options are also available.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <a class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#faq3">
                                            What treatments are available at RK Hospital Nagpur?
                                        </a>
                                    </h3>
                                    <div id="faq3" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-details-one">
                                        <div class="accordion-body">
                                            <p>
                                                RK Hospital specializes in robotic knee & hip replacement, spine
                                                surgery, trauma care, pregnancy care, infertility treatment, and
                                                laparoscopic gynecology procedures.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <a class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#faq4">
                                            Does RK Hospital provide robotic surgery in Nagpur?
                                        </a>
                                    </h3>
                                    <div id="faq4" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-details-one">
                                        <div class="accordion-body">
                                            <p>
                                                Yes, Dr. Agrawal's R.K. Hospital is a leading center for robotic knee
                                                and hip replacement surgery in Nagpur, offering high precision and
                                                faster recovery.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <a class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#faq5">
                                            Where is RK Hospital located in Nagpur?
                                        </a>
                                    </h3>
                                    <div id="faq5" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-details-one">
                                        <div class="accordion-body">
                                            <p>
                                                Dr. Agrawal's R.K. Hospital is located at Central Avenue, beside Hotel
                                                Al Zam Zam, Nagpur, Maharashtra, easily accessible from all major areas.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        ```
        <!-- End Faq -->
        <!-- /Article Section -->
        <?php include 'include/latest-blog.php'; ?>

        <?php include 'include/footer.php'; ?>

        <!-- Cursor -->
        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>
        <!-- /Cursor -->

    </div>
    <!-- /Main Wrapper -->

    <!-- start offcanvas -->
    <div class="offcanvas offcanvas-offset offcanvas-end support_popup" tabindex="-1" id="support_item">
        <div class="offcanvas-header">
            <a href="index.html"><img src="assets/img/logo.svg" alt="logo" class="img-fluid logo"></a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
                    class="isax isax-close-circle"></i></button>
        </div>

        <div class="offcanvas-body">

            <!-- Item 1 -->
            <div class="about-popup-item">
                <h3 class="title">About Doccure</h3>
                <p>Modern healthcare platform designed to simplify the way patients connect with doctors, clinics &
                    medical services.</p>
                <div class="about-img d-flex align-items-center gap-2 justify-content-between">
                    <a href="<?php echo $base_url; ?>assets/img/banner/about-img-1.jpg" data-fancybox="gallery"><img
                            src="assets/img/banner/about-img-1.jpg" alt="about-img-1" class="img-fluid"></a>
                    <a href="<?php echo $base_url; ?>assets/img/banner/about-img-2.jpg" data-fancybox="gallery"><img
                            src="assets/img/banner/about-img-2.jpg" alt="about-img-1" class="img-fluid"></a>
                    <a href="<?php echo $base_url; ?>assets/img/banner/about-img-3.jpg" data-fancybox="gallery"><img
                            src="assets/img/banner/about-img-3.jpg" alt="about-img-1" class="img-fluid"></a>
                </div>
            </div>
            <!-- Item 2 -->
            <div class="about-popup-item">
                <h3 class="title">Our Locations</h3>
                <div class="loction-item mb-3">
                    <h4 class="title">California</h4>
                    <p class="location">1250 Sunset, Los Angeles, CA</p>
                </div>
                <div class="loction-item">
                    <h4 class="title">Los Angeles</h4>
                    <p class="location">669 Boulevard, Los Angeles</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="about-popup-item">
                <h3 class="title">Contact Information</h3>
                <div class="support-item mb-3">
                    <div class="avatar avatar-lg bg-primary rounded-circle">
                        <i class="isax isax-messages-3"></i>
                    </div>
                    <div>
                        <p class="title">General Inquiries</p>
                        <h5 class="link"><a href="index.html#"><span class="__cf_email__"
                                    data-cfemail="9ff6f1f9f0dffae7fef2eff3fab1fcf0f2">[email&#160;protected]</span></a>
                        </h5>
                    </div>
                </div>
                <div class="support-item">
                    <div class="avatar avatar-lg bg-primary rounded-circle">
                        <i class="isax isax-call-calling"></i>
                    </div>
                    <div>
                        <p class="title">Emergency Cases</p>
                        <h5 class="link"><a href="index.html#">+1 24565 89856</a></h5>
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="about-popup-item border-0">
                <h3 class="title">Follow Us</h3>
                <ul class="d-flex align-items-center gap-2 social-iyem">
                    <li>
                        <a href="index.html#" class="social-icon"><i class="fa-brands fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="index.html#" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
                    </li>
                    <li>
                        <a href="index.html#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="index.html#" class="social-icon"><i class="fa-brands fa-linkedin"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <img src="assets/img/bg/offcanvas-bg.png" alt="element" class="element-01">
    </div>
    <!-- end offcanvas -->


    <!-- ScrollToTop -->
    <div class="progress-wrap active-progress">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919px, 307.919px; stroke-dashoffset: 228.265px;">
            </path>
        </svg>
    </div>
    <!-- /ScrollToTop -->

    <!-- jQuery -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- Feather Icon JS -->
    <script src="assets/js/feather.min.js"></script>

    <!-- BacktoTop JS -->
    <script src="assets/js/backToTop.js"></script>

    <!-- select JS -->
    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <!-- Slick Slider -->
    <script src="assets/plugins/slick/slick.min.js"></script>

    <!-- Fancybox JS -->
    <script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>

    <!-- Counter JS -->
    <script src="assets/js/counter.js"></script>

    <!-- Wow JS -->
    <script src="assets/plugins/wow/js/wow.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>

    <script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="d007907878785aba4b025926-|49" defer></script>
    <script>
    $('.banner-carousel-full').slick({
        autoplay: true,
        autoplaySpeed: 2500, // speed of slide change (2.5 sec)
        speed: 1000, // animation speed
        infinite: true,
        arrows: false,
        dots: true,
        pauseOnHover: false, // important (keeps rotating)
        pauseOnFocus: false,
        fade: true,
        cssEase: 'ease-in-out'
    });
    </script>
    <script>
    // Sticky header — guaranteed fallback regardless of script.js
    (function() {
        var header = document.querySelector('header.header');
        if (!header) return;

        function onScroll() {
            if (window.scrollY > 80) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        }
        window.addEventListener('scroll', onScroll, {
            passive: true
        });
        onScroll();
    })();
    </script>
</body>

</html>