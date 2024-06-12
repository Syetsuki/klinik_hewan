<?php

include 'connect.php';
$db = new database();

// Memeriksa apakah parameter ID Perawatan telah diterima dari URL
if (isset($_GET['id'])) {
    $id_perawatan = $_GET['id'];

    // Menjalankan query untuk menghapus data perawatan dengan ID yang diberikan
    $sql = "DELETE FROM Perawatan WHERE id_perawatan = $id_perawatan";

    // Menjalankan query delete
    if ($db->sqlquery($sql)) {
        echo "Data perawatan dengan ID $id_perawatan berhasil dihapus.";
        header ("location: indexwjs.php");
    } else {
        echo "Gagal menghapus data perawatan.";
    }
} else {
    echo "ID Perawatan tidak ditemukan.";
    
}

?>
