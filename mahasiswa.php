<?php
include("config.php");

// Jika ada parameter action=delete, lakukan penghapusan data
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_mahasiswa'])) {
    $id = $_GET['id_mahasiswa'];
    // Query DELETE untuk menghapus data mahasiswa berdasarkan id_mahasiswa
    $deleteQuery = "DELETE FROM mahasiswa WHERE id_mahasiswa = '$id'";
    if (mysqli_query($conn, $deleteQuery)) {
        // Jika berhasil, tampilkan modal sukses dan redirect setelah 2 detik
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Berhasil Dihapus</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <style>
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
                    Data berhasil dihapus!
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
        <?php
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
}

// --- Bagian untuk menampilkan data mahasiswa ---

// Konfigurasi pagination
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) { $page = 1; }
$offset = ($page - 1) * $limit;

// Hitung total data mahasiswa
$countQuery = "SELECT COUNT(*) as total FROM mahasiswa";
$countResult = mysqli_query($conn, $countQuery);
$countData = mysqli_fetch_assoc($countResult);
$totalRecords = $countData['total'];
$totalPages = ceil($totalRecords / $limit);

// Ambil data mahasiswa dengan limit dan offset, urutkan secara DESC
$query = "SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f8f8;
      margin: 0;
      padding: 0;
      display: flex;
      height: 100vh;
    }
    .main-content {
      margin-left: 270px;
      padding: 40px;
      width: calc(100% - 270px);
      display: flex;
      align-items: center;
      flex-direction: column;
    }
    .tambah-button {
      padding: 12px 24px;
      background-color: maroon;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      font-size: 16px;
    }
    .tambah-button:hover {
      background-color: #600000;
    }
    .table-container {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
      border: 2px solid maroon;
      text-align: center;
    }
    th, td {
      border: 2px solid maroon;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: maroon;
      color: white;
    }
    .edit-button, .hapus-button {
      padding: 8px 15px;
      font-size: 14px;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      width: 80px;
    }
    .edit-button {
      background-color: #6E8E59;
      color: white;
      margin-right: 5px;
    }
    .hapus-button {
      background-color: #B82132;
      color: white;
    }
    .edit-button:hover {
      background-color: #5a7d4e;
    }
    .hapus-button:hover {
      background-color: #a71d2a;
    }
    /* Styling pagination agar serasi dengan tema maroon */
    .pagination {
      margin-top: 20px;
    }
    .pagination .page-link {
      color: maroon;
      border: 1px solid maroon;
    }
    .pagination .page-item.active .page-link {
      background-color: maroon;
      border-color: maroon;
      color: #fff;
    }
  </style>
  <script>
    // Fungsi untuk memunculkan modal konfirmasi hapus
    function confirmDelete(id) {
      // Simpan ID dalam tombol "Ya" agar bisa digunakan saat menghapus
      document.getElementById("confirmDeleteBtn").setAttribute("data-id", id);
      // Tampilkan modal konfirmasi hapus
      var myModal = new bootstrap.Modal(document.getElementById("deleteModal"));
      myModal.show();
    }
    // Jika tombol "Ya" ditekan pada modal, redirect ke URL dengan parameter delete
    function deleteData() {
      var id = document.getElementById("confirmDeleteBtn").getAttribute("data-id");
      window.location.href = "mahasiswa.php?action=delete&id_mahasiswa=" + id;
    }
  </script>
</head>
<body>
  <?php include("sidebar.php"); ?>
  <div class="main-content">
    <div class="table-container">
      <h2>Data Mahasiswa</h2>
      <button class="tambah-button" onclick="window.location.href='tambah.php'">Tambah Mahasiswa</button>
    </div>
    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>NIM</th>
          <th>Nama</th>
          <th>Tempat Lahir</th>
          <th>Tanggal Lahir</th>
          <th>Fakultas</th>
          <th>Jurusan</th>
          <th>IPK</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          $no = $offset + 1;
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
            echo "<td>" . $row['nama_mahasiswa'] . "</td>";
            echo "<td>" . $row['tempat_lahir'] . "</td>";
            echo "<td>" . date("d-m-Y", strtotime($row['tanggal_lahir'])) . "</td>";
            echo "<td>" . $row['fakultas'] . "</td>";
            echo "<td>" . $row['jurusan'] . "</td>";
            echo "<td>" . $row['ipk'] . "</td>";
            echo "<td>
                    <button class='edit-button' onclick=\"window.location.href='edit.php?id_mahasiswa=" . $row['id_mahasiswa'] . "'\">Edit</button>
                    <button class='hapus-button' onclick=\"confirmDelete(" . $row['id_mahasiswa'] . ")\">Hapus</button>
                  </td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='9'>Tidak ada data</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <!-- Pagination di sudut kanan bawah tabel -->
    <nav aria-label="Page navigation" class="d-flex justify-content-end">
      <ul class="pagination">
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?php echo ($page - 1); ?>">Previous</a>
          </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>

  <!-- Modal Konfirmasi Hapus -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #800000;">
          <h5 class="modal-title" id="deleteModalLabel" style="color: #fff;">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
        </div>
        <div class="modal-body" style="background-color: #f8f9fa; color: #800000;">
          Apakah kamu yakin ingin menghapus data ini?
        </div>
        <div class="modal-footer" style="background-color: #800000;">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
          <button type="button" class="btn btn-light" id="confirmDeleteBtn" onclick="deleteData()">Ya</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
