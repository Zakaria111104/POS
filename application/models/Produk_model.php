<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_products()
    {
        return $this->db->get('produk')->result();
    }

    public function count_products()
    {
        return $this->db->count_all('produk');
    }

    public function get_product_by_id($id)
    {
        return $this->db->get_where('produk', ['id' => $id])->row();
    }

    public function insert_product($data)
    {
        return $this->db->insert('produk', $data);
    }

    public function update_product($id, $data)
    {
        return $this->db->update('produk', $data, ['id' => $id]);
    }

    public function delete_product($id)
    {
        return $this->db->delete('produk', ['id' => $id]);
    }

    // Method untuk menambahkan data sample produk
    public function add_sample_products()
    {
        // Cek apakah sudah ada data
        $count = $this->db->count_all('produk');
        if ($count > 0) {
            return false; // Sudah ada data
        }

        $sample_products = array(
            array(
                'nama' => 'Laptop Asus',
                'harga' => 8500000,
                'stok' => 10,
                'gambar' => 'laptop.jpg'
            ),
            array(
                'nama' => 'Mouse Gaming',
                'harga' => 250000,
                'stok' => 25,
                'gambar' => 'mouse.jpg'
            ),
            array(
                'nama' => 'Keyboard Mechanical',
                'harga' => 1200000,
                'stok' => 15,
                'gambar' => 'keyboard.jpg'
            ),
            array(
                'nama' => 'Monitor 24"',
                'harga' => 1800000,
                'stok' => 8,
                'gambar' => 'monitor.jpg'
            )
        );

        return $this->db->insert_batch('produk', $sample_products);
    }

    public function reduce_stock($product_id, $quantity)
    {
        $this->db->set('stok', 'stok - ' . (int) $quantity, FALSE);
        $this->db->where('id', $product_id);
        return $this->db->update('produk');
    }
}