<?php
include 'db.php';

if (isset($_GET['nim']) && isset($_GET['kode_mk'])) {
    $nim = $_GET['nim'];
    $kode_mk = $_GET['kode_mk'];

    $stmt = $conn->prepare("DELETE FROM nilai_mahasiswa WHERE nim = ? AND kode_mk = ?");
    $stmt->bind_param("ss", $nim, $kode_mk);
    $stmt->execute();

    // Redirect kembali ke index setelah hapus
    header("Location: index.php");
    exit;
} else {
    echo "Parameter tidak lengkap.";
}
?>
