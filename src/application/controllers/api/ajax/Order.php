<?php

class Order extends CW_API_AJAX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('order_model');
    }

    public function list()
    {
        $provider = $this->input->get('provider') !== NULL ? $this->input->get('provider') : '';
        $contributor = $this->input->get('contributor') !== NULL ? $this->input->get('contributor') : '';
        $observations = $this->input->get('observations') !== NULL ? $this->input->get('observations') : '';
        $finished = $this->input->get('finished') !== NULL && $this->input->get('finished') !== '-1' ? $this->input->get('finished') : '';

        $orders = array_map(function ($order) {
            return $order;
        }, $this->order_model->ajaxFetch($provider, $contributor, $observations, $finished, $this->limit, $this->offset));

        $count = count($this->order_model->ajaxFetch($provider, $contributor, $observations, $finished, count($this->order_model->fetch()), 1));

        $data = [
            'data' => $orders,
            'itemsCount' => $count,
        ];

        $this->toJSON($data, 200);
    }
}
