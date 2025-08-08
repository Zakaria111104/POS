<!DOCTYPE html>
<html>

<head>
    <title></title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            background: #fff;
            width: 100%;
            max-width: 420px;
            padding: 24px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 16px;
            font-size: 22px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 12px;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 15px;
        }

        .btn {
            width: 100%;
            background: #333;
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 4px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 8px;
        }

        .btn:hover {
            background: #555;
        }

        .link {
            text-align: center;
            margin-top: 14px;
            font-size: 14px;
        }

        .link a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <h2>Login</h2>
            <form method="post" action="<?php echo site_url('auth/login'); ?>">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">Masuk</button>
            </form>
            <div class="link">
                Belum punya akun? <a href="<?php echo site_url('auth/register'); ?>">Daftar</a>
            </div>
        </div>
    </div>

    <script>
        <?php if ($this->session->flashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Berhasil', text: '<?php echo $this->session->flashdata('success'); ?>', timer: 2500, showConfirmButton: false });
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            Swal.fire({ icon: 'error', title: 'Error', html: '<?php echo $this->session->flashdata('error'); ?>' });
        <?php endif; ?>
    </script>
</body>

</html>