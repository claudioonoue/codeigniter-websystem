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
        }, $this->product_model->ajaxFetch($this->limit, $this->offset));

        $count = count($this->product_model->fetch());

        $data = [
            'data' => $products,
            'itemsCount' => $count,
        ];

        $this->toJSON($data, 200);
    }
}
