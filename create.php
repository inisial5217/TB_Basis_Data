<?php include 'db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = escape($_POST['nim']);
    $nama = escape($_POST['nama']);
    $kelas = escape($_POST['kelas']);
    $jurusan = escape($_POST['jurusan']);

    // Validasi NIM unik
    $check = $conn->query("SELECT nim FROM data_mahasiswa WHERE nim = '$nim'");
    if ($check->num_rows > 0) {
        $error = "NIM sudah terdaftar!";
    } else {
        $sql = "INSERT INTO data_mahasiswa (nim, nama, kelas, jurusan) 
                VALUES ('$nim', '$nama', '$kelas', '$jurusan')";
        
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
    <title>Tambah Mahasiswa Baru</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background-color: white;
            width: 90%;
            max-width: 600px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
            font-size: 24px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2c3e50;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }
        .btn-simpan {
            background-color: #3498db;
            color: white;
        }
        .btn-batal {
            background-color: #e74c3c;
            color: white;
        }
        .error {
            color: #e74c3c;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>➕ Tambah Mahasiswa Baru</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>NIM:</label>
                <input type="text" name="nim" maxlength="10" required>
            </div>
            
            <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" required>
            </div>
            
            <div class="form-group">
                <label>Kelas:</label>
                <input type="text" name="kelas" required>
            </div>
            
            <div class="form-group">
                <label>Jurusan:</label>
                <input type="text" name="jurusan" required>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-simpan"> 💾 Simpan Data</button>
                <a href="index.php" class="btn btn-batal"> ❌ Batal</a>
            </div>
        </form>
    </div>
</body>
</html>