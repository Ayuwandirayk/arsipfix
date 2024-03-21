<?php
    $koneksi = mysqli_connect("localhost", "root", "" , "arsipfix") or die;

    $kode_rekening = $_POST['kode_rekening'];
    
    if (isset($_FILES['file']['name'])){
    
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        $lokasi = "sudahupload/";
        
        move_uploaded_file($file_tmp,$lokasi.$file_name);
        
        $insertquery = "INSERT INTO pdf_data(filename) VALUES('$file_name')";
        $iquery = mysqli_query($koneksi, $insertquery);

        header("Location: ../index.php");
        
    } else {?>
        <div class= "alert alert-danger alert-dismissible fade show text-center">
            <a class="close" data-dismiss="alert"aria-label="close"></a>
            <strong>Failed!</strong>
            File must be uploaded in PDF format!
        </div><?php
        header("Location: ../input.php");
    }
?>