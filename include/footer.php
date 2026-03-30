<?php $_base = rtrim(SITE_URL, '/') . '/'; ?>

<!-- Footer Section -->
<footer class="footer inner-footer footer-info">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="footer-widget">
                        <a href="<?= $_base ?>" class="d-inline-block mb-3">
                            <img src="<?= $_base ?>assets/img/logo.svg" alt="RK Hospital" height="36">
                        </a>
                        <p class="text-dark mb-4">
                            R.K. Hospital, Nagpur — providing compassionate, quality healthcare for over 20 years. Your health is our priority.
                        </p>
                        <ul class="d-flex gap-2 list-unstyled social-icon">
                            <li><a href="javascript:void(0);" class="social-icon"><i class="fa-brands fa-facebook"></i></a></li>
                            <li><a href="javascript:void(0);" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a></li>
                            <li><a href="javascript:void(0);" class="social-icon"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="javascript:void(0);" class="social-icon"><i class="fa-brands fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 mb-4 mb-lg-0">
                    <div class="footer-widget footer-menu">
                        <h6 class="footer-title">Quick Links</h6>
                        <ul>
                            <li><a href="<?= $_base ?>">Home</a></li>
                            <li><a href="<?= $_base ?>about-us">About Us</a></li>
                            <li><a href="<?= $_base ?>doctors">Our Doctors</a></li>
                            <li><a href="<?= $_base ?>services">Services</a></li>
                            <li><a href="<?= $_base ?>contact-us">Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 mb-4 mb-lg-0">
                    <div class="footer-widget footer-menu">
                        <h6 class="footer-title">Resources</h6>
                        <ul>
                            <li><a href="<?= $_base ?>blogs">Blog</a></li>
                            <li><a href="<?= $_base ?>services">Our Specialties</a></li>
                            <li><a href="<?= $_base ?>contact-us">Book Appointment</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <h6 class="footer-title">Contact Us</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2 text-dark">
                                <i class="fa fa-map-marker-alt me-2 text-primary"></i>
                                RK Hospital, Nagpur, Maharashtra
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-phone me-2 text-primary"></i>
                                <a href="tel:+910712000000" class="text-dark">+91 0712 000 000</a>
                            </li>
                            <li class="mb-4">
                                <i class="fa fa-envelope me-2 text-primary"></i>
                                <a href="mailto:info@rkhospital.in" class="text-dark">info@rkhospital.in</a>
                            </li>
                        </ul>
                        <h6 class="footer-title">Newsletter</h6>
                        <div class="subscribe-input">
                            <form action="<?= $_base ?>contact-us" method="get">
                                <input type="email" name="email" class="form-control" placeholder="Enter your email">
                                <button type="submit" class="btn btn-md btn-primary-gradient d-inline-flex align-items-center">
                                    <i class="isax isax-send-25 me-1"></i>Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="copyright">
                <div class="copyright-text mb-0">
                    <p class="mb-0">Copyright &copy; <?= date('Y') ?> R.K. Hospital Nagpur. All Rights Reserved.</p>
                </div>
                <div class="copyright-menu">
                    <ul class="policy-menu mb-0">
                        <li><a href="<?= $_base ?>about-us">About</a></li>
                        <li><a href="<?= $_base ?>contact-us">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- /Footer Section -->
