<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ranking extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Ranking_model', 'General_model'));
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

    public function ranking(){
        $this->load->view("dashboard/ranking/ranking");
    }
}
 
