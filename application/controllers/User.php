<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model(['User_model', 'Produk_model', 'Penjualan_model', 'Keranjang_model']);

        // Cek apakah user sudah login
        if (!$this->session->userdata('user')) {
            redirect('auth/login');
        }

        // Larang admin mengakses controller User (kompat angka/string)
        $role = $this->session->userdata('user')->role;
        $roleStr = is_string($role) ? strtolower($role) : (string) $role;
        if ($role === 0 || $role === '0' || $roleStr === 'admin') {
            redirect('admin');
        }
    }

    public function index()
    {
        // Data untuk dashboard user
        $data['products'] = $this->Produk_model->get_all_products();
        $data['cart_items'] = $this->Keranjang_model->get_cart_by_user($this->session->userdata('user')->id);
        $data['purchase_history'] = $this->Penjualan_model->get_purchase_history($this->session->userdata('user')->id);

        $this->load->view('user/dashboard', $data);
    }

    public function dashboard()
    {
        // Redirect ke index method
        $this->index();
    }

    public function add_to_cart()
    {
        $product_id = $this->input->post('product_id');
        $quantity = $this->input->post('quantity') ?: 1;
        $user_id = $this->session->userdata('user')->id;

        // Cek stok produk
        $product = $this->Produk_model->get_product_by_id($product_id);
        if (!$product || $product->stok < $quantity) {
            $this->session->set_flashdata('error', 'Stok tidak mencukupi!');
            redirect('user');
            return;
        }

        // Cek apakah sudah ada di keranjang
        $existing_cart = $this->Keranjang_model->get_cart_item($user_id, $product_id);
        if ($existing_cart) {
            // Update quantity
            $new_quantity = $existing_cart->quantity + $quantity;
            if ($product->stok < $new_quantity) {
                $this->session->set_flashdata('error', 'Stok tidak mencukupi!');
                redirect('user');
                return;
            }

            $this->Keranjang_model->update_cart_quantity($existing_cart->id, $new_quantity);
        } else {
            // Tambah ke keranjang
            $cart_data = [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'harga' => $product->harga
            ];
            $this->Keranjang_model->add_to_cart($cart_data);
        }

        $this->session->set_flashdata('success', 'Produk berhasil ditambahkan ke keranjang!');
        redirect('user');
    }

    public function remove_from_cart($cart_id)
    {
        $user_id = $this->session->userdata('user')->id;

        if ($this->Keranjang_model->remove_from_cart($cart_id, $user_id)) {
            $this->session->set_flashdata('success', 'Produk berhasil dihapus dari keranjang!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus produk dari keranjang!');
        }

        redirect('user');
    }

    public function checkout()
    {
        $user_id = $this->session->userdata('user')->id;
        $cart_items = $this->Keranjang_model->get_cart_by_user($user_id);

        if (empty($cart_items)) {
            $this->session->set_flashdata('error', 'Keranjang kosong!');
            redirect('user');
            return;
        }

        // Hitung total
        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item->harga * $item->quantity;
        }

        // Cek stok untuk semua item
        foreach ($cart_items as $item) {
            $product = $this->Produk_model->get_product_by_id($item->product_id);
            if ($product->stok < $item->quantity) {
                $this->session->set_flashdata('error', 'Stok produk ' . $product->nama . ' tidak mencukupi!');
                redirect('user');
                return;
            }
        }

        // Proses pembelian
        $this->db->trans_start();

        // Buat penjualan
        $sale_data = [
            'tanggal' => date('Y-m-d H:i:s'),
            'total' => $total,
            'kasir_id' => $user_id
        ];
        $sale_id = $this->Penjualan_model->create_sale($sale_data);

        // Buat detail penjualan dan update stok
        foreach ($cart_items as $item) {
            $detail_data = [
                'penjualan_id' => $sale_id,
                'produk_id' => $item->product_id,
                'jumlah' => $item->quantity,
                'subtotal' => $item->harga * $item->quantity
            ];
            $this->Penjualan_model->create_sale_detail($detail_data);

            // Update stok
            $this->Produk_model->reduce_stock($item->product_id, $item->quantity);
        }

        // Kosongkan keranjang
        $this->Keranjang_model->clear_cart($user_id);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal melakukan pembelian!');
        } else {
            $this->session->set_flashdata('success', 'Pembelian berhasil! Total: Rp ' . number_format($total, 0, ',', '.'));
        }

        redirect('user');
    }

    public function purchase_history()
    {
        $data['purchase_history'] = $this->Penjualan_model->get_purchase_history($this->session->userdata('user')->id);
        $this->load->view('user/purchase_history', $data);
    }
}