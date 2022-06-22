<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Neo_data extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');

        $this->load->model(array('Clientes_model', 'caja_model_outside','General_model', 'Neodata_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        
    }

    public function getCondominio()
    {
        $data = json_decode((file_get_contents("php://input")));
        
        if (!isset($data->nombre_condominio)){
            echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."), JSON_UNESCAPED_UNICODE);
        } else {
            if ($data->nombre_condominio == ""){
                echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."), JSON_UNESCAPED_UNICODE);
            }
            else{
                $result = $this->Neodata_model->getCondominio($data->nombre_condominio);
                if (count($result) > 0){
                    $idCondominio = $result[0]['idCondominio'];
                    echo json_encode(array("status" => 200, "message" => "El registro se ha encontrado de manera exitosa.", "idCondominio" => $idCondominio), JSON_UNESCAPED_UNICODE);
                }
                else{
                    echo json_encode(array("status" => 400, "message" => "No se encontro ningún registro."), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }


}