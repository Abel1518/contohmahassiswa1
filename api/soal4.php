<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");


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
WHERE buku.tahun_terbit = 2022
";

// Jalankan query
$query = mysqli_query($conn, $sql);



if ($query) {

    while($row = mysqli_fetch_assoc($query)) {

        $data[] = [
            "nama_peminjam" => $row['nama_peminjam'],
            "judul_buku" => $row['judul_buku'],
            "penulis" => $row['penulis'],
            "tanggal_pinjam" => $row['tanggal_pinjam'],
            "tahun_terbit" => $row['tahun_terbit']
        ];

    }

}


echo json_encode($data, JSON_PRETTY_PRINT);


mysqli_close($conn);

?>