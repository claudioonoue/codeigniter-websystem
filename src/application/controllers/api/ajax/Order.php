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
        $observations = $this->input->get('observations') !== NULL ? $this->input->get('observations') : '';

        $orders = array_map(function ($order) {
            return $order;
        }, $this->order_model->ajaxFetch($observations, $this->limit, $this->offset));

        $count = count($this->order_model->ajaxFetch($observations, count($this->order_model->fetch()), 1));

        $data = [
            'data' => $orders,
            'itemsCount' => $count,
        ];

        $this->toJSON($data, 200);
    }
}
