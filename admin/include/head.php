<?php
// C:\xampp\htdocs\rkhospital\admin\include\head.php
require_once __DIR__ . '/../../include/config.php';
$pageTitle = isset($pageTitle) ? $pageTitle : 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RK Hospital - <?= htmlspecialchars($pageTitle) ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="<?= SITE_URL ?>/admin/assets/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_URL ?>/admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/admin/assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/admin/assets/css/feathericon.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/admin/assets/css/select2.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/admin/assets/css/custom.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/admin/assets/css/admin-theme.css">

    <?php if (!empty($extraCSS)) echo $extraCSS; ?>
</head>
<body>
<div class="main-wrapper">