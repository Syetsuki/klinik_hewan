<?php
include 'connect.php';
$db = new database();

if (isset($_GET['id_perawatan'])) {
    $id_perawatan = $_GET['id_perawatan'];

    // Mendapatkan data perawatan yang akan diedit
    $sql_perawatan = "SELECT * FROM Perawatan WHERE id_perawatan = $id_perawatan";
    $result_perawatan = $db->fetchdata($sql_perawatan);
    $perawatan = $result_perawatan[0];

    // Mendapatkan daftar dokter
    $sql_dokter = "SELECT id_dokter, nama_dokter FROM DokterHewan";
    $result_dokter = $db->fetchdata($sql_dokter);

    // Mendapatkan daftar obat
    $sql_obat = "SELECT id_obat, nama_obat FROM Obat";
    $result_obat = $db->fetchdata($sql_obat);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Mengambil data dari form
        $id_dokter = $_POST['id_dokter'];
        $tanggal_perawatan = $_POST['tanggal_perawatan'];
        $diagnosa = $_POST['diagnosa'];
        $tindakan = $_POST['tindakan'];
        $id_obat = $_POST['id_obat'];
        $biaya = $_POST['biaya'];

        // Menjalankan prosedur untuk mengupdate data perawatan
        $sql = "CALL edit_perawatan($id_perawatan, $id_dokter, '$tanggal_perawatan', '$diagnosa', '$tindakan', $id_obat, $biaya)";    
        if ($db->sqlquery($sql)) {
            header("Location: indexwjs.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($db->getconnection());
        }
    }
} else {
    echo "ID perawatan tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Perawatan</title>
    <link rel="stylesheet" href="css/second.css">
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_perawatan=' . $id_perawatan; ?>">
            <h1>Edit Data</h1><br>
            <div class="jenisK">
                <p>Dokter :</p>
                <select id="id_dokter" name="id_dokter">
                    <?php
                    foreach ($result_dokter as $row) {
                        $selected = $row['id_dokter'] == $perawatan['id_dokter'] ? 'selected' : '';
                        echo "<option value='" . $row['id_dokter'] . "' $selected>" . $row['nama_dokter'] . "</option>";
                    }
                    ?>
                </select>
                <img src="assets/dropdown-arrow.png" class="dropdown-arrow">
            </div>
            <div class="input-box tanggal-lahir">
                <p>Tanggal Perawatan :</p>
                <input type="date" id="tanggal_perawatan" name="tanggal_perawatan" value="<?php echo $perawatan['tanggal_perawatan']; ?>">
            </div>
            <div class="input-box">
                <input type="text" id="diagnosa" name="diagnosa" value="<?php echo $perawatan['diagnosa']; ?>" placeholder="Diagnosa">
            </div>
            <div class="input-box">
                <input type="text" id="tindakan" name="tindakan" value="<?php echo $perawatan['tindakan']; ?>" placeholder="Tindakan">
            </div>
            <div class="jenisK">
                <p>Obat :</p>
                <select id="id_obat" name="id_obat">
                    <?php
                    foreach ($result_obat as $row) {
                        $selected = $row['id_obat'] == $perawatan['id_obat'] ? 'selected' : '';
                        echo "<option value='" . $row['id_obat'] . "' $selected>" . $row['nama_obat'] . "</option>";
                    }
                    ?>
                </select>
                <img src="assets/dropdown-arrow.png" class="dropdown-arrow">
            </div>
            <div class="input-box">
                <input type="number" id="biaya" name="biaya" value="<?php echo $perawatan['biaya']; ?>" placeholder="Biaya">
            </div>
            
            <button value="Submit" class="btnStyle">Update</button>
        </form>
    </div>
</body>
</html>
