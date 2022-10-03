<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Suma extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Suma_model', 'General_model', 'Comisiones_model', 'PagoInvoice_model', 'Usuarios_modelo'));
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

    public function comisiones_suma(){
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $datos['sub_menu'] = $this->get_menu->get_submenu_data($this->session->userdata('id_rol'), $this->session->userdata('id_usuario'));
        $datos["opn_cumplimiento"] = $this->Usuarios_modelo->Opn_cumplimiento($this->session->userdata('id_usuario'))->result_array();

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

    public function guardar_solicitud($usuario = ''){
        $validar_user = $this->session->userdata('id_usuario');
        $validar_sede =   $usuarioid =$this->session->userdata('id_sede');
  
        date_default_timezone_set('America/Mexico_City');       
        $fecha_actual = strtotime(date("d-m-Y H:i:00"));
  
        //fecha inicio
        // $fecha_entrada2 = strtotime("07-02-2022 00:00:00");
        // $fecha_entrada3 = strtotime("07-03-2022 00:00:00");
        // $fecha_entrada4 = strtotime("11-04-2022 00:00:00");
        // $fecha_entrada5 = strtotime("09-05-2022 00:00:00");
        // $fecha_entrada6 = strtotime("13-06-2022 00:00:00");
        // $fecha_entrada7 = strtotime("11-07-2022 00:00:00");
        // $fecha_entrada8 = strtotime("08-08-2022 00:00:00");
        // $fecha_entrada9 = strtotime("12-09-2022 00:00:00");
        // $fecha_entrada10 = strtotime("10-10-2022 00:00:00");
        // $fecha_entrada11 = strtotime("07-11-2022 00:00:00");
        // $fecha_entrada12 = strtotime("12-12-2022 00:00:00");
        //fecha fin
        
        // if($validar_sede == 8){
        //   $fecha_entrada22 = strtotime("08-02-2022 15:59:00");
        //   $fecha_entrada33 = strtotime("08-03-2022 15:59:00");
        //   $fecha_entrada44 = strtotime("12-04-2022 15:59:00");
        //   $fecha_entrada55 = strtotime("10-05-2022 15:59:00");
        //   $fecha_entrada66 = strtotime("14-06-2022 15:59:00");
        //   $fecha_entrada77 = strtotime("12-07-2022 15:59:00");
        //   $fecha_entrada88 = strtotime("09-08-2022 15:59:00");
        //   $fecha_entrada99 = strtotime("13-09-2022 15:59:00");
        //   $fecha_entrada100 = strtotime("11-10-2022 15:59:00");
        //   $fecha_entrada111 = strtotime("08-11-2022 15:59:00");
        //   $fecha_entrada122 = strtotime("13-12-2022 15:59:00");
        // }else{
        //   $fecha_entrada22 = strtotime("08-02-2022 13:59:00");
        //   $fecha_entrada33 = strtotime("08-03-2022 13:59:00");
        //   $fecha_entrada44 = strtotime("12-04-2022 13:59:00");
        //   $fecha_entrada55 = strtotime("10-05-2022 13:59:00");
        //   $fecha_entrada66 = strtotime("14-06-2022 13:59:00");
        //   $fecha_entrada77 = strtotime("12-07-2022 13:59:00");
        //   $fecha_entrada88 = strtotime("09-08-2022 13:59:00");
        //   $fecha_entrada99 = strtotime("13-09-2022 13:59:00");
        //   $fecha_entrada100 = strtotime("11-10-2022 13:59:00");
        //   $fecha_entrada111 = strtotime("08-11-2022 13:59:00");
        //   $fecha_entrada122 = strtotime("13-12-2022 13:59:00");
  
        // }
  
        // $resultado = array("resultado" => 3);
  
        // if(($fecha_actual >= $fecha_entrada2 && $fecha_actual <= $fecha_entrada22) ||
        //   ($fecha_actual >= $fecha_entrada3 && $fecha_actual <= $fecha_entrada33) ||
        //   ($fecha_actual >= $fecha_entrada4 && $fecha_actual <= $fecha_entrada44) || 
        //   ($fecha_actual >= $fecha_entrada5 && $fecha_actual <= $fecha_entrada55) ||
        //   ($fecha_actual >= $fecha_entrada6 && $fecha_actual <= $fecha_entrada66) ||
        //   ($fecha_actual >= $fecha_entrada7 && $fecha_actual <= $fecha_entrada77) ||
        //   ($fecha_actual >= $fecha_entrada8 && $fecha_actual <= $fecha_entrada88) ||
        //   ($fecha_actual >= $fecha_entrada9 && $fecha_actual <= $fecha_entrada99) || 
        //   ($fecha_actual >= $fecha_entrada10 && $fecha_actual <=$fecha_entrada100) ||
        //   ($fecha_actual >= $fecha_entrada11 && $fecha_actual <=$fecha_entrada111) ||
        //   ($fecha_actual >= $fecha_entrada12 && $fecha_actual <=$fecha_entrada122) ){
            if($usuario != ''){
              $usuarioid = $usuario;
            }
            else{
              $usuarioid =$this->session->userdata('id_usuario');
            }
       
            $datos = explode(",",$this->input->post('pagos'));
            $resultado = array("resultado" => TRUE);
            if( (isset($_POST) && !empty($_POST)) || ( isset( $_FILES ) && !empty($_FILES) ) ){
              $this->db->trans_begin();
              $responsable = $this->session->userdata('id_usuario');
              $resultado = TRUE;
              if( isset( $_FILES ) && !empty($_FILES) ){
                $config['upload_path'] = './UPLOADS/XMLS/';
                $config['allowed_types'] = 'xml';
                $this->load->library('upload', $config);
                $resultado = $this->upload->do_upload("xmlfile");
                if( $resultado ){
                  $xml_subido = $this->upload->data();
                  $datos_xml = $this->Comisiones_model->leerxml( $xml_subido['full_path'], TRUE );
  
                  $total = (float)$this->input->post('total');
                  $totalXml = (float)$datos_xml['total'];
  
                  if (($total + .50) >= $totalXml && ($total - .50) <= $totalXml) {
                    $nuevo_nombre = date("my")."_";
                    $nuevo_nombre .= str_replace( array(",", ".", '"'), "", str_replace( array(" ", "/"), "_", limpiar_dato($datos_xml["nameEmisor"]) ))."_";
                    $nuevo_nombre .= date("Hms")."_";
                    $nuevo_nombre .= rand(4, 100)."_";
                    $nuevo_nombre .= substr($datos_xml["uuidV"], -5).".xml";
                    rename( $xml_subido['full_path'], "./UPLOADS/XMLS/".$nuevo_nombre );
                    $datos_xml['nombre_xml'] = $nuevo_nombre;
                    ini_set('max_execution_time', 0);
                    for ($i=0; $i <count($datos) ; $i++) { 
                      if(!empty($datos[$i])){
                        $id_com =  $datos[$i];
                        $this->Suma_model->insertar_factura($id_com, $datos_xml,$usuarioid);
                        $this->Suma_model->update_acepta_solicitante($id_com);
                        $this->db->query("INSERT INTO historial_suma VALUES (".$id_com.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'COLABORADOR ENVÍO FACTURA A CONTRALORÍA')");
                      }
                    }
                  } 
                  else {
                    $this->db->trans_rollback();
                    echo json_encode(4);
                    return;
                  }
                }
                else {
                  $resultado["mensaje"] = $this->upload->display_errors();
                }
              }
              
              if ( $resultado === FALSE || $this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $resultado = array("resultado" => FALSE);
              }
              else{
                $this->db->trans_commit();
                $resultado = array("resultado" => TRUE);
              }
            }
  
            $this->Usuarios_modelo->Update_OPN($this->session->userdata('id_usuario'));
            echo json_encode( $resultado );
          // }
          // else{
          //   echo json_encode(3);
          // }
        }
}


