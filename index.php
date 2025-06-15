<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akademik</title>
    <style>
        /* === GLOBAL STYLE === */
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        h1, h2 {
            color: #2c3e50;
        }
        a {
            text-decoration: none;
            color: #3498db;
        }
        a:hover {
            text-decoration: underline;
        }

        /* === TABLE STYLE === */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e3f2fd;
        }

        /* === BUTTON & FORM STYLE === */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            border-radius: 4px;
            margin: 5px 0;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-danger {
            background-color: #e74c3c;
        }
        .btn-success {
            background-color: #2ecc71;
        }
        .btn-warning {
            background-color: #f39c12;
        }
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* === LAYOUT === */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .section {
            margin-bottom: 40px;
            padding: 20px;
            background: white;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 Sistem Akademik Mahasiswa</h1>

        <!-- ========== DATA MAHASISWA ========== -->
        <div class="section">
            <div class="section-title">
                <h2> Data Mahasiswa</h2>
                <a href="create.php" class="btn btn-success">➕ Tambah Mahasiswa</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM data_mahasiswa";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['nim']}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['kelas']}</td>
                                <td>{$row['jurusan']}</td>
                                <td>
                                    <a href='edit.php?nim={$row['nim']}' class='btn'>✏️ Edit</a>
                                    <a href='delete.php?nim={$row['nim']}' class='btn btn-danger' onclick='return confirm(\"Yakin hapus data mahasiswa?\")'>🗑️ Hapus</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='no-data'>Tidak ada data mahasiswa</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- ========== DATA DOSEN ========== -->
        <div class="section">
            <div class="section-title">
                <h2>Data Dosen</h2>
                <a href="create_dosen.php" class="btn btn-success">➕ Tambah Dosen</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>NIDN</th>
                        <th>Nama Dosen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM dosen";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['nidn']}</td>
                                <td>{$row['nama_dosen']}</td>
                                <td>
                                    <a href='edit_dosen.php?nidn={$row['nidn']}' class='btn'>✏️ Edit</a>
                                    <a href='delete_dosen.php?nidn={$row['nidn']}' class='btn btn-danger' onclick='return confirm(\"Yakin hapus data dosen?\")'>🗑️ Hapus</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='no-data'>Tidak ada data dosen</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- ========== DATA MATA KULIAH ========== -->
        <div class="section">
            <div class="section-title">
                <h2>Data Mata Kuliah</h2>
                <a href="create_matkul.php" class="btn btn-success">➕ Tambah Matkul</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Kode MK</th>
                        <th>Nama MK</th>
                        <th>Dosen Pengajar</th>
                        <th>SKS</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT matkul.*, dosen.nama_dosen 
                            FROM matkul 
                            LEFT JOIN dosen ON matkul.nidn = dosen.nidn";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['kode_mk']}</td>
                                <td>{$row['nama_mk']}</td>
                                <td>{$row['nama_dosen']} ({$row['nidn']})</td>
                                <td>{$row['sks']}</td>
                                <td>
                                    <a href='edit_matkul.php?kode_mk={$row['kode_mk']}' class='btn'>✏️ Edit</a>
                                    <a href='delete_matkul.php?kode_mk={$row['kode_mk']}' class='btn btn-danger' onclick='return confirm(\"Yakin hapus mata kuliah?\")'>🗑️ Hapus</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='no-data'>Tidak ada data mata kuliah</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- ========== DATA NILAI ========== -->
        <div class="section">
            <div class="section-title">
                <h2>Data Nilai Mahasiswa</h2>
                <a href="create_nilai.php" class="btn btn-success">➕ Tambah Nilai</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Nilai</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT n.*, m.nama as nama_mahasiswa, mk.nama_mk, d.nama_dosen 
                            FROM nilai_mahasiswa n
                            JOIN data_mahasiswa m ON n.nim = m.nim
                            JOIN matkul mk ON n.kode_mk = mk.kode_mk
                            JOIN dosen d ON n.nidn = d.nidn";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                        $nilai = $row['nilai'];
                        $keterangan = ($nilai < 60) ? "Tidak Lulus" : "Lulus";
                        echo "<tr>
                            <td>{$row['nim']}</td>
                            <td>{$row['nama_mahasiswa']}</td>
                            <td>{$row['nama_mk']}</td>
                            <td>{$row['nama_dosen']}</td>
                            <td>{$row['nilai']}</td>
                            <td>$keterangan</td>
                            <td>
                                <a href='edit_nilai.php?nim={$row['nim']}&kode_mk={$row['kode_mk']}' class='btn'>✏️ Edit</a>
                                <a href='delete_nilai.php?nim={$row['nim']}&kode_mk={$row['kode_mk']}' class='btn btn-danger' onclick='return confirm(\"Yakin hapus?\")'>🗑️ Hapus</a>
                            </td>
                        </tr>";
}

                    } else {
                        echo "<tr><td colspan='6' class='no-data'>Tidak ada data nilai</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
