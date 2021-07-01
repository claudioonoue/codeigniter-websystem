<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CW_API_V2_Controller extends CI_Controller
{
    public $limit;
    public $offset;
    public $tokenData;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url']);

        $token = $this->input->get_request_header('Authorization', TRUE);

        if (uri_string() !== 'api/v2/auth/create_session') {
            if (!isset($token)) {
                header('Content-Type: application/json');
                http_response_code(401);
                echo json_encode([
                    'message' => 'Token não informada',
                    'success' => false,
                ]);
                exit;
            } else {
                $error = $this->decodeToken(explode(' ', $token)[1]);

                if (isset($error)) {
                    header('Content-Type: application/json');
                    http_response_code(401);
                    echo json_encode([
                        'message' => 'Token inválida',
                        'success' => false,
                    ]);
                    exit;
                }

                $now = new DateTime();

                if ($this->tokenData->exp < $now->getTimestamp()) {
                    header('Content-Type: application/json');
                    http_response_code(401);
                    echo json_encode([
                        'message' => 'Token expirada',
                        'success' => false,
                    ]);
                    exit;
                }
            }
        }

        $this->limit = intval($this->input->get('limit'));
        $this->offset = intval(($this->input->get('page') - 1) * $this->limit);
    }

    public function toJSON($data, $statusCode)
    {
        $this->output->set_status_header($statusCode)->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function toJSONError($message, $statusCode)
    {
        $this->output->set_status_header($statusCode)->set_content_type('application/json')->set_output(json_encode([
            'message' => $message,
            'success' => false,
        ]));
    }

    public function decodeToken($token)
    {
        try {
            $tokenData = jwt::decode($token, $this->config->item('jwt_secret_key'), true);
            $this->tokenData = $tokenData;
            return NULL;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
