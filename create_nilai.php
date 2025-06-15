<?php include 'db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = escape($_POST['nim']);
    $kode_mk = escape($_POST['kode_mk']);
    $nidn = escape($_POST['nidn']);
    $nilai = escape($_POST['nilai']);

    // Validasi apakah nilai sudah ada
    $check = $conn->query("SELECT * FROM nilai_mahasiswa WHERE nim = '$nim' AND kode_mk = '$kode_mk'");
    if ($check->num_rows > 0) {
        $error = "Nilai untuk mahasiswa ini pada mata kuliah tersebut sudah ada!";
    } else {
        // Validasi range nilai (0-100)
        if ($nilai < 0 || $nilai > 100) {
            $error = "Nilai harus antara 0-100!";
        } else {
            $sql = "INSERT INTO nilai_mahasiswa (nim, kode_mk, nidn, nilai) 
                    VALUES ('$nim', '$kode_mk', '$nidn', '$nilai')";
            
            if ($conn->query($sql)) {
                header("Location: index.php?success=1");
                exit();
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Nilai Mahasiswa</title>
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
        h1 {
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
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .btn-danger {
            background-color: #e74c3c;
        }
        .error {
            color: #e74c3c;
            margin: 10px 0;
            padding: 10px;
            background-color: #fde8e8;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>➕ Tambah Nilai Mahasiswa</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Mahasiswa:</label>
                <select name="nim" required>
                    <option value="">Pilih Mahasiswa</option>
                    <?php
                    $mahasiswa = $conn->query("SELECT * FROM data_mahasiswa");
                    while ($mhs = $mahasiswa->fetch_assoc()):
                    ?>
                    <option value="<?= $mhs['nim'] ?>">
                        <?= $mhs['nim'] ?> - <?= $mhs['nama'] ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Mata Kuliah:</label>
                <select name="kode_mk" required>
                    <option value="">Pilih Mata Kuliah</option>
                    <?php
                    $matkul = $conn->query("SELECT * FROM matkul");
                    while ($mk = $matkul->fetch_assoc()):
                    ?>
                    <option value="<?= $mk['kode_mk'] ?>">
                        <?= $mk['kode_mk'] ?> - <?= $mk['nama_mk'] ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Dosen Pengajar:</label>
                <select name="nidn" required>
                    <option value="">Pilih Dosen</option>
                    <?php
                    $dosens = $conn->query("SELECT * FROM dosen");
                    while ($dosen = $dosens->fetch_assoc()):
                    ?>
                    <option value="<?= $dosen['nidn'] ?>">
                        <?= $dosen['nidn'] ?> - <?= $dosen['nama_dosen'] ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Nilai (0-100):</label>
                <input type="number" name="nilai" min="0" max="100" required>
            </div>
            
            <button type="submit" class="btn">💾 Simpan Nilai</button>
            <a href="index.php" class="btn btn-danger">❌ Batal</a>
        </form>
    </div>
</body>
</html>