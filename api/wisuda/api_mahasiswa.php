<?php

header("Content-Type: application/json; charset=UTF-8");

include "koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case "GET":

        $sql = "SELECT * FROM tabel_mahasiswa";
        $result = $conn->query($sql);

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode([
            "status" => true,
            "message" => "Data mahasiswa berhasil diambil",
            "total_data" => count($data),
            "data" => $data
        ], JSON_PRETTY_PRINT);

    break;


    case "POST":

        $input = json_decode(file_get_contents("php://input"), true);

        if (
            empty($input['nim']) ||
            empty($input['nama_mahasiswa']) ||
            empty($input['prodi']) ||
            empty($input['ipk'])
        ) {

            echo json_encode([
                "status" => false,
                "message" => "Semua data wajib diisi"
            ], JSON_PRETTY_PRINT);

            exit;
        }

        $stmt = $conn->prepare("
            INSERT INTO tabel_mahasiswa
            (nim, nama_mahasiswa, prodi, ipk)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sssd",
            $input['nim'],
            $input['nama_mahasiswa'],
            $input['prodi'],
            $input['ipk']
        );

        if ($stmt->execute()) {

            echo json_encode([
                "status" => true,
                "message" => "Data mahasiswa berhasil ditambahkan"
            ], JSON_PRETTY_PRINT);

        } else {

            echo json_encode([
                "status" => false,
                "message" => $stmt->error
            ], JSON_PRETTY_PRINT);

        }

    break;


    case "PUT":

        $input = json_decode(file_get_contents("php://input"), true);

        if (empty($input['id_mahasiswa'])) {

            echo json_encode([
                "status" => false,
                "message" => "ID mahasiswa wajib diisi"
            ], JSON_PRETTY_PRINT);

            exit;
        }

        $stmt = $conn->prepare("
            UPDATE tabel_mahasiswa
            SET
                nim = ?,
                nama_mahasiswa = ?,
                prodi = ?,
                ipk = ?
            WHERE id_mahasiswa = ?
        ");

        $stmt->bind_param(
            "sssdi",
            $input['nim'],
            $input['nama_mahasiswa'],
            $input['prodi'],
            $input['ipk'],
            $input['id_mahasiswa']
        );

        if ($stmt->execute()) {

            echo json_encode([
                "status" => true,
                "message" => "Data mahasiswa berhasil diubah"
            ], JSON_PRETTY_PRINT);

        } else {

            echo json_encode([
                "status" => false,
                "message" => $stmt->error
            ], JSON_PRETTY_PRINT);

        }

    break;


    case "DELETE":

        $input = json_decode(file_get_contents("php://input"), true);

        if (empty($input['id_mahasiswa'])) {

            echo json_encode([
                "status" => false,
                "message" => "ID mahasiswa wajib diisi"
            ], JSON_PRETTY_PRINT);

            exit;
        }

        $stmt = $conn->prepare("
            DELETE FROM tabel_mahasiswa
            WHERE id_mahasiswa = ?
        ");

        $stmt->bind_param(
            "i",
            $input['id_mahasiswa']
        );

        if ($stmt->execute()) {

            echo json_encode([
                "status" => true,
                "message" => "Data mahasiswa berhasil dihapus"
            ], JSON_PRETTY_PRINT);

        } else {

            echo json_encode([
                "status" => false,
                "message" => $stmt->error
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
