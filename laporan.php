<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .main-content {
            margin-left: 270px;
            width: calc(100% - 270px);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .maintenance-text {
            font-size: 36px;
            font-weight: bold;
            color: maroon;
        }
    </style>
</head>
<body>

    <?php include("sidebar.php"); ?>

    <div class="main-content">
        <p class="maintenance-text">Sedang dalam perbaikan. Mohon kembali lagi nanti!</p>
    </div>

</body>
</html>
