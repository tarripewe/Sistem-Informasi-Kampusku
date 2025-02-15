<?php
include 'config.php'; // Memasukkan koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nim            = $_POST['nim'];
    $nama_mahasiswa = $_POST['nama_mahasiswa'];
    $tempat_lahir   = $_POST['tempat_lahir'];
    $tanggal_lahir  = $_POST['tanggal_lahir'];
    $fakultas       = $_POST['fakultas'];
    $jurusan        = $_POST['jurusan'];
    $ipk            = floatval($_POST['ipk']); // Pastikan IPK dalam format angka desimal

    // Validasi: Pastikan IPK adalah angka dan tidak kosong
    if (!is_numeric($ipk) || $ipk < 0 || $ipk > 4) {
        die("Error: IPK harus berupa angka antara 0.00 hingga 4.00");
    }

    // Query untuk menyimpan data mahasiswa ke dalam tabel mahasiswa
    $query = "INSERT INTO mahasiswa (nim, nama_mahasiswa, tempat_lahir, tanggal_lahir, fakultas, jurusan, ipk) 
              VALUES ('$nim', '$nama_mahasiswa', '$tempat_lahir', '$tanggal_lahir', '$fakultas', '$jurusan', '$ipk')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil disimpan!'); window.location='mahasiswa.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            position: relative;
        }

        .btn-maroon {
            background-color: #800000;
            color: white;
            border: none;
        }

        .btn-maroon:hover {
            background-color: #600000;
        }

        h2 {
            color: #800000;
            text-align: center;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 20px;
            color: #800000;
            cursor: pointer;
            text-decoration: none;
        }

        .close-btn:hover {
            color: #600000;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="mahasiswa.php" class="close-btn"><i class="bi bi-x-circle"></i></a>
        <h2>Tambah Data Mahasiswa</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">NIM:</label>
                <input type="number" name="nim" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap:</label>
                <input type="text" name="nama_mahasiswa" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tempat Lahir:</label>
                <input type="text" name="tempat_lahir" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Fakultas:</label>
                <input type="text" name="fakultas" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jurusan:</label>
                <input type="text" name="jurusan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">IPK:</label>
                <input type="number" name="ipk" class="form-control" step="0.01" required>
            </div>

            <button type="submit" name="submit" class="btn btn-maroon w-100">Tambah Data</button>
        </form>
    </div>
</body>

</html>