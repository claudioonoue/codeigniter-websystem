<?php

class User extends CW_API_AJAX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->onlyAdmin();

        $this->load->model('user_model');
    }

    public function list()
    {
        $id = $this->session->userdata('id');

        $fullName = $this->input->get('fullName') !== NULL ? $this->input->get('fullName') : '';
        $email = $this->input->get('email') !== NULL ? $this->input->get('email') : '';
        $isAdmin = $this->input->get('isAdmin') !== NULL && $this->input->get('isAdmin') !== '-1' ? $this->input->get('isAdmin') : '';
        $hasSystemAccess = $this->input->get('hasSystemAccess') !== NULL && $this->input->get('hasSystemAccess') !== '-1' ? $this->input->get('hasSystemAccess') : '';
        $isProvider = $this->input->get('isProvider') !== NULL && $this->input->get('isProvider') !== '-1' ? $this->input->get('isProvider') : '';
        $active = $this->input->get('active') !== NULL && $this->input->get('active') !== '-1' ? $this->input->get('active') : '';
        $totalAddresses = $this->input->get('totalAddresses') !== NULL && $this->input->get('totalAddresses') !== '-1' ? $this->input->get('totalAddresses') : '';

        $users = array_map(function ($user) {
            return $user;
        }, $this->user_model->fetchWithoutLoggedUser(
            $id,
            $fullName,
            $email,
            $isAdmin,
            $hasSystemAccess,
            $isProvider,
            $active,
            $totalAddresses,
            $this->limit,
            $this->offset
        ));

        $count = count($this->user_model->fetchWithoutLoggedUser(
            $id,
            $fullName,
            $email,
            $isAdmin,
            $hasSystemAccess,
            $isProvider,
            $active,
            $totalAddresses,
            count($this->user_model->fetch()),
            1
        ));

        $data = [
            'data' => $users,
            'itemsCount' => $count,
        ];

        $this->toJSON($data, 200);
    }
}
