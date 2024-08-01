<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . "/controllers/BaseController.php");

class Casas extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('CasasModel'));
        $this->load->model('General_model');

        $this->load->library(['session']);

        $this->idRol = $this->session->userdata('id_rol');
        $this->idUsuario = $this->session->userdata('id_usuario');
    }

    public function cartera()
    {
        $this->load->view('template/header');
        $this->load->view("casas/cartera"); // se ha movido a raíz el archivo
    }

    public function asignacion()
    {
        $this->load->view('template/header');
        $this->load->view("casas/asignacion");
    }

    public function carta_auth()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/carta_auth");
    }

    public function adeudos()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/adeudos");
    }

    public function docu_cliente()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/docu_cliente");
    }

    public function documentacion($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/documentacion", $data);
    }

    public function proyecto_ejecutivo()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/proyecto_ejecutivo");
    }

    public function documentos_proyecto_ejecutivo($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/documentos_proyecto_ejecutivo", $data);
    }

    public function valida_comite()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/valida_comite");
    }

    public function comite_documentos($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/comite_documentos", $data);
    }

    public function carga_titulos()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/carga_titulos");
    }

    public function eleccion_propuestas()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/eleccion_propuestas");
    }

    public function propuesta_firma()
    {
        $data = [
            'idRol' => $this->idRol,
            'idUsuario' => $this->idUsuario,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/propuesta_firma", $data);
    }

    public function validacion_contraloria()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/validacion_contraloria");
    }

    public function valida_documentacion($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/valida_documentacion", $data);
    }

    public function cierre_cifras_documentacion($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/cierre_cifras_documentacion", $data);
    }

    public function solicitar_contratos()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/solicitar_contratos");
    }

    public function contratos($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/contratos", $data);
    }

    public function recepcion_contratos()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/recepcion_contratos");
    }

    public function vobo_contratos($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/vobo_contratos", $data);
    }

    public function cierre_cifras()
    {
        $data = [
            'idRol' => $this->idRol,
            'idUsuario' => $this->idUsuario,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/cierre_cifras", $data);
    }

    public function vobo_cifras()
    {
        $data = [
            'idUsuario' => $this->idUsuario,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/vobo_cifras", $data);
    }

    public function expediente_cliente()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/expediente_cliente");
    }

    public function envio_a_firma()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/envio_a_firma");
    }

    public function firma_contrato()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/firma_contrato");
    }

    public function recepcion_contrato()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/recepcion_contrato");
    }

    public function finalizar()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/finalizar");
    }

    public function ingresar_adeudos()
    {
        $data = [
            'idRol' => $this->idRol,
            'idUsuario' => $this->idUsuario,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/ingresar_adeudos", $data);
    }

    public function reporte_casas()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/reporte_casas");
    }

    public function cotizaciones($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/cotizaciones", $data);
    }

    public function historial($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/historial", $data);
    }

    public function carga_kit_bancario()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/carga_kit_bancario");
    }

    public function archivo($name)
    {
        $object = $this->bucket->object(urldecode($name));

        if ($object->exists()) {
            $contentType = $object->info()['contentType'];

            $file = $object->downloadAsString();

            header("Content-type: $contentType");

            print($file);

        } else {
            header("HTTP/1.1 404 Not Found");

            http_response_code(404);
        }
    }

    public function residenciales()
    {
        $residenciales = $this->CasasModel->getResidencialesOptions();

        $this->json($residenciales);
    }

    public function condominios()
    {
        $idResidencial = $this->input->get('proyecto');

        $condominios = $this->CasasModel->getCondominiosOptions($idResidencial);

        $this->json($condominios);
    }

    public function options_gerentes()
    {
        $asesores = $this->CasasModel->getGerentesOptions();

        $this->json($asesores);
    }

    public function options_asesores()
    {
        $asesores = $this->CasasModel->getAsesoresOptions();

        $this->json($asesores);
    }

    public function options_tipos_credito()
    {
        $notarias = $this->CasasModel->getTiposCreditoOptions();

        $this->json($notarias);
    }

    public function options_notarias()
    {
        $notarias = $this->CasasModel->getNotariasOptions();

        $this->json($notarias);
    }

    public function get_cotizaciones()
    {
        $id = $this->input->get('id');

        $cotizaciones = $this->CasasModel->getCotizacionesOptions($id);

        $this->json($cotizaciones);
    }

    public function lotes()
    {
        $idCondominio = $this->input->get('condominio');

        if (!isset($idCondominio)) {
            $this->json([]);
        }

        $lotes = $this->CasasModel->getCarteraLotes($idCondominio);

        $this->json($lotes);
    }

    public function lotesCreditoDirecto()
    {
        $data = $this->input->get();
        $proceso = $data["proceso"];

        $tipoDocumento = isset($data["tipoDocumento"]) ? $data["tipoDocumento"] : 0;

        if (!isset($proceso)) {
            $proceso = 0; // se asigna esta variable para saber de que proceso se van a mostrar
        }

        $lotes = $this->CasasModel->lotesCreditoDirecto($proceso, $tipoDocumento)->result();

        $this->json($lotes);
    }

    public function lista_asignacion()
    {
        $lotes = $this->CasasModel->getListaAsignacion();

        $this->json($lotes);
    }

    public function to_asignacion()
    {

        $idLote = $this->form('idLote');
        $comentario = $this->form('comentario');
        $gerente = $this->form('gerente');
        $idUsuario = $this->session->userdata('id_usuario');

        $esquemaCredito = $this->form('esquemaCredito'); // se agrega el tipo de crdito - 1: bancario - 2: directo
        $banderaSuccess = true;

        if (!isset($idLote) || !isset($gerente) || !isset($esquemaCredito)) {
            http_response_code(400);
            $this->json([]);
        }

        $dataUpdate = array(
            "esquemaCreditoCasas" => $esquemaCredito
        );

        $this->db->trans_begin();

        if ($esquemaCredito == 1) { // se agrega un condicion para saber que esquema de credito se usara
            $proceso = $this->CasasModel->addLoteToAsignacion($idLote, $gerente, $comentario, $idUsuario);
            // $copiarDs = $this->copiarDS($idLote);
        } else if ($esquemaCredito == 2) {
            $proceso = $this->CasasModel->addLoteToAsignacionDirecto($idLote, $gerente, $comentario, $idUsuario);
        }

        if ($proceso) {
            $this->CasasModel->addHistorial($proceso->idProcesoCasas, 'NULL', 0, 'Se inicio proceso | Comentario: ' . $proceso->comentario, $esquemaCredito == 1 ? 1 : 2);
            $this->General_model->updateRecord('lotes', $dataUpdate, 'idLote', $idLote);
        } else {
            $this->db->trans_rollback();
            http_response_code(404);

            $this->json([]);
        }

        $this->db->trans_commit();
        $this->json([]);
    }

    public function asignar()
    {
        $form = $this->form();

        $id = $this->form('id');
        $asesor = $this->form('asesor');
        $idLote = $this->form('idLote');
        $proceso = $this->form('proceso');
        $esquemaCreditoCasas = $this->form('esquemaCreditoCasas');
        $idProcesoCasas = $this->form('idProcesoCasas');
        $update = true;
        $banderaSuccess = true;

        if (!isset($form->id) || !isset($form->asesor) || !isset($form->id) || !isset($form->asesor)) {
            http_response_code(400);
        }

        $this->db->trans_begin();

        // paso general: se obtiene al asesor
        $asesor = $this->CasasModel->getAsesor($form->asesor);

        $addHistorialData = array(
            "idProcesoCasas"        => $idProcesoCasas,
            "procesoAnterior"       => $proceso,
            "procesoNuevo"          => $proceso,
            "fechaMovimiento"       => date("Y-m-d H:i:s"),
            "creadoPor"             => $this->session->userdata('id_usuario'),
            "descripcion"           => "Se asigno el asesor: " . $asesor->nombre . " - con id: " . $asesor->idUsuario,
            "esquemaCreditoProceso" => $esquemaCreditoCasas
        );

        $updateData = array(
            "idAsesor" => $asesor->idUsuario,
            "fechaModificacion" => date("Y-m-d H:i:s")
        );

        // paso general: se agrega el registro al historial
        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $addHistorialData);
        if (!$addHistorial) {
            $banderaSuccess = false;
        }

        if ($esquemaCreditoCasas == 1) {  // esquema de banco
            $update = $this->General_model->updateRecord("proceso_casas", $updateData, "idProcesoCasas", $idProcesoCasas);
        } else if ($esquemaCreditoCasas == 2) { // esquema directo
            $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProcesoCasas);
        }

        if (!$update) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(404);

            $this->json([]);
        }
    }

    public function to_carta_auth()
    {
        $this->form();

        $id = $this->form('id');
        $asesor = $this->form('asesor');
        $idLote = $this->form('idLote');
        $proceso = $this->form('proceso');
        $esquemaCreditoCasas = $this->form('esquemaCreditoCasas');
        $idProcesoCasas = $this->form('idProcesoCasas');
        $tipoMovimiento = $this->form('tipoMovimiento');
        $update = true;
        $comentario = $this->form('comentario');
        $banderaSuccess = true;

        if (!isset($id) || !isset($asesor) || !isset($idLote) || !isset($proceso) || !isset($esquemaCreditoCasas) || !isset($esquemaCreditoCasas) || !isset($idProcesoCasas) || !isset($update)) {
            http_response_code(400);

            $banderaSuccess = false;
        }

        $this->db->trans_begin();

        if ($esquemaCreditoCasas == 1) { // proceso de credito de banco
            $new_status = 1;

            $documentos = $this->CasasModel->getDocumentos([1]);

            foreach ($documentos as $key => $documento) {
                $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

                if (!$is_ok) {
                    break;
                }
            }

            $movimiento = 0;
            if ($tipoMovimiento == 1) {
                $movimiento = 2;
            }

            $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

            if ($is_ok) {
                $this->CasasModel->addHistorial($id, $proceso, $new_status, $comentario, 1);
            } else {
                $banderaSuccess = false;
            }
        } else if ($esquemaCreditoCasas == 2) { // proceso de credito directo
            $movimiento = 1;
            if ($tipoMovimiento == 2) {
                $movimiento = 3;
            }

            $updateData = array(
                "proceso"        => 16,
                "comentario"     => $comentario,
                "tipoMovimiento" => $movimiento,
                "fechaAvance"  => date("Y-m-d H:i:s"),
                "fechaModificacion"  => date("Y-m-d H:i:s")
            );

            $insertData = array(
                "idProcesoCasas"  => $idProcesoCasas,
                "procesoAnterior" => $proceso,
                "procesoNuevo"    => 16,
                "fechaMovimiento" => date("Y-m-d H:i:s"),
                "creadoPor"       => $this->session->userdata("id_usuario"),
                "descripcion"     => $comentario,
                "esquemaCreditoProceso" => 2
            );

            // se actualiza el registro de credito directo
            $update = $this->General_model->updateRecord('proceso_casas_directo', $updateData, 'idProceso', $idProcesoCasas);
            if (!$update) {
                $banderaSuccess = false;
            }

            $add = $this->General_model->addRecord('historial_proceso_casas', $insertData);
            if (!$add) {
                $banderaSuccess = false;
            }
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(404);

            $this->json([]);
        }
    }

    public function lista_carta_auth()
    {
        $lotes = $this->CasasModel->getListaCartaAuth();

        $this->json($lotes);
    }

    public function cancel_process()
    {
        $this->form();

        $id = $this->form('id');
        $idLote = $this->form('idLote');
        $proceso = $this->form('proceso');
        $esquemaCreditoCasas = $this->form('esquemaCreditoCasas');
        $idProcesoCasas = $this->form('idProcesoCasas');
        $comentario = $this->form('comentario');
        $banderaSuccess = true;

        if (!isset($id) || !isset($esquemaCreditoCasas)) {
            http_response_code(400);
        }

        $this->db->trans_begin();

        $updateLoteData = array(
            "esquemaCreditoCasas" => 0
        );

        $insertHistorialData = array(
            "idProcesoCasas"  => $id,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => 0,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata("id_usuario"),
            "descripcion"     => $comentario
        );

        // paso general 1: se regresa el esquema de credito del lote a 0 
        $updateLote = $this->General_model->updateRecord("lotes", $updateLoteData, "idLote", $idLote);
        if (!$updateLote) {
            $banderaSuccess = false;
        }

        // paso general 2: se agrega el historial
        $addHistorial = $this->General_model->addRecord('historial_proceso_casas', $insertHistorialData);
        if (!$addHistorial) {
            $banderaSuccess = false;
        }

        if ($esquemaCreditoCasas == 1) {
            $updateDataBanco = array(
                "status" => 0
            );
            // se elimina el registro de proceso_casas o se modifica ?
            // $deleteBanco = $this->General_model->deleteRecord('proceso_casas', array("idProcesoCasas" => $idProcesoCasas) );
            $deleteBanco = $this->General_model->updateRecord('proceso_casas', $updateDataBanco, "idProcesoCasas", $idProcesoCasas);
            if (!$deleteBanco) {
                $banderaSuccess = false;
            }
        } else if ($esquemaCreditoCasas == 2) {
            $updateDataDirecto = array(
                "estatus" => 0
            );
            // se elimina el registro de proceso_casas_directo
            //$deleteBanco = $this->General_model->deleteRecord('proceso_casas_directo', array("idProceso" => $idProcesoCasas) );
            $deleteBanco = $this->General_model->updateRecord('proceso_casas_directo', $updateDataDirecto, "idProceso", $idProcesoCasas);
            if (!$deleteBanco) {
                $banderaSuccess = false;
            }
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();

            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);
        }
    }

    public function back_to_asignacion()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 0;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function generateFileName($documento, $lote, $proceso, $archivo)
    {
        $file_ext = pathinfo($archivo, PATHINFO_EXTENSION);

        $documento = strtoupper($documento);
        $documento = str_replace(" ", "_", $documento);

        $lote = str_replace("-", "_", $lote);

        $filename = $documento . "_" . $lote . "_" . $proceso . '.' . $file_ext;

        $input = ['+', "'", '`', '^', 'à', '{', '}', ']', '[', 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ä', 'ë', 'ï', 'ö', 'ü', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü', 'â', 'ã', 'ä', 'å', 'ā', 'ă', 'ą', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ā', 'Ă', 'Ą', 'è', 'é', 'é', 'ê', 'ë', 'ē', 'ĕ', 'ė', 'ę', 'ě', 'Ē', 'Ĕ', 'Ė', 'Ę', 'Ě', 'ì', 'í', 'î', 'ï', 'ì', 'ĩ', 'ī', 'ĭ', 'Ì', 'Í', 'Î', 'Ï', 'Ì', 'Ĩ', 'Ī', 'Ĭ', 'ó', 'ô', 'õ', 'ö', 'ō', 'ŏ', 'ő', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ō', 'Ŏ', 'Ő', 'ù', 'ú', 'û', 'ü', 'ũ', 'ū', 'ŭ', 'ů', 'Ù', 'Ú', 'Û', 'Ü', 'Ũ', 'Ū', 'Ŭ', 'Ů', '(', ')', ' ', 'Ñ', 'ñ'];
        $output = '';

        $filename = str_replace($input, $output, $filename);

        return $filename;
    }

    public function upload_documento()
    {
        $id_proceso = $this->form('id_proceso');
        $id_documento = $this->form('id_documento');
        $name_documento = $this->form('name_documento');

        if (!isset($id_proceso) || !isset($id_documento) || !isset($name_documento)) {
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->CasasModel->getProceso($id_proceso);

        $file = $this->file('file_uploaded');

        if (!$file) {
            http_response_code(400);
        }

        if ($file) {
            $filename = $this->generateFileName($name_documento, $proceso->nombreLote, $id_proceso, $file->name);

            $uploaded = $this->upload($file->tmp_name, $filename);

            if ($uploaded) {
                $updated = $this->CasasModel->updateDocumentRow($id_documento, $filename);

                if ($updated) {
                    $motivo = "Se subio archivo: $name_documento";
                    $this->CasasModel->addHistorial($id_proceso, $proceso->proceso, $proceso->proceso, $motivo, 1); // se añade el numero de esquema 1 -proceso banco

                    $this->json([]);
                }
            }
        }

        http_response_code(404);
    }

    public function to_concentrar_adeudos()
    {
        $id = $this->form('id');
        $tipo = $this->form('tipo');
        $comentario = $this->form('comentario');

        if (!isset($id) || !isset($tipo)) {
            http_response_code(400);
            $this->json([]);
        }

        $new_status = 2;

        $proceso = $this->CasasModel->getProceso($id);

        // Aqui se asignara notaria si mas adelante nos piden poner mas notarias
        $notaria = 1;
        if ($tipo == 2) {
            $notaria = 2;
        }

        $is_ok = $this->CasasModel->setTipoCredito($id, $tipo, $notaria);

        $vobo = $this->CasasModel->getVobos($id, 1);

        if(!$vobo){
            $insertVobo = $this->CasasModel->insertVobo($proceso->idProcesoCasas, 1);

            if(!$insertVobo){
                http_response_code(404);
            }
        }

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        if ($is_ok) {
            $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

            $documentos = $this->CasasModel->getDocumentos([2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 23, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48]); // cambio a partir del 23 se agregaron los documentos faltantes de cliente y proveedor

            $is_okDoc = true;
                foreach ($documentos as $key => $documento) {
                    $is_ok = $this->CasasModel->inserDocumentsToProceso($proceso->idProcesoCasas, $documento->tipo, $documento->nombre);
                    if (!$is_okDoc) {
                        break;
                    }
                }

            if (!$is_okDoc) {
                http_response_code(500);
            }

            if ($is_ok) {
                $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1); // se agrega esquema 1 - credito de banco
            } else {
                http_response_code(404);
            }
        }

        $this->json([]);
    }

    public function lista_adeudos()
    {
        $data = $this->input->get();
        $tipoDoc = $data["tipoDoc"];
        $rol = $data["rol"];
        
        $lotes = $this->CasasModel->getListaConcentradoAdeudos($tipoDoc, $rol);

        $this->json($lotes);
    }

    public function concentracion_adeudos()
    {
        $data = $this->input->get();
        $documentos = $data["documentos"];

        $lotes = $this->CasasModel->getConcentracionAdeudos($documentos);

        $this->json($lotes);
    }

    public function back_to_carta_auth()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $vobo = $this->CasasModel->getVobos($id, 1);

        $updateData = array(
                "adm"  => 0,
                "ooam" => 0,
                "proyectos" => 0,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
        );
             
        $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);

        if(!$update){
            http_response_code(400);
        }

        $new_status = 1;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario, 1);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function to_documentacion_cliente()
    {
        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $documentos = $this->CasasModel->getDocumentos([2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 23, 26, 27]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if (!$is_ok) {
                break;
            }
        }

        if (!$is_ok) {
            http_response_code(500);
            $this->json([]);
        }

        $new_status = 3;

        $proceso = $this->CasasModel->getProceso($id);

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_proceso_documentos()
    {
        $lotes = $this->CasasModel->getListaProcesoDocumentos();

        $this->json($lotes);
    }

    public function back_to_adeudos()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 1;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario, 1);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_documentos_cliente($proceso)
    {
        $lotes = $this->CasasModel->getListaDocumentosCliente($proceso);

        $this->json($lotes);
    }

    public function lista_proyecto_ejecutivo_documentos()
    {
        $lotes = $this->CasasModel->getListaProyectoEjecutivo();

        $this->json($lotes);
    }

    public function lista_documentos_proyecto_ejecutivo($proceso)
    {
        $lotes = $this->CasasModel->getListaDocumentosProyectoEjecutivo($proceso);

        $this->json($lotes);
    }

    public function to_valida_comite()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');
        $rol = $this->form('rol') ? $this->form('rol') : 0;
        $doc = $this->form('documentos');

        if (!isset($id)) {
            http_response_code(400);
        }

        $documentos = $this->CasasModel->getDocumentos([16]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if (!$is_ok) {
                break;
            }
        }

        $vobo = $this->CasasModel->getVobos($id, 1);

        $proceso = $this->CasasModel->getProceso($id);

        if($doc == 3 && $vobo->adm == 1 && $vobo->ooam == 1){

            $updateData = array(
                "proyectos" => 1,
                "modificadoPor" => $this->session->userdata('id_usuario')
            );

            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);

            if (!$update) {
                http_response_code(404);
            }

            $this->CasasModel->addHistorial($id, $proceso->proceso, $proceso->proceso, $comentario, 1);

            $new_status = 4;

            $movimiento = 0;
            if ($proceso->tipoMovimiento == 1) {
                $movimiento = 2;
            }

            $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

            if ($is_ok) {
                $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1);

                $this->json([]);
            } else {
                http_response_code(404);
            }

        }else if($doc == 3 && ($vobo->adm == 0 || $vobo->ooam == 0)){

            if($rol == 0){

                $updateData = array(
                    "proyectos" => 1,
                    "modificadoPor" => $this->session->userdata('id_usuario')
                );
    
                $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);
    
                if ($update) {
                    $this->CasasModel->addHistorial($id, $proceso->proceso, $proceso->proceso, $comentario, 1);
    
                    $this->json([]);
                } else {
                    http_response_code(404);
                }
            }

                switch ($rol) {
                    case "99":
                        $updateData = array(
                            "ooam"  => 1,
                            "modificadoPor" => $this->session->userdata('id_usuario'),
                            "fechaModificacion" => date("Y-m-d H:i:s"),
                        );
                        break;
                    case "11":
                        $updateData = array(
                            "adm"  => 1,
                            "modificadoPor" => $this->session->userdata('id_usuario'),
                            "fechaModificacion" => date("Y-m-d H:i:s"),
                        );
                        break;
                    case "33":
                        $updateData = array(
                            "adm"  => 1,
                            "modificadoPor" => $this->session->userdata('id_usuario'),
                            "fechaModificacion" => date("Y-m-d H:i:s"),
                        );
                        break;
                }

                $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);
    
                if (!$update) {
                    http_response_code(404);
                }

                $vobo = $this->CasasModel->getVobos($id, 1);

                if($vobo->ooam == 1 && $vobo->adm == 1 && $vobo->proyectos == 1){
                    $new_status = 4;

                    $movimiento = 0;
                    if ($proceso->tipoMovimiento == 1) {
                        $movimiento = 2;
                    }

                    $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

                    if ($is_ok) {
                        $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1);

                        $this->json([]);
                    } else {
                        http_response_code(404);
                    }
                }

        }else{

            switch ($rol) {
                case "99":
                    $updateData = array(
                        "ooam"  => 1,
                        "modificadoPor" => $this->session->userdata('id_usuario'),
                        "fechaModificacion" => date("Y-m-d H:i:s"),
                    );
                    break;
                case "11":
                    $updateData = array(
                        "adm"  => 1,
                        "modificadoPor" => $this->session->userdata('id_usuario'),
                        "fechaModificacion" => date("Y-m-d H:i:s"),
                    );
                    break;
                case "33":
                    $updateData = array(
                        "adm"  => 1,
                        "modificadoPor" => $this->session->userdata('id_usuario'),
                        "fechaModificacion" => date("Y-m-d H:i:s"),
                    );
                    break;
            }
            
            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);

            if ($update) {
                $this->CasasModel->addHistorial($id, $proceso->proceso, $proceso->proceso, $comentario, 1);

                $this->json([]);
            } else {
                http_response_code(404);
            }

        }
    }

    public function lista_valida_comite()
    {
        $lotes = $this->CasasModel->getListaValidaComite();

        $this->json($lotes);
    }

    public function back_to_documentos()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 9;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario, 1);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_documentos_comite($proceso)
    {
        $lotes = $this->CasasModel->getListaDocumentosComiteEjecutivo($proceso);

        $this->json($lotes);
    }

    public function to_propuesta_firma()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
            $this->json([]);
        }

        $new_status = 5;

        $proceso = $this->CasasModel->getProceso($id);

        $cotizaciones = 1;
        if ($proceso->tipoCredito == 2) {
            $cotizaciones = 2;
        }

        $is_ok = $this->CasasModel->addPropuesta($id);

        $this->CasasModel->removeCotizaciones($id);
        for ($i = 1; $i <= $cotizaciones; $i++) {
            $is_ok = $this->CasasModel->addCotizacion($id);
        }

        $documentos = $this->CasasModel->getDocumentos([17, 28, 29, 30, 31, 32]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if (!$is_ok) {
                break;
            }
        }

        if ($is_ok) {
            $movimiento = 0;
            if ($proceso->tipoMovimiento == 1) {
                $movimiento = 2;
            }

            $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

            if ($is_ok) {
                $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario);
            } else {
                http_response_code(404);
            }
        } else {
            http_response_code(500);
        }

        $this->json([]);
    }

    /*
    public function lista_carga_titulos(){
        $lotes = $this->CasasModel->getListaCargaTitulos();

        $this->json($lotes);
    }
    */

    public function to_propuestas()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $documentos = $this->CasasModel->getDocumentos([18]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if (!$is_ok) {
                break;
            }
        }

        $new_status = 9;

        $proceso = $this->CasasModel->getProceso($id);

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_eleccion_propuestas()
    {
        $lotes = $this->CasasModel->getListaEleccionPropuestas();

        $this->json($lotes);
    }

    public function back_to_propuesta_firma()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 8;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario, 1);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function to_validacion_contraloria()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 10;

        $proceso = $this->CasasModel->getProceso($id);

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        if ($is_ok) {

            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_propuesta_firma()
    {
        $lotes = $this->CasasModel->getListaPropuestaFirma();

        $this->json($lotes);
    }

    public function lista_validacion_contraloria()
    {
        $lotes = $this->CasasModel->getListaValidaContraloria();

        $this->json($lotes);
    }

    public function lista_carga_kit_bancario()
    {
        $lotes = $this->CasasModel->getListaCargaKitBancario();

        $this->json($lotes);
    }

    public function lista_valida_documentacion($proceso)
    {
        $lotes = $this->CasasModel->getListaDocumentosValidaContraloria($proceso);

        $this->json($lotes);
    }

    public function to_solicitud_contratos()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $documentos = $this->CasasModel->getDocumentos([19, 20, 21, 22, 23, 24]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if (!$is_ok) {
                break;
            }
        }

        $new_status = 11;

        $proceso = $this->CasasModel->getProceso($id);

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function capturaContratos()
    {
        $this->form();

        $id = $this->form('id');
        $obra = $this->form('obra');
        $tesoreria = $this->form('tesoreria');
        $serviciosArquitectonicos = $this->form('serviciosArquitectonicos');

        if (!isset($id)) {
            http_response_code(400);
        }

        $updateData = array(
            "obra"  => $obra,
            "tesoreria" => $tesoreria,
            "serviciosArquitectonicos"    => $serviciosArquitectonicos,
        );

        $update = $this->General_model->updateRecord("proceso_casas", $updateData, "idProcesoCasas", $id);

        $proceso = $this->CasasModel->getProceso($id);

        if ($update) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $proceso->proceso, 'Se ingresaron la captura de contratos', 1);
            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function to_cierre_cifras()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 12;

        $proceso = $this->CasasModel->getProceso($id);

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_solicitar_contratos()
    {
        $lotes = $this->CasasModel->getListaSolicitarContratos();

        $this->json($lotes);
    }

    public function to_confirmar_contratos()
    {
        $id = $this->input->get('id');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 9;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se avanzo proceso');

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_contratos($proceso)
    {
        $lotes = $this->CasasModel->getListaContratos($proceso);

        $this->json($lotes);
    }

    public function lista_recepcion_contratos()
    {
        $lotes = $this->CasasModel->getListaRecepcionContratos();

        $this->json($lotes);
    }

    public function back_to_solicitar_contratos()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 2;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function to_carga_cifras()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $documentos = $this->CasasModel->getDocumentos([25]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

            if (!$is_ok) {
                break;
            }
        }

        $new_status = 10;

        $proceso = $this->CasasModel->getProceso($id);

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_cierre_cifras()
    {
        $lotes = $this->CasasModel->getListaCierreCifras();

        $this->json($lotes);
    }

    public function to_vobo_cifras()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 13;

        $proceso = $this->CasasModel->getProceso($id);

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1);

            $this->json([]);
        } 
        else {
            http_response_code(404);
        }
    }

    public function lista_vobo_cifras()
    {
        $lotes = $this->CasasModel->getListaVoBoCifras();

        $this->json($lotes);
    }

    public function back_to_cierre_cifras()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 10;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        $is_ok = $this->CasasModel->resetVoBos($id);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function to_expediente_cliente()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
            $this->json([]);
        }

        $column = null;
        if (in_array($this->idUsuario, [5107])) {
            $column = 'voboADM';
        }
        if (in_array($this->idUsuario, [15891, 15892, 15893, 16197, 16198, 16199])) {
            $column = 'voboOOAM';
        }
        if (in_array($this->idUsuario, [15896, 16204, 15897, 16205, 15898, 16206, 4512])) {
            $column = 'voboGPH';
        }
        if (in_array($this->idUsuario, [2896, 12072, 12112, 15900, 16208])) {
            $column = 'voboPV';
        }

        if (!$column) {
            http_response_code(500);
            $this->json([]);
        }

        $updated = $this->CasasModel->setVoboToProceso($id, $column);

        if ($updated) {
            $new_status = 12;

            $proceso = $this->CasasModel->getProceso($id);

            if ($proceso->voboADM && $proceso->voboOOAM && $proceso->voboGPH && $proceso->voboPV) {

                $movimiento = 0;
                if ($proceso->tipoMovimiento == 1) {
                    $movimiento = 2;
                }

                $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

                if ($is_ok) {
                    $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario);
                } else {
                    http_response_code(404);
                }
            }

            $this->json([]);
        }
    }

    public function lista_expediente_cliente()
    {
        $lotes = $this->CasasModel->getListaExpedienteCliente();

        $this->json($lotes);
    }

    public function to_envio_a_firma()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 13;

        $proceso = $this->CasasModel->getProceso($id);

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_envio_a_firma()
    {
        $lotes = $this->CasasModel->getListaEnvioAFirma();

        $this->json($lotes);
    }

    public function back_to_expediente_cliente()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 12;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function to_firma_contrato()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 14;

        $proceso = $this->CasasModel->getProceso($id);

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_firma_contrato()
    {
        $lotes = $this->CasasModel->getListaFirmaContrato();

        $this->json($lotes);
    }

    public function to_recepcion_contrato()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 15;

        $proceso = $this->CasasModel->getProceso($id);

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_recepcion_contrato()
    {
        $lotes = $this->CasasModel->getListaRecepcionContrato();

        $this->json($lotes);
    }

    public function back_to_firma_contrato()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 14;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function to_finalizar()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 16;

        $proceso = $this->CasasModel->getProceso($id);

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_finalizar()
    {
        $finalizado = $this->input->get('finalizado');

        $in = '0, 1';

        if ($finalizado == '1') {
            $in = '1';
        }

        if ($finalizado == '0') {
            $in = '0';
        }

        $lotes = $this->CasasModel->getListaFinalizar($in);

        $this->json($lotes);
    }

    public function finalizar_proceso()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');

        if (!isset($id)) {
            http_response_code(400);
        }

        $proceso = $this->CasasModel->getProceso($id, $comentario);

        $is_ok = $this->CasasModel->markProcesoFinalizado($id);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $proceso->proceso, 'Proceso finalizado | Comentario: ' . $comentario);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function ingresar_adeudo()
    {
        $form = $this->form();

        if (!isset($form->id) || !isset($form->adeudo) || !isset($form->cantidad)) {
            http_response_code(400);
            $this->json([]);
        }

        $id_rol = 2;

        $proceso = $this->CasasModel->getProceso($form->id);

        if ($proceso /* && isset($column) */) {
            $is_ok = $this->CasasModel->setAdeudo($proceso->idProcesoCasas, $form->adeudo, $form->cantidad);

            if ($is_ok) {

                // Se valida se ya se regitraron todos los adeudos
                $adeudosValid = $this->CasasModel->getAdeudosValid($proceso->idProcesoCasas);

                // Se actualiza el proceso a 3
                if($adeudosValid->num_rows() > 0){
                    
                    $this->CasasModel->setProceso3($proceso->idProcesoCasas);

                    $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, 3, "Se modifico adeudo", 1);
                }

                $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, "Se modifico adeudo", 1);

                $this->json([]);
            } else {
                http_response_code(404);
            }
        }

        http_response_code(404);
    }

    public function lista_cotizaciones($proceso)
    {
        $propuestas = $this->CasasModel->getCotizaciones($proceso);

        $this->json($propuestas);
    }

    public function save_propuestas()
    {
        $idProcesoCasas = $this->form('idProcesoCasas');
        $fechaFirma1 = $this->form('fechaFirma1');
        $fechaFirma2 = $this->form('fechaFirma2') ? $this->form('fechaFirma2') : null;
        $fechaFirma3 = $this->form('fechaFirma3') ? $this->form('fechaFirma3') : null;

        if (!$idProcesoCasas || !$fechaFirma1) {
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->CasasModel->getProceso($idProcesoCasas);

        $getProuesta = $this->CasasModel->getProuesta($idProcesoCasas);

        if($getProuesta->num_rows() > 0){

            $is_ok = $this->CasasModel->updatePropuesta($idProcesoCasas, $fechaFirma1, $fechaFirma2, $fechaFirma3);

        }else{

            $dataPropuesta = array(
                "idProcesoCasas"  => $idProcesoCasas,
                "fechaFirma1" => $fechaFirma1,
                "fechaFirma2"    => $fechaFirma2,
                "fechaFirma3" => $fechaFirma3,
                "fechaCreacion" => date("Y-m-d H:i:s"),
                "creadoPor"    => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
                "idModificacion"    => $this->session->userdata('id_usuario'),
            );

            $is_ok = $this->General_model->addRecord("propuestas_proceso_casas", $dataPropuesta);

        }

        if ($is_ok) {
            $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, "Se actualizo propuesta del proceso: $idProcesoCasas", 1);
        } else {
            http_response_code(404);
        }

        $this->json([]);
    }

    public function set_propuesta()
    {
        $form = $this->form();

        if (!$form->idProcesoCasas || !$form->cotizacion || !$form->fecha || !$form->idPropuesta) {
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->CasasModel->getProceso($form->idProcesoCasas);

        $is_ok = $this->CasasModel->setPropuesta($proceso->idProcesoCasas, $form->idPropuesta, $form->fecha, $form->cotizacion);

        if ($is_ok) {
            $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, "Se selecciono cotizacion: $form->cotizacion", 1);
        } else {
            http_response_code(404);
        }

        $this->json([]);
    }

    public function save_cotizacion()
    {
        $form = $this->form();

        if (!$form->idCotizacion || !$form->nombre) {
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->CasasModel->getProceso($form->idProcesoCasas);

        $file = $this->file('archivo');
        $filename = '';

        if ($file) {
            $name_documento = "COTIZACION $form->idCotizacion";

            $filename = $this->generateFileName($name_documento, $proceso->nombreLote, $proceso->idProcesoCasas, $file->name);

            $uploaded = $this->upload($file->tmp_name, $filename);
        }

        $is_ok = $this->CasasModel->updateCotizacion($form->idCotizacion, $form->nombre, $filename);

        if ($is_ok) {
            $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, "Se guardo cotizacion: $form->idCotizacion", 1);
        } else {
            http_response_code(404);
        }

        $this->json([]);
    }

    public function lista_reporte_casas()
    {
        $opcion = $this->input->get('opcion');

        $proceso = "0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16";
        $finalizado = "0, 1";

        if ($opcion != -1 && $opcion != -2 && isset($opcion)) {
            $proceso = $opcion;
            $finalizado = "0";
        }

        if ($opcion == -2) {
            $finalizado = "1";
        }

        $lotes = $this->CasasModel->getListaReporteCasas($proceso, $finalizado);

        $this->json($lotes);
    }

    public function lista_historial($proceso)
    {
        $lotes = $this->CasasModel->getListaHistorial($proceso);

        $this->json($lotes);
    }

    public function options_procesos()
    {
        $asesores = $this->CasasModel->getProcesosOptions();

        $this->json($asesores);
    }

    public function lista_archivos_titulos($proceso)
    {
        $lotes = $this->CasasModel->getListaArchivosTitulos($proceso);

        $this->json($lotes);
    }

    public function creditoDirectoCaja()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/cajas_adeudo_view");
    }

    public function creditoDirectoCorrida()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/expedienteCorrida_view");
    }

    public function creditoDirectoContratoElaborado()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/contrato_elaborado_view");
    }

    public function creditoDirectoAvance()
    {
        $form = $this->form();

        $idLote = $form->idLote;
        $idProceso = $form->idProceso;
        $proceso = $form->proceso;
        $procesoNuevo = $form->procesoNuevo;
        $comentario = $form->comentario;
        $tipoMovimiento = $form->tipoMovimiento;
        $banderaSuccess = true;

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $procesoNuevo,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 2
        );

        $this->db->trans_begin();

        $updateData = array(
            "comentario"        => $comentario,
            "proceso"           => $procesoNuevo,
            "fechaAvance"       => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => ($proceso > $procesoNuevo) ? 2 : (($tipoMovimiento == 2 && $procesoNuevo >= $proceso) ? 3 : 1)
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);
        if (!$update) {
            $banderaSuccess = false;
        }

        // paso 2: guardar registro del movimiento
        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if (!$addHistorial) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function UploadDocumentoCreditoDirecto()
    {
        $idProceso = $this->form('idProceso');
        $proceso = $this->form('proceso');
        $nombre_lote = $this->form('nombre_lote');
        $tipoDocumento = $this->form('tipoDocumento') ? $this->form('tipoDocumento') : 0;
        $id_documento = $this->form('id_documento');
        $file = $this->file('file_uploaded');

        if (!isset($proceso) || !isset($nombre_lote) || !isset($id_documento)) {
            http_response_code(400);
            $this->json([]);
        }

        if (!$file) {
            http_response_code(400);
        } else {

            // Consulta nombre tipo documento
            $documento = $this->CasasModel->getDocumentoCreditoDirecto($id_documento);

            $name_documento = $documento->result()[0]->nombre;

            //  Nombre del archivo          
            $filename = $this->generateFileName($name_documento, $nombre_lote, $idProceso, $file->name);

            // Se sube archivo al buket
            $uploaded = $this->upload($file->tmp_name, $filename);

            if ($uploaded) {

                $created = $this->CasasModel->insertDocProcesoCreditoDirecto($idProceso, $name_documento, $filename, $id_documento, $tipoDocumento);

                if ($created) {
                    $motivo = "Se subio archivo: $name_documento";
                    $this->CasasModel->addHistorial($idProceso, $proceso, $proceso, $motivo, 2);

                    $this->json([]);
                }
            }
        }

        http_response_code(404);
    }
    public function ordenCompra()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/ordenCompra_view");
    }

    public function validacionEngancheAvance()
    {
        $form = $this->form();

        $idLote = $form->idLote;
        $idProceso = $form->idProceso;
        $proceso = $form->proceso;
        $procesoNuevo = $form->procesoNuevo;
        $voBoValidacionEnganche = $form->voBoValidacionEnganche;
        $comentario = $form->comentario;
        $banderaSuccess = true;

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $procesoNuevo,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 2
        );

        $this->db->trans_begin();

        $updateData = array(
            "comentario" => $comentario,
            "proceso" => $procesoNuevo,
            "voBoValidacionEnganche" => $voBoValidacionEnganche
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idLote", $idLote);
        if (!$update) {
            $banderaSuccess = false;
        }

        // paso 2: guardar registro del movimiento
        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if (!$addHistorial) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function firmaClienteAvance()
    {
        $form = $this->form();

        $idLote = $form->idLote;
        $idProceso = $form->idProceso;
        $proceso = $form->proceso;
        $procesoNuevo = $form->procesoNuevo;
        $voBoContrato = $form->voBoContrato;
        $voBoValidacionEnganche = isset($form->voBoValidacionEnganche) ? $form->voBoValidacionEnganche : 1;
        $comentario = $form->comentario;
        $banderaSuccess = true;

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $procesoNuevo,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 2
        );

        $this->db->trans_begin();

        $updateData = array(
            "comentario" => $comentario,
            "proceso" => $procesoNuevo,
            "voBoContrato" => $voBoContrato,
            "voBoValidacionEnganche" => $voBoValidacionEnganche
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idLote", $idLote);
        if (!$update) {
            $banderaSuccess = false;
        }

        // paso 2: guardar registro del movimiento
        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if (!$addHistorial) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function adeudoCreditoDirecto()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/admon_adeudo_view");
    }

    public function setAdeudo()
    {
        $form = $this->form();

        $idProceso = $form->idProceso;
        $adeudo = $form->adeudo;
        $banderaSuccess = true;

        $this->db->trans_begin();

        $updateData = array(
            "adeudo"            => $adeudo,
            "fechaModificacion" => date("Y-m-d H:i:s")
        );

        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);
        if (!$update) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function avanceOrdenCompra()
    {
        $form = $this->form();

        $idProceso = $form->idProceso;
        $idLote = $form->idLote;
        $proceso = $form->proceso;
        $procesoNuevo = $form->procesoNuevo;
        $comentario = $form->comentario;
        $voBoOrdenCompra = $form->voBoOrdenCompra;
        $voBoAdeudoTerreno = $form->voBoAdeudoTerreno;
        $banderaSuccess = true;

        if(!isset($idProceso) || !isset($idLote) || !isset($proceso) || !isset($procesoNuevo) || !isset($comentario) || !isset($voBoOrdenCompra) || !isset($voBoAdeudoTerreno)){
            http_response_code(400);

            $this->json([]);
        }

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $voBoAdeudoTerreno == 1 ? $procesoNuevo : $proceso,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 2
        );

        $updateData = array(
            "comentario" => $comentario,
            "voBoOrdenCompra" => 1,
            "proceso" => $voBoAdeudoTerreno == 1 ? $procesoNuevo : $proceso,
        );

        $this->db->trans_begin();

        // actualizar el registro de la tabla
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);
        if(!$update){
            $banderaSuccess = false;
        }

        // insert en historial
        $add = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if(!$add){
            $banderaSuccess = false;
        }

        if($banderaSuccess){
            $this->db->trans_commit();
            $this->json([]);
        }
        else{
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function avanceAdeudo(){
        $form = $this->form();

        $idProceso = $form->idProceso;
        $idLote = $form->idLote;
        $proceso = $form->proceso;
        $procesoNuevo = $form->procesoNuevo;
        $comentario = $form->comentario;
        $voBoOrdenCompra = $form->voBoOrdenCompra;
        $voBoAdeudoTerreno = $form->voBoAdeudoTerreno;
        $banderaSuccess = true;

        if(!isset($idProceso) || !isset($idLote) || !isset($proceso) || !isset($procesoNuevo) || !isset($comentario) || !isset($voBoOrdenCompra) || !isset($voBoAdeudoTerreno)){
            http_response_code(400);

            $this->json([]);
        }

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $voBoOrdenCompra == 1 ? $procesoNuevo : $proceso,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 2
        );

        $updateData = array(
            "comentario" => $comentario,
            "voBoAdeudoTerreno" => 1,
            "proceso" => $voBoOrdenCompra == 1 ? $procesoNuevo : $proceso,
        );

        $this->db->trans_begin();

        // actualizar el registro de la tabla
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);
        if(!$update){
            $banderaSuccess = false;
        }

        // insert en historial
        $add = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if(!$add){
            $banderaSuccess = false;
        }

        if($banderaSuccess){
            $this->db->trans_commit();
            $this->json([]);
        }
        else{
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function creditoDirectoCongelacionSaldos()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/congelacionSaldos_view");
    }

    public function creditoDirectoFirmaCliente()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/firmaCliente_view");
    }

    public function expediente(){
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/expediente_view");
    }

    public function retrocesoAPaso17(){
        $form = $this->form();
        
        $idLote = $form->idLote;
        $idProceso = $form->idProceso;
        $proceso = $form->proceso;
        $procesoNuevo = $form->procesoNuevo;
        $comentario = $form->comentario;
        $banderaSuccess = true;

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $procesoNuevo,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 2
        );

        $this->db->trans_begin();

        $updateData = array(
            "comentario"         => $comentario,
            "proceso"            => $procesoNuevo,
            "voBoOrdenCompra"    => 0,
            "voBoAdeudoTerreno"  => 0,
            "fechaModificacion"  => date("Y-m-d H:i:s"),
            "tipoMovimiento"     => 2 
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);
        if(!$update){
            $banderaSuccess = false;
        }

        // paso 2: guardar registro del movimiento
        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if(!$addHistorial){
            $banderaSuccess = false;
        }

        if($banderaSuccess){
            $this->db->trans_commit();
            $this->json([]);
        }
        else{
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function creditoDirectoReciboFirmaCliente()
    {
        $this->load->view("template/header");
        $this->load->view("casas/creditoDirecto/reciboFirmaCliente_view");
    }
    public function creditoDirectoEnvioContrato()
    {
        $this->load->view("template/header");
        $this->load->view("casas/creditoDirecto/envioContrato_view");
    }
    public function creditoDirectoContratoListo()
    {
        $this->load->view("template/header");
        $this->load->view("casas/creditoDirecto/contratoListo_view");
    }

    public function creditoDirectoFirmaAcusteCliente()
    {
        $this->load->view("template/header");
        $this->load->view("casas/creditoDirecto/firmaAcusteCliente_view");
    }
    public function creditoDirectoAcusteEntregado()
    {
        $this->load->view("template/header");
        $this->load->view("casas/creditoDirecto/acusteEntregado_view");
    }
    public function acusteEntregadoFinalizar()
    {
        $form = $this->form();
        $idLote = $form->idLote;
        $idProceso = $form->idProceso;
        $proceso = $form->proceso;
        $finalizado = $form->finalizado;
        $banderaSuccess = true;
        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $finalizado,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => "Se ha finalizado el proceso del lote",
            "esquemaCreditoProceso" => 2
        );
        $this->db->trans_begin();
        $updateData = array(
            "finalizado"  => $finalizado,
            "fechaAvance" => date("Y-m-d H:i:s"),
        );
        
        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idLote", $idLote);
        if (!$update) {
            $banderaSuccess = false;
        }
        // paso 2: guardar registro del movimiento
        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if (!$addHistorial) {
            $banderaSuccess = false;
        }
        if ($banderaSuccess) {
            $this->db->trans_commit();

            $this->json([]);
        }
    }

    public function removerFlagContrato(){
        $idLote = $this->input->post("idLote");
        $idProceso = $this->input->post("idProceso");

        $updateData = array(
            "voBoContrato" => 0
        );
        
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);

        if($update){
            $this->json([]);
        }
        else{
            http_response_code(400);
            $this->json([]);
        }
    }

    public function returnFlagsPaso17(){
        $idLote = $this->input->post("idLote");
        $idProceso = $this->input->post("idProceso");

        $updateData = array(
            "voBoOrdenCompra"   => 0,
            "voBoAdeudoTerreno" => 0,
            "adeudo"            => 0,
            "fechaAvance"       => date("Y-m-d H:i:s"),
        );
        
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);

        if($update){
            $this->json([]);
        }
        else{
            http_response_code(400);
            $this->json([]);
        }
    }

    public function getReporteProcesoCredito()
    {
        $opcion = $this->input->get('opcion');

        $proceso = "16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27";

        $finalizado = "0, 1";

        if($opcion != -1 && $opcion != -2 && isset($opcion)){
            $proceso = $opcion;
            $finalizado = "0";
        }

        if($opcion == -2){
            $finalizado = "1";
        }

        $lotes = $this->CasasModel->getReporteProcesoCredito($proceso, $finalizado);

        $this->json($lotes);
    }

    public function getHistorial($idProceso, $tipoEsquema)
    {
        echo json_encode($this->CasasModel->getHistorialCreditoActual($idProceso, $tipoEsquema));
    }

    public function options_procesos_directo()
    {
        $asesores = $this->CasasModel->getProcesosOptionsDirecto();

        $this->json($asesores);
    }

    public function reporte_casas_venta(){
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/reporte_casas_venta_view');
    }

    public function upload_documento_new()
    {
        $id_proceso = $this->form('id_proceso');
        $name_documento = $this->form('name_documento');
        $tipo = $this->form('tipo');

        if (!isset($id_proceso) || !isset($name_documento)) {
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->CasasModel->getProceso($id_proceso);

        $file = $this->file('file_uploaded');

        if (!$file) {
            http_response_code(400);
        }

        if ($file) {
            $filename = $this->generateFileName($name_documento, $proceso->nombreLote, $id_proceso, $file->name);

            $uploaded = $this->upload($file->tmp_name, $filename);

            if ($uploaded) {

                $insertData = array(
                    "idProcesoCasas"  => $id_proceso,
                    "documento" => $name_documento,
                    "archivo" => $filename,
                    "tipo" => $tipo,
                    "fechaCreacion" => date("Y-m-d H:i:s"),
                    "creadoPor" => $this->session->userdata('id_usuario'),
                    "fechaModificacion" => date("Y-m-d H:i:s"),
                    "idModificacion" => $this->session->userdata('id_usuario'),
                );
                
                $add = $this->General_model->addRecord('documentos_proceso_casas', $insertData);

                if ($add) {
                    $motivo = "Se subio archivo: $name_documento";
                    $this->CasasModel->addHistorial($id_proceso, $proceso->proceso, $proceso->proceso, $motivo, 1); // se añade el numero de esquema 1 -proceso banco

                    $this->json([]);
                }
            }
        }

        http_response_code(404);
    }

    public function addNotaria()
    {
        $nombre = $this->form('nombre');

        if (!isset($nombre)) {
            http_response_code(400);
            $this->json([]);
        }

        $ntLast = $this->CasasModel->getLastNotarias();

        $newIdOpcion = $ntLast->id_opcion + 1;

        $insertData = array(
            "id_opcion"  => $newIdOpcion,
            "id_catalogo"  => 129,
            "nombre" => $nombre,
            "estatus" => 1,
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "creado_por" => $this->session->userdata('id_usuario')
        );

        $add = $this->General_model->addRecord('opcs_x_cats', $insertData);

        if (!$add){
            http_response_code(400);
        } 
            
    }

    public function estatusNotaria()
    {
        $id_opcion = $this->form('id_opcion');
        $estatus = $this->form('estatus');

        if (!isset($id_opcion) || !isset($estatus)) {
            http_response_code(400);
            $this->json([]);
        }

        $estatus = $estatus == 0 ? 1 : 0;

        $update = $this->CasasModel->updateNotaria($id_opcion, $estatus);

        if (!$update) {
             http_response_code(400);
        }
            
    }

    public function assignNotaria(){
        $idProcesoCasas = $this->form('idProcesoCasas');
        $notaria = $this->form('notaria');

        if (!isset($idProcesoCasas) || !isset($notaria)) {
            http_response_code(400);
            $this->json([]);
        }

        $updateData = array(
            "notaria" => $notaria,
            "modificadoPor" => $this->session->userdata('id_usuario'),
        );

        $update = $this->General_model->updateRecord("proceso_casas", $updateData, "idProcesoCasas", $idProcesoCasas);

        if (!$update) {
             http_response_code(400);
        }
    }

    public function getNotarias()
    {
        $nt = $this->CasasModel->getNotarias();

        $this->json($nt);
    }

    public function ordenCompraFirma(){
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/orden_compra_view');
    }

    public function getLotesProcesoBanco(){
        $data = $this->input->get();
        $proceso = $data["proceso"];

        $tipoDocumento = isset($data["tipoDocumento"]) ? $data["tipoDocumento"] : 0;
        
        if(!isset($proceso)){
            $response["result"] = false;
            $reponse["message"] = "Error al obtener los datos";
        }

        $getLotes = $this->CasasModel->getLotesProcesoBanco($proceso, $tipoDocumento)->result();

        $this->json($getLotes);
    }

    public function uploadDocumentoCreditoBanco()
    {
        $idProceso = $this->form('idProcesoCasas');
        $proceso = $this->form('proceso');
        $nombre_lote = $this->form('nombre_lote');
        $tipoDocumento = $this->form('tipoDocumento') ? $this->form('tipoDocumento') : 0;
        $id_documento = $this->form('id_documento');
        $file = $this->file('file_uploaded');
        $id_usuario = $this->session->userdata('id_usuario');

        if (!isset($proceso) || !isset($nombre_lote) || !isset($id_documento)) {
            http_response_code(400);
            $this->json([]);
        }

        if (!$file) {
            http_response_code(400);
        } 
        else {
            // Consulta nombre tipo documento
            $documento = $this->CasasModel->getDocumentoCreditoBanco($id_documento);

            $name_documento = $documento->result()[0]->nombre;

            //  Nombre del archivo          
            $filename = $this->generateFileName($name_documento, $nombre_lote, $idProceso, $file->name);

            // Se sube archivo al buket
            $uploaded = $this->upload($file->tmp_name, $filename);

            if ($uploaded) {
                $created = $this->CasasModel->insertDocProcesoCreditoBanco($idProceso, $name_documento, $filename, $id_documento, $tipoDocumento, $id_usuario);

                if ($created) {
                    $motivo = "Se subio archivo: $name_documento";
                    $this->CasasModel->addHistorial($idProceso, $proceso, $proceso, $motivo, 1);

                    $this->json([]);
                }
            }
        }

        http_response_code(404);
    }

    public function creditoBancoAvance()
    {
        $form = $this->form();

        $idLote = $form->idLote;
        $idProceso = $form->idProcesoCasas;
        $proceso = $form->proceso;
        $procesoNuevo = $form->procesoNuevo;
        $comentario = $form->comentario;
        $tipoMovimiento = $form->tipoMovimiento;
        $banderaSuccess = true;

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $procesoNuevo,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1
        );

        $this->db->trans_begin();

        $updateData = array(
            "comentario"        => $comentario,
            "proceso"           => $procesoNuevo,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => ($proceso > $procesoNuevo) ? 1 : (($tipoMovimiento == 1 && $procesoNuevo >= $proceso) ? 2 : 0)
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas", $updateData, "idProcesoCasas", $idProceso);
        if (!$update) {
            $banderaSuccess = false;
        }

        if($procesoNuevo == 3 || $procesoNuevo == 2){

            $vobo = $this->CasasModel->getVobos($idProceso, 1);

            $updateData = array(
                "adm"  => 0,
                "ooam" => 0,
                "proyectos" => 0,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );
             
            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);

            if(!$update){
                http_response_code(400);
            }

             // paso 2: guardar registro del movimiento
            $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
            if (!$addHistorial) {
                $banderaSuccess = false;
            }

            $cotizacion = $this->CasasModel->insertCotizacion($idProceso);
            $tituloPropiedad = $this->CasasModel->inserDocumentsToProceso($idProceso, 17, 'Titulo de propiedad');

            if (!$cotizacion && !$tituloPropiedad) {
                $banderaSuccess = false;
            }

            if ($banderaSuccess) {
                $this->db->trans_commit();
                $this->json([]);
            } else {
                $this->db->trans_rollback();
                http_response_code(400);

                $this->json([]);
            }
        }

        // paso 2: guardar registro del movimiento
        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if (!$addHistorial) {
            $banderaSuccess = false;
        }

        $cotizacion = $this->CasasModel->insertCotizacion($idProceso);
        $tituloPropiedad = $this->CasasModel->inserDocumentsToProceso($idProceso, 17, 'Titulo de propiedad');

        if (!$cotizacion && !$tituloPropiedad) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function cierreCifras(){
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/cierre_cifras_view');
    }

    public function congelacionSaldos(){
        $data = [
            'idRol' => $this->idRol,
            'idUsuario' => $this->idUsuario,
        ];

        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/congelacion_saldos_view', $data);
    }

    public function setVoBoSaldos(){
        $form = $this->form();

        $saldoAdmon = $form->saldoAdmon;
        $saldoOOAM = $form->saldoOOAM;
        $saldoGPH = $form->saldoGPH;
        $saldoPV = $form->saldoPV;
        $comentario = $form->comentario;
        $idProcesoCasas = $form->idProcesoCasas;
        $cierreContraloria = $form->cierreContraloria;

        $tipoSaldo = $form->tipoSaldo;
        $columna = '';
        $avance = 0;
        $banderaSuccess = true;
        $depto = '';
        $idUsuario = $this->session->userdata("id_usuario");

        switch($tipoSaldo){
            case 1: // admon
                if($saldoOOAM == 1 && $saldoGPH == 1 && $saldoPV == 1 && $cierreContraloria == 1){
                    $avance = 1;                    
                }

                $columna = 'saldoAdmon';
                $depto = 'administración';
                break;
                
            case 2: // ooam
                if($saldoAdmon == 1 && $saldoGPH == 1 && $saldoPV == 1 && $cierreContraloria == 1){
                    $avance = 1;                    
                }

                $columna = 'saldoOOAM';
                $depto = 'administración OOAM';
                break;
            
            case 3: // gph
                if($saldoAdmon == 1 && $saldoOOAM == 1 && $saldoPV == 1 && $cierreContraloria == 1){
                    $avance = 1;                    
                }

                $columna = 'saldoGPH';
                $depto = 'GPH';
                break;

            case 4: // pv
                if($saldoAdmon == 1 && $saldoOOAM == 1 && $saldoGPH == 1 && $cierreContraloria == 1){
                    $avance = 1;                    
                }

                $columna = 'saldoPV';
                $depto = 'PV';
                break;
        }

        $this->db->trans_begin();
        $insertData = array(
            "idProcesoCasas"  => $idProcesoCasas,
            "procesoAnterior" => 6,
            "procesoNuevo"    => 6,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $idUsuario,
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1  
        );

        $update = $this->CasasModel->setVoBoSaldos($columna, $idProcesoCasas, $idUsuario);
        if(!$update) $banderaSuccess = false;

        $insertHistorial = $this->General_model->addRecord("historial_proceso_casas", $insertData);
        if(!$insertHistorial) $banderaSuccess = false;

        if($banderaSuccess){
            $this->db->trans_commit();
            $response["result"] = true;
            $response["message"] = "Se ha avanzado el proceso correctamente";
            $response["avance"] = $avance;
        }
        else{
            $this->db->trans_rollback();
            $response["result"] = false;
            $response["message"] = "Error al avanzar el proceso";
            $response["avance"] = 0;
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response));
    }

    public function congelacionSaldosOOAM(){
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/saldos_ooam_view');
    }

    public function avancePreCierre(){
        $form = $this->form();

        $saldoAdmon = $form->saldoAdmon;
        $saldoOOAM = $form->saldoOOAM;
        $saldoGPH = $form->saldoGPH;
        $saldoPV = $form->saldoPV;
        $idProcesoCasas = $form->idProcesoCasas;
        $comentario = $form->comentario;
        $avance = 0;
        $idUsuario = $this->session->userdata("id_usuario");
        
        $banderaSuccess = true;

        if($saldoAdmon == 1 && $saldoOOAM == 1 && $saldoGPH == 1 && $saldoPV == 1){
            $avance = 1;
        }

        $updateData = array(
            "cierreContraloria" => 1,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "modificadoPor"    => $idUsuario
        );

        $insertData = array(
            "idProcesoCasas"  => $idProcesoCasas,
            "procesoAnterior" => 6,
            "procesoNuevo"    => 6,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $idUsuario,
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1  
        );

        $this->db->trans_begin();

        $update = $this->General_model->updateRecord("proceso_casas", $updateData, "idProcesoCasas", $idProcesoCasas);
        if(!$update){
            $banderaSuccess = false;
        }

        $insert = $this->General_model->addRecord("historial_proceso_casas", $insertData);
        if(!$insert){
            $banderaSuccess = false;
        }

        if($banderaSuccess){
            $this->db->trans_commit();
            
            $response["result"] = true;  
            $response["messsage"] = "Se ha avanzado el proceso";
            $response["avance"] = $avance;
        }
        else{
            $this->db->trans_rollback();

            $response["result"] = false;  
            $response["messsage"] = "Error al avanzar el proceso";
            $response["avance"] = 0;
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    public function validacionProyecto(){
        $data = [
            'idRol' => $this->idRol,
            'idUsuario' => $this->idUsuario,
        ];

        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/validacion_proyecto_view', $data);
    }

    public function setCierreCifras(){
        $form = $this->form();

        $voboADM = $form->voboADM;
        $voboOOAM = $form->voboOOAM;
        $voboGPH = $form->voboGPH;
        $voboPV = $form->voboPV;
        $comentario = $form->comentario;
        $idProcesoCasas = $form->idProcesoCasas;

        $tipoSaldo = $form->tipo;
        $columna = '';
        $avance = 0;
        $banderaSuccess = true;
        $depto = '';
        $idUsuario = $this->session->userdata("id_usuario");

        switch($tipoSaldo){
            case 1: // admon
                if($voboOOAM == 1 && $voboGPH == 1 && $voboPV == 1){
                    $avance = 1;                    
                }

                $columna = 'voboADM';
                $depto = 'administración';
                break;
                
            case 2: // ooam
                if($voboADM == 1 && $voboGPH == 1 && $voboPV == 1){
                    $avance = 1;                    
                }

                $columna = 'voboOOAM';
                $depto = 'administración OOAM';
                break;
            
            case 3: // gph
                if($voboADM == 1 && $voboOOAM == 1 && $voboPV == 1){
                    $avance = 1;                    
                }

                $columna = 'voboGPH';
                $depto = 'GPH';
                break;

            case 4: // pv
                if($voboADM == 1 && $voboOOAM == 1 && $voboGPH == 1){
                    $avance = 1;                    
                }

                $columna = 'voboPV';
                $depto = 'PV';
                break;
        }

        $this->db->trans_begin();
        $insertData = array(
            "idProcesoCasas"  => $idProcesoCasas,
            "procesoAnterior" => 13,
            "procesoNuevo"    => 13,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $idUsuario,
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1  
        );

        $update = $this->CasasModel->setVoBoSaldos($columna, $idProcesoCasas, $idUsuario);
        if(!$update) $banderaSuccess = false;

        $insertHistorial = $this->General_model->addRecord("historial_proceso_casas", $insertData);
        if(!$insertHistorial) $banderaSuccess = false;

        if($banderaSuccess){
            $this->db->trans_commit();
            $response["result"] = true;
            $response["message"] = "Se avanzado el proceso";
            $response["avance"] = $avance;
        }
        else{
            $this->db->trans_rollback();
            $response["result"] = false;
            $response["message"] = "Erro al avanzar el proceso";
            $response["avance"] = 0;
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response));
    }

    public function elaborarContrato(){
        $data = [
            'idRol' => $this->idRol,
            'idUsuario' => $this->idUsuario,
        ];

        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/elaborar_contrato_view', $data);
    }

    public function setAvanceContratos(){
        $form = $this->form();

        $contratoTitulacion = $form->contratoTitulacion;
        $contratoOOAM = $form->contratoOOAM;
        $contratoPV = $form->contratoPV;
        $comentario = $form->comentario;
        $idProcesoCasas = $form->idProcesoCasas;

        $tipo = $form->tipo;
        $columna = '';
        $avance = 0;
        $banderaSuccess = true;
        $depto = '';
        $idUsuario = $this->session->userdata("id_usuario");

        switch($tipo){
            case 1: // titulacion
                if($contratoOOAM == 1 && $contratoPV == 1){
                    $avance = 1;                    
                }

                $columna = 'contratoTitulacion';
                $depto = 'titulación';
                break;
                
            case 2: // ooam
                if($contratoTitulacion == 1 && $contratoPV == 1){
                    $avance = 1;                    
                }

                $columna = 'contratoOOAM';
                $depto = 'OOAM';
                break;

            case 3: // postventa
                if($contratoTitulacion == 1 && $contratoOOAM == 1){
                    $avance = 1;                    
                }

                $columna = 'contratoPV';
                $depto = 'Postventa';
                break;
        }

        $this->db->trans_begin();
        $insertData = array(
            "idProcesoCasas"  => $idProcesoCasas,
            "procesoAnterior" => 14,
            "procesoNuevo"    => 14,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $idUsuario,
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1  
        );

        $update = $this->CasasModel->setVoBoSaldos($columna, $idProcesoCasas, $idUsuario);
        if(!$update) $banderaSuccess = false;

        $insertHistorial = $this->General_model->addRecord("historial_proceso_casas", $insertData);
        if(!$insertHistorial) $banderaSuccess = false;

        if($banderaSuccess){
            $this->db->trans_commit();
            $response["result"] = true;
            $response["message"] = "Se avanzado el proceso";
            $response["avance"] = $avance;
        }
        else{
            $this->db->trans_rollback();
            $response["result"] = false;
            $response["message"] = "Erro al avanzar el proceso";
            $response["avance"] = 0;
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response));
    }

    public function ingresoExpediente(){
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/ingreso_expediente_view');
    }

    public function confirmarContrato(){
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/confirmar_contrato_view');
    }

    public function recepcionAcuse(){
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/recepcion_acuse_view');
    }

    public function creditoBancoFinalizar()
    {
        $form = $this->form();

        $idLote = $form->idLote;
        $idProceso = $form->idProcesoCasas;
        $proceso = $form->proceso;
        $procesoNuevo = $form->procesoNuevo;
        $comentario = $form->comentario;
        $tipoMovimiento = $form->tipoMovimiento;
        $banderaSuccess = true;

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $procesoNuevo,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1
        );

        $this->db->trans_begin();

        $updateData = array(
            "comentario"        => $comentario,
            "proceso"           => $procesoNuevo,
            "finalizado"        => 1,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => ($proceso > $procesoNuevo) ? 1 : (($tipoMovimiento == 1 && $procesoNuevo >= $proceso) ? 2 : 0)
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas", $updateData, "idProcesoCasas", $idProceso);
        if (!$update) {
            $banderaSuccess = false;
        }

        // paso 2: guardar registro del movimiento
        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if (!$addHistorial) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function vobo_cierre_cifras(){
        $data = [
            'idRol' => $this->idRol,
            'idUsuario' => $this->idUsuario,
        ];

        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/vobo_cierre_cifras', $data);
    }

    public function documentacionProveedor($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        if(is_null($lote)){
            $this->load->view('template/header');
		    $this->load->view('template/home');
		    $this->load->view('template/footer');
        }
        else{
            $data = [
                'lote' => $lote,
            ];
    
            $this->load->view('template/header');
            $this->load->view("casas/creditoBanco/documentacion_proveedor", $data);
        }
    }

    public function getDocumentosProveedor($proceso)
    {
        $lotes = $this->CasasModel->getDocumentosProveedor($proceso);

        $this->json($lotes);
    }

    public function countDocumentos()
    {
        $data = $this->input->get();
        $documentos = $data["documentos"];

        $lotes = $this->CasasModel->countDocumentos($documentos);

        $this->json($lotes);
    }

    public function documentacionCliente($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        if(is_null($lote)){
            $this->load->view('template/header');
		    $this->load->view('template/home');
		    $this->load->view('template/footer');
        }
        else{
            $data = [
                'lote' => $lote,
            ];

            $this->load->view('template/header');
            $this->load->view("casas/creditoBanco/documentacion_cliente", $data);
        }
    }

    public function getDocumentosCliente($proceso)
    {
        $lotes = $this->CasasModel->getListaDocumentosCliente($proceso);

        $this->json($lotes);
    }

    public function rechazoPaso15(){
        $form = $this->form();

        $idLote = $form->idLote;
        $idProcesoCasas = $form->idProcesoCasas;
        $banderaSuccess = true;

        $this->db->trans_begin();

        $updateData = array(
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "contratoTitulacion" => 0,
            "contratoOOAM" => 0,
            "contratoPV" => 0
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas", $updateData, "idProcesoCasas", $idProcesoCasas);
        if (!$update) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $response["result"] = true;         
        } 
        else {
            $this->db->trans_rollback();
            $response["result"] = false;
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso14(){
        $form = $this->form();

        $idLote = $form->idLote;
        $idProcesoCasas = $form->idProcesoCasas;
        $banderaSuccess = true;

        $this->db->trans_begin();

        $updateData = array(
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "voboADM" => 0,
            "voboOOAM" => 0,
            "voboGPH" => 0,
            "voboPV" => 0
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas", $updateData, "idProcesoCasas", $idProcesoCasas);
        if (!$update) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $response["result"] = true;         
        } 
        else {
            $this->db->trans_rollback();
            $response["result"] = false;
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso7(){
        $form = $this->form();

        $idLote = $form->idLote;
        $idProcesoCasas = $form->idProcesoCasas;
        $banderaSuccess = true;

        $this->db->trans_begin();

        $updateData = array(
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "saldoAdmon" => 0,
            "saldoGPH" => 0,
            "saldoPV" => 0,
            "saldoOOAM" => 0,
            "cierreContraloria" => 0
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas", $updateData, "idProcesoCasas", $idProcesoCasas);
        if (!$update) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $response["result"] = true;         
        } 
        else {
            $this->db->trans_rollback();
            $response["result"] = false;
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso6(){
        $form = $this->form();

        $idLote = $form->idLote;
        $idProcesoCasas = $form->idProcesoCasas;
        $comentario = $form->comentario;
        $banderaSuccess = true;

        $this->db->trans_begin();

        $updateData = array(
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "cierreContraloria" => 0
        );
        
        $dataHistorial = array(
            "idProcesoCasas"  => $idProcesoCasas,
            "procesoAnterior" => 6,
            "procesoNuevo"    => 5,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas", $updateData, "idProcesoCasas", $idProcesoCasas);
        if (!$update) {
            $banderaSuccess = false;
        }

        // paso 2: guardar registro del movimiento
        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if (!$addHistorial) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $response["result"] = true;         
        } 
        else {
            $this->db->trans_rollback();
            $response["result"] = false;
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    public function to_asignacion_varios()
    {
        $form = $this->form();

        $idLote = $this->form('idLote');
        $comentario = $this->form('comentario');
        $gerente = $this->form('gerente');
        $idUsuario = $this->session->userdata('id_usuario');
        $idLotes = json_decode($this->form('idLotes'));
        $esquemaCredito = $this->form('esquemaCredito'); // se agrega el tipo de crdito - 1: bancario - 2: directo
        $banderaSuccess = true;

        $dataHistorial = array();
        $dataUpdate = array();

        $this->db->trans_begin();

        if (!isset($idLote) || !isset($gerente) || !isset($esquemaCredito)) {
            $banderaSuccess = false;
        }

        foreach($idLotes as $id){
            foreach($id as $idValue){
                $dataUpdate[] = array(
                    "idLote" => $idValue,
                    "esquemaCreditoCasas" => $esquemaCredito
                );
            }
        }            

        if ($esquemaCredito == 1){ // se agrega un condicion para saber que esquema de credito se usara
            foreach($idLotes as $id){
                foreach($id as $idValue){  
                    $proceso = $this->CasasModel->addLoteToAsignacion($idValue, $gerente, $comentario, $idUsuario);
                
                    $dataHistorial[] = array(
                        "idProcesoCasas"  => $proceso->idProcesoCasas,
                        "procesoAnterior" => NULL,
                        "procesoNuevo"    => 0,
                        "creadoPor"    => $idUsuario,       
                        "descripcion"     => $proceso->comentario,
                        "esquemaCreditoProceso" => 1
                    );                    
                }                                        
            }
        }
        else if ($esquemaCredito == 2){
            foreach($idLotes as $id){
                foreach($id as $idValue){  
                    $proceso = $this->CasasModel->addLoteToAsignacionDirecto($idValue, $gerente, $comentario, $idUsuario);
                
                    $dataHistorial[] = array(
                        "idProcesoCasas"  => $proceso->idProceso,
                        "procesoAnterior" => NULL,
                        "procesoNuevo"    => 0,
                        "creadoPor"    => $idUsuario,       
                        "descripcion"     => $proceso->comentario,
                        "esquemaCreditoProceso" => 2
                    );
                }                
            }
        }

        // se hace el insert en el historial
        $insert = $this->General_model->insertBatch("historial_proceso_casas", $dataHistorial);
        if(!$insert){
            $banderaSuccess = false;
        }

        // se hace update del esquema de los lotes
        $update = $this->General_model->updateBatch('lotes', $dataUpdate, 'idLote');
        if(!$update){
            $banderaSuccess = false;
        }

        if($banderaSuccess){
            $this->db->trans_commit();
            $response["result"] = true;   
        }
        else{
            $this->db->trans_commit();
            $response["result"] = true;  
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    public function to_asignacion_asesor()
    {
        $form = $this->form();

        $asesor = $this->form('asesor');
        $idLotes = json_decode($this->form('idLotes'));
        $idUsuario = $this->session->userdata('id_usuario');        
        $banderaSuccess = true;

        // idLotes[0] -- es el idLote
        // idLotes[1] -- es el tipo de esquema 
        // idLotes[2] -- es el idProceso de su tabla

        $dataHistorial = array();
        $dataUpdateBanco = array();
        $dataUpdateDirecto = array();

        $this->db->trans_begin();
        
        $getAsesor = $this->CasasModel->getAsesor($asesor);

        if (!isset($idLotes) || !isset($asesor)) {
            $banderaSuccess = false;
        }

        foreach ($idLotes as $id) {
            $dataHistorial[] = array(
                "idProcesoCasas"  => 1,
                "procesoAnterior" => 0,
                "procesoNuevo"    => 0,
                "creadoPor"       => $idUsuario,
                "descripcion"     => "Se asigno el asesor " . $getAsesor->nombre . " con el ID: " . $getAsesor->idUsuario,
                "esquemaCreditoProceso" => $id[1]
            );

            if ($id[1] == 1) { // para guardar en distintos arreglos y saber si son de banco o directo
                $dataUpdateBanco[] = array(
                    "idProcesoCasas" => $id[2],
                    "idAsesor"       => $asesor,
                    "modificadoPor" => $idUsuario
                );
            } 
            else {
                $dataUpdateDirecto[] = array(
                    "idProceso" => $id[2],
                    "idAsesor"  => $asesor
                );
            }
        }
        
        // se hace insert en el historial
        $insert = $this->General_model->insertBatch("historial_proceso_casas", $dataHistorial);
        if(!$insert) $banderaSuccess = false;

        // se hace insert en la tabla de credito de banco si hay datos en el arreglo
        if(count($dataUpdateBanco) > 0){
            $update = $this->General_model->updateBatch("proceso_casas", $dataUpdateBanco, "idProcesoCasas");

            if(!$update) $banderaSuccess = false;
        }
        
        // se hace insert en la tabla de credito directo si hay datos en el arreglo
        if(count($dataUpdateDirecto) > 0){
            $update = $this->General_model->updateBatch("proceso_casas_directo", $dataUpdateDirecto, "idProceso");

            if(!$update) $banderaSuccess = false;
        }

        if($banderaSuccess){
            $this->db->trans_commit();
            $response["result"] = true;   
        }
        else{
            $this->db->trans_commit();
            $response["result"] = true;  
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    public function copiarDS($idLote){ // función para copiar el deposito de seriedad una vez que se asigna al tipo de credito
        // // paso 1: obtener el cliente del lote y el dato del deposito de seriedes
        // // $getClientes = $this->General_model->getClientes($idLote);

        // // paso 2: se hacen la copia de los datos del deposito seriedad en la nueva tabla
        // foreach($getClientes as $cliente){

        // }     

    }
}
