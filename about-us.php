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

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $base_url; ?>about-us.php">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta property="og:image" content="<?php echo $base_url; ?>assets/img/home/about-doctor1.webp">
    <meta property="og:site_name" content="Dr. Agrawal's R.K. Hospital Nagpur">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="twitter:image" content="<?php echo $base_url; ?>assets/img/home/about-doctor1.webp">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo $base_url; ?>about-us.php">

    <title><?php echo htmlspecialchars($page_title); ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/img/favicon.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $base_url; ?>assets/img/apple-touch-icon.png">

    <!-- Theme Script -->
    <script src="<?php echo $base_url; ?>assets/js/theme-script.js"></script>

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/animate.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/iconsax.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/feather.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/wow/css/animate.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fancybox/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">

    <!-- About Page Custom CSS (no :root redefinition — uses existing variables) -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/about-us.css">

    <!-- Structured Data: Hospital -->
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
</head>

<body>


    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <?php include 'include/header.php'; ?>

        <!-- ══════════════════════════════════════════
             SECTION 1: ABOUT HERO
        ══════════════════════════════════════════ -->



        <!-- ══════════════════════════════════════════
             SECTION 2: OUR STORY
        ══════════════════════════════════════════ -->
        <section class="rk-story-section" aria-labelledby="story-heading">
            <div class="container">
                <div class="row align-items-center g-5">

                    <!-- Images -->
                    <div class="col-lg-5 col-md-12 wow fadeInLeft" data-wow-duration="1s">
                        <div class="rk-story-img-stack">
                            <img
                                src="assets/img/home/about-doctor2.webp"
                                class="img-main"
                                alt="Dr. Rahul Agrawal — Best Orthopedic Surgeon Nagpur at R.K. Hospital"
                                loading="lazy"
                            >
                            <img
                                src="assets/img/home/about-doctor3.webp"
                                class="img-secondary"
                                alt="Dr. Priyanka Jain Agrawal — Best Gynecologist Nagpur at R.K. Hospital"
                                loading="lazy"
                            >
                            <div class="experience-badge" aria-label="25 plus years of medical excellence">
                                <span class="yr-num">25+</span>
                                <span class="yr-text">Years of Excellence</span>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="col-lg-7 col-md-12 wow fadeInRight" data-wow-duration="1s">
                        <div class="rk-story-content">
                            <div class="rk-section-header">
                                <div class="rk-section-eyebrow">Our Story</div>
                                <h2 class="rk-heading" id="story-heading">
                                    Building a Legacy of <span class="accent">Healing &amp; Trust in Nagpur</span><br>
                                     <span class="blue-accent"></span>
                                </h2>
                                <p class="lead" style="margin-top: 16px;">
                                    Dr. Agrawal's R.K. Hospital was founded with a single, unwavering commitment — to bring the highest standard of medical care within reach of every patient in Nagpur and the Vidarbha region.
                                </p>
                            </div>

                            <p>
                                What began as a vision to transform orthopedic and gynecological healthcare has grown into one of Nagpur's most trusted multi-specialty hospitals. Today, we are equipped with state-of-the-art robotic surgical technology, modular operation theatres, and a team of highly experienced specialists who have collectively performed thousands of successful surgeries.
                            </p>
                            <p>
                                From complex robotic knee and hip replacement surgeries to high-risk pregnancy management, spine treatment, and advanced laparoscopic gynecology — our hospital stands as a complete healthcare destination for patients across Nagpur, Wardha, Amravati, and beyond.
                            </p>

                            <!-- Highlights -->
                            <ul class="rk-highlights" aria-label="Hospital highlights">
                                <li>
                                    <span class="hl-dot" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                                    Robotic Joint Replacement Technology
                                </li>
                                <li>
                                    <span class="hl-dot" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                                    Modular Operation Theatres
                                </li>
                                <li>
                                    <span class="hl-dot" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                                    Cashless Insurance Facility
                                </li>
                                <li>
                                    <span class="hl-dot" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                                    24/7 Emergency &amp; Trauma Care
                                </li>
                                <li>
                                    <span class="hl-dot" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                                    High-Risk Pregnancy Management
                                </li>
                                <li>
                                    <span class="hl-dot" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                                    Advanced Laparoscopic Surgery
                                </li>
                                <li>
                                    <span class="hl-dot" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                                    5★ Rated Patient Care
                                </li>
                                <li>
                                    <span class="hl-dot" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                                    Experienced Specialist Doctors
                                </li>
                            </ul>

                            <div class="d-flex flex-wrap gap-3">
                                <a href="contact-us.php" class="rk-btn-primary">
                                    <i class="fa-solid fa-calendar-check"></i>
                                    Book Appointment
                                </a>
                                <a href="tel:+919766057372" class="rk-btn-outline">
                                    <i class="fa-solid fa-phone"></i>
                                    Call Now
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- ── /Our Story ── -->

     <section class="section about-section-two">
			<div class="container">
				<div class="row align-items-center">
					
					<!-- About Img -->
					<div class="col-lg-6">
						<div class="about-img-two wow fadeInUp" data-wow-duration="2s">
							<img src="assets/img/about/about.png" alt="about" class="img-fluid">
							<a href="https://youtu.be/MyQxnFgPgQU?si=Z9y2WdynImbFnqL2" data-fancybox="">
								<button class="animate-button" data-text="Play Video · Play Video ·">
									<p class="button-text"></p>
									<span class="button-circle">
										<i class="isax isax-play"></i>
									</span>
								</button>
							</a>
						</div>
					</div>
					<!-- About Img End -->
					
					<!-- About Content -->
					<div class="col-lg-6">
						<div class="about-content-two">
							<div class="section-header section-header-two">
								<div class="section-sub-title"><img src="assets/img/icons/section-icon.svg" alt="icon">About Us</div>
								<h2 class="section-title">
  We Understand That Each One Is Unique &amp; Their 
  <span style="color:#C22323 !important;">Health Journey.</span>
