<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Prestamos extends CI_Controller
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
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('8271', $_SERVER['HTTP_HOST']);
    $this->validateSession();
   }
   public function index(){
    redirect(base_url());
  }

  public function validateSession() {
    if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
      redirect(base_url() . "index.php/login");
  }

  public function panel_prestamos()
  {

    $datos = array();
    $datos["datos2"] = $this->Asesor_model->getMenu($this->session->userdata('id_rol'))->result();
    $datos["datos3"] = $this->Asesor_model->getMenuHijos($this->session->userdata('id_rol'))->result();
    $val = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $salida = str_replace('' . base_url() . '', '', $val);
    $datos["datos4"] = $this->Asesor_model->getActiveBtn($salida, $this->session->userdata('id_rol'))->result();
    $this->load->view('template/header');
    $this->load->view("ventas/panel_prestamos", $datos);
  }
  public function prestamos()
  {

    $datos = array();
    $datos["datos2"] = $this->Asesor_model->getMenu($this->session->userdata('id_rol'))->result();
    $datos["datos3"] = $this->Asesor_model->getMenuHijos($this->session->userdata('id_rol'))->result();
    $val = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $salida = str_replace('' . base_url() . '', '', $val);
    $datos["datos4"] = $this->Asesor_model->getActiveBtn($salida, $this->session->userdata('id_rol'))->result();
    $this->load->view('template/header');
    $this->load->view("ventas/prestamos", $datos);
  }
}