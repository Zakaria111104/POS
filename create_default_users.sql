-- Insert default users for POS application
-- Password: admin123 (hashed with PASSWORD_DEFAULT)
-- Password: kasir123 (hashed with PASSWORD_DEFAULT)

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('kasir', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kasir');

-- Insert sample products
INSERT INTO `produk` (`nama`, `harga`, `stok`, `gambar`) VALUES
('Laptop Asus', 8500000.00, 10, 'laptop_asus.jpg'),
('Mouse Wireless', 150000.00, 50, 'mouse_wireless.jpg'),
('Keyboard Mechanical', 500000.00, 25, 'keyboard_mech.jpg'),
('Monitor 24"', 2000000.00, 15, 'monitor_24.jpg'),
('Headphone Gaming', 750000.00, 30, 'headphone_gaming.jpg');
