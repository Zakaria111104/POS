<!DOCTYPE html>
<html>

<head>
    <title>Daftar Transaksi - Admin</title>
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

        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .transactions-table th,
        .transactions-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .transactions-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        .amount {
            font-weight: bold;
            color: #27ae60;
        }

        .no-data {
            text-align: center;
            color: #666;
            padding: 20px;
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
                <li><a href="<?php echo base_url('admin/products'); ?>">
                        <i class="fas fa-box"></i> Product Management
                    </a></li>
                <li><a href="<?php echo base_url('admin/transactions'); ?>" class="active">
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
                <h1>Daftar Transaksi</h1>
                <div class="user-info">
                    Selamat datang, <?php echo $this->session->userdata('user')->username; ?>!
                </div>
            </div>

            <div class="content-card">
                <h2>Riwayat Transaksi</h2>

                <?php if (!empty($transactions)): ?>
                    <table class="transactions-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php
                                    // Set timezone ke Asia/Jakarta (WIB)
                                    date_default_timezone_set('Asia/Jakarta');
                                    echo date('d/m/Y H:i', strtotime($transaction->tanggal)) . ' WIB';
                                    ?></td>
                                    <td><?php echo $transaction->customer_name ? $transaction->customer_name : 'Unknown'; ?>
                                    </td>
                                    <td class="amount">Rp <?php echo number_format($transaction->total, 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">
                        <p>Belum ada data transaksi</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>