<?php include 'db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_mk = escape($_POST['kode_mk']);
    $nama_mk = escape($_POST['nama_mk']);
    $sks = escape($_POST['sks']);
    $nidn = escape($_POST['nidn']);

    // Validasi Kode MK unik
    $check = $conn->query("SELECT kode_mk FROM matkul WHERE kode_mk = '$kode_mk'");
    if ($check->num_rows > 0) {
        $error = "Kode Mata Kuliah sudah terdaftar!";
    } else {
        $sql = "INSERT INTO matkul (kode_mk, nama_mk, sks, nidn) 
                VALUES ('$kode_mk', '$nama_mk', '$sks', '$nidn')";
        
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
    <title>Tambah Mata Kuliah</title>
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
        <h1>➕ Tambah Mata Kuliah Baru</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Kode Mata Kuliah:</label>
                <input type="text" name="kode_mk" maxlength="10" required>
            </div>
            
            <div class="form-group">
                <label>Nama Mata Kuliah:</label>
                <input type="text" name="nama_mk" required>
            </div>
            
            <div class="form-group">
                <label>SKS:</label>
                <input type="number" name="sks" min="1" max="6" required>
            </div>
            
            <div class="form-group">
                <label>Dosen Pengajar:</label>
                <select name="nidn" required>
                    <option value="">Pilih Dosen</option>
                    <?php
                    $dosens = $conn->query("SELECT * FROM dosen");
                    while ($dosen = $dosens->fetch_assoc()):
                    ?>
                    <option value="<?= $dosen['nidn'] ?>"><?= $dosen['nidn'] ?> - <?= $dosen['nama_dosen'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <button type="submit" class="btn">💾 Simpan Data</button>
            <a href="index.php" class="btn btn-danger">❌ Batal</a>
        </form>
    </div>
</body>
</html>