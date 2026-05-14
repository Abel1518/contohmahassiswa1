<?php

// Mengizinkan akses dari semua device/domain
header("Access-Control-Allow-Origin: *");

// Format output JSON
header("Content-Type: application/json; charset=UTF-8");

// Method yang diizinkan
header("Access-Control-Allow-Methods: GET");


include 'koneksi.php';


$data = array();


$sql = "SELECT * FROM buku";

$query = mysqli_query($conn, $sql);


if ($query) {

    while($row = mysqli_fetch_assoc($query)) {

        $data[] = [
            "id" => $row['id'],
            "judul_buku" => $row['judul_buku'],
            "penulis" => $row['penulis'],
            "tahun_terbit" => $row['tahun_terbit']
        ];

    }

}

echo json_encode($data, JSON_PRETTY_PRINT);

mysqli_close($conn);

?>