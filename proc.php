<?php
include 'connect.php';
$db = new database();

if(isset($_POST['jenis'])){ 
    $jenis = $_POST['jenis'];

    if($jenis=='kab'){
        $prop = $_POST['prop'];
        $sql = "SELECT * FROM kabupaten WHERE propinsi_id='$prop' ORDER BY nama";
        $data = $db->fetchdata($sql);
        foreach($data as $dat){
            echo "<option value='".$dat['id']."'>".$dat['nama']."</option>";
        }
    }

    if($jenis=='kec'){
        $kab = $_POST['kab'];
        $sql = "SELECT * FROM kecamatan WHERE kabupaten_id='$kab' ORDER BY nama";
        $data = $db->fetchdata($sql);
        foreach($data as $dat){
            echo "<option value='".$dat['id']."'>".$dat['nama']."</option>";
        }
    }

    if($jenis=='desa'){
        $kec = $_POST['kec'];
        $sql = "SELECT * FROM desa WHERE kecamatan_id='$kec' ORDER BY nama";
        $data = $db->fetchdata($sql);
        foreach($data as $dat){
            echo "<option value='".$dat['id']."'>".$dat['nama']."</option>";
        }
    }
}
?>