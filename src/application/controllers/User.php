<?php

class User extends CW_Controller
{
    public function index()
    {
        $this->loadView('User/index', []);
    }

    public function create()
    {
        echo 'Create';
    }

    public function edit()
    {
        echo 'Edit';
    }
}
