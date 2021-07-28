<?php
include 'koneksi.php';
include 'header.php';
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$query = query("SELECT * FROM data_keluarga");
$kriteria = query("SELECT * FROM data_kriteria");
function cluster($conn, $kondisi)
{
    $cluster = query("SELECT * FROM data_hasil_cluster WHERE cluster='$kondisi'");
    $jml = count($cluster);
    return $jml;
}
$jmlC1 = cluster($conn, 'Cluster1');
$jmlC2 = cluster($conn, 'Cluster2');
$jmlC3 = cluster($conn, 'Cluster3');
$jmlData = count($query);
$jmlkriteria = count($kriteria);
?>
<div class="container">
    <!-- Page Heading -->
    <div class=" mt-5  mb-4">
        <h1 class="h3 mb-0 text-center">Selamat Datang pada Aplikasi Metode Fuzzy C-Means</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>


    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Algoritma Fuzzy C-Means TM</span>
            </div>
        </div>
    </footer>
</div>
<?php include 'footer.php'; ?>