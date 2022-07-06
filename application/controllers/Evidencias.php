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

    public function evidenciaUser()
    {
        $this->load->view('template/header');
        $this->load->view("evidencias/evidencias_user");
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

    public function uploadToDropbox(){
        $file = $_FILES["file"];
        print_r($file);
        $api_url = 'https://content.dropboxapi.com/2/files/upload'; //dropbox api url
        $token = 'sl.BK5bb1HozS1lmZtu-xcWcGEEdMDis8VMPCxD3fSc2QHOfIYNnctJ6BdnM73oooFPdWqM9k4Sm3E8au3FA0McYl6FIfSThPKWRxyRM0Kr9s7tAcJV8vO7Bt2IIlDLZOUiRmmFEvM'; // oauth token

        $headers = array('Authorization: Bearer '. $token,
            'Content-Type: application/octet-stream',
            'Dropbox-API-Arg: '.
            json_encode(
                array(
                    "path"=> '/Test/'. basename($file["name"]),
                    "mode" => "add",
                    "autorename" => true,
                    "mute" => false
                )
            )

        );

        $ch = curl_init($api_url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);

        $path = $file['tmp_name'];
        $fp = fopen($path, 'rb');
        $filesize = filesize($path);

        curl_setopt($ch, CURLOPT_POSTFIELDS, fread($fp, $filesize));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_VERBOSE, 1); // debug

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo($response.'<br/>');
        echo($http_code.'<br/>');

        curl_close($ch);
    }

}
