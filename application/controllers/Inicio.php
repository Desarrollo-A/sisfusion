<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inicio extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Metricas_model', 'General_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'Email','permisos_sidebar'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function validateSession(){
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')==""){
            redirect(base_url() . "index.php/login");
        }
    }

    public function index(){
        $this->load->view("dashboard/inicio/inicio");
    }
}
 
