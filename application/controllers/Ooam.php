<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Ooam extends CI_Controller
{
  public function __construct() {
    parent::__construct();
    $this->load->model('Ooam_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('1998', $_SERVER['HTTP_HOST']);
    $this->validateSession();
    $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    $rutaUrl = substr($_SERVER["REQUEST_URI"],1);
    $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl,$this->session->userdata('opcionesMenu'));
    }
    public function index(){
        redirect(base_url());
    }
    public function prueba() {
        if ($this->session->userdata('id_rol') == FALSE)
            redirect(base_url());
                
            $datos["controversias"] = $this->Comisiones_model->getMotivosControversia();
            $this->load->view('template/header');
            $this->load->view("comisiones/dispersion-view", $datos);
      }

}



