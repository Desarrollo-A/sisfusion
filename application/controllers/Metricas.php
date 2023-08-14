<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Metricas extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Metricas_model', 'General_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'Email'));
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

    public function metricas(){
        $this->load->view("dashboard/metricas/metricas");
    }

    public function getSuperficieVendida(){
        $data = $this->Metricas_model->getSuperficieVendida();
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function getDisponibilidadProyecto(){
        $data = $this->Metricas_model->getDisponibilidadProyecto();
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function getVentasM2(){
        $data = $this->Metricas_model->getVentasM2($_POST['condominio']);
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function getLugarProspeccion(){
        $data = $this->Metricas_model->getLugarProspeccion();
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function getMedioProspeccion(){
        $data = $this->Metricas_model->getMedioProspeccion();
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function getProyectos(){
        $sede = $_POST['idSede'];
        $data = $this->Metricas_model->getProyectos($sede);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getCondominios(){
        $data = $this->Metricas_model->getCondominios($_POST['proyecto']);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getPromedio(){
        $data = $this->Metricas_model->getPromedio($_POST['sede'], $_POST['proyecto'], $_POST['beginDate'], $_POST['endDate']);
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function getSedes(){
        $data = $this->Metricas_model->getSedes();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getLotesInformation(){
        $data = $this->Metricas_model->getLotesInformation($_POST['sede_residencial'], $_POST['idResidencial'], $_POST['beginDate'], $_POST['endDate']);
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }



}
 
