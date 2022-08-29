<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Documentacion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Documentacion_model', 'General_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();
    }

    public function index()
    {
    }

    public function validateSession()
    {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "") {
            redirect(base_url() . "index.php/login");
        }
    }

    function mainDocumentTreeView()
    {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("documentacion/mainDocumentTreeView", $datos);
    }

    function mainDocumentTreeViewTest()
    {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("documentacion/mainDocumentTreeView_Test", $datos);
    }

    function getDocumentsInformation()
    {
        $idLote = $this->input->post("idLote");
        $data["owner"] = $this->Documentacion_model->getClientInformation($this->input->post("idLote"))->result_array();
        $depositoSeriedad = $this->Documentacion_model->getdp($idLote)->result_array();
        if (count($depositoSeriedad) <= 0) {
            $depositoSeriedad = $this->Documentacion_model->getdp_DS($idLote)->result_array();
        }
        $lead = $this->Documentacion_model->getLead($idLote)->result_array();
        $mktdEvidence = $this->Documentacion_model->getMktdEvidence($idLote)->result_array();
        $authorizations = $this->Documentacion_model->getAuthorizations($idLote)->result_array();
        $documentTree = $this->Documentacion_model->getDocumentTree($idLote)->result_array();

        if ($depositoSeriedad[0]["estatus_validacion"] == 2)
            $depositoSeriedad[0]["rejectReasons"] = $this->Documentacion_model->getRejectReasons($depositoSeriedad[0]["idDocumento"], $depositoSeriedad[0]["idLote"], 30)->result_array();


        if ($lead[0]["estatus_validacion"] == 2)
            $lead[0]["rejectReasons"] = $this->Documentacion_model->getRejectReasons($lead[0]["idDocumento"], $lead[0]["idLote"], 33)->result_array();

        if ($mktdEvidence[0]["estatus_validacion"] == 2)
            $mktdEvidence[0]["rejectReasons"] = $this->Documentacion_model->getRejectReasons($mktdEvidence[0]["idDocumento"], $mktdEvidence[0]["idLote"], 34)->result_array();

        if ($authorizations[0]["estatus_validacion"] == 2)
            $authorizations[0]["rejectReasons"] = $this->Documentacion_model->getRejectReasons($authorizations[0]["idDocumento"], $authorizations[0]["idLote"], 32)->result_array();

        for ($i = 0; $i < count($documentTree); $i++) {
            if ($documentTree[$i]["estatus_validacion"] == 2)
                $documentTree[$i]["rejectReasons"] = $this->Documentacion_model->getRejectReasons($documentTree[$i]["idDocumento"], $documentTree[$i]["idLote"], 0)->result_array();
        }

        $documentationRecords = array_merge(
            $depositoSeriedad,
            $lead,
            $mktdEvidence,
            $authorizations,
            $documentTree
        );
        $data["documentation"] = $documentationRecords;
        echo json_encode($data);
    }

    public function uploadFile()
    {
        $file = $_FILES["uploadedDocument"];
        $idLote = $this->input->post('idLote');
        $idDocumento = $this->input->post('idDocumento');
        $documentType = $this->input->post('documentType');
        $documentName = $this->Documentacion_model->generateFilename($idLote, $idDocumento)->row();
        $documentName = $documentName->fileName . '.' . substr(strrchr($_FILES["uploadedDocument"]["name"], '.'), 1);
        $folder = $this->getFolderFile($documentType);
        if ($documentType == 7) { // SE VA A SUBIR / REEMPLAZAR LA CORRIDA
            $fileExt = strtolower(substr($documentName, strrpos($documentName, '.') + 1));
            if ($fileExt == 'xlsx') {
                $this->updateDocumentBranch($file, $folder, $documentName, $idDocumento);
            } else {
                echo json_encode(3); // SE INTENTÓ SUBIR UN ARCHIVO DIFERENTE A UN .XLSX (CORRIDA)
            }
        } else { // SE VA A SUBIR EL EXPEDIENTE O EL CONTRATO
            $this->updateDocumentBranch($file, $folder, $documentName, $idDocumento);
        }
    }

    function getFolderFile($documentType)
    {
        if ($documentType == 7) $folder = "static/documentos/cliente/corrida/";
        else if ($documentType == 8) $folder = "static/documentos/cliente/contrato/";
        else $folder = "static/documentos/cliente/expediente/";
        return $folder;
    }

    function updateDocumentBranch($file, $folder, $documentName, $idDocumento)
    {
        $movement = move_uploaded_file($file["tmp_name"], $folder . $documentName);
        $validateMovement = $movement == FALSE ? 0 : 1;
        if ($validateMovement == 1) {
            $updateDocumentData = array(
                "expediente" => $documentName,
                "modificado" => date('Y-m-d H:i:s'),
                "idUser" => $this->session->userdata('id_usuario')
            );
            $response = $this->Documentacion_model->updateDocumentBranch($updateDocumentData, $idDocumento);
            echo json_encode($response);
        } else if ($validateMovement == 0) {
            echo json_encode(2); // EL ARCHIVO NO SE PUDO MOVER
        } else {
            echo json_encode(2); // EL ARCHIVO NO SE PUDO MOVER
        }
    }

    public function deleteFile()
    {
        $idDocumento = $this->input->post('idDocumento');
        $documentType = $this->input->post('documentType');
        $updateDocumentData = array(
            "expediente" => NULL,
            "modificado" => date('Y-m-d H:i:s'),
            "idUser" => $this->input->post('typeTransaction') == 2 ? $this->input->post('clientName') : $this->session->userdata('id_usuario')
        );
        $filename = $this->Documentacion_model->getFilename($idDocumento)->row()->expediente;
        $folder = $this->getFolderFile($documentType);
        $file = $folder . $filename;
        if (file_exists($file)) {
            unlink($file);
        }
        $response = $this->Documentacion_model->updateDocumentBranch($updateDocumentData, $idDocumento);
        echo json_encode($response);
        // FALTA ENVIAR EL CORREO CUANDO ES LA CORRIDA QUE SE ELIMINA
    }

    function getRejectionReasons()
    {
        $tipo_proceso = $this->input->post('tipo_proceso');
        $data = $this->Documentacion_model->getRejectionReasons($tipo_proceso);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function validateFile()
    {
        $idDocumento = $this->input->post('idDocumento');
        $idLote = $this->input->post('idLote');
        $documentType = $this->input->post('documentType');
        $action = $this->input->post('action');
        if ($action == 4) {
            $rejectionReasons = explode(",", $this->input->post('rejectionReasons'));
            for ($i = 0; $i < count($rejectionReasons); $i++) {
                $insertData[$i] = array(
                    "id_motivo" => $rejectionReasons[$i],
                    "id_documento" => $idDocumento,
                    "tipo" => $documentType,
                    "creado_por" => $this->session->userdata('id_usuario')
                );
            }
        }
        $rejectionReasonsList = $this->Documentacion_model->getRejectReasons($idDocumento, $idLote, $documentType)->result_array();
        if (count($rejectionReasonsList) >= 1) { // SÍ ENCONTRÓ REGISTROS
            for ($r = 0; $r < count($rejectionReasonsList); $r++) {
                $updateArrayData[] = array(
                    'id_mrxdoc' => $rejectionReasonsList[$r]["id_mrxdoc"],
                    'estatus' => 0
                );
            }
            //echo json_encode($updateArrayData);
            //exit;
            $this->db->update_batch("motivos_rechazo_x_documento", $updateArrayData, "id_mrxdoc");
        }
        $updateData = array("estatus_validacion" => $action == 4 ? 2 : 1, "validado_por" => $this->session->userdata('id_usuario'));
        if ($documentType == 30) { //  DEPÓSITO DE SERIEDAD
            $table = "deposito_seriedad";
            $key = "id";
        } else if ($documentType == 31) { // DEPÓSITO DE SERIEDAD OLD VERSION
            $table = "deposito_seriedad_consulta";
            $key = "id";
        } else if ($documentType == 32) { // AUTORIZACIONES
            $table = "autorizaciones";
            $key = "id_autorizacion";
        } else if ($documentType == 33) { // PROSPECTOS
            $table = "prospectos";
            $key = "id_prospecto";
        } else if ($documentType == 34) { // EVIDENCIA
            $table = "evidencia_cliente";
            $key = "id_evidencia";
        } else { // HISTORIA DOCUMENTO
            $table = "historial_documento";
            $key = "idDocumento";
        }
        $updateResponse = $this->General_model->updateRecord($table, $updateData, $key, $idDocumento); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
        if ($action == 4) {
            $insertResponse = $this->Documentacion_model->saveRejectionReasons($insertData);
            echo json_encode(($updateResponse == 1 && $insertResponse == 1) == TRUE ? 1 : 0);
        } else {
            echo json_encode($updateResponse == 1 ? 1 : 0);
        }
    }

    function reasonsForRejectionByDocument()
    {
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("documentacion/reasonsForRejectionByDocument", $datos);
    }

    function getReasonsForRejectionByDocument()
    {
        if ($this->input->post("id_documento") == '' || $this->input->post("tipo_proceso") == '')
            echo json_encode(array());
        else {
            $data['data'] = $this->Documentacion_model->getReasonsForRejectionByDocument($this->input->post("id_documento"), $this->input->post('tipo_proceso'))->result_array();
            if ($data != null)
                echo json_encode($data);
            else
                echo json_encode(array());
        }
    }

    function saveRejectReason()
    {
        if($this->input->post("action") == '' || $this->input->post("reject_reason") == '')
            echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."));
        else {
            if ($this->input->post("action") == 0) {
                if ($this->input->post("id_documento") == '')
                    echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."));
                else {
                    $insertData = array(
                        "tipo_documento" => $this->input->post("id_documento"),
                        "motivo" => $this->input->post("reject_reason"),
                        "estatus" => 1,
                        "tipo_proceso" => 2,
                        "creado_por" => $this->session->userdata('id_usuario'),
                        "fecha_creacion" => date('Y-m-d H:i:s'),
                        "modificado_por" => $this->session->userdata('id_usuario'),
                        "fecha_modificacion" => date('Y-m-d H:i:s')
                    );
                    $response = $this->General_model->addRecord("motivos_rechazo", $insertData);
                    if ($response)
                        echo json_encode(array("status" => 200, "message" => "El registro se ha ingresado de manera exitosa."));
                    else
                        echo json_encode(array("status" => 500, "message" => "Oops, algo salió mal. Inténtalo más tarde."));
                }
            } else {
                if ($this->input->post("id_motivo") == '')
                    echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."));
                else {
                    $updateData = array(
                        "motivo" => $this->input->post("reject_reason"),
                        "modificado_por" => $this->session->userdata('id_usuario'),
                        "fecha_modificacion" => date('Y-m-d H:i:s')
                    );
                    $response = $this->General_model->updateRecord("motivos_rechazo", $updateData, "id_motivo", $this->input->post("id_motivo"));
                    if ($response)
                        echo json_encode(array("status" => 200, "message" => "El registro se ha actualizado de manera exitosa."));
                    else
                        echo json_encode(array("status" => 500, "message" => "Oops, algo salió mal. Inténtalo más tarde."));
                }
            }
        }
    }

    function changeStatus()
    {
        if ($this->input->post("action") == '' || $this->input->post("id_motivo") == '')
            echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."));
        else {
            $updateData = array(
                "estatus" => $this->input->post("action") == 2 ? 0 : 1,
                "modificado_por" => $this->session->userdata('id_usuario'),
                "fecha_modificacion" => date('Y-m-d H:i:s')
            );
            $response = $this->General_model->updateRecord("motivos_rechazo", $updateData, "id_motivo", $this->input->post("id_motivo"));
            if ($response)
                echo json_encode(array("status" => 200, "message" => "El registro se ha actualizado de manera exitosa."));
            else
                echo json_encode(array("status" => 500, "message" => "Oops, algo salió mal. Inténtalo más tarde."));
        }
    }

    function getDocumentsInformation_Escrituracion(){
        $idLote = $this->input->post("idLote");
        $data = $this->Documentacion_model->getDocumentsInformation_Escrituracion($idLote)->result_array();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    function getLotesList_escrituracion()
    {
        $idCondominio = $this->input->post("idCondominio");
        $data = $this->Documentacion_model->getLotesList_escrituracion($idCondominio)->result_array();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }
}
