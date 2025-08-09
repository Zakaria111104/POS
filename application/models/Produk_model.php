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
                'nama' => 'Meja Makan',
                'harga' => 350000,
                'stok' => 3,
                'gambar' => 'Meja.jpg'
            ),
            array(
                'nama' => 'Kursi Kantor',
                'harga' => 400000,
                'stok' => 4,
                'gambar' => 'Kursi Kantor.jpg'
            ),
            array(
                'nama' => 'Kasur Spring Bed',
                'harga' => 800000,
                'stok' => 2,
                'gambar' => 'Spring Bed.jpg'
            ),
            array(
                'nama' => 'Lemari Pakaian Plastik',
                'harga' => 650000,
                'stok' => 10,
                'gambar' => 'Lemari Plastik.jpg'
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