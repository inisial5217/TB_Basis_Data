<?php include 'db.php'; ?>

<?php
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_dosen'])) {
        // Dosen form submission
        $nidn = escape($_POST['nidn']);
        $nama_dosen = escape($_POST['nama_dosen']);

        $check = $conn->query("SELECT nidn FROM dosen WHERE nidn = '$nidn'");
        if ($check->num_rows > 0) {
            $error_dosen = "NIDN sudah terdaftar!";
        } else {
            $sql = "INSERT INTO dosen (nidn, nama_dosen) VALUES ('$nidn', '$nama_dosen')";
            
            if ($conn->query($sql)) {
                header("Location: index.php?success=dosen");
                exit();
            } else {
                $error_dosen = "Error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Akademik</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
        }
        
        /* Form Styles */
        .form-container {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
            display: block; /* Always visible */
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
            font-size: 16px;
        }
        .btn {
            padding: 10px 15px;
            background-color: #3498db;
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
        .btn-success {
            background-color: #2ecc71;
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
        <h1>➕ Tambah Dosen</h1>
        
        <div id="dosen" class="form-container">
            <?php if (isset($error_dosen)): ?>
                <div class="error"><?= $error_dosen ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>NIDN:</label>
                    <input type="text" name="nidn" maxlength="20" required>
                </div>
                
                <div class="form-group">
                    <label>Nama Dosen:</label>
                    <input type="text" name="nama_dosen" required>
                </div>
                
                <button type="submit" name="add_dosen" class="btn btn-success">💾 Simpan</button>
                <a href="index.php" class="btn btn-danger">❌ Batal</a>
            </form>
        </div>
    </div>

</body>
</html>