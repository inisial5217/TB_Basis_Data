<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
require_once 'db.php';

// Cek parameter
if (!isset($_GET['nim']) || !isset($_GET['kode_mk'])) {
    die("Parameter nim dan kode mata kuliah diperlukan!");
}

$nim = $_GET['nim'];
$kode_mk = $_GET['kode_mk'];

// Ambil data
$sql = "SELECT n.*, m.nama, mk.nama_mk as mata_kuliah, d.nama_dosen 
        FROM nilai_mahasiswa n
        JOIN data_mahasiswa m ON n.nim = m.nim
        JOIN matkul mk ON n.kode_mk = mk.kode_mk
        JOIN dosen d ON n.nidn = d.nidn
        WHERE n.nim = ? AND n.kode_mk = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nim, $kode_mk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Data nilai tidak ditemukan!");
}

$data = $result->fetch_assoc();

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nilai = $_POST['nilai'];

    if (!is_numeric($nilai)) {
        $error = "Nilai harus berupa angka.";
    } else {
        $update_sql = "UPDATE nilai_mahasiswa SET nilai = ? WHERE nim = ? AND kode_mk = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("dss", $nilai, $nim, $kode_mk);

        if ($update_stmt->execute()) {
            // Redirect setelah 2 detik dengan pesan sukses
            header("Refresh: 2; url=index.php?success=Nilai berhasil diupdate");
            $success = "Nilai berhasil diupdate! Anda akan kembali ke halaman utama...";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $nim, $kode_mk);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
        } else {
            $error = "Gagal mengupdate data: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Nilai Mahasiswa</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 60px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #f9f9f9;
        }

        input[readonly] {
            background-color: #e9ecef;
            color: #495057;
        }

        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        button,
        a.button {
            padding: 10px 18px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button {
            background-color: #28a745;
            color: white;
        }

        button:hover {
            background-color: #218838;
        }

        a.button {
            background-color: #dc3545;
            color: white;
        }

        a.button:hover {
            background-color: #c82333;
        }

        /* Animasi untuk pesan sukses */
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0.7; }
        }
        
        .redirect-message {
            animation: fadeOut 1s ease-in-out infinite alternate;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Nilai Mahasiswa</h2>

        <?php if (isset($success)): ?>
            <div class="alert success redirect-message"><?= $success ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>NIM:</label>
                <input type="text" value="<?= htmlspecialchars($data['nim']) ?>" readonly>
            </div>

            <div class="form-group">
                <label>Nama Mahasiswa:</label>
                <input type="text" value="<?= htmlspecialchars($data['nama']) ?>" readonly>
            </div>

            <div class="form-group">
                <label>Mata Kuliah:</label>
                <input type="text" value="<?= htmlspecialchars($data['mata_kuliah']) ?>" readonly>
            </div>

            <div class="form-group">
                <label>Dosen:</label>
                <input type="text" value="<?= htmlspecialchars($data['nama_dosen']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="nilai">Nilai:</label>
                <input type="number" id="nilai" name="nilai" min="0" max="100" step="0.1"
                       value="<?= htmlspecialchars($data['nilai']) ?>" required>
            </div>

            <div class="buttons">
                <button type="submit">💾 Update Data</button>
                <a href="index.php" class="button">❌ Batal</a>
            </div>
        </form>
    </div>
</body>
</html>