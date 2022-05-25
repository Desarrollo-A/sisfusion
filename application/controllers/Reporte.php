<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reporte extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Reporte_model', 'General_model'));
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

    public function reporte(){
        $this->load->view("dashboard/reporte/reporte");
    }

    public function getInformation()
    {
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $type = $this->input->post("type");
            $saleType = $this->input->post("saleType");
            $currentYear = date("Y");
            if ($type == 1) { // GENERAL TABLE
                $data['data'] = $this->Reporte_model->getGeneralInformation($typeTransaction, $beginDate, $endDate, $currentYear, $saleType)->result_array();
            } else if ($type == 2) { // MANAGER TABLE
                $data['data'] = $this->Reporte_model->getInformationByManager($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            } else if ($type == 3) { // COORDINATOR TABLE
                $data['data'] = $this->Reporte_model->getInformationByCoordinator($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            } else if ($type == 4) { // ADVISER TABLE
                $data['data'] = $this->Reporte_model->getInformationByAdviser($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            }
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }
}
 
