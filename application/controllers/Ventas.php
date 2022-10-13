<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ventas extends CI_Controller {
	public function __construct() {
        
		parent::__construct();
        $this->load->model(array('Ventas_modelo', 'Statistics_model', 'asesor/Asesor_model'));
        $this->load->library(array('get_menu', 'Jwt_actions'));
		$this->load->helper(array('url','form'));
        $this->jwt_actions->authorize('3515', $_SERVER['HTTP_HOST']);
		$this->load->database('default');
        $this->validateSession();
	}

    public function validateSession() {
        if($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
            redirect(base_url() . "index.php/login");
    }

	public function index() {
        $id_rol = $this->session->userdata('id_rol');
		if($id_rol == FALSE || ($id_rol != '1' && $id_rol != '2' && $id_rol != '3' && $id_rol != '4' && $id_rol != '5'
                && $id_rol != '7' && $id_rol != '9' && $id_rol != '6' && $id_rol != '18' && $id_rol != '63')) {
			redirect(base_url().'login');
		}
        $datos = $this->get_menu->get_menu_data($id_rol);
        $datos['sub_menu'] = $this->get_menu->get_submenu_data($id_rol, $this->session->userdata('id_usuario'));
        switch ($id_rol) {
            case '1': // DIRECTOR
            case '2': // SUBDIRECTOR
            case '3': // GERENTE
            case '4': // ASISTENTE DIRECCIÓN
            case '5': // ASISTENTE SUBDIRECCIÓN
            case '6': // ASISTENTE GERENCIA
            case '7': // ASESOR
            case '9': // COORDINADOR
            case '18': // DIRECTOR TI
            case '63': // CONTROL INTERNO
            default: // POR DEFECTO
                $this->load->view('template/header');
                $this->load->view("template/home", $datos);
                $this->load->view('template/footer');
            break;
        }
	}

    public function repoVtasAsesor(){
        $this->validateSession();
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("ventas/vtas_periodo_asesor",$datos);
    }

    public function getInfRepoVta(){
        
        $data = $this->Ventas_modelo->getGralInfRepoVta()->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

}
