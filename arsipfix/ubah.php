<?php
require 'functions.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Periksa apakah parameter id_arsip_dokumen telah diberikan
if (!isset($_GET['id_arsip_dokumen'])) {
    echo "Error: Tidak ada ID yang dipilih.";
    exit; 
}

$id = $_GET['id_arsip_dokumen'];
$isi = query("SELECT * FROM arsip_dokumen WHERE id_arsip_dokumen = $id")[0];

if (isset($_POST['submit'])) {
    // Handle form submission

    // Prepare data for update
    $data = [
        'id_arsip_dokumen' => $id,
        'kode_rekening' => $_POST['kode_rekening'],
        'kegiatan' => $_POST['kegiatan'],
        'sub_kegiatan' => $_POST['sub_kegiatan'],
        'tanggal_kegiatan' => $_POST['tanggal_kegiatan'],
        'target_lokasi' => $_POST['target_lokasi'],
        'keterangan' => $_POST['keterangan']
    ];

    // Check if file is uploaded successfully
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Pastikan berkas yang diunggah adalah PDF
        if ($_FILES['file']['type'] != 'application/pdf') {
            echo "<script>alert('Berkas harus dalam format PDF!');</script>";
            header("Location: ubah.php?id_arsip_dokumen=$id");
            exit;
        }
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        // Tentukan lokasi penyimpanan file baru
        $file_location = "file/sudahupload/" . $file_name;
        // Pindahkan berkas ke direktori yang ditentukan
        if (!move_uploaded_file($file_tmp, $file_location)) {
            // Jika gagal memindahkan berkas, tampilkan pesan kesalahan
            echo "<script>alert('Gagal mengunggah berkas.'); window.location.href = 'ubah.php?id_arsip_dokumen=$id';</script>";
            exit;
        }
        // Jika file berhasil diunggah, tambahkan nama file ke dalam data yang akan diupdate
        $data['file'] = $file_name;
    }

    // Attempt to update data
    $result = ubah($data);

    if ($result) {
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'ubah.php?id_arsip_dokumen=$id';
              </script>";
        exit;
    }
}
?>




<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="vendor/bootstrap.min.css">

	<!-- CSS -->
	<link rel="stylesheet" href="vendor/style.css">
	<link rel="shortcut icon" type="text/css" href="img/logo.png">

	<title>Ubah Data</title>
</head>

<body class="bg">
	<?php include 'include/navbar.php'; ?>
	<section id="ubah_data" class="ubah_data">
		<div class="container">
			<div class="row mb-2">
				<div class="col text-white p-1 rounded bg-supergraphicss text-center">
					<h2>Ubah Data</h2>
				</div>
			</div>
			<div class="row">
				<div class="col bg-white rounded p-5 mb-2 shadow-box">
					<form action="ubah.php?id_arsip_dokumen=<?= $id ?>" method="POST" enctype="multipart/form-data">
						<div class="row">
						<input type="hidden" id="id_arsip_dokumen" value="<?= $isi['id_arsip_dokumen']; ?>">
							<div class="col-sm-6">
								<div class="form-group">
								<label for="kode_rekening">Kode Rekening : </label>
									<input type="text" id="kode_rekening" name="kode_rekening" class="form-control" required value="<?= $isi['kode_rekening']; ?>">
								</div>
								<div class="form-group">
									<label for="kegiatan">kegiatan : </label>
									<input type="text" id="kegiatan" name="kegiatan" class="form-control" required value="<?= $isi['kegiatan']; ?>">
								</div>
								<div class="form-group">
									<label for="sub_kegiatan">sub kegiatan : </label>
									<input type="text" id="sub_kegiatan" name="sub_kegiatan" class="form-control" required value="<?= $isi['sub_kegiatan']; ?>">
								</div>
								<div class="form-group">
									<label for="tanggal_kegiatan">Tanggal kegiatan : </label>
									<input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" class="form-control" required value="<?= $isi['Tanggal_kegiatan']; ?>">
								</div>
							</div>
							<div class="col-sm-6">								
								<div class="form-group">
									<label for="kegiatan">Target Lokasi : </label>
									<input type="text" id="target_lokasi" name="target_lokasi" class="form-control" required value="<?= $isi['Target_lokasi']; ?>">
								</div>
								<div class="form-group">
									<label for="keterangan">Keterangan : </label>
									<input type="text" id="keterangan" name="keterangan" class="form-control" required value="<?= $isi['Keterangan']; ?>">
								</div>
								<div class="form-group">
							<label class="control-label" for="file">File saat ini:</label>
							<?php if (!empty($isi['file'])): ?>
								<a href="file/sudahupload/<?= $isi['file']; ?>" target="_blank"><?= $isi['file']; ?></a>
							<?php else: ?>
								<span>Tidak ada file yang terkait.</span>
							<?php endif; ?>
						</div>
						<div class="form-group">
							<label class="control-label" for="file">Unggah file baru (Wajib format PDF):</label>
							<input type="file" id="file" name="file" class="form-control">
						</div>

						
						</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary mt-3" name="submit">Ubah Data
								<img src="img/baseline_send_white_18dp.png"></button>
						</div>
					</form>
				</div>
		</div>
		</div>
	</section>


	<div class="footer">
		COPYRIGHT &copy; <?= date('Y'); ?> DINAS SOSIAL DIY | Repost by <a href='https://dinassosial.go.id/' title='dinassosial.go.id' target='_blank'>dinassosial.go.id</a>
	</div>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="vendor/jquery-3.3.1.min.js"></script>
	<script src="vendor/jquery.autocomplete.min.js"></script>
	<script src="vendor/popper.min.js"></script>
	<script src="vendor/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			// Selector input yang akan menampilkan autocomplete.
			$("#kode_rekening").autocomplete({
				serviceUrl: "suggestion.php", // Kode php untuk prosesing data.
				dataType: "JSON", // Tipe data JSON.
				onSelect: function(suggestion) {
					$("#kode_rekening").val("" + suggestion.kode_rekening);
				}
			});

			// Selector input yang akan menampilkan autocomplete.
			$("#kegiatan").autocomplete({
				serviceUrl: "suggestion1.php", // Kode php untuk prosesing data.
				dataType: "JSON", // Tipe data JSON.
				onSelect: function(suggestion) {
					$("#kegiatan").val("" + suggestion.kegiatan);
				}
			});
			// Selector input yang akan menampilkan autocomplete.
			$("#sub_kegiatan").autocomplete({
				serviceUrl: "suggestion2.php", // Kode php untuk prosesing data.
				dataType: "JSON", // Tipe data JSON.
				onSelect: function(suggestion) {
					$("#sub_kegiatan").val("" + suggestion.sub_kegiatan);
				}
			});
		});
	</script>
</body>

</html>