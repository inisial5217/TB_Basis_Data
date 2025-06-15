<?php
include 'db.php';

if (isset($_GET['kode_mk'])) {
    $kode_mk = escape($_GET['kode_mk']);
    
    // Validasi keberadaan data mata kuliah
    $check = $conn->query("SELECT kode_mk FROM matkul WHERE kode_mk = '$kode_mk'");
    if ($check->num_rows == 0) {
        header("Location: index.php?error=Data mata kuliah tidak ditemukan");
        exit();
    }

    // Mulai transaction
    $conn->begin_transaction();
    
    try {
        // 1. Hapus data nilai terkait
        $conn->query("DELETE FROM nilai_mahasiswa WHERE kode_mk = '$kode_mk'");
        
        // 2. Hapus mata kuliah
        $conn->query("DELETE FROM matkul WHERE kode_mk = '$kode_mk'");
        
        // Commit transaction jika sukses
        $conn->commit();
        header("Location: index.php?success=Mata kuliah dan data nilai terkait berhasil dihapus");
    } catch (Exception $e) {
        // Rollback jika ada error
        $conn->rollback();
        header("Location: index.php?error=Gagal menghapus: " . urlencode($e->getMessage()));
    }
    exit();
} else {
    header("Location: index.php?error=Akses tidak valid");
    exit();
}
?>