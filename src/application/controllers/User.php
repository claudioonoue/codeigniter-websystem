<?php

class User extends CW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->onlyAdmin();

        $this->JSFolder = '/assets/js/user/';

        $this->load->model('user_model');
        $this->load->model('address_model');
    }

    public function index()
    {
        $this->loadJs([
            'index.js'
        ]);
        $this->loadView('User/index', ['title' => 'Usuários']);
    }

    public function create()
    {
        if ($this->input->method(true) === 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('fullName', 'Fullname', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('create_error', 'Verifique os campos obrigatórios.');
                redirect('/user/create');
            }

            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $fullName = $this->input->post('fullName');
            $phone = $this->input->post('phone');
            $isAdmin = $this->input->post('isAdmin');
            $hasSystemAccess = $this->input->post('hasSystemAccess');
            $isProvider = $this->input->post('isProvider');
            $active = $this->input->post('active');

            $usedEmail = $this->user_model->fetchByEmail($email);
            if (isset($usedEmail)) {
                $this->session->set_flashdata('create_error', 'Email em uso!');
                redirect('/user/create');
            }

            $newUser = new stdClass();
            $newUser->email = $email;
            $newUser->password = $password;
            $newUser->fullName = $fullName;
            $newUser->phone = $phone;
            $newUser->isAdmin = isset($isAdmin);
            $newUser->hasSystemAccess = isset($hasSystemAccess);
            $newUser->isProvider = isset($isProvider);
            $newUser->active = isset($active);
            $this->user_model->prepare('insert', $newUser);
            $this->user_model->insert();

            redirect('/user');
        } else {
            $this->loadJs([
                'create.js'
            ]);
            $this->loadView('User/create', ['title' => 'Usuários']);
        }
    }

    public function edit($id)
    {
        if (!isset($id) && $id === '') {
            redirect('/user');
        }
        $user = $this->user_model->fetchById($id);
        if (!isset($user)) {
            redirect('/user');
        }
        if ($this->input->method(true) === 'POST') {
            if (($user->active === '0') && ($this->input->post('active') === NULL)) {
                $this->session->set_flashdata('edit_error', 'Ative o usuário para editá-lo.');
                redirect('/user/edit/' . $id);
            }

            $password = '';
            $newPassword = '';
            $fullName = $user->fullName;
            $phone = $user->phone;
            $isAdmin = $user->isAdmin === '1' ? true : NULL;
            $hasSystemAccess = $user->hasSystemAccess === '1' ? true : NULL;
            $isProvider = $user->isProvider === '1' ? true : NULL;

            if ($user->active === '1') {
                $this->form_validation->set_rules('fullName', 'Fullname', 'required');
                $this->form_validation->set_rules('phone', 'Phone', 'required');

                if ($this->form_validation->run() === false) {
                    $this->session->set_flashdata('edit_error', 'Verifique os campos obrigatórios.');
                    redirect('/user/edit/' . $id);
                }

                $password = $this->input->post('password');
                $newPassword = $this->input->post('newPassword');
                $fullName = $this->input->post('fullName');
                $phone = $this->input->post('phone');
                $isAdmin = $this->input->post('isAdmin');
                $hasSystemAccess = $this->input->post('hasSystemAccess');
                $isProvider = $this->input->post('isProvider');
            }

            $active = $this->input->post('active');

            if ($password !== '' && $newPassword !== '') {
                if (!password_verify($password, $user->password)) {
                    $this->session->set_flashdata('edit_error', 'Senha antiga inválida.');
                    redirect('/user/edit/' . $id);
                }

                if (password_verify($newPassword, $user->password)) {
                    $this->session->set_flashdata('edit_error', 'A nova senha não pode ser a mesma que a antiga.');
                    redirect('/user/edit/' . $id);
                }
            }

            $newUserData = new stdClass();
            $newUserData->newPassword = $password !== '' && $newPassword !== '' ? $newPassword : null;
            $newUserData->password = $user->password;
            $newUserData->fullName = $fullName;
            $newUserData->phone = $phone;
            $newUserData->isAdmin = isset($isAdmin);
            $newUserData->hasSystemAccess = isset($hasSystemAccess);
            $newUserData->isProvider = isset($isProvider);
            $newUserData->active = isset($active);
            $this->user_model->prepare('update', $newUserData);
            $this->user_model->update($id);

            $neededAddresses = $user->isProvider === '1' ? 2 : ($user->isAdmin === '0' ? 1 : 0);
            if ($user->active && $neededAddresses > 0) {
                $manipulateAddressesSuccess = $this->manipulateAddresses('insert', $user->id, $neededAddresses);
                if ($manipulateAddressesSuccess === false) {
                    $this->session->set_flashdata('edit_error', 'Verifique os campos de endereço obrigatórios.');
                    redirect('/user/edit/' . $id);
                }
            }

            $this->session->set_flashdata('edit_success', 'Dados editados com sucesso.');
            redirect('/user/edit/' . $id);
        } else {
            $addresses = $this->address_model->fetchByUserId($user->id);
            $this->loadJs([
                'edit.js'
            ]);
            $this->loadView('User/edit', ['user' => $user, 'addresses' => $addresses]);
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

        $this->address_model->delete($userId);

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
        $this->address_model->insert();

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
            $this->address_model->insert();
        }

        return true;
    }
}
