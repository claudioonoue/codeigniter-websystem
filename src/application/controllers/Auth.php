<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['form', 'url']);

        $this->load->model('user_model');
    }

    public function login()
    {
        if ($this->session->has_userdata('id')) {
            redirect('/');
        }
        if ($this->input->method(true) === 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('login_error', 'Email e senha são obrigatórios.');
                redirect('/auth/login');
            }

            if (count($this->user_model->fetch()) === 0) {
                $newAdminUser = new stdClass();
                $newAdminUser->email = 'admin@admin.com';
                $newAdminUser->password = '123456';
                $newAdminUser->fullName = 'Administrador';
                $newAdminUser->phone = '912345678';
                $newAdminUser->isAdmin = true;
                $newAdminUser->hasSystemAccess = true;
                $newAdminUser->isProvider = false;
                $newAdminUser->active = true;
                $this->user_model->prepare('insert', $newAdminUser);
                $this->user_model->insert();
            }

            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->user_model->fetchByEmail($email);

            if (!isset($user)) {
                $this->session->set_flashdata('login_error', 'Email e/ou senha inválidos.');
                redirect('/auth/login');
            }

            if (!password_verify($password, $user->password)) {
                $this->session->set_flashdata('login_error', 'Email e/ou senha inválidos.');
                redirect('/auth/login');
            }

            if ($user->active === '0' || $user->hasSystemAccess === '0' || $user->isProvider === '1') {
                $this->session->set_flashdata('login_error', 'Usuário não autorizado.');
                redirect('/auth/login');
            }

            $this->session->set_userdata([
                'id' => $user->id,
                'email' => $user->email,
                'fullName' => $user->fullName,
                'isAdmin' => $user->isAdmin,
            ]);

            redirect('/');
        } else {
            $this->load->view('Auth/login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/auth/login');
    }
}
