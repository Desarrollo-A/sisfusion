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




}