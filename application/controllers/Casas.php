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

    public function documentacion($proceso){
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/documentacion", $data);
    }

    public function proyecto_ejecutivo(){
        $this->load->view('template/header');
        $this->load->view("casas/proyecto_ejecutivo");
    }

    public function documentos_proyecto_ejecutivo($proceso){
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/documentos_proyecto_ejecutivo", $data);
    }

    public function valida_comite(){
        $this->load->view('template/header');
        $this->load->view("casas/valida_comite");
    }

    public function comite_documentos($proceso){
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/comite_documentos", $data);
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

        $documento = $this->CasasModel->getDocumentosCartaAuth();

        if($documento){
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if(!$is_ok){
                http_response_code(500);
            }
        }

        $is_ok = $this->CasasModel->setProcesoToValidaComite($id);

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

    public function generateFileName($documento, $lote, $proceso, $archivo){
        $file_ext = pathinfo($archivo, PATHINFO_EXTENSION);

        $documento = strtoupper($documento);
        $documento = str_replace(" ", "_", $documento);

        $lote = str_replace("-", "_", $lote);

        $filename = $documento . "_" . $lote . "_" . $proceso . ".pdf";

        return $filename;
    }

    public function upload_documento(){
        $form = $this->form();

        $id_proceso = $this->form('id_proceso');
        $id_documento = $this->form('id_documento');
        $name_documento = $this->form('name_documento');

        if(!isset($id_proceso)){
            http_response_code(400);
        }

        $proceso = $this->CasasModel->getProceso($id_proceso);

        $file = $this->file('file_uploaded');

        if(!$file){
            http_response_code(400);
        }

        if($file){
            $filename = $this->generateFileName($name_documento, $proceso->nombreLote, $id_proceso, $file->name);

            $uploaded = $this->upload($file->tmp_name, $filename);

            if($uploaded){
                $updated = $this->CasasModel->updateDocumentRow($id_documento, $filename);

                if($updated){
                    $this->json([]);
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

        $documentos = $this->CasasModel->getDocumentosCliente();

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if(!$is_ok){
                break;
            }
        }

        if(!$is_ok){
            http_response_code(500);
        }

        $is_ok = $this->CasasModel->setProcesoToDocumentacionCliente($id);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_proceso_documentos(){
        $lotes = $this->CasasModel->getListaProcesoDocumentos();

        $this->json($lotes);
    }

    public function back_to_adeudos(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $is_ok = $this->CasasModel->backToAdeudos($id);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_documentos_cliente($proceso){
        $lotes = $this->CasasModel->getListaDocumentosCliente($proceso);

        $this->json($lotes);
    }

    public function lista_proyecto_ejecutivo_documentos(){
        $lotes = $this->CasasModel->getListaProyectoEjecutivo();

        $this->json($lotes);
    }

    public function lista_documentos_proyecto_ejecutivo($proceso){
        $lotes = $this->CasasModel->getListaDocumentosProyectoEjecutivo($proceso);

        $this->json($lotes);
    }

    public function to_valida_comite(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $documento = $this->CasasModel->getDocumentoAnexosTecnicos();

        if($documento){
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if(!$is_ok){
                http_response_code(500);
            }
        }

        $is_ok = $this->CasasModel->setProcesoToValidaComite($id);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_valida_comite(){
        $lotes = $this->CasasModel->getListaValidaComite();

        $this->json($lotes);
    }

    public function back_to_documentos(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $is_ok = $this->CasasModel->backToDocumentos($id);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_documentos_comite($proceso){
        $lotes = $this->CasasModel->getListaDocumentosComiteEjecutivo($proceso);

        $this->json($lotes);
    }

    public function to_titulacion(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $documento = $this->CasasModel->getDocumentoTitulacion();

        if($documento){
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if(!$is_ok){
                http_response_code(500);
            }
        }

        $is_ok = $this->CasasModel->setProcesoToTitulacion($id);

        if($is_ok){
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }
}