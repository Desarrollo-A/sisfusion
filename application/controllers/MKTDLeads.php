<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MKTDLeads extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Postventa_model', 'Documentacion_model', 'General_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        date_default_timezone_set('America/Mexico_City');
    }

    public function index_post()
	{
        $json = file_get_contents('php://input');
        print_r($json);
		$this->db->insert('prospectos',$json);
		$this->response(['Lead Insertado correctamente.'], REST_Controller::HTTP_OK);
	}

}


