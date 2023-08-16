<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Documentacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Documentacion_model', 'General_model', 'Registrolote_modelo'));
        $this->load->library(array('session', 'form_validation', 'get_menu', 'email','permisos_sidebar'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        date_default_timezone_set('America/Mexico_City');

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }
    
    public function documentacion() {
        $datos = [
            'residencial' => $this->Registrolote_modelo->getResidencialQro(),
            'tieneAcciones' => 1,
            'tipoFiltro' => null
        ];

        $this->load->view('template/header');
        $this->load->view("documentacion/documentacion_view", $datos);
    }

    public function subirArchivo() {
        $lote = $this->Registrolote_modelo->getNameLote($this->input->post('idLote'));

        if ($lote->observacionContratoUrgente && intval($lote->observacionContratoUrgente) === 1) {
            echo json_encode(['code' => 400, 'message' => 'El registro se encuentra en proceso de liberación.']);
            return;
        }

        $file = $_FILES["uploadedDocument"];
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $idDocumento = $this->input->post('idDocumento');
        $tipoDocumento = $this->input->post('tipoDocumento');
        $documentName = "{$this->input->post('tituloDocumento')}.$fileExt";

        $folder = $this->getCarpetaDeArchivo($tipoDocumento);

        if ($tipoDocumento != 7) { // SE VA A SUBIR EL EXPEDIENTE O EL CONTRATO
            $res = $this->actualizarRamaDeDocumento($file, $folder, $documentName, $idDocumento);
            echo json_encode($res);
            return;
        }

        // SE VA A SUBIR / REEMPLAZAR LA CORRIDA
        if ($fileExt != 'xlsx') {
            // SE INTENTÓ SUBIR UN ARCHIVO DIFERENTE A UN .XLSX (CORRIDA)
            echo json_encode(['code' => 400, 'message' => 'El archivo que se intenta subir no cuenta con la extención .xlsx']);
            return;
        }

        $res = $this->actualizarRamaDeDocumento($file, $folder, $documentName, $idDocumento);
        echo json_encode($res);
    }

    function actualizarRamaDeDocumento($file, string $folder, string $documentName, $idDocumento): array {
        $movement = move_uploaded_file($file["tmp_name"], $folder . $documentName);

        if ($movement) {
            $updateDocumentData = array(
                "expediente" => $documentName,
                "modificado" => date('Y-m-d H:i:s'),
                "idUser" => $this->session->userdata('id_usuario')
            );

            $result = $this->General_model->updateRecord("historial_documento", $updateDocumentData, "idDocumento", $idDocumento);

            return ($result)
                ? ['code' => 200]
                : ['code' => 500];
        }

        return ['code' => 400, 'message' => 'No fue posible almacenar el archivo en el servidor.'];
    }

    public function eliminarArchivo() {
        $idDocumento = $this->input->post('idDocumento');
        $tipoDocumento = $this->input->post('tipoDocumento');
        $updateDocumentData = array(
            "expediente" => NULL,
            "modificado" => date('Y-m-d H:i:s'),
            "idUser" => $this->session->userdata('id_usuario')
        );

        $nombreExp = $this->Registrolote_modelo->getNomExp($idDocumento);
        $infoLote = $this->Registrolote_modelo->getNameLote($nombreExp->idLote);

        if ($infoLote->observacionContratoUrgente && intval($infoLote->observacionContratoUrgente) === 1) {
            echo json_encode(['code' => 400, 'message' => 'El registro se encuentra en proceso de liberación.']);
            return;
        }

        $filename = $this->Documentacion_model
            ->getFilename($idDocumento)
            ->row()
            ->expediente;
        $folder = $this->getCarpetaDeArchivo($tipoDocumento);
        $file = $folder . $filename;

        if (file_exists($file)) {
            unlink($file);
        }

        $result = $this->General_model->updateRecord("historial_documento", $updateDocumentData, "idDocumento", $idDocumento);
        $response = ($result) ? ['code' => 200] : ['code' => 500];

        if (intval($tipoDocumento) !== 7) { // El tipo de documento es CORRIDA
            echo json_encode($response);
            return;
        }

        $validaMail = $this->Registrolote_modelo->sendMailAdmin($nombreExp->idLote);

        if (is_null($validaMail->idHistorialLote)) {
            echo json_encode($response);
            return;
        }

        $contenido[0] = [
            'nombreResidencial' => $infoLote->nombreResidencial,
            'nombre' => $infoLote->nombre,
            'nombreLote' => $infoLote->nombreLote,
            'observacion' => 'SE MODIFICÓ CORRIDA FINANCIERA',
            'fechaHora' => date('Y-m-d H:i:s')
        ];

        $this->email
            ->initialize()
            ->from('Ciudad Maderas')
            ->to('tester.ti2@ciudadmaderas.com')
            /*->to('coord.administrativoslp@ciudadmaderas.com',
                'coord.administrativo@ciudadmaderas.com',
                'coord.administrativo1@ciudadmaderas.com',
                'coord.administrativo2@ciudadmaderas.com',
                'coord.administrativo3@ciudadmaderas.com',
                'karen.pina@ciudadmaderas.com',
                'coord.administrativo4@ciudadmaderas.com',
                'coord.administrativo5@ciudadmaderas.com',
                'coord.administrativo7@ciudadmaderas.com',
                'asistente.admon@ciudadmaderas.com')*/
            ->subject('MODIFICACIÓN DE CORRIDA FINANCIERA')
            ->view($this->load->view('template/mail/componentes/tabla', [
                'encabezados' => [
                    'nombreResidencial' => 'PROYECTO',
                    'nombre' => 'CONDOMINIO',
                    'nombreLote' => 'LOTE',
                    'observacion' => 'OBSERVACIÓN',
                    'fechaHora' => 'FECHA/HORA'
                ],
                'contenido' => $contenido
            ], true));

            $this->email->send();

        echo json_encode($response);
    }

    private function getCarpetaDeArchivo($tipoDocumento): string {
        if ($tipoDocumento == 7) { // CORRIDA FINANCIERA: CONTRALORÍA
            return 'static/documentos/cliente/corrida/';
        }

        if ($tipoDocumento == 8) { // CONTRATO: JURÍDICO
            return 'static/documentos/cliente/contrato/';
        }

        if ($tipoDocumento == 30) { // CONTRATO FIRMADO: CONTRALORÍA
            return 'static/documentos/cliente/contratoFirmado/';
        }

        // EL RESTO DE DOCUMENTOS SE GUARDAN EN LA CARPETA DE EXPEDIENTES
        return 'static/documentos/cliente/expediente/';
    }

    function reasonsForRejectionByDocument() {
        $this->load->view('template/header');
        $this->load->view("documentacion/reasonsForRejectionByDocument");
    }

    function getReasonsForRejectionByDocument() {
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

    function saveRejectReason() {
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
                        "tipo_proceso" =>$this->input->post("id_documento") == 0 ? 3 :  2,
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

    function changeStatus() {
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

    function getDocumentsInformation_Escrituracion() {
        $idLote = $this->input->post("idLote");
        $data = $this->Documentacion_model->getDocumentsInformation_Escrituracion($idLote)->result_array();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    function getLotesList_escrituracion() {
        $idCondominio = $this->input->post("idCondominio");
        $data = $this->Documentacion_model->getLotesList_escrituracion($idCondominio)->result_array();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getCatalogOptions() {
        
            echo json_encode($this->Documentacion_model->getCatalogOptions()->result_array());
    }

    function getRejectionReasons() {
        $tipo_proceso = $this->input->post('tipo_proceso');
        $data = $this->Documentacion_model->getRejectionReasons($tipo_proceso);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function documentacionPorClienteLote() {
        $datos = [
            'residencial' => $this->Registrolote_modelo->getResidencialQro(),
            'tieneAcciones' => 0,
            'tipoFiltro' => 1
        ];

        $this->load->view('template/header');
        $this->load->view("documentacion/documentacion_view", $datos);
    }

    public function getLotesAll($condominio, $residencial) {
        $datos = array();
        $data = $this->Registrolote_modelo->getLotesGral($condominio, $residencial);
        echo json_encode($data);
    }
    
    public function getClientesPorLote($idLote) {
        $datos = array();
        $datos = $this->Documentacion_model->getClientesPorLote($idLote);
        echo json_encode($datos);
    }

    public function deleteFile(){
        $idDocumento = $this->input->post('idDocumento');
        $documentType = $this->input->post('documentType');
        $updateDocumentData = array(
        "expediente" => NULL,
        "modificado" => date('Y-m-d H:i:s'),
        "idUser" => $this->input->post('typeTransaction') == 2 ? $this->input->post('clientName') : $this->session->userdata('id_usuario')
        );
        $filename = $this->Documentacion_model->getFilename($idDocumento)->row()->expediente;
        $folder = $this->getCarpetaDeArchivo($documentType);
        $file = $folder . $filename;
        if (file_exists($file)) {
            unlink($file);
        }
        $response = $this->General_model->updateRecord('historial_documento',$updateDocumentData, 'idDocumento', $idDocumento);
        echo $response;
        echo json_encode($response);
    }

    public function uploadFile(){
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

    function updateDocumentBranch($file, $folder, $documentName, $idDocumento){
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
}


