<?php
// Ambil kredensial dari environment variable (set di Vercel Dashboard)
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = getenv('DB_NAME');
$port = (int)(getenv('DB_PORT') ?: 4000);

// TiDB Cloud wajib SSL — gunakan mysqli_real_connect dengan flag SSL
$conn = mysqli_init();

if (!$conn) {
    die(json_encode(['error' => 'mysqli_init gagal']));
}

// Aktifkan SSL (tidak perlu CA cert karena TiDB Cloud menggunakan cert publik)
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

$connected = mysqli_real_connect(
    $conn,
    $host,
    $user,
    $pass,
    $db,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (!$connected) {
    die(json_encode([
        'error' => 'Koneksi gagal: ' . mysqli_connect_error()
    ]));
}

mysqli_set_charset($conn, 'utf8mb4');
?>
