<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    /** @var bool|null */
    private $roleColumnIsNumeric = null;
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

    /**
     * Determine whether the `users.role` column is numeric (int/tinyint/etc.).
     */
    private function is_role_column_numeric(): bool
    {
        if ($this->roleColumnIsNumeric !== null) {
            return $this->roleColumnIsNumeric;
        }
        $query = $this->db->query("SHOW COLUMNS FROM `users` LIKE 'role'");
        $row = $query->row();
        $type = $row ? strtolower($row->Type) : '';
        $this->roleColumnIsNumeric = (strpos($type, 'int') !== false || strpos($type, 'decimal') !== false || strpos($type, 'float') !== false);
        return $this->roleColumnIsNumeric;
    }

    /**
     * Get storage value for role name based on DB column type.
     * Supports two schemas:
     * - numeric (0=admin, 1=user)
     * - string ('admin'/'user')
     */
    public function get_role_value_for(string $roleName)
    {
        $normalized = strtolower(trim($roleName));
        if ($this->is_role_column_numeric()) {
            return $normalized === 'admin' ? 0 : 1;
        }
        return $normalized === 'admin' ? 'admin' : 'user';
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
