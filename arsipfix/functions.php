<?php
session_start();
// koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "" , "arsipfix") or die;

function query($query){
	global $koneksi;
	$result = mysqli_query($koneksi, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}


function tambah($data){
	global $koneksi;
	$kegiatan = htmlspecialchars($data['kegiatan']);
	$sub_kegiatan = htmlspecialchars($data['sub_kegiatan']);
	$kode_rekening = htmlspecialchars($data['kode_rekening']);
	$tanggal_kegiatan = htmlspecialchars($data['tanggal_kegiatan']);
	$target_lokasi = htmlspecialchars($data['target_lokasi']);
	$keterangan = htmlspecialchars($data['keterangan']);

	
	// query insert data
	$query = "INSERT INTO arsip_dokumen (kegiatan, sub_kegiatan, kode_rekening, tanggal kegiatan, target_lokasi, keterangan) 
		VALUES ('$kegiatan', '$sub_kegiatan', '$kode_rekening', '$tanggal_kegiatan', '$target_lokasi', '$keterangan);
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function tambahkegiatan($data){
	global $koneksi;
	$kegiatan = htmlspecialchars($data['kegiatan']);
	$sub_kegiatan = htmlspecialchars($data['sub_kegiatan']);
	
	// query insert data
	$query = "INSERT INTO kegiatan (kegiatan, sub_kegiatan) 
		VALUES ('$kegiatan', '$sub_kegiatan');
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function tambahkodeRekening($data){
	global $koneksi;
	$kode_rekening = htmlspecialchars($data['kode_rekening']);
	$deskripsi_rekening = htmlspecialchars($data['deskripsi_rekening']);
	
	// query insert data
	$query = "INSERT INTO kode_rekening (kode_rekening, deskripsi_rekening) 
		VALUES ('$kode_rekening', '$deskripsi_rekening');
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function tambahAkun($data){
	global $koneksi;
	$username = strtolower(stripcslashes($data['username']));
	$password = mysqli_real_escape_string($koneksi, $data['password']);
	$password2 = mysqli_real_escape_string($koneksi, $data['password2']);
	$nama = htmlspecialchars($data['nama']);
	$akses = htmlspecialchars($data['akses']);

	// cek username sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
				alert('username sudah terdaftar !');
			</script>";
		return false;
	}

	// cek konfirmasi password
	if ($password !== $password2) {
	 	echo "<script>
				alert('konfirmasi password tidak sesuai !');
			</script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);
	
	// query insert data
	$query = "INSERT INTO user (username, password, nama, akses) 
		VALUES ('$username', '$password', '$nama', '$akses');
			";
	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}



function hapus($id){
	global $koneksi;
	mysqli_query($koneksi, "DELETE FROM arsip_dokumen WHERE id_arsip_dokumen = $id");
	
	return mysqli_affected_rows($koneksi); 
}

function hapuskodeRekening($id){
	global $koneksi;
	mysqli_query($koneksi, "DELETE FROM kode_rekening WHERE id_kode_rekening = $id");
	
	return mysqli_affected_rows($koneksi); 
}

function hapuskegiatan($id){
	global $koneksi;
	mysqli_query($koneksi, "DELETE FROM kegiatan WHERE id_kegiatan = $id");
	
	return mysqli_affected_rows($koneksi); 
}

function hapusAkun($id){
	global $koneksi;
	mysqli_query($koneksi, "DELETE FROM user WHERE id_user = $id");
	
	return mysqli_affected_rows($koneksi); 
}

function ubah($data){
	global $koneksi;
	$id = " "; 
	if (isset($data['id_arsip_dokumen'])) {
		$id = $data['id_arsip_dokumen'];
	}
	//$id = $data['id_arsip_dokumen'];
	$kode_rekening = htmlspecialchars($data['kode_rekening']);
	$kegiatan = htmlspecialchars($data['kegiatan']);
	$subkegiatan = htmlspecialchars($data['sub_kegiatan']);
	$tanggal_kegiatan = htmlspecialchars($data['tanggal_kegiatan']);
	$target_lokasi = htmlspecialchars($data['target_lokasi']);
	$keterangan = htmlspecialchars($data['keterangan']);
	

	// query insert data
	$query = "UPDATE arsip_dokumen
				SET
				kode_rekening = '$kode_rekening', 
				kegiatan = '$kegiatan', 
				sub_kegiatan = '$subkegiatan', 
				tanggal_kegiatan = '$tanggal_kegiatan', 
				target_lokasi = '$target_lokasi',
				keterangan = '$keterangan'
				WHERE id_arsip_dokumen = '$id' 
			";
	mysqli_query($koneksi, $query);
	
	return mysqli_affected_rows($koneksi);
}



function ubahkodeRekening($data){
	global $koneksi;
	$id = $data['id_kode_rekening'];
	$kode_rekening = htmlspecialchars($data['kode_rekening']);
	$deskripsi_rekening = htmlspecialchars($data['deskripsi_rekening']);

	// query insert data
	$query = "UPDATE kode_rekening
				SET 
				kode_rekening = '$kode_rekening',
				deskripsi_rekening = '$deskripsi_rekening'
				WHERE id_kode_rekening = '$id' 
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function ubahkegiatan($data){
	global $koneksi;
	$id = $data['id_kegiatan'];
	$kegiatan = htmlspecialchars($data['kegiatan']);
	$sub_kegiatan = htmlspecialchars($data['sub_kegiatan']);

	// query insert data
	$query = "UPDATE kegiatan
				SET 
				kegiatan = '$kegiatan',
				sub_kegiatan = '$sub_kegiatan'
				WHERE id_kegiatan = '$id' 
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function ubahAkun($data){
	global $koneksi;
	$id = $data['id'];
	$username = strtolower(stripcslashes($data['username']));
	$password = mysqli_real_escape_string($koneksi, $data['password']);
	$password2 = mysqli_real_escape_string($koneksi, $data['password2']);
	$nama = htmlspecialchars($data['nama']);
	$akses = htmlspecialchars($data['akses']);

	if ($password !== $password2) {
		echo "<script>
			alert('konfirmasi tidak sesuai');
		</script>";
		return false;
	}
	$password = password_hash($password, PASSWORD_DEFAULT);
	// query insert data
	$query = "UPDATE user
				SET
				username = '$username',
				password = '$password',
				nama = '$nama',
				akses = '$akses'
				WHERE id_user = '$id' 
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}


function cariTanggalkegiatan($keyword){
	$query = "SELECT * FROM arsip_dokumen JOIN kode_rekening ON arsip_dokumen.kode_rekening = kode_rekening.kode_rekening WHERE tanggal_kegiatan LIKE '%$keyword%'";
	return query($query);
}

function cariTargetLokasi($keyword){
	$query = "SELECT * FROM arsip_dokumen JOIN kode_rekening ON arsip_dokumen.kode_rekening = kode_rekening.kode_rekening WHERE target_lokasi LIKE '%$keyword%'";
	return query($query);
}

function carikodeRekening($keyword){
	$query = "SELECT * FROM arsip_dokumen JOIN kode_rekening ON arsip_dokumen.kode_rekening = kode_rekening.kode_rekening WHERE arsip_dokumen.kode_rekening LIKE '%$keyword%'";
	return query($query);
}

function carikegiatan($keyword){
	$query = "SELECT * FROM arsip_dokumen JOIN kode_rekening ON arsip_dokumen.kode_rekening = kode_rekening.kode_rekening WHERE kegiatan LIKE '%$keyword%'";
	return query($query);
}

function carikodeRekening1($keyword){
	$query = "SELECT * FROM kode_rekening WHERE kode_rekening LIKE '%$keyword%'";
	return query($query);
}

function cariDeskripsiRekening1($keyword){
	$query = "SELECT * FROM kode_rekening WHERE deskripsi_rekening LIKE '%$keyword%'";
	return query($query);
}

function carikegiatan1($keyword){
	$query = "SELECT * FROM kegiatan WHERE kegiatan LIKE '%$keyword%'";
	return query($query);
}

function cariSubkegiatan1($keyword){
	$query = "SELECT * FROM kegiatan WHERE sub_kegiatan LIKE '%$keyword%'";
	return query($query);
}

function cariAkun($keyword){
	$query = "SELECT * FROM user WHERE 
		username LIKE '%$keyword%' OR
		password LIKE '%$keyword%' OR
		nama LIKE '%$keyword%' OR
		akses LIKE '%$keyword%'
		";
	return query($query);
}

function salam() {
	date_default_timezone_set("Asia/Jakarta");

	$b = time();
	$hour = date("G",$b);

	if ($hour>=0 && $hour<=10)
	{
	echo "Selamat Pagi, Selalu Cek dengan teliti data yang akan diinput ya kak ";
	}
	elseif ($hour >=10 && $hour<=14)
	{
	echo "Selamat Siang, Selalu Cek dengan teliti data yang akan diinput ya kak";
	}
	elseif ($hour >=14 && $hour<=18)
	{
	echo "Selamat Sore, Selalu Cek dengan teliti data yang akan diinput ya kak ";
	}

	elseif ($hour >=18 && $hour<24)
	{
	echo "Selamat Malam, Selalu Cek dengan teliti data yang akan diinput ya kak ";
	}

}


 ?>
