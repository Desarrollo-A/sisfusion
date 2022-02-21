<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Restore extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model('Restore_model');
                //$this->load->model('asesor/Asesor_model');
        $this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
    }
    
    public function return_status_uno($idCliente){
        // for($x = 0;$x < count($idCliente);$x++){
            // $data= $this->Restore_model->return_status_uno($idCliente[$x]);

        // }
		$data= $this->Restore_model->return_status_uno($idCliente);

        echo json_encode( $data );
    }
}