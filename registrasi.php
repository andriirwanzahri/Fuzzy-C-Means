<?php
include 'koneksi.php';

if (isset($_POST["register"])) {

    if (registrasi($_POST) > 0) {
        echo ' <script>
        location.replace("index.php?page=kelolaakun&pesan_success= Akun Berhasil Di tambahkan");
    </script>';
    } else {
        echo mysqli_error($conn);
    }
}
?>
<div class="container">
    <!-- Nested Row within Card Body -->
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Daftar Akun!</h1>
                </div>
                <form action="" method="post" class="user">
                    <div class="form-group">
                        <input type="text" name="nama" class="form-control " id="exampleInputEmail" placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="nik" class="form-control " id="exampleInputEmail" placeholder="NIK 110804xxxxxxxxxx" required>
                    </div>
                    <div class="form-group">
                        <label for="inputState">Jenis Kelamin</label>
                        <select id="inputState" name="jk" class="form-control">
                            <option selected value="laki-laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputState">Level Penguna</label>
                        <select id="inputState" name="level" class="form-control">
                            <option selected value="1">Admin</option>
                            <option value="2">Petugas Desa</option>
                            <option value="3">Petugas Camat</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" name="password" class="form-control " id="exampleInputPassword" placeholder="Password" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="password" name="password2" class="form-control " id="exampleRepeatPassword" placeholder="Konfirmasi Password" required>
                        </div>
                    </div>
                    <button type="text" name="register" class="btn btn-primary btn-user btn-block">
                        Daftar
                    </button>
                    <div class="text-center">
                        <a class="small" href="login.php">Kembali</a>
                    </div>
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