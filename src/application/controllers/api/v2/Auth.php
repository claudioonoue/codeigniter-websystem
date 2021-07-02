<?php

class Auth extends CW_API_V2_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation']);
        $this->load->helper(['form']);

        $this->load->model('user_model');
    }

    public function create_session()
    {
        if ($this->input->method(true) === 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === false) {
                $this->toJSONError('Email e senha são obrigatórios', 400);
                return;
            }

            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->user_model->fetchByEmail($email);

            if (!isset($user)) {
                $this->toJSONError('Email e/ou senha inválidos', 401);
                return;
            }

            if (!password_verify($password, $user->password)) {
                $this->toJSONError('Email e/ou senha inválidos', 401);
                return;
            }

            if ($user->active === '0' || $user->hasSystemAccess === '0' || $user->isProvider === '1') {
                $this->toJSONError('Usuário não autorizado', 401);
                return;
            }

            $exp = new DateTime();
            $exp->setTimestamp($exp->getTimestamp() + $this->config->item('jwt_exp_time'));

            $token = jwt::encode([
                'id' => $user->id,
                'email' => $user->email,
                'exp' => $exp->getTimestamp(),
            ], $this->config->item('jwt_secret_key'));

            $this->toJSON([
                'token' => $token,
            ], 200);
        } else {
            $this->toJSONError('Método não permitido', 405);
        }
    }
}
