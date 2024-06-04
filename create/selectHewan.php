<?php
include '../connect.php';
$db = new database();

// Memuat daftar hewan dari database
$sql = "SELECT id_hewan, nama_hewan FROM Hewan";
$result = $db->sqlquery($sql);

// Memeriksa tindakan yang akan dilakukan (menambah perawatan)
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Memeriksa apakah form telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_hewan = $_POST['id_hewan'];
    if ($action == 'add_perawatan') {
        header("Location: createPerawatan.php?id_hewan=" . $id_hewan);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Hewan</title>
    <link rel="stylesheet" href="../css/second.css">
</head>
<body>
    <div class="wrapper">
        <h1>Pilih Hewan</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?action=<?php echo $action; ?>">
            <div class="jenisK">
                <select id="id_hewan" name="id_hewan">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_hewan'] . "'>" . $row['nama_hewan'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <img src="../assets/dropdown-arrow.png" class="dropdown-arrow">
            </div>
            <br>
            <button value="Submit" class="btnStyle">Submit</button>
        </form>
    </div>
</body>
</html>
