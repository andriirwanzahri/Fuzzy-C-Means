<?php
include "koneksi.php";
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
<!-- Page Heading -->
<div class="d-sm-flex align-items-center mt-3 justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Selamat Datang <?= $_SESSION['login']['nama']; ?></h1>
    <p class="btn btn-success"> Anda Masuk Sebagai
        <?php
        if ($_SESSION['login']['level'] == 1) {
            echo 'Admin';
        } elseif ($_SESSION['login']['level'] == 2) {
            echo 'Petugas Desa';
        } elseif ($_SESSION['login']['level'] == 3) {
            echo 'Petugas Camat';
        }
        ?> </p>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<!-- Content Row -->
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-200 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Data Masyarakat</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlData; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-200 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Kriteria</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlkriteria; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-200 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Cluster 1</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlC1; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-200 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Cluster 2</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlC2; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-200 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Cluster 3</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlC3; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Algoritma Fuzzy C-Means TM</span>
        </div>
    </div>
</footer>