<tr>
    <td>Prodi</td>
    <td>
        <select id="dataprodi" name="prodi">
            <option value=""></option>
            <?php
            $no = 0;
            while ($data = mysqli_fetch_array($data_ubah)) {
                $no++;
                $ket = "";
                if (isset($_GET['prodi'])) {
                    $prodi = trim($_GET['prodi']);
                    if ($prodi == $data['kodep']) {
                        $ket = "selected";
                    }
                }
            ?>
                <option <?php echo $ket; ?> value="<?php echo $data_ubah['kodep']; ?>"><?php echo $data_ubah['namap']; ?></option>
            <?php
            }
            ?>
        </select>
    </td>
</tr>