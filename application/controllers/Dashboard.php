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
        // Redirect admin ke admin dashboard
        if ($this->session->userdata('user')->role == 0) {
            redirect('admin');
        }

        // Redirect user ke user dashboard
        redirect('user');
    }
}
