<?php
include "koneksi.php";

if (!isset($_POST['proses'])) : ?>
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <form action="" method="post">
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-4 col-form-label">Cluster</label>
                    <div class="col-sm-8">
                        <input type="text" name="cluster" class="form-control" value="3" id="inputPassword" placeholder="Cluster">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-4 col-form-label">Max Iterasi</label>
                    <div class="col-sm-8">
                        <input type="text" name="maxiterasi" class="form-control" value="100" id="inputPassword" placeholder="Max Iterasi">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-4 col-form-label">Pangkat</label>
                    <div class="col-sm-8">
                        <input type="text" name="pembobot" class="form-control" value="2" id="inputPassword" placeholder="Pangkat">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-4 col-form-label">error</label>
                    <div class="col-sm-8">
                        <input type="text" name="error" value="0.000001" class="form-control" id="inputPassword" placeholder="error">
                    </div>
                </div>
                <button type="submit" name="proses" class="float-right btn btn-success">Proses CMEANS</button>
            </form>
        </div>
    </div>
<?php
elseif (isset($_POST['proses'])) :
    $keluarga = array();

    $querykeluarga = mysqli_query($conn, "SELECT * FROM data_keluarga ORDER BY id_keluarga");
    $i = 0;
    while ($datakeluarga = mysqli_fetch_array($querykeluarga)) {
        $keluarga[$i] = $datakeluarga['nama_keluarga'];
        $i++;
    }
    $keluargaid = array();
    $querykeluarga1 = mysqli_query($conn, "SELECT * FROM data_keluarga ORDER BY id_keluarga");
    $i = 0;
    while ($datakeluargaid = mysqli_fetch_array($querykeluarga1)) {
        $keluargaid[$i] = $datakeluargaid['id_keluarga'];
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

    // Untuk Melakukan Perhitungan Manual
    $datacoba = array(
        array(80, 6, 1, 6, 1),
        array(72, 6, 1, 6, 1),
        array(46, 6, 1, 6, 1),
        array(30, 8, 3, 6, 1),
        array(40, 2, 1, 6, 1),
        array(36, 6, 3, 6, 1),
        array(35, 6, 3, 6, 1),
        array(34, 3, 6, 2, 4),
        array(42, 3, 6, 6, 1),
        array(150, 8, 3, 6, 1)
    );
    $data = $datacoba;


    $data = $keluargakriteria;

    mysqli_query($conn, "TRUNCATE data_hasil_cluster");
    function tampiltabel($arr, $title)
    {
        echo '<div class="col-md-6">';
        echo '<div class="table-responsive">';
        echo "<table class='table table-bordered'  id='dataTable' width='100%' cellspacing='0'>";
        echo '<thead>';
        echo '<tr bgcolor="green">';
        echo '<th colspan="100" style="color:white;" class="text-center">';
        echo $title;
        echo '</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        for ($i = 0; $i < count($arr); $i++) {
            echo '<tr>';
            for ($j = 0; $j < count($arr[$i]); $j++) {
                echo '<td>' . $arr[$i][$j] . '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
    }
    function tampiltabelkolom($arr, $title)
    {
        echo '<div class="col-md-6">';
        echo '<div class="table-responsive">';
        echo "<table class='table table-bordered'  id='dataTable' width='100%' cellspacing='0'>";
        echo '<thead>';
        echo '<tr bgcolor="green">';
        echo '<th colspan="100" style="color:white;" class="text-center">';
        echo $title;
        echo '</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        for ($i = 0; $i < count($arr); $i++) {
            echo '<tr>';
            for ($j = 0; $j < count($arr[$i]); $j++) {
                echo '<td>' . $arr[$i][$j] . '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
    }

    function tampiltabel_cluster($arr)
    {
        global $conn;
        echo '<table class="table table-bordered">';
        echo '<tr style="color:white;" bgcolor="green">';
        echo '<td><b>No</b></td>';
        // include 'koneksi.php';
        $sql = mysqli_query($conn, "SELECT * FROM data_kriteria");
        while ($data = mysqli_fetch_array($sql)) {
            echo "<td><b>" . $data["nama_kriteria"] . "</b></td>";
        }
        echo '</tr>';
        for ($i = 0; $i < count($arr); $i++) {
            $cluster = $i + 1;
            echo '<tr>';
            echo '<td>' . $cluster . '</td>';
            for ($j = 0; $j < count($arr[$i]); $j++) {
                echo '<td>' . $arr[$i][$j] . '</td>';
            }
            echo '<tr>';
        }
        echo '</table>';
    }

    function tampilbaris($arr, $title)
    {
        // echo '<div class="col-md-6">';
        echo "<table class='table table-bordered'>";

        echo '<tr style="color:white;" bgcolor="green">';
        echo '<th colspan="100" class="text-center">';
        echo $title;
        echo '</th>';
        echo '</tr>';
        echo '<tr>';
        for ($i = 0; $i < count($arr); $i++) {
            echo '<td>' . format_decimal($arr[$i]) . '</td>';
        }
        echo '</tr>';
        echo '</table>';
        // echo '</div">';
    }

    function tampilkolom($arr, $title)
    {
        echo '<div class="col-md-6">';
        echo "<table class='table table-bordered'>";
        echo '<tr style="color:white;" bgcolor="green">';
        echo '<th colspan="100" class="text-center">';
        echo $title;
        echo '</th>';
        echo '</tr>';
        for ($i = 0; $i < count($arr); $i++) {
            echo '<tr>';
            echo '<td>' . format_decimal($arr[$i]) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div">';
    }


    $jmlCluster = $_POST['cluster'];
    $jmlData;
    $jmlVariabel;
    $maksIterasi = $_POST['maxiterasi'];
    $pembobot = $_POST['pembobot'];
    $epsilon = $_POST['error'];
    $selisih_fungsi_objective = 0;
    $fungsi_objective = 0;
    $jmlVariable = count($data[0]);
    $jmlData = count($data);
    // var_dump($jmlData);

    function format_decimal($value)
    {
        return round($value, 2);
    }
    $pusatCluster = array(array());

    for ($d = 0; $d < $jmlData; $d++) {
        $jml = 0;
        for ($c = 0; $c < $jmlCluster; $c++) {
            $keangotaan[$d][$c] = rand(0, 9);
            $jml += $keangotaan[$d][$c];
        }
        for ($c = 0; $c < $jmlCluster; $c++) {
            $keangotaan[$d][$c] = $keangotaan[$d][$c] / $jml;
        }
        $tot = 0;
        for ($c = 0; $c < ($jmlCluster - 1); $c++) {
            $tot = $tot + $keangotaan[$d][$c];
        }
        $keangotaan[$d][$jmlCluster - 1] = 1 - $tot;
    }
    if ($jmlCluster == 3 and $jmlData == 10) {
        $keangotaan = array(
            array(0.3, 0.3, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.8, 0.1, 0.1),
            array(0.5, 0.2, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.2, 0.1, 0.7),
            array(0.3, 0.4, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.5, 0.1, 0.4),
            array(0.6, 0.2, 0.2)
        );
    }
    if ($jmlCluster == 3 and $jmlData == 100) {
        $keangotaan = array(
            array(0.3, 0.3, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.8, 0.1, 0.1),
            array(0.5, 0.2, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.2, 0.1, 0.7),
            array(0.3, 0.4, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.5, 0.1, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.3, 0.3, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.8, 0.1, 0.1),
            array(0.8, 0.1, 0.1),
            array(0.5, 0.2, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.2, 0.1, 0.7),
            array(0.3, 0.4, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.5, 0.1, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.3, 0.3, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.8, 0.1, 0.1),
            array(0.5, 0.2, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.2, 0.1, 0.7),
            array(0.3, 0.4, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.5, 0.1, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.3, 0.3, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.8, 0.1, 0.1),
            array(0.5, 0.2, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.2, 0.1, 0.7),
            array(0.3, 0.4, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.5, 0.1, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.3, 0.3, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.8, 0.1, 0.1),
            array(0.5, 0.2, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.2, 0.1, 0.7),
            array(0.3, 0.4, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.5, 0.1, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.3, 0.3, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.8, 0.1, 0.1),
            array(0.5, 0.2, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.2, 0.1, 0.7),
            array(0.3, 0.4, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.5, 0.1, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.3, 0.3, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.8, 0.1, 0.1),
            array(0.5, 0.2, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.2, 0.1, 0.7),
            array(0.3, 0.4, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.5, 0.1, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.3, 0.3, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.8, 0.1, 0.1),
            array(0.5, 0.2, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.2, 0.1, 0.7),
            array(0.3, 0.4, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.5, 0.1, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.3, 0.3, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.8, 0.1, 0.1),
            array(0.5, 0.2, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.2, 0.1, 0.7),
            array(0.3, 0.4, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.5, 0.1, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.3, 0.3, 0.4),
            array(0.3, 0.5, 0.2),
            array(0.8, 0.1, 0.1),
            array(0.5, 0.2, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.2, 0.1, 0.7),
            array(0.3, 0.4, 0.3),
            array(0.5, 0.1, 0.4),
            array(0.6, 0.2, 0.2)
        );
    }

    $miu_kuadrat = array(array());
    $miu_kuadrat_x = array(array(array()));
    $total_miu_kuadrat = array();
    $total_miu_kuadrat_x = array(array());
    $pusatCluster = array(array());
    $X_V = array(array());
    $L = array(array());
    $total_L = array();
    $LT = array(array());
    $total_LT = array();

    $ketemu = false;

    for ($iterasi = 0; $iterasi < $maksIterasi; $iterasi++) {
        echo ("<br/><br/><h3 class='text-center'>-- ITERASI : " . ($iterasi + 1) . " --</h3><br/><br/>");

        for ($i = 0; $i < $jmlData; $i++) {
            $h = 0;
            for ($c = 0; $c < $jmlCluster; $c++) {
                $h = $keangotaan[$i][$c];
            }
        }
        echo "<div class='row'>";
        // echo "Keangotaan:";
        tampiltabel($keangotaan, "Keanggotaan");

        $miu_kuadrat = array(array(array()));
        $total_miu_kuadrat = array(array());

        for ($c = 0; $c < $jmlCluster; $c++) {
            $total_miu_kuadrat[$c] = 0;
            for ($d = 0; $d < $jmlData; $d++) {
                $miu_kuadrat[$d][$c] = pow($keangotaan[$d][$c], $pembobot);
                $total_miu_kuadrat[$c] = $total_miu_kuadrat[$c] + $miu_kuadrat[$d][$c];
            }
        }
        // var_dump($miu_kuadrat);

        // echo "Miu Kuadrat :";
        tampiltabelkolom($miu_kuadrat, "Miu Kuadrat");
        // echo " Total Miu Kuadrat :";
        tampilbaris($total_miu_kuadrat, "Total Miu Kuadrat");


        $miu_kuadrat_x = array(array(array()));
        $total_miu_kuadrat_x = array(array());

        for ($c = 0; $c < $jmlCluster; $c++) {
            for ($d = 0; $d < $jmlData; $d++) {
                for ($v = 0; $v < $jmlVariable; $v++) {
                    $miu_kuadrat_x[$c][$d][$v] = $miu_kuadrat[$d][$c] * $data[$d][$v];
                    $total_miu_kuadrat_x[$c][$v] = 0;
                }
            }
            // echo "Miu Kuadrat X " . ($c + 1) . ":<br/><br/>";
            tampiltabel($miu_kuadrat_x[$c], "Miu Kuadrat " . ($c + 1) . "");
            // echo "<br/><br/>";
        }
        // print_r($miu_kuadrat_x);

        for ($c = 0; $c < $jmlCluster; $c++) {
            for ($d = 0; $d < $jmlData; $d++) {
                for ($v = 0; $v < $jmlVariable; $v++) {
                    $total_miu_kuadrat_x[$c][$v] = @$total_miu_kuadrat_x[$c][$v] + $miu_kuadrat_x[$c][$d][$v];
                }
            }
        }
        // echo " Total Miu Kuadrat X :<br/><br/>";
        tampiltabel($total_miu_kuadrat_x, "Niu Kuadrat X total");
        // echo "<br/><br/>";

        $pusatCluster = array(array());

        for ($c = 0; $c < $jmlCluster; $c++) {
            for ($v = 0; $v < $jmlVariable; $v++) {
                $pusat_cluster[$c][$v] = @$total_miu_kuadrat_x[$c][$v] / $total_miu_kuadrat[$c];
            }
        }

        // echo " Pusat Cluster :<br/><br/>";
        tampiltabel($pusat_cluster, "pusat Cluster");

        $X_V = array(array());
        $L = array(array());
        $total_L = array();

        for ($c = 0; $c < $jmlCluster; $c++) {
            for ($d = 0; $d < $jmlData; $d++) {
                $X_V[$d][$c] = 0;
                for ($v = 0; $v < $jmlVariable; $v++) {
                    $X_V[$d][$c] = $X_V[$d][$c] + (($data[$d][$v] - $pusat_cluster[$c][$v]) * ($data[$d][$v] - $pusat_cluster[$c][$v]));
                }
            }
        }
        // echo " X_V :<br/><br/>";
        tampiltabel($X_V, "X_V");
        echo "</div>";
        $fungsi_objective_akhir = 0;
        $total_L = array();
        for ($d = 0; $d < $jmlData; $d++) {
            $total_L[$d] = 0;
            for ($c = 0; $c < $jmlCluster; $c++) {
                $L[$d][$c] = @$X_V[$d][$c] * $miu_kuadrat[$d][$c];
                $total_L[$d] = @$total_L[$d] + $L[$d][$c];
                $fungsi_objective_akhir = @$fungsi_objective_akhir + $L[$d][$c];
            }
        }
        // echo " L :<br/><br/>";
        echo "<div class='row'>";
        tampiltabel($L, "L");
        for ($d = 0; $d < $jmlData; $d++) {
            $total_LT[$d] = 0;
            for ($c = 0; $c < $jmlCluster; $c++) {
                $LT[$d][$c] = @pow($X_V[$d][$c], (-1 / ($pembobot - 1)));
                $total_LT[$d] = @$total_LT[$d] + $LT[$d][$c];
            }
        }
        // echo " LT :<br/><br/>";
        tampiltabel($LT, "LT");
        echo "</div>";
        echo "<div class='row'>";
        tampilbaris($total_L, "Total L");
        tampilbaris($total_LT, "Total LT");
        echo "</div>";
        $selisih_fungsi_objective = @abs($fungsi_objective_akhir - $fungsi_objective);

        echo "Fungsi objectif : " . $fungsi_objective_akhir . "";
        echo "<br/><br/>";
        echo "Selisih Fungsi objectif : (" . $fungsi_objective_akhir . "-" . $fungsi_objective . ") " . $selisih_fungsi_objective . "";
        echo "<br/><br/>";
        $fungsi_objective = $fungsi_objective_akhir;
        for ($d = 0; $d < $jmlData; $d++) {
            for ($c = 0; $c < $jmlCluster; $c++) {
                $keangotaan[$d][$c] = $LT[$d][$c] / $total_LT[$d];
            }
        }
        echo "<div class='row'>";
        tampiltabel($keangotaan, "Keanggotaan Baru");
        echo "</div>";
        if ($selisih_fungsi_objective <= $epsilon) {
            $ketemu = true;
            break;
        } else {
            $ketemu = false;
        }
    }
?>
<?php
    if ($ketemu == true) {
        echo "<br/>";
        echo "<br/>";
        echo "Hasil di dapatkan Objectifit Akhir";
        echo "<br/>";
        echo "<br/>";
        echo "Berhenti pada Iterasi Ke = " . ($iterasi + 1) . "<br/><br/>";
        echo "<b>Nilai Centroid Akhir<b>";
        tampiltabel_cluster($pusat_cluster);
        echo "<br/><br/>";
        $X_V = array(array());
        $L = array(array());
        $total_L = array();
        for ($c = 0; $c < $jmlCluster; $c++) {
            for ($d = 0; $d < $jmlData; $d++) {
                $X_V[$d][$c] = 0;
                for ($v = 0; $v < $jmlVariable; $v++) {
                    $X_V[$d][$c] = $X_V[$d][$c] + (($data[$d][$v] - $pusat_cluster[$c][$v]) * ($data[$d][$v] - $pusat_cluster[$c][$v]));
                }
            }
        }
        echo "Keanggotaan Cluster Akhir";
        echo "<br/>";
        echo "<br/>";
        echo "<table class='table table-bordered'>";
        echo "<tr>";
        echo "<th>Nama Keluarga</th>";
        echo "<th colspan='4'>Keanggotaan</th>";
        echo "</tr>";
        for ($d = 0; $d < $jmlData; $d++) {
            $terkecil = 0;
            $anggota[$d] = '';
            for ($c = 0; $c < $jmlCluster; $c++) {
                if ($c == 0) {
                    $terkecil = $keangotaan[$d][$c];
                    $anggota[$d] = 'Cluster' . ($c + 1);
                } else {
                    if ($terkecil < $keangotaan[$d][$c]) {
                        $terkecil = $keangotaan[$d][$c];
                        $anggota[$d] = 'Cluster' . ($c + 1);
                    }
                }
            }
            echo "<tr>";
            echo "<td>" . $keluarga[$d] . "<td>";
            echo "<td>" . $keluargaid[$d] . "<td>";
            echo "<td colspan='4'>" . $anggota[$d] . "<td>";
            echo "</tr>";
            mysqli_query($conn, "INSERT INTO data_hasil_cluster VALUES('','$keluargaid[$d]','$anggota[$d]')");
        }
        echo "</table>";
    } else {
        echo "Perhitunggan Belum Mendapatkan Hasil";
    }
endif;
?>