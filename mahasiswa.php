<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            text-align: center;
        }

        h2 {
            color: maroon;
        }

        .button-container {
            text-align: right;
            margin-right: 10%;
            margin-bottom: 20px;
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

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background-color: #fff;
            border: 2px solid maroon;
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

        /* Tombol Edit dan Hapus dengan ukuran yang sama */
        .edit-button,
        .hapus-button {
            padding: 8px 15px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 80px; /* Membuat lebar tombol sama */
            display: inline-block;
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
    </style>
    <script>
        function pindahKeTambah() {
            window.location.href = "tambah.php";
        }
    </script>
</head>

<body>

    <h2>Data Mahasiswa</h2>

    <!-- Tombol tambah mahasiswa di kanan -->
    <div class="button-container">
        <button class="tambah-button" onclick="pindahKeTambah()">Tambah Mahasiswa</button>
    </div>

    <table>
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

        <!-- Data Mahasiswa Contoh -->
        <tr>
            <td>1</td>
            <td>22040175</td>
            <td>Tarri Peritha Westi</td>
            <td>Jakarta</td>
            <td>02-10-2002</td>
            <td>Teknik</td>
            <td>Informatika</td>
            <td>3.8</td>
            <td>
                <button class="edit-button">Edit</button>
                <button class="hapus-button">Hapus</button>
            </td>
        </tr>
    </table>

</body>
</html>
