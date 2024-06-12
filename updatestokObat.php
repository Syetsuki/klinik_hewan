<?php
    include 'connect.php';
    $db = new database();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $obat_updates = $_POST['obat'];
        foreach ($obat_updates as $id_obat => $stok_baru) {
            $sql = "UPDATE Obat SET stok = $stok_baru WHERE id_obat = $id_obat";
            $db->sqlquery($sql);
        }
        header("Location: indexwjs.php");
        exit();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Stok Obat</title>
    <link rel="stylesheet" href="css/obat.css">
</head>
<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Stok Obat</h1>
            <?php
            $obat = $db->fetchdata("SELECT id_obat, nama_obat, stok FROM Obat");
            foreach ($obat as $data) {
                ?>
                <div class="input-box">
                    <label for='obat_<?php echo $data['id_obat']; ?>'><?php echo $data['nama_obat']; ?>:</label>
                    <input type='number' id='obat_<?php echo $data['id_obat']; ?>' name='obat[<?php echo $data['id_obat']; ?>]' value='<?php echo $data['stok']; ?>' min='0'><br>
                </div>
                <?php
            }
            ?>
            <button value="Submit" class="btnStyle">Update Stok</button>
        </form>
    </div>
</body>
</html>