</h2>
								<p>We aim to provide faster diagnosis, clearer insights, and more accurate treatment decisions ensuring every patient receives safe, precise, and personalized care.</p>
							</div>
							<div class="row g-4">
								<div class="col-md-6">
									<div class="mission-item wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1s">
										<div class="mission-inner">
											<div class="mission-info">
												<div class="mission-icon bg-primary">
													<img src="assets/img/icons/mission.svg" alt="mission" class="img-fluid">
												</div>
												<h3 class="custom-title">Our Mission</h3>
											</div>
											<p>To deliver compassionate, patient-first healthcare by combining expert clinical judgment with technology.</p>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mission-item wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="4s">
										<div class="mission-inner">
											<div class="mission-info">
												<div class="mission-icon bg-secondary">
													<img src="assets/img/icons/vision.svg" alt="vision" class="img-fluid">
												</div>
												<h3 class="custom-title">Our Vision</h3>
											</div>
											<p>Empower doctors to detect conditions earlier, improve outcomes, and redefine the future of modern healthcare.</p>
										</div>
									</div>
								</div>
							</div>
							<a href="single-service.php" class="btn btn-md btn-primary">Know More<i class="isax isax-arrow-right-34 ms-2"></i></a>
						</div>
					</div>
					<!-- About Content End -->

				</div>
			</div>
			<img src="assets/img/bg/about-bg.png" alt="icon" class="img-fluid about-bg-01">
		</section>

        <!-- ══════════════════════════════════════════
             SECTION 7: AWARDS & ACCREDITATIONS
        ══════════════════════════════════════════ -->
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
        <!-- ── /Awards ── -->

     
        <!-- ══════════════════════════════════════════
             SECTION 8: CTA — Book Appointment
    
        <!-- ── /CTA ── -->

        <!-- Cursor -->
        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>

        <?php include 'include/footer.php'; ?>

    </div>
    <!-- /Main Wrapper -->


    <!-- ── Offcanvas Support Popup ── -->
    <div class="offcanvas offcanvas-offset offcanvas-end support_popup" tabindex="-1" id="support_item">
        <div class="offcanvas-header">
            <a href="index.php">
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

    <!-- ScrollToTop -->
    <div class="progress-wrap active-progress">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102" aria-hidden="true">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition:stroke-dashoffset 10ms linear;stroke-dasharray:307.919px,307.919px;stroke-dashoffset:228.265px;">
            </path>
        </svg>
    </div>

    <!-- Scripts -->
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