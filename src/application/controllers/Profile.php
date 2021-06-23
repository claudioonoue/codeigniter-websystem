<?php

class Profile extends CW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->JSFolder = '/assets/js/profile/';

        $this->load->model('user_model');
        $this->load->model('address_model');
    }

    public function index()
    {
        $id = $this->session->userdata('id');
        if (!isset($id) && $id === '') {
            redirect('/');
        }
        $user = $this->user_model->fetchById($id);
        if (!isset($user)) {
            redirect('/');
        }
        if ($this->input->method(true) === 'POST') {
            $this->form_validation->set_rules('fullName', 'Fullname', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('edit_error', 'Verifique os campos obrigatórios.');
                redirect('/profile');
            }

            $password = $this->input->post('password');
            $newPassword = $this->input->post('newPassword');
            $fullName = $this->input->post('fullName');
            $phone = $this->input->post('phone');
            $isAdmin = $this->input->post('isAdmin');
            $hasSystemAccess = $this->input->post('hasSystemAccess');
            $isProvider = $this->input->post('isProvider');
            $active = $this->input->post('active');

            if ($password !== '' && $newPassword !== '') {
                if (!password_verify($password, $user->password)) {
                    $this->session->set_flashdata('edit_error', 'Senha antiga inválida.');
                    redirect('/profile');
                }

                if (password_verify($newPassword, $user->password)) {
                    $this->session->set_flashdata('edit_error', 'A nova senha não pode ser a mesma que a antiga.');
                    redirect('/profile');
                }
            }

            $newUserData = new stdClass();
            $newUserData->newPassword = $password !== '' && $newPassword !== '' ? $newPassword : null;
            $newUserData->password = $user->password;
            $newUserData->fullName = $fullName;
            $newUserData->phone = $phone;
            $newUserData->isAdmin = $user->isAdmin === '1' ? isset($isAdmin) : ($user->isAdmin === '1');
            $newUserData->hasSystemAccess = $user->isAdmin === '1' ? isset($hasSystemAccess) : ($user->hasSystemAccess === '1');
            $newUserData->isProvider = $user->isAdmin === '1' ? isset($isProvider) : ($user->isProvider === '1');
            $newUserData->active = $user->isAdmin === '1' ? isset($active) : ($user->active === '1');
            $this->user_model->prepare('update', $newUserData);
            $this->user_model->update($id);

            $neededAddresses = $user->isProvider === '1' ? 2 : ($user->isAdmin === '0' ? 1 : 0);
            if ($neededAddresses > 0) {
                $manipulateAddressesSuccess = $this->manipulateAddresses(intval($user->totalAddresses) === 0 ? 'insert' : 'update', $user->id, $neededAddresses);
                if ($manipulateAddressesSuccess === false) {
                    $this->session->set_flashdata('edit_error', 'Verifique os campos de endereço obrigatórios.');
                    redirect('/profile');
                }
            }

            $this->session->set_flashdata('edit_success', 'Dados editados com sucesso.');
            redirect('/profile');
        } else {
            $addresses = $this->address_model->fetchByUserId($user->id);
            $this->loadJs([
                'index.js'
            ]);
            $this->loadView('Profile/index', ['user' => $user, 'addresses' => $addresses]);
        }
    }

    private function manipulateAddresses($operation, $userId, $neededAddresses)
    {
        $this->form_validation->set_rules('firstZipCode', 'FirstZipCode', 'required');
        $this->form_validation->set_rules('firstAddress', 'FirstAddress', 'required');
        $this->form_validation->set_rules('firstNumber', 'FirstNumber', 'required');
        $this->form_validation->set_rules('firstNeighborhood', 'FirstNeighborhood', 'required');
        $this->form_validation->set_rules('firstCity', 'FirstCity', 'required');
        $this->form_validation->set_rules('firstState', 'FirstState', 'required');
        $this->form_validation->set_rules('firstCountry', 'FirstCountry', 'required');

        if ($neededAddresses > 1) {
            $this->form_validation->set_rules('secondZipCode', 'SecondZipCode', 'required');
            $this->form_validation->set_rules('secondAddress', 'SecondAddress', 'required');
            $this->form_validation->set_rules('secondNumber', 'SecondNumber', 'required');
            $this->form_validation->set_rules('secondNeighborhood', 'SecondNeighborhood', 'required');
            $this->form_validation->set_rules('secondCity', 'SecondCity', 'required');
            $this->form_validation->set_rules('secondState', 'SecondState', 'required');
            $this->form_validation->set_rules('secondCountry', 'SecondCountry', 'required');
        }

        if ($this->form_validation->run() === false) {
            return false;
        }

        $firstZipCode = $this->input->post('firstZipCode');
        $firstAddress = $this->input->post('firstAddress');
        $firstNumber = $this->input->post('firstNumber');
        $firstComplement = $this->input->post('firstComplement');
        $firstNeighborhood = $this->input->post('firstNeighborhood');
        $firstCity = $this->input->post('firstCity');
        $firstState = $this->input->post('firstState');
        $firstCountry = $this->input->post('firstCountry');

        $firstAddressObj = new stdClass();
        $firstAddressObj->userId = $userId;
        $firstAddressObj->addressOrdenation = 1;
        $firstAddressObj->zipCode = $firstZipCode;
        $firstAddressObj->address = $firstAddress;
        $firstAddressObj->number = $firstNumber;
        $firstAddressObj->complement = $firstComplement;
        $firstAddressObj->neighborhood = $firstNeighborhood;
        $firstAddressObj->city = $firstCity;
        $firstAddressObj->state = $firstState;
        $firstAddressObj->country = $firstCountry;
        $firstAddressObj->active = true;

        $this->address_model->cleanModel();
        $this->address_model->prepare($operation, $firstAddressObj);
        if ($operation === 'insert') {
            $this->address_model->insert();
        } else {
            $this->address_model->update($userId, 1);
        }

        if ($neededAddresses > 1) {
            $secondZipCode = $this->input->post('secondZipCode');
            $secondAddress = $this->input->post('secondAddress');
            $secondNumber = $this->input->post('secondNumber');
            $secondComplement = $this->input->post('secondComplement');
            $secondNeighborhood = $this->input->post('secondNeighborhood');
            $secondCity = $this->input->post('secondCity');
            $secondState = $this->input->post('secondState');
            $secondCountry = $this->input->post('secondCountry');

            $secondAddressObj = new stdClass();
            $secondAddressObj->userId = $userId;
            $secondAddressObj->addressOrdenation = 2;
            $secondAddressObj->zipCode = $secondZipCode;
            $secondAddressObj->address = $secondAddress;
            $secondAddressObj->number = $secondNumber;
            $secondAddressObj->complement = $secondComplement;
            $secondAddressObj->neighborhood = $secondNeighborhood;
            $secondAddressObj->city = $secondCity;
            $secondAddressObj->state = $secondState;
            $secondAddressObj->country = $secondCountry;
            $secondAddressObj->active = true;

            $this->address_model->cleanModel();
            $this->address_model->prepare($operation, $secondAddressObj);
            if ($operation === 'insert') {
                $this->address_model->insert();
            } else {
                $this->address_model->update($userId, 2);
            }
        }

        return true;
    }
}
