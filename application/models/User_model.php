<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert_user($data)
    {
        return $this->db->insert('users', $data);
    }

    public function get_by_username($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row();
    }

    // Admin methods
    public function get_all_users()
    {
        return $this->db->get('users')->result();
    }

    public function count_users()
    {
        return $this->db->count_all('users');
    }

    public function delete_user($id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }

    public function get_user_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function update_user($id, $data)
    {
        return $this->db->update('users', $data, ['id' => $id]);
    }
}
