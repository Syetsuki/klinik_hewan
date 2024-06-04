<?php
include 'connect.php';
$db = new database();

$searchPerformed = false;
$notificationMessage = "";
// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchPerformed = true;
    $filtervalue = $_POST['search'];
    
    // Query to search for data
    $sql = "SELECT pr.id_perawatan,pr.tanggal_perawatan, h.id_hewan, h.nama_hewan, h.jenis_hewan, p.id_pemilik, p.nama_pemilik, pr.diagnosa, dh.id_dokter, dh.nama_dokter, pr.biaya
            FROM Perawatan pr
            JOIN Hewan h ON pr.id_hewan = h.id_hewan
            JOIN Pemilik p ON h.id_pemilik = p.id_pemilik
            JOIN DokterHewan dh ON pr.id_dokter = dh.id_dokter
            WHERE CONCAT(nama_hewan, jenis_hewan, nama_pemilik, nama_dokter, tanggal_perawatan) LIKE '%$filtervalue%'";

    // Execute the query
    $result = $db->fetchdata($sql);
} else {
    // If form is not submitted, fetch all data
    $sql = "CALL tableAwal()";
    $result = $db->fetchdata($sql);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - Klinik Hewan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="table">
        <section class="tableHeader">
            <h1>Animal Care Checklist</h1>
            <form class="search" action="" method="POST">
                <div class="input-group">
                    <input type="text" name="search" required value="<?php if(isset($_POST['search'])) echo $_POST['search']; ?>" placeholder="Search Data...">
                    <img src="assets/Search.png">
                </div>
            </form>
        </section>
        </section>
        <section class="btnStyle">
             <!-- Tombol untuk menambahkan data baru  -->
            <a href="create/createPemilik.php"><button>New Customer</button></a>
             <!-- Tombol untuk pemilik yang sudah terdaftar tetapi hewannya belum  -->
            <a href="create/selectPemilik.php?action=add_hewan"><button>Tambah Hewan</button></a>
             <!-- Tombol untuk pemilik dan hewan yang sudah terdaftar  -->
            <a href="create/selectHewan.php?action=add_perawatan"><button>Tambah Perawatan</button></a>
        </section>
        <section class="tableBody">
            <table class="content-table">
                <thead>
                   <tr>
                    <th>ID</th>
                    <th>Tanggal Perawatan</th>
                    <th>Nama Hewan</th>
                    <th>Jenis Hewan</th>
                    <th>Nama Pemilik</th>
                    <th>Diagnosa</th>
                    <th>Nama Dokter</th>
                    <th>Biaya</th>
                    <th style="text-align: center">Aksi</th>
                   </tr> 
                </thead>
                <tbody>
                    <?php
                    if (is_array($result) && count($result) > 0) {
                        foreach ($result as $row) {
                            echo '<tr>';
                            echo '<td>' . $row['id_perawatan'] . '</td>';
                            echo '<td>' . $row['tanggal_perawatan'] . '</td>';
                            echo '<td>' . $row['nama_hewan'] . '</td>';
                            echo '<td>' . $row['jenis_hewan'] . '</td>';
                            echo '<td>' . $row['nama_pemilik'] . '</td>';
                            echo '<td>' . $row['diagnosa'] . '</td>';
                            echo '<td>' . $row['nama_dokter'] . '</td>';
                            echo '<td><strong>Rp. ' . $row['biaya'] . '</strong></td>';
                            echo '<td style="text-align: center"><a href="edit.php?id_perawatan=' . $row['id_perawatan'] . '"><img src="assets/Edit.png"></a> <a href="delete.php?id=' . $row['id_perawatan'] . '" onclick="return confirm(\'Yakin hapus data?\')"><img src="assets/Delete.png"></a></td>';
                            echo '</tr>';
                        }
                    } else {
                        $sql = "CALL tableAwal()";
                        $result = $db->fetchdata($sql);
                        if ($searchPerformed) {
                            if (is_array($result) && count($result) > 0) {
                                foreach ($result as $row) {
                                    echo '<tr>';
                                    echo '<td>' . $row['id_perawatan'] . '</td>';
                                    echo '<td>' . $row['tanggal_perawatan'] . '</td>';
                                    echo '<td>' . $row['nama_hewan'] . '</td>';
                                    echo '<td>' . $row['jenis_hewan'] . '</td>';
                                    echo '<td>' . $row['nama_pemilik'] . '</td>';
                                    echo '<td>' . $row['diagnosa'] . '</td>';
                                    echo '<td>' . $row['nama_dokter'] . '</td>';
                                    echo '<td><strong>Rp. ' . $row['biaya'] . '</strong></td>';
                                    echo '<td style="text-align: center"><a href="edit.php?id_perawatan=' . $row['id_perawatan'] . '"><img src="assets/Edit.png"></a> <a href="delete.php?id=' . $row['id_perawatan'] . '" onclick="return confirm(\'Yakin hapus data?\')"><img src="assets/Delete.png"></a></td>';
                                    echo '</tr>';
                                }
                            
                            }
                        
                        }
                    }
                    ?>
                </tbody>
            </table>
    </main>
</body>
</html>
