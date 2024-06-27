<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . "/controllers/BaseController.php");

class Credito extends BaseController {
    public function __construct() {
        parent::__construct();

        $this->load->model(array('Credito_model'));

        $this->load->library(['session']);

        $this->idRol = $this->session->userdata('id_rol');
        $this->idUsuario = $this->session->userdata('id_usuario');
    }

    public function index(){
		$this->load->view('template/header');
		$this->load->view("template/home");
		$this->load->view('template/footer');
	}

    public function ordenCompra(){
        $this->load->view('template/header');
        $this->load->view("casas/creditoDirecto/ordenCompra_view");
    }

    public function getOrdenCompra(){
        $lotes = $this->Credito_model->getOrdenCompra();

        $this->json($lotes);
    }

    
}