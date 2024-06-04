<?php
include '../connect.php';
$db = new database();

// Mengambil id_pemilik dari URL jika ada
if (isset($_GET['id_pemilik'])) {
    $id_pemilik = $_GET['id_pemilik'];
} else {
    // Jika tidak ada ID pemilik yang diterima, beri nilai default (atau sesuaikan sesuai kebutuhan Anda)
    $id_pemilik = 0;
}

// Memeriksa apakah form telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $nama_hewan = $_POST['nama_hewan'];
    $jenis_hewan = $_POST['jenis_hewan'];
    $ras_hewan = $_POST['ras_hewan'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $kelamin = $_POST['kelamin'];
    $id_pemilik = $_POST['id_pemilik'];

    // Menjalankan prosedur untuk menambahkan data hewan
    $sql = "CALL tambah_hewan('$nama_hewan', '$jenis_hewan', '$ras_hewan', '$tanggal_lahir', '$kelamin', $id_pemilik)";
    if ($db->sqlquery($sql)) {
        $sql_last_id = "SELECT id_hewan FROM hewan ORDER BY id_hewan DESC LIMIT 1";
        $result_last_id = $db->sqlquery($sql_last_id);
        $row = $result_last_id->fetch_assoc();
        $id_hewan = $row['id_hewan']; 
        header("Location: createPerawatan.php?id_hewan=" . $id_hewan);
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
    <title>Tambah Data Hewan</title>
    <link rel="stylesheet" href="../css/second.css">
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h1>Hewan</h1>
            <div class="input-box">
                <input type="text" id="nama_hewan" name="nama_hewan" placeholder="Nama Hewan" required>
                <img src="../assets/namaHewan.png">
            </div>
            <div class="input-box">
                <input type="text" id="jenis_hewan" name="jenis_hewan" placeholder="Jenis Hewan" required>
                <img src="../assets/jenisHewan.png">
            </div>
            <div class="input-box">
                <input type="text" id="ras_hewan" name="ras_hewan" placeholder="Ras Hewan" required>
                <img src="../assets/rasHewan.png">
            </div>
            <div class="input-box tanggal-lahir">
                <p>Tanggal Lahir:</p>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir" required>
                
            </div>
            <div class="jenisK">
                <p>Jenis Kelamin:</p>
                <select id="kelamin" name="kelamin" required>
                    <option value="Jantan">Jantan</option>
                    <option value="Betina">Betina</option>
                </select>
                <img src="../assets/dropdown-arrow.png" class="dropdown-arrow">
            </div>
            <div class="input-box">
                <input type="text" id="id_pemilik" name="id_pemilik" placeholder="ID Pemilik" value="<?php echo $id_pemilik; ?>" readonly>
            </div>
            <button value="Submit" class="btnStyle">Submit</button>
        </form>
    </div>
    
</body>
</html>
