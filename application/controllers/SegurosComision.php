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




}