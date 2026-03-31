<?php $_base = rtrim(SITE_URL, '/') . '/'; ?>

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
                            R.K. Hospital, Nagpur — providing compassionate, quality healthcare for over 20 years.
                            Your health is our priority.
                        </p>

                        <ul class="d-flex gap-3 list-unstyled">
                            <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
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
                            <li><a href="<?= $_base ?>doctors">Our Doctors</a></li>
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
                                RK Hospital, Nagpur, Maharashtra
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-phone me-2 text-primary"></i>
                                <a href="tel:+910712000000">+91 0712 000 000</a>
                            </li>
                            <li class="mb-3">
                                <i class="fa fa-envelope me-2 text-primary"></i>
                                <a href="mailto:info@rkhospital.in">info@rkhospital.in</a>
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

                <p class="mb-0">
                    Copyright &copy; <?= date('Y') ?> R.K. Hospital Nagpur. All Rights Reserved.
                </p>

                <ul class="list-unstyled d-flex gap-3 mb-0">
                    <li><a href="<?= $_base ?>about-us">About</a></li>
                    <li><a href="<?= $_base ?>contact-us">Contact</a></li>
                </ul>

            </div>
        </div>
    </div>

</footer>
<!-- /Footer Section -->