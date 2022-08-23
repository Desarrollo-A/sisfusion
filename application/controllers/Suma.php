<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Suma extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Suma_model'));
        $this->load->library(array('session', 'form_validation', 'Jwt_actions'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->jwt_actions->authorize_externals('3450', apache_request_headers()["Authorization"]);
    }

    public function index() {}

    public function validateUserAccess() {
        $data = json_decode(file_get_contents("php://input"));
        if (!isset($data->id_asesor) || !isset($data->contrasena))
            echo json_encode(array("status" => 401, "message" => "Algún parámetro no viene informado. Verifique que todos los parámetros requeridos se incluyan en la petición."), JSON_UNESCAPED_UNICODE);
        else {
            if ($data->id_asesor == '' || $data->contrasena == '')
                echo json_encode(array("status" => 401, "message" => "Algún parámetro no tiene un valor especificado. Verifique que todos los parámetros contengan un valor especificado."), JSON_UNESCAPED_UNICODE);
            else {
                $result = $this->Suma_model->getUserInformation($data->id_asesor, encriptar($data->contrasena));
                if ($result->id_rol != 7)
                    echo json_encode(array("status" => 401, "message" => "Los datos ingresados no corresponde a un ID de usuario con rol de asesor."), JSON_UNESCAPED_UNICODE);
                else {
                    if ($result->estatus != 1)
                        echo json_encode(array("status" => 401, "message" => "El usuario ingresado no se encuentra activo."), JSON_UNESCAPED_UNICODE);
                    else {
                        echo json_encode(array("status" => 200, "message" => "Autenticado exitosamente.", 
                        "id_asesor" => $result->id_asesor, "nombre_asesor" => $result->nombre_asesor,
                        "id_coordinador" => $result->id_coordinador, "nombre_coordinador" => $result->nombre_coordinador,
                        "id_gerente" => $result->id_gerente, "nombre_gerente" => $result->nombre_gerente,
                        "id_subdirector" => $result->id_subdirector, "nombre_subdirector" => $result->nombre_subdirector,
                        "id_regional" => $result->id_regional, "nombre_regional" => $result->nombre_regional), JSON_UNESCAPED_UNICODE);
                    }
                }
            }
        }
    }
}


