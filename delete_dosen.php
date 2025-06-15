<?php
include 'db.php';

if (isset($_GET['nidn'])) {
    $nidn = escape($_GET['nidn']);
    
    // Validasi keberadaan data
    $check = $conn->query("SELECT nidn FROM dosen WHERE nidn = '$nidn'");
    if ($check->num_rows == 0) {
        die("Data tidak ditemukan!");
    }

    // Eksekusi delete
    if ($conn->query("DELETE FROM dosen WHERE nidn = '$nidn'")) {
        header("Location: index.php?success=1");
        exit();
    } else {
        die("Error: " . $conn->error);
    }
} else {
    die("Akses tidak valid!");
}
?>