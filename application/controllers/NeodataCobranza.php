<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class NeodataCobranza extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('NeodataCobranza_model', 'General_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
    }

    public function index() {}

    public function getInformation() {
        $data = $this->NeodataCobranza_model->getInformation()->result_array();
        /*for ($i = 0; $i < count($data); $i++) { // CICLO PARA LIMPIAR EL ARREGLO QUE NOS TRAEMOS DE COBRANZA
            unset($data[$i]['id_cobranza'], $data[$i]['empresa'], $data[$i]['referencia']);
        }
        $response = $this->General_model->updateBatch("lotes", $data, "nombreLote");*/ // MJ: SE MANDA CORRER EL UPDATE BATCH
        $responseTruncate = $this->db->query("TRUNCATE TABLE [comentarios_administracion]");
        if ($responseTruncate) {
            $responseInsert = $this->General_model->insertBatch("comentarios_administracion", $data);
            echo json_encode($responseInsert);
        }
        else
            echo json_encode(false);
    }

}