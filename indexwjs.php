<?php
include 'connect.php';
$db = new database();
$sql = "CALL tableAwal()";
$result = $db->fetchdata($sql);

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
                <div class="input-group">
                    <input type="search" id="search-input" placeholder="Search Data...">
                    <img src="assets/Search.png">
                </div>
        </section>
        <section class="btnStyle">
             <!-- Tombol untuk menambahkan data baru  -->
            <a href="create/createPemilik.php"><button>New Customer</button></a>
             <!-- Tombol untuk pemilik yang sudah terdaftar tetapi hewannya belum  -->
            <a href="create/selectPemilik.php?action=add_hewan"><button>Tambah Hewan</button></a>
             <!-- Tombol untuk pemilik dan hewan yang sudah terdaftar  -->
            <a href="create/selectHewan.php?action=add_perawatan"><button>Tambah Perawatan</button></a>
            <a href="updatestokObat.php"><button>Stok Obat</button></a>
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
                    if (is_array($result)) {
                        foreach ($result as $row) {
                            echo '<tr>';
                            echo '<td>' . $row['id_perawatan'] . '</td>';
                            echo '<td>' . $row['tanggal_perawatan'] . '</td>';
                            echo '<td>' . $row['nama_hewan'] . '</td>';
                            echo '<td>' . $row['jenis_hewan'] . '</td>';
                            echo '<td>' . $row['nama_pemilik'] . '</td>';
                            echo '<td>' . $row['diagnosa'] . '</td>';
                            echo '<td>' . $row['nama_dokter'] . '</td>';
                            echo '<td style="text-align: left; padding-left: 20px"><strong>Rp. ' . $row['biaya'] . '</strong></td>';
                            echo '<td style="text-align: center"><a href="edit.php?id_perawatan=' . $row['id_perawatan'] . '"><img src="assets/Edit.png"></a> <a href="delete.php?id=' . $row['id_perawatan'] . '" onclick="return confirm(\'Yakin hapus data?\')"><img src="assets/Delete.png"></a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <script src="js/script.js"></script>
</body>
</html>
