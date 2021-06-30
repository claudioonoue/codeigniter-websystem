<?php

class Order extends CW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->JSFolder = '/assets/js/order/';

        $this->load->model('order_model');
        $this->load->model('order_product_model');
        $this->load->model('user_model');
        $this->load->model('product_model');
    }

    public function index()
    {
        $this->loadJs([
            'index.js'
        ]);
        $this->loadView('Order/index', ['title' => 'Pedidos']);
    }

    public function create()
    {
        if ($this->input->method(true) === 'POST') {
            $this->form_validation->set_rules('providerId', 'Provider ID', 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('create_error', 'Verifique os campos obrigatórios.');
                redirect('/order/create');
            }

            $productsSequence = $this->input->post('productsSequence');

            if (!isset($productsSequence) || $productsSequence === '') {
                $this->session->set_flashdata('create_error', 'É necessário ao menos 1 produto para salvar o pedido!');
                redirect('/order/create');
            }

            $arrProductsSequence = explode(',', $productsSequence);

            $products = [];

            foreach ($arrProductsSequence as $sequence) {
                $this->form_validation->set_rules('inpSelectProduct-' . $sequence, 'inpSelectProduct-' . $sequence, 'required');
                $this->form_validation->set_rules('inpValue-' . $sequence, 'inpValue-' . $sequence, 'required');
                $this->form_validation->set_rules('inpQuantity-' . $sequence, 'inpQuantity-' . $sequence, 'required');

                $product = new stdClass();
                $product->productId = $this->input->post('inpSelectProduct-' . $sequence);
                $product->productValue = $this->input->post('inpValue-' . $sequence);
                $product->productQuantity = $this->input->post('inpQuantity-' . $sequence);

                array_push($products, $product);
            }

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('create_error', 'Verifique os campos obrigatórios dos produtos.');
                redirect('/order/create');
            }

            $providerId = $this->input->post('providerId');
            $contributorId = $this->session->has_userdata('id');
            $observations = $this->input->post('observations');
            $finished = false;

            $newOrder = new stdClass();
            $newOrder->providerId = $providerId;
            $newOrder->contributorId = $contributorId;
            $newOrder->observations = $observations;
            $newOrder->finished = $finished;

            $this->order_model->cleanModel();
            $this->order_model->prepare('insert', $newOrder);
            $orderId = $this->order_model->insert();

            foreach ($products as $product) {
                $newOrderProduct = new stdClass();
                $newOrderProduct->orderId = $orderId;
                $newOrderProduct->productId = $product->productId;
                $newOrderProduct->unitPrice = $product->productValue;
                $newOrderProduct->quantity = $product->productQuantity;

                $this->order_product_model->cleanModel();
                $this->order_product_model->prepare('insert', $newOrderProduct);
                $this->order_product_model->insert();
            }

            redirect('/order');
        } else {
            $providers = $this->user_model->fetchProviders();
            $this->loadJs([
                'create.js'
            ]);
            $this->loadView('Order/create', [
                'providers' => $providers,
            ]);
        }
    }

    public function edit($id)
    {
        if (!isset($id) && $id === '') {
            redirect('/order');
        }
        $order = $this->order_model->fetchById($id);
        if (!isset($order)) {
            redirect('/order');
        }
        if ($this->input->method(true) === 'POST') {
            if ($order->finished === '1') {
                redirect('/order/edit/' . $id);
            }

            $this->form_validation->set_rules('providerId', 'Provider ID', 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('edit_error', 'Verifique os campos obrigatórios.');
                redirect('/order/edit/' . $id);
            }

            $productsSequence = $this->input->post('productsSequence');

            if (!isset($productsSequence) || $productsSequence === '') {
                $this->session->set_flashdata('edit_error', 'É necessário ao menos 1 produto para salvar o pedido!');
                redirect('/order/edit/' . $id);
            }

            $arrProductsSequence = explode(',', $productsSequence);

            $products = [];

            foreach ($arrProductsSequence as $sequence) {
                $this->form_validation->set_rules('inpSelectProduct-' . $sequence, 'inpSelectProduct-' . $sequence, 'required');
                $this->form_validation->set_rules('inpValue-' . $sequence, 'inpValue-' . $sequence, 'required');
                $this->form_validation->set_rules('inpQuantity-' . $sequence, 'inpQuantity-' . $sequence, 'required');

                $product = new stdClass();
                $product->productId = $this->input->post('inpSelectProduct-' . $sequence);
                $product->productValue = $this->input->post('inpValue-' . $sequence);
                $product->productQuantity = $this->input->post('inpQuantity-' . $sequence);

                array_push($products, $product);
            }

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('edit_error', 'Verifique os campos obrigatórios dos produtos.');
                redirect('/order/edit/' . $id);
            }

            $providerId = $this->input->post('providerId');
            $observations = $this->input->post('observations');
            $finished = false;

            $newOrderData = new stdClass();
            $newOrderData->providerId = $providerId;
            $newOrderData->observations = $observations;
            $newOrderData->finished = $finished;

            $this->order_model->cleanModel();
            $this->order_model->prepare('update', $newOrderData);
            $this->order_model->update($order->id);

            $this->order_product_model->deleteByOrderId($order->id);

            foreach ($products as $product) {
                $newOrderProductData = new stdClass();
                $newOrderProductData->orderId = $order->id;
                $newOrderProductData->productId = $product->productId;
                $newOrderProductData->unitPrice = $product->productValue;
                $newOrderProductData->quantity = $product->productQuantity;

                $this->order_product_model->cleanModel();
                $this->order_product_model->prepare('insert', $newOrderProductData);
                $this->order_product_model->insert();
            }

            $this->session->set_flashdata('edit_success', 'Dados editados com sucesso.');
            redirect('/order/edit/' . $id);
        } else {
            $providers = $this->user_model->fetchProviders();
            $orderProducts = $this->order_product_model->fetchByOrderId($order->id);
            $products = $this->product_model->fetch();
            $this->loadJs([
                'edit.js'
            ]);
            $this->loadView('Order/edit', [
                'order' => $order,
                'orderProducts' => $orderProducts,
                'providers' => $providers,
                'products' => $products,
            ]);
        }
    }

    public function finish($id)
    {
        if (!isset($id) && $id === '') {
            redirect('/order');
        }
        $order = $this->order_model->fetchById($id);
        if (!isset($order)) {
            redirect('/order');
        }
        if ($order->finished === '1') {
            redirect('/order/edit/' . $id);
        }

        $providerId = $order->providerId;
        $observations = $order->observations;
        $finished = true;

        $newOrderData = new stdClass();
        $newOrderData->providerId = $providerId;
        $newOrderData->observations = $observations;
        $newOrderData->finished = $finished;

        $this->order_model->cleanModel();
        $this->order_model->prepare('update', $newOrderData);
        $this->order_model->update($order->id);

        redirect('/order/edit/' . $id);
    }

    public function delete($id)
    {
        if (!isset($id) && $id === '') {
            redirect('/order');
        }
        $order = $this->order_model->fetchById($id);
        if (!isset($order)) {
            redirect('/order');
        }
        if ($order->finished === '1') {
            redirect('/order/edit/' . $id);
        }

        $this->order_product_model->deleteByOrderId($order->id);
        $this->order_model->delete($id);

        redirect('/order');
    }
}
