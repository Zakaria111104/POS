<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_income_today()
    {
        $today = date('Y-m-d');
        $query = $this->db->query("SELECT SUM(total) as total FROM penjualan WHERE DATE(tanggal) = ?", array($today));
        $result = $query->row();
        return $result->total ? $result->total : 0;
    }

    public function get_income_month()
    {
        $month = date('Y-m');
        $query = $this->db->query("SELECT SUM(total) as total FROM penjualan WHERE DATE_FORMAT(tanggal, '%Y-%m') = ?", array($month));
        $result = $query->row();
        return $result->total ? $result->total : 0;
    }

    public function get_recent_sales($limit = 5)
    {
        $this->db->select('penjualan.*, users.username as kasir_name');
        $this->db->from('penjualan');
        $this->db->join('users', 'users.id = penjualan.kasir_id', 'left');
        $this->db->order_by('penjualan.tanggal', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function get_all_sales()
    {
        $this->db->select('penjualan.*, users.username as kasir_name');
        $this->db->from('penjualan');
        $this->db->join('users', 'users.id = penjualan.kasir_id', 'left');
        $this->db->order_by('penjualan.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    // Method untuk menambahkan data sample
    public function add_sample_data()
    {
        // Cek apakah sudah ada data
        $count = $this->db->count_all('penjualan');
        if ($count > 0) {
            return false; // Sudah ada data
        }

        // Ambil user pertama sebagai kasir
        $user = $this->db->get('users')->row();
        if (!$user) {
            return false; // Tidak ada user
        }

        $sample_data = array(
            array(
                'tanggal' => date('Y-m-d H:i:s'),
                'total' => 150000,
                'kasir_id' => $user->id
            ),
            array(
                'tanggal' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'total' => 200000,
                'kasir_id' => $user->id
            ),
            array(
                'tanggal' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'total' => 175000,
                'kasir_id' => $user->id
            )
        );

        return $this->db->insert_batch('penjualan', $sample_data);
    }

    public function create_sale($data)
    {
        $this->db->insert('penjualan', $data);
        return $this->db->insert_id();
    }

    public function create_sale_detail($data)
    {
        return $this->db->insert('penjualan_detail', $data);
    }

    public function get_purchase_history($user_id)
    {
        $this->db->select('penjualan.*, penjualan_detail.jumlah, penjualan_detail.subtotal, produk.nama as nama_produk');
        $this->db->from('penjualan');
        $this->db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id');
        $this->db->join('produk', 'produk.id = penjualan_detail.produk_id');
        $this->db->where('penjualan.kasir_id', $user_id);
        $this->db->order_by('penjualan.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function get_sales_by_user($user_id)
    {
        $this->db->select('penjualan.*, users.username as customer_name');
        $this->db->from('penjualan');
        $this->db->join('users', 'users.id = penjualan.kasir_id');
        $this->db->where('penjualan.kasir_id', $user_id);
        $this->db->order_by('penjualan.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all_transactions()
    {
        $this->db->select('penjualan.*, users.username as customer_name');
        $this->db->from('penjualan');
        $this->db->join('users', 'users.id = penjualan.kasir_id', 'left');
        $this->db->order_by('penjualan.tanggal', 'DESC');
        return $this->db->get()->result();
    }
}