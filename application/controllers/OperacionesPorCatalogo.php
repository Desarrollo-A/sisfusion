<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class OperacionesPorCatalogo extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('OperacionesPorCatalogo_model');
        $this->load->library(array('session','form_validation', 'get_menu', 'Jwt_actions','Formatter','permisos_sidebar'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
		$this->validateSession();
		$this->jwt_actions->authorize('2565', $_SERVER['HTTP_HOST']);
		date_default_timezone_set('America/Mexico_City');
		$val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
		$rutaUrl = substr($_SERVER["REQUEST_URI"],1); //explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl,$this->session->userdata('opcionesMenu'));
        
    }

    public function index(){
        if($this->session->userdata('perfil') == FALSE || ($this->session->userdata('perfil') != 'contraloria' && $this->session->userdata('perfil') != 'contraloriaCorporativa' && $this->session->userdata('perfil') != 'subdirectorContraloria' && $this->session->userdata('perfil') != 'direccionFinanzas' && $this->session->userdata('perfil') != 'direccionFinanzas' && $this->session->userdata('perfil') != 'ejecutivoContraloriaJR'))
		{
			redirect(base_url().'login');
		}
        $this->load->view('template/header');
		$this->load->view('template/home');
		$this->load->view('template/footer');
           
    }
    public function listacatalogo() {
        echo json_encode($this->OperacionesPorCatalogo_model->get_lista_opcs_x_cats_by_77()->result_array());
      }
}