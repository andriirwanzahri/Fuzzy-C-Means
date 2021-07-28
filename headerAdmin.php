<?php
session_start();
if (!isset($_SESSION['login']['level'])) {
    header("Location: homeuser.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Aplikasi Fuzzy C-Means</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>

<body class="" id="page-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- NavBar Kepala -->
            <a class="navbar-brand" href="#">Fuzzy C-Means</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?page=home">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <?php
                    if ($_SESSION['login']['level'] == '1') :
                    ?>
                        <li class="nav-item-item active">
                            <a class="nav-link" href="index.php?page=kelolaakun">Management akun</a>
                        </li>
                        <li class="nav-item-item active">
                            <a class="nav-link" href="index.php?page=kriteria">Kriteria</a>
                        </li>
                        <li class="nav-item-item active">
                            <a class="nav-link" href="index.php?page=datamasyarakat">Data Masyarakat</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Proses Fuzzy C-Means
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="index.php?page=perhitungan">Perhitungan Fuzzy C-Means</a>
                                <a class="dropdown-item" href="index.php?page=hasilklasifikasi">Hasil Klasifikasi</a>
                            </div>
                        </li>
                    <?php elseif ($_SESSION['login']['level'] == '2') : ?>
                        <li class="nav-item-item active">
                            <a class="nav-link" href="index.php?page=kriteria">Kriteria</a>
                        </li>
                        <li class="nav-item-item active">
                            <a class="nav-link" href="index.php?page=datamasyarakat">Data Masyarakat</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Proses Fuzzy C-Means
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="index.php?page=perhitungan">Perhitungan Fuzzy C-Means</a>
                                <a class="dropdown-item" href="index.php?page=hasilklasifikasi">Hasil Klasifikasi</a>
                            </div>
                        </li>
                    <?php elseif ($_SESSION['login']['level'] == '3') : ?>
                        <li class="nav-item-item active">
                            <a class="nav-link" href="index.php?page=datamasyarakat">Data Masyarakat</a>
                        </li>
                        <li class="nav-item-item active">
                            <a class="nav-link" href="index.php?page=hasilklasifikasi">Data Masyarakat klasifikasi</a>
                        </li>
                        <?php
                        // elseif ($_SESSION['login']['level'] == '4') :
                        ?>
                        <!-- <li class="nav-item-item active">
                            <a class="nav-link" href="index.php?page=datadiri">Data Diri</a>
                        </li> -->
                    <?php endif; ?>
                    <li class="nav-item-item active">
                        <a class="nav-link" href="index.php?page=info">Info</a>
                    </li>
                    <li class="nav-item-item active">
                        <a class="nav-link" href="index.php?page=logout" onClick="return confirm('Anda yakin ingin keluar ?')">keluar</a>
                    </li>
                </ul>
                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>
            </div>
    </nav>
    <div class="container">
        <!-- akhir Navbar -->