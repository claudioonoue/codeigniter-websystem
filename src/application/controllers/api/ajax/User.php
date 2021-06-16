<?php

class User extends CW_API_AJAX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
    }

    public function list()
    {
        $users = array_map(function ($user) {
            return $user;
        }, $this->user_model->fetch());

        $count = count($users);

        $data = [
            'data' => $users,
            'itemsCount' => $count,
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($data));
    }
}
