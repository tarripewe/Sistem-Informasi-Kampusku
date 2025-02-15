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
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tempat Lahir:</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Fakultas:</label>
                <select name="fakultas" class="form-control" required>
                    <option value="" disabled selected>Pilih Fakultas</option>
                    <option value="Teknik">Teknik</option>
                    <option value="Ekonomi">Ekonomi</option>
                    <option value="Kedokteran">Kedokteran</option>
                    <option value="Ilmu Komputer">Ilmu Komputer</option>
                    <option value="Hukum">Hukum</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Jurusan:</label>
                <select name="jurusan" class="form-control" required>
                    <option value="" disabled selected>Pilih Jurusan</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Manajemen">Manajemen</option>
                    <option value="Akuntansi">Akuntansi</option>
                    <option value="Kedokteran Umum">Kedokteran Umum</option>
                    <option value="Ilmu Hukum">Ilmu Hukum</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">IPK:</label>
                <input type="text" name="ipk" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-maroon w-100">Tambah Data</button>
        </form>
    </div>
</body>
</html>
