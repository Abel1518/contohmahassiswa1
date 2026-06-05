<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include "koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];

switch($method){

case "GET":
    $result = $conn->query(
        "SELECT * FROM tabel_periode_wisuda"
    );

    $data=[];

    if ($result) {
        while($row=$result->fetch_assoc()){
            $data[]=$row;
        }
    }

    echo json_encode([
        "status" => true,
        "message" => "Data periode berhasil diambil",
        "total_data" => count($data),
        "data" => $data
    ], JSON_PRETTY_PRINT);
break;

case "POST":

    $input=json_decode(file_get_contents("php://input"),true);

    if (
        empty($input['tahun_periode']) ||
        empty($input['tanggal_pelaksanaan']) ||
        empty($input['kuota_maksimal'])
    ) {
        echo json_encode([
            "status" => false,
            "message" => "Semua data wajib diisi"
        ], JSON_PRETTY_PRINT);
        exit;
    }

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

    if ($stmt->execute()) {
        echo json_encode([
            "status"=>true,
            "message"=>"Data periode berhasil ditambahkan"
        ], JSON_PRETTY_PRINT);
    } else {
        echo json_encode([
            "status"=>false,
            "message"=>$stmt->error
        ], JSON_PRETTY_PRINT);
    }
break;

case "PUT":

    $input=json_decode(file_get_contents("php://input"),true);

    if (
        empty($input['id_periode']) ||
        empty($input['tahun_periode']) ||
        empty($input['tanggal_pelaksanaan']) ||
        empty($input['kuota_maksimal'])
    ) {
        echo json_encode([
            "status" => false,
            "message" => "Semua data wajib diisi"
        ], JSON_PRETTY_PRINT);
        exit;
    }

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

    if ($stmt->execute()) {
        echo json_encode([
            "status"=>true,
            "message"=>"Data periode berhasil diubah"
        ], JSON_PRETTY_PRINT);
    } else {
        echo json_encode([
            "status"=>false,
            "message"=>$stmt->error
        ], JSON_PRETTY_PRINT);
    }
break;

case "DELETE":

    $input=json_decode(file_get_contents("php://input"),true);

    if (empty($input['id_periode'])) {
        echo json_encode([
            "status" => false,
            "message" => "ID periode wajib diisi"
        ], JSON_PRETTY_PRINT);
        exit;
    }

    $stmt=$conn->prepare(
        "DELETE FROM tabel_periode_wisuda
        WHERE id_periode=?"
    );

    $stmt->bind_param(
        "i",
        $input['id_periode']
    );

    if ($stmt->execute()) {
        echo json_encode([
            "status"=>true,
            "message"=>"Data periode berhasil dihapus"
        ], JSON_PRETTY_PRINT);
    } else {
        echo json_encode([
            "status"=>false,
            "message"=>$stmt->error
        ], JSON_PRETTY_PRINT);
    }
break;

default:
    echo json_encode([
        "status" => false,
        "message" => "Method tidak didukung"
    ], JSON_PRETTY_PRINT);
break;
}

$conn->close();
?>
