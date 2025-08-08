<!DOCTYPE html>
<html>

<head>
    <title>Riwayat Pembelian - Toko Online Sederhana</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            margin-bottom: 10px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            background-color: #666;
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

        .history-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fafafa;
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .history-date {
            color: #666;
            font-size: 14px;
        }

        .history-total {
            color: #e74c3c;
            font-weight: bold;
            font-size: 18px;
        }

        .history-details {
            display: grid;
            gap: 8px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .product-name {
            font-weight: bold;
            color: #333;
            font-size: 16px;
        }

        .product-quantity {
            color: #666;
            font-size: 14px;
        }

        .product-subtotal {
            color: #e74c3c;
            font-weight: bold;
            font-size: 16px;
        }

        .empty-history {
            text-align: center;
            color: #666;
            padding: 40px;
        }

        .empty-history i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 20px;
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

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content-area {
                margin-left: 200px;
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
        <h1>Toko Online Sederhana</h1>
        <div class="user-info">
            Selamat datang, <?php echo $this->session->userdata('user')->username; ?>!
        </div>
    </div>

    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Menu</h3>
            <ul class="nav-menu">
                <li><a href="<?php echo base_url('user'); ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a></li>
                <li><a href="<?php echo base_url('user/purchase_history'); ?>" class="active">
                        <i class="fas fa-history"></i> Riwayat Pembelian
                    </a></li>
                <li><a href="<?php echo base_url('auth/logout'); ?>" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a></li>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <div class="section">
                <h2><i class="fas fa-history"></i> Riwayat Pembelian</h2>

                <?php if (!empty($purchase_history)): ?>
                    <?php
                    $current_sale_id = null;
                    $current_total = 0;
                    $current_date = null;
                    $current_items = [];

                    foreach ($purchase_history as $purchase):
                        if ($current_sale_id !== $purchase->id):
                            // Tampilkan penjualan sebelumnya
                            if ($current_sale_id !== null):
                                ?>
                                <div class="history-item">
                                    <div class="history-header">
                                        <div class="history-date">
                                            <i class="fas fa-calendar"></i>
                                            <?php
                                            // Set timezone ke Asia/Jakarta (WIB)
                                            date_default_timezone_set('Asia/Jakarta');
                                            echo date('d/m/Y H:i', strtotime($current_date)) . ' WIB';
                                            ?>
                                        </div>
                                        <div class="history-total">
                                            Total: Rp <?php echo number_format($current_total, 0, ',', '.'); ?>
                                        </div>
                                    </div>
                                    <div class="history-details">
                                        <?php foreach ($current_items as $item): ?>
                                            <div class="detail-item">
                                                <div>
                                                    <div class="product-name"><?php echo $item['nama_produk']; ?></div>
                                                    <div class="product-quantity">Qty: <?php echo $item['jumlah']; ?></div>
                                                </div>
                                                <div class="product-subtotal">
                                                    Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php
                            endif;

                            // Mulai penjualan baru
                            $current_sale_id = $purchase->id;
                            $current_total = 0;
                            $current_date = $purchase->tanggal;
                            $current_items = [];
                        endif;

                        $current_total += $purchase->subtotal;
                        $current_items[] = [
                            'nama_produk' => $purchase->nama_produk,
                            'jumlah' => $purchase->jumlah,
                            'subtotal' => $purchase->subtotal
                        ];
                    endforeach;

                    // Tampilkan penjualan terakhir
                    if ($current_sale_id !== null):
                        ?>
                        <div class="history-item">
                            <div class="history-header">
                                <div class="history-date">
                                    <i class="fas fa-calendar"></i>
                                    <?php
                                    // Set timezone ke Asia/Jakarta (WIB)
                                    date_default_timezone_set('Asia/Jakarta');
                                    echo date('d/m/Y H:i', strtotime($current_date)) . ' WIB';
                                    ?>
                                </div>
                                <div class="history-total">
                                    Total: Rp <?php echo number_format($current_total, 0, ',', '.'); ?>
                                </div>
                            </div>
                            <div class="history-details">
                                <?php foreach ($current_items as $item): ?>
                                    <div class="detail-item">
                                        <div>
                                            <div class="product-name"><?php echo $item['nama_produk']; ?></div>
                                            <div class="product-quantity">Qty: <?php echo $item['jumlah']; ?></div>
                                        </div>
                                        <div class="product-subtotal">
                                            Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="empty-history">
                        <i class="fas fa-receipt"></i>
                        <h3>Belum ada riwayat pembelian</h3>
                        <p>Mulai berbelanja untuk melihat riwayat pembelian Anda</p>
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