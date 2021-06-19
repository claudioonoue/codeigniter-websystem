<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CW_Controller extends CI_Controller
{
    public $JSFolder;

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);

        if (!$this->session->has_userdata('id')) {
            redirect('/auth/login');
        }
    }

    public function onlyAdmin()
    {
        if ($this->session->userdata('isAdmin') === '0') {
            redirect('/');
        }
    }

    public function loadView($view, $data)
    {
        $this->template->load('template', $view, $data);
    }

    public function loadJS($files)
    {
        $files = array_map(function ($item) {
            return $this->JSFolder . $item;
        }, $files);
        $this->template->set('js', $files);
    }
}
