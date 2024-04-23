<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . "/controllers/BaseController.php");

class PagosCasas extends BaseController {
    public function __construct() {
        parent::__construct();

        $this->load->model(array('PagosCasasModel'));
    }

    public function iniciar_proceso(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/iniciar_proceso");
    }

    public function documentos(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/documentos");
    }

    public function to_documentacion(){
        
    }

    public function lista_iniciar_proceso(){
        $lotes = $this->PagosCasasModel->getListaIniciarProceso();

        $this->json($lotes);
    }

}