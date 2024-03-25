<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class SegurosComision extends CI_Controller
{
  private $gph;
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Comisiones_model');
    $this->load->model('asesor/Asesor_model');
    $this->load->model('Usuarios_modelo');
    $this->load->model('PagoInvoice_model');
    $this->load->model('General_model');
    $this->load->model('Pagos_model');
    $this->load->model('Seguros_comision_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('4141', $_SERVER['HTTP_HOST']);
    $this->validateSession();

      $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
      $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
      $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
      $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
  }

  public function validateSession() {
    if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
      redirect(base_url() . "index.php/login");
  }

  public function getDatosNuevasAsimiladosSeguros(){

    if($this->session->userdata('id_rol') == 31){
      $filtro1 = $this->input->post('puesto');  
      $filtro2 = $this->input->post('usuario'); 
      
    }else{
      $filtro1 = $this->input->post('proyecto');  
      $filtro2 = $this->input->post('condominio'); 
    }
    
    $dat =  $this->Seguros_comision_model->getDatosNuevasAsimiladosSeguros($filtro1,$filtro2);
    
    for( $i = 0; $i < count($dat); $i++ ){
        $dat[$i]['pa'] = 0;
    }
    echo json_encode( array( "data" => $dat));
  }

  public function getDatosNuevasRemanenteSeguros(){
    $proyecto = $this->input->post('proyecto');  
    $condominio =   $this->input->post('condominio');
    $dat =  $this->Seguros_comision_model->getDatosNuevasRemanenteSeguros($proyecto,$condominio);
    for( $i = 0; $i < count($dat); $i++ ){
      $dat[$i]['pa'] = 0;
    }
    echo json_encode( array( "data" => $dat));
  }

  public function getDatosNuevasFacturasSeguros(){
    $proyecto = $this->input->post('proyecto');  
    $condominio =   $this->input->post('condominio');  
    $dat =  $this->Seguros_comision_model->getDatosNuevasFacturasSeguros($proyecto,$condominio);
    for( $i = 0; $i < count($dat); $i++ ){
      $dat[$i]['pa'] = 0;
    }
    echo json_encode( array( "data" => $dat));
  }

  public function updateRevisionaInternomex(){
    $sol=$this->input->post('idcomision');  
    $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_seguro_ind where id_pago_i IN (".$sol.")");
      if( $consulta_comisiones->num_rows() > 0 ){
        $consulta_comisiones = $consulta_comisiones->result_array();
        $id_user_Vl = $this->session->userdata('id_usuario');
          $sep = ',';
          $id_pago_i = '';
          $data=array();
          foreach ($consulta_comisiones as $row) {
            $id_pago_i .= implode($sep, $row);
            $id_pago_i .= $sep;

            $row_arr=array(
              'id_pago_i' => $row['id_pago_i'],
              'id_usuario' =>  $id_user_Vl,
              'fecha_movimiento' => date('Y-m-d H:i:s'),
              'estatus' => 1,
              'comentario' =>  'CONTRALORÍA ENVÍO PAGO A INTERNOMEX' 
            );
              array_push($data,$row_arr);
          }
          $id_pago_i = rtrim($id_pago_i, $sep);
            $arrayUpdateControlaria = array(
              'estatus' => 8,
              'modificado_por' => $id_user_Vl
            );
            $up_b = $this->Seguros_comision_model->update_acepta_contraloria($arrayUpdateControlaria , $id_pago_i);
            $ins_b = $this->Seguros_comision_model->insert_phc($data);
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

  public function lista_usuarios(){
    $rol = $this->input->post("rol");
    $forma_pago = $this->input->post("forma_pago");
    $respuesta = $this->Seguros_comision_model->get_lista_usuarios($rol,$forma_pago);
    echo json_encode($respuesta);
  }

  public function pago_internomex(){
    $id_pago_is = $this->input->post('idcomision');  
    $consulta_comisiones = $this->Seguros_comision_model->consultaComisiones($id_pago_is);

      if( $consulta_comisiones != 0 ){
        $id_user_Vl = $this->session->userdata('id_usuario');
        $sep = ',';
        $id_pago_i = '';
        $data=array();

          foreach ($consulta_comisiones as $row) {
            $id_pago_i .= implode($sep, $row);
            $id_pago_i .= $sep;

            $row_arr=array(
              'id_pago_i' => $row['id_pago_i'],
              'id_usuario' =>   $this->session->userdata('id_usuario'),
              'fecha_movimiento' => date('Y-m-d H:i:s'),
              'estatus' => 1,
              'comentario' =>  'INTERNOMEX APLICÓ PAGO' 
            );
            array_push($data,$row_arr);
          }
          $id_pago_i = rtrim($id_pago_i, $sep);
            
            $up_b = $this->Seguros_comision_model->update_acepta_INTMEX($id_pago_i);
            $ins_b = $this->Seguros_comision_model->insert_phc($data);
      
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

  public function getReporteEmpresa(){
    echo json_encode($this->Pagos_model->report_empresa());
  }

  public function getDesarrolloSelectINTMEX(){

      $value = $this->input->post("desarrollo");
      if($value == ''){
      echo json_encode($this->Seguros_comision_model->getDesarrolloSelectINTMEX()->result_array());
    }else{
      echo json_encode($this->Seguros_comision_model->getDesarrolloSelectINTMEX($value)->result_array());
    }
  }

  public function getPagosByProyect($proyect, $formap){
    
    if(empty($proyect)){
      echo json_encode($this->Seguros_comision_model->getPagosByProyect());
    }else{
      echo json_encode($this->Seguros_comision_model->getPagosByProyect($proyect,$formap));
    }
  }

  function pausar_solicitud(){
    $respuesta = array( FALSE );
    if($this->input->post("id_pago")){
      $respuesta = array( $this->Comisiones_model->update_estatus_pausa( $this->input->post("id_pago_i"), $this->input->post("observaciones")));
    }
    echo json_encode( $respuesta );
  }

  function IntMexPagadosByProyect(){
    date_default_timezone_set('America/Mexico_City');
    $idsessionado = $this->session->userdata('id_usuario');
    $idsPagos = $this->input->post("ids");
    $sep = ',';
    $id_pago_i = '';
    //$cadena_equipo = '';
    $data = array();
      for($i=0; $i <count($idsPagos) ; $i++) { 
        $id_pago_i = implode(",", $idsPagos);
        // $id_pago_i .= implode($sep, $idsPagos);
        //  $id_pago_i .= $sep;
        $row_arr=array(
          'id_pago_i' => $idsPagos[$i],
          'id_usuario' =>  $idsessionado,
          'fecha_movimiento' => date('Y-m-d H:i:s'),
          'estatus' => 1,
          'comentario' =>  'INTERNOMEX APLICO PAGO' 
        );
        array_push($data,$row_arr);
      }
      Ini_set('max_execution_time', 0);

      $up_b = $this->Seguros_comision_model->update_acepta_INTMEX($id_pago_i);
      $ins_b = $this->Seguros_comision_model->insert_phc($data);

    if($up_b == true && $ins_b == true){
      $data_response = 1;
      echo json_encode($data_response);
    } else {
      $data_response = 0;
      echo json_encode($data_response);
    }
  }

  function despausar_solicitud(){
    $respuesta = array( FALSE );
    // <input type="hidden" name="value_pago" value="2">
    if($this->input->post("value_pago")){
      $validate = $this->input->post("value_pago");
  
      switch($validate){
          case 1:
            $prueba= $this->input->post("estatus");
            echo $prueba;
            return;
            $respuesta = array($this->Seguros_comision_model->update_estatus_pausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus") ));
          break;    
          case 2:
            $respuesta = array($this->Seguros_comision_model->update_estatus_despausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus")));
          break;
          case 3:
            $validate =  $this->Seguros_comision_model->registroComisionAsimilados();
          // echo $validate->row()->registro_comision.' *COMISION'.$validate->row()->registro_comision;
          if($validate->row()->registro_comision == 7){
            $respuesta = FALSE;
              // echo 'no entra';
          }else{
            // echo 'si entra';
          $respuesta = array($this->Seguros_comision_model->update_estatus_edit($this->input->post("id_pago_i"), $this->input->post("observaciones")));
          }
          break;
      }  
    }
    echo json_encode( $respuesta );
  }




}