<?php
// function import($file)
// {
//     try {
//         $users = array();
//         $params = array(1 => 'user_name', 'user_password', 'user_first_name', 'user_last_name', 'user_email', 'user_group', 'user_vhost');
//         $excel = new Spreadsheet_Excel_Reader($file);
//         $rows = $excel->rowcount($sheet_index = 0);
//         $cols = $excel->colcount($sheet_index = 0);
//         for ($row = 2; $row <= $rows; $row++) {
//             if ($cols == 7) {
//                 for ($col = 1; $col <= $cols; $col++) {
//                     $users[$row][$params[$col]] = $excel->val($row, $col);
//                     $users[$row]['user_vhost'] = explode(',', $excel->val($row, 7));
//                     $users[$row]['user_group'] = '';
//                 }
//             }
//         }
//         $this->userimport = new userimport();
//         $users = $this->userimport->import($users);
//         $_SESSION['message'] = $this->userimport->get_message();
//         return $users;
//     } catch (Exception $e) {
//         display_page_error();
//     }
// }

// var_dump($kriteria);/
?>
<!-- Menampilkan Data Masyarakat -->
<div class='row'>
    <br />
    Data Alternatif, Kriteria
    <br />
    Yang akan Di hitung Keanggotaan dalam Cluster
    <br />
    <br />
    <div class="table-responsive">
        <table class='table table-bordered' id='dataTable' width='90%' cellspacing='0'>
            <thead>
                <tr bgcolor="green" style="color: white;">
                    <td rowspan="2" class="text-center">Nama</td>
                    <?php echo "<td colspan=\"" . count($kriteria) . "\" align=\"center\">Kriteria</td>"; ?>
                </tr>
                <tr bgcolor="green" style="color: white;">
                    <?php
                    for ($i = 0; $i < count($kriteria); $i++) {
                        echo "<td>" . $kriteria[$i] . "</td>";
                    }
                    ?>
            </thead>
            <tbody>
                <?php
                echo "</tr>";

                for ($j = 0; $j < count($keluarga); $j++) {
                    echo "<tr>";
                    echo "<td>" . $keluarga[$j] . "</td>";
                    for ($i = 0; $i < count($kriteria); $i++) {
                        echo "<td>" . $keluargakriteria[$j][$i] . "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '../../koneksi.php';
include "../excel_reader2.php";
// upload file xls
$target = basename($_FILES['datauji']['name']);
move_uploaded_file($_FILES['datauji']['tmp_name'], $target);

// beri permisi agar file xls dapat di baca
$cham = chmod($_FILES['datauji']['name'], 0777);

if ($cham) {

    // mengambil isi file xls
    // $data = new Spreadsheet_Excel_Reader($_FILES['datauji']['name'], false);
    // menghitung jumlah baris data yang ada
    $jumlah_baris = $data->rowcount($sheet_index = 0);
    $jumlah_baris = $data->colcount($sheet_index = 0);

    // jumlah default data yang berhasil di import
    $berhasil = 0;
    for ($i = 2; $i <= $jumlah_baris; $i++) {

        // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing

        $namaLintas     = $data->val($i, 1);
        $namaLintas = $data->val($i, 2);
        $panjangRuas = $data->val($i, 3);
        $jns_pen = $data->val($i, 4);
        $tanah_krikil = $data->val($i, 5);
        $aspal = $data->val($i, 6);
        $rigit = $data->val($i, 7);
        $kondisi = $data->val($i, 8);

        if ($ura_dukung != "" && $namaLintas != "" && $panjangRuas != "" && $jns_pen != "" && $tanah_krikil != "" && $aspal != "" && $rigit != "" && $kondisi != "") {
            //masukkan data  pada table  data preprocessing
            $result = mysqli_query($conn, "INSERT INTO datauji VALUES('','$ura','$NL','$pR','$JP','$tK','$aspl','$rgt','$kon','','')");
            $berhasil++;
            if ($result) {
                header("location:../../index.php?page=hitungAkurasi&berhasil=$berhasil");
            } else {
                header("location:../../index.php?page=hitungAkurasi&gagal=0");
            }
        }
    }
} else {
    header("location:../../index.php?page=hitungAkurasi&gagal=tidak ada file");
}
// hapus kembali file .xls yang di upload tadi
unlink($_FILES['datauji']['name']);

// alihkan halaman ke index.php

// $conn = mysqli_connect('localhost', 'root', '', 'k_means');

// //ini sialisasi cluster awal
// function jumlah($conn, $data)
// {
//     $row = $conn->query($data)->fetch_array();
//     return $row[0];
// }
// $jmldata = jumlah($conn, "SELECT count(*) FROM data");

// for ($i = 0; $i < $jmldata; $i++) {
//     $clusterawal[$i] = "1";
// }

// $centro1[0] = array("2", "5", "1");
// $centro2[0] = array("2", "1", "3");
// $centro3[0] = array("2", "3", "2");

// $status = 'false';
// $loop = '0';
// $x = 0;
// while ($status == 'false') {
//     //proses k-means perhitungan
//     $query = "SELECT * FROM data";
//     $result = $conn->query($query);
//     while ($data = mysqli_fetch_assoc($result)) {
//         extract($data);
//         $hasilc1 = 0;
//         $hasilc2 = 0;
//         $hasilc3 = 0;
//         //Proses pencarian Nilai Centroi1
//         $hasilc1 = sqrt(pow($gaji - $centro1[$loop][0], 2) +
//             pow($keluaran - $centro1[$loop][1], 2) +
//             pow($pekerjaan - $centro1[$loop][2], 2));

//         //Proses pencarian Nilai Centroi1
//         $hasilc2 = sqrt(pow($gaji - $centro2[$loop][0], 2) +
//             pow($keluaran - $centro2[$loop][1], 2) +
//             pow($pekerjaan - $centro2[$loop][2], 2));

//         //Proses pencarian Nilai Centroi1
//         $hasilc3 = sqrt(pow($gaji - $centro3[$loop][0], 2) +
//             pow($keluaran - $centro3[$loop][1], 2) +
//             pow($pekerjaan - $centro3[$loop][2], 2));

//         //Mencari Nilai Terkecil
//         if ($hasilc1 < $hasilc2 && $hasilc1 < $hasilc3) {
//             $clusterakhir[$x] = 'C1';
//             update_data($conn, $id, 'C1');
//         } elseif ($hasilc2 < $hasilc1 && $hasilc2 < $hasilc3) {
//             $clusterakhir[$x] = 'C2';
//             update_data($conn, $id, 'C2');
//         } else {
//             $clusterakhir[$x] = 'C3';
//             update_data($conn, $id, 'C3');
//         }
//         //penambahan counter index
//         $x += 1;
//     }
//     //jika selesai 
//     //Proses mencari centroid baru dari basis data.
//     //centroid baru pusat 1
//     $loop += 1;
//     $centro1[$loop][0] = jumlah($conn, "SELECT avg(gaji)FROM data WHERE rule='C1'");
//     $centro1[$loop][1] = jumlah($conn, "SELECT avg(keluaran)FROM data WHERE rule='C1'");
//     $centro1[$loop][2] = jumlah($conn, "SELECT avg(pekerjaan)FROM data WHERE rule='C1'");

//     //centroid baru pusat 1
//     $centro2[$loop][0] = jumlah($conn, "SELECT avg(gaji)FROM data WHERE rule='C2'");
//     $centro2[$loop][1] = jumlah($conn, "SELECT avg(keluaran)FROM data WHERE rule='C2'");
//     $centro2[$loop][2] = jumlah($conn, "SELECT avg(pekerjaan)FROM data WHERE rule='C2'");
//     //centroid baru pusat 1
//     $centro3[$loop][0] = jumlah($conn, "SELECT avg(gaji)FROM data WHERE rule='C3'");
//     $centro3[$loop][1] = jumlah($conn, "SELECT avg(keluaran)FROM data WHERE rule='C3'");
//     $centro3[$loop][2] = jumlah($conn, "SELECT avg(pekerjaan)FROM data WHERE rule='C3'");
//     $status = 'true';

//     for ($i = 0; $i < $jmldata; $i++) {
//         if ($clusterawal[$i] != $clusterakhir[$i]) {
//             $status = 'false';
//         }
//     }
//     if ($clusterawal = $clusterakhir) {
//         $status == 'true';
//     }
// }
// echo "proses Berhasil dilakukan sebanyak $loop kali";

// function update_data($conn, $id, $rule)
// {
//     $stmt = mysqli_query($conn, "UPDATE data SET rule='$rule' WHERE id=$id");
// }
