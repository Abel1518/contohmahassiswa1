<?php
include "koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];

switch($method){

case "GET":

    $sql = "SELECT * FROM tabel_mahasiswa";
    $result = $conn->query($sql);

    $data = [];

    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }

    echo json_encode($data);
break;

case "POST":

    $input = json_decode(file_get_contents("php://input"), true);

    $stmt = $conn->prepare(
        "INSERT INTO tabel_mahasiswa
        (nim,nama_mahasiswa,prodi,ipk)
        VALUES (?,?,?,?)"
    );

    $stmt->bind_param(
        "sssd",
        $input['nim'],
        $input['nama_mahasiswa'],
        $input['prodi'],
        $input['ipk']
    );

    $stmt->execute();

    echo json_encode([
        "status"=>true,
        "message"=>"Data mahasiswa berhasil ditambahkan"
    ]);

break;

case "PUT":

    $input = json_decode(file_get_contents("php://input"), true);

    $stmt = $conn->prepare(
        "UPDATE tabel_mahasiswa
        SET nim=?, nama_mahasiswa=?, prodi=?, ipk=?
        WHERE id_mahasiswa=?"
    );

    $stmt->bind_param(
        "sssdi",
        $input['nim'],
        $input['nama_mahasiswa'],
        $input['prodi'],
        $input['ipk'],
        $input['id_mahasiswa']
    );

    $stmt->execute();

    echo json_encode([
        "status"=>true,
        "message"=>"Data mahasiswa berhasil diubah"
    ]);

break;

case "DELETE":

    $input = json_decode(file_get_contents("php://input"), true);

    $stmt = $conn->prepare(
        "DELETE FROM tabel_mahasiswa
        WHERE id_mahasiswa=?"
    );

    $stmt->bind_param(
        "i",
        $input['id_mahasiswa']
    );

    $stmt->execute();

    echo json_encode([
        "status"=>true,
        "message"=>"Data mahasiswa berhasil dihapus"
    ]);

break;
}
?>
