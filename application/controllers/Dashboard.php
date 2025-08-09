<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // Cek apakah user sudah login
        if (!$this->session->userdata('user')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        // Redirect admin ke admin dashboard (kompat angka/string)
        $role = $this->session->userdata('user')->role;
        $roleStr = is_string($role) ? strtolower($role) : (string) $role;
        if ($role === 0 || $role === '0' || $roleStr === 'admin') {
            redirect('admin');
        }

        // Redirect user ke user dashboard
        redirect('user');
    }
}
