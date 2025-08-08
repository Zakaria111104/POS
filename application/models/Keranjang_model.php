<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keranjang_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_cart_by_user($user_id)
    {
        $this->db->select('keranjang.*, produk.nama as nama_produk, produk.gambar');
        $this->db->from('keranjang');
        $this->db->join('produk', 'produk.id = keranjang.product_id');
        $this->db->where('keranjang.user_id', $user_id);
        return $this->db->get()->result();
    }

    public function get_cart_item($user_id, $product_id)
    {
        return $this->db->get_where('keranjang', [
            'user_id' => $user_id,
            'product_id' => $product_id
        ])->row();
    }

    public function add_to_cart($data)
    {
        return $this->db->insert('keranjang', $data);
    }

    public function update_cart_quantity($cart_id, $quantity)
    {
        return $this->db->update('keranjang', ['quantity' => $quantity], ['id' => $cart_id]);
    }

    public function remove_from_cart($cart_id, $user_id)
    {
        return $this->db->delete('keranjang', ['id' => $cart_id, 'user_id' => $user_id]);
    }

    public function clear_cart($user_id)
    {
        return $this->db->delete('keranjang', ['user_id' => $user_id]);
    }

    public function get_cart_total($user_id)
    {
        $this->db->select_sum('harga * quantity', 'total');
        $this->db->where('user_id', $user_id);
        $result = $this->db->get('keranjang')->row();
        return $result->total ? $result->total : 0;
    }

    public function get_cart_count($user_id)
    {
        $this->db->select_sum('quantity');
        $this->db->where('user_id', $user_id);
        $result = $this->db->get('keranjang')->row();
        return $result->quantity ? $result->quantity : 0;
    }
}