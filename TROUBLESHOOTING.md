# 🔧 Troubleshooting Guide - Aplikasi POS

## ❌ Error 404 "Page Not Found"

### **Penyebab:**

1. Controller method tidak ditemukan
2. Role checking salah
3. Database belum diimport
4. Base URL tidak sesuai

### **✅ Solusi:**

#### **1. Pastikan Database Sudah Diimport:**

```sql
-- Di phpMyAdmin:
1. Buat database: POS
2. Import: ci3_project.sql
3. Import: create_default_users.sql
```

#### **2. Cek URL yang Benar:**

- **Login**: `http://localhost:8080/auth/login`
- **Register**: `http://localhost:8080/auth/register`
- **Admin Dashboard**: `http://localhost:8080/admin/dashboard`
- **User Dashboard**: `http://localhost:8080/user/dashboard`

#### **3. Credentials yang Benar:**

- **Admin**: `admin` / `admin123`
- **Kasir**: `kasir` / `kasir123`

#### **4. Restart Server:**

```bash
# Stop server
taskkill /F /IM php.exe

# Start server
php -S localhost:8080
```

## 🔍 Debug Steps

### **1. Cek Log Error:**

- Buka browser developer tools (F12)
- Lihat tab Console dan Network
- Cek response status code

### **2. Cek Database Connection:**

- Pastikan MySQL running
- Cek konfigurasi di `application/config/database.php`
- Test koneksi di phpMyAdmin

### **3. Cek File Structure:**

```
POS/
├── application/
│   ├── controllers/
│   │   ├── Auth.php ✅
│   │   ├── Admin.php ✅
│   │   └── User.php ✅
│   ├── models/
│   │   ├── User_model.php ✅
│   │   └── Produk_model.php ✅
│   └── views/
│       ├── auth/
│       ├── admin/
│       └── user/
```

## 🚀 Quick Fix

### **Jika masih error 404:**

1. **Clear browser cache**
2. **Restart server**: `php -S localhost:8080`
3. **Import database lagi**
4. **Coba login dengan credentials default**

### **URL Testing:**

```
✅ http://localhost:8080/ (Welcome page)
✅ http://localhost:8080/auth/login
✅ http://localhost:8080/auth/register
✅ http://localhost:8080/admin/dashboard (setelah login admin)
✅ http://localhost:8080/user/dashboard (setelah login kasir)
```

## 📞 Support

Jika masih ada masalah:

1. Cek error log di `application/logs/`
2. Pastikan semua file controller ada
3. Restart VS Code dan server
4. Cek Laragon services running
