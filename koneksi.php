<?php
$conn = mysqli_connect('localhost', 'root', '', 'k_means');

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function hapus2($data, $tabel1, $tabel2, $idtabel)
{
    global $conn;
    $id = $data["hapus"];
    $as = mysqli_query($conn, "SELECT * FROM $tabel2 WHERE $idtabel='$id'");
    $data = mysqli_num_rows($as);
    $query1 = "DELETE FROM $tabel1 WHERE $idtabel='$id'";
    $query2 = "DELETE FROM $tabel2 WHERE $idtabel='$id'";
    if ($data > 0) {
        mysqli_query($conn, $query1);
        mysqli_query($conn, $query2);
    } else {
        mysqli_query($conn, $query1);
    }

    return mysqli_affected_rows($conn);
}

function hapus($data, $tabel1, $idtabel)
{
    global $conn;
    $id = $data["hapus"];
    $query1 = "DELETE FROM $tabel1 WHERE $idtabel='$id'";
    mysqli_query($conn, $query1);
    return mysqli_affected_rows($conn);
}



function tambahkriteria($data, $kodeauto)
{
    global $conn;
    $namakriteria = $data["namakriteria"];
    mysqli_query($conn, "INSERT INTO data_kriteria VALUES('$kodeauto', '$namakriteria')");

    return mysqli_affected_rows($conn);
}

function tambahsubkriteria($data, $kodekriteria)
{
    global $conn;
    $namasubkriteria = $data["namasubkriteria"];
    $nilai = $data["nilai"];
    mysqli_query($conn, "INSERT INTO sub_kriteria VALUES('','$kodekriteria','$namasubkriteria','$nilai')");
    return mysqli_affected_rows($conn);
}

function datadiri($data)
{
    global $conn;
    $nama = $data["nama"];
    $nik = $data["nik"];
    $alamat = $data["alamat"];
    $kota = $data["kota"];
    $provinsi = $data["provinsi"];
    $tombol = $data["simpan"];

    if ($tombol == "tambah") {
        // echo "oke";
        mysqli_query($conn, "INSERT INTO data_keluarga VALUES('$nik','$nama','$alamat','$kota','$provinsi')");
    } else {
        mysqli_query($conn, "UPDATE data_keluarga SET nama_keluarga = '$nama', alamat = '$alamat',kota = '$kota',provinsi = '$provinsi'
          WHERE id_keluarga = '$nik'");
        // echo "tidak";
    }
    return mysqli_affected_rows($conn);
}

function dataset($data, $id_keluarga)
{
    global $conn;
    $kriteria = query("SELECT * FROM data_kriteria");
    foreach ($kriteria as $k) {
        $kiteria = $k['id_kriteria'];
        $n = $k['nama_kriteria'];
        $id_kriteria = $data[$kiteria];
        $nilai = $data[$n];
        mysqli_query($conn, "INSERT INTO data_keluarga_kriteria VALUES('','$n','$id_keluarga','$id_kriteria','$nilai')");
    }
    return mysqli_affected_rows($conn);
}

function registrasi($data)
{
    global $conn;
    $nama = $data["nama"];
    $nik = $data["nik"];
    $jk = $data["jk"];
    $level = $data["level"];
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek nik sudah ada atau belum
    $result2 = mysqli_query($conn, "SELECT nik FROM user WHERE nik='$nik'");
    if (mysqli_fetch_assoc($result2)) {
        echo "<script>
        alert('nik anda sudah Terdaftar!')
        </script>";
        return false;
    }
    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
				alert('konfirmasi password tidak sesuai!');
                </script>";
        return false;
    }
    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan userbaru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$nama','$jk','$nik', '$password','$level','1')");


    return mysqli_affected_rows($conn);
}


// ========================================================= alert
function display_error($msg)
{
    echo "<div class='alert alert-danger alert-dismissable'>
            
            <h4><i class='icon fa fa-ban'></i> Error! </h4>
            " . $msg . "
        </div>";
}

function display_success($msg)
{
    echo "<div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-check'></i> Success. </h4>
                    " . $msg . "
                  </div>";
}
