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

        $users = array_map(function ($user) {
            return $user;
        }, $this->user_model->fetchWithoutLoggedUser($id, $this->limit, $this->offset));

        $count = count($this->user_model->fetch());

        $data = [
            'data' => $users,
            'itemsCount' => $count,
        ];

        $this->toJSON($data, 200);
    }
}
