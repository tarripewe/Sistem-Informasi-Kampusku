<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }

        .login-container img {
            width: 80px;
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #b73d3d;
            border: none;
        }

        .btn-primary:hover {
            background-color: #8c2f2f;
        }

        .register-link {
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h3>Login</h3>
        <!-- Menampilkan pesan error jika ada -->
        <!-- <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?> -->
        <form method="post">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3 form-check text-start">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary w-100"  onclick="window.location.href='mahasiswa.php'">Login</button>
        </form>
        <div class="register-link">
            <p><a href="forgot.php">Forgot password?</a>
            </p>
            <!-- Not registered? <a href="register.php">Create an account!</a> -->
        </div>
    </div>
</body>

</html>