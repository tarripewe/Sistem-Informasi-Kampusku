<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #d3d3d3;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .forgot-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }
        h3 {
            color: maroon;
        }
        .btn-back {
            background-color: maroon;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color: #600000;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <h3>Lupa Password</h3>
        <p>Silahkan hubungi Admin untuk mendapatkan Password Baru.</p>
        <a href="login.php" class="btn-back">Kembali ke Login</a>
    </div>
</body>
</html>
