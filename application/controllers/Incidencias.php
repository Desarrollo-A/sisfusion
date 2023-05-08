<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Incidencias extends CI_Controller
{
  private $gph;
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Comisiones_model');
    $this->load->model('Incidencias_model');
    $this->load->model('asesor/Asesor_model');
    $this->load->model('Usuarios_modelo');
    $this->load->model('Incidencias_model');    
    $this->load->model('PagoInvoice_model');
    $this->load->model('General_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('566', $_SERVER['HTTP_HOST']);
    $this->validateSession(); 
   }
   public function validateSession() {
    if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
      redirect(base_url() . "index.php/login");
  }
// antes se llamada incidencias se encontraba en comisiones
   public function index()
  {
    $datos["datos2"] = $this->Asesor_model->getMenu($this->session->userdata('id_rol'))->result();
    $datos["datos3"] = $this->Asesor_model->getMenuHijos($this->session->userdata('id_rol'))->result();
    $datos = array();
    $datos["datos2"] = $this->Asesor_model->getMenu($this->session->userdata('id_rol'))->result();
    $datos["datos3"] = $this->Asesor_model->getMenuHijos($this->session->userdata('id_rol'))->result();
    $val = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $salida = str_replace('' . base_url() . '', '', $val);
    $datos["datos4"] = $this->Asesor_model->getActiveBtn($salida, $this->session->userdata('id_rol'))->result();
    $this->load->view('template/header');
    $this->load->view("incidencia/IncidenciasByLote", $datos);
  }

  // se encuentra en comisiones ! 
  
  public function getInCommissions($lote)
  {

      $datos = array();
      $datos = $this->Incidencias_model->getInCommissions($lote);
      if ($datos != null) {
          echo json_encode($datos);
      } else {
          echo json_encode(array());
      }
  }
  
  
  public function getUsuariosRol3($rol)
  {
    echo json_encode($this->Comisiones_model->getUsuariosRol3($rol)->result_array());
  }


 

}