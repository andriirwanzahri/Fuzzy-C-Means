<?php
include "koneksi.php";
$query = query("SELECT data_keluarga.*, data_hasil_cluster.cluster FROM data_keluarga, data_hasil_cluster WHERE data_keluarga.id_keluarga = data_hasil_cluster.id_keluarga ");

$keluarga = array();
$querykeluarga = mysqli_query($conn, "SELECT * FROM data_keluarga ORDER BY id_keluarga");
$i = 0;
while ($datakeluarga = mysqli_fetch_array($querykeluarga)) {
    $keluarga[$i] = $datakeluarga['nama_keluarga'];
    $i++;
}
$kriteria = array();
$querykriteria = mysqli_query($conn, "SELECT * FROM data_kriteria ORDER BY id_kriteria");
$i = 0;
while ($datakriteria = mysqli_fetch_array($querykriteria)) {
    $kriteria[$i] = $datakriteria['nama_kriteria'];
    $i++;
}
$keluargakriteria = array();

$querykeluarga = mysqli_query($conn, "SELECT * FROM data_keluarga ORDER BY id_keluarga");
$i = 0;
while ($datakeluarga = mysqli_fetch_array($querykeluarga)) {
    $querykriteria = mysqli_query($conn, "SELECT * FROM data_kriteria ORDER BY id_kriteria");
    $j = 0;
    while ($datakriteria = mysqli_fetch_array($querykriteria)) {
        $querykeluargakriteria = mysqli_query($conn, "SELECT * FROM 
        data_keluarga_kriteria WHERE 
        id_keluarga='$datakeluarga[id_keluarga]' AND 
        id_kriteria='$datakriteria[id_kriteria]'");
        $datakeluargakriteria = mysqli_fetch_array($querykeluargakriteria);
        $keluargakriteria[$i][$j] = $datakeluargakriteria['nilai'];

        $j++;
    }
    $i++;
}
?>
<!-- Page Heading -->
<h1 class=" mt-3 h3 mb-2 text-gray-800">Data Hasil Pengelompokan (Clustering)</h1>
<p class="mb-4">Data Ini Merupakaan hasil Dari clustering Fuzzy C- Means.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="cetaklaporan.php" target="_blank" class="float-right">Cetak Laporan</a>
        <h6 class="m-0 font-weight-bold text-success">Tabel Pengelompokan Masyarakat</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Alamat</th>
                        <?php
                        for ($i = 0; $i < count($kriteria); $i++) {
                            echo "<td>" . $kriteria[$i] . "</td>";
                        }
                        ?>
                        <th>Hasil Cluster</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $j = 0;
                    foreach ($query as $d) :
                    ?>
                        <tr>
                            <td><?= $d['nama_keluarga']; ?></td>
                            <td><?= $d['id_keluarga']; ?></td>
                            <td><?= $d['alamat']; ?></td>
                            <?php
                            for ($i = 0; $i < count($kriteria); $i++) {
                                echo "<td>" . $keluargakriteria[$j][$i] . "</td>";
                            }
                            ?>

                            <td>
                                <?php
                                if ($d['cluster'] == 'Cluster1') {
                                    echo 'Miskin';
                                } elseif ($d['cluster'] == 'Cluster2') {
                                    echo 'Fakir';
                                } elseif ($d['cluster'] == 'Cluster3') {
                                    echo 'Sederhana';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                        $j++;
                    endforeach; ?>
                </tbody>
            </table>
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