<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CW_API_AJAX_Controller extends CI_Controller
{
    public $limit;
    public $offset;

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session']);
        $this->load->helper(['url']);

        if (!$this->session->has_userdata('id')) {
            redirect('/auth/login');
        }

        $this->limit = intval($this->input->get('pageSize'));
        $this->offset = intval(($this->input->get('pageIndex') - 1) * $this->limit);
    }

    public function onlyAdmin()
    {
        if ($this->session->userdata('isAdmin') === '0') {
            redirect('/');
        }
    }

    public function toJSON($data, $statusCode)
    {
        $this->output->set_status_header($statusCode)->set_content_type('application/json')->set_output(json_encode($data));
    }
}
