# Panduan Menjalankan Project POS di VS Code

## 🚀 Quick Start

### 1. **Menjalankan Server**
- **Via VS Code Tasks**: `Ctrl + Shift + P` → "Tasks: Run Task" → "Start PHP Server"
- **Via Terminal**: `php -S localhost:8000`
- **Via Laragon**: Akses `http://localhost/POS`

### 2. **Mengakses Aplikasi**
- Buka browser dan akses: `http://localhost:8000`
- Atau gunakan task: `Ctrl + Shift + P` → "Tasks: Run Task" → "Open in Browser"

## 📋 Prerequisites

### Software yang Diperlukan:
- ✅ PHP 7.4+ (sudah terinstall dengan Laragon)
- ✅ MySQL/MariaDB (sudah terinstall dengan Laragon)
- ✅ VS Code dengan extensions yang direkomendasikan

### Database Setup:
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Buat database baru: `POS`
3. Import file: `ci3_project.sql`

## 🔧 VS Code Setup

### Extensions yang Direkomendasikan:
- **PHP Intelephense** - PHP syntax highlighting
- **PHP Debug** - Debugging support
- **PHP Extension Pack** - Bundle PHP tools
- **Auto Rename Tag** - HTML/PHP tag renaming
- **Bracket Pair Colorizer** - Code readability

### Keyboard Shortcuts:
- `Ctrl + Shift + P` - Command Palette
- `Ctrl + `` - Terminal
- `Ctrl + Shift + E` - File Explorer
- `F5` - Start Debugging
- `Ctrl + F5` - Start Without Debugging

## 🛠️ Development Workflow

### 1. **Menjalankan Project**
```bash
# Di terminal VS Code
php -S localhost:8000
```

### 2. **Debugging**
- Set breakpoint dengan klik di sebelah kiri line number
- Tekan `F5` untuk start debugging
- Gunakan `F10` (step over), `F11` (step into), `F12` (step out)

### 3. **File Structure**
```
POS/
├── application/
│   ├── controllers/    # Controller files
│   ├── models/        # Model files
│   ├── views/         # View files
│   └── config/        # Configuration files
├── system/            # CodeIgniter core
├── uploads/           # Uploaded files
└── index.php          # Entry point
```

## 🔍 Troubleshooting

### Error: "Database connection failed"
- Pastikan MySQL service running
- Cek konfigurasi di `application/config/database.php`
- Pastikan database "POS" sudah dibuat

### Error: "Page not found"
- Pastikan server PHP running di port 8000
- Cek file `.htaccess` (jika ada)
- Pastikan URL routing benar

### Error: "Permission denied"
- Pastikan folder `uploads/` memiliki permission write
- Cek permission folder `application/cache/`

## 📝 Tips Development

### 1. **Code Navigation**
- `Ctrl + P` - Quick file open
- `Ctrl + Shift + O` - Go to symbol in file
- `Ctrl + T` - Go to symbol in workspace

### 2. **Code Editing**
- `Alt + Shift + F` - Format code
- `Ctrl + /` - Toggle comment
- `Ctrl + D` - Select next occurrence

### 3. **Terminal Commands**
```bash
# Start server
php -S localhost:8000

# Stop server
taskkill /F /IM php.exe

# Check PHP version
php -v

# Check running processes
netstat -an | findstr :8000
```

## 🎯 Next Steps

1. **Setup Database**: Import `ci3_project.sql`
2. **Configure Database**: Edit `application/config/database.php` jika perlu
3. **Start Development**: Mulai coding di VS Code!
4. **Test Features**: Login, CRUD products, transactions

## 📞 Support

Jika ada masalah:
1. Cek error log di `application/logs/`
2. Pastikan semua prerequisites terpenuhi
3. Restart VS Code jika perlu
4. Cek Laragon services running

---
**Happy Coding! 🚀**
