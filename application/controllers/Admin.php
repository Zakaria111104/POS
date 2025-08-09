<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model(['User_model', 'Produk_model', 'Penjualan_model']);

        // Cek apakah user sudah login dan adalah admin (kompat angka/string)
        $user = $this->session->userdata('user');
        if (!$user) {
            redirect('auth/login');
        }
        $role = $user->role;
        $roleStr = is_string($role) ? strtolower($role) : (string) $role;
        $isAdmin = ($role === 0 || $role === '0' || $roleStr === 'admin');
        if (!$isAdmin) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        // Tambahkan data sample jika tabel kosong
        $this->Penjualan_model->add_sample_data();
        $this->Produk_model->add_sample_products();

        // Data untuk dashboard
        $data['total_users'] = $this->User_model->count_users();
        $data['total_products'] = $this->Produk_model->count_products();
        $data['income_today'] = $this->Penjualan_model->get_income_today();
        $data['income_month'] = $this->Penjualan_model->get_income_month();
        $data['recent_sales'] = $this->Penjualan_model->get_recent_sales(5);
        $data['all_sales'] = $this->Penjualan_model->get_all_sales();

        $this->load->view('admin/dashboard', $data);
    }

    public function dashboard()
    {
        // Redirect ke index method
        $this->index();
    }

    public function user_purchases($user_id = null)
    {
        if ($user_id) {
            $data['user'] = $this->User_model->get_user_by_id($user_id);
            $data['purchases'] = $this->Penjualan_model->get_sales_by_user($user_id);
            $this->load->view('admin/user_purchases', $data);
        } else {
            redirect('admin');
        }
    }

    // User Management
    public function users()
    {
        $data['users'] = $this->User_model->get_all_users();
        $this->load->view('admin/users', $data);
    }

    public function delete_user($id)
    {
        if ($this->User_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user');
        }
        redirect('admin/users');
    }

    // Product Management
    public function products()
    {
        $data['products'] = $this->Produk_model->get_all_products();
        $this->load->view('admin/products', $data);
    }

    public function edit_product($id)
    {
        if ($this->input->post()) {
            $data = [
                'nama' => $this->input->post('nama'),
                'harga' => $this->input->post('harga'),
                'stok' => $this->input->post('stok')
            ];

            // Upload gambar baru jika ada
            if ($_FILES['gambar']['name']) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambar')) {
                    $upload_data = $this->upload->data();
                    $data['gambar'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload gambar: ' . $this->upload->display_errors());
                    redirect('admin/edit_product/' . $id);
                    return;
                }
            }

            if ($this->Produk_model->update_product($id, $data)) {
                $this->session->set_flashdata('success', 'Produk berhasil diupdate');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate produk');
            }
            redirect('admin/products');
        }

        $data['product'] = $this->Produk_model->get_product_by_id($id);
        $this->load->view('admin/edit_product', $data);
    }

    public function delete_product($id)
    {
        if ($this->Produk_model->delete_product($id)) {
            $this->session->set_flashdata('success', 'Produk berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus produk');
        }
        redirect('admin/products');
    }

    public function add_product()
    {
        if ($this->input->post()) {
            // Upload gambar
            $gambar = 'default.jpg';
            if ($_FILES['gambar']['name']) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambar')) {
                    $upload_data = $this->upload->data();
                    $gambar = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload gambar: ' . $this->upload->display_errors());
                    redirect('admin/add_product');
                    return;
                }
            }

            $data = [
                'nama' => $this->input->post('nama'),
                'harga' => $this->input->post('harga'),
                'stok' => $this->input->post('stok'),
                'gambar' => $gambar
            ];

            if ($this->Produk_model->insert_product($data)) {
                $this->session->set_flashdata('success', 'Produk ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan produk');
            }
            redirect('admin/products');
        }

        $this->load->view('admin/add_product');
    }

    // Transaction History
    public function transactions()
    {
        $data['transactions'] = $this->Penjualan_model->get_all_transactions();
        $this->load->view('admin/transactions', $data);
    }
}