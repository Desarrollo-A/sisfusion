<?php class Errors extends CI_Controller {

	public function __construct(){
		parent::__construct();


	}

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('errors/404not-found');
	}

}
