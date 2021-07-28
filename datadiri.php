<?php
include 'koneksi.php';
$id_keluarga = $_SESSION['login']['nik'];
$query = mysqli_query($conn, "SELECT * FROM data_keluarga WHERE id_keluarga='$id_keluarga'");
$Qkiteria = mysqli_query($conn, "SELECT * FROM data_keluarga_kriteria WHERE id_keluarga='$id_keluarga'");
$ada = mysqli_fetch_array($query);
$row = mysqli_num_rows($query);
$rowKiteria = mysqli_num_rows($Qkiteria);
$kriteria = query("SELECT * FROM data_kriteria");
if (isset($_POST['simpan'])) {
    if (datadiri($_POST) > 0) {
        echo ' <script>
        location.replace("index.php?page=datadiri&pesan_success=Data Berhasil ditambahkan");
    </script>';
    } else {
        echo '<script>
    location.replace("index.php?page=datadiri&pesan_error=Data gagal ditambahkan");
    </script>';
    }
}

if (isset($_GET["hapus"])) {
    if (hapus($_GET, "data_keluarga_kriteria", "id_keluarga") > 0) { // ('iddata','nama tabel','kolom id')
        echo ' <script>
            location.replace("index.php?page=datadiri&pesan_success=Data Berhasil dihapus");
        </script>';
    } else {
        echo '<script>
            location.replace("index.php?page=datadiri&pesan_error=Data Berhasil dihapus");
        </script>';
    }
}


