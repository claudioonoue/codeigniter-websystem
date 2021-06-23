<?php

class Product extends CW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->JSFolder = '/assets/js/product/';

        $this->load->model('product_model');
    }

    public function index()
    {
        $this->loadJs([
            'index.js'
        ]);
        $this->loadView('Product/index', ['title' => 'Produtos']);
    }

    public function create()
    {
        if ($this->input->method(true) === 'POST') {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('create_error', 'Verifique os campos obrigatórios.');
                redirect('/product/create');
            }

            $name = $this->input->post('name');
            $description = $this->input->post('description');
            $active = $this->input->post('active');

            $newProduct = new stdClass();
            $newProduct->name = $name;
            $newProduct->description = $description;
            $newProduct->active = isset($active);
            $this->product_model->prepare('insert', $newProduct);
            $this->product_model->insert();

            redirect('/product');
        } else {
            $this->loadJs([
                'create.js'
            ]);
            $this->loadView('Product/create', []);
        }
    }

    public function edit($id)
    {
        if (!isset($id) && $id === '') {
            redirect('/product');
        }
        $product = $this->product_model->fetchById($id);
        if (!isset($product)) {
            redirect('/product');
        }
        if ($this->input->method(true) === 'POST') {
            if (($product->active === '0') && ($this->input->post('active') === NULL)) {
                $this->session->set_flashdata('edit_error', 'Ative o produto para editá-lo.');
                redirect('/product/edit/' . $id);
            }

            $name = $product->name;
            $description = $product->description;

            if ($product->active === '1') {
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('description', 'Description', 'required');

                if ($this->form_validation->run() === false) {
                    $this->session->set_flashdata('edit_error', 'Verifique os campos obrigatórios.');
                    redirect('/product/edit/' . $id);
                }

                $name = $this->input->post('name');
                $description = $this->input->post('description');
            }

            $active = $this->input->post('active');

            $newProductData = new stdClass();
            $newProductData->name = $name;
            $newProductData->description = $description;
            $newProductData->active = isset($active);
            $this->product_model->prepare('update', $newProductData);
            $this->product_model->update($id);

            $this->session->set_flashdata('edit_success', 'Dados editados com sucesso.');
            redirect('/product/edit/' . $id);
        } else {
            $this->loadJs([
                'edit.js'
            ]);
            $this->loadView('Product/edit', ['product' => $product]);
        }
    }
}
