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

        $users = array_map(function ($user) {
            return $user;
        }, $this->user_model->fetchWithoutLoggedUser($id, $fullName, $email, $this->limit, $this->offset));

        $count = count($this->user_model->fetchWithoutLoggedUser($id, $fullName, $email, count($this->user_model->fetch()), 1));

        $data = [
            'data' => $users,
            'itemsCount' => $count,
        ];

        $this->toJSON($data, 200);
    }
}
