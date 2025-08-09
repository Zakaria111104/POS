<!DOCTYPE html>
<html>
<head>
    <title>Toko Online Sederhana</title>
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
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .section h2 {
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            grid-auto-rows: 1fr; /* pastikan tiap grid item merentang penuh */
        }

        .product-card {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            background-color: #fafafa;
            display: flex;
            flex-direction: column; /* seragamkan tinggi kartu */
            height: 100%;
        }

        .product-image {
            width: 100%;
            aspect-ratio: 4 / 3; /* tinggi gambar konsisten */
            background-color: #eee;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            padding: 10px;
        }

        .product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 5px;
        }

        .product-name {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .product-price {
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* dorong form/tombol ke bawah agar tinggi kartu sama */
        .product-card form {
            margin-top: auto;
        }

        .product-stock {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .quantity-input {
            width: 60px;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .add-to-cart-btn {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 3px;
            cursor: pointer;
            width: 100%;
        }

        .add-to-cart-btn:hover {
            background-color: #229954;
        }

        .add-to-cart-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-total {
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
            font-size: 18px;
        }

        .checkout-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .checkout-btn:hover {
            background-color: #c0392b;
        }

        .empty-cart {
            text-align: center;
            color: #666;
            padding: 20px;
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
            
            .products-grid {
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
                <li><a href="<?php echo base_url('user'); ?>" class="active">
                    <i class="fas fa-home"></i> Dashboard
                </a></li>
                <li><a href="<?php echo base_url('user/purchase_history'); ?>">
                    <i class="fas fa-history"></i> Riwayat Pembelian
                </a></li>
                <li><a href="<?php echo base_url('auth/logout'); ?>" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a></li>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Produk Section -->
            <div class="section">
                <h2><i class="fas fa-shopping-bag"></i> Produk Tersedia</h2>
                <div class="products-grid">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <div class="product-image">
                                    <?php if ($product->gambar && $product->gambar != 'default.jpg'): ?>
                                        <img src="<?php echo base_url('uploads/' . $product->gambar); ?>" 
                                             alt="<?php echo $product->nama; ?>">
                                    <?php else: ?>
                                        <i class="fas fa-image" style="font-size: 48px; color: #999;"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="product-name"><?php echo $product->nama; ?></div>
                                <div class="product-price">Rp <?php echo number_format($product->harga, 0, ',', '.'); ?></div>
                                <div class="product-stock">Stok: <?php echo $product->stok; ?> unit</div>
                                <form method="post" action="<?php echo base_url('user/add_to_cart'); ?>">
                                    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $product->stok; ?>" 
                                           class="quantity-input">
                                    <button type="submit" class="add-to-cart-btn" <?php echo ($product->stok <= 0) ? 'disabled' : ''; ?>>
                                        <?php echo ($product->stok <= 0) ? 'Stok Habis' : 'Tambah ke Keranjang'; ?>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="grid-column: 1 / -1; text-align: center; color: #666; padding: 40px;">
                            <i class="fas fa-box-open" style="font-size: 48px; margin-bottom: 20px;"></i>
                            <p>Belum ada produk tersedia</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Keranjang Section -->
            <div class="section">
                <h2><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h2>
                <?php if (!empty($cart_items)): ?>
                    <div class="cart-items">
                        <?php
                        $total = 0;
                        foreach ($cart_items as $item):
                            $subtotal = $item->harga * $item->quantity;
                            $total += $subtotal;
                        ?>
                            <div class="cart-item">
                                <div>
                                    <div style="font-weight: bold;"><?php echo $item->nama_produk; ?></div>
                                    <div>Rp <?php echo number_format($item->harga, 0, ',', '.'); ?> x <?php echo $item->quantity; ?></div>
                                </div>
                                <a href="<?php echo base_url('user/remove_from_cart/' . $item->id); ?>" 
                                   onclick="return confirm('Hapus dari keranjang?')" 
                                   style="color: #e74c3c; text-decoration: none;">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="cart-total">
                        Total: Rp <?php echo number_format($total, 0, ',', '.'); ?>
                    </div>
                    <form method="post" action="<?php echo base_url('user/checkout'); ?>">
                        <button type="submit" class="checkout-btn">
                            <i class="fas fa-credit-card"></i> Checkout
                        </button>
                    </form>
                <?php else: ?>
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ddd; margin-bottom: 20px;"></i>
                        <p>Keranjang belanja kosong</p>
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