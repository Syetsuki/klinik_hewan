<?php
include '../connect.php';
$db = new database();

// Memeriksa apakah form telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $nama_pemilik = $_POST['nama_pemilik'];
    $no_telepon = $_POST['no_telepon'];
    $desa_id = $_POST['desa_id'];

    // Menjalankan prosedur untuk menambahkan data pemilik
    $sql = "CALL tambah_pemilik('$nama_pemilik', '$no_telepon', '$desa_id')";
    if ($db->sqlquery($sql)) {
        // Mengambil ID pemilik yang baru saja ditambahkan
        $sql_last_id = "SELECT id_pemilik FROM pemilik ORDER BY id_pemilik DESC LIMIT 1";
        $result_last_id = $db->sqlquery($sql_last_id);
        $row = $result_last_id->fetch_assoc();
        $id_pemilik = $row['id_pemilik']; 
        // Mengarahkan ke halaman createHewan.php dengan ID pemilik
        header("Location: createHewan.php?id_pemilik=" . $id_pemilik);
        exit();
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
    <title>Tambah Data Pemilik</title>
    <link rel="stylesheet" href="../css/second.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"></script>
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h1>Pemilik</h1>
            <div class="input-box">
                <input type="text" id="nama_pemilik" name="nama_pemilik" placeholder="Nama Pemilik" required>
                <img src="../assets/User.png">
            </div>
            <div class="all-alamat">
                <div class="alamatup">
                    <div class="alamat">
                        <select name="propinsi_id" id="propinsi_id">
                            <option selected>Provinsi</option>
                            <?php 
                                $sql = "SELECT * FROM propinsi ORDER BY nama";
                                $data = $db->fetchdata($sql);
                                foreach($data as $dat){
                                    echo "<option value='" .$dat['id']."'>" .$dat['nama']."</option>";
                                }
                            ?>
                        </select>
                        <img src="../assets/dropdown-arrow.png" class="dropdown-arrow">
                    </div>
                    <div class="alamat">
                        <select name="kabupaten_id" id="kabupaten_id">
                            <option selected>Kota/Kab.</option>
                        </select>
                        <img src="../assets/dropdown-arrow.png" class="dropdown-arrow">
                    </div>
                </div>
                <div class="alamatdown">
                    <div class="alamat">
                        <select name="kecamatan_id" id="kecamatan_id">
                            <option selected>Kec.</option>
                        </select>
                        <img src="../assets/dropdown-arrow.png" class="dropdown-arrow">
                    </div>
                    <div class="alamat">
                        <select name="desa_id" id="desa_id">
                            <option selected>Desa</option>
                        </select>
                        <img src="../assets/dropdown-arrow.png" class="dropdown-arrow">
                    </div>
                </div>
            <div class="input-box">
                <input type="text" id="no_telepon" name="no_telepon" placeholder="Nomor Telepon" required>
                <img src="../assets/Call.png">
            </div>
            <button value="Submit" class="btnStyle">Submit</button>
                
        </form>
    </div>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $('#propinsi_id').change(function(){
                var prop = $('#propinsi_id').val();
                $.ajax({
                    type: "POST",
                    url: "../proc.php",
                    data: { jenis: 'kab', prop: prop },
                    success: function(res){
                        $('#kabupaten_id').html('<option value="">Kota/Kab.</option>' + res);
                        $('#kecamatan_id').html('<option value="">Kec.</option>');
                        $('#desa_id').html('<option value="">Desa</option>');
                    }
                });
            });

            $('#kabupaten_id').change(function(){
                var kab = $('#kabupaten_id').val();
                $.ajax({
                    type: "POST",
                    url: "../proc.php",
                    data: { jenis: 'kec', kab: kab },
                    success: function(res){
                        $('#kecamatan_id').html('<option value="">Kec.</option>' + res);
                        $('#desa_id').html('<option value="">Desa</option>');
                    }
                });
            });

            $('#kecamatan_id').change(function(){
                var kec = $('#kecamatan_id').val();
                $.ajax({
                    type: "POST",
                    url: "../proc.php",
                    data: { jenis: 'desa', kec: kec },
                    success: function(res){
                        $('#desa_id').html('<option value="">Desa</option>' + res);
                    }
                });
            });
        });
    </script>
</body>
</html>
