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
}
 
