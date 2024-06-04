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
        $sql = "UPDATE Perawatan 
                SET id_dokter = $id_dokter, 
                    tanggal_perawatan = '$tanggal_perawatan', 
                    diagnosa = '$diagnosa', 
                    tindakan = '$tindakan', 
                    id_obat = $id_obat, 
                    biaya = $biaya 
                WHERE id_perawatan = $id_perawatan";

        if ($db->sqlquery($sql)) {
            echo "Data perawatan berhasil diperbarui!";
            header("Location: index.php");
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
</head>
<body>
    <h1>Edit Data Perawatan</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_perawatan=' . $id_perawatan; ?>">
        <label for="id_dokter">Dokter:</label><br>
        <select id="id_dokter" name="id_dokter">
            <?php
            foreach ($result_dokter as $row) {
                $selected = $row['id_dokter'] == $perawatan['id_dokter'] ? 'selected' : '';
                echo "<option value='" . $row['id_dokter'] . "' $selected>" . $row['nama_dokter'] . "</option>";
            }
            ?>
        </select><br>

        <label for="tanggal_perawatan">Tanggal Perawatan:</label><br>
        <input type="date" id="tanggal_perawatan" name="tanggal_perawatan" value="<?php echo $perawatan['tanggal_perawatan']; ?>"><br>

        <label for="diagnosa">Diagnosa:</label><br>
        <input type="text" id="diagnosa" name="diagnosa" value="<?php echo $perawatan['diagnosa']; ?>"><br>

        <label for="tindakan">Tindakan:</label><br>
        <input type="text" id="tindakan" name="tindakan" value="<?php echo $perawatan['tindakan']; ?>"><br>

        <label for="id_obat">Obat:</label><br>
        <select id="id_obat" name="id_obat">
            <?php
            foreach ($result_obat as $row) {
                $selected = $row['id_obat'] == $perawatan['id_obat'] ? 'selected' : '';
                echo "<option value='" . $row['id_obat'] . "' $selected>" . $row['nama_obat'] . "</option>";
            }
            ?>
        </select><br>

        <label for="biaya">Biaya:</label><br>
        <input type="number" id="biaya" name="biaya" value="<?php echo $perawatan['biaya']; ?>"><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
