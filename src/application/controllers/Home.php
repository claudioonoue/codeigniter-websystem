<?php

class Home extends CW_Controller
{
    public function index()
    {
        $this->loadView('Home/index', []);
    }
}
