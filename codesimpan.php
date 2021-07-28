<?php
include "koneksi.php";
$pangkat = 2;
$maxIterasi = 100;
$error = 0.000001;

fcm($conn, $pangkat, $maxIterasi, $error);

function tampiltabel($arr)
{
    echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>";
    for ($i = 0; $i < count($arr); $i++) {
        echo '<tr>';
        for ($j = 0; $j < count($arr[$i]); $j++) {
            echo '<td>' . $arr[$i][$j] . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

function fcm($conn, $pangkat, $maxIterasi, $error)
{
    $centro1[0] = array(0.3, 0.3, 0.8, 0.5, 0.5, 0.2, 0.3, 0.6);
    $centro2[0] = array(0.3, 0.5, 0.1, 0.2, 0.1, 0.1, 0.4, 0.2);
    $centro3[0] = array(0.4, 0.2, 0.1, 0.3, 0.4, 0.7, 0.3, 0.2);

    $keangotaan = array(
        array(0.3, 0.3, 0.4),
        array(0.3, 0.5, 0.2),
        array(0.8, 0.1, 0.1),
        array(0.5, 0.2, 0.3),
        array(0.5, 0.1, 0.4),
        array(0.2, 0.1, 0.7),
        array(0.3, 0.4, 0.3),
        array(0.6, 0.2, 0.2)
    );

    $objective = 0;
    $fungsi_objective = 0;
    $loop = 0;
    $iterasi = 1;
    $status = 'false';
    while ($status == 'false') {
        $nilai_gaji = array();
        $nilai_gaji = cek_nilaiAtribut($conn, 'gaji',);
        $nilai_id = array();
        $nilai_id = cek_nilaiAtribut($conn, 'id',);
        $nilai_keluaran = array();
        $nilai_keluaran = cek_nilaiAtribut($conn, 'keluaran',);
        $jmlcentro = count($nilai_keluaran);

        print_r($nilai_gaji);

        echo "<h1 class='text-center'>Iterasi " . $iterasi . "</h1>";

        tampiltabel($keangotaan);
        // ================= Tabel Keangotaan =========
        echo "
        <table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
        <tr>
            <th colspan='3' class='text-center'>Keangotaan</th>
        </tr>";
        $a = 0;
        while ($a < $jmlcentro) {
            echo "<tr>
            <td>" . $centro1[$loop][$a] . "</td>
                <td>" . $centro2[$loop][$a] . "</td>
                <td>" . $centro3[$loop][$a] . "</td> </tr>";
            $a++;
        }
        echo "
        <table><br>
        ";
        // ======================== Tabel Miu Kuadrat ============================
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
        <tr>
            <th colspan='3' class='text-center'>miuKuadrat</th>
        </tr>";
        $a = 0;
        $miuKtotal1 = 0;
        $miuKtotal2 = 0;
        $miuKtotal3 = 0;
        while ($a < $jmlcentro) {
            $miuKuadrat1 = hitungKuadrat($centro1[$loop][$a], $pangkat);
            $miuKuadrat2 = hitungKuadrat($centro2[$loop][$a], $pangkat);
            $miuKuadrat3 = hitungKuadrat($centro3[$loop][$a], $pangkat);
            echo "
            <tr>
                <td>" . $miuKuadrat1 . "</td>
                <td>" . $miuKuadrat2 . "</td>
                <td>" . $miuKuadrat3 . "</td> 
            </tr>";
            $miuKtotal1 += $miuKuadrat1;
            $miuKtotal2 += $miuKuadrat2;
            $miuKtotal3 += $miuKuadrat3;
            $a++;
        }
        echo "<table> <br>";
        // ======================= Tabel Miu kuadrat Total=============================
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
        <tr>
            <th colspan='3' class='text-center'>miuKuadrat Total</th>
        </tr>
        <tr>
            <td>" . $miuKtotal1 . "</td>
            <td>" . $miuKtotal2 . "</td>
            <td>" . $miuKtotal3 . "</td> 
        </tr>
        <table><br>";
        // ===========================Miu kuadrat X 1=============================
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
        <tr>
            <th colspan='3' class='text-center'>miu X1</th>
        </tr>";
        $a = 0;
        $miuX1Gajitotal = 0;
        $miuX1Keluarantotal = 0;
        while ($a < $jmlcentro) {
            $miuKuadrat1 = hitungKuadrat($centro1[$loop][$a], $pangkat);
            $miuX1Gaji = hitungXkuadrat($miuKuadrat1, $nilai_gaji[$a]);
            $miuX1keluaran = hitungXkuadrat($miuKuadrat1, $nilai_keluaran[$a]);
            echo "<tr>
            <td>" . $miuX1Gaji . "</td>
                <td>" . $miuX1keluaran . "</td>";
            //menghitung miu kuadrat X1
            $miuX1Gajitotal += $miuX1Gaji;
            $miuX1Keluarantotal += $miuX1keluaran;
            $a++;
        }
        echo "
        <table><br>
        ";
        // ======================= Miu Kuadrat X1 Total=============================
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
        <tr><th colspan='3' class='text-center'>miuKuadrat X1 Total</th></tr>
        <tr><td>" . $miuX1Gajitotal . "</td>
        <td>" . $miuX1Keluarantotal . "</td> </tr>
        <table><br>";
        // ======================== Miu Kuadrat X2======================================
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
        <tr>
            <th colspan='3' class='text-center'>miu X2</th>
        </tr>";
        $a = 0;
        $miuX2Gajitotal = 0;
        $miuX2Keluarantotal = 0;
        while ($a < $jmlcentro) {
            $miuKuadrat2 = hitungKuadrat($centro2[$loop][$a], $pangkat);
            $miuX2Gaji = hitungXkuadrat($miuKuadrat2, $nilai_gaji[$a]);
            $miuX2keluaran = hitungXkuadrat($miuKuadrat2, $nilai_keluaran[$a]);
            echo "<tr>
            <td>" . $miuX2Gaji . "</td>
            <td>" . $miuX2keluaran . "</td>";
            //menghitung miu kuadrat X2
            $miuX2Gajitotal += $miuX2Gaji;
            $miuX2Keluarantotal += $miuX2keluaran;
            $a++;
        }
        echo "
            <table><br>
            ";
        // ====================== Miu Kuadrat X2 Total==============================
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
            <tr><th colspan='3' class='text-center'>miuKuadrat X2 Total</th></tr>
            <tr><td>" . $miuX2Gajitotal . "</td>
            <td>" . $miuX2Keluarantotal . "</td> </tr>
            <table> <br>";
        // ======================== Miu Kuadrat X 3=============================================
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
        <tr>
            <th colspan='3' class='text-center'>miu X3</th>
        </tr>";
        $a = 0;
        $miuX3Gajitotal = 0;
        $miuX3Keluarantotal = 0;
        while ($a < $jmlcentro) {
            $miuKuadrat3 = hitungKuadrat($centro3[$loop][$a], $pangkat);
            $miuX3Gaji = hitungXkuadrat($miuKuadrat3, $nilai_gaji[$a]);
            $miuX3keluaran = hitungXkuadrat($miuKuadrat3, $nilai_keluaran[$a]);
            echo "<tr>
            <td>" . $miuX3Gaji . "</td>
                <td>" . $miuX3keluaran . "</td>";
            //menghitung miu kuadrat X1
            $miuX3Gajitotal += $miuX3Gaji;
            $miuX3Keluarantotal += $miuX3keluaran;
            $a++;
        }
        echo "
               <table><br>
               ";
        // ===================== Miu kuadfrat X 3 Total ===============================
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
               <tr><th colspan='3' class='text-center'>miuKuadrat X3 Total</th></tr>
               <tr><td>" . $miuX3Gajitotal . "</td>
               <td>" . $miuX3Keluarantotal . "</td> </tr>
               <table><br>";
        // ============================== Tabel Pusat Cluster ========================================
        $Cluster1k1 = pusatCluster($miuX1Gajitotal, $miuKtotal1);
        $Cluster1k2 = pusatCluster($miuX1Keluarantotal, $miuKtotal1);
        $Cluster2k1 = pusatCluster($miuX2Gajitotal, $miuKtotal2);
        $Cluster2k2 = pusatCluster($miuX2Keluarantotal, $miuKtotal2);
        $Cluster3k1 = pusatCluster($miuX3Gajitotal, $miuKtotal3);
        $Cluster3k2 = pusatCluster($miuX3Keluarantotal, $miuKtotal3);
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
        <tr><th colspan='3' class='text-center'>Pusat Centroid</th>
        </tr>
        <tr><td>" . $Cluster1k1 . "</td>
        <td>" . $Cluster1k2 . "</td> 
        </tr>
        </tr>
        <tr><td>" . $Cluster2k1 . "</td>
        <td>" . $Cluster2k2 . "</td> 
        </tr>
        </tr>
        <tr><td>" . $Cluster3k1 . "</td>
        <td>" . $Cluster3k2 . "</td> 
        </tr>
        <table><br>";
        // ==================== Tabel X_V ==================================
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
        <tr>
            <th colspan='3' class='text-center'>XV</th>
        </tr>";
        $a = 0;
        while ($a < $jmlcentro) {
            //manghitung Nilai X_V
            $xvk1 = xv($nilai_gaji[$a], $nilai_keluaran[$a], $Cluster1k1, $Cluster1k2);
            $xvk2 = xv($nilai_gaji[$a], $nilai_keluaran[$a], $Cluster2k1, $Cluster2k2);
            $xvk3 = xv($nilai_gaji[$a], $nilai_keluaran[$a], $Cluster3k1, $Cluster3k2);
            echo "<tr>
            <td>" . $xvk1 . "</td>
                <td>" . $xvk2 . "</td>
                <td>" . $xvk3 . "</td> </tr>";
            $a++;
        }
        echo "
        <table><br>
        ";
        // ============================== Tabel L ==========================================
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
        <tr>
            <th colspan='3' class='text-center'>L</th>
            <th class='text-center'>Total L</th>
        </tr>";
        $a = 0;
        $jmlL = 0;
        while ($a < $jmlcentro) {
            $miuKuadrat1 = hitungKuadrat($centro1[$loop][$a], $pangkat);
            $miuKuadrat2 = hitungKuadrat($centro2[$loop][$a], $pangkat);
            $miuKuadrat3 = hitungKuadrat($centro3[$loop][$a], $pangkat);
            //manghitung Nilai X_V
            $xvk1 = xv($nilai_gaji[$a], $nilai_keluaran[$a], $Cluster1k1, $Cluster1k2);
            $xvk2 = xv($nilai_gaji[$a], $nilai_keluaran[$a], $Cluster2k1, $Cluster2k2);
            $xvk3 = xv($nilai_gaji[$a], $nilai_keluaran[$a], $Cluster3k1, $Cluster3k2);
            // Menghitung L
            $L1 = $xvk1 * $miuKuadrat1;
            $L2 = $xvk2 * $miuKuadrat2;
            $L3 = $xvk3 * $miuKuadrat3;
            //Total Tabel L
            $LTotal = $L1 + $L2 + $L3;
            echo "<tr>
            <td>" . $L1 . "</td>
                <td>" . $L2 . "</td>
                <td>" . $L3 . "</td>
                <td>" . $LTotal . "</td> 
                </tr>";
            $a++;
            $jmlL += $LTotal;
        }
        echo "
        <table><br>
        ";
        $abs = abs($jmlL - $fungsi_objective);
        echo "Fungsi Objective   " . $jmlL . "<br>";
        echo "Selisih Fungsi Objective " . $jmlL . "-" . $fungsi_objective . "<br>  " . $abs . "";
        $objective = $abs;
        $fungsi_objective = $jmlL;

        if ($objective <= $error) {
            $status = 'true';
        } else {
            $status = 'false';
        }
        if ($iterasi >= $maxIterasi) {
            $status = 'true';
        }
        // =============================================================================
        echo "<table align='center' width='400' border='1' cellpadding='3' cellspacing='1'>
        <tr>
            <th colspan='3' class='text-center'>LT</th>
            <th class='text-center'>Total LT</th>
        </tr>";
        $a = 0;
        while ($a < $jmlcentro) {
            $miuKuadrat1 = hitungKuadrat($centro1[$loop][$a], $pangkat);
            $miuKuadrat2 = hitungKuadrat($centro2[$loop][$a], $pangkat);
            $miuKuadrat3 = hitungKuadrat($centro3[$loop][$a], $pangkat);
            //manghitung Nilai X_V
            $xvk1 = xv($nilai_gaji[$a], $nilai_keluaran[$a], $Cluster1k1, $Cluster1k2);
            $xvk2 = xv($nilai_gaji[$a], $nilai_keluaran[$a], $Cluster2k1, $Cluster2k2);
            $xvk3 = xv($nilai_gaji[$a], $nilai_keluaran[$a], $Cluster3k1, $Cluster3k2);
            //Total Tabel LT
            $LT1 = pow($xvk1, (-1 / ($pangkat - 1)));
            $LT2 = pow($xvk2, (-1 / ($pangkat - 1)));
            $LT3 = pow($xvk3, (-1 / ($pangkat - 1)));
            //Total Tabel L
            $LTTotal = $LT1 + $LT2 + $LT3;
            echo "<tr>
            <td>" . $LT1 . "</td>
            <td>" . $LT2 . "</td>
            <td>" . $LT3 . "</td>
            <td>" . $LTTotal . "</td> 
            </tr>";
            // memasukkan data keangotaan baru
            $keangotaanB1 = $LT1 / $LTTotal;
            $keangotaanB2 = $LT2 / $LTTotal;
            $keangotaanB3 = $LT3 / $LTTotal;
            // var_dump($nilai_id[$a]);
            update_data($conn, $nilai_id[$a], $keangotaanB1, $keangotaanB2, $keangotaanB3);
            $a++;
        }
        echo "<table><br>";
        $loop += 1;
        $iterasi += 1;
        $centro1[$loop] = array();
        $centro1[$loop] = cek_nilaiCentroid($conn, 'c1');
        $centro2[$loop] = array();
        $centro2[$loop] = cek_nilaiCentroid($conn, 'c2');
        $centro3[$loop] = array();
        $centro3[$loop] = cek_nilaiCentroid($conn, 'c3');
    }
    echo "proses Berhasil dilakukan sebanyak $loop kali";
}

function cek_nilaiCentroid($conn, $field)
{
    //sql disticnt		
    $hasil = array();
    $sql = mysqli_query($conn, "SELECT ($field) FROM c_sementara");
    $a = 0;
    while ($row = mysqli_fetch_array($sql)) {
        $hasil[$a] = $row['0'];
        $a++;
    }
    return $hasil;
}

function cek_nilaiAtribut($conn, $field)
{
    //sql disticnt		
    $hasil = array();
    $sql = mysqli_query($conn, "SELECT ($field) FROM data");
    $a = 0;
    while ($row = mysqli_fetch_array($sql)) {
        $hasil[$a] = $row['0'];
        $a++;
    }
    return $hasil;
}

function format_decimal($value)
{
    return round($value, 6);
}

//Menghitung Nilai X Kuadrat
function hitungXkuadrat($miuKuadrat, $atribut)
{
    $jumlah = $miuKuadrat * $atribut;
    return $jumlah;
}

//Menghitung miuKuadrat
function hitungKuadrat($centro, $pangkat)
{
    $miuKuadrat = pow($centro, $pangkat);
    return $miuKuadrat;
}

//Menghitung Nilai X_V
function xv($gaji, $keluaran, $Cluster1k1, $Cluster1k2)
{
    $X_V1 = (($gaji - $Cluster1k1) * ($gaji - $Cluster1k1))
        + (($keluaran - $Cluster1k2) * ($keluaran - $Cluster1k2));
    return $X_V1;
}

// menghitung pusat Cluster
function pusatCluster($gaji, $total)
{
    $Cluster1k1 = $gaji / $total;
    return $Cluster1k1;
}

function update_data($conn, $id, $c1, $c2, $c3)
{
    mysqli_query($conn, "UPDATE c_sementara SET c1='$c1',c2='$c2',c3='$c3' WHERE iddata='$id'");
}






































///=============================================================================================
// $query = "SELECT * FROM data";
// $result = $conn->query($query);
// $index = 0;
// $objective = 0;
// $jmlL = 0;
// while ($data = mysqli_fetch_assoc($result)) {
//     extract($data);
//     //menghitung Nilai Miu
//     $miuKuadrat1 = hitungKuadrat($centro1[$index]);
//     $miuKuadrat2 = hitungKuadrat($centro2[$index]);
//     $miuKuadrat3 = hitungKuadrat($centro3[$index]);
//     //Mengambil Nilai Centroid
//     $hasil = cariData($conn, $centro1, $centro2, $centro3);
//     $c1k1 = $hasil['C1K1'];
//     $c1k2 = $hasil['C1K2'];
//     $c2k1 = $hasil['C2K1'];
//     $c2k2 = $hasil['C2K2'];
//     $c3k1 = $hasil['C3K1'];
//     $c3k2 = $hasil['C3K2'];

//     //manghitung Nilai X_V
//     $xvk1 = xv($gaji, $keluaran, $c1k1, $c1k2);
//     $xvk2 = xv($gaji, $keluaran, $c2k1, $c2k2);
//     $xvk3 = xv($gaji, $keluaran, $c3k1, $c3k2);
//     // Menghitung L
//     $L1 = $xvk1 * $miuKuadrat1;
//     $L2 = $xvk2 * $miuKuadrat2;
//     $L3 = $xvk3 * $miuKuadrat3;
//     //Total Tabel L
//     $LTotal = $L1 + $L2 + $L3;
//     //Total Tabel LT
//     $LT1 = pow($xvk1, (-1 / (2 - 1)));
//     $LT2 = pow($xvk2, (-1 / (2 - 1)));
//     $LT3 = pow($xvk3, (-1 / (2 - 1)));

//     $jmlL += format_decimal($LTotal);
//     $index += 1;
// }
// //Menghitung Nilai ABS
// $abs = format_decimal(abs($jmlL - $objective));
// // var_dump($abs);



//Menghitung Nilai Cluster
// function cariData($conn, $centro1, $centro2, $centro3)
// {
//     $query = "SELECT * FROM data";
//     $result = $conn->query($query);
//     $index = 0;
//     //membuat variable miu total kuadrat
//     $miuKtotal1 = 0;
//     $miuKtotal2 = 0;
//     $miuKtotal3 = 0;
//     //membuat variable miu X1 2 3 kuadrat
//     $miuX1Gajitotal = 0;
//     $miuX2Gajitotal = 0;
//     $miuX3Gajitotal = 0;
//     $miuX1Keluarantotal = 0;
//     $miuX2Keluarantotal = 0;
//     $miuX3Keluarantotal = 0;
//     while ($data = mysqli_fetch_assoc($result)) {
//         extract($data);
//         //Menghitung miu Kuadrat
//         $miuKuadrat1 = hitungKuadrat($centro1[$index], $pangkat);
//         $miuKuadrat2 = hitungKuadrat($centro2[$index], $pangkat);
//         $miuKuadrat3 = hitungKuadrat($centro3[$index], $pangkat);

//         //Menghitung Miu Kuadrat 1
//         $miuX1Gaji = hitungXkuadrat($miuKuadrat1, $gaji);
//         $miuX1keluaran = hitungXkuadrat($miuKuadrat1, $keluaran);
//         //Menghitung Miu Kuadrat 2
//         $miuX2Gaji = hitungXkuadrat($miuKuadrat2, $gaji);
//         $miuX2keluaran = hitungXkuadrat($miuKuadrat2, $keluaran);
//         //Menghitung Miu Kuadrat 3
//         $miuX3Gaji = hitungXkuadrat($miuKuadrat3, $gaji);
//         $miuX3keluaran = hitungXkuadrat($miuKuadrat3, $keluaran);

//         //Menghitung total Miu Kuadrat 
//         $miuKtotal1 += $miuKuadrat1;
//         $miuKtotal2 += $miuKuadrat2;
//         $miuKtotal3 += $miuKuadrat3;
//         //menghitung miu kuadrat X1
//         $miuX1Gajitotal += $miuX1Gaji;
//         $miuX1Keluarantotal += $miuX1keluaran;
//         //menghitung miu kuadrat X2
//         $miuX2Gajitotal += $miuX2Gaji;
//         $miuX2Keluarantotal += $miuX2keluaran;
//         //menghitung miu kuadrat X3
//         $miuX3Gajitotal += $miuX3Gaji;
//         $miuX3Keluarantotal += $miuX3keluaran;
//         // $xv = xv($gaji, $keluaran, $Cluster1k1, $Cluster1k2);
//         $index += 1;
//     }
//     $Cluster1k1 = pusatCluster($miuX1Gajitotal, $miuKtotal1);
//     $Cluster1k2 = pusatCluster($miuX1Keluarantotal, $miuKtotal1);
//     $Cluster2k1 = pusatCluster($miuX2Gajitotal, $miuKtotal2);
//     $Cluster2k2 = pusatCluster($miuX2Keluarantotal, $miuKtotal2);
//     $Cluster3k1 = pusatCluster($miuX3Gajitotal, $miuKtotal3);
//     $Cluster3k2 = pusatCluster($miuX3Keluarantotal, $miuKtotal3);
//     return array(
//         'C1K1' => $Cluster1k1, 'C1K2' => $Cluster1k2,
//         'C2K1' => $Cluster2k1, 'C2K2' => $Cluster2k2,
//         'C3K1' => $Cluster3k1, 'C3K2' => $Cluster3k2,
//     );
// }
