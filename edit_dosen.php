<?php 
include 'db.php';

if (!function_exists('escape')) {
    function escape($data) {
        return htmlspecialchars(trim($data));
    }
}

$nidn_awal = escape($_GET['nidn']);
$dosen = $conn->query("SELECT * FROM dosen WHERE nidn = '$nidn_awal'")->fetch_assoc();

if (!$dosen) {
    die("Data dosen tidak ditemukan!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nidn_baru = escape($_POST['nidn']);
    $nama_dosen = escape($_POST['nama_dosen']);

    // Cek apakah nidn_baru sudah dipakai dosen lain
    if ($nidn_baru !== $nidn_awal) {
        $cek_nidn = $conn->query("SELECT * FROM dosen WHERE nidn = '$nidn_baru'");
        if ($cek_nidn->num_rows > 0) {
            $error = "NIDN baru sudah dipakai oleh dosen lain.";
        }
    }

    if (!isset($error)) {
        $update = $conn->query("UPDATE dosen SET nidn='$nidn_baru', nama_dosen='$nama_dosen' WHERE nidn='$nidn_awal'");
        
        if ($update) {
            header("Location: index.php?success=1");
            exit();
        } else {
            $error = "Gagal memperbarui data dosen.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Dosen</title>
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
        <h2>Edit Dosen</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>NIDN:</label>
                <input type="text" name="nidn" value="<?= htmlspecialchars($dosen['nidn']) ?>" required>
            </div>

            <div class="form-group">
                <label>Nama Dosen:</label>
                <input type="text" name="nama_dosen" value="<?= htmlspecialchars($dosen['nama_dosen']) ?>" required>
            </div>

            <button type="submit" class="btn">💾 Update Data</button>
            <a href="index.php" class="btn btn-danger">❌ Batal</a>
        </form>
    </div>
</body>
</html>