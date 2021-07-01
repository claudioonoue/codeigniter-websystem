<?php

class Home extends CW_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('order_model');
        $this->load->model('product_model');
    }

    public function index()
    {
        $totalOrders = count($this->order_model->fetch());
        $totalOrdersNotFinished = count($this->order_model->fetchNotFinished());
        $totalProducts = count($this->product_model->fetch());
        $totalProductsDeactivated = count($this->product_model->fetchInative());
        $this->loadView('Home/index', [
            'totalOrders' => $totalOrders,
            'totalOrdersNotFinished' => $totalOrdersNotFinished,
            'totalProducts' => $totalProducts,
            'totalProductsDeactivated' => $totalProductsDeactivated,
        ]);
    }
}
