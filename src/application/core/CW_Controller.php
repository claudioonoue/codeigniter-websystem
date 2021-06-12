<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CW_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session']);
        $this->load->helper(['url']);

        if (!$this->session->has_userdata('id')) {
            redirect('/auth/login');
        }
    }

    public function loadView($view, $data)
    {
        $this->template->load('template', $view, $data);
    }
}
