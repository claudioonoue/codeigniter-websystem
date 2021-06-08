<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CW_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function loadView($view, $data)
    {
        $this->template->load('template', $view, $data);
    }
}
