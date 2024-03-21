<?php
require 'functions.php';

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

// pagination
// konfigurasi
$jumlah_data_per_halaman = 20;
$jumlah_data = count(query("SELECT * FROM kode_rekening"));
$jumlah_halaman = ceil($jumlah_data / $jumlah_data_per_halaman);
$halaman_aktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$awal_data = ($jumlah_data_per_halaman * $halaman_aktif) - $jumlah_data_per_halaman;

$isi = query("SELECT * FROM kode_rekening ORDER BY kode_rekening ASC LIMIT $awal_data, $jumlah_data_per_halaman");

// tombol cari di klik
if (isset($_POST['cari_kode_rekening'])) {
	$keyword = $_POST['keyword'];
	$isi = cariKodeRekening1($keyword);
}

if (isset($_POST['cari_deskripsi_rekening'])) {
	$keyword = $_POST['keyword'];
	$isi = cariDeskripsiRekening1($keyword);
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
	<title>Halaman kode rekening</title>
</head>

<body class="bg">
	<?php include 'include/navbar.php'; ?>
	<section>
		<div class="container-fluid">
			<div class="row h3">
				<div class="col">
					<h3 class="bg-supergraphicss p-2 text-white text-center rounded">Info kode rekening</h3>
				</div>
			</div>
			<div class="row justify-content-center menu">
				<div class="col-md-6 mt-3 mb-2">
					<form class="form-inline" method="post">
						<input for="colFormLabel" class="form-control mr-sm-2" type="text" autocomplete="off" placeholder="Cari" aria-label="Search" name="keyword">
						<div class="dropdown">
							<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Cari berdasarkan
								<img src="img/baseline_search_white_18dp.png">
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<button class="dropdown-item" name="cari_kode_rekening" type="submit">Kode Rekening</button>
								<button class="dropdown-item" name="cari_deskripsi_rekening" type="submit">Deskripsi Kode Rekening</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-6 mt-3 mb-2">
				<div class="row aksi">
				<a class="nav-link btn btn-primary text-white m-1" href="tambah_kode_rekening.php">Tambah Kode Rekening</a>
			</div>
</div>
			</div>
			<div class="row">
				<!-- pagination -->
				<div class="col-md-3">
					<nav aria-label="Page navigation example">
						<ul class="pagination pagination-md">
							<li class="page-item">
								<?php if ($halaman_aktif > 1) : ?>
									<a class="page-link" href="?halaman=<?= $halaman_aktif - 1; ?>" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
									</a>
								<?php endif; ?>
							</li>

							<?php for ($i = 1; $i <= $jumlah_halaman; $i++) : ?>
								<?php if ($i == $halaman_aktif) : ?>
									<li class="page-item"><a class="rounded page-link bg-primary text-white" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
								<?php else : ?>
									<li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
								<?php endif; ?>
							<?php endfor; ?>

							<li class="page-item">
								<?php if ($halaman_aktif < $jumlah_halaman) : ?>
									<a class="page-link" href="?halaman=<?= $halaman_aktif + 1; ?>" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
									</a>
								<?php endif; ?>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<table class="rounded table bg-white table-bordered table-hover table-primary shadow-box">
						<thead>
							<tr class="bg-primary text-white text-center">
								<th>No.</th>
								<th>Kode Rekening</th>
								<th>Deskripsi Kode Rekening</th>
								<th class="aksi">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($isi as $row) : ?>
								<tr class="text-center">
									<td><?= $i; ?></td>
									<td><?= $row["kode_rekening"]; ?></td>
									<td><?= $row["deskripsi_rekening"]; ?></td>
									<td class="aksi">
										<a href="ubah_kode_rekening.php?id=<?= $row['id_kode_rekening']; ?>" onclick="return confirm('Apakah Anda Ingin Mengubah Data ?');" class="btn btn-warning text-center text-white">
											<img src="img/baseline_edit_white_18dp.png">
										</a>
										<a href="hapus_kode_rekening.php?id=<?= $row['id_kode_rekening']; ?>" onclick="return confirm('Apakah Anda Ingin Menghapus Data ?');" class="btn btn-danger text-center">
											<img src="img/baseline_delete_white_18dp.png">
										</a>
									</td>
								</tr>
								<?php $i++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<!-- pagination -->
				<div class="col-md-3">
					<nav aria-label="Page navigation example">
						<ul class="pagination pagination-md">
							<li class="page-item">
								<?php if ($halaman_aktif > 1) : ?>
									<a class="page-link" href="?halaman=<?= $halaman_aktif - 1; ?>" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
									</a>
								<?php endif; ?>
							</li>

							<?php for ($i = 1; $i <= $jumlah_halaman; $i++) : ?>
								<?php if ($i == $halaman_aktif) : ?>
									<li class="page-item"><a class="rounded page-link bg-primary text-white" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
								<?php else : ?>
									<li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
								<?php endif; ?>
							<?php endfor; ?>

							<li class="page-item">
								<?php if ($halaman_aktif < $jumlah_halaman) : ?>
									<a class="page-link" href="?halaman=<?= $halaman_aktif + 1; ?>" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
									</a>
								<?php endif; ?>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<div class="footer">
		COPYRIGHT &copy; <?= date('Y'); ?> Seksi Penyuluhan Sosial | Repost by <a href='https://dinassosial.go.id/' title='dinassosial.go.id' target='_blank'>dinassosial.go.id</a>
	</div>


	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="vendor/jquery-3.3.1.slim.min.js"></script>
	<script src="vendor/popper.min.js"></script>
	<script src="vendor/bootstrap.min.js"></script>
</body>

</html>