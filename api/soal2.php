<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");


include 'koneksi.php';


$data = array();


$sql = "SELECT * FROM peminjaman";

$query = mysqli_query($conn, $sql);


if ($query) {

    while($row = mysqli_fetch_assoc($query)) {

        $data[] = [
            "id" => $row['id'],
            "buku_id" => $row['buku_id'],
            "nama_peminjam" => $row['nama_peminjam'],
            "tanggal_pinjam" => $row['tanggal_pinjam']
        ];

    }

}



echo json_encode($data, JSON_PRETTY_PRINT);


mysqli_close($conn);

?>