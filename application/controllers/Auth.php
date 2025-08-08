<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function register()
    {
        if ($this->input->post()) {
            // Validasi input
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');

            // Cek apakah username sudah ada
            if ($this->User_model->get_by_username($username)) {
                $this->session->set_flashdata('error', 'Username sudah ada!');
                redirect('auth/register');
                return;
            }

            // Cek password confirmation
            if ($password !== $confirm_password) {
                $this->session->set_flashdata('error', 'Password tidak sama!');
                redirect('auth/register');
                return;
            }

            $data = [
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 1 // Level 1 = User (default)
            ];

            if ($this->User_model->insert_user($data)) {
                $this->session->set_flashdata('success', 'Registrasi berhasil!');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Gagal melakukan registrasi!');
                redirect('auth/register');
            }
        }
        $this->load->view('auth/register');
    }

    public function login()
    {
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->User_model->get_by_username($username);
            if ($user && password_verify($password, $user->password)) {
                $this->session->set_userdata('user', $user);
                $this->session->set_flashdata('success', 'Login berhasil! Selamat datang, ' . $user->username);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah!');
                redirect('auth/login');
            }
        }
        $this->load->view('auth/login');
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        redirect('auth/login');
    }
}
