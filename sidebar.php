<!DOCTYPE html>
<html lang="id">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .sidebar {
            width: 250px;
            background-color: maroon;
            color: white;
            padding: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar h3 {
            text-align: left;
            margin-bottom: 30px;
            padding-left: 10px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            margin: 5px 0;
            border-radius: 5px;
            text-align: left;
        }

        .sidebar a.active {
            background-color: #600000;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: #800000;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3><i class="bi bi-mortarboard-fill"></i> KampusKu</h3>
        <a href="mahasiswa.php" class="<?= basename($_SERVER['PHP_SELF']) == 'mahasiswa.php' ? 'active' : '' ?>">
            <i class="bi bi-person-lines-fill"></i> Data Mahasiswa
        </a>
        <a href="laporan.php" class="<?= basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-text-fill"></i> Laporan
        </a>
        <a href="pengaturan.php" class="<?= basename($_SERVER['PHP_SELF']) == 'pengaturan.php' ? 'active' : '' ?>">
            <i class="bi bi-gear-fill"></i> Pengaturan
        </a>
        <!-- <a href="logout.php">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a> -->
    </div>
</body>

</html>