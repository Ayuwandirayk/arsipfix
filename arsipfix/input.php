<?php
require 'functions.php';

if (!isset($_SESSION["login"])) {
	header("Location: 'login.php'");
}


if (isset($_POST['submit'])) {

		$max_file_size = 10 * 1024 * 1024; // Misalnya, batas ukuran adalah 10 MB
	
	// Periksa apakah file yang diunggah melebihi batasan ukuran
	if ($_FILES['file']['size'] > $max_file_size) {
		echo "<div class='alert alert-danger alert-dismissible fade show text-center'>";
		echo "<a class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
		echo "<strong>Gagal!</strong> File terlalu besar, maksimal ukuran file adalah 10 MB.";
		echo "</div>";
		// Tambahkan kode tambahan di sini, seperti mengarahkan pengguna kembali ke halaman sebelumnya
		exit; // Keluar dari skrip
	}


	// cek apakah data berhasil ditambahkan atau tidak
	if (tambah($_POST) > 0) {
		echo "
			<script>
				alert('data berhasil ditambahkan!');
				document.location.href = 'index.php';
			</script>
		";
	} else {
		echo "<script>
				alert('data gagal ditambahkan!');
				document.location.href = 'input.php';
			</script>
		";
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

	<title>Tambah Data SPJ</title>
</head>

<body class="bg">
	<?php include 'include/navbar.php'; ?>

	<section id="tambah_data" class="tambah_data">
		<div class="container">
			<div class="row mb-2">
				<div class="col text-white p-1 rounded bg-supergraphicss text-center">
					<h2>Tambah Data SPJ</h2>
				</div>
			</div>
			<div class="row">
				<div class="col bg-white rounded p-5 mb-2 shadow-box">
					<form action="proses_input.php" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
								<label class="control-label" for="kode_rekening">Kode Rekening : </label>
									<input type="text" id="kode_rekening" name="kode_rekening" class="form-control" required>
								</div>
								<div class="form-group">
									<label class="control-label" for="kegiatan">kegiatan : </label>
									<input type="text" id="kegiatan" name="kegiatan" class="form-control" required>
								</div>
								<div class="form-group">
									<label class="control-label" for="sub_kegiatan">sub kegiatan : </label>
									<input type="text" id="sub_kegiatan" name="sub_kegiatan" class="form-control" required>
								</div>
								<div class="form-group">
									<label class="control-label" for="tanggal_kegiatan">Tanggal kegiatan : </label>
									<input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" class="form-control" required>
								</div>
							</div>
							<div class="col-sm-6">								
								<div class="form-group">
									<label class="control-label" for="kegiatan">Target Lokasi : </label>
									<input type="text" id="target_lokasi" name="target_lokasi" class="form-control" required>
								</div>
								<div class="form-group">
									<label class="control-label" for="keterangan">Keterangan : </label>
									<input type="text" id="keterangan" name="keterangan" class="form-control" required>
								</div>
								<div class="form-group">
								<label class="control-label" for="..file/">Input File (Wajib format PDF):</label>
								<input type="file" id="file" name="file" class="form-control" required><br><br>
								
						</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary mt-3" name="submit">Tambah Data
								<img src="img/baseline_send_white_18dp.png"></button>
						</div>
					</form>
				</div>
</div>
</div></section>

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