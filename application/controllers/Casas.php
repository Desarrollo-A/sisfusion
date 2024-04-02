<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . "/controllers/BaseController.php");

class Casas extends BaseController {
    public function __construct() {
        parent::__construct();

        $this->load->model(array('CasasModel'));
    }

    public function cartera(){
        $this->load->view('template/header');
        $this->load->view("casas/cartera");
    }

    public function asignacion(){
        $this->load->view('template/header');
        $this->load->view("casas/asignacion");
    }

    public function residenciales(){
        $residenciales = $this->CasasModel->getResidencialesOptions();

        $this->json($residenciales);
    }

    public function condominios(){
        $idResidencial = $this->input->get('proyecto');

        $condominios = $this->CasasModel->getCondominiosOptions($idResidencial);

        $this->json($condominios);
    }

    public function options_asesores(){
        $asesores = $this->CasasModel->getAsesoresOptions();

        $this->json($asesores);
    }

    public function lotes(){
        $idCondominio = $this->input->get('condominio');

        if(!isset($idCondominio)){
            $this->json([]);
        }
        
        $lotes = $this->CasasModel->getCarteraLotes($idCondominio);

        $this->json($lotes);
    }

    public function lista_asignacion(){
        $lotes = $this->CasasModel->getListaAsignacion();

        $this->json($lotes);
    }

    public function to_asignacion(){
        $idLote = $this->input->get('lote');

        if(!isset($idLote)){
            http_response_code(400);
        }

        $is_ok = $this->CasasModel->addLoteToAsignacion($idLote);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function asignar(){
        $form = $this->form();

        if(!isset($form->id) || !isset($form->asesor)){
            http_response_code(400);
        }

        $is_ok = $this->CasasModel->asignarAsesor($form->id, $form->asesor);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }
}