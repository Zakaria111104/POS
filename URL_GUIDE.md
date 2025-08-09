# 📋 URL Guide - Aplikasi POS

## 🔐 Authentication

- **Login**: `http://localhost:8080/auth/login`
- **Register**: `http://localhost:8080/auth/register`
- **Logout**: `http://localhost:8080/auth/logout`

## 🏠 Dashboard

- **Admin Dashboard**: `http://localhost:8080/admin/dashboard`
- **Kasir Dashboard**: `http://localhost:8080/user/dashboard`

## 📦 Admin Features

- **Products**: `http://localhost:8080/admin/products`
- **Add Product**: `http://localhost:8080/admin/add_product`
- **Edit Product**: `http://localhost:8080/admin/edit_product/{id}`
- **Users**: `http://localhost:8080/admin/users`
- **Transactions**: `http://localhost:8080/admin/transactions`

## 🛒 Kasir Features

- **Purchase History**: `http://localhost:8080/user/purchase_history`
- **New Transaction**: `http://localhost:8080/user/new_transaction`

## 🔧 Default Credentials

### Admin User:

- **Username**: `admin`
- **Password**: `admin123`

### Kasir User:

- **Username**: `kasir`
- **Password**: `kasir123`

## 🚀 Quick Start

1. Import database: `ci3_project.sql`
2. Import users: `create_default_users.sql`
3. Login: `http://localhost:8000/auth/login`
4. Start using the application!
