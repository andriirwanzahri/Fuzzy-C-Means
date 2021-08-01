<?php
include "header.php";
include "koneksi.php";
$query = query("SELECT data_keluarga.*, data_hasil_cluster.cluster FROM data_keluarga, data_hasil_cluster WHERE data_keluarga.id_keluarga = data_hasil_cluster.id_keluarga ");
?>
<div class="container">
    <!-- Page Heading -->
    <h1 class=" mt-3 h3 mb-2 text-gray-800 text-center">Data Hasil Pengelompokan (Clustering)</h1>
    <p class="mb-4  text-center">Data Ini Merupakaan hasil Dari clustering Fuzzy C- Means.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
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
                            <th>Hasil Cluster</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($query as $d) :
                        ?>
                            <tr>
                                <td><?= $d['nama_keluarga']; ?></td>
                                <td><?= $d['id_keluarga']; ?></td>
                                <td><?= $d['alamat']; ?></td>
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
                        <?php endforeach; ?>
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
</div>
<?php
include "footer.php";
?>