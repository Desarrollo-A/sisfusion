<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Resguardos extends CI_Controller
{
  private $gph;
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Resguardos_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions', 'phpmailer_lib'));
    $this->load->database('default');
    $this->jwt_actions->authorize('6512', $_SERVER['HTTP_HOST']);
    $this->validateSession();
   }

  public function index(){
    redirect(base_url());
  }

  public function validateSession() {
    if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
      redirect(base_url() . "index.php/login");
  }

   // resguardos-view complete

  public function retiros() {
    if ($this->session->userdata('id_rol') == FALSE)
        redirect(base_url());
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("resguardos/retiros-view", $datos);
      }

  public function getRetiros($user,$opc)
  {
    $data["data"] = $this->Resguardos_model->getRetiros($user,$opc)->result_array();
    echo json_encode($data);
  }

  public function getListaRetiros($id)
  {
      echo json_encode($this->Resguardos_model->getListaRetiros($id)->result_array());
  }


 
  // public function getDataDispersionPago() {
  //   $data['data'] = $this->Resguardos_model->getDataDispersionPago()->result_array();
  //   echo json_encode($data);
  // }


  // public function getPlanesResguardos($val = ''){

  //     $data = array();
  //     if(empty($val)){
  //       $data = $this->Resguardos_model->getPlanesResguardos();
  //     }else{
  //       $data = $this->Resguardos_model->getPlanesResguardos($val);
  //     }
      
  //     if ($data != null) {
  //       echo json_encode($data);
  //     } else {
  //       echo json_encode(array());
  //     }
  //   }





    // public function resguardos()
    // {
    //   $datos = array();
    //   $datos["datos2"] = $this->Asesor_model->getMenu($this->session->userdata('id_rol'))->result();
    //   $datos["datos3"] = $this->Asesor_model->getMenuHijos($this->session->userdata('id_rol'))->result();
    //   $val = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    //   $salida = str_replace('' . base_url() . '', '', $val);
    //   $datos["datos4"] = $this->Asesor_model->getActiveBtn($salida, $this->session->userdata('id_rol'))->result();
    //   $this->load->view('template/header');
    //   $this->load->view("ventas/revision_resguardo", $datos);
    // }
 
    // public function getDatosResguardoContraloria($user,$condominio){
    //   $dat =  $this->Comisiones_model->getDatosResguardoContraloria($user,$condominio)->result_array();
    //  for( $i = 0; $i < count($dat); $i++ ){
    //      $dat[$i]['pa'] = 0;
    //  }
    //  echo json_encode( array( "data" => $dat));
    // }



    //  public function retiros()
    // {
    //   $datos = array();
    //   $datos["datos2"] = $this->Asesor_model->getMenu($this->session->userdata('id_rol'))->result();
    //   $datos["datos3"] = $this->Asesor_model->getMenuHijos($this->session->userdata('id_rol'))->result();
    //   $val = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    //   $salida = str_replace('' . base_url() . '', '', $val);
    //   $datos["datos4"] = $this->Asesor_model->getActiveBtn($salida, $this->session->userdata('id_rol'))->result();
    //   $this->load->view('template/header');
    //   $this->load->view("ventas/retiros", $datos);
    // }
 
    // public function getDatosRetirosContraloria($proyecto,$condominio){
    //   $dat =  $this->Comisiones_model->getDatosRetirosContraloria($proyecto,$condominio)->result_array();
    //  for( $i = 0; $i < count($dat); $i++ ){
    //      $dat[$i]['pa'] = 0;
    //  }
    //  echo json_encode( array( "data" => $dat));
    // }

    //  public function retiros_resguardo()
    // {
    //   $datos = array();
    //   $datos["datos2"] = $this->Asesor_model->getMenu($this->session->userdata('id_rol'))->result();
    //   $datos["datos3"] = $this->Asesor_model->getMenuHijos($this->session->userdata('id_rol'))->result();
    //   $val = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    //   $salida = str_replace('' . base_url() . '', '', $val);
    //   $datos["datos4"] = $this->Asesor_model->getActiveBtn($salida, $this->session->userdata('id_rol'))->result();
    //   $this->load->view('template/header');
    //   $this->load->view("ventas/retiros_dir", $datos);
    // }

    //  public function historial_retiros()
    // {
    //   $datos = array();
    //   $datos["datos2"] = $this->Asesor_model->getMenu($this->session->userdata('id_rol'))->result();
    //   $datos["datos3"] = $this->Asesor_model->getMenuHijos($this->session->userdata('id_rol'))->result();
    //   $val = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    //   $salida = str_replace('' . base_url() . '', '', $val);
    //   $datos["datos4"] = $this->Asesor_model->getActiveBtn($salida, $this->session->userdata('id_rol'))->result();
    //   $this->load->view('template/header');
    //   $this->load->view("ventas/retiros_historial", $datos);
    // }
 
    // public function getDatoshistorialResguardoContraloria($proyecto,$condominio){
    //   $dat =  $this->Comisiones_model->getDatoshistorialResguardoContraloria($proyecto,$condominio)->result_array();
    //  for( $i = 0; $i < count($dat); $i++ ){
    //      $dat[$i]['pa'] = 0;
    //  }
    //  echo json_encode( array( "data" => $dat));
    // }




  }

 
   // resguardos-view end
