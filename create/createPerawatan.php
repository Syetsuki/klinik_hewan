<?php
include '../connect.php';
$db = new database();

// Memuat daftar hewan dari database
$sql_hewan = "SELECT id_hewan, nama_hewan FROM Hewan";
$result_hewan = $db->sqlquery($sql_hewan);

if (isset($_GET['id_hewan'])) {
    $id_hewan = $_GET['id_hewan'];
} else {
    // Jika tidak ada ID hewan yang diterima, beri nilai default (atau sesuaikan sesuai kebutuhan Anda)
    $id_hewan = 0;
}

// Memuat daftar dokter dari database
$sql_dokter = "SELECT id_dokter, nama_dokter FROM DokterHewan";
$result_dokter = $db->sqlquery($sql_dokter);

// Memuat daftar obat dari database
$sql_obat = "SELECT id_obat, nama_obat FROM Obat"; 
$result_obat = $db->sqlquery($sql_obat);

// Memeriksa apakah form telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $id_hewan = $_POST['id_hewan'];
    $id_dokter = $_POST['id_dokter'];
    $tanggal_perawatan = $_POST['tanggal_perawatan'];
    $diagnosa = $_POST['diagnosa'];
    $tindakan = $_POST['tindakan'];
    $biaya = $_POST['biaya'];
    $id_obat = $_POST['id_obat'];

    // Menjalankan prosedur untuk menambahkan data perawatan
    $sql = "CALL tambah_perawatan($id_hewan, $id_dokter, '$tanggal_perawatan', '$diagnosa', '$tindakan', $id_obat, $biaya)";
    if ($db->sqlquery($sql)) {
        echo "Data perawatan berhasil ditambahkan!";
        header("Location: ../indexwjs.php");
    } else {
        echo "Error: " . $db->getconnection()->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Perawatan</title>
    <link rel="stylesheet" href="../css/second.css">
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h1>Perawatan</h1>
            <div class="input-box">
                <input type="number" id="id_hewan" name="id_hewan" value="<?php echo $id_hewan; ?>" readonly>
            </div>
            <div class="jenisK">
                <p>Dokter :</p>
                <select id="id_dokter" name="id_dokter">
                    <?php
                    if ($result_dokter->num_rows > 0) {
                        while ($row = $result_dokter->fetch_assoc()) {
                            echo "<option value='" . $row['id_dokter'] . "'>" . $row['nama_dokter'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <img src="../assets/dropdown-arrow.png" class="dropdown-arrow">
            </div>
            <div class="input-box tanggal-lahir">
                <p>Tanggal Perawatan :</p>
                <input type="date" id="tanggal_perawatan" name="tanggal_perawatan">
            </div>
            <div class="input-box">
                <input type="text" id="diagnosa" name="diagnosa" placeholder="Diagnosa">
            </div>
            <div class="input-box">
                <input type="text" id="tindakan" name="tindakan" placeholder="Tindakan">
            </div>
            <div class="jenisK">
                <p>Obat :</p>
                <select id="id_obat" name="id_obat">
                    <?php
                    if ($result_obat->num_rows > 0) {
                        while ($row = $result_obat->fetch_assoc()) {
                            echo "<option value='" . $row['id_obat'] . "'>" . $row['nama_obat'] . "</option>";
                        }   
                    }
                    ?>
                </select>
                    <img src="../assets/dropdown-arrow.png" class="dropdown-arrow">
            </div>
            <div class="input-box">
                <input type="number" id="biaya" name="biaya" placeholder="Biaya">
            </div>
            <button value="Submit" class="btnStyle">Submit</button>
        </form>
    </div>
    
    
</body>
</html>
