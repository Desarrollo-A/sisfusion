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

    public function carga_titulos(){
        $this->load->view('template/header');
        $this->load->view("casas/carga_titulos");
    }

    public function eleccion_propuestas(){
        $this->load->view('template/header');
        $this->load->view("casas/eleccion_propuestas");
    }

    public function propuesta_firma(){
        $this->load->view('template/header');
        $this->load->view("casas/propuesta_firma");
    }

    public function validacion_contraloria(){
        $this->load->view('template/header');
        $this->load->view("casas/validacion_contraloria");
    }

    public function valida_documentacion($proceso){
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/valida_documentacion", $data);
    }

    public function solicitar_contratos(){
        $this->load->view('template/header');
        $this->load->view("casas/solicitar_contratos");
    }

    public function contratos($proceso){
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/contratos", $data);
    }

    public function recepcion_contratos(){
        $this->load->view('template/header');
        $this->load->view("casas/recepcion_contratos");
    }

    public function vobo_contratos($proceso){
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/vobo_contratos", $data);
    }

    public function cierre_cifras(){
        $this->load->view('template/header');
        $this->load->view("casas/cierre_cifras");
    }

    public function vobo_cifras(){
        $this->load->view('template/header');
        $this->load->view("casas/vobo_cifras");
    }

    public function expediente_cliente(){
        $this->load->view('template/header');
        $this->load->view("casas/expediente_cliente");
    }

    public function envio_a_firma(){
        $this->load->view('template/header');
        $this->load->view("casas/envio_a_firma");
    }

    public function firma_contrato(){
        $this->load->view('template/header');
        $this->load->view("casas/firma_contrato");
    }

    public function recepcion_contrato(){
        $this->load->view('template/header');
        $this->load->view("casas/recepcion_contrato");
    }

    public function finalizar(){
        $this->load->view('template/header');
        $this->load->view("casas/finalizar");
    }

    public function ingresar_adeudos(){
        $this->load->view('template/header');
        $this->load->view("casas/ingresar_adeudos");
    }

    public function propuestas($proceso){
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/propuestas", $data);
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

    public function options_notarias(){
        $notarias = $this->CasasModel->getNotariasOptions();

        $this->json($notarias);
    }

    public function options_propuestas(){
        $id = $this->input->get('id');

        $propuestas = $this->CasasModel->getPropuestasOptions($id);

        $this->json($propuestas);
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

        $proceso = $this->CasasModel->addLoteToAsignacion($idLote);

        if($proceso){
            $this->CasasModel->addHistorial($proceso->idProcesoCasas, 'NULL', 0, 'Se inicio proceso');

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

        $proceso = $this->CasasModel->getProceso($form->id);

        $asesor = $this->CasasModel->getAsesor($form->asesor);

        $is_ok = $this->CasasModel->asignarAsesor($proceso->idProcesoCasas, $asesor->idUsuario);

        if($is_ok){
            $motivo = "Se asigno asesor $asesor->idUsuario: $asesor->nombre";
            $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, $motivo);

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

        $proceso = $this->CasasModel->getProceso($id);

        $new_status = 1;

        $documentos = $this->CasasModel->getDocumentos([1]);

        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if(!$is_ok){
                break;
            }
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');

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

        $proceso = $this->CasasModel->getProceso($id);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, 'NULL', 'Se cancelo proceso');

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

        $new_status = 0;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso');

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
                    $motivo = "Se subio archivo: $name_documento";
                    $this->CasasModel->addHistorial($id_proceso, $proceso->proceso, $proceso->proceso, $motivo);

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

        $new_status = 2;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');

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

        $new_status = 1;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso');

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

        $documentos = $this->CasasModel->getDocumentos([2,3,4,5,6,7,8,9,10,11,12,13,14,15]);

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

        $new_status = 3;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');

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

        $new_status = 2;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso');

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

        $documentos = $this->CasasModel->getDocumentos([16]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if(!$is_ok){
                break;
            }
        }

        $new_status = 4;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
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

        $new_status = 3;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso');
            
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

        $documentos = $this->CasasModel->getDocumentos([17]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if(!$is_ok){
                break;
            }
        }

        $new_status = 5;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_carga_titulos(){
        $lotes = $this->CasasModel->getListaCargaTitulos();

        $this->json($lotes);
    }

    public function to_propuestas(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $documentos = $this->CasasModel->getDocumentos([18]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if(!$is_ok){
                break;
            }
        }

        $new_status = 6;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_eleccion_propuestas(){
        $lotes = $this->CasasModel->getListaEleccionPropuestas();

        $this->json($lotes);
    }

    public function back_to_carga_titulos(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 5;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function to_validacion_contraloria(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 7;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_propuesta_firma(){
        $lotes = $this->CasasModel->getListaPropuestaFirma();

        $this->json($lotes);
    }

    public function lista_validacion_contraloria(){
        $lotes = $this->CasasModel->getListaValidaContraloria();

        $this->json($lotes);
    }

    public function lista_valida_documentacion($proceso){
        $lotes = $this->CasasModel->getListaDocumentosValidaContraloria($proceso);

        $this->json($lotes);
    }

    public function to_solicitud_contratos(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $documentos = $this->CasasModel->getDocumentos([19,20,21,22,23,24]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if(!$is_ok){
                break;
            }
        }

        $new_status = 8;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_solicitar_contratos(){
        $lotes = $this->CasasModel->getListaSolicitarContratos();

        $this->json($lotes);
    }

    public function to_confirmar_contratos(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 9;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_contratos($proceso){
        $lotes = $this->CasasModel->getListaContratos($proceso);

        $this->json($lotes);
    }

    public function lista_recepcion_contratos(){
        $lotes = $this->CasasModel->getListaRecepcionContratos();

        $this->json($lotes);
    }

    public function back_to_solicitar_contratos(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 8;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function to_carga_cifras(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $documentos = $this->CasasModel->getDocumentos([25]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if(!$is_ok){
                break;
            }
        }

        $new_status = 10;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_cierre_cifras(){
        $lotes = $this->CasasModel->getListaCierreCifras();

        $this->json($lotes);
    }

    public function to_vobo_cifras(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 11;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_vobo_cifras(){
        $lotes = $this->CasasModel->getListaVoBoCifras();

        $this->json($lotes);
    }

    public function back_to_cierre_cifras(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 10;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function to_expediente_cliente(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 12;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_expediente_cliente(){
        $lotes = $this->CasasModel->getListaExpedienteCliente();

        $this->json($lotes);
    }

    public function to_envio_a_firma(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 13;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_envio_a_firma(){
        $lotes = $this->CasasModel->getListaEnvioAFirma();

        $this->json($lotes);
    }

    public function back_to_expediente_cliente(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 12;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function to_firma_contrato(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 14;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_firma_contrato(){
        $lotes = $this->CasasModel->getListaFirmaContrato();

        $this->json($lotes);
    }

    public function to_recepcion_contrato(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 15;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_recepcion_contrato(){
        $lotes = $this->CasasModel->getListaRecepcionContrato();

        $this->json($lotes);
    }

    public function back_to_firma_contrato(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 14;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function to_finalizar(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $new_status = 16;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');
            
            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function lista_finalizar(){
        $finalizado = $this->input->get('finalizado');

        $in = '0, 1';

        if($finalizado == '1'){
            $in = '1';
        }

        if($finalizado == '0'){
            $in = '0';
        }

        $lotes = $this->CasasModel->getListaFinalizar($in);

        $this->json($lotes);
    }

    public function finalizar_proceso(){
        $id = $this->input->get('id');

        if(!isset($id)){
            http_response_code(400);
        }

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->markProcesoFinalizado($id);

        if($is_ok){
            $this->CasasModel->addHistorial($id, $proceso->proceso, $proceso->proceso, 'Proceso finalizado');

            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function ingresar_adeudo(){
        $form = $this->form();

        if(!isset($form->id) || !isset($form->adeudo)){
            http_response_code(400);
        }

        $id_rol = 2;

        $column = 'adeudoOOAM';

        $proceso = $this->CasasModel->getProceso($form->id);

        if($proceso && isset($column)){
            $is_ok = $this->CasasModel->setAdeudo($proceso->idProcesoCasas, $column, $form->adeudo);

            if($is_ok){
                $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, "Se modifico adeudo: $column");

                $this->json([]);
            }else{
                http_response_code(404);
            }
        }

        http_response_code(404);
    }

    public function lista_propuestas($proceso){
        $propuestas = $this->CasasModel->getPropuestas($proceso);

        $this->json($propuestas);
    }

    public function save_propuesta(){
        $form = $this->form();

        if(!$form->idProcesoCasas || !$form->notaria || !$form->fecha){
            http_response_code(400);
        }

        $proceso = $this->CasasModel->getProceso($form->idProcesoCasas);

        if(isset($form->idPropuesta)){
            $is_ok = $this->CasasModel->updatePropuesta($form->idPropuesta, $form->notaria, $form->fecha, $form->costo);

            $descripcion = "Se actualizo propuesta: $form->idPropuesta";
        }else{
            $is_ok = $this->CasasModel->addPropuesta($form->idProcesoCasas, $form->notaria, $form->fecha, $form->costo);

            $descripcion = "Se agrego propuesta";
        }

        if($is_ok){
            $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, $descripcion);

            $this->json([]);
        }else{
            http_response_code(404);
        }
    }

    public function set_propuesta(){
        $form = $this->form();

        if(!$form->idProcesoCasas || !$form->idPropuesta){
            http_response_code(400);
        }

        $proceso = $this->CasasModel->getProceso($form->idProcesoCasas);

        $is_ok = $this->CasasModel->setPropuesta($proceso->idProcesoCasas, $form->idPropuesta);

        if($is_ok){
            
            $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, "Se selecciono propuesta: $form->idPropuesta");

            $this->json([]);
        }else{
            http_response_code(404);
        }
    }
}