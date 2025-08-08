<!DOCTYPE html>
<html>

<head>
    <title>Product Management - Admin</title>
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
        }

        .header h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .content-card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .content-card h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .add-product-btn {
            background: #333;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 14px;
            margin-bottom: 15px;
            display: inline-block;
            transition: background 0.2s;
        }

        .add-product-btn:hover {
            background: #444;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .products-table th,
        .products-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .products-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        .price {
            font-weight: bold;
            color: #27ae60;
        }

        .stock {
            font-weight: bold;
        }

        .stock.low {
            color: #e74c3c;
        }

        .stock.medium {
            color: #f39c12;
        }

        .stock.high {
            color: #27ae60;
        }

        .action-btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 12px;
            margin-right: 5px;
            transition: background 0.2s;
        }

        .edit-btn {
            background: #333;
            color: white;
        }

        .edit-btn:hover {
            background: #444;
        }

        .delete-btn {
            background: #e74c3c;
            color: white;
        }

        .delete-btn:hover {
            background: #c0392b;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 3px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
                <h1>Product Management</h1>
                <div class="user-info">
                    Selamat datang, <?php echo $this->session->userdata('user')->username; ?>!
                </div>
            </div>

            <div class="content-card">
                <h2>Daftar Produk</h2>

                <a href="<?php echo base_url('admin/add_product'); ?>" class="add-product-btn">
                    Tambah Produk
                </a>

                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-error">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <!-- Products Table -->
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $product->nama; ?></td>
                                    <td class="price">Rp <?php echo number_format($product->harga, 0, ',', '.'); ?></td>
                                    <td>
                                        <span class="stock <?php
                                        if ($product->stok <= 10)
                                            echo 'low';
                                        elseif ($product->stok <= 50)
                                            echo 'medium';
                                        else
                                            echo 'high';
                                        ?>">
                                            <?php echo $product->stok; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('admin/edit_product/' . $product->id); ?>"
                                            class="action-btn edit-btn">
                                            Edit
                                        </a>
                                        <a href="<?php echo base_url('admin/delete_product/' . $product->id); ?>"
                                            class="action-btn delete-btn"
                                            onclick="return confirmDelete(<?php echo $product->id; ?>, '<?php echo $product->nama; ?>')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px; color: #666;">
                                    Belum ada data produk
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
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

        function confirmDelete(id, nama) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: `Produk "${nama}" akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?php echo base_url('admin/delete_product/'); ?>' + id;
                }
            });
            return false;
        }
    </script>
</body>

</html>