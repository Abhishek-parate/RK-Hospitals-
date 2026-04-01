<?php $_base = rtrim(SITE_URL, '/') . '/'; ?>
<style>
.footer.inner-footer { margin-top: 0 !important; padding-top: 0 !important; }
.footer-top { padding-bottom: 10px !important; }
@media (max-width: 768px) {
    .footer-bottom {
        padding-top: 12px !important;
        padding-bottom: 12px !important;
    }
}
</style>
<!-- Footer Section -->
<footer class="footer inner-footer footer-info">
    <div class="footer-top py-5">
        <div class="container">
            <div class="row">

                <!-- Logo + About -->
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="footer-widget">
                        <a href="<?= $_base ?>" class="d-inline-block mb-3">
                            <img src="<?= $_base ?>assets/img/team/rk-hospital-best-hospital-in-nagpur.png"
                                alt="RK Hospital" style="height:80px; width:auto; max-width:200px; object-fit:contain;">
                        </a>

                        <p class="text-dark mb-4">
                            R.K. Hospital, Nagpur — providing compassionate, quality healthcare for over 5+ years.
                            Your health is our priority.
                        </p>

                        <ul class="d-flex gap-3 list-unstyled">
                            <li><a href="https://www.facebook.com/share/1Aze23diqp/" class="social-icon" target="_blank"><i class="fa-brands fa-facebook"></i></a></li>
                           
                            <li><a href="https://www.instagram.com/dr.agrawalsrkhospital?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="fa-brands fa-instagram"></i></a></li>
                   
                        </ul>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 mb-4">
                    <div class="footer-widget footer-menu">
                        <h6 class="footer-title">Quick Links</h6>
                        <ul class="list-unstyled">
                            <li><a href="<?= $_base ?>">Home</a></li>
                            <li><a href="<?= $_base ?>about-us">About Us</a></li>
                            <li><a href="<?= $_base ?>doctors/Abhishek">Our Doctors</a></li>
                            <li><a href="<?= $_base ?>services">Services</a></li>

                        </ul>
                    </div>
                </div>

                <!-- Resources -->
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 mb-4">
                    <div class="footer-widget footer-menu">
                        <h6 class="footer-title">Resources</h6>
                        <ul class="list-unstyled">
                            <li><a href="<?= $_base ?>blogs">Blog</a></li>
                            <li><a href="<?= $_base ?>services">Our Specialties</a></li>
                            <li><a href="<?= $_base ?>contact-us">Book Appointment</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Help Center -->
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 mb-4">
                    <div class="footer-widget footer-menu">
                        <h6 class="footer-title">Help Center</h6>
                        <ul class="list-unstyled">
                            <li><a href="<?= $_base ?>privacy-policy">Privacy Policy</a></li>
                            <li><a href="<?= $_base ?>cancellation-policy">Cancellation Policy</a></li>
                            <li><a href="<?= $_base ?>terms-conditions">Terms & Conditions</a></li>
                            <li><a href="<?= $_base ?>contact-us">Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact + Newsletter -->
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h6 class="footer-title">Contact Us</h6>

                        <ul class="list-unstyled mb-3">
                            <li class="mb-2">
                                <i class="fa fa-map-marker-alt me-2 text-primary"></i>
                               <a style="color:#0F172A;">27 Chandrashekhar, Azad Square, Central Ave, Ladpura, Itwari, Nagpur, Maharashtra 440002</a>
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-phone me-2 text-primary"></i>
                                <a href="tel:+919766057372">+91 97660 57372</a>
                            </li>
                            <li class="mb-3">
                                <i class="fa fa-envelope me-2 text-primary"></i>
                                <a href="mailto: info@dragrawalsrkhospital.in"> info@dragrawalsrkhospital.in</a>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>
<!-- Footer Bottom -->
<div class="footer-bottom py-3 border-top">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center">

            <ul class="list-unstyled d-flex gap-3 mb-0 invisible">
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>

            <p style="text-align: center; margin-bottom: 0;">
                Copyright &copy; <?= date('Y') ?> R.K. Hospital Nagpur. All Rights Reserved | Designed And Developed By 
                <a href="https://techinbox.in/" target="_blank" style="color:#0F172A;">Techinbox.in</a>
            </p>

            <ul class="list-unstyled d-flex gap-3 mb-0 d-none d-md-flex">
                <li><a href="<?= $_base ?>about-us">About</a></li>
                <li><a href="<?= $_base ?>contact-us">Contact</a></li>
            </ul>

        </div>
    </div>
</div>
</footer>
<!-- /Footer Section -->