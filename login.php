<?php
include 'koneksi.php';
include 'header.php';
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}
if (isset($_POST["login"])) {

    $nik = $_POST["nik"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE nik = '$nik'");
    // $status = mysqli_query($conn, "SELECT * FROM user WHERE status = '0'");

    // cek nik
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row["status"] == '0') {
            $status = true;
        } else {
            // cek password
            if (password_verify($password, $row["password"])) {
                // set session
                // $_SESSION["login"] = true;
                $_SESSION['login']['level'] = $row['level'];
                $_SESSION['login']['nama'] = $row['nama'];
                $_SESSION['login']['nik'] = $row['nik'];
                header("Location: index.php");
                exit;
            }
        }
    } else {
        $error = true;
    }
}


?>
<div class="container">
    <div class="p-5">
        <div class="row justify-content-center">
            <div class="card col-md-6">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Halaman Login!</h1>
                        </div>
                        <form class="user" action="" method="post">
                            <div class="form-group">
                                <input type="text" name="nik" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="NIK 110804xxxxxxxxxx">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                            </div>

                            <button type="submit" name="login" class="btn btn-success btn-user btn-block">
                                Login
                            </button>
                            <hr>
                            <?php if (isset($error)) : ?>
                                <p style="color: red; font-style: italic;">nik / password salah</p>
                            <?php endif; ?>
                            <?php if (isset($status)) : ?>
                                <p style="color: red; font-style: italic;">Akun Anda Belum Aktif</p>
                            <?php endif; ?>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="registrasi.php">Daftar Akun</a>
                        </div>
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
<?php include 'footer.php'; ?>