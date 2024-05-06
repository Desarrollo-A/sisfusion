<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Anticipos extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Anticipos_model', 'General_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'Email', 'Jwt_actions', 'Formatter','permisos_sidebar'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->jwt_actions->authorize('9717','2807', $_SERVER['HTTP_HOST']);
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function index(){
        redirect(base_url());
    }
      
    public function validateSession(){
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')==""){
            redirect(base_url() . "index.php/login");
        }
    }

    public function historial_Anticipo(){
		$this->load->view('template/header');
		$this->load->view("anticipos/anticipos_view");
	}

    public function getAnticipos(){

        $data = $this->Anticipos_model->getAnticipos()->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function actualizarEstatus() {

        $comentario = $this->input->post('comentario');
        $id_usuario = $this->input->post('id_usuario');
        $id_anticipo = $this->input->post('id_anticipo');
        $procesoAnt = $this->input->post('procesoAnt');
        $monto = $this->input->post('monto');

        $result = $this->Anticipos_model->updateEstatus($procesoAnt, $id_usuario);
        $result_2 = $this->Anticipos_model->updateHistorial($id_anticipo, $id_usuario, $comentario, $procesoAnt);
        
        echo json_encode ($result,$result_2);
    }
}