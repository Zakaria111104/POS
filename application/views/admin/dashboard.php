<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
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
            line-height: 1.6;
        }

        .header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            margin-bottom: 10px;
        }

        .user-info {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .main-container {
            display: flex;
            min-height: calc(100vh - 100px);
        }

        .sidebar {
            width: 250px;
            background-color: #444;
            color: white;
            padding: 20px;
            position: fixed;
            height: calc(100vh - 100px);
            overflow-y: auto;
        }

        .sidebar h3 {
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 1px solid #666;
            padding-bottom: 10px;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-menu li {
            margin-bottom: 14px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 16px;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            background-color: #666;
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

        .content-area {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }

        .section {
            background-color: white;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .section h2 {
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #3498db;
        }

        .stat-card.income {
            border-left-color: #27ae60;
        }

        .stat-card.users {
            border-left-color: #e74c3c;
        }

        .stat-card.products {
            border-left-color: #f39c12;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
        }

        .recent-sales {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .recent-sales h3 {
            margin-bottom: 15px;
            color: #333;
            font-size: 18px;
        }

        .sales-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sales-table th,
        .sales-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .sales-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .amount {
            font-weight: bold;
            color: #27ae60;
        }

        .no-data {
            text-align: center;
            color: #666;
            padding: 30px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content-area {
                margin-left: 200px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                position: static;
                height: auto;
            }

            .content-area {
                margin-left: 0;
            }

            .main-container {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Halaman Admin</h1>
        <div class="user-info">
            Selamat datang, <?php echo $this->session->userdata('user')->username; ?>!
        </div>
    </div>

    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Menu</h3>
            <ul class="nav-menu">
                <li><a href="<?php echo base_url('admin'); ?>" class="active">
                        <i class="fas fa-home"></i> Dashboard
                    </a></li>
                <li><a href="<?php echo base_url('admin/users'); ?>">
                        <i class="fas fa-users"></i> User Management
                    </a></li>
                <li><a href="<?php echo base_url('admin/products'); ?>">
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

        <!-- Content Area -->
        <div class="content-area">
            <!-- Stats Grid -->
            <div class="section">
                <h2><i class="fas fa-chart-line"></i> Statistik Overview</h2>
                <div class="stats-grid">
                    <div class="stat-card income">
                        <div class="stat-number">Rp <?php echo number_format($income_today, 0, ',', '.'); ?></div>
                        <div class="stat-label">Pemasukan Hari Ini</div>
                    </div>

                    <div class="stat-card income">
                        <div class="stat-number">Rp <?php echo number_format($income_month, 0, ',', '.'); ?></div>
                        <div class="stat-label">Pemasukan Bulan Ini</div>
                    </div>

                    <div class="stat-card users">
                        <div class="stat-number"><?php echo $total_users; ?></div>
                        <div class="stat-label">Total Users</div>
                    </div>

                    <div class="stat-card products">
                        <div class="stat-number"><?php echo $total_products; ?></div>
                        <div class="stat-label">Total Products</div>
                    </div>
                </div>
            </div>

            <!-- Recent Sales -->
            <div class="section">
                <h2><i class="fas fa-history"></i> Penjualan Terbaru</h2>
                <?php if (!empty($recent_sales)): ?>
                    <table class="sales-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pembeli</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_sales as $sale): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y H:i', strtotime($sale->tanggal)); ?></td>
                                    <td><?php echo $sale->kasir_name ? $sale->kasir_name : 'Unknown'; ?></td>
                                    <td class="amount">Rp <?php echo number_format($sale->total, 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">
                        <p>Belum ada data penjualan</p>
                    </div>
                <?php endif; ?>
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
    </script>
</body>

</html>