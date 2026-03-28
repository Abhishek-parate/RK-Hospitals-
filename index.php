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
    <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/img/favicon.png" type="image/x-icon">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $base_url; ?>assets/img/apple-touch-icon.png">

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

    </style>
</head>

<body><a href="https://doccure.dreamstechnologies.com/cdn-cgi/content?id=9AwWJ6OYRjeADANYsu6BhO8Xh1spBbpICR_64ULwChU-1773164928.2015598-1.0.1.1-pqZR2On.5acTxHq8lZV9fTE0YFo5d6y17w8iArEoNAk"
        aria-hidden="true" rel="nofollow noopener" style="display: none !important; visibility: hidden !important"></a>

    <!-- Main Wrapper -->
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
            <h2 class="section-title">Highlighting the <span class="text-danger">Care & Support</span></h2>
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
                <button type="button" class="slick-arrow spciality-prev"><i class="isax isax-arrow-left"></i></button>
                <button type="button" class="slick-arrow spciality-next"><i class="isax isax-arrow-right-1"></i></button>
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
                            Dr. Agrawal's R.K. Hospital is one of the most trusted and advanced healthcare centers in Nagpur, specializing in Orthopedics and Gynecology. Known for its excellence in robotic knee replacement, hip replacement, spine surgery, and trauma care, the hospital provides world-class treatment using modern technology and highly experienced specialists.
                        </p>

                        <p>
                            Our gynecology and obstetrics department offers comprehensive pregnancy care, high-risk pregnancy management, and advanced laparoscopic surgeries. With a strong focus on patient safety, hygiene, and personalized care, we ensure the best outcomes for both mother and baby.
                        </p>

                        <p>
                            With a 5-star patient rating and a reputation for successful surgeries, expert doctors, and supportive staff, R.K. Hospital stands as a leading choice for quality healthcare in Nagpur. We are available 24/7 for emergency services, ensuring timely and reliable medical care when you need it most.
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
                            <div class="section-sub-title" style="color:#004D8F;">Trusted Healthcare Since 2010</div>
                            <h2 class="section-title">We combine advanced robotic technology with
                                compassionate care to <span style="color:#AB1820 !important;">deliver the best orthopedic &amp;
                                    gynecology outcomes</span></h2>
                        </div>
                    </div>
                </div>
                 
                <div class="row g-4">

                    <!-- Work Item 1 -->
                    <div class="col-xl-3 col-md-6 d-flex wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1s">
                        <div class="work-item-two flex-fill">
                            <h3 class="custom-title">Advanced Joint Replacement Surgery</h3>
                            <div class="work-info">
                                <div class="work-icon">
                                    <img src="assets/img/icons/work-01.svg" alt="icon" class="img-fluid">
                                </div>
                                <div class="count-number">01</div>
                            </div>
                            <p>Expert knee, hip & shoulder replacement using robotic-assisted precision for faster
                                recovery
                                and long-lasting results.</p>
                        </div>
                    </div>
                    <!-- Work Item 1 End -->

                    <!-- Work Item 2 -->
                    <div class="col-xl-3 col-md-6 d-flex wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="2s">
                        <div class="work-item-two flex-fill">
                            <h3 class="custom-title">Women's Health & Gynecology Care</h3>
                            <div class="work-info">
                                <div class="work-icon">
                                    <img src="assets/img/icons/work-02.svg" alt="icon" class="img-fluid">
                                </div>
                                <div class="count-number">02</div>
                            </div>
                            <p>Comprehensive gynecological services including PCOS, fibroids, laparoscopic surgery &
                                complete maternity care.</p>
                        </div>
                    </div>
                    <!-- Work Item 2 End -->
                  
                    <!-- Work Item 3 -->
                    <div class="col-xl-3 col-md-6 d-flex wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="3s">
                        <div class="work-item-two flex-fill">
                            <h3 class="custom-title">Sports Injury & Spine Treatment</h3>
                            <div class="work-info">
                                <div class="work-icon">
                                    <img src="assets/img/icons/work-03.svg" alt="icon" class="img-fluid">
                                </div>
                                <div class="count-number">03</div>
                            </div>
                            <p>Specialized treatment for ligament tears, fractures, spine disorders & sports injuries
                                with
                                physiotherapy support.</p>
                        </div>
                    </div>
                    <!-- Work Item 3 End -->

                    <!-- Work Item 4 -->
                    <div class="col-xl-3 col-md-6 d-flex wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="4s">
                        <div class="work-item-two flex-fill">
                            <h3 class="custom-title">High-Risk Pregnancy & Maternity</h3>
                            <div class="work-info">
                                <div class="work-icon">
                                    <img src="assets/img/icons/work-04.svg" alt="icon" class="img-fluid">
                                </div>
                                <div class="count-number">04</div>
                            </div>
                            <p>Dedicated care for high-risk pregnancies, normal & C-section deliveries with 24/7 NICU &
                                maternity support.</p>
                        </div>
                    </div>
                    <!-- Work Item 4 End -->

                </div>

                <div class="text-center">
                    <div class="connect-badge">
                        Consult our specialists for orthopedic &amp; gynecology concerns
                        <span>Book Appointment Today</span>
                    </div>
                </div>
            </div>
        </section>
        <!-- Why Choose Section Start -->
        <section class="whychoose-section-nine section">
            <div class="container">
                <div class="section-header section-header-nine text-center wow fadeInUp" data-wow-duration="1s">
                    <div class="title"><span class="dot"></span>WHY CHOOSE US</div>
                    <h2 class="section-title"> Your <span class="text-primary text-decoration-underline">Trusted</span>
                        Homecare Partner </h2>
                </div>


                <!-- start row -->
                <div class="row">
                    <!-- Left Item -->
                    <div class="col-lg-3">
                        <div class="choose-item-nine wow fadeInUp" data-wow-duration="1s">
                            <h3 class="custom-title">Medical & Non-Medical Services</h3>
                            <p class="description">From nursing and therapy to companionship and daily assistance</p>
                        </div>
                        <div class="choose-item-nine wow fadeInUp" data-wow-duration="2s">
                            <h3 class="custom-title">Modern Monitoring & Health Tracking</h3>
                            <p class="description">Technology-enabled tracking, digital reports, medication reminders
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="choose-img-nine">
                            <img src="assets/img/about/choose-img-one.jpg" alt="choose-img"
                                class="img-fluid img-one d-none">
                            <video playsinline="playsinline" autoplay muted="muted" loop="loop" id="video">
                                <source src="assets/img/video/video.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="choose-item-nine right-item wow fadeInUp" data-wow-duration="1s">
                            <h3 class="custom-title">Family-Centered Care Approach</h3>
                            <p class="description">We focus on comfort, dignity, independence, and building trust</p>
                        </div>
                        <div class="choose-item-nine right-item wow fadeInUp" data-wow-duration="2s">
                            <h3 class="custom-title">24/7 Support & Emergency</h3>
                            <p class="description">Round-the-clock care, monitoring, and helpline for safety at all
                                times.</p>
                        </div>
                    </div>
                    <!-- right Item -->
                </div>
                <!-- end row -->

                <!-- start row -->
                <div class="row choose-step-nine g-3 justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="choose-step wow fadeInUp" data-wow-duration="1s">
                            <div class="step-icon">
                                <img src="assets/img/bg/choose-step-bg.png" alt="choose-img" class="img-fluid bg-one">
                                <img src="assets/img/icons/step-icon-1.png" alt="choose-img" class="img-fluid icon">
                            </div>
                            <div class="step-content">
                                <span class="level">Step 1</span>
                                <h3 class="custom-title">Select Your Service</h3>
                                <p>Choose from nursing care, elder care, therapy, or medical assistance your specific
                                    needs.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="choose-step wow fadeInUp" data-wow-duration="2s">
                            <div class="step-icon">
                                <img src="assets/img/bg/choose-step-bg.png" alt="choose-img" class="img-fluid bg-one">
                                <img src="assets/img/icons/step-icon-2.png" alt="choose-img" class="img-fluid icon">
                            </div>
                            <div class="step-content">
                                <span class="level">Step 2</span>
                                <h3 class="custom-title">Choose Date & Time</h3>
                                <p>Pick your preferred date and time , and we’ll certified caregiver and share booking
                                    details.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="choose-step wow fadeInUp" data-wow-duration="3s">
                            <div class="step-icon">
                                <img src="assets/img/bg/choose-step-bg.png" alt="choose-img" class="img-fluid bg-one">
                                <img src="assets/img/icons/step-icon-3.png" alt="choose-img" class="img-fluid icon">
                            </div>
                            <div class="step-content">
                                <span class="level">Step 3</span>
                                <h3 class="custom-title">Care Begins at Home</h3>
                                <p>Our professional caregiver arrives at your location and starts personalized care with
                                    full support.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
            <img src="assets/img/bg/choose-bg-5.png" alt="choose" class="img-fluid choose-bg-5">
        </section>
        <!-- Why Choose Section Start-->


        <!-- Services Section -->
        <section class="services-section wow fadeInUp" data-wow-duration="1s">
            <div class="horizontal-slide d-flex" data-direction="right" data-speed="slow">
                <div class="slide-list d-flex gap-4">
                    <div class="services-slide">
                        <h6><a href="index.html#">Multi Speciality Treatments & Doctors</a></h6>
                    </div>
                    <div class="services-slide">
                        <h6><a href="index.html#">Lab Testing Services</a></h6>
                    </div>
                    <div class="services-slide">
                        <h6><a href="index.html#">Medecines & Supplies</a></h6>
                    </div>
                    <div class="services-slide">
                        <h6><a href="index.html#">Hospitals & Clinics</a></h6>
                    </div>
                    <div class="services-slide">
                        <h6><a href="index.html#">Health Care Services</a></h6>
                    </div>
                    <div class="services-slide">
                        <h6><a href="index.html#">Talk to Doctors</a></h6>
                    </div>
                    <div class="services-slide">
                        <h6><a href="index.html#">Home Care Services</a></h6>
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
                            <div class="section-sub-title" style="color:#004D8F;">Our Speciality Services</div>
                            <h2 class="section-title">Comprehensive orthopedic &amp; gynecology care with
                                state-of-the-art
                                technology and <span style="color:#ED1C24;">expert medical professionals</span></h2>
                        </div>
                        <div class="col-xl-4">
                            <div class="text-xl-end">
                                <a href="orthopedic-services.html" class="btn btn-white theme-7-btn">View All
                                    Services<span class="icon"><i class="isax isax-arrow-right-3"></i></span></a>
                            </div>
                        </div>
                        <div class="services-item-seven">
                            <div class="service-header">
                                <h3 class="custom-title">ECG & EKG Tests</h3>
                            </div>
                            <div class="service-content">
                                <p>Accurate testing to monitor and analyze your heart's electrical activity. Helps
                                    detect
                                    arrhythmias and early cardiac abnormalities.</p>
                            </div>
                            <div class="service-img">
                                <img src="assets/img/home/ecg.webp" alt="service" class="img-fluid">
                            </div>
                        </div>
                        <!-- Service Item End -->

                        <!-- Service Item -->
                        <div class="services-item-seven">
                            <div class="service-header">
                                <h3 class="custom-title">Robotic Hip Replacement</h3>
                            </div>
                            <div class="service-content">
                                <p>Advanced robotic hip replacement surgery ensuring accurate implant placement and
                                    quicker
                                    return to daily activities.</p>
                            </div>
                            <div class="service-img">
                                <img src="assets/img/home/robotic.webp" alt="service" class="img-fluid">
                            </div>
                        </div>
                        <!-- Service Item End -->

                        <!-- Service Item -->
                        <div class="services-item-seven active">
                            <div class="service-header">
                                <h3 class="custom-title">Spine Surgery</h3>
                            </div>
                            <div class="service-content">
                                <p>Expert spine surgery for disc problems, spinal stenosis, and deformities using
                                    minimally
                                    invasive techniques.</p>
                            </div>
                            <div class="service-img">
                                <img src="assets/img/home/spline.webp" alt="service" class="img-fluid">
                            </div>
                        </div>
                        <!-- Service Item End -->

                        <!-- Service Item -->
                        <div class="services-item-seven">
                            <div class="service-header">
                                <h3 class="custom-title">Pregnancy &amp; Delivery Care</h3>
                            </div>
                            <div class="service-content">
                                <p>Complete antenatal, delivery, and postnatal care by an experienced gynecologist in a
                                    safe
                                    and hygienic environment.</p>
                            </div>
                            <div class="service-img">
                                <img src="assets/img/home/delivery.webp" alt="service" class="img-fluid">
                            </div>
                        </div>
                        <!-- Service Item End -->

                        <!-- Service Item -->
                        <div class="services-item-seven">
                            <div class="service-header">
                                <h3 class="custom-title">Laparoscopic Gynecology Surgery</h3>
                            </div>
                            <div class="service-content">
                                <p>Keyhole laparoscopic procedures for fibroids, ovarian cysts, endometriosis, and other
                                    gynecological conditions.</p>
                            </div>
                            <div class="service-img">
                                <img src="assets/img/home/laparoscopic.webp" alt="service" class="img-fluid">
                            </div>
                        </div>
                        <!-- Service Item End -->

                    </div>
                    <img src="assets/img/bg/service-bg-01.png" alt="bg" class="service-bg-01">
        </section>



        <!-- ==================== Doctors Listing ==================== -->
        <section class="section" style="background: #fff; padding: 56px 0 80px;">
            <div class="container">

                <!-- Section Header -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="rk-eyebrow">Our Specialists</div>
                        <h2 class="rk-section-title">Explore the team <span>in their Success</span></h2>
                        <p style="color: var(--text-soft); font-size:15px; margin-top:6px;">
                            Showing <strong style="color:var(--red);">2</strong> highly experienced and trusted medical
                            specialists
                        </p>
                    </div>
                </div>

                <!-- Doctor Cards -->
                <div class="row g-4 justify-content-center">

                    <!-- ── Doctor 1 ── -->
                    <div class="col-lg-6">
                        <div class="doc-card">

                            <div class="doc-banner">
                                <div class="deco-ring r1"></div>
                                <div class="deco-ring r2"></div>
                                <div class="doc-photo-wrap">
                                    <img src="assets/img/home/doctor1.webp" alt="Dr. Priyanka Jain Agrawal">
                                    <span class="doc-spec-badge">Gynecologist &amp; Obstetrician</span>
                                </div>
                            </div>

                            <div class="doc-body">
                                <div class="doc-name">Dr. Priyanka Jain Agrawal</div>
                                <div class="doc-degree">MBBS, MS – Obstetrics &amp; Gynecology</div>
                                <div class="doc-hr"></div>

                                <div class="doc-tags">
                                    <span class="doc-tag">Pregnancy Care</span>
                                    <span class="doc-tag">Normal Delivery</span>
                                    <span class="doc-tag">C-Section</span>
                                    <span class="doc-tag">Infertility</span>
                                    <span class="doc-tag">Laparoscopy</span>
                                    <span class="doc-tag">Hysteroscopy</span>
                                </div>

                                <p class="doc-bio">
                                    Dr. Priyanka Jain Agrawal is a trusted Obstetrician-Gynecologist in Nagpur,
                                    specializing
                                    in pregnancy care, infertility treatment, and women's health. She offers antenatal
                                    checkups, normal and cesarean deliveries, menstrual and hormonal disorder
                                    management,
                                    and advanced laparoscopic and hysteroscopy procedures.
                                    <br><br>
                                    Known for her patient-friendly approach, clear guidance, and ethical treatment, she
                                    supports women through every stage — from planning a pregnancy to childbirth and
                                    postpartum care.
                                </p>

                                <div class="doc-info-strip">
                                    <div class="doc-info-item">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>Central Avenue, Nagpur</span>
                                    </div>
                                    <div class="doc-info-item">
                                        <i class="fa-solid fa-clock"></i>
                                        <span><strong>Mon – Sat</strong> &nbsp;·&nbsp; 9 AM – 6 PM</span>
                                    </div>
                                </div>

                                <div class="doc-actions">
                                    <a href="gynecology-services.html" class="btn-rk-primary">
                                        <i class="fa-solid fa-list-ul me-2"></i>Detailed Services
                                    </a>
                                    <a href="contact-us.html" class="btn-rk-outline">
                                        <i class="fa-solid fa-calendar-plus"></i> Book
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- ── /Doctor 1 ── -->

                    <!-- ── Doctor 2 ── -->
                    <div class="col-lg-6">
                        <div class="doc-card">

                            <div class="doc-banner">
                                <div class="deco-ring r1"></div>
                                <div class="deco-ring r2"></div>
                                <div class="doc-photo-wrap">
                                    <img src="assets/img/home/doctor3.webp" alt="Dr. Rahul R. Agrawal">
                                    <span class="doc-spec-badge">Orthopedic Surgeon</span>
                                </div>
                            </div>

                            <div class="doc-body">
                                <div class="doc-name">Dr. Rahul R. Agrawal</div>
                                <div class="doc-degree">MBBS, MS – Orthopedics &amp; Traumatology</div>
                                <div class="doc-hr"></div>

                                <div class="doc-tags">
                                    <span class="doc-tag">Robotic Knee</span>
                                    <span class="doc-tag">Joint Replacement</span>
                                    <span class="doc-tag">Spine Surgery</span>
                                    <span class="doc-tag">Fracture Care</span>
                                    <span class="doc-tag">Arthroscopy</span>
                                    <span class="doc-tag">Sports Injuries</span>
                                </div>

                                <p class="doc-bio">
                                    Dr. Rahul R. Agrawal is a trusted Orthopedic Surgeon in Nagpur, known for treating
                                    fractures, joint problems, and sports injuries with a patient-first approach. He
                                    specializes in joint replacement, robotic-assisted knee and hip surgery, spine
                                    treatment, trauma care, arthroscopy, deformity correction, and pediatric
                                    orthopedics.
                                    <br><br>
                                    With experience across emergency care, rehabilitation, and advanced orthopedic
                                    procedures, Dr. Rahul focuses on accurate diagnosis, transparent guidance, and safe
                                    recovery plans for every patient.
                                </p>

                                <div class="doc-info-strip">
                                    <div class="doc-info-item">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>Central Avenue, Nagpur</span>
                                    </div>
                                    <div class="doc-info-item">
                                        <i class="fa-solid fa-clock"></i>
                                        <span><strong>Mon – Sat</strong> &nbsp;·&nbsp; 9 AM – 6 PM</span>
                                    </div>
                                </div>

                                <div class="doc-actions">
                                    <a href="orthopedic-services.html" class="btn-rk-primary">
                                        <i class="fa-solid fa-list-ul me-2"></i>Detailed Services
                                    </a>
                                    <a href="contact-us.html" class="btn-rk-outline">
                                        <i class="fa-solid fa-calendar-plus"></i> Book
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- ── /Doctor 2 ── -->

                </div>
            </div>
        </section>
        <!-- ==================== /Doctors Listing ==================== -->



        <!-- Testimonial Section -->
        <section class="testimonial-section-one section">
            <div class="container">
                <div class="section-header section-header-one text-center wow fadeInUp" data-wow-duration="1s">
                    <div class="title">Testimonials</div>
                    <h2 class="section-title"> 15k Users <span class="text-danger">Trust Doccure </span>Worldwide </h2>
                </div>

                <!-- Testimonial Slider -->
                <div class="testimonials-slider ">
                    <!-- Item 1 -->
                    <div class="slide-item">
                        <div class="testimonials-item wow fadeInUp" data-wow-duration="1s">
                            <div class="testimonials-info">
                                <div class="review-star justify-content-between">
                                    <div class="rating d-flex">
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </div>
                                    <span>
                                        <img src="assets/img/icons/quote-icon.svg" alt="img">
                                    </span>
                                </div>
                                <div class="testimonial-content">
                                    <h3 class="title">Nice Treatment</h3>
                                    <p class="description">I had a wonderful experience the staff was friendly and
                                        attentive, and Dr. Smith took the time to explain everything clearly.</p>
                                </div>
                                <div class="testimonial-author">
                                    <a href="index.html#" class="avatar avatar-lg">
                                        <img src="assets/img/patients/patient22.jpg" class="rounded-circle" alt="img">
                                    </a>
                                    <div>
                                        <p class="author-name"><a href="index.html#">Deny Hendrawan</a></p>
                                        <p class="author-location">United States</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="slide-item">
                        <div class="testimonials-item wow fadeInUp" data-wow-duration="2s">
                            <div class="testimonials-info">
                                <div class="review-star justify-content-between">
                                    <div class="rating d-flex">
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </div>
                                    <span>
                                        <img src="assets/img/icons/quote-icon.svg" alt="img">
                                    </span>
                                </div>
                                <div class="testimonial-content">
                                    <h3 class="title">Nice Support</h3>
                                    <p class="description">My experience was excellent. The staff was polite and
                                        attentive, and the doctor took the time to explain every step clearly.</p>
                                </div>
                                <div class="testimonial-author">
                                    <a href="index.html#" class="avatar avatar-lg">
                                        <img src="assets/img/patients/patient2.jpg" class="rounded-circle" alt="img">
                                    </a>
                                    <div>
                                        <p class="author-name"><a href="index.html#">Brooks Steave</a></p>
                                        <p class="author-location">Dallas, CA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="slide-item">
                        <div class="testimonials-item wow fadeInUp" data-wow-duration="3s">
                            <div class="testimonials-info">
                                <div class="review-star justify-content-between">
                                    <div class="rating d-flex">
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </div>
                                    <span>
                                        <img src="assets/img/icons/quote-icon.svg" alt="img">
                                    </span>
                                </div>
                                <div class="testimonial-content">
                                    <h3 class="title">Excellent Service</h3>
                                    <p class="description">I had a wonderful experience the staff was friendly and
                                        attentive, and Dr. Smith took the time to explain everything clearly.</p>
                                </div>
                                <div class="testimonial-author">
                                    <a href="index.html#" class="avatar avatar-lg">
                                        <img src="assets/img/patients/patient23.jpg" class="rounded-circle" alt="img">
                                    </a>
                                    <div>
                                        <p class="author-name"><a href="index.html#">Sofia Doe</a></p>
                                        <p class="author-location">Los Boston, USA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 4 -->
                    <div class="slide-item">
                        <div class="testimonials-item wow fadeInUp" data-wow-duration="4s">
                            <div class="testimonials-info">
                                <div class="review-star justify-content-between">
                                    <div class="rating d-flex">
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled me-1"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </div>
                                    <span>
                                        <img src="assets/img/icons/quote-icon.svg" alt="img">
                                    </span>
                                </div>
                                <div class="testimonial-content">
                                    <h3 class="title">Good Hospitability</h3>
                                    <p class="description">Genuinely cares about his patients. He helped me understand
                                        my condition and worked with me to create a plan.</p>
                                </div>
                                <div class="testimonial-author">
                                    <a href="index.html#" class="avatar avatar-lg">
                                        <img src="assets/img/patients/patient21.jpg" class="rounded-circle" alt="img">
                                    </a>
                                    <div>
                                        <p class="author-name"><a href="index.html#">Johnson DWayne</a></p>
                                        <p class="author-location">San Francisco, CA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /Testimonial Slider -->
                </div>
        </section>
        <!-- /Testimonial Section -->



        <!-- Start Faq -->
        <section class="faq-section-eight section">
            <div class="container">
                <!-- start row -->
                <div class="row">
                    <div class="col-lg-5">
                        <div class="faq-support">
                            <img src="assets/img/home/faq1.webp" alt="faq-img" class="img-fluid img-1">
                            
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="section-header section-header-eight">
                            <div class="section-sub-title"><span class="dot"></span>Our Experts Respond</div>
                            <h2 class="section-title">Commonly <span class="line">Asked Questions</span></h2>
                        </div>
                        <div class="faq-info wow zoomIn" data-wow-duration="1s">
                            <div class="accordion" id="faq-details-one">

                                <!-- FAQ Item -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="headingOne">
                                        <a href="javascript:void(0);" class="accordion-button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            How do I book an appointment with a doctor?
                                        </a>
                                    </h3>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        data-bs-parent="#faq-details-one">
                                        <div class="accordion-body">
                                            <div class="accordion-content">
                                                <p>Yes, simply visit our website and log in or create an account. Search
                                                    for a doctor based on specialization, location, or availability &
                                                    confirm your booking.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /FAQ Item -->

                                <!-- FAQ Item -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="headingTwo">
                                        <a href="javascript:void(0);" class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            Can I request a specific doctor when booking my appointment?
                                        </a>
                                    </h3>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-details-one">
                                        <div class="accordion-body">
                                            <div class="accordion-content">
                                                <p>Yes, you can usually request a specific doctor when booking your
                                                    appointment, though availability may vary based on their schedule.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /FAQ Item -->

                                <!-- FAQ Item -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="headingThree">
                                        <a href="javascript:void(0);" class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree">
                                            What should I do if I need to cancel or reschedule my appointment?
                                        </a>
                                    </h3>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-details-one">
                                        <div class="accordion-body">
                                            <div class="accordion-content">
                                                <p>If you need to cancel or reschedule your appointment, contact the
                                                    doctor as soon as possible to inform them and to reschedule for
                                                    another available time slot.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /FAQ Item -->

                                <!-- FAQ Item -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="headingFour">
                                        <a href="javascript:void(0);" class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                            aria-expanded="false" aria-controls="collapseFour">
                                            What if I'm running late for my appointment?
                                        </a>
                                    </h3>
                                    <div id="collapseFour" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-details-one">
                                        <div class="accordion-body">
                                            <div class="accordion-content">
                                                <p>If you know you will be late, it's courteous to call the doctor's
                                                    office and inform them. Depending on their policy and schedule, they
                                                    may be able to accommodate you or reschedule your appointment.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /FAQ Item -->

                                <!-- FAQ Item -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="headingFive">
                                        <a href="javascript:void(0);" class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            Can I book appointments for family members or dependents?
                                        </a>
                                    </h3>
                                    <div id="collapseFive" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-details-one">
                                        <div class="accordion-body">
                                            <div class="accordion-content">
                                                <p>Yes, in many cases, you can book appointments for family members or
                                                    dependents. However, you may need to provide their personal
                                                    information and consent to do so.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /FAQ Item -->

                            </div>
                        </div>
                                     
                    </div>
                </div>
                <!-- end row -->
            </div>
        </section>
        <!-- End Faq -->
        <!-- /Article Section -->
         <?php include 'include/latest-blog.php'; ?>
         
        <!-- Info Section -->
        <section class="info-section">
            <div class="container">
                <div class="contact-info">
                    <div class="info-col">
                        <div class="wow fadeInUp" data-wow-duration="1s">
                            <h3 class="info-title">Working for Your Better Health.</h3>
                        </div>
                        <div class="support-info wow fadeInUp" data-wow-duration="1s">
                            <div class="con-info">
                                <span class="con-icon">
                                    <i class="isax isax-headphone5"></i>
                                </span>
                                <div class="con-details">
                                    <p class="title">Customer Support</p>
                                    <p class="description">+1 56589 54598</p>
                                </div>
                            </div>
                            <div class="con-info">
                                <span class="con-icon">
                                    <i class="isax isax-message-25"></i>
                                </span>
                                <div class="con-details">
                                    <p class="title">Drop Us an Email</p>
                                    <p class="description"><a
                                            href="https://doccure.dreamstechnologies.com/cdn-cgi/l/email-protection"
                                            class="__cf_email__"
                                            data-cfemail="ef86818980dedddad9af8a978e829f838ac18c8082">[email&#160;protected]</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img src="assets/img/bg/info-bg.png" alt="element" class="img-fluid element-01">
                </div>
            </div>
        </section>
        <!-- /Info Section -->
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
</body>

</html>