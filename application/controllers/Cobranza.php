<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cobranza extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Cobranza_model','Contraloria_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
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

    public function masterCobranza() {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }

        $this->load->view('template/header');
        $this->load->view("cobranza/masterCobranza");
    }

    public function getInformation()
    {
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");       
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data['data'] = $this->Cobranza_model->getInformation($typeTransaction, $beginDate, $endDate, $where)->result_array();
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function sendRequestPayment(){
        $update_lotes_data = array(
            "registro_comision" => 2,
            "usuario" => $this->session->userdata('id_usuario')
        );
        $response = $this->Cobranza_model->updateRecord("lotes", $update_lotes_data, "idLote", $this->input->post("idLote")); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
        echo json_decode($response);
    }

    public function report_prospects(){
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $this->load->view('template/header');
        $this->load->view("cobranza/report_prospects");
    }
    public function getClientsByAsesor(){
        $asesor = $_POST['asesor'];
        $data['data'] =$this->Cobranza_model->getClientsByAsesor($asesor)->result_array();
        echo json_encode($data);
    }
    public function getDetails(){
        $id = $_POST['id'];
        $checks = $_POST['checks'];
        $fechaInicio = explode('/', $this->input->post("beginDate"));
        $fechaFin = explode('/', $this->input->post("endDate"));
        $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
        $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
        $sede = $_POST['sede'];
        $data =$this->Cobranza_model->getDetails($id, $checks, $beginDate, $endDate, $sede)->result_array();
        echo json_encode($data);
    }
    public function setControversy(){
        $idCliente = $_POST['idCliente'];
        $idLote = $_POST['idLote'];
        $controversy = $_POST['controversy'];
        $verify = $this->Cobranza_model->verificarControversia($idLote);
        if($verify == null){
            $data_insert =  array(
                'id_lote' => $idLote,
                'creado_por' => $this->session->userdata('id_usuario'),
                'tipo' => '3',
                "fecha_creacion" => date("Y-m-d H:i:s"),
                'comentario' => $controversy,
                'estatus' => 1,
                'id_cliente' => $idCliente
            );
            $this->Cobranza_model->insertControversia($data_insert);
            $json['resultado'] = TRUE;
            echo json_encode( $json );
        }
        else{
            $json['error'] = 'El lote ya ha sido registrado o no existe';
            echo json_encode($json);
        }
    }
    public function getAsesores(){
        echo json_encode($this->Cobranza_model->getAsesores()->result_array());
    }

    public function getSedes(){
        echo json_encode($this->Cobranza_model->getSedes()->result_array());
    }

    function addEvidenceToCobranza(){
        $comentario = ($this->input->post('comentario_0') != '' ? $this->input->post('comentario_0') : '');
        $id_cliente = $this->input->post('idCliente');
        $id_lote = $this->input->post('idLote');
        $id_sol = $this->input->post('id_sol');
        $id_rolAut = 32;

        $fileTmpPath = $_FILES['docArchivo1']['tmp_name'];
        $fileName = $_FILES['docArchivo1']['name'];
        $fileSize = $_FILES['docArchivo1']['size'];
        $fileType = $_FILES['docArchivo1']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        $data = [
            'idCliente' => $id_cliente,
            'idLote' => $id_lote,
            'id_sol' => $id_sol,
            'id_rolAut' => $id_rolAut,
            'estatus' => 2,
            'evidencia' => $newFileName,
            'comentario_autorizacion' => $comentario,
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "fecha_modificado" => date("Y-m-d H:i:s"),
            "estatus_particular" => 1
        ];


        $data_insert = $this->Cobranza_model->insertEvidencia($data);
        $last_id = $this->db->insert_id();
        $data_historial = [
            'id_evidencia' => $last_id,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus' => 2,
            'creado_por' => $this->session->userdata('id_usuario'),
            'evidencia' => $newFileName,
            'comentario_autorizacion' => $comentario
        ];
        $this->Cobranza_model->insertHistorialEvidencia($data_historial);
        if($data_insert){
            $uploadFileDir = './static/documentos/evidencia_mktd/';
            $dest_path = $uploadFileDir . $newFileName;
            move_uploaded_file($fileTmpPath, $dest_path);
            echo json_encode($data_insert);
        }
    }

    public function repordeLiberaciones()
    {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $this->load->view('template/header');
        $this->load->view("cobranza/reporteLiberaciones");
    }

    public function getReporteLiberaciones() {
        $data['data'] = $this->Cobranza_model->getReporteLiberaciones()->result_array();
        echo json_encode($data);
    }

    public function masterCobranzaHistorial() {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }

        $this->load->view('template/header');
        $this->load->view("cobranza/cobranza_reporte_master_historico");
    }

    public function informationMasterCobranzaHistorial() {
        $fechaInicio = explode('/', $this->input->post("beginDate"));
        $fechaFin = explode('/', $this->input->post("endDate"));
        $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
        $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
        $data['data'] = $this->Contraloria_model->getInformation($beginDate, $endDate)->result_array();
        $idLote = $this->input->post("idLote");
        $bandera = $this->input->post("bandera");
        if($bandera == 1) {
            $endDate = '';
            $beginDate = '';
        } else
            $idLote = '';
        $data['data'] = $this->Cobranza_model->informationMasterCobranzaHistorial($idLote, $beginDate, $endDate)->result_array();
        echo json_encode($data);
    }

    public function getComments($pago){
        echo json_encode($this->Cobranza_model->getComments($pago)->result_array());
    }
    
    public function reporteLotesPorComisionista() {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $this->load->view('template/header');
        $this->load->view("comisiones/reporteLotesPorComisionista_view");
    }

    public function getReporteLotesPorComisionista() {
        if (isset($_POST) && !empty($_POST)) {
            $beginDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("beginDate"))));
            $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("endDate"))));
            $comisionista = $this->input->post("comisionista");       
            $tipoUsuario = $this->input->post("tipoUsuario");
            $data['data'] = $this->Cobranza_model->getReporteLotesPorComisionista($beginDate, $endDate, $comisionista, $tipoUsuario)->result_array();
            echo json_encode($data);
        } else
            json_encode(array());
    }

    public function getOpcionesParaReporteComisionistas() {
        $seeAll = $this->input->post("seeAll");
        $condicionXUsuario = '';
        if ($seeAll == 0 ){
            $condicionXUsuario = 'AND us.id_usuario = '.$this->session->userdata('id_usuario');
        }
        echo json_encode($this->Cobranza_model->getOpcionesParaReporteComisionistas($condicionXUsuario)->result_array());
    }

    public function getDetalleVentasPorComisionista() {
        $comisionista = $this->input->post("comisionista");
        $ventasActivasPorRol = $this->Cobranza_model->getVentasActivasPorRol($comisionista)->result_array();
        if (count($ventasActivasPorRol) > 0) {
            for($i = 0; $i < count($ventasActivasPorRol); $i ++) {
                $ventasActivasPorRol[$i]['datos'] = $this->Cobranza_model->getVentasPorRolPorAnio($comisionista, $ventasActivasPorRol[$i]['columna'])->result_array();
            }
            echo json_encode($ventasActivasPorRol);
        }
        else
            echo json_encode(array());
    }

}
