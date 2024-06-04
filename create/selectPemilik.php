<?php
include '../connect.php';
$db = new database();

// Memuat daftar pemilik dari database
$sql = "SELECT id_pemilik, nama_pemilik FROM Pemilik";
$result = $db->sqlquery($sql);

// Memeriksa tindakan yang akan dilakukan (menambah hewan atau perawatan)
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Memeriksa apakah form telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pemilik = $_POST['id_pemilik'];
    if ($action == 'add_hewan') {
        header("Location: createHewan.php?id_pemilik=" . $id_pemilik);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Pemilik</title>
    <link rel="stylesheet" href="../css/second.css">
</head>
<body>
    <div class="wrapper">
        <h1>Pilih Pemilik</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?action=<?php echo $action; ?>">
            <div class="jenisK">
                <select id="id_pemilik" name="id_pemilik">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_pemilik'] . "'>" . $row['nama_pemilik'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <img src="../assets/dropdown-arrow.png" class="dropdown-arrow">
            </div>
            <button value="Submit" class="btnStyle">Submit</button>
        </form>
    </div>
</body>
</html>
