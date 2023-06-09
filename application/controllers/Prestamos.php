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

    $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
  }
   public function index(){
    redirect(base_url());
  }

  public function validateSession() {
    if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
      redirect(base_url() . "index.php/login");
  }

  public function prestamos() {
    if ($this->session->userdata('id_rol') == FALSE) {
        redirect(base_url());
    }
    $this->load->view('template/header');
    $this->load->view("prestamos/prestamos-view");
  }

  public function historial() {
    if ($this->session->userdata('id_rol') == FALSE) {
        redirect(base_url());
    }
    $this->load->view('template/header');
    $this->load->view("prestamos/historial-view");
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
}