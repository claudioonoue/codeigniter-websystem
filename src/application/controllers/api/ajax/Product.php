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
        $name = $this->input->get('name') !== NULL ? $this->input->get('name') : '';
        $description = $this->input->get('description') !== NULL ? $this->input->get('description') : '';
        $active = $this->input->get('active') !== NULL && $this->input->get('active') !== '-1' ? $this->input->get('active') : '';

        $products = array_map(function ($product) {
            return $product;
        }, $this->product_model->ajaxFetch($name, $description, $active, $this->limit, $this->offset));

        $count = count($this->product_model->ajaxFetch($name, $description, $active, count($this->product_model->fetch()), 1));

        $data = [
            'data' => $products,
            'itemsCount' => $count,
        ];

        $this->toJSON($data, 200);
    }

    public function list_all()
    {
        $products = array_map(function ($product) {
            return $product;
        }, $this->product_model->fetchActive());

        $count = count($products);

        $data = [
            'data' => $products,
            'itemsCount' => $count,
        ];

        $this->toJSON($data, 200);
    }
}
