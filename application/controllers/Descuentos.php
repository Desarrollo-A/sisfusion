<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Descuentos extends CI_Controller
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
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('0606', $_SERVER['HTTP_HOST']);
    $this->validateSession();
    $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
    $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function index(){
    redirect(base_url());
    }

    public function validateSession(){
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
        redirect(base_url() . "index.php/login");
    }
    public function historial_prestamos(){
    $this->load->view('template/header');
    $this->load->view("descuentos/historial_prestamo_view");
    }


}