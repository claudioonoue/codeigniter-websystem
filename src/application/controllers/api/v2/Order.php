<?php

class Order extends CW_API_V2_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('order_model');
        $this->load->model('order_product_model');
        $this->load->model('user_model');
        $this->load->model('address_model');
    }

    public function list_finished()
    {
        $orders = array_map(function ($order) {
            $provider = $this->user_model->fetchById($order->providerId, true);
            $provider->addresses = $this->address_model->fetchByUserId($order->providerId, true);
            $contributor = $this->user_model->fetchById($order->contributorId, true);
            $contributor->addresses = $this->address_model->fetchByUserId($order->contributorId, true);
            $products = $this->order_product_model->fetchAPIByOrderId($order->id);

            $responseOrder = new stdClass();
            $responseOrder->order = $order;
            $responseOrder->products = $products;
            $responseOrder->provider = $provider;
            $responseOrder->contributor = $contributor;

            return $responseOrder;
        }, $this->order_model->fetchFinished($this->limit, $this->offset));

        $this->toJSON($orders, 200);
    }
}
