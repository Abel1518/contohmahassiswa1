<?php

header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$pass = "";
$db   = "";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode([
        "status" => false,
        "message" => $conn->connect_error
    ]));
}
?>
