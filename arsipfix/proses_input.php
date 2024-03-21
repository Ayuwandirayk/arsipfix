<?php
    $koneksi = mysqli_connect("localhost", "root", "" , "arsipfix") or die;
    $id = $_POST['id_kode_rekening'];
    $kode_rekening = $_POST['kode_rekening'];
    $kegiatan =  $_POST['kegiatan'];
    $sub_kegiatan = $_POST['sub_kegiatan'];
    $tanggal_kegiatan = $_POST['tanggal_kegiatan'];
    $target_lokasi = $_POST['target_lokasi'];
    $keterangan =  $_POST['keterangan'];

    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $lokasi = "file/sudahupload/";
    move_uploaded_file($file_tmp,$lokasi.$file_name);


    $perintah = "INSERT INTO arsip_dokumen (kode_rekening, kegiatan, sub_kegiatan, tanggal_kegiatan, 
    target_lokasi, keterangan,file) VALUES ('$kode_rekening','$kegiatan', '$sub_kegiatan', 
    '$tanggal_kegiatan','$target_lokasi', '$keterangan','$file_name');";
    $query = mysqli_query($koneksi,$perintah);

    if ($query) {
        header("location:index.php");
    }else {
        header("location:input.php");
    }

?>