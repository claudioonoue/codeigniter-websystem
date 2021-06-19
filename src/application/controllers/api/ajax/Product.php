<?php

class Product extends CW_API_AJAX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('product_model');
    }

    public function list()
    {
        $products = array_map(function ($product) {
            return $product;
        }, $this->product_model->fetch());

        $count = count($products);

        $data = [
            'data' => $products,
            'itemsCount' => $count,
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($data));
    }
}
