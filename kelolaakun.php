<?php
include 'koneksi.php';
$pdata = query("SELECT * FROM user ORDER BY id DESC");

if (isset($_GET["hapus"])) {
    if (hapus($_GET, "user", "id") > 0) {
        echo ' <script>
            location.replace("index.php?page=kelolaakun&pesan_success=Data Berhasil dihapus");
        </script>';
    } else {
        echo '<script>
            location.replace("index.php?page=kelolaakun&pesan_error=Data Berhasil dihapus");
        </script>';
    }
}

if (isset($_POST["ubah"])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $level = $_POST['level'];
    $status = $_POST['status'];
    $data = "UPDATE user SET nama='$nama',nik='$nik',level='$level',status='$status' WHERE id='$id'";
    if (mysqli_query($conn, $data)) {
        echo ' <script>
        location.replace("index.php?page=kelolaakun&pesan_success=Data Berhasil diubah");
    </script>';
    } else {
        echo '<script>
    location.replace("index.php?page=kelolaakun&pesan_error=Data gagal diubah");
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
<h1 class=" mt-3 h3 mb-2 text-gray-800">Data Penguna Akun</h1>
<p class="mb-4">Data Penguna Akun yang dapat mengakses aplikasi ini.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="index.php?page=registrasi" class="btn btn-success float-right">Tambah Pengguna</a>
        <h6 class="m-0 font-weight-bold text-success">Tabel Kelola akun</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Nik</th>
                        <th>Hak Akses</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pdata as $d) { ?>
                        <tr>
                            <td><?= $d['nama'] ?></td>
                            <td><?= $d['nik'] ?></td>
                            <td>
                                <?php
                                if ($d['level'] == 1) {
                                    echo "Admin";
                                } elseif ($d['level'] == 2) {
                                    echo "Petugas Desa";
                                } elseif ($d['level'] == 3) {
                                    echo "Petugas Camat";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($d['status'] == 0) {
                                    echo "Disnebel";
                                } elseif ($d['status'] == 1) {
                                    echo "Enable";
                                }
                                ?>
                            </td>
                            <td><a href="index.php?page=kelolaakun&hapus=<?= $d['id']; ?>" onClick="return confirm('Anda yakin akan hapus ?')"><i class="fas fa-trash"></i></a>
                                |<a href="#" class="badge badge-pill badge-success" data-toggle="modal" data-target="#myModal<?= $d['id']; ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                        </tr>
                        <!-- Ubah Data Jalan -->
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
                                                <input type="hidden" name="id" class="form-control" value="<?= $d['id']; ?>">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="nama" class="form-control" value="<?= $d['nama']; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="nik" class="form-control" value="<?= $d['nik']; ?>">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <select id="inputState" name="level" class="form-control">
                                                            <?php if ($d['level'] == 1) : ?>
                                                                <option selected value="1">Admin</option>
                                                                <option value="2">Petugas Desa</option>
                                                                <option value="3">Petugas Camat</option>
                                                            <?php elseif ($d['level'] == 2) : ?>
                                                                <option value="1">Admin</option>
                                                                <option selected value="2">Petugas Desa</option>
                                                                <option value="3">Petugas Camat</option>
                                                            <?php elseif ($d['level'] == 3) : ?>
                                                                <option value="1">Admin</option>
                                                                <option value="2">Petugas Desa</option>
                                                                <option selected value="3">Petugas Camat</option>
                                                            <?php else : ?>
                                                                <option value="1">Admin</option>
                                                                <option value="2">Petugas Desa</option>
                                                                <option selected value="3">Petugas Camat</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select id="inputState" name="status" class="form-control">
                                                            <?php if ($d['status'] == 0) : ?>
                                                                <option selected value="0">Disnable</option>
                                                                <option value="1">Enable</option>
                                                            <?php elseif ($d['status'] == 1) : ?>
                                                                <option value="0">Disnable</option>
                                                                <option selected value="1">Enable</option>
                                                            <?php endif; ?>
                                                        </select>
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
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>