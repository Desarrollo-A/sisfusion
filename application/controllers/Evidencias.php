<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Evidencias extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $this->load->model(array('Evidencias_model', 'General_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu', 'jwt_actions'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    }

    public function index()
    {
    }


    public function evidenciaPorLote()
    {
        $this->load->view('template/header');
        $this->load->view("evidencias/evidenciaPorLote");
    }

    public function evidenciaUser()
    {
        $response = $this->jwt_actions->validateToken($_GET['jwt']);
        $res = json_decode($response);
        if($res->status == 200){
            $validation = $this->Evidencias_model->validateRecords($res->data->data)->result_array();
            if(count($validation) <= 0){
                $datos['information'] = $res->data;
                $this->load->view('template/header');
                $this->load->view("evidencias/evidencias_user", $datos);
            }else{
                $datos['information'] = false;
                $this->load->view('template/header');
                $this->load->view("evidencias/evidencias_user", $datos);
            }
           
        }else{
            echo('a donde vaquero');
        }
        
    }

    public function getDropboxToken(){
        $oauth_url = "https://x2lo5zybskv36p6:dkptwnk6hrbne2m@api.dropbox.com/oauth2/token";
        $token = '-AA44PRdHUYAAAAAAAAAAV1bjrWAGsYa80flvAFtOqHlBROPsYnzInSrjDDHIJWX'; // oauth token
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $oauth_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    "grant_type=refresh_token&refresh_token=$token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_decode($response);
    }

    public function uploadToDropbox(){
        $file = $_FILES["file"];
        $data = json_decode($_POST['data']);
        $token = $this->getDropboxToken()->access_token;
        $api_url = 'https://content.dropboxapi.com/2/files/upload'; //dropbox api url
        $name = "Evidencia_".$data->idCliente."_".$data->idLote.date('Y-m-d').basename($file["name"]);
        $headers = array('Authorization: Bearer '. $token,
            "Dropbox-API-Select-User: dbmid:AACiFGk3sK8Eozce52KTBVX5JuOUTQsWnYE",
            'Content-Type: application/octet-stream',
            'Dropbox-API-Arg: '.
            json_encode(
                array(
                    "path"=> "/Test/$name",
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
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($http_code == 200){
            $dataToInsert = array(
                "idCliente" => $data->idCliente,
                "idLote" => $data->idLote,
                "nombre_archivo" => $name,
                "tipo" => 1,
                "estatus" => 1
            );
            $this->General_model->addRecord('video_evidencia',$dataToInsert);
            curl_close($ch);
            echo json_encode($response);
        }else{
            echo json_encode(array());

        }
    }

    public function getClient(){
        $idLote = $this->input->post("idLote");
        $data = $this->Evidencias_model->getClient($idLote)->row();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }    
    }

    public function viewDropboxFile(){
        $videoNombre = $this->input->post("videoNombre");
        $token = $this->getDropboxToken()->access_token;
        $parameters = array('path' => "/Test/$videoNombre");

        $headers = array("Authorization: Bearer $token",
                        "Dropbox-API-Select-User: dbmid:AACiFGk3sK8Eozce52KTBVX5JuOUTQsWnYE",
                        'Content-Type: application/json');

        $curlOptions = array(
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($parameters),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_VERBOSE => true
            );

        $ch = curl_init('https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings');
        curl_setopt_array($ch, $curlOptions);

        $response = curl_exec($ch);

        curl_close($ch);

        echo json_encode($response);

    }

    public function generateToken()
    {
        $this->load->view('template/header');
        $this->load->view("token/generateToken");
    }

    public function getEvidencesInformation()
    {
        $data['data'] = $this->Evidencias_model->getEvidencesInformation()->result_array();
        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    public function reviewEvidences()
    {
        $this->load->view('template/header');
        $this->load->view("token/reviewTokenEvidence");
    }

    public function validateEvidence()
    {
        if(isset($_POST) && !empty($_POST)){
            $type = $this->input->post("type");
            $action = $this->input->post("action");
            if ($type == 1) // MJ: EVIDENCIA BBVA
                $response = $this->General_model->updateRecord('tokens',  array ("estatus" => $action), 'id_token', $this->input->post("id"));
            else if ($type == 2) // MJ: EVIDENCIA VIDEO
                $response = $this->General_model->updateRecord('video_evidencia',  $action == 2 ? array ("estatus" => 0, "estatus_validacion" => $action) : array ("estatus_validacion" => $action), 'id_video', $this->input->post("id"));
            echo json_encode($response);
        }
    }

}
