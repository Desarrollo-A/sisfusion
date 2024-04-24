<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . "/controllers/BaseController.php");

class PagosCasas extends BaseController {
    public function __construct() {
        parent::__construct();

        $this->load->model(['PagosCasasModel', 'CasasModel']);
    }

    public function iniciar_proceso(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/iniciar_proceso");
    }

    public function documentacion(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/documentacion");
    }

    public function subir_documentacion($proceso){
        $lote = $this->PagosCasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("pagos_casas/subir_documentacion", $data);
    }

    public function valida_documentos(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/valida_documentos");
    }

    public function lista_valida_documentos($proceso){
        $lote = $this->PagosCasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("pagos_casas/lista_valida_documentos", $data);
    }

    public function validar_deposito(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/validar_deposito");
    }

    public function generateFileName($documento, $lote, $proceso, $archivo){
        $file_ext = pathinfo($archivo, PATHINFO_EXTENSION);

        $documento = strtoupper($documento);
        $documento = str_replace(" ", "_", $documento);

        $lote = str_replace("-", "_", $lote);

        $filename = $documento . "_" . $lote . "_" . $proceso . '.' . $file_ext;

        return $filename;
    }

    public function upload_documento(){
        $form = $this->form();

        $id_proceso = $this->form('id_proceso');
        $id_documento = $this->form('id_documento');
        $name_documento = $this->form('name_documento');

        if(!isset($id_proceso) || !isset($id_documento) || !isset($name_documento)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($id_proceso);

        $file = $this->file('file_uploaded');

        if(!$file){
            http_response_code(400);
        }

        if($file){
            $filename = $this->generateFileName($name_documento, $proceso->nombreLote, $id_proceso, $file->name);

            $uploaded = $this->upload($file->tmp_name, $filename);

            if($uploaded){
                $updated = $this->PagosCasasModel->updateDocumentRow($id_documento, $filename);

                if($updated){
                    // $motivo = "Se subio archivo: $name_documento";
                    // $this->CasasModel->addHistorial($id_proceso, $proceso->proceso, $proceso->proceso, $motivo);
                }
            }
        }

        $this->json([]);
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

    public function lista_iniciar_proceso(){
        $lotes = $this->PagosCasasModel->getListaIniciarProceso();

        $this->json($lotes);
    }

    public function to_documentacion(){
        $idProcesoCasas = $this->input->get('id');

        if(!isset($idProcesoCasas)){
            http_response_code(400);
        }

        $proceso = $this->CasasModel->getProceso($idProcesoCasas);

        $result = $this->PagosCasasModel->addLoteToProcesoPagos($proceso->idLote, $idProcesoCasas);

        if($result){
            $documentos = $this->PagosCasasModel->getDocumentos([1,2,3,4,5,6]);

            foreach ($documentos as $key => $documento) {
                $is_ok = $this->PagosCasasModel->inserDocumentsToProceso($result->idProcesoPagos, $documento->tipo, $documento->nombre);

                if(!$is_ok){
                    break;
                }
            }

            if($is_ok){
                // $this->CasasModel->addHistorial($proceso->idProcesoCasas, 'NULL', 0, 'Se inicio proceso');

                $this->json([]);
            }
        }else{
            http_response_code(404);
        }
    }

    public function lista_documentacion(){
        $lotes = $this->PagosCasasModel->getListaDocumentacion();

        $this->json($lotes);
    }

    public function edit_montos(){
        $form = $this->form();

        if(!isset($form->idProcesoPagos) || !isset($form->costoConstruccion) || !isset($form->montoDepositado)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($form->idProcesoPagos);

        if($proceso){
            $is_ok = $this->PagosCasasModel->editMontos($proceso->idProcesoPagos, $form->costoConstruccion, $form->montoDepositado);

            if($is_ok){
                //$this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, "Se modifico adeudo: $column");
            }else{
                http_response_code(404);
            }
        }

        $this->json([]);
    }

    public function lista_subir_documentos($proceso){
        $lotes = $this->PagosCasasModel->getListaSubirDcoumentos($proceso);

        $this->json($lotes);
    }

    public function to_validacion(){
        $idProcesoPagos = $this->input->get('id');

        if(!isset($idProcesoPagos)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($idProcesoPagos);

        $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 2);

        if($is_ok){
            // $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 'NULL', 0, 'Se inicio proceso');
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function lista_valida_documentacion(){
        $lotes = $this->PagosCasasModel->getListaValidaDocumentacion();

        $this->json($lotes);
    }

    public function to_validar_deposito(){
        $idProcesoPagos = $this->input->get('id');

        if(!isset($idProcesoPagos)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($idProcesoPagos);

        $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 3);

        if($is_ok){
            // $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 'NULL', 0, 'Se inicio proceso');
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function lista_validar_deposito(){
        $lotes = $this->PagosCasasModel->getListaValidarDeposito();

        $this->json($lotes);
    }

}