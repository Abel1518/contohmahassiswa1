<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");


include 'koneksi.php';


$data = array();


$sql = "
SELECT
    buku.judul_buku,
    COUNT(peminjaman.id) AS total_dipinjam
FROM peminjaman
JOIN buku
ON peminjaman.buku_id = buku.id
WHERE peminjaman.tanggal_pinjam
BETWEEN '2026-05-01' AND '2026-05-07'
GROUP BY buku.judul_buku
";

// Jalankan query
$query = mysqli_query($conn, $sql);



if ($query) {

    while($row = mysqli_fetch_assoc($query)) {

        $data[] = [
            "judul_buku" => $row['judul_buku'],
            "total_dipinjam" => $row['total_dipinjam']
        ];

    }

}


echo json_encode($data, JSON_PRETTY_PRINT);



mysqli_close($conn);

?>