if (isset($_POST['ubah'])) {
    // var_dump($_POST);
    if (dataset($_POST, $id_keluarga) > 0) {
        echo ' <script>
            location.replace("index.php?page=datadiri&pesan_success=Data Berhasil ditambahkan");
        </script>';
    } else {
        echo '<script>
        location.replace("index.php?page=datadiri&pesan_error=Data gagal ditambahkan");
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

if ($row > 0) :
?>
    <h1 class=" mt-3 h3 mb-2 text-gray-800">Data Diri ada</h1>
    <p class="mb-4">Masukkan Data Lengkap Diri Anda...</p>
    <form action="" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" id="inputEmail4" placeholder="Nama lengkap" value="<?= $ada['nama_keluarga']; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">NIK</label>
                <input type="text" class="form-control" name="nik" id="inputPassword4" placeholder="Nik" value="<?= $ada['id_keluarga']; ?>" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Alamat</label>
                <input type="text" name="alamat" class="form-control" id="inputCity" value="<?= $ada['alamat']; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="inputCity">Jenis Kelamin</label>
                <input type="text" name="jk" class="form-control" id="inputCity" value="<?= $ada['kota']; ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Kota</label>
                <input type="text" name="kota" class="form-control" id="inputCity" value="<?= $ada['kota']; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="inputCity">provinsi</label>
                <input type="text" name="provinsi" class="form-control" id="inputCity" value="<?= $ada['provinsi']; ?>">
            </div>
        </div>
        <button type="submit" name="simpan" value="simpan" class="btn btn-success">Simpan</button>
    </form>
    <?php if ($rowKiteria > 0) : ?>
        <h1 class=" mt-3 h3 mb-2 text-gray-800">Data lainnya ada</h1>
        <p class="mb-4">Data lainnya Sudah terisi Anda...</p>
        <form action="" method="post" class="card mb-5">
            <div class="row">
                <?php
                $Qkiteria = mysqli_query($conn, "SELECT * FROM data_keluarga_kriteria WHERE id_keluarga='$id_keluarga'");
                while ($k = mysqli_fetch_array($Qkiteria)) :
                    $id_kriteria = $k['id_kriteria'];
                    $sub = mysqli_query($conn, "SELECT * FROM sub_kriteria WHERE id_kriteria='$id_kriteria'");
                    $lit = mysqli_num_rows($sub); ?>
                    <div class="form-group col-md-6">
                        <label for="inputState"><?= $k['nama_kriteria']; ?></label>
                        <?php if ($lit > 0) : ?>
                            <input type="hidden" name="<?= $k['id_kriteria']; ?>" value="<?= $k['id_kriteria']; ?>">
                            <select id="inputState" name="<?= $k['nama_kriteria']; ?>" readonly="" class="form-control">
                                <?php while ($d = mysqli_fetch_array($sub)) {
                                    if ($k['nilai'] == $d['nilai']) { ?>
                                        <option selected value="<?= $d['nilai']; ?>"><?= $d['nama_sub']; ?></option>
                                <?php }
                                } ?>
                            </select>
                        <?php endif; ?>
                        <?php if ($lit == 0) : ?>
                            <input type="hidden" name="<?= $k['id_kriteria']; ?>" value="<?= $k['id_kriteria']; ?>">
                            <input type="text" name="<?= $k['id_kriteria']; ?>" class="form-control" value="<?= $k['nilai']; ?>" readonly placeholder="Masukkan Nilai <?= $k['id_kriteria']; ?>" id="inputCity">
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </form>
        <a href="index.php?page=datadiri&hapus=<?= $_SESSION['login']['nik']; ?>" type="submit" name="hapus" class="float-right btn btn-danger">Hapus</a>
    <?php else : ?>
        <h1 class=" mt-3 h3 mb-2 text-gray-800">Data lainnya tidak</h1>
        <p class="mb-4">Masukkan Data lainnya Anda...</p>
        <form action="" method="post" class="mb-5">
            <div class="row">
                <?php
                foreach ($kriteria as $k) :
                    $id_kriteria = $k['id_kriteria'];
                    $sub = mysqli_query($conn, "SELECT * FROM sub_kriteria WHERE id_kriteria='$id_kriteria'");
                    // $lit = mysqli_fetch_array($sub);
                    $lit = mysqli_num_rows($sub);
                ?>
                    <div class="form-group col-md-6">
                        <label for="inputState"><?= $k['nama_kriteria']; ?></label>
                        <?php if ($lit > 0) : ?>
                            <input type="hidden" name="<?= $k['id_kriteria']; ?>" value="<?= $k['id_kriteria']; ?>">
                            <select id="inputState" name="<?= $k['nama_kriteria']; ?>" class="form-control">
                                <?php while ($d = mysqli_fetch_array($sub)) { ?>
                                    <option selected value="<?= $d['nilai']; ?>"><?= $d['nama_sub']; ?></option>
                                <?php } ?>
                            </select>
                        <?php endif; ?>
                        <?php if ($lit == 0) : ?>
                            <input type="hidden" name="<?= $k['id_kriteria']; ?>" value="<?= $k['id_kriteria']; ?>">
                            <input type="text" name="<?= $k['nama_kriteria']; ?>" class="form-control" placeholder="Masukkan Nilai <?= $k['nama_kriteria']; ?>" id="inputCity">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" name="ubah" value="ubah" class="float-right btn btn-success">Simpan</button>
        </form>
    <?php endif; ?>
<?php else : ?>

    <h1 class=" mt-3 h3 mb-2 text-gray-800">Data Diri tidak</h1>
    <p class="mb-4">Masukkan Data Lengkap Diri Anda...</p>
    <form action="" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" id="inputEmail4" placeholder="Email" value="<?= $_SESSION['login']['nama']; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">NIK</label>
                <input type="text" name="nik" class="form-control" id="inputPassword4" placeholder="Nik" value="<?= $_SESSION['login']['nik']; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label for="inputAddress">Alamat</label>
            <input type="text" name="alamat" class="form-control" id="inputAddress" placeholder="Alamat">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Kota</label>
                <input type="text" name="kota" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-6">
                <label for="inputCity">provinsi</label>
                <input type="text" name="provinsi" class="form-control" id="inputCity">
            </div>
        </div>
        <button type="submit" name="simpan" value="tambah" class="btn btn-success">Simpan</button>
    </form>
<?php endif; ?>