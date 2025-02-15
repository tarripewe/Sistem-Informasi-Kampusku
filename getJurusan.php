<?php
include 'config.php';

if(isset($_GET['id_fakultas'])){
    $id_fakultas = $_GET['id_fakultas'];
    $query = "SELECT * FROM jurusan WHERE id_fakultas = '$id_fakultas' ORDER BY nama_jurusan ASC";
    $result = mysqli_query($conn, $query);
    if($result){
        // Mulai dengan option default
        echo '<option value="">-- Pilih Jurusan --</option>';
        while($row = mysqli_fetch_assoc($result)){
            echo '<option value="'.$row['id_jurusan'].'">'.htmlspecialchars($row['nama_jurusan']).'</option>';
        }
    } else {
        echo '<option value="">Error mengambil data jurusan</option>';
    }
} else {
    echo '<option value="">Pilih fakultas terlebih dahulu</option>';
}
?>
