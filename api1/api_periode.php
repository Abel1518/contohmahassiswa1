<?php
include "koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];

switch($method){

case "GET":
    $result = $conn->query(
        "SELECT * FROM tabel_periode_wisuda"
    );

    $data=[];

    while($row=$result->fetch_assoc()){
        $data[]=$row;
    }

    echo json_encode($data);
break;

case "POST":

    $input=json_decode(file_get_contents("php://input"),true);

    $stmt=$conn->prepare(
        "INSERT INTO tabel_periode_wisuda
        (tahun_periode,tanggal_pelaksanaan,kuota_maksimal)
        VALUES (?,?,?)"
    );

    $stmt->bind_param(
        "isi",
        $input['tahun_periode'],
        $input['tanggal_pelaksanaan'],
        $input['kuota_maksimal']
    );

    $stmt->execute();

    echo json_encode([
        "status"=>true,
        "message"=>"Data periode berhasil ditambahkan"
    ]);
break;

case "PUT":

    $input=json_decode(file_get_contents("php://input"),true);

    $stmt=$conn->prepare(
        "UPDATE tabel_periode_wisuda
        SET tahun_periode=?,
            tanggal_pelaksanaan=?,
            kuota_maksimal=?
        WHERE id_periode=?"
    );

    $stmt->bind_param(
        "isii",
        $input['tahun_periode'],
        $input['tanggal_pelaksanaan'],
        $input['kuota_maksimal'],
        $input['id_periode']
    );

    $stmt->execute();

    echo json_encode([
        "status"=>true,
        "message"=>"Data periode berhasil diubah"
    ]);
break;

case "DELETE":

    $input=json_decode(file_get_contents("php://input"),true);

    $stmt=$conn->prepare(
        "DELETE FROM tabel_periode_wisuda
        WHERE id_periode=?"
    );

    $stmt->bind_param(
        "i",
        $input['id_periode']
    );

    $stmt->execute();

    echo json_encode([
        "status"=>true,
        "message"=>"Data periode berhasil dihapus"
    ]);
break;
}
?>
