<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .dashboard-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .user-info {
            background: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .role-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .role-admin {
            background-color: #dc3545;
        }

        .role-user {
            background-color: #28a745;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <h1>Selamat datang di Dashboard!</h1>
        <div class="user-info">
            <p><strong>Halo, <?php echo $this->session->userdata('user')->username; ?>.</strong></p>
            <p>
                Level:
                <span
                    class="role-badge <?php echo ($this->session->userdata('user')->role == 0) ? 'role-admin' : 'role-user'; ?>">
                    <?php
                    if ($this->session->userdata('user')->role == 0) {
                        echo 'Admin (Level 0)';
                    } else {
                        echo 'User (Level 1)';
                    }
                    ?>
                </span>
            </p>
        </div>
        <a href="<?php echo base_url('auth/logout'); ?>" class="logout-btn">Logout</a>
    </div>

    <script>
        // SweetAlert untuk flash messages
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