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
    
    public function updateLote(){
        $datos = $_POST;
        $data = $this->Restore_model->updateLote($datos);
        $data_back = array(
            'data' =>$data
        );


        if($data_back != null) {
            echo json_encode($data_back);
        } else {
            echo json_encode(array());
        }
    }
    
    public function return_status_uno()
    {
        $datos = $_POST;// $this->input->post('idCliente');
		$data= $this->Restore_model->return_status_uno($datos);
        $data_back = array(
            'data' =>$data
        );


        if($data_back != null) {
            echo json_encode($data_back);
        } else {
            echo json_encode(array());
        }

    }
}