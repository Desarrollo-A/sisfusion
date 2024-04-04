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

    public function carta_auth(){
        $this->load->view('template/header');
        $this->load->view("casas/carta_auth");
    }

    public function adeudos(){
        $this->load->view('template/header');
        $this->load->view("casas/adeudos");
    }

    public function docu_cliente(){
        $this->load->view('template/header');
        $this->load->view("casas/docu_cliente");
    }

    public function archivo($name)
    {
        $object = $this->bucket->object(urldecode($name));

        if($object->exists()){
            $contentType = $object->info()['contentType'];

            $file = $object->downloadAsString();

            header("Content-type: $contentType");

            print($file);
        }else{
            header("HTTP/1.1 404 Not Found");

            http_response_code(404);
        }
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

    public function to_carta_auth(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $is_ok = $this->CasasModel->setProcesoToCartaAuth($id);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_carta_auth(){
        $lotes = $this->CasasModel->getListaCartaAuth();

        $this->json($lotes);
    }

    public function cancel_process(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $is_ok = $this->CasasModel->cancelProcess($id);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function back_to_asignacion(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $is_ok = $this->CasasModel->backToAsignacion($id);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function upload_carta_auth(){
        $id = $this->form('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $proceso = $this->CasasModel->getProceso($id);

        $file = $this->file('carta_auth');

        if(!isset($file)){
            http_response_code(400);
        }

        if($file){
            $date = date('Ymd');

            $filename = "CARTA_AUTH_" . $proceso->nombreLote . "_" . $proceso->idProcesoCasas . "_" . $date . ".pdf";

            $uploaded = $this->upload($file->tmp_name, $filename);

            if($uploaded){
                $inserted = $this->CasasModel->addDocumentRow($id, $filename, 'CARTA DE AUTORIZACION');

                if($inserted){
                    $updated = $this->CasasModel->setCartaAuth($id, $inserted);

                    if($updated){
                        $this->json([]);
                    }
                }
            }
        }

        http_response_code(404);
    }

    public function to_concentrar_adeudos(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $is_ok = $this->CasasModel->setProcesoToConcentrarAdeudos($id);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_adeudos(){
        $lotes = $this->CasasModel->getListaConcentradoAdeudos();

        $this->json($lotes);
    }

    public function back_to_carta_auth(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $is_ok = $this->CasasModel->backToCartaAutorizacion($id);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function to_documentacion_cliente(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $is_ok = $this->CasasModel->setProcesoToDocumentacionCliente($id);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_documentos_cliente(){
        $this->json([]);
    }
}