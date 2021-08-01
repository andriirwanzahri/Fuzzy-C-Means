<!-- Page Heading -->
<?php
include "koneksi.php";

if (isset($_GET["hapus"])) {
    // $hapus = $_GET['hapus'];
    if (hapus2($_GET, "data_keluarga", "data_keluarga_kriteria", "id_keluarga") > 0) {
        echo ' <script>
            location.replace("index.php?page=datamasyarakat&pesan_success=Data Berhasil di Hapus");
        </script>';
    } else {
        echo '<script>
            location.replace("index.php?page=datamasyarakat&pesan_error=Data gagal di Hapus");
        </script>';
    }
}

// if (isset($_POST['ubah'])) {
//     var_dump($_POST);
//     // $id_keluarga = $_POST['id'];
//     // $das = mysqli_query($conn, "SELECT * FROM data_keluarga_kriteria WHERE id_keluarga='$id_keluarga'");
//     // while ($k = mysqli_fetch_array($Qkiteria)) {
//     //     $query = "UPDATE data_keluarga_kriteria SET nilai=$nilaiK WHERE id_keluarga='$id_keluarga' AND id_kriteria='$id_kriteria'";
//     // }
// }

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
if (isset($_GET['berhasil'])) {
    echo "
    <div class='alert alert-info alert-dismissable' id='divAlert'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
            Data Tersimpan Sebanyak " . $_GET['berhasil'] . "
            </div>";
} else if (isset($_GET['gagal'])) {
    echo "
    <div class='alert alert-danger alert-dismissable' id='divAlert'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
            Data Gagal Tersimpan " . $_GET['gagal'] . "
            </div>";
}

if (isset($_POST["hapus"])) {
    $data = mysqli_query($conn, "TRUNCATE data_keluarga_kriteria");
    mysqli_query($conn, "TRUNCATE data_keluarga");
    if ($data > 0) {
        echo ' <script>
        location.replace("index.php?page=datamasyarakat&pesan_success=Data Berhasil dihapus");
    </script>';
    } else {
        echo ' <script>
        location.replace("index.php?page=datamasyarakat&pesan_error=Data gagal dihapus");
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
<button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#KeteranganModal">Keterangan</button>
<h1 class=" mt-3 h3 mb-2 text-gray-800">Data Masyarakat</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#HapusModal">Hapus Semua Data</button>
        <form action="uploadmasyarakat.php" class="float-right" enctype="multipart/form-data" method="post">
            <button type="submit" name="upload" class="float-right btn btn-outline-secondary">upload</button>
            <input type="file" name="datamasya" class="float-right" id="">
        </form>
        <h6 class="m-0 font-weight-bold text-success">Tabel Masyarakat</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                <thead>
                    <tr>
                        <td class="text-center">Nama Keluarga</td>
                        <td class="text-center">NIK</td>
                        <?php
                        for ($i = 0; $i < count($kriteria); $i++) {
                            echo "<td>" . $kriteria[$i] . "</td>";
                        }
                        ?>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = query("SELECT * FROM data_keluarga");
                    $j = 0;
                    foreach ($data as $d) {
                    ?>
                        <tr>
                            <td><?= $d['nama_keluarga']; ?></td>
                            <td><?= $d['id_keluarga']; ?></td>
                            <?php
                            for ($i = 0; $i < count($kriteria); $i++) {
                                echo "<td>" . $keluargakriteria[$j][$i] . "</td>";
                            }
                            ?>
                            <td><a href='index.php?page=datamasyarakat&hapus=<?= $d['id_keluarga']; ?>' class="badge badge-pill badge-danger" onClick="return confirm('Anda yakin akan hapus ?')"><i class="fas fa-trash"></i> hapus</a>
                                <a href="#" class="badge badge-pill badge-success" data-toggle="modal" data-target="#myModal<?php echo $d['id_keluarga']; ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Ubah Data Jalan -->
                        <div class="modal fade bd-example-modal-lg" id="myModal<?= $d['id_keluarga']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <input type="hidden" name="id" class="form-control" value="<?= $d['id_keluarga']; ?>">
                                                <div class="row">
                                                    <?php
                                                    $id_keluarga = $d['id_keluarga'];
                                                    $Qkiteria = mysqli_query($conn, "SELECT * FROM data_keluarga_kriteria WHERE id_keluarga='$id_keluarga'");
                                                    while ($k = mysqli_fetch_array($Qkiteria)) :
                                                        $id_kriteria = $k['id_kriteria'];
                                                        $sub = mysqli_query($conn, "SELECT * FROM sub_kriteria WHERE id_kriteria='$id_kriteria'");
                                                        $lit = mysqli_num_rows($sub); ?>
                                                        <div class="form-group col-md-6">
                                                            <label for="inputState"><?= $k['nama_kriteria']; ?></label>
                                                            <?php if ($lit > 0) : ?>
                                                                <input type="hidden" name="<?= $k['id_kriteria']; ?>" value="<?= $k['id_kriteria']; ?>">
                                                                <select id="inputState" name="<?= $k['id_kriteria']; ?>" class="form-control">
                                                                    <?php
                                                                    while ($d = mysqli_fetch_array($sub)) {
                                                                        if ($k['nilai'] == $d['nilai']) {
                                                                    ?>
                                                                            <option selected value="<?= $d['nilai']; ?>"><?= $d['nama_sub']; ?></option>
                                                                    <?php }
                                                                    } ?>
                                                                </select>
                                                            <?php endif; ?>
                                                            <?php if ($lit == 0) : ?>
                                                                <input type="hidden" name="<?= $k['id_kriteria']; ?>" value="<?= $k['id_kriteria']; ?>">
                                                                <input type="text" name="<?= $k['id_kriteria']; ?>" class="form-control" value="<?= $k['nilai']; ?>" placeholder="Masukkan Nilai <?= $k['id_kriteria']; ?>" id="inputCity">
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endwhile; ?>
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
                    <?php
                        $j++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="HapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Siap untuk Menghapus?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah Anda Yakin Ingin menghapus Semua Data.</div>
            <div class="modal-footer">
                <form action="" method="post">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" name="hapus">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="KeteranganModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $tkriteria = query("SELECT * FROM data_kriteria");

                foreach ($tkriteria as $k) {
                    $id = $k['id_kriteria'];
                    $subkriteria = mysqli_query($conn, "SELECT * FROM sub_kriteria WHERE id_kriteria='$id'");
                ?>

                    <div class="row mt-5">
                        <div class="col-md-12 text-center"><?= $k['nama_kriteria']; ?></div>
                    </div>
                    <div class="row">
                        <?php
                        while ($s = mysqli_fetch_array($subkriteria)) {
                        ?>
                            <div class="col-md-6 text-center"><?= $s['nama_sub']; ?></div>
                            <div class="col-md-6 text-center"><?= $s['nilai']; ?></div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </form>
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