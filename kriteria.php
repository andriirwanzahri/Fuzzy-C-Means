<?php
include "koneksi.php";
$datakriteria = query("SELECT * FROM data_kriteria ORDER BY id_kriteria DESC");

if (isset($_POST["ubah"])) {
    $id = $_POST['id'];
    $namakriteria = $_POST['nama_kriteria'];
    $data = "UPDATE data_kriteria SET nama_kriteria='$namakriteria' WHERE id_kriteria='$id'";
    if (mysqli_query($conn, $data)) {
        echo ' <script>
        location.replace("index.php?page=kriteria&pesan_success=Data Berhasil diubah");
    </script>';
    } else {
        echo '<script>
    location.replace("index.php?page=kriteria&pesan_error=Data gagal diubah");
    </script>';
    }
}

if (isset($_POST["tambah"])) {
    $query = "SELECT max(id_kriteria) as maxKode FROM data_kriteria";
    $hasil = mysqli_query($conn, $query);
    $data = mysqli_fetch_array($hasil);
    $kodeJalan = $data['maxKode'];
    $noUrut = (int) substr($kodeJalan, 3, 3);
    $noUrut++;
    $char = "KTR";
    $kodeJalan = $char . sprintf("%03s", $noUrut);

    if (tambahkriteria($_POST, $kodeJalan) > 0) {
        echo ' <script>
        location.replace("index.php?page=kriteria&pesan_success=Data Berhasil ditambahkan");
    </script>';
    } else {
        echo '<script>
    location.replace("index.php?page=kriteria&pesan_error=Data gagal ditambahkan");
    </script>';
    }
}
if (isset($_GET["hapus"])) {
    // $hapus = $_GET['hapus'];
    if (hapus2($_GET, "data_kriteria", "sub_kriteria", "id_kriteria") > 0) {
        echo ' <script>
            location.replace("index.php?page=kriteria&pesan_success=Data Berhasil di Hapus");
        </script>';
    } else {
        echo '<script>
            location.replace("index.php?page=kriteria&pesan_error=Data gagal di Hapus");
        </script>';
    }
}
$pesan_error = $pesan_success = "";
if (isset($_GET['pesan_error'])) {
    $pesan_error = $_GET['pesan_error'];
}
if (isset($_GET['pesan_success'])) {
    $pesan_success = $_GET['pesan_success'];
}

if (!empty($pesan_error)) {
    display_error($pesan_error);
}
if (!empty($pesan_success)) {
    display_success($pesan_success);
}
?>

<!-- Page Heading -->
<h1 class=" mt-3 h3 mb-2 text-gray-800">Data Kriteria</h1>
<p class="mb-4">Masukkan Data Kriteria Untuk Atribut perhitunggan Fuzzy C-Means.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button class="btn btn-dark float-right" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i>Kriteria</button>
        <h6 class="m-0 font-weight-bold text-success">Tabel Kriteria</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kriteria</th>
                        <th>Lainnya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($datakriteria as $d) :
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['nama_kriteria']; ?></td>
                            <td>
                                <a href="index.php?page=subkriteria&idkriteria=<?php echo $d['id_kriteria']; ?>" class="badge badge-pill badge-info"><i class="fas fa-info"></i> Sub Kriteria</a>
                                <a href="index.php?page=kriteria&hapus=<?php echo $d['id_kriteria']; ?>" class="badge badge-pill badge-danger" onClick="return confirm('Anda yakin akan hapus ?')"><i class="fas fa-trash"></i> hapus</a>
                                <a href="#" class="badge badge-pill badge-success" data-toggle="modal" data-target="#myModal<?php echo $d['id_kriteria']; ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Ubah Data Jalan -->
                        <div class="modal fade bd-example-modal-lg" id="myModal<?= $d['id_kriteria']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Ubah Kriteria</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <form action="" method="post">
                                                <input type="hidden" name="id" class="form-control" value="<?= $d['id_kriteria']; ?>">
                                                <input type="text" name="nama_kriteria" class="form-control" value="<?= $d['nama_kriteria']; ?>">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                                    <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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


<!-- Tambah Data kriteria  -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nama Kriteria:</label>
                                    <input type="text" name="namakriteria" class="form-control" id="recipient-name" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Tambahkan</button>
                </div>
                </form>
            </div>
        </div>
    </div>