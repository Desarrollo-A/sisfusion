<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Evidencias extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $this->load->model(array('Evidencias_model', 'General_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        
    }

    public function index()
    {
    }


    public function evidenciaPorLote()
    {
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("evidencias/evidenciaPorLote", $datos);
    }

    public function getTokensInformation()
    {
        $data['data'] = $this->caja_model_outside->getTokensInformation()->result_array();
        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    public function reviewTokenEvidence()
    {
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("token/reviewTokenEvidence", $datos);
    }

    public function validarToken()
    {
        if(isset($_POST) && !empty($_POST)){
            $data = array ("estatus" => $this->input->post("action"));
            $response = $this->General_model->updateRecord('tokens',  $data, 'id_token', $this->input->post("id"));
            echo json_encode($response);
        }

    }

}
