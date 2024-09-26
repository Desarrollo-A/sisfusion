<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . "/controllers/BaseController.php");

class Pagoscasas extends BaseController {
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

    public function confirmar_pago(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/confirmar_pago");
    }

    public function confirmar_pago_dos(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/confirmar_pago_dos");
    }

    public function carga_complemento(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/carga_complemento");
    }

    public function carga_complemento_dos(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/carga_complemento_dos");
    }

    public function validar_pago(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/validar_pago");
    }

    public function validar_pago_dos(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/validar_pago_dos");
    }

    public function solicitar_avance(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/solicitar_avance");
    }

    public function validar_avance(){
        $this->load->view('template/header');
        $this->load->view("pagos_casas/validar_avance");
    }

    public function avances($proceso){
        $lote = $this->PagosCasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("pagos_casas/avances", $data);
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
        $id_proceso = $this->form('id_proceso');
        $id_documento = $this->form('id_documento');
        $name_documento = $this->form('name_documento');

        if(!isset($id_proceso) || !isset($id_documento) || !isset($name_documento)){
            http_response_code(400);
            $this->json([]);
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
                    $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 3, 3, 'Se subió archivo: '. $filename);
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
        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if(!isset($id)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);

        if($proceso){
            $documentos = $this->PagosCasasModel->getDocumentos([1,2,3,4,5,6]);

            foreach ($documentos as $key => $documento) {
                $is_ok = $this->PagosCasasModel->insertDocumentsToProceso($proceso->idProcesoPagos, $documento->tipo, $documento->nombre);

                if(!$is_ok){
                    break;
                }
            }

            if($is_ok){
                $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 3, $comentario);
                $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 2, 3, 'Se avanzó al proceso 3 | Comentario: '. $comentario);

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

        if(!isset($form->idProcesoPagos) || !isset($form->costoConstruccion)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($form->idProcesoPagos);

        if($proceso){
            $is_ok = $this->PagosCasasModel->editMontos($proceso->idProcesoPagos, $form->costoConstruccion);

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

    public function to_validacion_contraloria(){
        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if(!isset($id)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);

        $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 4, $comentario);

        if($is_ok){
            $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 3, 4, 'Se avanzó el proceso al paso 4 | Comentario: '. $comentario);
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
        $id_proceso = $this->form('id_proceso');
        $comentario = $this->form('comentario');

        if(!isset($id_proceso)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($id_proceso);

        $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 2, $comentario);

        if($is_ok){
             $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 1, 2, 'Se inició proceso | Comentario: '. $comentario);
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function lista_validar_deposito(){
        $lotes = $this->PagosCasasModel->getListaValidarDeposito();

        $this->json($lotes);
    }

    public function back_to_documentacion(){
        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if(!isset($id)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);

        $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 3, $comentario);

        if($is_ok){
            // $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 'NULL', 0, 'Se inicio proceso');
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function to_confirmar_pago(){
        $id = $this->form('id');
        $comentario = $this->form('comentario');
        $monto = $this->form('monto');

        if(!isset($id)){
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);

        $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 5, $comentario);

        if($is_ok){
            $this->PagosCasasModel->insertarAvance($proceso->idProcesoPagos, 0, 0);
            $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 4, 5, 'Se avanzó el proceso al paso 5 | Comentario: '. $comentario);
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function lista_confirmar_pago(){
        $lotes = $this->PagosCasasModel->getListaConfirmarPago($idProceso = 5);

        $this->json($lotes);
    }

    public function lista_confirmar_pago_dos(){
        $lotes = $this->PagosCasasModel->getListaConfirmarPago($idProceso = 9);

        $this->json($lotes);
    }

    public function to_carga_complemento(){
        $id = $this->form('id');
        $comentario = $this->form('comentario');
        $paso = $this->form('paso');
        $id_avance = $this->form('id_avance');
        $avanceObra = $this->form('avanceObra');

        if(!isset($id)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);
        
        if($paso == 5) {
            $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 6, $comentario);
            $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 5, 6, 'Se avanzó el proceso al paso 6 | Comentario: '. $comentario);
        }
        if($paso == 9) {
            $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 10, $comentario);
            $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 2, 1, 'Se avanzó el proceso al paso 10 | Comentario: '. $comentario);
            $is_ok = $this->PagosCasasModel->setPagadoAvance($id_avance);
            
            if($avanceObra < 100) {
                $this->PagosCasasModel->insertarAvance($proceso->idProcesoPagos, 0, 0);
            }
            
            
        }

        if($is_ok){
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }
    
    public function lista_carga_complemento(){
        $lotes = $this->PagosCasasModel->getListaCargaComplemento($paso = 6);

        $this->json($lotes);
    }

    public function lista_carga_complemento_dos(){
        $lotes = $this->PagosCasasModel->getListaCargaComplemento($paso = 10);

        $this->json($lotes);
    }

    public function upload_complemento(){
        $id_proceso = $this->form('id_proceso');
        $id_avance = $this->form('id_avance');
        $paso = $this->form('paso');

        $file_pdf = $this->file('file_pdf');
        $file_xml = $this->file('file_xml');

        if(!isset($id_proceso) || !isset($id_avance) || !isset($file_pdf) || !isset($file_xml)){
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->PagosCasasModel->getProceso($id_proceso);

        $name_pdf = "complemento de pago pdf $id_avance";
        $filename_pdf = $this->generateFileName($name_pdf, $proceso->nombreLote, $id_proceso, $file_pdf->name);

        $uploaded_pdf = $this->upload($file_pdf->tmp_name, $filename_pdf);

        $name_xml = "complemento de pago xml $id_avance";
        $filename_xml = $this->generateFileName($name_xml, $proceso->nombreLote, $id_proceso, $file_xml->name);

        $uploaded_xml = $this->upload($file_xml->tmp_name, $filename_xml);

        if($uploaded_pdf && $uploaded_xml){
            $is_ok = $this->PagosCasasModel->setComplementosAvance($id_avance, $filename_pdf, $filename_xml);

            if($is_ok){
                $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, $paso, $paso, 'Se subió archivo: '. $filename_pdf);
                $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, $paso, $paso, 'Se subió archivo: '. $filename_xml);
            }else{
                http_response_code(404);
            }
        }else{
            http_response_code(500);
        }

        $this->json([]);
    }

