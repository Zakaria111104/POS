<!DOCTYPE html>
<html>

<head>
    <title>User Management - Admin</title>
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

        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .users-table th,
        .users-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .users-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        .role-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .role-admin {
            background-color: #e74c3c;
        }

        .role-user {
            background-color: #27ae60;
        }

        .delete-btn {
            background: #e74c3c;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 12px;
            transition: background 0.2s;
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
                <li><a href="<?php echo base_url('admin/users'); ?>" class="active">
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

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>User Management</h1>
                <div class="user-info">
                    Selamat datang, <?php echo $this->session->userdata('user')->username; ?>!
                </div>
            </div>

            <div class="content-card">
                <h2>Daftar User</h2>

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

                <!-- Users Table -->
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $user->username; ?></td>
                                <td>
                                    <span class="role-badge <?php echo ($user->role == 0) ? 'role-admin' : 'role-user'; ?>">
                                        <?php echo ($user->role == 0) ? 'Admin' : 'User'; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user->id != $this->session->userdata('user')->id): ?>
                                        <a href="<?php echo base_url('admin/delete_user/' . $user->id); ?>" class="delete-btn"
                                            onclick="return confirm('Yakin ingin menghapus user ini?')">
                                            Delete
                                        </a>
                                    <?php else: ?>
                                        <span style="color: #666;">Current User</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>