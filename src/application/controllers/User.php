<?php

class User extends CW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->JSFolder = '/assets/js/user/';

        $this->load->model('user_model');
    }

    public function index()
    {
        $this->loadJs([
            'index.js'
        ]);
        $this->loadView('User/index', ['title' => 'Usuários']);
    }

    public function create()
    {
        if ($this->input->method(true) === 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('fullName', 'Fullname', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('create_error', 'Verifique os campos obrigatórios.');
                redirect('/user/create');
            }

            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $fullName = $this->input->post('fullName');
            $phone = $this->input->post('phone');
            $isAdmin = $this->input->post('isAdmin');
            $hasSystemAccess = $this->input->post('hasSystemAccess');
            $isProvider = $this->input->post('isProvider');
            $active = $this->input->post('active');

            $usedEmail = $this->user_model->fetchByEmail($email);
            if (isset($usedEmail)) {
                $this->session->set_flashdata('create_error', 'Email em uso!');
                redirect('/user/create');
            }

            $newUser = new stdClass();
            $newUser->email = $email;
            $newUser->password = $password;
            $newUser->fullName = $fullName;
            $newUser->phone = $phone;
            $newUser->isAdmin = isset($isAdmin);
            $newUser->hasSystemAccess = isset($hasSystemAccess);
            $newUser->isProvider = isset($isProvider);
            $newUser->active = isset($active);
            $this->user_model->prepare('insert', $newUser);
            $this->user_model->insert();

            redirect('/user/index');
        } else {
            $this->loadJs([
                'create.js'
            ]);
            $this->loadView('User/create', ['title' => 'Usuários']);
        }
    }

    public function edit($id)
    {
        if (!isset($id) && $id === '') {
            redirect('/user/index');
        }
        $user = $this->user_model->fetchById($id);
        if (!isset($user)) {
            redirect('/user/index');
        }
        if ($this->input->method(true) === 'POST') {
            $this->form_validation->set_rules('fullName', 'Fullname', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('edit_error', 'Verifique os campos obrigatórios.');
                redirect('/user/edit/' . $id);
            }

            $password = $this->input->post('password');
            $newPassword = $this->input->post('newPassword');
            $fullName = $this->input->post('fullName');
            $phone = $this->input->post('phone');
            $isAdmin = $this->input->post('isAdmin');
            $hasSystemAccess = $this->input->post('hasSystemAccess');
            $isProvider = $this->input->post('isProvider');
            $active = $this->input->post('active');

            if ($password !== '' && $newPassword !== '') {
                if (!password_verify($password, $user->password)) {
                    $this->session->set_flashdata('edit_error', 'Senha antiga inválida.');
                    redirect('/user/edit/' . $id);
                }

                if (password_verify($newPassword, $user->password)) {
                    $this->session->set_flashdata('edit_error', 'A nova senha não pode ser a mesma que a antiga.');
                    redirect('/user/edit/' . $id);
                }
            }

            $newUserData = new stdClass();
            $newUserData->newPassword = $password !== '' && $newPassword !== '' ? $newPassword : null;
            $newUserData->password = $user->password;
            $newUserData->fullName = $fullName;
            $newUserData->phone = $phone;
            $newUserData->isAdmin = isset($isAdmin);
            $newUserData->hasSystemAccess = isset($hasSystemAccess);
            $newUserData->isProvider = isset($isProvider);
            $newUserData->active = isset($active);
            $this->user_model->prepare('update', $newUserData);
            $this->user_model->update($id);

            $this->session->set_flashdata('edit_success', 'Dados editados com sucesso.');
            redirect('/user/edit/' . $id);
        } else {
            $this->loadJs([
                'edit.js'
            ]);
            $this->loadView('User/edit', ['user' => $user]);
        }
    }
}
