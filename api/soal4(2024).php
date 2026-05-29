<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'koneksi.php';

$data = array();

$sql = "
SELECT
    peminjaman.nama_peminjam,
    buku.judul_buku,
    buku.penulis,
    peminjaman.tanggal_pinjam,
    buku.tahun_terbit
FROM peminjaman
JOIN buku
ON peminjaman.buku_id = buku.id
WHERE buku.tahun_terbit = 2024
";

$query = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($query)) {

    $data[] = $row;

}

echo json_encode($data, JSON_PRETTY_PRINT);

mysqli_close($conn);

?>