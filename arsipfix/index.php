<?php
require 'functions.php';

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

// pagination
// konfigurasi
$jumlah_data_per_halaman = 10;
$jumlah_data = count(query("SELECT * FROM arsip_dokumen"));
$jumlah_halaman = ceil($jumlah_data / $jumlah_data_per_halaman);
$halaman_aktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$awal_data = ($jumlah_data_per_halaman * $halaman_aktif) - $jumlah_data_per_halaman;

$isi = query("SELECT * FROM arsip_dokumen JOIN kode_rekening ON arsip_dokumen.kode_rekening = kode_rekening.kode_rekening LIMIT $awal_data, $jumlah_data_per_halaman");

// tombol cari di klik
if (isset($_POST['cari_tanggal_kegiatan'])) {
	$keyword = $_POST['keyword'];
	$isi = cariTanggalkegiatan($keyword);
}

if (isset($_POST['cari_target_kegiatan'])) {
	$keyword = $_POST['keyword'];
	$isi = cariTargetLokasi($keyword);
}

if (isset($_POST['cari_kode_rekening'])) {
	$keyword = $_POST['keyword'];
	$isi = cariKodeRekening($keyword);
}

if (isset($_POST['cari_kegiatan'])) {
	$keyword = $_POST['keyword'];
	$isi = carikegiatan($keyword);
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
	<title>Halaman Utama</title>
</head>

<body class="bg">
	<?php include 'include/navbar.php'; ?>
	<section id="kegiatan" class="kegiatan">
		<div class="container-fluid">
			<div class="row marquee justify-content-center">
				<div class="col-md-6 mt-3 mb-3">
					<marquee scrollamount="10" loop="infinite" direction="left" class="nav-link text-white p-2 bg-info rounded text-center">
						<h4><?= salam(); ?> <?= ucfirst($_SESSION['username']); ?></h4>
					</marquee>
				</div>
			</div>
			<div class="row h3">
				<div class="col">
					<h3 class="bg-supergraphicss p-2 text-white text-center rounded">Dashboard</h3>
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
								<button class="dropdown-item" name="cari_tanggal_kegiatan" type="submit">Tanggal kegiatan</button>
								<button class="dropdown-item" name="cari_target_kegiatan" type="submit">Target kegiatan</button>
								<button class="dropdown-item" name="cari_kode_rekening" type="submit">Kode Rekening</button>
								<button class="dropdown-item" name="cari_kegiatan" type="submit">kegiatan</button>
							</div>
						</div>
					</form>
				</div>
				
			</div>
			<div class="row pagination">
				<!-- pagination -->
				<div class="col-md-12">
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
					<table rules="all" cellpadding="10" cellspacing="0" class="table bg-white table-bordered table-hover table-primary shadow-box">
						<tr class="bg-primary text-white text-center">
							<th>No.</th>
							<th>Kode Rekening</th>
							<th>kegiatan</th>
							<th>sub kegiatan</th>
							<th>Tanggal kegiatan </th>
							<th>Target kegiatan</th>
							<th>Keterangan</th>
							<th>File PDF (Klik File untuk mendownload) </th>
							<th class="aksi">Aksi</th>
						</tr>
						<?php $i = 1; ?>
						<?php foreach ($isi as $row) : ?>
							<tr class="text-center">
								<td><?= $i; ?></td>
								<td>
									<button type="button" class="kode_rekening btn btn-white border bordered-primary" data-toggle="popover" title="<?= $row["kode_rekening"]; ?>" data-content="<?= $row['deskripsi_rekening']; ?>"><?= $row["kode_rekening"]; ?></button>
								</td>
								<td><?= $row["kegiatan"]; ?></td>
								<td><?= $row["sub_kegiatan"]; ?></td>

								<td><?= date('d F Y', strtotime($row["Tanggal_kegiatan"])); ?></td>
								<td class="text-center text-justify"><?= ucwords($row["Target_lokasi"]); ?></td>
								<td class="text-center text-justify"><?= ucwords($row["Keterangan"]); ?></td>
								<td style="text-center text-justify;"><a href="file/sudahupload/<?= ucwords($row["file"]); ?>"><?= ucwords($row["file"]); ?></td>
						
								<td class="aksi">
								<a href="ubah.php?id_arsip_dokumen=<?= $row['id_arsip_dokumen']; ?>" onclick="return confirm('Apakah Anda Ingin Mengubah Data ?');" class="m-1 btn btn-warning text-center text-white">
										<img src="img/baseline_edit_white_18dp.png">
									
								<a href="hapus.php?id=<?= $row['id_arsip_dokumen']; ?>" onclick="return confirm('Apakah Anda Ingin Menghapus Data ?');" class="m-1 btn btn-danger text-center">
										<img src="img/baseline_delete_white_18dp.png">
									</a>
									
							</tr> 
							<?php $i++; ?>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<div class="row pagination">
				<!-- pagination -->
				<div class="col-md-12">
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
		COPYRIGHT &copy; <?= date('Y'); ?> DINAS SOSIAL DIY | Repost by <a href='https://dinassosial.go./' title='dinassosial.go.' target='_blank'>dinassosial.go.id</a>
	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="vendor/jquery-3.3.1.slim.min.js"></script>
	<script src="vendor/popper.min.js"></script>
	<script src="vendor/bootstrap.min.js"></script>
	<script>
		$(function() {
			$('[data-toggle="popover"]').popover()
		})
	</script>
</body>

</html>