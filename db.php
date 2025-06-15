<?php
// Koneksi Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistem_akademik_mahasiswa";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Fungsi escape dengan double protection
function escape($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Pastikan tabel ada
$conn->query("CREATE TABLE IF NOT EXISTS data_mahasiswa (
    nim VARCHAR(10) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    kelas VARCHAR(20),
    jurusan VARCHAR(50)
)");
?>