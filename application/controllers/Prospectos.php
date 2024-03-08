<?php  

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Prospectos extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Prospectos_model', 'General_model'));
        $this->load->library(array('session','form_validation'));
        $this->load->library(array('session','form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        $this->jwt_actions->authorize('137', $_SERVER['HTTP_HOST']);
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();
        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = substr($_SERVER["REQUEST_URI"],1); //explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl,$this->session->userdata('opcionesMenu'));
	}

	public function index() {
		if($this->session->userdata('id_rol') == FALSE)
			redirect(base_url().'login');
		$this->load->view('template/header');
		$this->load->view('asesor/inicio_asesor_view2');
		$this->load->view('template/footer');
	}

    public function validateSession() {
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
            redirect(base_url() . "index.php/login");
    }

    public function reasignacion() {
        $this->load->view('template/header');
        $this->load->view("prospectos/reasignacion");
    }

    public function getListaProspectos() {
        $fechaInicio = explode('/', $this->input->post("beginDate"));
        $fechaFin = explode('/', $this->input->post("endDate"));
        $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
        $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
        $result['data'] = $this->Prospectos_model->getListaProspectos($beginDate, $endDate, $this->input->post("tipoUsuario"));
        echo json_encode($result, JSON_NUMERIC_CHECK);    
    }

    public function getRoles() {
        echo json_encode($this->Prospectos_model->getRoles());
    }

    public function getListaUsuarios() {
        echo json_encode($this->Prospectos_model->getListaUsuarios());
    }

    public function aplicarReAsignacion() {
        $idProspecto = $this->input->post("tipoTransaccion") == 2 ? implode(', ', $this->input->post("idProspecto")) : $this->input->post("idProspecto"); 
        $datosParaActualizar = array(
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "id_asesor" => $this->input->post("idAsesor"),
            "id_coordinador" => $this->input->post("idCoordinador"),
            "id_gerente" => $this->input->post("idGerente"),
            "id_subdirector" => $this->input->post("idSubdorector"),
            "id_regional" => $this->input->post("idRegional"),
            "id_regional_2" => $this->input->post("idRegional2")
        );
        $dbTransaction = $this->Prospectos_model->aplicarReAsignacion($datosParaActualizar, $idProspecto);
        if ($dbTransaction) // SUCCESS TRANSACTION
            echo json_encode(array("status" => 1, "message" => 'La re asignación se ha ejecutado con éxito.'), JSON_UNESCAPED_UNICODE);
        else // ERROR TRANSACTION
            echo json_encode(array("status" => -1, "message" => "Servicio no disponible. Por favor, inténtelo de nuevo más tarde."), JSON_UNESCAPED_UNICODE);
    }
    
}