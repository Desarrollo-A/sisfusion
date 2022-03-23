<?php

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class MKTDLeads extends REST_Controller {

	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

    public function index_post()
	{
		$input = $this->input->post();
        print_r($input);
		$this->db->insert('prospectos',$input);
		$this->response(['Lead Insertado correctamente.'], REST_Controller::HTTP_OK);
	}
}