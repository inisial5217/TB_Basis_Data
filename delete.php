<?php
include 'db.php';

if (isset($_GET['nim'])) {
    $nim = escape($_GET['nim']);
    
    // Validasi keberadaan data
    $check = $conn->query("SELECT nim FROM data_mahasiswa WHERE nim = '$nim'");
    if ($check->num_rows == 0) {
        die("Data tidak ditemukan!");
    }

    // Eksekusi delete
    if ($conn->query("DELETE FROM data_mahasiswa WHERE nim = '$nim'")) {
        header("Location: index.php?success=1");
        exit();
    } else {
        die("Error: " . $conn->error);
    }
} else {
    die("Akses tidak valid!");
}
?>