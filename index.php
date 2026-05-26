<?php
require_once 'class/CompanyProfile.php';
require "inc.koneksi.php";
$profile = new CompanyProfile();

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$page = preg_replace('/[^a-zA-Z0-9-]/', '', $page); // Sanitasi input URL
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $profile->getNamaPerusahaan(); ?> - B2C E-Commerce</title>
    
    <!-- Bootstrap 5.3.8 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?page=home"><?= $profile->getNamaPerusahaan(); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link <?= ($page == 'home') ? 'active' : '' ?>" href="index.php?page=home">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($page == 'about') ? 'active' : '' ?>" href="index.php?page=about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($page == 'catalog') ? 'active' : '' ?>" href="index.php?page=catalog">Katalog Produk</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($page == 'contact') ? 'active' : '' ?>" href="index.php?page=contact">Kontak</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($page == 'employeelist') ? 'active' : '' ?>" href="index.php?page=employeelist">Karyawan</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($page == 'employeeprojectlist') ? 'active' : '' ?>" href="index.php?page=employeeprojectlist">Employee Project</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light position-relative" href="index.php?page=cart">
                            Cart
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                0
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dynamic Content -->
    <main class="container my-5 flex-grow-1">
        <?php
        $file = "pages/" . $page . ".php";
        if (file_exists($file)) {
            include $file;
        } else {
            include "pages/404.php";
        }
        ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0">&copy; 2026 <?= $profile->getNamaPerusahaan(); ?>. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5.3.8 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
</body>
</html>