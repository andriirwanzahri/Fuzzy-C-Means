<?php
include 'headerAdmin.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <?php
    if (isset($_GET['page'])) {
        if ($_GET['page'] == "home") {
            include 'home.php';
        } elseif ($_GET['page'] == "perhitungan") {
            include 'perhitungan.php';
        } elseif ($_GET['page'] == "datadiri") {
            include 'datadiri.php';
        } elseif ($_GET['page'] == "kriteria") {
            include 'kriteria.php';
        } elseif ($_GET['page'] == "info") {
            include 'info.php';
        } elseif ($_GET['page'] == "subkriteria") {
            include 'subkriteria.php';
        } elseif ($_GET['page'] == "kelolaakun") {
            include 'kelolaakun.php';
        } elseif ($_GET['page'] == "hasilklasifikasi") {
            include 'hasilklasifikasi.php';
        } elseif ($_GET['page'] == "datamasyarakat") {
            include 'datamasyarakat.php';
        } elseif ($_GET['page'] == "registrasi") {
            include 'registrasi.php';
        } elseif ($_GET['page'] == "logout") {

            $_SESSION = [];
            session_unset();
            session_destroy();
            echo "<script>location='homeuser.php';</script>";
        }
    } else {
        include 'home.php';
    }
    ?>
    <?php
    include 'footer.php';
    ?>