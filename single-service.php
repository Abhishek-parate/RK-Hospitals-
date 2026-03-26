<?php $base_url = "http://localhost/rkhospital/"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ✅ SEO Meta Tags -->
    <title>PCOD Treatment in Nagpur | Polycystic Ovary Disease | RK Hospital</title>
    <meta name="description"
        content="Expert PCOD & PCOS treatment in Nagpur at RK Hospital. Our specialist gynecologists offer hormonal therapy, diet management & advanced care for irregular periods, infertility & acne caused by PCOD.">
    <meta name="keywords"
        content="PCOD treatment Nagpur, PCOS specialist Nagpur, polycystic ovary disease hospital Nagpur, PCOD doctor Nagpur, PCOS treatment, irregular periods treatment Nagpur, RK Hospital gynecology">
    <meta name="author" content="RK Hospital Nagpur">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo $base_url; ?>pcod-treatment.php">

    <!-- ✅ Open Graph (Social Sharing) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $base_url; ?>pcod-treatment.php">
    <meta property="og:title" content="PCOD Treatment in Nagpur | RK Hospital">
    <meta property="og:description"
        content="Get expert PCOD/PCOS treatment at RK Hospital Nagpur. Book an appointment with our specialist gynecologist today.">
    <meta property="og:image" content="<?php echo $base_url; ?>assets/img/services/pcod-treatment.jpg">

    <!-- ✅ Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="PCOD Treatment in Nagpur | RK Hospital">
    <meta name="twitter:description"
        content="Expert PCOD & PCOS care at RK Hospital Nagpur. Advanced hormonal therapy, diet plans & surgical options available.">
    <meta name="twitter:image" content="<?php echo $base_url; ?>assets/img/services/pcod-treatment.jpg">

    <!-- ✅ Schema.org Structured Data (Boosts Google Rich Results) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MedicalWebPage",
        "name": "PCOD Treatment in Nagpur",
        "description": "Expert PCOD and PCOS treatment at RK Hospital Nagpur including hormonal therapy, diet management and infertility care.",
        "url": "<?php echo $base_url; ?>pcod-treatment.php",
        "about": {
            "@type": "MedicalCondition",
            "name": "Polycystic Ovary Disease (PCOD)",
            "alternateName": "PCOS",
            "description": "PCOD is a hormonal disorder causing enlarged ovaries with small cysts on the outer edges.",
            "possibleTreatment": [
                "Hormonal Therapy",
                "Lifestyle and Diet Management",
                "Ovulation Induction",
                "Laparoscopic Ovarian Drilling"
            ],
            "signOrSymptom": [
                "Irregular Periods",
                "Excessive Hair Growth",
                "Acne",
                "Weight Gain",
                "Hair Thinning"
            ]
        },
        "breadcrumb": {
            "@type": "BreadcrumbList",
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "<?php echo $base_url; ?>"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Services",
                    "item": "<?php echo $base_url; ?>services.php"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "PCOD Treatment",
                    "item": "<?php echo $base_url; ?>pcod-treatment.php"
                }
            ]
        },
        "publisher": {
            "@type": "Hospital",
            "name": "RK Hospital",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Nagpur",
                "addressRegion": "Maharashtra",
                "addressCountry": "IN"
            },
            "telephone": "+91-XXXXXXXXXX"
        }
    }
    </script>

    <!-- FAQ Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [{
                "@type": "Question",
                "name": "What is PCOD (Polycystic Ovary Disease)?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "PCOD is a hormonal disorder in which the ovaries produce immature or partially mature eggs in large numbers, which over time become cysts in the ovaries. It causes irregular periods, weight gain, acne, and hormonal imbalance."
                }
            },
            {
                "@type": "Question",
                "name": "Is PCOD curable permanently?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "PCOD cannot be permanently cured but it can be effectively managed with medication, lifestyle changes, diet management, and hormonal therapy under a specialist's guidance."
                }
            },
            {
                "@type": "Question",
                "name": "Can PCOD cause infertility?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Yes, PCOD is one of the leading causes of infertility in women. However, with proper treatment like ovulation induction and assisted reproductive techniques, many women with PCOD can conceive successfully."
                }
            },
            {
                "@type": "Question",
                "name": "What is the difference between PCOD and PCOS?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "PCOD (Polycystic Ovary Disease) is a condition where ovaries release immature eggs. PCOS (Polycystic Ovary Syndrome) is a more severe metabolic disorder involving hormonal imbalance. PCOS has more health complications than PCOD."
                }
            },
            {
                "@type": "Question",
                "name": "How is PCOD diagnosed?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "PCOD is diagnosed through pelvic ultrasound, blood hormone tests (LH, FSH, testosterone, insulin levels), and clinical evaluation of symptoms by a gynecologist."
                }
            }
        ]
    }
    </script>


    <style>
    /* Calendar icon */
    .date-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #0d6efd;
        pointer-events: none;
    }

    /* Flatpickr theme upgrade */
    .flatpickr-calendar {
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        font-family: inherit;
    }

    .flatpickr-day.selected {
        background: #0d6efd;
        border-color: #0d6efd;
    }

    .flatpickr-day:hover {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .aboutsection {
        padding: 40px 0px 0px 0px;
    }

    .icon-style {
        width: 60px;
        height: 60px;
        background: #6f42c1;
        /* change as per your theme */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-style i {
        color: #fff;
        font-size: 24px;
    }

    /* Container feel */
    .custom-point {
        position: relative;
        padding: 16px 16px 16px 45px;
        background: #ffffff;
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 1px solid #f1f1f1;
    }

    /* Hover effect */
    .custom-point:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    /* Attractive gradient pointer */
    .custom-point::before {
        content: "";
        position: absolute;
        left: 15px;
        top: 20px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d6efd, #00c6ff);
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
    }

    /* Heading */
    .custom-point h6 {
        margin-bottom: 5px;
        font-weight: 600;
        color: #0b1c39;
    }

    /* Text */
    .custom-point p {
        margin: 0;
        font-size: 14px;
        color: #6c757d;
    }
    </style>
    <!-- Favicon -->


    <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/img/favicon.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $base_url; ?>assets/img/apple-touch-icon.png">

    <!-- Theme Settings JS -->
    <script src="<?php echo $base_url; ?>assets/js/theme-script.js"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/animate.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/iconsax.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/feather.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/slick/slick.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/slick/slick-theme.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/wow/css/animate.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fancybox/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
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
        <!-- Breadcrumb -->
        <!-- Breadcrumb -->
        <!-- Breadcrumb -->
        <!-- Breadcrumb -->
        <div class="breadcrumb-bar" style="
    min-height: 700px; 
    display: flex; 
    align-items: center;
    position: relative;
    background: url('<?php echo $base_url; ?>assets/img/service/service-01.jpg') center center / cover no-repeat;">

            <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.45);"></div>

            <div class="container" style="position: relative; z-index: 2;">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo $base_url; ?>index.php">
                                        <i class="isax isax-home-15"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo $base_url; ?>services.php">Services</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">PCOD Treatment</li>
                            </ol>
                            <h1 class="breadcrumb-title">PCOD / PCOS Treatment in Nagpur</h1>
                        </nav>
                    </div>
                </div>
            </div>

        </div>

        <!-- /Breadcrumb -->


        <!-- Add this in <head> if not already added -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- About / Hero Section - PCOD -->
        <div class="about-sec aboutsection">
            <div class="container">
                <div class="row align-items-center">

                    <!-- Left Image -->
                    <div class="col-lg-6">
                        <div class="about-img-ten">
                            <div class="about-img-01">
                                <img src="<?php echo $base_url; ?>assets/img/doctors/doctor-05.jpg" class="img-fluid"
                                    alt="PCOD PCOS Treatment in Nagpur - RK Hospital">
                            </div>
                        </div>
                    </div>
                    <!-- /Left Image -->

                    <!-- Right Content -->
                    <div class="col-lg-6">
                        <div class="about-content-ten">

                            <div class="section-header section-header-ten">
                                <div class="section-sub-title">
                                    <span class="dot"></span>Gynecology &amp; Women's Health — Nagpur
                                </div>
                                <h2 class="section-title">Your Trusted Partner in PCOD &amp; PCOS Care</h2>
                                <p>
                                    Dealing with PCOD can feel overwhelming — from irregular periods and weight gain
                                    to acne and fertility concerns. At RK Hospital, Nagpur, our experienced
                                    gynecologists provide compassionate, science-backed PCOD treatment designed
                                    specifically for you. We combine advanced diagnostics, hormonal therapy,
                                    and lifestyle management to help you reclaim your health and confidence.
                                </p>
                            </div>

                            <!-- Point 1 -->
                            <div class="mission-item-ten wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1s">
                                <div class="mission-icon">
                                    <div class="mission-inner icon-style">
                                        <i class="fa-solid fa-user-doctor"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="custom-title">15+ Years of PCOD &amp; Gynecology Expertise</h3>
                                    <p>
                                        Trusted by thousands of women across Nagpur for PCOD, PCOS,
                                        hormonal imbalance, and infertility treatment.
                                    </p>
                                </div>
                            </div>

                            <!-- Point 2 -->
                            <div class="mission-item-ten wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="1s">
                                <div class="mission-icon">
                                    <div class="mission-inner icon-style">
                                        <i class="fa-solid fa-heart-pulse"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="custom-title">Holistic &amp; Personalised PCOD Treatment</h3>
                                    <p>
                                        From hormonal therapy, diet &amp; nutrition counselling, ovulation
                                        induction to minimally invasive surgery — all under one roof.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /Right Content -->

                </div>
            </div>
        </div>
        <!-- /About / Hero Section -->


        <div class="content">
            <div class="container">
                <div class="row">

                    <!-- ===================== MAIN CONTENT ===================== -->
                    <div class="col-md-7 col-lg-9 col-xl-9">

                        <!-- Service Hero Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="doctor-widget">
                                    <div class="doc-info-left">
                                        <div class="doctor-img1">
                                            <img src="<?php echo $base_url; ?>assets/img/service/service-02.jpg"
                                                class="img-fluid" alt="PCOD Treatment Nagpur - RK Hospital">
                                        </div>
                                        <div class="doc-info-cont">
                                            <h2 class="doc-name mb-2">PCOD / PCOS Treatment</h2>
                                            <p class="text-muted mb-1">
                                                <i class="isax isax-hospital me-1 text-primary"></i>
                                                Department of Gynecology &amp; Women's Health
                                            </p>
                                            <p class="text-muted mb-2">
                                                <i class="isax isax-location me-1 text-primary"></i>
                                                RK Hospital, Nagpur, Maharashtra
                                            </p>
                                            <p>Polycystic Ovary Disease (PCOD) is one of the most common hormonal
                                                disorders affecting women of reproductive age. At RK Hospital, Nagpur,
                                                our expert gynecologists provide comprehensive and personalized PCOD
                                                treatment to help you regain hormonal balance and improve quality of
                                                life.</p>
                                            <div class="feature-product pt-3">
                                                <span><b>Conditions Treated:</b></span>
                                                <ul>
                                                    <li>Irregular or missed periods</li>
                                                    <li>Hormonal imbalance &amp; cysts</li>
                                                    <li>PCOD-related infertility</li>
                                                    <li>Excessive hair growth (hirsutism)</li>
                                                    <li>Acne &amp; oily skin due to PCOD</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Service Hero Card -->

                        <!-- Detailed Content Card -->
                        <div class="card">
                            <div class="card-body pt-0">

                                <h2 class="pt-4">About PCOD Treatment at RK Hospital</h2>
                                <hr>

                                <div class="tab-content pt-3">
                                    <div class="tab-pane fade show active">

                                        <!-- What is PCOD -->
                                        <div class="widget about-widget">
                                            <h3 class="widget-title">What is PCOD (Polycystic Ovary Disease)?</h3>
                                            <p>PCOD (Polycystic Ovary Disease), also referred to as PCOS (Polycystic
                                                Ovary Syndrome), is a hormonal disorder common among women of
                                                reproductive age. In PCOD, the ovaries produce a large number of
                                                immature or partially mature eggs that eventually turn into small cysts.
                                                This leads to enlarged ovaries and disruption in normal hormonal
                                                production.</p>
                                            <p>PCOD affects approximately <strong>1 in 5 women</strong> in India, making
                                                it one of the leading causes of hormonal imbalance, irregular
                                                menstruation, and infertility. Early diagnosis and treatment at RK
                                                Hospital, Nagpur can significantly improve symptoms and long-term health
                                                outcomes.</p>
                                        </div>

                                        <!-- Symptoms -->
                                        <div class="widget awards-widget">
                                            <h3 class="widget-title">Common Symptoms of PCOD / PCOS</h3>
                                            <p>Recognizing PCOD symptoms early is key to effective treatment. The most
                                                common signs include:</p>
                                            <div class="experience-box">
                                                <ul class="experience-list">
                                                    <li>
                                                        <div class="experience-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <p><strong>Irregular Periods:</strong> Infrequent,
                                                                    irregular, or prolonged menstrual cycles are the
                                                                    most common sign of PCOD.</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="experience-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <p><strong>Excess Androgen:</strong> Elevated levels of
                                                                    male hormones causing excessive facial or body hair
                                                                    (hirsutism), severe acne, and male-pattern baldness.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="experience-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <p><strong>Polycystic Ovaries:</strong> Ovaries become
                                                                    enlarged and contain follicles surrounding the eggs,
                                                                    detected through ultrasound.</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="experience-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <p><strong>Weight Gain:</strong> Unexplained weight gain
                                                                    or difficulty in losing weight, particularly around
                                                                    the abdomen.</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="experience-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <p><strong>Hair Thinning &amp; Scalp Hair Loss:</strong>
                                                                    Thinning of hair on the scalp resembling
                                                                    male-pattern baldness.</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="experience-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <p><strong>Mood Changes &amp; Depression:</strong>
                                                                    Hormonal imbalance leads to anxiety, depression, and
                                                                    mood swings in many PCOD patients.</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Causes -->
                                        <div class="widget about-widget">
                                            <h3 class="widget-title">Causes &amp; Risk Factors of PCOD</h3>
                                            <p>The exact cause of PCOD is unknown, but several factors play a major
                                                role:</p>
                                            <div class="row g-3 mt-1">
                                                <div class="col-md-6">
                                                    <div class="card border-0 bg-light p-3 h-100">
                                                        <div class="d-flex align-items-start gap-2">
                                                            <i class="isax isax-dna text-primary fs-4 mt-1"></i>
                                                            <div>
                                                                <h5 class="mb-1">Genetics</h5>
                                                                <p class="mb-0 text-muted small">Family history of PCOD
                                                                    significantly increases the risk. If your mother or
                                                                    sister has PCOD, you are more likely to develop it.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card border-0 bg-light p-3 h-100">
                                                        <div class="d-flex align-items-start gap-2">
                                                            <i class="isax isax-activity text-primary fs-4 mt-1"></i>
                                                            <div>
                                                                <h5 class="mb-1">Insulin Resistance</h5>
                                                                <p class="mb-0 text-muted small">High insulin levels
                                                                    trigger extra androgen production in the ovaries,
                                                                    which interferes with normal ovulation.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card border-0 bg-light p-3 h-100">
                                                        <div class="d-flex align-items-start gap-2">
                                                            <i class="isax isax-health text-primary fs-4 mt-1"></i>
                                                            <div>
                                                                <h5 class="mb-1">Hormonal Imbalance</h5>
                                                                <p class="mb-0 text-muted small">Elevated levels of
                                                                    androgens (male hormones) prevent ovaries from
                                                                    producing eggs normally, causing cyst formation.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card border-0 bg-light p-3 h-100">
                                                        <div class="d-flex align-items-start gap-2">
                                                            <i class="isax isax-weight text-primary fs-4 mt-1"></i>
                                                            <div>
                                                                <h5 class="mb-1">Unhealthy Lifestyle</h5>
                                                                <p class="mb-0 text-muted small">Sedentary lifestyle,
                                                                    junk food consumption, poor sleep, and chronic
                                                                    stress are major contributing factors to PCOD.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Diagnosis -->
                                        <div class="widget about-widget">
                                            <h3 class="widget-title">How is PCOD Diagnosed at RK Hospital?</h3>
                                            <p>Our expert gynecologists at RK Hospital, Nagpur follow a thorough
                                                diagnostic approach to confirm PCOD:</p>
                                            <div class="row g-3 mt-1">
                                                <div class="col-md-4 text-center">
                                                    <div class="card border-primary p-3">
                                                        <h6>Pelvic Ultrasound</h6>
                                                        <p class="small text-muted mb-0">Detects enlarged ovaries and
                                                            presence of cysts</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <div class="card border-primary p-3">
                                                        <h6>Blood Hormone Tests</h6>
                                                        <p class="small text-muted mb-0">LH, FSH, testosterone, insulin
                                                            &amp; thyroid levels</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <div class="card border-primary p-3">
                                                        <h6>Clinical Evaluation</h6>
                                                        <p class="small text-muted mb-0">Review of symptoms, BMI, cycle
                                                            history &amp; physical exam</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Treatment Options -->
                                        <div class="widget about-widget">
                                            <h3 class="widget-title">PCOD Treatment Options at RK Hospital, Nagpur</h3>
                                            <p>We offer a multi-disciplinary, personalized approach to PCOD treatment
                                                combining medical, hormonal, and lifestyle-based interventions:</p>

                                            <div class="accordion mt-3" id="pcod-treatment-accordion">

                                                <div class="accordion-item">
                                                    <h4 class="accordion-header">
                                                        <a href="javascript:void(0);" class="accordion-button"
                                                            data-bs-toggle="collapse" data-bs-target="#t1"
                                                            aria-expanded="true">
                                                            Hormonal Therapy &amp; Medications
                                                        </a>
                                                    </h4>
                                                    <div id="t1" class="accordion-collapse collapse show"
                                                        data-bs-parent="#pcod-treatment-accordion">
                                                        <div class="accordion-body">
                                                            <p>Oral contraceptive pills help regulate menstrual cycles
                                                                and reduce androgen levels. Metformin is prescribed to
                                                                manage insulin resistance, a core driver of PCOD.
                                                                Anti-androgen medications reduce excessive hair growth
                                                                and acne. All medications are carefully prescribed based
                                                                on individual hormonal profiles.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h4 class="accordion-header">
                                                        <a href="javascript:void(0);" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#t2"
                                                            aria-expanded="false">
                                                            Diet, Nutrition &amp; Lifestyle Management
                                                        </a>
                                                    </h4>
                                                    <div id="t2" class="accordion-collapse collapse"
                                                        data-bs-parent="#pcod-treatment-accordion">
                                                        <div class="accordion-body">
                                                            <p>A low-glycemic diet, regular exercise, and weight
                                                                management are among the most effective tools to reverse
                                                                PCOD symptoms. Our team includes nutritionists who
                                                                create personalized PCOD diet plans. Even a 5–10%
                                                                reduction in body weight can restore ovulation and
                                                                improve hormonal balance significantly.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h4 class="accordion-header">
                                                        <a href="javascript:void(0);" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#t3"
                                                            aria-expanded="false">
                                                            Ovulation Induction (For Fertility)
                                                        </a>
                                                    </h4>
                                                    <div id="t3" class="accordion-collapse collapse"
                                                        data-bs-parent="#pcod-treatment-accordion">
                                                        <div class="accordion-body">
                                                            <p>For women with PCOD who are trying to conceive, ovulation
                                                                induction with Clomiphene Citrate or Letrozole is used.
                                                                These medications stimulate the ovaries to release eggs
                                                                regularly, increasing the chances of successful
                                                                pregnancy. This is monitored via follicular ultrasound
                                                                studies.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h4 class="accordion-header">
                                                        <a href="javascript:void(0);" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#t4"
                                                            aria-expanded="false">
                                                            Laparoscopic Ovarian Drilling (LOD)
                                                        </a>
                                                    </h4>
                                                    <div id="t4" class="accordion-collapse collapse"
                                                        data-bs-parent="#pcod-treatment-accordion">
                                                        <div class="accordion-body">
                                                            <p>For patients who do not respond to medication,
                                                                Laparoscopic Ovarian Drilling (LOD) is a minimally
                                                                invasive surgical procedure. Small holes are made in the
                                                                ovary using laser energy to destroy the tissue producing
                                                                excess androgens. This helps restore normal ovulation
                                                                and is done as day-care surgery at RK Hospital.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Why Choose Us -->
                                        <div class="widget about-widget">
                                            <h3 class="widget-title">
                                                Why Choose RK Hospital for PCOD Treatment in Nagpur?
                                            </h3>

                                            <div class="row g-4 mt-2">

                                                <div class="col-md-6">
                                                    <div class="custom-point">
                                                        <h6>Experienced Gynecologists</h6>
                                                        <p>Team of specialized gynecologists with 15+ years of
                                                            experience treating PCOD & PCOS.</p>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="custom-point">
                                                        <h6>Advanced Diagnostic Equipment</h6>
                                                        <p>State-of-the-art ultrasound, hormonal labs and fertility
                                                            monitoring equipment.</p>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="custom-point">
                                                        <h6>Holistic & Personalized Care</h6>
                                                        <p>Comprehensive care including gynecologist, nutritionist, and
                                                            mental health support all under one roof.</p>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="custom-point">
                                                        <h6>Easy Appointment Booking</h6>
                                                        <p>Book online or call us. Flexible slots including evenings and
                                                            weekends available.</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- FAQ Section -->
                                        <div class="widget about-widget mb-0">
                                            <h3 class="widget-title">Frequently Asked Questions About PCOD</h3>
                                            <div class="accordion mt-3" id="faq-pcod">

                                                <div class="accordion-item">
                                                    <h4 class="accordion-header" id="faq1-head">
                                                        <a href="javascript:void(0);" class="accordion-button"
                                                            data-bs-toggle="collapse" data-bs-target="#faq1"
                                                            aria-expanded="true">
                                                            What is the difference between PCOD and PCOS?
                                                        </a>
                                                    </h4>
                                                    <div id="faq1" class="accordion-collapse collapse show"
                                                        data-bs-parent="#faq-pcod">
                                                        <div class="accordion-body">
                                                            <p>PCOD is a condition where ovaries release immature eggs
                                                                which form cysts, causing hormonal imbalance. PCOS is a
                                                                more severe metabolic disorder involving insulin
                                                                resistance, higher androgen levels, and more complex
                                                                health complications. Both are manageable with proper
                                                                treatment at RK Hospital.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h4 class="accordion-header">
                                                        <a href="javascript:void(0);" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#faq2"
                                                            aria-expanded="false">
                                                            Is PCOD curable permanently?
                                                        </a>
                                                    </h4>
                                                    <div id="faq2" class="accordion-collapse collapse"
                                                        data-bs-parent="#faq-pcod">
                                                        <div class="accordion-body">
                                                            <p>PCOD cannot be completely cured but symptoms can be
                                                                effectively managed through hormonal therapy, lifestyle
                                                                changes, and diet management. Many women lead perfectly
                                                                normal and healthy lives with PCOD when it is properly
                                                                managed.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h4 class="accordion-header">
                                                        <a href="javascript:void(0);" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#faq3"
                                                            aria-expanded="false">
                                                            Can I get pregnant if I have PCOD?
                                                        </a>
                                                    </h4>
                                                    <div id="faq3" class="accordion-collapse collapse"
                                                        data-bs-parent="#faq-pcod">
                                                        <div class="accordion-body">
                                                            <p>Yes! Many women with PCOD conceive successfully with the
                                                                right treatment. Ovulation induction, fertility
                                                                medications, and assisted reproductive techniques like
                                                                IUI and IVF are available at RK Hospital to help you
                                                                achieve pregnancy.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h4 class="accordion-header">
                                                        <a href="javascript:void(0);" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#faq4"
                                                            aria-expanded="false">
                                                            What foods should I avoid with PCOD?
                                                        </a>
                                                    </h4>
                                                    <div id="faq4" class="accordion-collapse collapse"
                                                        data-bs-parent="#faq-pcod">
                                                        <div class="accordion-body">
                                                            <p>Avoid high-glycemic foods like white rice, refined flour,
                                                                sugary drinks, processed foods, and trans fats. Instead,
                                                                eat more whole grains, leafy vegetables, fruits, lean
                                                                proteins, and healthy fats like nuts and seeds. Our
                                                                nutritionist at RK Hospital can create a personalized
                                                                PCOD diet plan for you.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h4 class="accordion-header">
                                                        <a href="javascript:void(0);" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#faq5"
                                                            aria-expanded="false">
                                                            How is PCOD diagnosed at RK Hospital, Nagpur?
                                                        </a>
                                                    </h4>
                                                    <div id="faq5" class="accordion-collapse collapse"
                                                        data-bs-parent="#faq-pcod">
                                                        <div class="accordion-body">
                                                            <p>PCOD diagnosis at RK Hospital includes pelvic ultrasound
                                                                to detect ovarian cysts, blood tests to measure hormone
                                                                levels (LH, FSH, testosterone, insulin, thyroid), and a
                                                                detailed clinical evaluation of your menstrual history
                                                                and physical symptoms.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- /FAQ -->

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /Detailed Content Card -->

                    </div>
                    <!-- ===================== /MAIN CONTENT ===================== -->


                    <!-- ===================== STICKY SIDEBAR ===================== -->
                    <div class="col-md-5 col-lg-3 col-xl-3 theiaStickySidebar">

                        <!-- Book Appointment Card -->
                        <div class="card search-filter">
                            <div class="card-body">
                                <h4 class="card-title mb-3">
                                    <i class="isax isax-calendar-add me-2 text-primary"></i>Book an Appointment
                                </h4>
                                <form action="<?php echo $baseurl ?>booking.php" method="POST" id="appointmentForm"
                                    novalidate>
                                    <input type="hidden" name="department" value="gynecology">

                                    <!-- Full Name -->
                                    <div class="mb-3">
                                        <label class="form-label" for="apptName">
                                            Full Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" id="apptName" class="form-control"
                                            placeholder="Enter your full name" autocomplete="name">
                                        <div class="invalid-feedback">
                                            Please enter your full name (letters only, min 3 characters).
                                        </div>
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="mb-3">
                                        <label class="form-label" for="apptPhone">
                                            Phone Number <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel" name="phone" id="apptPhone" class="form-control"
                                            placeholder="+91 XXXXX XXXXX" maxlength="13" autocomplete="tel">
                                        <div class="invalid-feedback">
                                            Enter a valid 10-digit Indian mobile number (e.g. 9876543210 or +91...).
                                        </div>
                                    </div>

                                    <!-- Preferred Date -->
                                    <div class="mb-3">
                                        <label class="form-label" for="appointmentDate">
                                            Preferred Date <span class="text-danger">*</span>
                                        </label>
                                        <div class="position-relative">
                                            <input type="text" name="date" id="appointmentDate" class="form-control"
                                                placeholder="Select Date" readonly>
                                            <span class="date-icon"><i class="isax isax-calendar"></i></span>
                                        </div>
                                        <div class="text-danger small mt-1" id="dateError" style="display:none;">
                                            Please select a preferred appointment date.
                                        </div>
                                    </div>

                                    <!-- Service -->
                                    <div class="mb-3">
                                        <label class="form-label" for="apptService">
                                            Service <span class="text-danger">*</span>
                                        </label>
                                        <select name="service" id="apptService" class="form-control select">
                                            <option value="">-- Select a Service --</option>
                                            <option value="pcod">PCOD / PCOS Treatment</option>
                                            <option value="infertility">Infertility Consultation</option>
                                            <option value="gynecology">General Gynecology</option>
                                            <option value="hormonal">Hormonal Imbalance</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a service.</div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="clinic-booking mt-3">
                                        <button type="submit" class="btn btn-primary btn-primary-gradient w-100">
                                            <i class="isax isax-calendar-add me-2"></i>Book Appointment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-- Quick Contact Card -->
                        <div class="card search-filter">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Quick Contact</h4>

                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item px-0">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="contact-icon">
                                                <i class="isax isax-call-calling"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-muted small">Emergency / OPD</p>
                                                <a href="tel:+91XXXXXXXXXX"><b>+91 XXXXX XXXXX</b></a>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item px-0">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="contact-icon">
                                                <i class="isax isax-messages-3"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-muted small">Email Us</p>
                                                <a href="mailto:info@rkhospital.com"><b>info@rkhospital.com</b></a>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item px-0">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="contact-icon">
                                                <i class="isax isax-location"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-muted small">Location</p>
                                                <b>Nagpur, Maharashtra</b>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item px-0 border-0">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="contact-icon">
                                                <i class="isax isax-clock"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-muted small">Working Hours</p>
                                                <b>Mon–Sat: 9AM – 7PM</b>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!-- /Quick Contact Card -->

                        <!-- Related Services Card -->
                        <div class="card search-filter">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Related Services</h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 border-0 py-1">
                                        <a href="<?php echo $base_url; ?>infertility-treatment.php"
                                            class="d-flex align-items-center gap-2 text-dark">
                                            <i class="isax isax-arrow-right-3 text-primary"></i> Infertility Treatment
                                        </a>
                                    </li>
                                    <li class="list-group-item px-0 border-0 py-1">
                                        <a href="<?php echo $base_url; ?>thyroid-treatment.php"
                                            class="d-flex align-items-center gap-2 text-dark">
                                            <i class="isax isax-arrow-right-3 text-primary"></i> Thyroid Disorders
                                        </a>
                                    </li>
                                    <li class="list-group-item px-0 border-0 py-1">
                                        <a href="<?php echo $base_url; ?>hormonal-imbalance.php"
                                            class="d-flex align-items-center gap-2 text-dark">
                                            <i class="isax isax-arrow-right-3 text-primary"></i> Hormonal Imbalance
                                        </a>
                                    </li>
                                    <li class="list-group-item px-0 border-0 py-1">
                                        <a href="<?php echo $base_url; ?>diabetes-treatment.php"
                                            class="d-flex align-items-center gap-2 text-dark">
                                            <i class="isax isax-arrow-right-3 text-primary"></i> Diabetes Management
                                        </a>
                                    </li>
                                    <li class="list-group-item px-0 border-0 py-1">
                                        <a href="<?php echo $base_url; ?>gynecology.php"
                                            class="d-flex align-items-center gap-2 text-dark">
                                            <i class="isax isax-arrow-right-3 text-primary"></i> General Gynecology
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /Related Services Card -->

                    </div>
                    <!-- ===================== /STICKY SIDEBAR ===================== -->

                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- /Page Content -->

        <!-- /Page Content -->



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
            <a href="index.html"><img src="<?php echo $base_url; ?>assets/img/logo.svg" alt="logo"
                    class="img-fluid logo"></a>
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
                            src="<?php echo $base_url; ?>assets/img/banner/about-img-1.jpg" alt="about-img-1"
                            class="img-fluid"></a>
                    <a href="<?php echo $base_url; ?>assets/img/banner/about-img-2.jpg" data-fancybox="gallery"><img
                            src="<?php echo $base_url; ?>assets/img/banner/about-img-2.jpg" alt="about-img-1"
                            class="img-fluid"></a>
                    <a href="<?php echo $base_url; ?>assets/img/banner/about-img-3.jpg" data-fancybox="gallery"><img
                            src="<?php echo $base_url; ?>assets/img/banner/about-img-3.jpg" alt="about-img-1"
                            class="img-fluid"></a>
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
        <img src="<?php echo $base_url; ?>assets/img/bg/offcanvas-bg.png" alt="element" class="element-01">
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
    <script src="<?php echo $base_url; ?>assets/js/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    <!-- Bootstrap Bundle JS -->
    <script src="<?php echo $base_url; ?>assets/js/bootstrap.bundle.min.js"></script>

    <!-- Sticky Sidebar JS -->
    <script src="<?php echo $base_url; ?>assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
    <script src="<?php echo $base_url; ?>assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

    <!-- Select2 JS -->
    <script src="<?php echo $base_url; ?>assets/plugins/select2/js/select2.min.js"></script>



    <!-- Feather Icon JS -->
    <script src="<?php echo $base_url; ?>assets/js/feather.min.js"></script>

    <!-- BacktoTop JS -->
    <script src="<?php echo $base_url; ?>assets/js/backToTop.js"></script>

    <!-- select JS -->
    <script src="<?php echo $base_url; ?>assets/plugins/select2/js/select2.min.js"></script>

    <!-- Slick Slider -->
    <script src="<?php echo $base_url; ?>assets/plugins/slick/slick.min.js"></script>

    <!-- Fancybox JS -->
    <script src="<?php echo $base_url; ?>assets/plugins/fancybox/jquery.fancybox.min.js"></script>

    <!-- Counter JS -->
    <script src="<?php echo $base_url; ?>assets/js/counter.js"></script>

    <!-- Wow JS -->
    <script src="<?php echo $base_url; ?>assets/plugins/wow/js/wow.min.js"></script>

    <!-- Custom JS -->
    <script src="<?php echo $base_url; ?>assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="d007907878785aba4b025926-|49" defer></script>

    <script>
    flatpickr("#appointmentDate", {
        minDate: "today",
        dateFormat: "d M Y", // 26 Mar 2026 format
        disableMobile: true,
        animate: true,
    });
    </script>
    <!-- Appointment Form Validation -->
    <script>
    (function() {
        'use strict';

        var form = document.getElementById('appointmentForm');
        if (!form) return;

        var nameEl = document.getElementById('apptName');
        var phoneEl = document.getElementById('apptPhone');
        var dateEl = document.getElementById('appointmentDate');
        var serviceEl = document.getElementById('apptService');
        var dateError = document.getElementById('dateError');

        // ── Validators ─────────────────────────────────────────────────────────
        function isValidName(v) {
            return v.trim().length >= 3 && /^[a-zA-Z\s'.]+$/.test(v.trim());
        }

        function isValidPhone(v) {
            var c = v.replace(/[\s\-]/g, '');
            return /^(\+91|91)?[6-9]\d{9}$/.test(c);
        }

        function isValidDate(v) {
            return v.trim() !== '';
        }

        function isValidService(v) {
            return v !== '';
        }

        // ── State Helpers ───────────────────────────────────────────────────────
        function markValid(el) {
            el.classList.remove('is-invalid');
            el.classList.add('is-valid');
        }

        function markInvalid(el) {
            el.classList.remove('is-valid');
            el.classList.add('is-invalid');
        }

        function clearMark(el) {
            el.classList.remove('is-valid', 'is-invalid');
        }

        function markDateValid() {
            dateEl.classList.remove('is-invalid');
            dateEl.classList.add('is-valid');
            dateError.style.display = 'none';
        }

        function markDateInvalid() {
            dateEl.classList.remove('is-valid');
            dateEl.classList.add('is-invalid');
            dateError.style.display = 'block';
        }

        // ── Real-time: Name ─────────────────────────────────────────────────────
        nameEl.addEventListener('blur', function() {
            isValidName(this.value) ? markValid(this) : markInvalid(this);
        });

        nameEl.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                isValidName(this.value) ? markValid(this) : markInvalid(this);
            }
        });

        // ── Real-time: Phone ────────────────────────────────────────────────────
        phoneEl.addEventListener('input', function() {
            // Strip anything that's not a digit, +, or space
            this.value = this.value.replace(/[^0-9+\s]/g, '');
            if (this.value.trim()) {
                isValidPhone(this.value) ? markValid(this) : markInvalid(this);
            } else {
                clearMark(this);
            }
        });

        phoneEl.addEventListener('blur', function() {
            if (!this.value.trim()) {
                markInvalid(this);
                return;
            }
            isValidPhone(this.value) ? markValid(this) : markInvalid(this);
        });

        // ── Real-time: Service ──────────────────────────────────────────────────
        serviceEl.addEventListener('change', function() {
            isValidService(this.value) ? markValid(this) : markInvalid(this);
        });

        // ── Flatpickr Re-init with onChange hook ────────────────────────────────
        if (typeof flatpickr !== 'undefined') {
            flatpickr('#appointmentDate', {
                minDate: 'today',
                dateFormat: 'j M Y',
                disableMobile: true,
                animate: true,
                onChange: function(selectedDates) {
                    selectedDates.length > 0 ? markDateValid() : markDateInvalid();
                }
            });
        }

        // ── Submit Validation ───────────────────────────────────────────────────
        form.addEventListener('submit', function(e) {
            var valid = true;

            // Name
            if (!isValidName(nameEl.value)) {
                markInvalid(nameEl);
                valid = false;
            } else {
                markValid(nameEl);
            }

            // Phone
            if (!isValidPhone(phoneEl.value)) {
                markInvalid(phoneEl);
                valid = false;
            } else {
                markValid(phoneEl);
            }

            // Date
            if (!isValidDate(dateEl.value)) {
                markDateInvalid();
                valid = false;
            } else {
                markDateValid();
            }

            // Service
            if (!isValidService(serviceEl.value)) {
                markInvalid(serviceEl);
                valid = false;
            } else {
                markValid(serviceEl);
            }

            // Block submit + scroll to first error
            if (!valid) {
                e.preventDefault();
                e.stopPropagation();
                var firstError = form.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.focus();
                }
            }
        });

    })();
    </script>

</body>

</html>