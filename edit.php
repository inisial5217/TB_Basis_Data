<?php 
include 'db.php';

// Ambil data yang akan diedit
$nim = escape($_GET['nim']);
$result = $conn->query("SELECT * FROM data_mahasiswa WHERE nim = '$nim'");
$row = $result->fetch_assoc();

if (!$row) {
    die("Data mahasiswa tidak ditemukan!");
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_nim = escape($_POST['nim']);  // NIM baru dari form
    $nama = escape($_POST['nama']);
    $kelas = escape($_POST['kelas']);
    $jurusan = escape($_POST['jurusan']);

    // Validasi jika NIM diubah
    if ($new_nim != $nim) {
        // Cek apakah NIM baru sudah digunakan
        $check = $conn->query("SELECT nim FROM data_mahasiswa WHERE nim = '$new_nim'");
        if ($check->num_rows > 0) {
            $error = "NIM baru sudah terdaftar!";
        } else {
            // Update termasuk NIM baru
            $sql = "UPDATE data_mahasiswa SET 
                    nim = '$new_nim',
                    nama = '$nama', 
                    kelas = '$kelas', 
                    jurusan = '$jurusan' 
                    WHERE nim = '$nim'";
            
            if ($conn->query($sql)) {
                header("Location: index.php?success=1");
                exit();
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    } else {
        // Jika NIM tidak diubah
        $sql = "UPDATE data_mahasiswa SET 
                nama = '$nama', 
                kelas = '$kelas', 
                jurusan = '$jurusan' 
                WHERE nim = '$nim'";
        
        if ($conn->query($sql)) {
            header("Location: index.php?success=1");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .warning {
            color: #ff9800;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Data Mahasiswa</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label>NIM:</label>
                <input type="text" name="nim" value="<?= htmlspecialchars($row['nim']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Kelas:</label>
                <input type="text" name="kelas" value="<?= htmlspecialchars($row['kelas']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Jurusan:</label>
                <input type="text" name="jurusan" value="<?= htmlspecialchars($row['jurusan']) ?>" required>
            </div>
            
            <button type="submit" class="btn">Update Data</button>
            <a href="index.php" style="margin-left: 10px;">Kembali</a>
        </form>
    </div>
</body>
</html>