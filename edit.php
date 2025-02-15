<?php
include 'config.php'; // Koneksi database

// Cek apakah parameter id_mahasiswa tersedia
if (isset($_GET['id_mahasiswa'])) {
    $id_mahasiswa = $_GET['id_mahasiswa'];

    // Ambil data mahasiswa berdasarkan id_mahasiswa
    $query = "SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $mahasiswa = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='mahasiswa.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak disediakan!'); window.location='mahasiswa.php';</script>";
    exit;
}

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nim            = $_POST['nim'];
    $nama_mahasiswa = $_POST['nama_mahasiswa'];
    $tempat_lahir   = $_POST['tempat_lahir'];
    $tanggal_lahir  = $_POST['tanggal_lahir'];
    $fakultas       = $_POST['fakultas'];
    $jurusan        = $_POST['jurusan'];
    $ipk            = floatval($_POST['ipk']);

    // Validasi IPK: harus berupa angka antara 0.00 hingga 4.00
    if (!is_numeric($ipk) || $ipk < 0 || $ipk > 4) {
        die("Error: IPK harus berupa angka antara 0.00 hingga 4.00");
    }

    // Query UPDATE untuk mengubah data mahasiswa
    $updateQuery = "UPDATE mahasiswa SET 
                        nim = '$nim',
                        nama_mahasiswa = '$nama_mahasiswa',
                        tempat_lahir = '$tempat_lahir',
                        tanggal_lahir = '$tanggal_lahir',
                        fakultas = '$fakultas',
                        jurusan = '$jurusan',
                        ipk = '$ipk'
                    WHERE id_mahasiswa = '$id_mahasiswa'";

    if (mysqli_query($conn, $updateQuery)) {
        // Jika update berhasil, tampilkan modal sukses dan redirect setelah 2 detik
        echo '
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Berhasil Update</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <style>
                /* Warna tema maroon */
                .modal-header, .modal-footer {
                    background-color: #800000;
                }
                .modal-title, .modal-footer .btn {
                    color: #fff;
                }
                .modal-body {
                    background-color: #f8f9fa;
                    color: #800000;
                }
            </style>
        </head>
        <body>
            <!-- Modal Sukses -->
            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Berhasil</h5>
                  </div>
                  <div class="modal-body">
                    Data berhasil diubah !
                  </div>
                </div>
              </div>
            </div>
            <script>
                var myModal = new bootstrap.Modal(document.getElementById("successModal"));
                myModal.show();
                setTimeout(function(){
                    window.location = "mahasiswa.php";
                }, 2000);
            </script>
        </body>
        </html>
        ';
        exit;
    } else {
        echo "Error: " . $updateQuery . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
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
        <h2>Edit Data Mahasiswa</h2>
        <form id="editForm" method="POST">
            <div class="mb-3">
                <label class="form-label">NIM:</label>
                <input type="number" name="nim" class="form-control" required value="<?php echo htmlspecialchars($mahasiswa['nim']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap:</label>
                <input type="text" name="nama_mahasiswa" class="form-control" required value="<?php echo htmlspecialchars($mahasiswa['nama_mahasiswa']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Tempat Lahir:</label>
                <input type="text" name="tempat_lahir" class="form-control" required value="<?php echo htmlspecialchars($mahasiswa['tempat_lahir']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" class="form-control" required value="<?php echo htmlspecialchars($mahasiswa['tanggal_lahir']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Fakultas:</label>
                <input type="text" name="fakultas" class="form-control" required value="<?php echo htmlspecialchars($mahasiswa['fakultas']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Jurusan:</label>
                <input type="text" name="jurusan" class="form-control" required value="<?php echo htmlspecialchars($mahasiswa['jurusan']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">IPK:</label>
                <input type="number" name="ipk" class="form-control" step="0.01" required value="<?php echo htmlspecialchars($mahasiswa['ipk']); ?>">
            </div>
            <button type="submit" name="submit" class="btn btn-maroon w-100">Update Data</button>
        </form>
    </div>
</body>
</html>
