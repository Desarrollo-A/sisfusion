<?php class Errors extends CI_Controller {

	public function __construct(){
		parent::__construct();


        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    }

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('errors/404not-found');
	}

}
