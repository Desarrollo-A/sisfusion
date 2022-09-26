<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Suma extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Suma_model', 'General_model'));
        $this->load->library(array('session', 'form_validation', 'Jwt_actions'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        // $this->jwt_actions->authorize_externals('3450', apache_request_headers()["Authorization"]);
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
                if (!isset($result->id_rol))
                    echo json_encode(array("status" => 401, "message" => "No se logró autenticar el usuario."), JSON_UNESCAPED_UNICODE);
                else {
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

    public function sumServ(){
        $data_json = json_decode((file_get_contents("php://input")));
        $request = array();
        $valido = true;
        foreach ($data_json as &$data) {
            if (!isset($data->id_cliente) || !isset($data->total_venta) || !isset($data->comisionistas) || !isset($data->nombre_cliente) || !isset($data->id_pago) || !isset($data->referencia)){
                echo json_encode(array("status" => 402, "message" => "Algún parámetro no viene en el array general."), JSON_UNESCAPED_UNICODE);
                $valido = false;
                break;
            }
            else {
                if ($data->id_cliente == "" || $data->total_venta == "" || $data->comisionistas == "" || $data->nombre_cliente == "" || $data->id_pago == ""|| $data->referencia == ""){
                    echo json_encode(array("status" => 402, "message" => "Algún parámetro no tiene un valor en el array general."), JSON_UNESCAPED_UNICODE);
                    $valido = false;
                    break;
                }
                else {
                    if( count( $data->comisionistas )==0 ){
                        echo json_encode(array("status" => 402, "message" => "Debe de venir al menos un comisionista."), JSON_UNESCAPED_UNICODE);
                        $valido = false;
                        break;
                    }
                    else{
                        $arrayComisiones[] = array(
                            'total_venta' => $data->total_venta,
                            'id_cliente' => $data->id_cliente,
                            'nombre_cliente' => $data->nombre_cliente,
                            'id_pago' => $data->id_pago,
                            'referencia' => $data->referencia
                        );
                        
                        foreach ($data->comisionistas as &$valor) {
                            if ( !isset($valor->id_rol) || !isset($valor->id_usuario) || !isset($valor->porcentaje_comision) || !isset($valor->total_comision) || !isset($data->referencia) ){
                                echo json_encode(array("status" => 402, "message" => "Algún parámetro no viene en el array del comisionista."), JSON_UNESCAPED_UNICODE);
                                $valido = false;
                                break;

                            }
                            else{
                                if ($valor->id_rol == "" || $valor->id_usuario == "" || $valor->porcentaje_comision == "" || $data->nombre_cliente == "" || $data->id_pago == ""|| $valor->total_comision == "" || $data->referencia == "" ){
                                    echo json_encode(array("status" => 402, "message" => "Algún parámetro no tiene un valor en el array del comisionista."), JSON_UNESCAPED_UNICODE);
                                    $valido = false;
                                    break;
                                }
                                else{
                                    $arrayPagos[] = array(
                                        'id_rol' => $valor->id_rol,
                                        'id_usuario' => $valor->id_usuario,
                                        'porcentaje_comision' => $valor->porcentaje_comision,
                                        'total_comision' => $valor->total_comision,
                                        'referencia' => $data->referencia
                                    );
                                }
                                
                            }
                        }
                    }
                }
            }
        }
        
        if($valido){
            $result = $this->Suma_model->setComisionesPagos($arrayComisiones, $arrayPagos);
            if($result){
                array_push($request, array("status" => 200, "message" => "Los registros se han ingresado de manera exitosa."));
            }
            else
                array_push($request, array("status" => 400, "message" => "Oops, ocurrió un error al insertar los registros"));

            echo(json_encode($request, JSON_UNESCAPED_UNICODE));
        }
    }
}


