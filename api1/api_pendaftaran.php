<?php

header("Content-Type: application/json");
include "koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case "GET":

        $sql = "
        SELECT
            rp.id_pendaftaran,
            m.nim,
            m.nama_mahasiswa,
            m.prodi,
            p.tahun_periode,
            p.tanggal_pelaksanaan,
            s.nama_staf,
            rp.nomor_kursi,
            rp.status_verifikasi
        FROM tabel_rekap_pendaftaran rp
        JOIN tabel_mahasiswa m
            ON rp.id_mahasiswa = m.id_mahasiswa
        JOIN tabel_periode_wisuda p
            ON rp.id_periode = p.id_periode
        LEFT JOIN tabel_staf_verifikator s
            ON rp.id_staf = s.id_staf
        ";

        $result = $conn->query($sql);

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode($data);

    break;

    case "POST":

        $input = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare("
            INSERT INTO tabel_rekap_pendaftaran
            (
                id_mahasiswa,
                id_periode,
                id_staf,
                nomor_kursi,
                status_verifikasi
            )
            VALUES
            (
                ?,
                ?,
                NULL,
                NULL,
                'Pending'
            )
        ");

        $stmt->bind_param(
            "ii",
            $input['id_mahasiswa'],
            $input['id_periode']
        );

        $stmt->execute();

        echo json_encode([
            "status" => true,
            "message" => "Pendaftaran wisuda berhasil"
        ]);

    break;

    case "PUT":

        $input = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare("
            UPDATE tabel_rekap_pendaftaran
            SET
                id_staf = ?,
                nomor_kursi = ?,
                status_verifikasi = ?
            WHERE id_pendaftaran = ?
        ");

        $stmt->bind_param(
            "issi",
            $input['id_staf'],
            $input['nomor_kursi'],
            $input['status_verifikasi'],
            $input['id_pendaftaran']
        );

        $stmt->execute();

        echo json_encode([
            "status" => true,
            "message" => "Verifikasi berhasil"
        ]);

    break;

    case "DELETE":

        $input = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare("
            DELETE FROM tabel_rekap_pendaftaran
            WHERE id_pendaftaran = ?
        ");

        $stmt->bind_param(
            "i",
            $input['id_pendaftaran']
        );

        $stmt->execute();

        echo json_encode([
            "status" => true,
            "message" => "Pendaftaran berhasil dibatalkan"
        ]);

    break;
}
?>
