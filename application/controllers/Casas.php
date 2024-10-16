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
        $this->load->library('email');

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

    public function documentacionDirecto($proceso)
    {
        $lote = $this->CasasModel->getProcesoDirecto($proceso);
        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoDirecto/documentacion", $data);
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

    public function tipo_proveedor()
    {
        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/tipo_proveedor");
    }

    public function toda_documentacion($value='')
    {
        $this->load->view('template/header');
        $this->load->view("casas/toda_documentacion");
    }

    public function toda_documentacion_cliente($value = '' ) {
        $this->load->view('template/header');
        $this->load->view("casas/toda_documentacion_cliente");
    }

    public function documentos_proveedor($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoBanco/documentos_proveedor", $data);
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

    public function lotes_option()
    {
        $idCondominio = $this->input->get('condominio');
        $idRol = $this->idRol = $this->session->userdata('id_rol');
        $extraColumns = "";
        $extraSelect = "";
        $idUsuario = $this->idUsuario = $this->session->userdata('id_usuario');

        switch($idRol) {
            case '3': 
                $extraColumns = " AND (cl.id_gerente_c = $idUsuario)";
                break;
            case '6':
                $extraColumns = " AND (cl.id_gerente_c = $idUsuario)";
                break;
            case '7':
                $extraColumns = " AND (cl.id_asesor_c = $idUsuario)";
                break;
            default: 
                $extraColumns = " AND (cl.id_asesor_c != 0 AND cl.id_gerente_c != 0)";

        }

        if (!isset($idCondominio)) {
            $this->json([]);
        }

        $lotes = $this->CasasModel->getLotesOption($idCondominio, $extraColumns);

        $this->json($lotes);
    }

    public function lotes_option_directo() {
        $idCondominio = $this->input->get('condominio');

        if (!isset($idCondominio)) {
            $this->json([]);
        }

        $lotes = $this->CasasModel->getLotesOptionDirecto($idCondominio);

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
        $lotes = $this->CasasModel->getListaAsignacion()->result();

        $this->json($lotes);
    }

    public function lista_asignacion_esquema()
    {
        $lotes = $this->CasasModel->getListaAsignacionEsquema()->result();

        $this->json($lotes);
    }

    public function to_asignacion()
    {
        $idLote = $this->form('idLote');
        $idCliente = $this->form('idCliente');
        $gerente = $this->form('gerente');
        $idUsuario = $this->session->userdata('id_usuario');
        $banderaSuccess = true;
        if (!isset($idLote) || !isset($gerente)) {
            http_response_code(400);
            $this->json([]);
        }

        $dataUpdate = array(
            "id_gerente_c" => $gerente,
            "id_subdirector_c" => $idUsuario,
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "pre_proceso_casas" => 1
        );

        $this->db->trans_begin();

        $getGerente = $this->CasasModel->getGerente($gerente);
        $this->CasasModel->addHistorial(0, '0', 1, "Pre proceso | se asigna el gerente: " . $getGerente->nombre . " IDLOTE: $idLote", 0, $idCliente);
        $this->General_model->updateRecord('clientes', $dataUpdate, 'id_cliente', $idCliente);

        $update = $this->General_model->updateRecord("clientes", $dataUpdate, "id_cliente", $idCliente);
        $updateLotes = $this->General_model->updateRecord("lotes", array('idCliente' => $idCliente), 'idLote', $idLote);

        if (!$update || !$updateLotes) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();

            $response["result"] = true;
            $response["message"] = "Se ha avanzado el proceso correctamente";
        } else {
            $this->db->trans_rollback();

            $response["result"] = false;
            $response["message"] = "No se puede avanzar el proceso";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output($this->json([]));
    }
    public function asignar()
    {
        $idAsesor = $this->form('asesor');
        $idCliente = $this->form('idCliente');
        $idLote = $this->form('idLote');
        $banderaSuccess = true;

        if (!isset($idCliente)) {
            http_response_code(400);
        }

        $this->db->trans_begin();

        $updateCliente = array(
            "id_asesor_c"        => $idAsesor,
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "pre_proceso_casas" => 2,
            "plan_comision_c" => 101
        );

        $getAsesor = $this->CasasModel->getAsesor($idAsesor);

        $update = $this->General_model->updateRecord('clientes', $updateCliente, 'id_cliente', $idCliente);

        $this->CasasModel->addHistorial(0, 1, 2, 'Pre proceso | se asigna el asesor: ' . $getAsesor->nombre . " IDLOTE: $idLote ", 0 , $idCliente);

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
        $idCliente = $this->form('idCliente');
        $banderaSuccess = true;
        $idLote = $this->form('idLote');

        if (!isset($id) || !isset($asesor) || !isset($idLote) || !isset($proceso) || !isset($esquemaCreditoCasas) || !isset($esquemaCreditoCasas) || !isset($idProcesoCasas) || !isset($update) || !isset($idCliente)) {
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

            $updateCliente = array(
                "id_asesor_c"        => $asesor,
                "plan_comision_c" => 101,
                "fechaModificacion" => date("Y-m-d H:i:s"),
                "modificadoPor" => $this->session->userdata('id_usuario')
            );

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
                "esquemaCreditoProceso" => 2,
                "idCliente" => $idCliente
            );


            // se actualiza el registro de credito directo
            $update = $this->General_model->updateRecord('proceso_casas_directo', $updateData, 'idProceso', $idProcesoCasas);
            if (!$update) {
                $banderaSuccess = false;
            }

            $updateCliente = $this->General_model->updateRecord('clientes', $updateCliente, 'id_cliente', $idCliente);

            if (!$updateCliente) {
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

        $idCliente = $this->form('idCliente');
        $banderaSuccess = true;

        if (!isset($idCliente)) {
            http_response_code(400);
        }

        $this->db->trans_begin();

        $dataUpdate = array(
            "id_gerente_c" => 0
        );

        $update = $this->General_model->updateRecord("clientes", $dataUpdate, "id_cliente", $idCliente);
        //se rechaza a preproseso
        if (!$update) {
            $banderaSuccess = false;
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
        $idProceso = $this->form('idProceso');
        $idCliente = $this->form('idCliente');
        $comentario = $this->form('comentario');

        $this->db->trans_begin();

        if(!isset($idProceso) || !isset($idCliente)) {
            http_response_code(400);
        }
        $dataProceso = array(
            "comentario" => $comentario,
            "tipoMovimiento" => 4,

        );

        $updateProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);
        
        if($updateProceso) {
            $response["result"] = true;
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback();
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function back_to_asignacion_cartera()
    {
        $this->form();
        $idCliente = $this->form('idCliente');
        $idGerente = $this->form('idGerente');
        $idLote = $this->form('idLote');
        $banderaSuccess = true;

        if (!isset($idCliente)) {
            http_response_code(400);
        }

        $this->db->trans_begin();

        $updateCliente = array(
            "id_asesor_c" => 0,
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "pre_proceso_casas" => 1,
            "plan_comision_c" =>0
        );

        $getGerente = $this->CasasModel->getGerente($idGerente);
        $update = $this->General_model->updateRecord('clientes', $updateCliente, 'id_cliente', $idCliente);
        $this->CasasModel->addHistorial(0, 2, 1, "Pre proceso | se regresa a gerente $getGerente->nombre IDLOTE: $idLote ", 0, $idCliente);

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

    public function back_to_originacion_cartera()
    {
        $this->form();
        $idCliente = $this->form('idCliente');
        $idSubdirector = $this->form('idSubdirector');
        $idLote = $this->form('idLote');
        $banderaSuccess = true;

        if (!isset($idCliente)) {
            http_response_code(400);
        }

        $this->db->trans_begin();

        $updateCliente = array(
            "id_gerente_c" => 0,
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "pre_proceso_casas" => null,
            "plan_comision_c" => 0
        );

        $getSubdirector = $this->CasasModel->getGerente($idSubdirector);
        $update = $this->General_model->updateRecord('clientes', $updateCliente, 'id_cliente', $idCliente);
        $this->CasasModel->addHistorial(0, 1, '0', "Pre proceso | se regresa a subdirector: $getSubdirector->nombre IDLOTE: $idLote ", 0, $idCliente);

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
        $tipo_documento = $this->form('tipo_documento');
        $idCliente = $this->form('idCliente');

        if (!isset($id_proceso) || !isset($id_documento) || !isset($name_documento)) {
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->CasasModel->getProceso($id_proceso);

        $file = $this->file('file_uploaded');

        if (!$file) {
            http_response_code(400);
        }

        setlocale(LC_ALL, "es_MX");
        $dateNow = date("D-M-Y H:i:s");

        if ($tipo_documento == 2) {

            $data_mail = $this->CasasModel->getDataMail($id_proceso);

            $encabezados = [
                'idLote' => 'ID LOTE',
                'proyecto' => 'PROYECTO',
                'nombreCondominio'  => 'CONDOMINIO',
                'nombreLote'        => 'LOTE',
                'cliente'           => 'CLIENTE',
                'usuarioAsignado'   => 'USUARIO ASIGNADO',
            ];

            $info[0] = [
                'idLote' =>  $data_mail->idLote,
                'proyecto' =>  $data_mail->proyecto,
                'nombreCondominio' =>  $data_mail->condominio,
                'nombreLote' =>  $data_mail->nombreLote,
                'cliente' =>  $data_mail->cliente,
                'usuarioAsignado'   =>  $data_mail->nombreAsesor,
            ];

            $this->email
                ->initialize()
                ->from('Ciudad Maderas')
                ->to('coordinador1.desarrollo@ciudadmaderas.com')
                ->subject('Notificación de carga de orden de compra en proceso casas - ' . $dateNow)
                ->view($this->load->view('mail/casas/mailOrdenCompra', [
                    'encabezados' => $encabezados,
                    'contenido' => $info
                ], true));

            $this->email->send();
        }

        if ($file) {
            $filename = $this->generateFileName($name_documento, $proceso->nombreLote, $id_proceso, $file->name);

            $uploaded = $this->upload($file->tmp_name, $filename);

            if ($uploaded) {
                $updated = $this->CasasModel->updateDocumentRow($id_documento, $filename);

                if ($updated) {
                    $motivo = "Se subió archivo: $name_documento";
                    $this->CasasModel->addHistorial($id_proceso, $proceso->proceso, $proceso->proceso, $motivo, 1, $idCliente); // se añade el numero de esquema 1 -proceso banco

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
        $tipoMovimiento = $this->form('tipoMovimiento');
        $adm = $this->form('adm');
        $ooam = $this->form('ooam');
        $idLote = $this->form('idLote');
        $idCliente = $this->form('idCliente');

        $responseTitulacion = $this->CasasModel->checkVoboEscrituracion($idLote);

        if (!isset($id) || !isset($tipo)) {
            http_response_code(400);
            $this->json([]);
        }

        // 1 es avance y 2 rechazo
        $bandera = 1;

        $new_status = $this->CasasModel->getPasos($id, $bandera)->avance;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setTipoCredito($id, $tipo);

        // $vobo = $this->CasasModel->getVobos($id, 1);

        // if (!$vobo) {
        $insertVobo = $this->CasasModel->insertVobo($proceso->idProcesoCasas, 2);

        if (!$insertVobo) {
            http_response_code(404);
        }
        // }

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        if ($is_ok) {
            $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);
            
            //NO TIENE VOBO DE TITULACIÓN
            if(($responseTitulacion->revisionEscrituracion == 0 || $responseTitulacion->revisionEscrituracion == null) && $responseTitulacion->escrituraFinalizada != 1) {
                $documentos = $this->CasasModel->getDocumentos([11, 13, 14, 15, 27, 36]);
            }
            else {
                $documentos = $this->CasasModel->getDocumentos([13, 14, 15, 27, 36]);
            }
            
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
                $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, "Se avanzó el proceso al paso 2 | Comentario: ".$comentario, 1, $idCliente); // se agrega esquema 1 - credito de banco
            } else {
                http_response_code(404);
            }
        }

        $this->json([]);
    }

    public function lista_adeudos()
    {
        $data = $this->input->get();
        $rol = $this->idRol;

        $lotes = $this->CasasModel->getListaConcentradoAdeudos($rol);

        $this->json($lotes);
    }

    public function concentracion_adeudos()
    {
        $data = $this->input->get();
        $documentos = $data["documentos"];

        $lotes = $this->CasasModel->getConcentracionAdeudos($documentos);

        $this->json($lotes);
    }

    public function to_documentacion_cliente()
    {
        $id = $this->form('id');
        $comentario = $this->form('comentario');
        $idCliente = $this->form('idCliente');

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
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1, $idCliente);

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
        $idCliente = $this->form('idCliente');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 1;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario, 1, $idCliente);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function lista_documentos_cliente($proceso)
    {
        $documentos = [];

        switch ($this->idRol) {
            case '62':
                $documentos = $this->CasasModel->getListaDocumentosCliente($proceso, [13, 14, 15]);
                break;
            case '99':
                $documentos = $this->CasasModel->getListaDocumentosCliente($proceso, [36, 27]);
                break;
        }

        if ($this->idUsuario == 5107) {
            $documentos = $this->CasasModel->getListaDocumentosCliente($proceso, [11]);
        }

        $this->json($documentos);
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

    public function avancePaso2()
    {
        $this->form();

        $rol = $this->idRol;
        $idProceso = $this->form('id');
        $procesoActual = $this->form('proceso');
        $comentario = $this->form('comentario');
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        $documentos = $this->CasasModel->getDocumentos([16]);

        $is_ok = true;
        foreach ($documentos as $key => $documento) {
            $is_ok = $this->CasasModel->inserDocumentsToProceso($idProceso, $documento->tipo, $documento->nombre);

            if (!$is_ok) {
                break;
            }
        }

        switch ($rol) {
            case 99:
                $newVobos = [
                    "ooam"  => 1,
                    "modificadoPor" => $this->session->userdata('id_usuario'),
                    "fechaModificacion" => date("Y-m-d H:i:s"),
                ];
                break;
            case 11:
                $newVobos = [
                    "adm"  => 1,
                    "modificadoPor" => $this->session->userdata('id_usuario'),
                    "fechaModificacion" => date("Y-m-d H:i:s"),
                ];
                break;
            case 33:
                $newVobos = [
                    "adm"  => 1,
                    "modificadoPor" => $this->session->userdata('id_usuario'),
                    "fechaModificacion" => date("Y-m-d H:i:s"),
                ];
                break;
            default:
                $newVobos = [
                    "proyectos" => 1,
                    "modificadoPor" => $this->session->userdata('id_usuario'),
                    "fechaModificacion" => date("Y-m-d H:i:s"),
                ];
                break;
        }

        $vobo = $this->CasasModel->updateVobos($idProceso, 2, $newVobos);

        $addHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $procesoActual, "Se da visto bueno | Comentario: " . $comentario, 1, $idCliente);

        if ($vobo && $addHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));

        if ($vobo->adm == 1 && $vobo->ooam == 1 && $vobo->proyectos == 1) {

            // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
            $tipoAvance = 1;
            $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
            $nuevoEstado = $pasos->avance;
            $tipoMovimiento = $pasos->tipoMovimiento;

            // Datos para actualizar el proceso
            $dataProceso = array(
                "comentario"        => $comentario,
                "proceso"           => $nuevoEstado,
                "fechaProceso"      => date("Y-m-d H:i:s"),
                "fechaModificacion" => date("Y-m-d H:i:s"),
                "tipoMovimiento"    => $tipoMovimiento,
                "modificadoPor"     => $this->session->userdata('id_usuario'),
            );

            $documentos = $this->CasasModel->getDocumentos([2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 23, 38]);

            $vobo = $this->CasasModel->getVobos($idProceso, 4);

            $is_ok = true;
                foreach ($documentos as $key => $documento) {

                    $is_ok = $this->CasasModel->inserDocumentsToProceso($idProceso, $documento->tipo, $documento->nombre);

                    if (!$is_ok) {
                        break;
                    }
                }

            // Update proceso banco
            $updateProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

            // Insert nuevos vobos
            $insertVobo = $this->CasasModel->insertVobo($idProceso, 4);

            // Insert historial
            $addHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se avanza al paso 4 comentario: | Comentario: ' . $comentario, 1, $idCliente);

            // Verificar todas las operaciones
            if ($updateProceso && $insertVobo && $addHistorial) {
                $response["result"] = true;
                $this->db->trans_commit(); 
            } else {
                $this->db->trans_rollback(); 
                $response["result"] = false;
            }

            $this->output->set_output(json_encode($response));
        }
    }

    public function avancePaso4()
    {
        $idProceso = $this->form('idProcesoCasas');
        $procesoActual = $this->form('proceso');
        $comentario = $this->form('comentario');
        $idCasaFinal = $this->form('idCasaFinal');
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        $vobo = $this->CasasModel->getVobos($idProceso, 4);

        if ($vobo->proyectos == 0 && $vobo->comercializacion == 0) {

            if ($this->idRol == 62) {

                $dataVobo = array(
                    "proyectos"  => 1,
                    "comercializacion" => 0,
                    "contraloria" => 0,
                    "gph" => 0,
                    "pv" => 0,
                    "titulacion" => 0,
                    "modificadoPor" => $this->idUsuario,
                    "fechaModificacion" => date("Y-m-d H:i:s"),
                );

                $updateVobos = $this->General_model->updateRecord("vobos_proceso_casas", $dataVobo, "idVobo", $vobo->idVobo);
                $addHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $procesoActual, 'Se da visto bueno | Comentario: ' . $comentario, 1, $idCliente);

                // Verificar todas las operaciones
                if ($updateVobos && $addHistorial) {
                    $response["result"] = true;
                    $this->db->trans_commit(); 
                } else {
                    $this->db->trans_rollback(); 
                    $response["result"] = false;
                }

                $this->output->set_output(json_encode($response));

            } else {

                $dataVobo = array(
                    "comercializacion"  => 1,
                    "contraloria" => 0,
                    "gph" => 0,
                    "pv" => 0,
                    "titulacion" => 0,
                    "modificadoPor" => $this->idUsuario,
                    "fechaModificacion" => date("Y-m-d H:i:s"),
                );

                $updateVobos = $this->General_model->updateRecord("vobos_proceso_casas", $dataVobo, "idVobo", $vobo->idVobo);
                $addHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $procesoActual, 'Se da visto bueno | Comentario: ' . $comentario, 1, $idCliente);

                // Verificar todas las operaciones
                if ($updateVobos && $addHistorial) {
                    $response["result"] = true;
                    $this->db->trans_commit(); 
                } else {
                    $this->db->trans_rollback(); 
                    $response["result"] = false;
                }

                $this->output->set_output(json_encode($response));
            }

        } else if ($vobo->proyectos == 1 || $vobo->comercializacion == 1) {

            // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
            $tipoAvance = 1;
            $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
            $nuevoEstado = $pasos->avance;
            $tipoMovimiento = $pasos->tipoMovimiento;

            $dataVobo = array(
                "comercializacion"  => 1,
                "proyectos"  => 1,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );

            // Datos para actualizar el proceso
            $dataProceso = array(
                "comentario"        => $comentario,
                "proceso"           => $nuevoEstado,
                "cierreContraloria" => 0,
                "saldoAdmon"        => 0,
                "saldoOOAM"         => 0,
                "saldoGPH"          => 0,
                "saldoPV"           => 0,
                "fechaProceso"      => date("Y-m-d H:i:s"),
                "fechaModificacion" => date("Y-m-d H:i:s"),
                "tipoMovimiento"    => $tipoMovimiento,
                "modificadoPor"     => $this->session->userdata('id_usuario'),
            );

            $updateVobos = $this->General_model->updateRecord("vobos_proceso_casas", $dataVobo, "idVobo", $vobo->idVobo);

            $updateCliente = $this->General_model->updateRecord('clientes', array('idCasaFinal' => $idCasaFinal), 'id_cliente', $idCliente);

            $addHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $procesoActual, 'Se da visto bueno | Comentario: ' . $comentario, 1, $idCliente);
            
            // Update proceso banco
            $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

            // Insert historial
            $addHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se avanzó proceso | Comentario: ' . $comentario, 1, $idCliente);
    
            // Verificar todas las operaciones
            if ($actualizarProceso && $updateVobos && $addHistorial) {
                $response["result"] = true;
                $this->db->trans_commit(); 
            } else {
                $this->db->trans_rollback(); 
                $response["result"] = false;
            }

            $this->output->set_output(json_encode($response));
        }
    }

    public function lista_valida_comite()
    {
        $lotes = $this->CasasModel->getListaValidaComite();

        $this->json($lotes);
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
        $idCliente = $this->form('idCliente');

        if (!isset($id)) {
            http_response_code(400);
            $this->json([]);
        }

        $new_status = 5;

        $proceso = $this->CasasModel->getProceso($id);

        $cotizaciones = 3;
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
                $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, $idCliente);
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

    public function lista_eleccion_propuestas()
    {
        $lotes = $this->CasasModel->getListaEleccionPropuestas();

        $this->json($lotes);
    }

    public function lista_propuesta_firma()
    {
        $data = $this->input->get();
        $rol = $data["rol"];

        $lotes = $this->CasasModel->getListaPropuestaFirma($rol);

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
        $proceso = $this->CasasModel->getProceso($id);
        $comentario = $this->form('comentario');
        $idCliente = $this->form('idCliente');

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

        // 1 es avance y 2 rechazo
        $bandera = 1;

        $new_status = $this->CasasModel->getPasos($id, $bandera)->avance;

        $movimiento = 0;
        if ($proceso->tipoMovimiento == 1) {
            $movimiento = 2;
        }

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

        $addHistorial = $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1, $idCliente);

        if (!$addHistorial) {
            http_response_code(400);
        }

        if ($is_ok) {

            $vobo = $this->CasasModel->getVobos($id, 11);

            if (!$vobo) {
                $insertVobo = $this->CasasModel->insertVobo($id, 11);

                if (!$insertVobo) {
                    http_response_code(404);
                }
            }

            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, "Se avanzó el proceso a la carga de kit bancario | Comentario: ".$comentario, 1, $idCliente);

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
        $idCliente = $this->form('idCliente');

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
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, 1, $idCliente);

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
        $idCliente = $this->form('idCliente');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 2;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario, $idCliente);

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
        $idCliente = $this->form('idCLient');

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
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, $idCliente);

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
        $proceso = $this->CasasModel->getProceso($id);
        $idCliente = $this->form('idCliente');
        if (!isset($id)) {
            http_response_code(400);
        }

        $vobo = $this->CasasModel->getVobos($id, 11);

        if ($vobo->comercializacion == 0 && $vobo->contraloria == 0) {

            $updateData = array(
                "comercializacion"  => 1,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );

            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);
            $historialResponse = $this->CasasModel->addHistorial($id, 11, 11, "Se da visto bueno", 1, $idCliente);

            if (!$update || !$historialResponse) {
                http_response_code(400);
            }
        } else if ($vobo->comercializacion == 0 && $vobo->contraloria == 1) {

            $vobo = $this->CasasModel->getVobos($id, 11);

            $updateData = array(
                "comercializacion"  => 1,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );

            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);
            $historialResponse = $this->CasasModel->addHistorial($id, 11, 11, "Se da visto bueno", 1, $idCliente);
            if (!$update || !$historialResponse) {
                http_response_code(400);
            }

            $new_status = 13;

            //$proceso = $this->CasasModel->getProceso($id);

            $movimiento = 0;
            if ($proceso->tipoMovimiento == 1) {
                $movimiento = 2;
            }

            $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

            if ($is_ok) {

                $insertVobo = $this->CasasModel->insertVobo($id, 13);

                if (!$insertVobo) {
                    http_response_code(404);
                }

                $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, "Se avanzó al paso 13 | Comentario: ".$comentario, 1, $idCliente);

                $this->json([]);
            } else {
                http_response_code(404);
            }
        }
    }

    public function to_vobo_cifras_contraloria()
    {
        $this->form();
        $id = $this->form('id');
        $proceso = $this->CasasModel->getProceso($id);
        $comentario = $this->form('comentario');
        $idCliente = $this->form('idCliente');

        if (!isset($id)) {
            http_response_code(400);
        }

        $vobo = $this->CasasModel->getVobos($id, 11);

        if ($vobo->comercializacion == 0 && $vobo->contraloria == 0) {

            $updateData = array(
                "contraloria"  => 1,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );

            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);
            $historialResponse = $this->CasasModel->addHistorial($id, 12, 12, "Se da visto bueno", 1, $idCliente);

            if (!$update || !$historialResponse) {
                http_response_code(400);
            }
        } else if ($vobo->comercializacion == 1 && $vobo->contraloria == 0) {

            $vobo = $this->CasasModel->getVobos($id, 11);

            $updateData = array(
                "contraloria"  => 1,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );

            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);
            $historialResponse = $this->CasasModel->addHistorial($id, 12, 12, "Se da visto bueno", 1, $idCliente);

            if (!$update || !$historialResponse) {
                http_response_code(400);
            }

            // 1 es avance y 2 rechazo
            $bandera = 1;

            //$new_status = $this->CasasModel->getPasos($id, $bandera)->avance;

            $new_status = 13;

            $movimiento = 0;
            if ($proceso->tipoMovimiento == 1) {
                $movimiento = 2;
            }

            $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, $movimiento);

            if ($is_ok) {

                $insertVobo = $this->CasasModel->insertVobo($id, 13);

                if (!$insertVobo) {
                    http_response_code(404);
                }

                $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, "Se avanzó al paso 13", 1, $idCliente);

                $this->json([]);
            } else {
                http_response_code(404);
            }
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
        $idCliente = $this->form('idCliente');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 10;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        $is_ok = $this->CasasModel->resetVoBos($id);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario, $idCliente);

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
        $idCliente = $this->form('idCliente');

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
                    $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, $idCliente);
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
        $idCliente = $this->form('idCliente');

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
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, $idCliente);

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
        $idCliente = $this->form('idCliente');

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
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, $comentario, $idCliente);

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
        $idCliente = $this->form('idCliente');

        if (!isset($id)) {
            http_response_code(400);
        }

        $new_status = 14;

        $proceso = $this->CasasModel->getProceso($id);

        $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario, $idCliente);

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
        $idCliente = $this->form('idCliente');

        if (!isset($id)) {
            http_response_code(400);
        }

        $proceso = $this->CasasModel->getProceso($id, $comentario);

        $is_ok = $this->CasasModel->markProcesoFinalizado($id);

        if ($is_ok) {
            $this->CasasModel->addHistorial($id, $proceso->proceso, $proceso->proceso, 'Proceso finalizado | Comentario: ' . $comentario, $idCliente);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function ingresar_adeudo()
    {
        $form = $this->form();
        $idCliente = $this->form('idCliente');

        if (!isset($form->id) || !isset($form->adeudo) || !isset($form->cantidad) ||!isset( $form->idCliente)) {
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
                if ($adeudosValid->num_rows() > 0) {

                    $this->CasasModel->setProceso3($proceso->idProcesoCasas);

                    $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, 3, "Se modificó adeudo", 1, $form->idCliente);
                }else {
                    $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, "Se modificó adeudo", 1, $form->idCliente);
                }

                

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
        $idCliente = $this->form('idCliente');

        if (!$idProcesoCasas || !$fechaFirma1) {
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->CasasModel->getProceso($idProcesoCasas);

        $getProuesta = $this->CasasModel->getProuesta($idProcesoCasas);

        if ($getProuesta->num_rows() > 0) {

            $is_ok = $this->CasasModel->updatePropuesta($idProcesoCasas, $fechaFirma1, $fechaFirma2, $fechaFirma3);
        } else {

            $dataPropuesta = array(
                "idProcesoCasas"  => $idProcesoCasas,
                "fechaFirma1" => $fechaFirma1,
                "fechaFirma2"    => $fechaFirma2,
                "fechaFirma3" => $fechaFirma3,
                "fechaCreacion" => date("Y-m-d H:i:s"),
                "creadoPor"    => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
                "modificadoPor"    => $this->session->userdata('id_usuario'),
            );

            $is_ok = $this->General_model->addRecord("propuestas_proceso_casas", $dataPropuesta);
        }

        if ($is_ok) {
            $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, "Se actualizó propuesta del proceso: $idProcesoCasas", 1, $idCliente);
        } else {
            http_response_code(404);
        }

        $this->json([]);
    }

    public function set_propuesta()
    {
        $form = $this->form();
        $idCliente = $this->form('idCliente');

        if (!$form->idProcesoCasas || !$form->cotizacion || !$form->fecha || !$form->idPropuesta) {
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->CasasModel->getProceso($form->idProcesoCasas);

        $is_ok = $this->CasasModel->setPropuesta($proceso->idProcesoCasas, $form->idPropuesta, $form->fecha, $form->cotizacion);

        if ($is_ok) {
            $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, "Se seleccionó cotización: $form->cotizacion", 1, $idCliente);
        } else {
            http_response_code(404);
        }

        $this->json([]);
    }

    public function save_cotizacion()
    {
        $form = $this->form();
        $idCliente = $this->form('idCliente');

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
            $this->CasasModel->addHistorial($proceso->idProcesoCasas, $proceso->proceso, $proceso->proceso, "Se guardó cotización: $form->idCotizacion", 1, $idCliente);
        } else {
            http_response_code(404);
        }

        $this->json([]);
    }

    public function lista_reporte_casas()
    {
        $opcion = $this->input->get('opcion');
        $proceso = "0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ";
        $finalizado = "0, 1";
        $extraFields = "";
        $extraValidation = "";
        $idRol = $this->idRol;
        $idUsuario = $this->idUsuario;

        switch($this->idRol) {
            case '3' :
                $extraValidation = " AND (cli.id_gerente_c) = $idUsuario";
                break;
            case '7':
                $extraValidation = "AND (cli.id_asesor_c) = $idUsuario";
                break;
            default: 
                $extraValidation = "";
                break;
        }
        if ($opcion != -1 && $opcion != -2 && isset($opcion)) {
            $proceso = $opcion;
            $finalizado = "0";
            $extraFields = "AND (pc.proceso IN ($proceso))";
        }
        if ($opcion == -2) {
            $finalizado = "1";
            $extraFields = "AND (pc.proceso IN ($proceso))";
        }
        if($opcion == -3) {
            $finalizado = "0";
            $extraFields = "AND (pc.idProcesoCasas IS NULL)";

        }

        $lotes = $this->CasasModel->getListaReporteCasas($proceso, $finalizado, $extraFields, $extraValidation);

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
        $idCliente = $this->form('idCliente');

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $procesoNuevo,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 2,
            'idCliente' => $idCliente
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
                    $motivo = "Se subió archivo: $name_documento";
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
        $idCliente = $this->form('idCliente');

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $procesoNuevo,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "idMovimiento"    => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 2,
            "idCliente" => $idCliente
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
        $idCliente = $this->form('idCliente');

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $procesoNuevo,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 2,
            "idCliente" => $idCliente
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

        if (!isset($idProceso) || !isset($idLote) || !isset($proceso) || !isset($procesoNuevo) || !isset($comentario) || !isset($voBoOrdenCompra) || !isset($voBoAdeudoTerreno)) {
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
        if (!$update) {
            $banderaSuccess = false;
        }

        // insert en historial
        $add = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if (!$add) {
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

    public function avanceAdeudo()
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

        if (!isset($idProceso) || !isset($idLote) || !isset($proceso) || !isset($procesoNuevo) || !isset($comentario) || !isset($voBoOrdenCompra) || !isset($voBoAdeudoTerreno)) {
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
        if (!$update) {
            $banderaSuccess = false;
        }

        // insert en historial
        $add = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if (!$add) {
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

    public function expediente()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/expediente_view");
    }

    public function retrocesoAPaso17()
    {
        $form = $this->form();

        $idLote = $form->idLote;
        $idProceso = $form->idProceso;
        $proceso = $form->proceso;
        $procesoNuevo = $form->procesoNuevo;
        $comentario = $form->comentario;
        $banderaSuccess = true;
        $idCliente = $this->form('idCliente');

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $procesoNuevo,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 2,
            "idCliente" => $idCliente
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
        $idCliente = $this->form('idCliente');

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $finalizado,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => "Se ha finalizado el proceso del lote",
            "esquemaCreditoProceso" => 2,
            "idCliente" => $idCliente
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

    public function removerFlagContrato()
    {
        $idLote = $this->input->post("idLote");
        $idProceso = $this->input->post("idProceso");

        $updateData = array(
            "voBoContrato" => 0
        );

        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);

        if ($update) {
            $this->json([]);
        } else {
            http_response_code(400);
            $this->json([]);
        }
    }

    public function returnFlagsPaso17()
    {
        $idLote = $this->input->post("idLote");
        $idProceso = $this->input->post("idProceso");

        $updateData = array(
            "voBoOrdenCompra"   => 0,
            "voBoAdeudoTerreno" => 0,
            "adeudo"            => 0,
            "fechaAvance"       => date("Y-m-d H:i:s"),
        );

        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);

        if ($update) {
            $this->json([]);
        } else {
            http_response_code(400);
            $this->json([]);
        }
    }

    public function getReporteProcesoCredito()
    {
        $opcion = $this->input->get('opcion');

        $proceso = "16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27";

        $finalizado = "0, 1";

        if ($opcion != -1 && $opcion != -2 && isset($opcion)) {
            $proceso = $opcion;
            $finalizado = "0";
        }

        if ($opcion == -2) {
            $finalizado = "1";
        }

        $lotes = $this->CasasModel->getReporteProcesoCredito($proceso, $finalizado);

        $this->json($lotes);
    }

    public function getHistorial($idProceso, $tipoEsquema, $idLote = null)
    {
        echo json_encode($this->CasasModel->getHistorialCreditoActual($idProceso, $tipoEsquema, $idLote));
    }

    public function options_procesos_directo()
    {
        $asesores = $this->CasasModel->getProcesosOptionsDirecto();

        $this->json($asesores);
    }

    public function reporte_casas_venta()
    {
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/reporte_casas_venta_view');
    }

    public function upload_documento_new()
    {
        $id_proceso = $this->form('id_proceso');
        $name_documento = $this->form('name_documento');
        $tipo = $this->form('tipo');
        $idCliente = $this->form('idCliente');

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
                    "modificadoPor" => $this->session->userdata('id_usuario'),
                );

                $add = $this->General_model->addRecord('documentos_proceso_casas', $insertData);

                if ($add) {
                    $motivo = "Se subió archivo: $name_documento";
                    $this->CasasModel->addHistorial($id_proceso, $proceso->proceso, $proceso->proceso, $motivo, 1, $idCliente); // se añade el numero de esquema 1 -proceso banco

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

        if (!$add) {
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

    public function assignNotaria()
    {
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

        $update = $this->General_model->updateRecord("proceso_casas_banco", $updateData, "idProcesoCasas", $idProcesoCasas);

        if (!$update) {
            http_response_code(400);
        }
    }

    public function getNotarias()
    {
        $nt = $this->CasasModel->getNotarias();

        $this->json($nt);
    }

    public function ordenCompraFirma()
    {
        $data = [
            'idRol' => $this->idRol
        ];
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/orden_compra_view', $data);
    }

    public function getLotesProcesoBanco()
    {
        $data = $this->input->get();
        $proceso = $data["proceso"];

        $tipoDocumento = isset($data["tipoDocumento"]) ? $data["tipoDocumento"] : 0;
        $tipoSaldo = isset($data["tipoSaldo"]) ? $data["tipoSaldo"] : 0;
        $condicionExtra = ""; // solo se usa en paso 5 y 6 de proceso casa credito de banco

        if (!isset($proceso)) {
            $response["result"] = false;
            $reponse["message"] = "Error al obtener los datos";
        }
        if ($tipoSaldo != 0) {
            $condicionExtra = "AND " . $data["campo"] . " = 0";
        }

        $getLotes = $this->CasasModel->getLotesProcesoBanco($proceso, $tipoDocumento, $condicionExtra)->result();

        $this->json($getLotes);
    }

    public function lista_elaborar_contrato()
    {
        $tipo = $this->get('tipo');

        switch ($tipo) {
            case 1: //titulacion
                $vobo = 'titulacion';
                $documentos = '33, 34, 35';
                break;
            case 2: // OOAM
                $vobo = 'ooam';
                $documentos = '49';
                break;

            case 3: // postventa
                $vobo = 'pv';
                $documentos = '24';
                break;
        }

        $lotes = $this->CasasModel->getListaElaborarContrato($vobo, $documentos);

        $this->json($lotes);
    }

    public function getVoboCierreCifras()
    {
        $data = $this->input->get();
        $proceso = $data["proceso"];

        $tipoDocumento = isset($data["tipoDocumento"]) ? $data["tipoDocumento"] : 0;
        $tipoSaldo = isset($data["tipoSaldo"]) ? $data["tipoSaldo"] : 0;
        $condicionExtra = ""; // solo se usa en paso 5 y 6 de proceso casa credito de banco

        if (!isset($proceso)) {
            $response["result"] = false;
            $reponse["message"] = "Error al obtener los datos";
        }
        if ($tipoSaldo != 0) {
            $condicionExtra = "AND " . $data["campo"] . " = 0";
        }

        $column = '';

        if (in_array($this->idUsuario, [5107])) {
            $column = 'vb.adm != 1 AND';
        }
        if (in_array($this->idUsuario, [15838, 15891, 15892, 15893, 16197, 16198, 16199, 15840])) {
            $column = 'vb.ooam != 1 AND';
        }
        if (in_array($this->idUsuario, [15896, 16204, 15897, 16205, 15898, 16206, 4512, 15841])) {
            $column = 'vb.gph != 1 AND';
        }
        if (in_array($this->idUsuario, [2896, 12072, 12112, 15900, 16208])) {
            $column = 'vb.pv != 1 AND';
        }

        $getLotes = $this->CasasModel->getVoboCierreCifras($proceso, $tipoDocumento, $condicionExtra, $column)->result();

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
        $idCliente = $this->form('idCliente');

        if (!isset($proceso) || !isset($nombre_lote) || !isset($id_documento)) {
            http_response_code(400);
            $this->json([]);
        }

        if (!$file) {
            http_response_code(400);
        } else {
            // Consulta nombre tipo documento
            $documento = $this->CasasModel->getDocumentoCreditoBanco($id_documento);

            if ($documento) {
                $name_documento = $documento->nombre;

                //  Nombre del archivo          
                $filename = $this->generateFileName($name_documento, $nombre_lote, $idProceso, $file->name);

                // Se sube archivo al buket
                $uploaded = $this->upload($file->tmp_name, $filename);

                if ($uploaded) {
                    $created = $this->CasasModel->insertDocProcesoCreditoBanco($idProceso, $name_documento, $filename, $id_documento, $tipoDocumento, $id_usuario);

                    if ($created) {
                        $motivo = "Se subió archivo: $name_documento";
                        $this->CasasModel->addHistorial($idProceso, $proceso, $proceso, $motivo, 1, $idCliente);

                        $this->json([]);
                    }
                }
            }

            http_response_code(404);
            $this->json([]);
        }
    }

    public function creditoBancoAvance()
    {
        $form = $this->form();

        $idLote = $form->idLote;
        $idProceso = $form->idProcesoCasas;
        $proceso = $form->proceso;
        $comentario = $form->comentario;
        $tipoMovimiento = $form->tipoMovimiento;
        $idCasaFinal = $form->idCasaFinal ?? null;
        $idCliente = $form->idCliente;
        $banderaSuccess = true;
        // 1 es avance y 2 rechazo
        $bandera = 1;
        $new_status = $this->CasasModel->getPasos($idProceso, $bandera)->avance;

        if ($new_status == 12) {

            $vobo = $this->CasasModel->getVobos($idProceso, 4);

            $updateData = array(
                "proyectos"  => 0,
                "comercializacion" => 0,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );

            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);

            if (!$update) {
                http_response_code(400);
            }
        }

        if($new_status == 7){

            $addHistorial = $this->CasasModel->addHistorial($idProceso, $proceso, $new_status, "Se avanzó el proceso al paso 7 | Comentario: ".$comentario, 1, $idCliente);    
            if (!$addHistorial) {
                $banderaSuccess = false;
            }
        }

        if ($new_status == 8) {
            $insertVobo = $this->CasasModel->insertVobo($idProceso, 8);
            $response = $this->CasasModel->addHistorial($idProceso, $proceso, $new_status, "Se avanzó el proceso al paso 7 | Comentario: ". $comentario, 1, $idCliente);

            if (!$insertVobo || !$response) {
                http_response_code(404);
            }
        }

        if ($new_status == 4) {

            $vobo = $this->CasasModel->getVobos($idProceso, 8);

            $updateData = array(
                "titulacion"  => 0,
                "gph" => 0,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );

            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);

            if (!$update) {
                http_response_code(400);
            }
        }
        
        $this->db->trans_begin();

        $updateData = array(
            "comentario"        => $comentario,
            "proceso"           => $new_status,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => ($proceso > $new_status) ? 1 : (($tipoMovimiento == 1 && $new_status >= $proceso) ? 2 : 0)
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas_banco", $updateData, "idProcesoCasas", $idProceso);
        $updateClientes = $this->General_model->updateRecord("clientes", array("idCasaFinal" => $idCasaFinal), "id_cliente",  $idCliente);
        if (!$update && !$updateClientes) {
            $banderaSuccess = false;
        }

        if ($new_status == 3) { //para el rechazo al paso 3

            $vobo = $this->CasasModel->getVobos($idProceso, 4);

            $updateData = array(
                "comercializacion" => 0,
                "proyectos" => 0,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );

            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);

            if (!$update) {
                http_response_code(400);
            }

            $dataHistorial = array(

                "idProcesoCasas"  => $idProceso,
                "procesoAnterior" => $proceso,
                "procesoNuevo"    => $new_status,
                "fechaMovimiento" => date("Y-m-d H:i:s"),
                "idMovimiento"    => $this->session->userdata('id_usuario'),
                "creadoPor"       => $this->session->userdata('id_usuario'),
                "descripcion"     => $comentario,
                "esquemaCreditoProceso" => 1,
                "idCliente" => $idCliente
            );
    

            // paso 2: guardar registro del movimiento
            $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
            if (!$addHistorial) {
                $banderaSuccess = false;
            }

            for ($i = 1; $i <= 3; $i++) {
                $cotizacion = $this->CasasModel->insertCotizacion($idProceso);
            }
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

        if($new_status == 16){
            $addHistorial = $this->CasasModel->addHistorial($idProceso, $proceso, $new_status, "Se avanzó el proceso al paso 16 | Comentario: ".$comentario, 1, $idCliente);    
            if (!$addHistorial) {
                $banderaSuccess = false;
            }
        }


        if($new_status == 17){
            $addHistorial = $this->CasasModel->addHistorial($idProceso, $proceso, $new_status, "Se avanzó el proceso al paso 17 | Comentario: ".$comentario, 1, $idCliente);    
            if (!$addHistorial) {
                $banderaSuccess = false;
            }
        }

        if($new_status == 18){
            $addHistorial = $this->CasasModel->addHistorial($idProceso, $proceso, $new_status, "Se avanzó el proceso al paso 18 | Comentario: ".$comentario, 1, $idCliente);    
            if (!$addHistorial) {
                $banderaSuccess = false;
            }
        }

        if($new_status == 19){
            $addHistorial = $this->CasasModel->addHistorial($idProceso, $proceso, $new_status, "Se avanzó el proceso al paso 19 | Comentario: ".$comentario, 1, $idCliente);    
            if (!$addHistorial) {
                $banderaSuccess = false;
            }
        }
        

        if($new_status == 18){
            $addHistorial = $this->CasasModel->addHistorial($idProceso, $proceso, $new_status, "Se avanzó el proceso al paso 18 | Comentario: ".$comentario, 1, $idCliente);    
            if (!$addHistorial) {
                $banderaSuccess = false;
            }
        }

        if($new_status == 19){
            $addHistorial = $this->CasasModel->addHistorial($idProceso, $proceso, $new_status, "Se avanzó el proceso al paso 19 | Comentario: ".$comentario, 1, $idCliente);    
            if (!$addHistorial) {
                $banderaSuccess = false;
            }
        }
        

        for ($i = 1; $i <= 3; $i++) {
            $cotizacion = $this->CasasModel->insertCotizacion($idProceso);
        }

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

    public function cierreCifras()
    {
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/cierre_cifras_view');
    }

    public function congelacionSaldos()
    {
        $data = [
            'idRol' => $this->idRol,
            'idUsuario' => $this->idUsuario,
        ];

        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/congelacion_saldos_view', $data);
    }

    public function congelacionSaldosOOAM()
    {
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/saldos_ooam_view');
    }

    public function voboPaso5()
    {
        $form = $this->form();

        $saldoAdmon = $form->saldoAdmon;
        $saldoOOAM = $form->saldoOOAM;
        $saldoGPH = $form->saldoGPH;
        $saldoPV = $form->saldoPV;
        $idProcesoCasas = $form->idProcesoCasas;
        $comentario = $form->comentario;
        $avance = 0;
        $idUsuario = $this->session->userdata("id_usuario");
        $idCliente = $form->idCliente;

        $banderaSuccess = true;

        if ($saldoAdmon == 1 && $saldoOOAM == 1 && $saldoGPH == 1 && $saldoPV == 1) {
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
            "idMovimiento" => $idUsuario,
            "creadoPor"       => $idUsuario,
            "descripcion"     => "Se avanzó el proceso a validación de proyectos | Comentario: ".$comentario,
            "esquemaCreditoProceso" => 1,
            "idCliente" => $idCliente
        );

        $this->db->trans_begin();

        $update = $this->General_model->updateRecord("proceso_casas_banco", $updateData, "idProcesoCasas", $idProcesoCasas);
        if (!$update) {
            $banderaSuccess = false;
        }

        $insert = $this->General_model->addRecord("historial_proceso_casas", $insertData);
        if (!$insert) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();

            $response["result"] = true;
            $response["message"] = "Se ha avanzado el proceso correctamente";
            $response["avance"] = $avance;
        } else {
            $this->db->trans_rollback();

            $response["result"] = false;
            $response["message"] = "Error al avanzar el proceso";
            $response["avance"] = 0;
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    public function voboPaso6()
    {
        $form = $this->form();

        $saldoAdmon = $form->saldoAdmon;
        $saldoOOAM = $form->saldoOOAM;
        $saldoGPH = $form->saldoGPH;
        $saldoPV = $form->saldoPV;
        $comentario = $form->comentario;
        $idProceso = $form->idProcesoCasas;
        $procesoActual = $form->proceso;
        $cierreContraloria = $form->cierreContraloria;
        $tipoSaldo = $form->tipoSaldo;
        $columna = '';
        $avance = 0;
        $idUsuario = $this->session->userdata("id_usuario");
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        switch ($tipoSaldo) {
            case 1: // admon
                if ($saldoOOAM == 1 && $saldoGPH == 1 && $saldoPV == 1 && $cierreContraloria == 1) {
                    $avance = 1;
                }

                $columna = 'saldoAdmon';
                break;

            case 2: // ooam
                if ($saldoAdmon == 1 && $saldoGPH == 1 && $saldoPV == 1 && $cierreContraloria == 1) {
                    $avance = 1;
                }

                $columna = 'saldoOOAM';
                break;

            case 3: // gph
                if ($saldoAdmon == 1 && $saldoOOAM == 1 && $saldoPV == 1 && $cierreContraloria == 1) {
                    $avance = 1;
                }

                $columna = 'saldoGPH';
                break;

            case 4: // pv
                if ($saldoAdmon == 1 && $saldoOOAM == 1 && $saldoGPH == 1 && $cierreContraloria == 1) {
                    $avance = 1;
                }

                $columna = 'saldoPV';
                break;
        }

        $updateVobos = $this->CasasModel->setVoBoSaldos($columna, $idProceso, $idUsuario);

        // Insert historial
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $procesoActual, 'Visto bueno | Comentario: ' . $comentario, 1, $idCliente);

        // Verificar todas las operaciones
        if ($updateVobos && $agregarHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
            $response["message"] = "Se ha avanzado el proceso correctamente";
            $response["avance"] = $avance;
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
            $response["message"] = "Error al avanzar el proceso";
            $response["avance"] = 0;
        }

        $this->output->set_output(json_encode($response));
    }

    public function avancePaso5_6()
    {
        $form = $this->form();
        $idProceso = $form->idProcesoCasas;
        $procesoActual = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $form->idCliente;

        $this->db->trans_begin();

        // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
        $tipoAvance = 1;
        $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
        $nuevoEstado = $pasos->avance;
        $tipoMovimiento = $pasos->tipoMovimiento;

        // Datos para actualizar el proceso
        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => $nuevoEstado,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
        );   
            
        // Update proceso banco
        $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

        // Insert historial
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se avanzó el proceso al paso 7 | Comentario: ' . $comentario, 1, $form->idCliente);

        // Verificar todas las operaciones
        if ($actualizarProceso && $agregarHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));

    }

    public function avancePaso7()
    {
        $form = $this->form();
        $idProceso = $form->idProcesoCasas;
        $procesoActual = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
        $tipoAvance = 1;
        $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
        $nuevoEstado = $pasos->avance;
        $tipoMovimiento = $pasos->tipoMovimiento;

        // Datos para actualizar el proceso
        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => $nuevoEstado,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
        );   

        $vobo = $this->CasasModel->getVobos($idProceso, 8);

        if (!$vobo) {
        $insertVobo = $this->CasasModel->insertVobo($idProceso, 8);
            if (!$insertVobo) {
                $this->db->trans_rollback(); 
                $response["result"] = false;
            }
        }
           
        // Update proceso banco
        $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

        // Insert historial
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se avanzó el proceso al paso 8 | Comentario: ' . $comentario, 1, $idCliente);
        $tituloPropiedad = $this->CasasModel->inserDocumentsToProceso($idProceso, 17, 'Titulo de propiedad');

        for ($i = 1; $i <= 3; $i++) {
            $cotizacion = $this->CasasModel->insertCotizacion($idProceso);
        }

        // Verificar todas las operaciones
        if ($actualizarProceso && $agregarHistorial && $tituloPropiedad) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function avancePaso8()
    {
        $this->form();

        $idProceso = $this->form('id');
        $idRol = $this->form('idRol');
        $procesoActual = $this->form('proceso');
        $comentario = $this->form('comentario');
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        $tipoAvance = 1;
        $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
        $nuevoEstado = $pasos->avance;
        $tipoMovimiento = $pasos->tipoMovimiento;

        $vobo = $this->CasasModel->getVobos($idProceso, 8);
        $modificadoPor = $this->session->userdata('id_usuario');
        $fechaModificacion = date("Y-m-d H:i:s");

        $dataVobo = [
            $idRol = ($idRol == 101 || $idRol == 33) ? "gph" : "titulacion" => 1,
            "modificadoPor" => $modificadoPor,
            "fechaModificacion" => $fechaModificacion,
        ];

        $actualizarVobo = $this->General_model->updateRecord("vobos_proceso_casas", $dataVobo, "idVobo", $vobo->idVobo);
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $procesoActual,  'Se da visto bueno | Comentario: ' . $comentario, 1, $idCliente);

        if ($actualizarVobo && $agregarHistorial) {
            $response["result"] = true;
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback();
            $response["result"] = false;
        }

        $checkVobos = $this->CasasModel->getVobos($idProceso, 8);

        if ($checkVobos->gph == 1 && $checkVobos->titulacion == 1) {
            $documentos = $this->CasasModel->getDocumentos([18]);

            foreach ($documentos as $documento) {
                if (!$this->CasasModel->inserDocumentsToProceso($idProceso, $documento->tipo, $documento->nombre)) {
                    break;
                }
            }

            $dataProceso = [
                "comentario" => $comentario,
                "proceso" => $nuevoEstado,
                "fechaProceso" => $fechaModificacion,
                "fechaModificacion" => $fechaModificacion,
                "tipoMovimiento" => $tipoMovimiento,
                "modificadoPor" => $modificadoPor,
            ];

            $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

            $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado,  'Se avanza a paso 9 | Comentario: ' . $comentario, 1, $idCliente);

            if ($actualizarProceso && $agregarHistorial) {
                $response["result"] = true;
                $this->db->trans_commit();
            } else {
                $this->db->trans_rollback();
                $response["result"] = false;
            }
        }

        $this->output->set_output(json_encode($response));
    }

    public function avancePaso9()
    {
        $form = $this->form();
        $idProceso = $form->id;
        $procesoActual = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
        $tipoAvance = 1;
        $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
        $nuevoEstado = $pasos->avance;
        $tipoMovimiento = $pasos->tipoMovimiento;

        // Datos para actualizar el proceso
        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => $nuevoEstado,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
        );

        // Update proceso banco
        $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

        // Insert historial
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se avanzó proceso | Comentario: ' . $comentario, 1, $idCliente);

        // Verificar todas las operaciones
        if ($actualizarProceso && $agregarHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function capturaContratos()
    {
        $this->form();

        $idProceso = $this->form('id');
        $proceso = $this->form('proceso');
        $idCliente = $this->form('idCliente');
        $obra = $this->form('obra');
        $tesoreria = $this->form('tesoreria');
        $serviciosArquitectonicos = $this->form('serviciosArquitectonicos');
        $costoConstruccion = $this->form('costoConstruccion');

        $this->db->trans_begin();

        $updateData = array(
            "obra"  => $obra,
            "tesoreria" => $tesoreria,
            "serviciosArquitectonicos" => $serviciosArquitectonicos
        );

        $dataCliente = array(
            "costo_construccion" => $costoConstruccion
        );

        $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $updateData, "idProcesoCasas", $idProceso);

        $updateCliente = $this->General_model->updateRecord("clientes", $dataCliente, "id_cliente", $idCliente);
        
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $proceso, $proceso, 'Se ingresaron la captura de contratos', 1, $idCliente);

        // Verificar todas las operaciones
        if ($actualizarProceso && $updateCliente && $agregarHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function avancePaso10()
    {
        $this->form();

        $idProceso = $this->form('id');
        $proceso = $this->form('proceso');
        $comentario = $this->form('comentario');
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

         // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
         $banderaRechazo = 1;
         $pasos = $this->CasasModel->getPasos($idProceso, $banderaRechazo);
         $nuevoEstado = $pasos->avance;
         $tipoMovimiento = $pasos->tipoMovimiento;

        $updateData = array(
            "comentario"        => $comentario,
            "proceso"           => $nuevoEstado,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
        );

        $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $updateData, "idProcesoCasas", $idProceso);
        
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $proceso, $nuevoEstado, 'Se ingresaron la captura de contratos', 1, $idCliente);

        $vobo = $this->CasasModel->getVobos($idProceso, 11);

        if (!$vobo) {
            $insertVobo = $this->CasasModel->insertVobo($idProceso, 11);

            if (!$insertVobo) {
                $this->db->trans_rollback(); 
                $response["result"] = false;
            }
        }

        // Verificar todas las operaciones
        if ($actualizarProceso && $agregarHistorial && $insertVobo) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function validacionProyecto()
    {
        $data = [
            'idRol' => $this->idRol,
            'idUsuario' => $this->idUsuario,
        ];

        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/validacion_proyecto_view', $data);
    }

    public function elaborarContrato()
    {
        $data = [
            'idRol' => $this->idRol,
            'idUsuario' => $this->idUsuario,
        ];

        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/elaborar_contrato_view', $data);
    }

    public function setAvanceContratos()
    {
        $form = $this->form();
        $comentario = $form->comentario;
        $idProcesoCasas = $form->idProcesoCasas;
        $idCliente = $this->form('idCliente');



        $tipo = $form->tipo;
        // $columna = '';
        // $avance = 0;
        // $banderaSuccess = true;
        // $depto = '';
        // $idUsuario = $this->session->userdata("id_usuario");

        switch ($tipo) {
            case 1: // titulacion
                $new_vobo = [
                    "titulacion"  => 1,
                    "modificadoPor" => $this->idUsuario,
                    "fechaModificacion" => date("Y-m-d H:i:s"),
                ];
                break;

            case 2: // ooam
                $new_vobo = [
                    "ooam"  => 1,
                    "modificadoPor" => $this->idUsuario,
                    "fechaModificacion" => date("Y-m-d H:i:s"),
                ];
                break;

            case 3: // postventa
                $new_vobo = [
                    "pv"  => 1,
                    "modificadoPor" => $this->idUsuario,
                    "fechaModificacion" => date("Y-m-d H:i:s"),
                ];
                break;
        }

        // $this->db->trans_begin();

        // $update = $this->CasasModel->setVoBoSaldos($columna, $idProcesoCasas, $idUsuario);
        // if (!$update) $banderaSuccess = false;
        $vobo = $this->CasasModel->updateVobos($idProcesoCasas, 14, $new_vobo);

        $insertData = array(
            "idProcesoCasas"  => $idProcesoCasas,
            "procesoAnterior" => 14,
            "procesoNuevo"    => 14,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "idMovimiento"    => $this->idUsuario,
            "creadoPor"       => $this->idUsuario,
            "descripcion"     => "Se da visto bueno | Comentario:".$comentario,
            "esquemaCreditoProceso" => 1,
            "idCliente" => $idCliente
        );

        $this->General_model->addRecord("historial_proceso_casas", $insertData);

        if ($vobo->titulacion && $vobo->ooam && $vobo->pv) {
            $proceso = $this->CasasModel->getProceso($idProcesoCasas);

            $movimiento = 0;
            if ($proceso->tipoMovimiento == 1) {
                $movimiento = 2;
            }

            // 1 es avance y 2 rechazo
            $bandera = 1;

            $new_status = $this->CasasModel->getPasos($idProcesoCasas, $bandera)->avance;

            $is_ok = $this->CasasModel->setProcesoTo($idProcesoCasas, $new_status, $comentario, $movimiento);

            if ($is_ok) {

                $vobo = $this->CasasModel->getVobos($idProcesoCasas, 15);

                if (!$vobo) {
                    $insertVobo = $this->CasasModel->insertVobo($idProcesoCasas, 15);

                    if (!$insertVobo) {
                        http_response_code(404);
                    }
                }

                $this->CasasModel->addHistorial($idProcesoCasas, $proceso->proceso, $new_status, "Se avanzó el proceso al paso 15 | Comentario: ".$comentario, 1, $idCliente);

            } else {
                $response["result"] = false;
                $response["message"] = "Erro al avanzar el proceso";
                $response["avance"] = 0;

                $this->json($response);
            }
        }

        $response["result"] = true;
        $response["message"] = "Se dio visto bueno al avance";
        $response["avance"] = 1;

        $this->json($response);
    }

    public function ingresoExpediente()
    {
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/ingreso_expediente_view');
    }

    public function confirmarContrato()
    {
        $this->load->view('template/header');
        $this->load->view('casas/creditoBanco/confirmar_contrato_view');
    }

    public function recepcionAcuse()
    {
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
        $idCliente = $this->form('idCliente');

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $procesoNuevo,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "idMovimiento"       => $this->session->userdata('id_usuario'),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => "Se termina el proceso | Comentario: " . $comentario,
            "esquemaCreditoProceso" => 1,
            "idCliente" => $idCliente
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
        $update = $this->General_model->updateRecord("proceso_casas_banco", $updateData, "idProcesoCasas", $idProceso);
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

    public function vobo_cierre_cifras()
    {
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

        if (is_null($lote)) {
            $this->load->view('template/header');
            $this->load->view('template/home');
            $this->load->view('template/footer');
        } else {
            $data = [
                'lote' => $lote,
            ];

            $this->load->view('template/header');
            $this->load->view("casas/creditoBanco/documentacion_proveedor", $data);
        }
    }

    public function documentacionContratos($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        if (is_null($lote)) {
            $this->load->view('template/header');
            $this->load->view('template/home');
            $this->load->view('template/footer');
        } else {
            $data = [
                'lote' => $lote,
                'idRol' => $this->idRol,
            ];

            $this->load->view('template/header');
            $this->load->view("casas/creditoBanco/documentacion_contratos", $data);
        }
    }

    public function getDocumentosProveedor($proceso)
    {
        $lotes = $this->CasasModel->getDocumentosProveedor($proceso);

        $this->json($lotes);
    }

    public function getDocumentosContratos($proceso)
    {
        $tipo = $this->get('tipo');

        switch ($tipo) {
            case 1:
                $documentos = '33, 34, 35';
                break;

            case 2:
                $documentos = '23';
                break;

            case 3:
                $documentos = '24';
                break;
        }

        $lotes = $this->CasasModel->getDocumentosContratos($proceso, $documentos);

        $this->json($lotes);
    }

    public function countDocumentos()
    {
        $data = $this->input->get();
        $documentos = $data["documentos"];
        $proceso = $data["proceso"];
        $validacionExtra = "";

        if (isset($data["campo"])) {
            $campo = $data["campo"];

            $validacionExtra = "AND " . $campo . " = 0";
        }

        $lotes = $this->CasasModel->countDocumentos($documentos, $proceso, $validacionExtra);

        $this->json($lotes);
    }

    public function documentacionCliente($proceso)
    {
        $lote = $this->CasasModel->getProceso($proceso);

        if (is_null($lote)) {
            $this->load->view('template/header');
            $this->load->view('template/home');
            $this->load->view('template/footer');
        } else {
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

    public function getDocumentosClienteCompleto($proceso)
    {
        $lotes = $this->CasasModel->getListaDocumentosClienteCompleto($proceso);

        $this->json($lotes);
    }

    public function rechazoPaso2()
    {
        $this->form();
        $idProceso = $this->form('id');
        $procesoActual = $this->form('proceso');
        $comentario = $this->form('comentario');
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
        $tipoAvance = 2;
        $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
        $nuevoEstado = $pasos->avance;
        $tipoMovimiento = $pasos->tipoMovimiento;

        $vobo = $this->CasasModel->getVobos($idProceso, 2);

        $dataVobo = array(
            "adm"  => 0,
            "ooam" => 0,
            "proyectos" => 0,
            "modificadoPor" => $this->session->userdata('id_usuario'),
            "fechaModificacion" => date("Y-m-d H:i:s"),
        );

        // Datos para actualizar el proceso
        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => $nuevoEstado,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
        );

        // Update proceso banco
        $updateProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

        // Update vobos
        $actualizarVobo = $this->General_model->updateRecord("vobos_proceso_casas", $dataVobo, "idVobo", $vobo->idVobo);

        // Insert historial
        $addHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se rechazó proceso | Comentario: ' . $comentario, 1, $idCliente);

        // Verificar todas las operaciones
        if ($updateProceso && $actualizarVobo && $addHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso15()
    {
        $form = $this->form();
        $idProceso = $form->idProcesoCasas;
        $proceso = $form->proceso;
        $comentario = $form->comentario;
        $banderaSuccess = true;
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        // 1 es avance y 2 rechazo
        $bandera = 2;

        $new_status = $this->CasasModel->getPasos($idProceso, $bandera)->avance;

        $vobos = [
            "titulacion" => 0,
            'pv' => 0,
            'ooam' => 0,
            "modificadoPor" => $this->session->userdata('id_usuario'),
            "fechaModificacion" => date("Y-m-d H:i:s"),
        ];

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $new_status,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "idMovimiento"    => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1,
            "idCliente" => $idCliente
        );

        $is_ok = $this->CasasModel->setProcesoTo($idProceso, $new_status, $comentario, 1);

        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);

        $vobosUpdate = $this->CasasModel->updateVobos($idProceso, 14, $vobos);

        if ($is_ok && $vobosUpdate && $addHistorial) {
            $response["result"] = true;
            $this->db->trans_commit();
            
        }else{
            $this->db->trans_rollback();
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso14()
    {
        $form = $this->form();
        $idProceso = $form->idProcesoCasas;
        $proceso = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        // Consulta al vobo paso 14
        $vobo = $this->CasasModel->getVobos($idProceso, 14);

        // Consulta al vobo paso 8
        $vobo2 = $this->CasasModel->getVobos($idProceso, 8);

        // 1 es avance y 2 rechazo
        $bandera = 2;

        $new_status = $this->CasasModel->getPasos($idProceso, $bandera)->avance;

        //reset vobos paso 14
        $vobosData = array(
            "titulacion"  => 0,
            "ooam" => 0,
            "pv" => 0,
            "modificadoPor" => $this->session->userdata('id_usuario'),
            "fechaModificacion" => date("Y-m-d H:i:s"),
        );

        //reset vobos paso 8
        $vobosData2 = array(
            "titulacion"  => 0,
            "gph" => 0,
            "modificadoPor" => $this->session->userdata('id_usuario'),
            "fechaModificacion" => date("Y-m-d H:i:s"),
        );

        $vobosUpdate = $this->General_model->updateRecord("vobos_proceso_casas", $vobosData, "idVobo", $vobo->idVobo);

        $vobosUpdate2 = $this->General_model->updateRecord("vobos_proceso_casas", $vobosData2, "idVobo", $vobo2->idVobo);

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $new_status,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "idMovimiento"       => $this->session->userdata('id_usuario'),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1,
            "idCliente" => $idCliente
        );

        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);

        $is_ok = $this->CasasModel->setProcesoTo($idProceso, $new_status, $comentario, 1);

        if ($is_ok && $vobosUpdate && $vobosUpdate2 && $addHistorial) {
            $response["result"] = true;
            $this->db->trans_commit();
            
        }else{
            $this->db->trans_rollback();
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso4()
    {
        $form = $this->form();
        $idProceso = $form->idProcesoCasas;
        $procesoActual = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

         // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
         $tipoAvance = 2;
         $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
         $nuevoEstado = $pasos->avance;
         $tipoMovimiento = $pasos->tipoMovimiento;

        // Datos para actualizar el proceso
        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => $nuevoEstado,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
        );

        $dataVobo = [
            "proyectos"  => 0,
            "adm" => 0,
            "ooam" => 0,
            "modificadoPor" => $this->session->userdata('id_usuario'),
            "fechaModificacion" => date("Y-m-d H:i:s"),
        ];

        $dataVobo2 = [
            "proyectos"  => 0,
            "comercializacion" => 0,
            "modificadoPor" => $this->session->userdata('id_usuario'),
            "fechaModificacion" => date("Y-m-d H:i:s"),
        ];

        // Update proceso banco
        $updateProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

        $vobosUpdate = $this->CasasModel->updateVobos($idProceso, 2, $dataVobo);

        $vobosUpdate2 = $this->CasasModel->updateVobos($idProceso, 4, $dataVobo2);;

        // Insert historial
        $addHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se rechazó proceso | Comentario: ' . $comentario, 1, $idCliente);

        // Verificar todas las operaciones
        if ($updateProceso && $vobosUpdate && $vobosUpdate2 && $addHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso5()
    {
        $form = $this->form();
        $idProceso = $form->idProcesoCasas;
        $procesoActual = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
        $tipoAvance = 2;
        $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
        $nuevoEstado = $pasos->avance;
        $tipoMovimiento = $pasos->tipoMovimiento;

        // Datos para actualizar el proceso
        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => $nuevoEstado,
            "cierreContraloria" => 0,
            "saldoAdmon"        => 0,
            "saldoOOAM"         => 0,
            "saldoGPH"          => 0,
            "saldoPV"           => 0,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
        );

        // Actualizar los datos del visto bueno (VoBo)
        $vobo = $this->CasasModel->getVobos($idProceso, 4);
        $dataVobo = array(
            "proyectos"            => 0,
            "comercializacion"     => 0,
            "modificadoPor"        => $this->session->userdata('id_usuario'),
            "fechaModificacion"    => date("Y-m-d H:i:s"),
        );

        // Update proceso banco
        $updateProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

        // Update vobos
        $actualizarVobo = $this->General_model->updateRecord("vobos_proceso_casas", $dataVobo, "idVobo", $vobo->idVobo);

        // Insert historial
        $addHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se rechazó proceso | Comentario: ' . $comentario, 1, $idCliente);

        // Verificar todas las operaciones
        if ($updateProceso && $actualizarVobo && $addHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso6()
    {
        $form = $this->form();
        $idProceso = $form->idProcesoCasas;
        $procesoActual = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
        $tipoAvance = 2;
        $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
        $tipoMovimiento = $pasos->tipoMovimiento;

        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => 5,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
            "cierreContraloria" => 0,
            "saldoAdmon" => 0,
            "saldoOOAM"  => 0,
            "saldoGPH"   => 0,
            "saldoPV"    => 0
        );

        // Update proceso banco
        $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

        // Insert historial
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, 5, 'Se rechazó proceso | Comentario: ' . $comentario, 1, $idCliente);

        // Verificar todas las operaciones
        if ($actualizarProceso && $agregarHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso7()
    {
        $form = $this->form();
        $idProceso = $form->idProcesoCasas;
        $procesoActual = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
        $tipoAvance = 2;
        $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
        $nuevoEstado = $pasos->avance;
        $tipoMovimiento = $pasos->tipoMovimiento;

        // Datos para actualizar el proceso
        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => $nuevoEstado,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
        );

        // Actualizar los datos del visto bueno (VoBo)
        $vobo = $this->CasasModel->getVobos($idProceso, 4);
        $dataVobo = array(
            "proyectos"            => 0,
            "comercializacion"     => 0,
            "modificadoPor"        => $this->session->userdata('id_usuario'),
            "fechaModificacion"    => date("Y-m-d H:i:s"),
        );

        // Update proceso banco
        $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

        // Update vobos
        $actualizarVobo = $this->General_model->updateRecord("vobos_proceso_casas", $dataVobo, "idVobo", $vobo->idVobo);

        // Insert historial
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se rechazó proceso | Comentario: ' . $comentario, 1, $idCliente);

        // Verificar todas las operaciones
        if ($actualizarProceso && $actualizarVobo && $agregarHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso8()
    {
        $form = $this->form();
        $idProceso = $form->idProcesoCasas;
        $procesoActual = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
        $tipoAvance = 2;
        $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
        $nuevoEstado = $pasos->avance;
        $tipoMovimiento = $pasos->tipoMovimiento;

        // Datos para actualizar el proceso
        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => $nuevoEstado,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
        );

        // Actualizar los datos del visto bueno (VoBo)
        $vobo = $this->CasasModel->getVobos($idProceso, 4);
        $dataVobo = array(
            "proyectos"            => 0,
            "comercializacion"     => 0,
            "modificadoPor"        => $this->session->userdata('id_usuario'),
            "fechaModificacion"    => date("Y-m-d H:i:s"),
        );

        $vobo2 = $this->CasasModel->getVobos($idProceso, 8);
        $dataVobo2 = array(
           "titulacion" => 0,
            'gph' => 0,
            "modificadoPor"        => $this->session->userdata('id_usuario'),
            "fechaModificacion"    => date("Y-m-d H:i:s"),
        );

        // Update proceso banco
        $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

        // Update vobos
        $actualizarVobo = $this->General_model->updateRecord("vobos_proceso_casas", $dataVobo, "idVobo", $vobo->idVobo);

        $actualizarVobo2 = $this->General_model->updateRecord("vobos_proceso_casas", $dataVobo2, "idVobo", $vobo2->idVobo);

        // Insert historial
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se rechazó proceso | Comentario: ' . $comentario, 1, $idCliente);

        // Verificar todas las operaciones
        if ($actualizarProceso && $actualizarVobo && $actualizarVobo2 && $agregarHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso9()
    {
        $form = $this->form();
        $idProceso = $form->id;
        $procesoActual = $form->proceso;
        $comentario = $form->comentario;
        $this->db->trans_begin();
        $idCliente = $this->form('idCliente');

        // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
        $tipoAvance = 2;
        $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
        $nuevoEstado = $pasos->avance;
        $tipoMovimiento = $pasos->tipoMovimiento;

        // Datos para actualizar el proceso
        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => $nuevoEstado,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
        );

        // Actualizar los datos del visto bueno (VoBo)
        $vobo = $this->CasasModel->getVobos($idProceso, 8);
        $dataVobo = array(
            "gph"  => 0,
            "titulacion" => 0,
            "modificadoPor"        => $this->session->userdata('id_usuario'),
            "fechaModificacion"    => date("Y-m-d H:i:s"),
        );

        // Update proceso banco
        $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

        // Update vobos
        $actualizarVobo = $this->General_model->updateRecord("vobos_proceso_casas", $dataVobo, "idVobo", $vobo->idVobo);

        // Insert historial
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se rechazó proceso | Comentario: ' . $comentario, 1, $idCliente);

        // Verificar todas las operaciones
        if ($actualizarProceso && $actualizarVobo && $agregarHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));

    }

    public function rechazoPaso10()
    {
        $form = $this->form();
        $idProceso = $form->idProcesoCasas;
        $procesoActual = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        // Determinar el nuevo estado y tipo de movimiento del proceso (1 es avance, 2 es rechazo)
        $tipoAvance = 2;
        $pasos = $this->CasasModel->getPasos($idProceso, $tipoAvance);
        $nuevoEstado = $pasos->avance;
        $tipoMovimiento = $pasos->tipoMovimiento;

        // Datos para actualizar el proceso
        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => $nuevoEstado,
            "fechaProceso"      => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $tipoMovimiento,
            "modificadoPor"     => $this->session->userdata('id_usuario'),
        );

        // Actualizar los datos del visto bueno (VoBo)
        $vobo = $this->CasasModel->getVobos($idProceso, 4);
        $dataVobo = array(
            "proyectos"            => 0,
            "comercializacion"     => 0,
            "modificadoPor"        => $this->session->userdata('id_usuario'),
            "fechaModificacion"    => date("Y-m-d H:i:s"),
        );

        // Update proceso banco
        $actualizarProceso = $this->General_model->updateRecord("proceso_casas_banco", $dataProceso, "idProcesoCasas", $idProceso);

        // Update vobos
        $actualizarVobo = $this->General_model->updateRecord("vobos_proceso_casas", $dataVobo, "idVobo", $vobo->idVobo);

        // Insert historial
        $agregarHistorial = $this->CasasModel->addHistorial($idProceso, $procesoActual, $nuevoEstado, 'Se rechazó proceso | Comentario: ' . $comentario, 1, $idCliente);

        // Verificar todas las operaciones
        if ($actualizarProceso && $actualizarVobo && $agregarHistorial) {
            $response["result"] = true;
            $this->db->trans_commit(); 
        } else {
            $this->db->trans_rollback(); 
            $response["result"] = false;
        }

        $this->output->set_output(json_encode($response));
    }

    public function rechazoPaso11()
    {
        $this->form();

        $idProceso = $this->form('idProcesoCasas');
        $comentario = $this->form('comentario');
        $idCliente = $this->form('idCliente');

        // 1 es avance y 2 rechazo
        $bandera = 2;
        $new_status = $this->CasasModel->getPasos($idProceso, $bandera)->avance;
        $proceso = $this->CasasModel->getProceso($idProceso);
        $is_ok = $this->CasasModel->setProcesoTo($idProceso, $new_status, $comentario, 1);

        if (!$is_ok) {
            http_response_code(404);
        }

        $this->CasasModel->addHistorial($idProceso, $proceso->proceso, $new_status, 'Se regreso proceso | Comentario: ' . $comentario, 1, $idCliente);

        $this->json([]);
    }

    public function rechazoPaso12()
    {
        $form = $this->form();

        $idLote = $form->idLote;
        $idProceso = $form->idProcesoCasas;
        $proceso = $form->proceso;
        $comentario = $form->comentario;
        $tipoMovimiento = $form->tipoMovimiento;
        $banderaSuccess = true;
        $idCliente = $this->form('idCliente');

        $this->db->trans_begin();

        // 1 es avance y 2 rechazo
        $bandera = 2;

        $new_status = $this->CasasModel->getPasos($idProceso, $bandera)->avance;

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $new_status,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->session->userdata('id_usuario'),
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1,
            "idCliente" => $idCliente
        );

        // paso 1: hacer update del proceso
        $update = $this->CasasModel->rechazoPaso12($idProceso);
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

    public function RechazoPaso13()
    {
        $this->form();

        $idProceso = $this->form('id');
        $comentario = $this->form('comentario');
        $vobo = $this->CasasModel->getVobos($idProceso, 11);
        $voboPaso12 = $this->CasasModel->getVobos($idProceso, 11);
        $idCliente = $this->form('idCliente');

        $updateData = array(
            "adm"  => 0,
            "ooam" => 0,
            "gph" => 0,
            "pv" => 0,
            "comercializacion" => 1,
            "contraloria" => 0,
            "modificadoPor" => $this->session->userdata('id_usuario'),
            "fechaModificacion" => date("Y-m-d H:i:s"),
        );

        $updateDataPaso12 = array(
            "comercializacion" => 1,
            "contraloria" => 0,
            "modificadoPor" => $this->session->userdata('id_usuario'),
            "fechaModificacion" => date("Y-m-d H:i:s"),
        );

        $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);

        if (!$update) {
            http_response_code(400);
        }

        $updatePaso12 = $this->General_model->updateRecord("vobos_proceso_casas", $updateDataPaso12, "idVobo", $voboPaso12->idVobo);

        if (!$updatePaso12) {
            http_response_code(400);
        }

        // 1 es avance y 2 rechazo
        $bandera = 2;
        $new_status = $this->CasasModel->getPasos($idProceso, $bandera)->avance;
        $proceso = $this->CasasModel->getProceso($idProceso);
        $is_ok = $this->CasasModel->setProcesoTo($idProceso, $new_status, $comentario, 1);

        if ($is_ok) {
            $this->CasasModel->addHistorial($idProceso, $proceso->proceso, $new_status, $comentario, 1, $idCliente);

            $this->json([]);
        } else {
            http_response_code(404);
        }
    }

    public function to_asignacion_varios()
    {
        $form = $this->form();

        $idClientes = json_decode($this->form('idClientes'));
        $idLote = json_decode($this->form('idLotes'));
        $gerente = $this->form('gerente');
        $banderaSuccess = true;

        $dataUpdate = array();

        $this->db->trans_begin();

        if (!isset($idClientes) || !isset($gerente)) {
            $banderaSuccess = false;
        }

        foreach ($idClientes as $id) {
            foreach ($id as $idValue) {
                $dataUpdate[] = array(
                    "id_cliente" => $idValue,
                    "id_gerente_c" => $gerente,
                    "id_subdirector_c" => $this->session->userdata('id_usuario'),
                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                    "modificado_por" => $this->session->userdata('id_usuario'),
                    "pre_proceso_casas" => 1
                );
            }
        }

        $dataUpdateLotes = [];
        for ($i = 0; $i < count($idClientes); $i++) {
            $idCliente = $idClientes[$i][0];
            $idLoteIndividual = $idLote[$i][0];
            $dataUpdateLotes[] = array(
                "idLote" => $idLoteIndividual,
                "idCliente" => $idCliente,
            );
        }

        // se hace update del esquema de credito y gerente en clientes 
        $update = $this->General_model->updateBatch('clientes', $dataUpdate, 'id_cliente');
        $updateLotes = $this->General_model->updateBatch('lotes', $dataUpdateLotes, 'idLote');
        $getGerente = $this->CasasModel->getGerente($gerente);
        foreach ($idLote as $key=>$lote) {
            $this->CasasModel->addHistorial(0, '0', 1, "Pre proceso | se asigna el gerente: " . $getGerente->nombre . " IDLOTE: $lote[0]", 0, $idClientes[$key][0]);
        }

        if (!$update || !$updateLotes) {
            $banderaSuccess = false;
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $response["result"] = true;
        } else {
            $this->db->trans_commit();
            $response["result"] = true;
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    
    public function to_asignacion_asesor() {
        $form = $this->form();
        $asesor = $this->form('asesor');
        $idClientes = json_decode($this->form('idClientes'));
        $idLotes = json_decode($this->form('idLotes'));
        
        $idUsuario = $this->session->userdata('id_usuario');
        $banderaSuccess = true;

        if (!isset($idClientes) || !isset($asesor)) {
            http_response_code(400);
        }

        $dataUpdate = array();
        $getAsesor = $this->CasasModel->getAsesor($asesor);

        $this->db->trans_begin();

        foreach ($idClientes as $cliente) {
            foreach ($cliente as $id) {
                $dataUpdate[] = array(
                    "id_cliente" => $id,
                    "id_asesor_c" => $asesor,
                    "plan_comision_c" => 101,
                    "modificado_por" => $idUsuario,
                    "pre_proceso_casas" => 2
                );
            }
        }

        foreach($idLotes as $key=>$lote) {
            $this->CasasModel->addHistorial(0, 1, 2, 'Pre proceso | se asigna el asesor: ' . $getAsesor->nombre . " IDLOTE: " . $lote[0], 0, $idClientes[$key][0]);        
        }
        
        $update = $this->General_model->updateBatch("clientes", $dataUpdate, "id_cliente");

        if (!$update) $banderaSuccess = false;

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $response["result"] = true;
        } else {
            $this->db->trans_commit();
            $response["result"] = true;
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    public function back_to_originacion_varios()
    {
        $form = $this->form();
        $idClientes = json_decode($this->form('idClientes'));
        $idLotes = json_decode($this->form('idLotes'));
        $idSubdirectores = json_decode($this->form('idSubdirectores'));

        $idUsuario = $this->session->userdata('id_usuario');
        $banderaSuccess = true;

        if (!isset($idClientes) || !isset($idSubdirectores)) {
            http_response_code(400);
        }

        $dataUpdate = array();

        $this->db->trans_begin();

        foreach ($idClientes as $cliente) {
            foreach ($cliente as $id) {
                $dataUpdate[] = array(
                    "id_cliente" => $id,
                    "id_gerente_c" => 0,
                    "plan_comision_c" => 0,
                    "modificado_por" => $idUsuario,
                    "pre_proceso_casas" => 0
                );
            }
        }

        foreach($idLotes as $key=>$lote) {
            $subdirector = $this->CasasModel->getGerente($idSubdirectores[$key][0]);
            $this->CasasModel->addHistorial(0, 1, 0, 'Pre proceso | se regresa al subdirector: ' . $subdirector->nombre . " IDLOTE: " . $lote[0], 0, $idClientes[$key][0]);        
        }

        $update = $this->General_model->updateBatch("clientes", $dataUpdate, "id_cliente");

        if (!$update) $banderaSuccess = false;

        if ($banderaSuccess) {
            $this->db->trans_commit();
            $response["result"] = true;
        } else {
            $this->db->trans_commit();
            $response["result"] = true;
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    public function copiarDS($idLote)
    { // función para copiar el deposito de seriedad una vez que se asigna al tipo de credito
        // // paso 1: obtener el cliente del lote y el dato del deposito de seriedes
        // // $getClientes = $this->General_model->getClientes($idLote);

        // // paso 2: se hacen la copia de los datos del deposito seriedad en la nueva tabla
        // foreach($getClientes as $cliente){

        // }     

    }

    public function VoboCierreCifras()
    {
        $this->form();

        $id = $this->form('id');
        $comentario = $this->form('comentario');
        $proceso = $this->CasasModel->getProceso($id);
        $idCliente = $this->form('idCliente');

        if (!isset($id)) {
            http_response_code(400);    
        }

        $vobo = $this->CasasModel->getVobos($id, 13);

        if (in_array($this->idRol, [11]) || in_array($this->idUsuario, [5107])) {
            $updateData = array(
                "adm"  => 1,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );

            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);
            $responseHistorial = $this->CasasModel->addHistorial($id, $proceso->proceso, $proceso->proceso,"Se da visto bueno | Comentario: ".$comentario, 1, $idCliente);

            if (!$update || !$responseHistorial) {
                http_response_code(400);
            }
        }
        if (in_array($this->idUsuario, [15838, 15891, 15892, 15893, 16197, 16198, 16199, 15840])) {
            $updateData = array(
                "ooam"  => 1,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );

            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);
            $responseHistorial = $this->CasasModel->addHistorial($id, $proceso->proceso, $proceso->proceso,"Se da visto bueno | Comentario: ".$comentario, 1, $idCliente);

            if (!$update || !$responseHistorial) {
                http_response_code(400);
            }
        }
        if (in_array($this->idRol, [101, 33])) {
            $updateData = array(
                "gph"  => 1,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );

            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);
            $responseHistorial = $this->CasasModel->addHistorial($id, $proceso->proceso, $proceso->proceso,"Se da visto bueno | Comentario: ".$comentario, 1, $idCliente);
            if (!$update || !$responseHistorial) {
                http_response_code(400);
            }
        }
        if (in_array($this->idUsuario, [2896, 12072, 12112, 15900, 16208])) {
            $updateData = array(
                "pv"  => 1,
                "modificadoPor" => $this->session->userdata('id_usuario'),
                "fechaModificacion" => date("Y-m-d H:i:s"),
            );
            $update = $this->General_model->updateRecord("vobos_proceso_casas", $updateData, "idVobo", $vobo->idVobo);
            $responseHistorial = $this->CasasModel->addHistorial($id, $proceso->proceso, $proceso->proceso,"Se da visto bueno | Comentario: ".$comentario, 1, $idCliente);
            if (!$update || !$responseHistorial) {
                http_response_code(400);
            }
        }

        $vobosGet = $this->CasasModel->getVobos($id, 13);

        if ($vobosGet->adm == 1 && $vobosGet->ooam == 1 && $vobosGet->gph == 1 && $vobosGet->pv == 1) {
            // 1 es avance y 2 rechazo
            $bandera = 1;

            $new_status = $this->CasasModel->getPasos($id, $bandera)->avance;

            $documentos = $this->CasasModel->getDocumentos([33, 34, 35]);

            foreach ($documentos as $key => $documento) {
                $is_ok = $this->CasasModel->inserDocumentsToProceso($id, $documento->tipo, $documento->nombre);

                if (!$is_ok) {
                    break;
                }
            }

            //$proceso = $this->CasasModel->getProceso($id);

            $is_ok = $this->CasasModel->setProcesoTo($id, $new_status, $comentario, 0);

            if ($is_ok) {

                $insertVobo = $this->CasasModel->insertVobo($id, 14);

                if (!$insertVobo) {
                    http_response_code(404);
                }

                $this->CasasModel->addHistorial($id, $proceso->proceso, $new_status, "Se avanzó el proceso al paso 14.", 1, $idCliente);

                $this->json([]);
            } else {
                http_response_code(404);
            }
        }
    }

    public function delete_cotizacion()
    {
        $this->form();

        $idCotizacion = $this->form('idCotizacion');

        $updateData = array(
            "nombre" => '',
            "archivo" => NULL
        );

        $update = $this->General_model->updateRecord("cotizacion_proceso_casas", $updateData, "idCotizacion", $idCotizacion);

        if ($update) {
            $response["result"] = true;
            $response["message"] = "Se ha eliminado la cotización";
        } else {
            $response["result"] = false;
            $response["message"] = "Error al eliminar la cotización";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response));
    }

    public function removerBanderPaso12()
    {
        $form = $this->form();

        $idVobo = $form->idVobo;
        $update = $this->CasasModel->removerBanderaPaso12($idVobo);

        if ($update) {
            $response["result"] = true;
            $response["message"] = "";
        } else {
            $response["result"] = false;
            $response["message"] = "";
        }

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($update));
    }

    public function asignacionEsquema()
    {
        $this->load->view('template/header');
        $this->load->view("casas/asignacion_esquema");
    }

    public function options_esquema()
    {
        $esquema = $this->CasasModel->getEsquemaOptions()->result();

        $this->json($esquema);
    }

    public function options_modelo()
    {
        $modelo = $this->CasasModel->getModeloOptions()->result();
        $this->json($modelo);
    }

    public function to_asignacion_esquema()
    {
        $idLote = $this->form('idLote');
        $idCliente = $this->form('idCliente');
        $comentario = $this->form('comentario');
        $esquemaCredito = $this->form('esquemaCredito');
        $modeloCasa = $this->form('modeloCasa');
        $idUsuario = $this->session->userdata('id_usuario');
        $tabla = $esquemaCredito == 1 ? 'proceso_casas_banco' : 'proceso_casas_directo';
        $banderaSuccess = true;
        $idGerente = $this->form('idGerente');
        $idSubdirector = $this->form('idSubdirector');

        if (!isset($idLote) || !isset($idCliente) || !isset($esquemaCredito)) {
            http_response_code(400);
            $this->json([]);
        }

        $dataUpdate = array(
            "esquemaCreditoCasas" => $esquemaCredito,
            "id_asesor_c" => $idUsuario,
            "idPropuestaCasa" => $modeloCasa,
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );

        $procesoData = array(
            "idLote" => $idLote,
            "proceso" => 1,
            "comentario" => $comentario,
            "creadoPor" => $this->session->userdata('id_usuario'),
            "idCliente" => $idCliente
        );

        $this->db->trans_begin();

        $update = $this->General_model->updateRecord("clientes", $dataUpdate, "id_cliente", $idCliente);
        if (!$update) {
            $banderaSuccess = false;
        }
        $checkPreproceso = $this->CasasModel->checkPreproceso($idLote, $tabla, $idCliente);
        if ($checkPreproceso != null) {
            $idProcesoCasas = $checkPreproceso->idProcesoCasas ?? $checkPreproceso->idProceso;
            $update = $this->General_model->updateRecord($tabla, $procesoData, "idProcesoCasas", $idProcesoCasas);
            $insert = $checkPreproceso->idProcesoCasas ?? $checkPreproceso->idProceso;
        } else {
            $insert = $this->CasasModel->insertProceso($procesoData, $tabla); // valor del id de casas que se inserta en el momento
            if (!$insert) {
                $banderaSuccess = false;
            }
        }

        $dataHistorial = array(
            "idProcesoCasas" => $insert,
            "procesoAnterior" => 2,
            "procesoNuevo" => 1,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor" => $this->session->userdata('id_usuario'),
            "idMovimiento" => $this->session->userdata('id_usuario'),
            "descripcion" => "Pre proceso | se inicia proceso comentario: " . $comentario . " IDLOTE: $idLote",
            "esquemaCreditoProceso" => $esquemaCredito,
            "idCliente" => $idCliente
        );

        $insertHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if (!$insertHistorial) {
            $banderaSuccess = false;
        }

        if ($esquemaCredito == 1 && $checkPreproceso == null) {
            $documentoData = array(
                "idProcesoCasas" => $insert,
                "documento" => "Carta de autorización",
                "archivo" => NULL,
                "tipo" => 1,
                "creadoPor" => $idUsuario,
                "modificadoPor" => $idUsuario,
                "estatus" => 1,
                "idCliente" => $idCliente
            );

            $insertDocumento = $this->General_model->addRecord("documentos_proceso_casas", $documentoData);
            if (!$insertDocumento) {
                $banderaSuccess = false;
            }
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();

            $response["result"] = true;
            $response["message"] = "Se ha avanzado el proceso correctamente";
        } else {
            $this->db->trans_rollback();

            $response["result"] = false;
            $response["message"] = "No se puede avanzar el proceso";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output($this->json([]));
    }

    public function clienteAccion()
    {
        $nombre = $this->form('nombre');
        $paterno = $this->form('paterno');
        $materno = $this->form('materno');
        $telefono = $this->form('telefono');
        $correo = $this->form('correo');
        $domicilio = $this->form('domicilio');
        $estadoCivil = $this->form('estado_civil');
        $ocupacion = $this->form('ocupacion');
        $idLote = $this->form('idLote');
        $accion = $this->form('altaAccion');

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            $this->json(['El correo es inválido']);
        }

        $flagStatus = true;
        $this->db->trans_begin();
        //INSERT
        if ($accion == 1) {
            $insertArr = array(
                'nombre' => $nombre,
                'apellido_paterno' => $paterno,
                'apellido_materno' => $materno,
                'telefono1' => $telefono,
                'correo' => $correo,
                'domicilio_particular' => $domicilio,
                'estado_civil' => $estadoCivil,
                'ocupacion' => $ocupacion,
                'id_subdirector' => 0,
                'id_regional' => 0,
                'plan_comision' => 0,
                'regimen_fac' => 0,
                'cp_fac' => 0,
                'banderaEscrituracion' => 0,
                'proceso' => 0,
                'tipoLiberacion' => 0,
                'banderaComisionCl' => 0,
                'totalNeto2Cl' => 0,
                'total8P' => 0,
                'venta_extranjero' => 0,
                'tipoCancelacion' => 0,
                'estatusSeguro' => 0,
                'sedeRecepcion' => 0,
                'id_asesor_c' => 0,
                'id_gerente_c' => 0,
                'id_subdirector_c' => 0,
                'esquemaCreditoCasas' => 0,
                'idLote' => $idLote
            );

            $insertCliente = $this->General_model->addRecord("clientes", $insertArr);
            if (!$insertCliente) {
                $flagStatus = false;
            }
        }

        if ($accion == 2) {
            $idCliente = $this->form('idCliente');
            $dataUpdate = array(
                'nombre' => $nombre,
                'apellido_paterno' => $paterno,
                'apellido_materno' => $materno,
                'telefono1' => $telefono,
                'correo' => $correo,
                'domicilio_particular' => $domicilio,
                'estado_civil' => $estadoCivil,
                'ocupacion' => $ocupacion
            );
            $updateCliente = $this->General_model->updateRecord('clientes', $dataUpdate, 'id_cliente', $idCliente);
            if (!$updateCliente) {
                $flagStatus = false;
            }
        }

        if ($flagStatus) {
            $this->db->trans_commit();
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output($this->json([]));
    }

    public function modeloOptions()
    {
        $idModelo = $this->input->post('idModelo');
        $modeloData = $this->CasasModel->modeloOptions($idModelo)->result();
        $this->json($modeloData);
    }

    public function lista_tipo_proveedor()
    {
        $lotes = $this->CasasModel->getListaTipoProveedor();

        $this->json($lotes);
    }

    public function select_tipo_proveedor()
    {
        $idProcesoCasas = $this->form('idProcesoCasas');
        $tipoProveedor = $this->form('tipoProveedor');

        if (!isset($idProcesoCasas) || !isset($tipoProveedor)) {
            http_response_code(400);

            $this->json([]);
        }

        $is_ok = $this->CasasModel->selectTipoProveedor($idProcesoCasas, $tipoProveedor);

        if ($is_ok) {
            $this->CasasModel->insertDocumentosProveedor($idProcesoCasas, $tipoProveedor);
        }

        $this->json([]);
    }

    public function lista_documentos_proveedor($proceso)
    {
        $documentos = $this->CasasModel->getListaDocumentosProveedor($proceso, [26, 27]);

        $this->json($documentos);
    }

    public function lista_orden_compra_firma()
    {
        $lotes = $this->CasasModel->getListaOrdenCompraFirma();

        $this->json($lotes);
    }

    public function lista_documentos_cliente_directo($proceso)
    {
        $documentos = [];

        switch ($this->idRol) {
            case '12':
                $documentos = $this->CasasModel->getListaDocumentosClienteDirecto($proceso, [2]);
                break;
        }
        $this->json($documentos);
    }

    public function ingresar_adeudo_directo()
    {
    }

    public function lista_toda_documentacion_casas_banco(){
        $lote = $this->get('lote');

        if(!isset($lote)){
            return $this->json([]);
        }
        
        $documentos_proceso_casas = $this->CasasModel->getListaDocumentacionProcesoCasas($lote);
        $documentos_cotizaciones = $this->CasasModel->getListaDocumentacionCotizaciones($lote);

        $merged_documents = array_merge(
            $documentos_proceso_casas,
            $documentos_cotizaciones
        );

        usort($merged_documents, function($a, $b) {
            return $a->idProcesoCasas <=> $b->idProcesoCasas;
        });

        return $this->json($merged_documents);
    }

    public function lista_toda_documentacion_casas_directo(){ 
        $lote = $this->get('lote');

        if(!isset($lote)){
            return $this->json([]);
        }
        
        $documentos_proceso_casas_directo = $this->CasasModel->getListaDocumentacionProcesoCasasDirecto($lote);
        return $this->json($documentos_proceso_casas_directo);
    }
    public function lista_toda_documentacion_casas_pagos() {
        $lote = $this->get('lote');
        $extraColumns = "";

        if(!isset($lote)){
            return $this->json([]);
        }

        $documentos_proceso_pagos = $this->CasasModel->getListaDocumentacionProcesoPagos($lote, $extraColumns);
        $documentos_avances_pdf = $this->CasasModel->getListaDocumentacionAvancesComplementoPDF($lote, $extraColumns);
        $documentos_avances_xml = $this->CasasModel->getListaDocumentacionAvancesComplementoXML($lote, $extraColumns);

        $merged_documents = array_merge(
            $documentos_proceso_pagos,
            $documentos_avances_pdf, 
            $documentos_avances_xml
        );

        usort($merged_documents, function($a, $b) {
            return $a->idProcesoCasas <=> $b->idProcesoCasas;
        });

        return $this->json($merged_documents);
    }

    public function documentacion_clientes() {
        $idCliente = $this->get('idCliente');
        $valueTab = $this->get('valueTab');
        $tableName = '';
        $extraWhere = '';

        switch($valueTab) {
            case '1':
                $extraWhere = " AND (pcb.idProcesoCasas IS NOT NULL AND pcd.idProceso IS NULL) AND (pcb.estatus = 1)";
                break;
            case '2' :
                $extraWhere = " AND (pcd.idProceso IS NOT NULL AND pcb.idProcesoCasas IS NULL) AND (pcd.estatus = 1)";
                break;
            default: 
                break;
        }

        if(!isset($idCliente)) {
            return $this->json([]);
        }

        $documentos_cliente = $this->CasasModel->getListaDatosCliente($idCliente, $extraWhere);

        return $this->json($documentos_cliente);
    }

    public function actualizarPreProceso (){
        //CHECK THE VALUES 
        $idLote = $this->form('idLote');
        $idCliente = $this->form('idCliente');
        $comentario = $this->form('comentario');
        $esquemaCreditoActual = $this->form('esquemaCreditoActual');
        $esquemaCreditoNuevo = $this->form('esquemaCreditoNuevo');
        $tabla = $esquemaCreditoNuevo == 1 ? 'proceso_casas_banco' : 'proceso_casas_directo';
        $tablaActual = $esquemaCreditoActual == 1 ? 'proceso_casas_banco' : 'proceso_casas_directo';
        $modeloCasa = $this->form('modeloCasa');
        $idUsuario = $this->session->userdata('id_usuario');
        $banderaSuccess = true;
        $insert = '';

        if (!isset($idLote) || !isset($idCliente) || !isset($esquemaCreditoActual) || !isset($esquemaCreditoNuevo)) {
            http_response_code(400);
            $this->json([]);
        }

        $dataUpdate = array(
            "esquemaCreditoCasas" => $esquemaCreditoNuevo,
            "idPropuestaCasa" => $modeloCasa,
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );

        $procesoData = array(
            "idLote" => $idLote,
            "proceso" => 1,
            "tipoMovimiento" => 0,
            "comentario" => $comentario,
            "creadoPor" => $this->session->userdata('id_usuario')
        );

        $this->db->trans_begin();

        $update = $this->General_model->updateRecord("clientes", $dataUpdate, "id_cliente", $idCliente);

        if (!$update) {
            $banderaSuccess = false;
        }

        // cambia el esquema
        if($esquemaCreditoActual != $esquemaCreditoNuevo) {
            $dataEsquemaActual = array(
                'estatus' => 0
            );

            $checkPreproceso = $this->CasasModel->checkPreproceso($idLote, $tablaActual, $idCliente);
            if ($checkPreproceso != null) {
                $idProcesoCasas = $checkPreproceso->idProcesoCasas ?? $checkPreproceso->idProceso;
                // actualizar estatus de tabla actual
                $update = $this->General_model->updateRecord($tablaActual, $dataEsquemaActual, $esquemaCreditoActual == 1 ? "idProcesoCasas" : "idProceso", $idProcesoCasas);

                $checkPreprocesoNuevo = $this->CasasModel->checkPreproceso($idLote, $tabla, $idCliente);
                // si existe un registro en la tabla nueva solo lo actualizamos
                if($checkPreprocesoNuevo != null) {
                    $idProcesoCasas = $checkPreproceso->idProcesoCasas ?? $checkPreproceso->idProceso;
                    $update = $this->General_model->updateRecord($tabla, $procesoData, $esquemaCreditoActual == 1 ? "idProcesoCasas" : "idProceso", $idProcesoCasas);
                    $insert = $checkPreproceso->idProcesoCasas;
                } else { // si no existe lo creamos
                    $insert = $this->CasasModel->insertProceso($procesoData, $tabla); // valor del id de casas que se inserta en el momento
                    if (!$insert) {
                        $banderaSuccess = false;
                    }
                }
            }
        } else {
            // solo cambia otro campo, actualizamos registro exitente
            $checkPreproceso = $this->CasasModel->checkPreproceso($idLote, $tabla, $idCliente);
            if ($checkPreproceso != null) {
                $idProcesoCasas = $checkPreproceso->idProcesoCasas ?? $checkPreproceso->idProceso;
                $update = $this->General_model->updateRecord($tabla, $procesoData, $esquemaCreditoActual == 1 ? "idProcesoCasas" : "idProceso", $idProcesoCasas);
                $insert = $checkPreproceso->idProcesoCasas ?? $checkPreproceso->idProceso;
            }
        }

        $dataHistorial = array(
            "idProcesoCasas" => $insert,
            "procesoAnterior" => 2,
            "procesoNuevo" => 1,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor" => $this->session->userdata('id_usuario'),
            "idMovimiento" => $this->session->userdata('id_usuario'),
            "descripcion" => "Pre proceso | se inicia proceso comentario: " . $comentario . " IDLOTE: $idLote",
            "esquemaCreditoProceso" => $esquemaCreditoNuevo,
            "idCliente" => $idCliente
        );

        $insertHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);
        if (!$insertHistorial) {
            $banderaSuccess = false;
        }
        
        $checkPreproceso = $this->CasasModel->checkPreproceso($idLote, $tablaActual);
        if ($checkPreproceso != null) {
            $idProcesoCasas = $checkPreproceso->idProcesoCasas ?? $checkPreproceso->idProceso;
            $this->General_model->updateRecord('documentos_proceso_casas', array("estatus" => 0), 'idProcesoCasas', $idProcesoCasas);
        }

        if ($esquemaCreditoNuevo == 1) {
            $documentoData = array(
                "idProcesoCasas" => $insert,
                "documento" => "Carta de autorización",
                "archivo" => NULL,
                "tipo" => 1,
                "creadoPor" => $idUsuario,
                "modificadoPor" => $idUsuario,
                "estatus" => 1,
                "idCliente" => $idCliente
            );

            $checkDocumento = $this->CasasModel->checkDocument($insert);
            if ($checkDocumento == null) {
                $insertDocumento = $this->General_model->addRecord("documentos_proceso_casas", $documentoData);
                if (!$insertDocumento) {
                    $banderaSuccess = false;
                }
            } else {
                $this->Geneal_model->updateRecord('documentos_proceso_casas', $documentoData, 'idProcesoCasas', $documentoData->idProcesoCasas);
            }
        }

        if ($banderaSuccess) {
            $this->db->trans_commit();

            $response["result"] = true;
            $response["message"] = "Se ha avanzado el proceso correctamente";
        } else {
            $this->db->trans_rollback();

            $response["result"] = false;
            $response["message"] = "No se puede avanzar el proceso";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output($this->json([]));
    }

    public function documentacion_clientes_pago () {
        $lote = $this->get('lote');

        if(!isset($lote)) {
            return $this->json([]);
        }

        $documentos_clientes_pdf = $this->CasasModel->getDocumentacionPagosClientePDF($lote);
        $documentos_clientes_xml = $this->CasasModel->getDocumentacionPagosClienteXML($lote);

        $merged_documents = array_merge(
            $documentos_clientes_pdf, 
            $documentos_clientes_xml
        );

        usort($merged_documents, function($a, $b) {
            return $a->idProcesoCasas <=> $b->idProcesoCasas;
        });

        return $this->json($merged_documents);
    }

    public function getClientesPorLote($idLote) {
        if (!isset($idLote)) {
            $this->json([]);
        }

        $clientes = $this->CasasModel->getClientesPorLote($idLote);

        $this->json($clientes);
    }
}
