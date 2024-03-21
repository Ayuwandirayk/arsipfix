<?php
// Set header type konten.
header("Content-Type: application/json; charset=UTF-8");

require 'functions.php';

// Deklarasi variable keyword kode_rekening.
$kode_rekening = $_GET["query"];

// Query ke database.
$query  = $koneksi->query("SELECT * FROM kode_rekening WHERE kode_rekening LIKE '%$kode_rekening%' ORDER BY kode_rekening ASC");
$result = $query->fetch_all(MYSQLI_ASSOC);

// Format bentuk data untuk autocomplete.
foreach($result as $data) {
    $output['suggestions'][] = [
        'value' => $data['kode_rekening'],
        'kode_rekening'  => $data['kode_rekening']
    ];
}

if (! empty($output)) {
    // Encode ke format JSON.
    echo json_encode($output);
}else{
	$output['suggestions'] = '';
	echo json_encode($output);
}

?>