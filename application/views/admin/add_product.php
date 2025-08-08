<!DOCTYPE html>
<html>

<head>
    <title>Tambah Produk - Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 200px;
            background-color: #444;
            color: white;
            padding: 20px;
        }

        .sidebar-header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #555;
            margin-bottom: 20px;
        }

        .sidebar-header h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 12px;
            opacity: 0.8;
        }

        .nav-menu {
            list-style: none;
        }

        .sidebar h3 {
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 1px solid #666;
            padding-bottom: 10px;
        }

        .nav-menu li {
            margin-bottom: 5px;
        }

        .nav-menu a {
            display: block;
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            transition: background 0.2s;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            background: #555;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 3px;
            margin-top: 20px;
            display: block;
            text-align: center;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .back-btn {
            background: #555;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 14px;
            transition: background 0.2s;
        }

        .back-btn:hover {
            background: #666;
        }

        .content-card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #555;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 3px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: background 0.2s;
        }

        .btn-primary {
            background: #333;
            color: white;
        }

        .btn-primary:hover {
            background: #444;
        }

        .btn-secondary {
            background: #666;
            color: white;
        }

        .btn-secondary:hover {
            background: #777;
        }

        small {
            color: #666;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Menu</h3>
            <ul class="nav-menu">
                <li><a href="<?php echo base_url('admin'); ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a></li>
                <li><a href="<?php echo base_url('admin/users'); ?>">
                        <i class="fas fa-users"></i> User Management
                    </a></li>
                <li><a href="<?php echo base_url('admin/products'); ?>" class="active">
                        <i class="fas fa-box"></i> Product Management
                    </a></li>
                <li><a href="<?php echo base_url('admin/transactions'); ?>">
                        <i class="fas fa-receipt"></i> Transactions
                    </a></li>
                <li><a href="<?php echo base_url('auth/logout'); ?>" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Tambah Produk Baru</h1>
                <a href="<?php echo base_url('admin/products'); ?>" class="back-btn">Back to Products</a>
            </div>

            <!-- Add Form -->
            <div class="content-card">
                <form method="post" action="<?php echo base_url('admin/add_product'); ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama">Nama Produk</label>
                        <input type="text" id="nama" name="nama" required>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" id="harga" name="harga" min="0" step="1000" required>
                    </div>

                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" id="stok" name="stok" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="gambar">Gambar Produk</label>
                        <input type="file" id="gambar" name="gambar" accept="image/*">
                        <small>Format: JPG, PNG, GIF, WEBP. Maksimal 2MB</small>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Tambah Produk</button>
                        <a href="<?php echo base_url('admin/products'); ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // SweetAlert untuk flash messages
        <?php if ($this->session->flashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?php echo $this->session->flashdata('success'); ?>',
                timer: 3000,
                showConfirmButton: false
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?php echo $this->session->flashdata('error'); ?>',
                timer: 3000,
                showConfirmButton: false
            });
        <?php endif; ?>
    </script>
</body>

</html>