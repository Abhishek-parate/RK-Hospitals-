<!-- C:\xamppnew\htdocs\rkhospital\admin\include\head.php -->
<?php
// Usage: set $pageTitle, $assetBase, $extraCSS before including
$pageTitle = isset($pageTitle) ? $pageTitle : 'Dashboard';
$assetBase = isset($assetBase) ? $assetBase : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doccure - <?= htmlspecialchars($pageTitle) ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= $assetBase ?>assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= $assetBase ?>assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="<?= $assetBase ?>assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= $assetBase ?>assets/plugins/fontawesome/css/all.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="<?= $assetBase ?>assets/css/feathericon.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= $assetBase ?>assets/css/custom.css">

    <?php if (!empty($extraCSS)) echo $extraCSS; ?>
</head>
<body>
<div class="main-wrapper">
