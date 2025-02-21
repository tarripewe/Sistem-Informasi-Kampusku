<?php
include("config.php");

// Jika ada parameter action=delete, lakukan penghapusan data
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_mahasiswa'])) {
    $id = $_GET['id_mahasiswa'];
    $deleteQuery = "DELETE FROM mahasiswa WHERE id_mahasiswa = '$id'";
    if (mysqli_query($conn, $deleteQuery)) {
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
                .modal-header,
                .modal-footer {
                    background-color: #800000;
                }

                .modal-title,
                .modal-footer .btn {
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
                setTimeout(function() {
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

// --- Fitur Search ---
// Pencarian hanya berdasarkan NIM dan Nama Mahasiswa
$search = "";
if (isset($_GET['q'])) {
    $search = mysqli_real_escape_string($conn, $_GET['q']);
}
$whereClause = "";
if ($search != "") {
    $whereClause = "WHERE m.nim LIKE '%$search%' OR m.nama_mahasiswa LIKE '%$search%'";
}

// --- Fitur Sorting ---
$allowedSort = array(
    'nim'      => 'm.nim',
    'nama'     => 'm.nama_mahasiswa',
    'fakultas' => 'f.nama_fakultas',
    'jurusan'  => 'j.nama_jurusan'
);
$sort  = isset($_GET['sort']) && isset($allowedSort[$_GET['sort']]) ? $_GET['sort'] : "";
$order = (isset($_GET['order']) && strtolower($_GET['order']) == 'asc') ? 'ASC' : 'DESC';
$sortColumn = $sort !== "" ? $allowedSort[$sort] : 'm.id_mahasiswa';

// Parameter search untuk link
$searchParam = $search !== "" ? "&q=" . urlencode($search) : "";

// --- Pagination ---
$limit = 10;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

$countQuery = "SELECT COUNT(*) as total 
               FROM mahasiswa m
               JOIN fakultas f ON m.fakultas = f.id_fakultas
               JOIN jurusan j ON m.jurusan = j.id_jurusan
               $whereClause";
$countResult = mysqli_query($conn, $countQuery);
$countData   = mysqli_fetch_assoc($countResult);
$totalRecords = $countData['total'];
$totalPages   = ceil($totalRecords / $limit);

$query = "SELECT m.*, f.nama_fakultas, j.nama_jurusan 
          FROM mahasiswa m
          JOIN fakultas f ON m.fakultas = f.id_fakultas
          JOIN jurusan j ON m.jurusan = j.id_jurusan
          $whereClause
          ORDER BY $sortColumn $order 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

function getSortIcon($col)
{
    global $sort, $order;
    if ($sort == $col) {
        return (strtolower($order) == 'asc') ? ' <i class="bi bi-arrow-up"></i>' : ' <i class="bi bi-arrow-down"></i>';
    } else {
        return ' <i class="bi bi-arrow-down-up"></i>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Sertakan Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .search-container {
            position: absolute;
            top: 20px;
            right: 20px;
            max-width: 400px;
            width: 100%;
        }

        .table-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            margin-top: 60px;
            /* memberi ruang dari search */
        }

        .table-header h2 {
            margin: 0;
            color: maroon;
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
            flex-direction: column;
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

        th,
        td {
            border: 2px solid maroon;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: maroon;
            color: white;
        }

        a.sort-link {
            color: white;
            text-decoration: none;
        }

        a.sort-link:hover {
            text-decoration: underline;
        }

        .edit-button,
        .hapus-button {
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
            document.getElementById("confirmDeleteBtn").setAttribute("data-id", id);
            var myModal = new bootstrap.Modal(document.getElementById("deleteModal"));
            myModal.show();
        }

        function deleteData() {
            var id = document.getElementById("confirmDeleteBtn").getAttribute("data-id");
            window.location.href = "mahasiswa.php?action=delete&id_mahasiswa=" + id;
        }
    </script>
</head>

<body>
    <?php include("sidebar.php"); ?>
    <div class="main-content">
        <!-- Search Container di pojok kanan atas -->
        <div class="search-container">
            <form class="search-form" method="GET" action="mahasiswa.php">
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="Cari NIM atau Nama..." value="<?php echo htmlspecialchars($search); ?>">
                    <?php if ($search != ""): ?>
                        <button type="button" class="tambah-button" onclick="window.location.href='mahasiswa.php'">Reset</button>
                    <?php else: ?>
                        <button type="submit" class="tambah-button">Cari</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <!-- Header dengan judul di kiri dan tombol add di kanan -->
        <div class="table-header">
            <h1>Data Mahasiswa</h1>
            <button class="tambah-button" onclick="window.location.href='tambah.php'">Tambah Mahasiswa</button>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>
                            <a class="sort-link" href="?sort=nim&order=<?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nim' && strtolower($_GET['order']) == 'asc') ? 'desc' : 'asc';
                                                                        echo $searchParam; ?>">
                                NIM<?php echo getSortIcon('nim'); ?>
                            </a>
                        </th>
                        <th>
                            <a class="sort-link" href="?sort=nama&order=<?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nama' && strtolower($_GET['order']) == 'asc') ? 'desc' : 'asc';
                                                                        echo $searchParam; ?>">
                                Nama<?php echo getSortIcon('nama'); ?>
                            </a>
                        </th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>
                            <a class="sort-link" href="?sort=fakultas&order=<?php echo (isset($_GET['sort']) && $_GET['sort'] == 'fakultas' && strtolower($_GET['order']) == 'asc') ? 'desc' : 'asc';
                                                                            echo $searchParam; ?>">
                                Fakultas<?php echo getSortIcon('fakultas'); ?>
                            </a>
                        </th>
                        <th>
                            <a class="sort-link" href="?sort=jurusan&order=<?php echo (isset($_GET['sort']) && $_GET['sort'] == 'jurusan' && strtolower($_GET['order']) == 'asc') ? 'desc' : 'asc';
                                                                            echo $searchParam; ?>">
                                Jurusan<?php echo getSortIcon('jurusan'); ?>
                            </a>
                        </th>
                        <th>IPK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $no = $offset + 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr onclick=\"window.location.href='detail_mahasiswa.php?id_mahasiswa=" . $row['id_mahasiswa'] . "'\" style='cursor: pointer;'>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                            echo "<td>" . $row['nama_mahasiswa'] . "</td>";
                            echo "<td>" . $row['tempat_lahir'] . "</td>";
                            echo "<td>" . date("d-m-Y", strtotime($row['tanggal_lahir'])) . "</td>";
                            echo "<td>" . $row['nama_fakultas'] . "</td>";
                            echo "<td>" . $row['nama_jurusan'] . "</td>";
                            echo "<td>" . $row['ipk'] . "</td>";
                            echo "<td>
                <button class='edit-button' onclick=\"event.stopPropagation(); window.location.href='edit.php?id_mahasiswa=" . $row['id_mahasiswa'] . "'\">Edit</button>
                <button class='hapus-button' onclick=\"event.stopPropagation(); confirmDelete(" . $row['id_mahasiswa'] . ")\">Hapus</button>
            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>
        <!-- Pagination -->
        <nav aria-label="Page navigation" class="d-flex justify-content-end">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo ($page - 1) . $searchParam; ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i . $searchParam; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo ($page + 1) . $searchParam; ?>">Next</a>
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