    public function to_validar_pago(){
        $id = $this->form('id');
        $comentario = $this->form('comentario');
        $paso = $this->form('paso');

        if(!isset($id)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);

        if($paso == 6) {
            $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 7, $comentario);
            $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 6, 7, 'Se avanzó el proceso al paso 7 | Comentario: '. $comentario);
        }
        if($paso == 10) {
            $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 11, $comentario);
            $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 10, 11, 'Se avanzó el proceso al paso 11  | Comentario: '. $comentario);
        }
        

        if($is_ok){
            // $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 'NULL', 0, 'Se inicio proceso');
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function lista_validar_pago(){
        $lotes = $this->PagosCasasModel->getListaValidarPago($paso = 7);

        $this->json($lotes);
    }

    public function lista_validar_pago_dos(){
        $lotes = $this->PagosCasasModel->getListaValidarPago($paso = 11);

        $this->json($lotes);
    }

    public function back_to_carga_complementos(){
        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if(!isset($id)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);

        $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 6, $comentario);

        if($is_ok){
            // $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 'NULL', 0, 'Se inicio proceso');
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function to_solicitar_avance(){
        $id = $this->form('id');
        $id_avance = $this->form('id_avance');
        $comentario = $this->form('comentario');
        $paso = $this->form('paso');

        if(!isset($id)){
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);
        if($paso == 7) {
            $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 8, $comentario);
            $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 7, 8, 'Se avanzó el proceso al paso 8 | Comentario: '. $comentario);
        }
        if($paso == 11) {
            $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 7, $comentario);
            $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 11, 7, 'Se repite el proceso al paso 7 | Comentario: '. $comentario);
        }
        

        if($is_ok){
            //$is_ok = $this->PagosCasasModel->setPagadoAvance($id_avance);
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function lista_solicitar_avance(){
        $lotes = $this->PagosCasasModel->getListaSolicitarAvance();

        $this->json($lotes);
    }

    public function add_avance(){
        $id_proceso = $this->form('id_proceso');
        $id_avance = $this->form('id_avance');
        $avance = $this->form('nuevo_avance');
        $monto = $this->form('monto');

        if(!isset($id) && !isset($avance) && !isset($monto)){
            http_response_code(400);
            $this->json([]);
        }

        if(isset($id_avance)){
            $is_ok = $this->PagosCasasModel->updateAvance($id_avance, $avance, $monto);
            $this->PagosCasasModel->addHistorial($id_proceso, 8, 8, 'Se actualizó el avance');
            
        }else{
            $is_ok = $this->PagosCasasModel->insertarAvance($id_proceso, $avance, $monto);
            $this->PagosCasasModel->addHistorial($id_proceso, 8, 8, 'Se insertó el avance de '.$avance.'% con el monto de $'.$monto);
        }

        if($is_ok){
            // $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 'NULL', 0, 'Se inicio proceso');
        }else{
            http_response_code(500);
        }

        $this->json([]);
    }

    public function to_validar_avance(){
        $id = $this->form('id');
        $avance = $this->form('avance');
        $comentario = $this->form('comentario');
        $paso = $this->form('paso');

        if(!isset($id)){
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);

        $nuevo_avance = $proceso->avanceObra + $avance;

        if($paso == 8) {
            $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 9, $comentario);
            $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 8, 9, 'Se avanzó el proceso al paso 9 | Comentario: '. $comentario);
            $is_ok = $this->PagosCasasModel->setAvanceToProceso($id, $nuevo_avance);
        }
        
        

        if($is_ok){
            
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function lista_validar_avance(){
        $lotes = $this->PagosCasasModel->getListaValidarAvance();

        $this->json($lotes);
    }

    public function to_confirmar_pago_avance(){
        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if(!isset($id)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);

        $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 4, $comentario);

        if($is_ok){
            // $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 'NULL', 0, 'Se inicio proceso');
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function lista_reporte_pagos($tableValue){
        $opcion = $this->input->get('opcion');
        $proceso = "0, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12, 13, 14, 15, 16";
        $finalizado = "0, 1";
        
        if ($opcion != -1 && $opcion != -2 && isset($opcion)) {
            $proceso = $opcion;
            $finalizado = "0";
        }
        if ($opcion == -2) {
            $finalizado = "1";
        }
        if($opcion == -3) {
            $finalizado = "0";
        }

        $lotes = $this->PagosCasasModel->getListaReportePagos($proceso, $finalizado);
        $this->json($lotes);
    }

    public function lista_avances($proceso){
        $lotes = $this->PagosCasasModel->getListaAvances($proceso);

        $this->json($lotes);
    }

    public function to_finalizar_proceso(){
        $id = $this->form('id');
        $id_avance = $this->form('id_avance');
        $comentario = $this->form('comentario');

        if(!isset($id)){
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);

        $is_ok = $this->PagosCasasModel->setProcesoFinalizado($proceso->idProcesoPagos, $comentario);

        if($is_ok){
            $is_ok = $this->PagosCasasModel->setPagadoAvance($id_avance);

            // $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 'NULL', 0, 'Se inicio proceso');
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function add_monto_depositado(){
        $id_proceso = $this->form('id_proceso');
        $id_casas = $this->form('id_casas');
        $monto = $this->form('monto');

        if(!isset($monto) || ( !isset($id_proceso) && !isset($id_casas) )){
            http_response_code(400);
            $this->json([]);
        }

        if(!isset($id_proceso)){
            $proceso = $this->CasasModel->getProceso($id_casas);

            $result = $this->PagosCasasModel->addLoteToProcesoPagos($proceso->idLote, $id_casas);

            $id_proceso = $result->idProcesoPagos;
        }

        $is_ok = $this->PagosCasasModel->setMontoDepositado($id_proceso, $monto);

        if($is_ok){
            $this->json([]);
        }
    }

    public function upload_comprobante(){
        $id_proceso = $this->form('id_proceso');
        $id_casas = $this->form('id_casas');

        $archivo = $this->file('archivo');

        if(!isset($archivo) || ( !isset($id_proceso) && !isset($id_casas) )){
            http_response_code(400);
            $this->json([]);
        }

        if(!isset($id_proceso)){
            $proceso = $this->CasasModel->getProceso($id_casas);

            $result = $this->PagosCasasModel->addLoteToProcesoPagos($proceso->idLote, $id_casas);

            $id_proceso = $result->idProcesoPagos;
        }

        $proceso = $this->PagosCasasModel->getProceso($id_proceso);

        $nombre_documento = 'COMPROBANTE DE PAGO';

        $filename = $this->generateFileName($nombre_documento, $proceso->nombreLote, $id_proceso, $archivo->name);

        $uploaded = $this->upload($archivo->tmp_name, $filename);

        if($uploaded){
            $is_ok = $this->PagosCasasModel->insertDocumentsToProceso($proceso->idProcesoPagos, 7, $nombre_documento);

            if($is_ok){
                $documento = $this->PagosCasasModel->getDocumento($proceso->idProcesoPagos, 7);

                $this->PagosCasasModel->updateDocumentRow($documento->idDocumento, $filename);

                $this->json([]);
            }
        }else{
            http_response_code(500);
        }

        $this->json([]);
    }

    public function back_to_carga_comprobante(){
        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if(!isset($id)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);

        $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 1, $comentario);

        if($is_ok){
            $this->PagosCasasModel->addHistorial($proceso->idProcesoPagos, 2, 1, 'Se regresó el proceso al paso 1 | Comentario: '. $comentario);
        }else{
            http_response_code(404);
        }

        $this->json([]);
    }

    public function back_to_step_7 (){
        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if(!isset($id)){
            http_response_code(400);
        }

        $proceso = $this->PagosCasasModel->getProceso($id);

        $is_ok = $this->PagosCasasModel->setProcesoTo($proceso->idProcesoPagos, 7, $comentario);

        if($is_ok) {

        }else {
            http_response_code(404);
        }
    }

    public function getHistorial($idProceso) {
        echo json_encode($this->PagosCasasModel->getHistorialPagosCasas($idProceso));
    }
}
