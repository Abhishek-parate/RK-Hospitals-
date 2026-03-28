
<!-- C:\xamppnew\htdocs\rkhospital\admin\blank-page.php -->
<?php
$pageTitle  = 'Blank Page';   // ← changes per page
$activePage = 'blank-page.php'; // ← highlights correct sidebar item

require_once 'includes/head.php';
?>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <?php require_once 'includes/header.php'; ?>

        <?php require_once 'includes/sidebar.php'; ?>

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Blank Page</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Blank Page</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- ★ YOUR CONTENT GOES HERE ★ -->
                <div class="row">
                    <div class="col-sm-12">
                        <p>Contents here</p>
                    </div>
                </div>
                <!-- /Content -->

            </div>
        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

<?php require_once 'includes/scripts.php'; ?>
