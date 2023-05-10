<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Documentacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Documentacion_model', 'General_model', 'Registrolote_modelo'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
    }
    
    public function documentacion() {
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $datos["residencial"] = $this->Registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("documentacion/documentacion_view", $datos);
    }

    public function subirArchivo() {
        $file = $_FILES["uploadedDocument"];
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $idLote = $this->input->post('idLote');
        $idDocumento = $this->input->post('idDocumento');
        $tipoDocumento = $this->input->post('tipoDocumento');
        $documentName = "{$this->input->post('tituloDocumento')}.$fileExt";

        $folder = $this->getCarpetaDeArchivo($tipoDocumento);
        
        if ($tipoDocumento == 7) { // SE VA A SUBIR / REEMPLAZAR LA CORRIDA
            if ($fileExt == 'xlsx') {
                $this->actualizarRamaDeDocumento($file, $folder, $documentName, $idDocumento);
            } else {
                echo json_encode(3); // SE INTENTÓ SUBIR UN ARCHIVO DIFERENTE A UN .XLSX (CORRIDA)
            }
        } else { // SE VA A SUBIR EL EXPEDIENTE O EL CONTRATO
            $this->actualizarRamaDeDocumento($file, $folder, $documentName, $idDocumento);
        }
    }

    function actualizarRamaDeDocumento($file, string $folder, string $documentName, $idDocumento) {
        $movement = move_uploaded_file($file["tmp_name"], $folder . $documentName);
        $validateMovement = $movement == FALSE ? 0 : 1;

        if ($validateMovement == 1) {
            $updateDocumentData = array(
                "expediente" => $documentName,
                "modificado" => date('Y-m-d H:i:s'),
                "idUser" => $this->session->userdata('id_usuario')
            );

            $result = $this->General_model->updateRecord("historial_documento", $updateDocumentData, "idDocumento", $idDocumento);

            $response = ($result) ? 1 : 4;
            echo json_encode($response);
        } else {
            echo json_encode(2); // EL ARCHIVO NO SE PUDO MOVER
        }
    }

    public function eliminarArchivo() {
        $idDocumento = $this->input->post('idDocumento');
        $tipoDocumento = $this->input->post('tipoDocumento');
        $updateDocumentData = array(
            "expediente" => NULL,
            "modificado" => date('Y-m-d H:i:s'),
            "idUser" => $this->session->userdata('id_usuario')
        );

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
        $response = ($result) ? 1 : 2;

        echo json_encode($response);
        // FALTA ENVIAR EL CORREO CUANDO ES LA CORRIDA QUE SE ELIMINA
        // TODO: Se debe de incluir el envío del correo, está en producción
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
}
