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
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getDisponibilidadProyecto(){
        $data = $this->Metricas_model->getDisponibilidadProyecto();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getVentasM2(){
        $data = $this->Metricas_model->getVentasM2($_POST['condominio']);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getLugarProspeccion(){
        $data = $this->Metricas_model->getLugarProspeccion();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getMedioProspeccion(){
        $data = $this->Metricas_model->getMedioProspeccion();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getProyectos(){
        $data = $this->Metricas_model->getProyectos();
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


}
 
