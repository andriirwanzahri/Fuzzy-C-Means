<?php
include "koneksi.php";


$kodekriteria = $_GET['idkriteria'];
$data = mysqli_query($conn, "SELECT * FROM data_kriteria WHERE id_kriteria='$kodekriteria'");
$pecah = mysqli_fetch_array($data);
$datasubkriteria = query("SELECT * FROM sub_kriteria WHERE id_kriteria='$kodekriteria'");
if (isset($_POST["ubah"])) {
    $id = $_POST['id'];
    $subnama = $_POST['subnama'];
    $nilai = $_POST['nilai'];
    $data = "UPDATE sub_kriteria SET nama_sub='$subnama', nilai='$nilai' WHERE id='$id'";
    if (mysqli_query($conn, $data)) {
        echo ' <script>
        location.replace("index.php?page=subkriteria&idkriteria=' . $kodekriteria . '&pesan_success=Data Berhasil diubah");
    </script>';
    } else {
        echo '<script>
    location.replace("index.php?page=subkriteria&idkriteria=' . $kodekriteria . '&pesan_error=Data gagal diubah");
    </script>';
    }
}
if (isset($_POST["tambah"])) {
    if (tambahsubkriteria($_POST, $kodekriteria) > 0) {
        echo ' <script>
        location.replace("index.php?page=subkriteria&idkriteria=' . $kodekriteria . '&pesan_success=Data Berhasil ditambahkan");
    </script>';
    } else {
        echo '<script>
    location.replace("index.php?page=subkriteria&idkriteria=' . $kodekriteria . '&pesan_error=Data gagal ditambahkan");
    </script>';
    }
}
if (isset($_GET["hapus"])) {
    if (hapus($_GET, "sub_kriteria", "id") > 0) { // ('iddata','nama tabel','kolom id')
        echo ' <script>
            location.replace("index.php?page=subkriteria&idkriteria=' . $kodekriteria . '&pesan_success=Data Berhasil dihapus");
        </script>';
    } else {
        echo '<script>
            location.replace("index.php?page=subkriteria&idkriteria=' . $kodekriteria . '&pesan_error=Data Berhasil dihapus");
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
<h1 class=" mt-3 h3 mb-2 text-gray-800">Data Sub Kriteria</h1>
<p class="mb-4">Masukkan Data Sub Kriteria Kriteria Untuk Atribut perhitunggan Fuzzy C-Means.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button class="btn btn-dark float-right" data-toggle="modal" data-target="#exampleModal">Tambah sub</button>
        <h6 class="m-0 font-weight-bold text-success">Tabel Sub <?php echo $pecah['nama_kriteria']; ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sub Kriteria</th>
                        <th>Nilai</th>
                        <th>Lainnya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($datasubkriteria as $d) :
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['nama_sub']; ?></td>
                            <td><?php echo $d['nilai']; ?></td>
                            <td><a href="index.php?page=subkriteria&hapus=<?php echo $d['id']; ?>" class="badge badge-pill badge-danger" onClick="return confirm('Anda yakin akan hapus ?')"><i class="fas fa-trash"></i>Hapus</a>
                                <a href="#" class="badge badge-pill badge-success" data-toggle="modal" data-target="#myModal<?php echo $d['id']; ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <div class="modal fade bd-example-modal-lg" id="myModal<?= $d['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="id" class="form-control" value="<?= $d['id']; ?>">
                                                        <input type="text" name="subnama" class="form-control" value="<?= $d['nama_sub']; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="nilai" class="form-control" value="<?= $d['nilai']; ?>">
                                                    </div>
                                                </div>
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
                                    <label for="recipient-name" class="col-form-label">Nama Sub Kriteria:</label>
                                    <input type="text" name="namasubkriteria" class="form-control" id="recipient-name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nilai:</label>
                                    <input type="text" name="nilai" class="form-control" id="recipient-name" required>
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