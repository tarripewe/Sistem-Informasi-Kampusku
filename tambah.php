<?php
include 'config.php'; // Memasukkan koneksi database

// Ambil data fakultas dari tabel fakultas
$facQuery = "SELECT * FROM fakultas ORDER BY nama_fakultas ASC";
$facResult = mysqli_query($conn, $facQuery);
if (!$facResult) {
    die("Query fakultas gagal: " . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nim            = $_POST['nim'];
    $nama_mahasiswa = $_POST['nama_mahasiswa'];
    $tempat_lahir   = $_POST['tempat_lahir'];
    $tanggal_lahir  = $_POST['tanggal_lahir'];
    $fakultas       = $_POST['fakultas']; // Berisi id_fakultas
    $jurusan        = $_POST['jurusan'];  // Berisi id_jurusan
    $ipk            = floatval($_POST['ipk']); // Pastikan IPK dalam format angka desimal

    // Validasi: Pastikan IPK adalah angka antara 0.00 hingga 4.00
    if (!is_numeric($ipk) || $ipk < 0 || $ipk > 4) {
        die("Error: IPK harus berupa angka antara 0.00 hingga 4.00");
    }

    // Query untuk menyimpan data mahasiswa ke dalam tabel mahasiswa
    $query = "INSERT INTO mahasiswa (nim, nama_mahasiswa, tempat_lahir, tanggal_lahir, fakultas, jurusan, ipk) 
              VALUES ('$nim', '$nama_mahasiswa', '$tempat_lahir', '$tanggal_lahir', '$fakultas', '$jurusan', '$ipk')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Jika insert berhasil, tampilkan modal sukses dan redirect setelah 2 detik
        echo '
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Berhasil Disimpan</title>
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
                    Data berhasil disimpan!
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
    <!-- Sertakan jQuery untuk AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <script>
        // Fungsi untuk mencegah input selain huruf dan spasi
        function onlyLettersAndSpaces(event) {
            var char = String.fromCharCode(event.which);
            if (!/^[A-Za-z\s]+$/.test(char)) {
                event.preventDefault();
                return false;
            }
            return true;
        }
        // Ketika dropdown fakultas berubah, lakukan AJAX untuk mengambil jurusan yang sesuai
        $(document).ready(function(){
            $("select[name='fakultas']").change(function(){
                var id_fakultas = $(this).val();
                if(id_fakultas !== ''){
                    $.ajax({
                        url: "getJurusan.php",
                        method: "GET",
                        data: { id_fakultas: id_fakultas },
                        success: function(data){
                            $("select[name='jurusan']").html(data);
                        }
                    });
                } else {
                    $("select[name='jurusan']").html('<option value="">Pilih Fakultas terlebih dahulu</option>');
                }
            });
        });
    </script>
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
                <input type="text" name="nama_mahasiswa" class="form-control" 
                       pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi yang diperbolehkan" 
                       required onkeypress="return onlyLettersAndSpaces(event)">
            </div>
            <div class="mb-3">
                <label class="form-label">Tempat Lahir:</label>
                <input type="text" name="tempat_lahir" class="form-control" 
                       pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi yang diperbolehkan" 
                       required onkeypress="return onlyLettersAndSpaces(event)">
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Fakultas:</label>
                <select name="fakultas" class="form-control" required>
                    <option value="">-- Pilih Fakultas --</option>
                    <?php
                    while ($fac = mysqli_fetch_assoc($facResult)) {
                        echo '<option value="' . $fac['id_fakultas'] . '">' . htmlspecialchars($fac['nama_fakultas']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Jurusan:</label>
                <!-- Awalnya kosong, akan diisi berdasarkan pilihan fakultas -->
                <select name="jurusan" class="form-control" required>
                    <option value="">-- Pilih Jurusan --</option>
                </select>
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
