<?php
include 'koneksi.php';
include "excel_reader/excel_reader2.php";
// upload file xls
$target = basename($_FILES['datamasya']['name']);
move_uploaded_file($_FILES['datamasya']['tmp_name'], $target);

// beri permisi agar file xls dapat di baca
$cham = chmod($_FILES['datamasya']['name'], 0777);

if ($cham) {

    // mengambil isi file xls
    $data = new Spreadsheet_Excel_Reader($_FILES['datamasya']['name'], false);
    // menghitung jumlah baris data yang ada
    $jumlah_baris = $data->rowcount($sheet_index = 0);

    // jumlah default data yang berhasil di import
    $berhasil = 0;
    for ($i = 2; $i <= $jumlah_baris; $i++) {
        // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
        $nik = $data->val($i, 1);
        $nama_keluarga = $data->val($i, 2);
        $kecamatan = $data->val($i, 3);
        $desa = $data->val($i, 4);
        $alamat = $data->val($i, 5);

        $luas_lantai = $data->val($i, 6);
        $lantai = $data->val($i, 7);
        $dinding = $data->val($i, 8);
        $atap = $data->val($i, 9);
        $kloset = $data->val($i, 10);
        // ================================
        $idluaslantai = $data->val(2, 11);
        $iddinding = $data->val(3, 11);
        $idatap = $data->val(4, 11);
        $idlantai = $data->val(5, 11);
        $idkloset = $data->val(6, 11);
        // nama kriteria
        $nama_luas = $data->val(1, 6);
        $namalantai = $data->val(1, 7);
        $namadinding = $data->val(1, 8);
        $namaatap = $data->val(1, 9);
        $namakloset = $data->val(1, 10);

        if (
            $nama_keluarga != ""
            && $nik != ""
            && $kecamatan != ""
            && $desa != ""
            && $alamat != ""
            && $luas_lantai != ""
            && $lantai != ""
            && $dinding != ""
            && $atap != ""
            && $kloset != ""
        ) {
            //masukkan data  pada table  data preprocessing
            $result = mysqli_query($conn, "INSERT INTO data_keluarga VALUES('$nik','$nama_keluarga','$alamat','$desa','$kecamatan')");
            $result2 = mysqli_query($conn, "INSERT INTO data_keluarga_kriteria VALUES('','$nama_luas','$nik','$idluaslantai','$luas_lantai')");
            $result3 = mysqli_query($conn, "INSERT INTO data_keluarga_kriteria VALUES('','$namalantai','$nik','$idlantai','$lantai')");
            $result4 = mysqli_query($conn, "INSERT INTO data_keluarga_kriteria VALUES('','$namadinding','$nik','$iddinding','$dinding')");
            $result4 = mysqli_query($conn, "INSERT INTO data_keluarga_kriteria VALUES('','$namaatap','$nik','$idatap','$atap')");
            $result4 = mysqli_query($conn, "INSERT INTO data_keluarga_kriteria VALUES('','$namakloset','$nik','$idkloset','$kloset')");
            $berhasil++;
            if ($result) {
                header("location:index.php?page=datamasyarakat&berhasil=$berhasil");
            } else {
                header("location:index.php?page=datamasyarakat&gagal=0");
            }
        }
    }
} else {
    header("location:index.php?page=datamasyarakat&file=tidak ada file");
}
// hapus kembali file .xls yang di upload tadi
unlink($_FILES['datamasya']['name']);
