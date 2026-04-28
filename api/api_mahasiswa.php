<?php
// Set header agar output dikenali sebagai JSON dan mengizinkan CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Menyertakan file koneksi database
include 'koneksi.php';

$data = array();

// Proses query untuk mengambil seluruh data mahasiswa
$query = mysqli_query($conn, "SELECT * FROM mahasiswa");

// Jika query berhasil, masukkan setiap baris ke dalam array $data
if ($query) {
    while($row = mysqli_fetch_assoc($query)){
        $data[] = $row;
    }
}

// Convert array ke format JSON dengan visual yang rapi (pretty print)
echo json_encode($data, JSON_PRETTY_PRINT);
?>
