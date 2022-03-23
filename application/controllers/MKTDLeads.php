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
		$input =$_POST;
        print_r($input);
		$this->db->insert('prospectos',$input);
		$this->response(['Lead Insertado correctamente.'], REST_Controller::HTTP_OK);
	}

}


