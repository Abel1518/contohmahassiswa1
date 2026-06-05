<?php

header("Content-Type: application/json");
include "koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case "GET":

        $result = $conn->query("SELECT * FROM tabel_staf_verifikator");

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode($data);

    break;

    case "POST":

        $input = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare("
            INSERT INTO tabel_staf_verifikator
            (nama_staf, divisi)
            VALUES (?, ?)
        ");

        $stmt->bind_param(
            "ss",
            $input['nama_staf'],
            $input['divisi']
        );

        $stmt->execute();

        echo json_encode([
            "status" => true,
            "message" => "Data staf berhasil ditambahkan"
        ]);

    break;

    case "PUT":

        $input = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare("
            UPDATE tabel_staf_verifikator
            SET nama_staf = ?, divisi = ?
            WHERE id_staf = ?
        ");

        $stmt->bind_param(
            "ssi",
            $input['nama_staf'],
            $input['divisi'],
            $input['id_staf']
        );

        $stmt->execute();

        echo json_encode([
            "status" => true,
            "message" => "Data staf berhasil diubah"
        ]);

    break;

    case "DELETE":

        $input = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare("
            DELETE FROM tabel_staf_verifikator
            WHERE id_staf = ?
        ");

        $stmt->bind_param(
            "i",
            $input['id_staf']
        );

        $stmt->execute();

        echo json_encode([
            "status" => true,
            "message" => "Data staf berhasil dihapus"
        ]);

    break;
}
?>
