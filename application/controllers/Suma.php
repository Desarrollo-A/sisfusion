<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Suma extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Suma_model', 'General_model', 'Comisiones_model', 'PagoInvoice_model'));
        $this->load->library(array('session', 'form_validation', 'Jwt_actions', 'get_menu'));
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
                if (!isset($result->rol_asesor))
                    echo json_encode(array("status" => 401, "message" => "No se logró autenticar el usuario."), JSON_UNESCAPED_UNICODE);
                else {
                    if ($result->rol_asesor != 7)
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

    public function comisiones_suma(){
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $datos['sub_menu'] = $this->get_menu->get_submenu_data($this->session->userdata('id_rol'), $this->session->userdata('id_usuario'));
    
        
        $this->load->view('template/header');
        $this->load->view("Ventas/comisiones_suma", $datos);
    }

    public function getComisionesByStatus(){
        $data = $this->Suma_model->getComisionesByStatus($_POST['estatus']);
        echo json_encode($data);
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

    public function getHistorial($pago){
        echo json_encode($this->Suma_model->getHistorial($pago)->result_array());
    }

    public function acepto_comisiones_user(){
        $id_user_Vl = $this->session->userdata('id_usuario');
        $formaPagoUsuario = $this->session->userdata('forma_pago');
        $sol=$this->input->post('idcomision');  
        $consulta_comisiones = $this->db->query("SELECT id_pago_suma FROM pagos_suma where id_pago_suma IN (".$sol.")");
        $opinionCumplimiento = $this->Comisiones_model->findOpinionActiveByIdUsuario($id_user_Vl);
       
        if( $consulta_comisiones->num_rows() > 0 ){
            $consulta_comisiones = $consulta_comisiones->result_array();
            $sep = ',';
            $id_pago_i = '';

            $data=array();
            $pagoInvoice = array();

            foreach ($consulta_comisiones as $row) {
                $id_pago_i .= implode($sep, $row);
                $id_pago_i .= $sep;

                $row_arr=array(
                    'id_pago' => $row['id_pago_suma'],
                    'id_usuario' =>  $id_user_Vl,
                    'fecha_movimiento' => date('Y-m-d H:i:s'),
                    'estatus' => 2,
                    'comentario' =>  'COLABORADOR ENVÍO A CONTRALORÍA' 
                );
                array_push($data,$row_arr);

                if ($formaPagoUsuario == 5) { // Pago extranjero
                    $pagoInvoice[] = array(
                    'id_pago_i' => $row['id_pago_suma'],
                    'nombre_archivo' => $opinionCumplimiento->archivo_name,
                    'estatus' => 2,
                    'modificado_por' => $id_user_Vl,
                    'fecha_registro' => date('Y-m-d H:i:s')
                    );
                }
            }
            $id_pago_i = rtrim($id_pago_i, $sep);
        
            $up_b = $this->Suma_model->update_acepta_solicitante($id_pago_i);
            $ins_b = $this->Suma_model->insert_historial($data);
            // $this->Comisiones_model->changeEstatusOpinion($id_user_Vl);
            if ($formaPagoUsuario == 5) {
                $this->PagoInvoice_model->insertMany($pagoInvoice);
            }
          
            if($up_b == true && $ins_b == true){
                $data_response = 1;
                echo json_encode($data_response);
            } else {
                $data_response = 0;
                echo json_encode($data_response);
            } 
            
        }
        else{
            $data_response = 0;
            echo json_encode($data_response);
        }
    }
}


